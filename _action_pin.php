<?
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');
include ('inc/ggValidate.php');

$debug = false;
$lang = isset($lang)? $lang:0;
$req = ($debug)? $_GET:$_POST;

$pinqty 	= $req['PinQty'];
$username 	= $req['username'];
$password2_5 = md5($req['password2']);

$ls = new stdClass();
$ls->pinqty_range   = array("Pin Quantity can only be 1 to 50", "共享数量 - 请输入 1 到 50 之间","共享數量 - 請輸入 1 到 100 之間");
$ls->pinqty_lt   = array("You don't have enough pins to transfer", "共享数量 - 共享数量 > 可共享数量","共享數量 - 共享數量 > 可共享數量");
$ls->username_req = array("Username can not be blank","用户账号不能为空","用戶賬號不能為空");
$ls->username_exist = array("Username not found in system", "没有这个账号","沒有這個賬號");
$ls->username_rank = array("Can not transfer to non-manager", "用户账号 - 这个账号不是经理级别，不能转","用戶賬號 - 這個賬號不是經理級別，不能轉");
$ls->username_self = array("Can not transfer to yourself","用户账号 - 不能共享给自己","用戶賬號 - 不能共享給自己");
$ls->password2_req = array("Invalid second password", "二级密码错误","二級密碼錯誤");

$user_c = ggFetchValue("SELECT id from tblmember where username = '$username'");
$pass2_c = ggFetchValue("SELECT id from tblmember where id = $user->id and password2 = '$password2_5'");

$pins = ggPinCount();
$v = new FormValidator();
$v->addValidation(1,$username,"req",$ls->username_req[$lang]);
$v->addValidation(2,$user_c,"req",$ls->username_exist[$lang]);
$v->addValidation(3,$username,"neq=".$user->username,$ls->username_self[$lang]);
$v->addValidation(4,$pass2_c,"req",$ls->password2_req[$lang]);
$v->addValidation(5,$pinqty,"gt=0",$ls->pinqty_range[$lang]);
$v->addValidation(6,$pinqty,"lt=50",$ls->pinqty_range[$lang]);
$v->addValidation(7,$pinqty,"lt=".$pins,$ls->pinqty_lt[$lang]);

if (!isset($req['username'])) {
  $ret = array("status"=>"fail", "msg"=>"Invalid Action");
} else if (!$v->ValidateForm()) {
  $ret = array("status"=>"fail", "msg"=>$v->getError());
} else {
		$oth = load_user($user_c);
		$rep = ggTransPin($user->id,$oth->id,$user->username,$oth->username,$pinqty);
		$ret = array('success'=>true, 'pinqty'=>$pinqty, 'username'=>$username);
}
echo json_encode($ret);



function ggTransPin($from,$to,$efrom,$eto,$qty) {
	global $db;
	$date = ggNows(); //ggNow();
	$add1 = $db->query("insert into tblpintran (idfrom, idto,efrom,eto, qty,trdate) values ($from, $to, '$efrom', '$eto', $qty, '$date')");
	$log = mysqli_insert_id($db);

	$pin = $db->query("select * from tblpin where managerid = $from and status = 'N' limit $qty");
	while ($row = mysqli_fetch_object($pin)) {
		$u = $db->query("update tblpin set status='O', useby=$to, usedate='$date',note1='$log' where id = $row->id");
		$add2 = $db->query("insert into tblpin (managerid,requestdate, pin, paid, status,note1,note) values ('$to', '$date', '$row->pin', '$row->paid','N','$log','')") or die("Pins ".$db->error);
	}
}
?>