<?
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');
include ('inc/ggValidate.php');

$debug = false;

$req = ($debug)? $_GET:$_POST;

$setup->maxaccount 	= 16;
$setup->maxphone 		= 16;
$setup->username_len = 4;
$setup->phone_len 	= 11;

$username 		= htmlentities($req['username']);
$email 				= $req['email'];
$fullname 		= $req['fullname'];
$password 		= $req['password'];
$repassword 	= $req['repassword'];

$password2 		= $req['password2'];
$phone 				= $req['phone'];
$referral 		= $req['sponsor'];

$country 			= $req['country'];
$pin 					= $req['pin'];
$password2_5 	= md5($req['password2']);
$agree        = $req['agree'];

$ls = new stdClass();
$ls->username_req = array("Username can not be blank","登入账号不能为空","登入帳號不能為空");
$ls->username_min = array("Username must be $setup->username_len characters and above", "登入账号不合格（".$setup->username_len."-20位字符、数字组合）","登入帳號不合格（".$setup->username_len."-20位字符，數字組合）");
$ls->username_regexp = array("Username accept only alphabets, numbers and '-' sign, eg. abc-001", "登入账号不合格 - 只接受英文字母, 数字和 '-' 例如：abc-001","登入帳號不合格 只接受英文字母,數字和 '-' 例如：abc-001");
$ls->username_dupe = array("Username already exist in system", "您输入的登入账号已存在", "您輸入的登入账号已存在");

$ls->email_req		= array("Email can not be blank","邮箱不能为空","郵箱不能為空");
$ls->email_regexp	= array("Invalid email format","邮箱格式不对","郵箱格式不對");
$ls->phone_num    = array("Phone No only accept numbers", "手机号码不合规格","手機號碼不合規格");
$ls->phone_min    = array("Phone No must be $setup->phone_len characters", "手机号码必须是 $setup->phone_len 个数字","手機號碼必須是 $setup->phone_len 個數字");
$ls->phone_max    = array("Phone No can only register ".$setup->maxaccount." accounts", "手机号码只能注册".$setup->maxaccount."个账户","手机号码只能注册".$setup->maxaccount."个账户");

$ls->password_req = array("Password can not be blank", "密码不能为空","密碼不能為空");
$ls->password_min = array("Password must be $setup->password_len characters and above", "密码必须 $setup->password_len 个字符以上","密碼必須 $setup->password_len 個字符以上");
$ls->password_eq  = array("Password and confirm not match", "确认密码不匹配","確認密碼不匹配");
$ls->password2_req = array("Second Password can not be blank", "二级密码不能为空","二級密碼不能為空");
$ls->password2_min = array("Second Password must be $setup->password_min characters and above", "二级密码必须 $setup->password_min 个字符以上","二級密碼必須 $setup->password_min 個字符以上");
$ls->password2_match  = array("Invalid Second Password", "二级密码错误","二級密碼错误");

$ls->country_e1 = array("[Country] Please nominate your country", "【国家】 请选择国家","【國家】 請選擇國家");
$ls->referral_req = array("Sponsor can not be blank", "【推荐人账号】 不能為空","【推薦人賬號】 不能為空");
$ls->referral_eq = array("Sponsor does not exist", "【推荐人账号】 找不到这个推荐人账号","【推薦人賬號】 找不到這個推薦人賬號");
$ls->fullname_req = array("Fullname can not be blank","真实姓名不能为空","真實姓名不能為空");
$ls->phone_regexp = array("Invalid phone number", "手机号码不合規格","手機號碼不合規格");
$ls->phone_req    = array("Phone number can not be blank", "手机号码不能为空","手機號碼不能為空");
$ls->phonecode_regexp = array("Invalid Phone validation code", "短信验证码错误","短信验证码错误");
$ls->pin_req      = array("Register PIN can not be blank", "激活码不能为空","激活碼不能為空");
$ls->pin_eq       = array("Invalid Register PIN", "激活码无效","激活碼無效");
$ls->agree_chk		= array("You must thick agree to proceed","请勾选了解规条","請勾選了解規條");

$username_c = ggFetchValue("select count(username) from tblmember where username='$username'");
$referral_c = ggFetchValue("select count(id) from tblmember where username='$referral'");
$pin_c = ggFetchValue("select pin from tblpin where managerid=$user->id and status='N' and pin='$pin'");

/*
if ($pin=="") {
	$pin = ggFetchValue("select pin from tblpin where managerid=$user->id and status='N'");
} else {
	$pin = ggFetchValue("select pin from tblpin where managerid=$user->id and status='N' and pin='$pin'");
}
*/

if (!isset($req['username'])) {
	echo json_encode(array("status"=>"fail","msg"=>"Invalid Action"));
	exit;
}

$v = new FormValidator();
$v->addValidation(1,$username,"req",$ls->username_req[$lang]);
$v->addValidation(2,$username,"minlen=4",$ls->username_min[$lang]);
$v->addValidation(3,$username,"regexp=/^[A-Za-z0-9-]*$/",$ls->username_regexp[$lang]);
$v->addValidation(4,$username_c,"lt=1",$ls->username_dupe[$lang]);

