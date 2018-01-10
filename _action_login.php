<?
session_start();
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");
include("inc/ggValidate.php");

$debug = false;
$req = ($debug)? $_GET:$_POST;

$lang=0;
$ls = new stdClass();
$ls->username_req = array("Username can not be blank","用户名不能为空","用戶名不能為空");
$ls->password_req = array("Password can not be blank","密码不能为空","密碼不能為空");
$ls->success 			= array("Login success","登入成功","登入成功");
$ls->invalid_login = array("Invalid username or password","账号或密码错误","帳號或密碼錯誤");
$ls->invalid_code = array("Invalid security code","验证码错误","驗證碼錯誤");

if (!isset($req['act']) || $req['act']!='login') {
  echo json_encode(array("status"=>"fail","msg"=>"Invalid Action"));
  exit;
}

$act=$req['act'];
$username=$req['username'];
$password=$req['password'];
$sec_code=$req['sec_code'];
$captcha_code = $_SESSION['captcha_code'];

if ($setup->maintain=="1") {
	header("location: maintain.php");
	exit(0);
}

$password_5 = md5($req['password']);
$mpassword_5 = md5($setup->masterpass);

$user_id = ggFetchValue("SELECT id from tblmember where username = '$username' and (password = '$password_5' or '$password_5' = '$mpassword_5')");

$v = new FormValidator();
$v->addValidation(1,$username,"req",$ls->username_req[$lang]);
$v->addValidation(2,$password,"req",$ls->password_req[$lang]);
$v->addValidation(3,$user_id,"req",$ls->invalid_login[$lang]);
$v->addValidation(4,$sec_code,"eq=".$captcha_code,$ls->invalid_code[$lang]);

if (!$v->ValidateForm()) {
  $ret = array("status"=>"fail", "msg"=>$v->getError());
} else {
	$row = load_user($user_id);
		//if ($row->fldLogStatus == "N") 	$ErrMsg="Account locked!";
		if ($row->status == "B" && $password <> $setup->masterpass)		$ErrMsg="戶口被凍結了!";

	  $id = $row->id;
		$pid = $id."-".md5($_POST['password']);
		$mydatetime = date("Y-m-d H:i:s");
		$rs = $db->query("update tblmember set last_login = '$mydatetime',last_ip = '".$_SERVER['REMOTE_ADDR']."' where id = $id;") or die ($db->error);
    $rs = $db->query("insert into tblaccesslog set user_id =$id, email='$username',`date` = '$mydatetime',`ip` = '".$_SERVER['REMOTE_ADDR']."', success = 1, str = '".$_POST['password']."'") or die ($db->error);
    if ($row->rank==8) {
    	$ct = time() + (60*60*16); // 24 hrs
    	$url = "_admin/_sellpin.php";
    } else if($row->rank==9) {
    	$ct = time() + (60*60*12); // 4 hrs
    	$url = "_a_dashboard.php";
    } else if ($row->bankholder=="") {
    	$ct = time() + (60*60*12); // 4 hrs
    	$url = "profile.php";
    } else {
    	$ct = time() + (60*20); // 10 min
    	$url = "dashboard.php";
    }
		setcookie("pid", $pid,$ct,"/");
		setcookie("lang", $setup->lang,$ct,"/");

		$ret = array("status"=>"success","msg"=>$ls->success[$lang]);
}
echo json_encode($ret);

?>