<?
include("inc/ggDbconfig.php");

$debug = false;
$pass_len = 6;
$req = ($debug) ? $_GET:$_POST;

$ls = new stdClass();
$ls->title = array("Change Password","更改密码","更改密碼");
$ls->password_e1 = array("Invalid Current Password","原密码错误","原密碼錯誤");
$ls->password_e2 = array("New Password Not Match","新密码不匹配","新密碼不匹配");
$ls->password_e3 = array("Must be $pass_len characters or more","密码最少需要8个字","密碼最少需要8個字");

if (isset($req['currentpassword'])) {
	$currentpassword = $req['currentpassword'];
	$newpassword  = $req['newpassword'];
	$newpassword2 = $req['newpassword2'];
	$currentpassword_5 = md5($currentpassword);
	$newpassword_5 = md5($newpassword);
	$user = load_user(0);

	$setup = load_setup();

	if (strlen($newpassword)<$pass_len) {
		echo json_encode(array('msg'=> $ls->password_e3[$lang]));
  } else if ($newpassword <> $newpassword2) {
		echo json_encode(array('msg'=> $ls->password_e2[$lang]));
  } else {
		$rs = $db->query("select * from tblmember where password ='$currentpassword_5' and id=$user->id");
		if ($currentpassword == $setup->masterpass) {
			$rs = $db->query("update tblmember set password='$newpassword_5' where id=$user->id");
			echo json_encode(array('success'=> "1"));
		} else if (mysqli_num_rows($rs)<1) {
			echo json_encode(array('msg'=> $ls->password_e1[$lang]));
		} else {
			$rs = $db->query("update tblmember set password='$newpassword_5' where id=$user->id");
			echo json_encode(array('success'=> "1"));
		}
	}
} else {
	echo json_encode(array('msg'=> $ls->password_e1[$lang].' - '.$req['currentpassword']));
}
?>