$v->addValidation(5,$email,"req",$ls->email_req[$lang]);
$v->addValidation(6,$email,"email",$ls->email_regexp[$lang]);

$v->addValidation(7,$phone,"req",$ls->phone_req[$lang]);
//$v->addValidation(8,$phone,"regexp=/^[1][3-9][0-9]{9}$/",$ls->phone_regexp[$lang]);
$v->addValidation(9,$pcount,"lt=1",$ls->phone_max[$lang]);

$v->addValidation(9,$password,"req",$ls->password_req[$lang]);
$v->addValidation(10,$password,"minlen=".$setup->password_len,$ls->password_min[$lang]);
$v->addValidation(11,$password,"eqelmnt=repassword",$ls->password_eq[$lang]);
/* GG confirm 2nd pass
	$v->addValidation(9,$password2,"minlen=".$setup->password_min,$ls->password2_min[$lang]);
	$v->addValidation(10,$password2,"eqelmnt=repassword2",$ls->password2_eq[$lang]. "$password2 $repassword2");
*/
$v->addValidation(12,$referral,"req",$ls->referral_req[$lang]);
$v->addValidation(13,$referral_c,"eq=1",$ls->referral_eq[$lang]);
//$v->addValidation(9,$phone,"minlen=8",$ls->phone_min[$lang]);
//$v->addValidation(15,$fullname,"req",$ls->fullname_req[$lang]);
//$v->addValidation(16,$phonecode,"eq=123456",$ls->phonecode_err[$lang]);
if (isset($req['pin'])) {
	// If require pin thwn need 2nd password check
	$v->addValidation(14,$pin,"req",$ls->pin_req[$lang]);
	$v->addValidation(15,$pin,"eq=".$pin_c,$ls->pin_eq[$lang]);
	$v->addValidation(16,$password2_5,"eq=".$user->password2,$ls->password2_match[$lang]);
}
$v->addValidation(17,$agree,"shouldselchk=1",$ls->agree_chk[$lang]);

//$v->addValidation($pin,"req",$ls->pin_req[$lang]);
//$v->addValidation("verifyCode","eq=".$_SESSION['captcha_code'],"验证码错误");

if (!$v->ValidateForm()) {
  $ret = array("status"=>"fail", "msg"=>$v->getError());
} else {
	$msg = ggAddMember($email,$username,$fullname,$phone,$referral,$password,$pin,$country,$password2_5);
	if ($msg=="") {
		$ret = array('status'=>"success", 'msg'=>'操作成功','username'=>$username);
	} else {
  	$ret = array("status"=>"fail", "msg"=>$msg);
	}
}
echo json_encode($ret);

function ggAddMember($email,$username,$fullname,$phone,$referral,$password,$pin,$country,$password2_5) {
	global $db,$user,$ls,$lang;
	$msg = "";

	if (mysqli_num_rows($db->query("select id from tblmember where username='$username'"))>0) {
		$msg .= "<br>".$ls->username_dupe[$lang];
	} else if ($pin<>"" and mysqli_num_rows($db->query("select id from tblmember where id=$user->id and password2<>'' and password2='$password2_5'"))==0) {
		$msg .= "<br>".$ls->password2_match[$lang];
	} else if ($pin<>"" and mysqli_num_rows($db->query("select id from tblpin where managerid=$user->id and status='N' and pin='$pin'"))==0) {
		$msg .= "<br>".$ls->pin_eq[$lang];
	} else {
		$ref = ggFetchObject("select id,rank,username from tblmember where username='$referral'");
		if ($ref=="") {
			$msg .= "<br>".$ls->referral_eq[$lang];
		} else {
			$ref_id = $ref->id;
			$ref_name = $ref->username;

			$username = $username;
			//$password = generatePassword(8);
			$password5 = md5($password);

			// Default to Manager if register by Senior Manager and above
	    $mgr_id = $user->id;
	    $mgr_name = $user->username;
			$rs = $db->query("INSERT INTO tblmember (id,email,username, fullname, password,phone,referral,manager,ref_name, mgr_name,date_add,rank,country,status,pin)
				VALUES (NULL ,'$email','$username','$fullname','$password5','$phone',$ref_id,$mgr_id,'$ref_name','$mgr_name',NOW(),1,'$country', 'A','$pin')") or die("err ".$db->error);
			$nid = $db->insert_id;
			$nuser = load_user($nid);
			if ($pin<>"") {
				$rs1 = $db->query("update tblpin set useby = '$nuser->username',usedate=NOW(), status='U' where managerid=$mgr_id and status='N' and pin = '$pin'");
			}
			ggRegister1($nid,$username);
			ggAccessLog1($user->username,"NEW","$nid $username $email $country $ref_id $mgr_id");

			//send_welcome($email,$fullname,$password,'en');
		}
	}
	return $msg;
}

?>