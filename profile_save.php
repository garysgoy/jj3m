<?
include ('_dbconfig.php');
include ('_ggFunctions.php');

$user = load_user(0);
$setup=load_setup();

$check_phone_len = false;

$fullname 	= $_REQUEST['fullname'];
$username 	= $_REQUEST['username'];
$email 		= $_REQUEST['email'];
$bankholder = $_REQUEST['bankholder'];
$bankaccount = $_REQUEST['bankacc'];
$phone 		= $_REQUEST['phone'];
$wechat 	= $_REQUEST['wechat'];
$alipay 	= $_REQUEST['alipay'];
$btc 	= $_REQUEST['btc'];
$eth 	= $_REQUEST['eth'];
$whatsapp 	= $_REQUEST['whatsapp'];
$line 		= $_REQUEST['line'];
$bankname 	= $_REQUEST['bankname'];
$bankbranch = $_REQUEST['bankbranch'];
$password2_5  = md5($_REQUEST['transpin']);
$transpin   = $_REQUEST['transpin'];
$transpin2  = $_REQUEST['transpin2'];

$bankaccount = preg_replace("/\\s+/iu","",$bankaccount);

$lang = 1;
$ls = new stdClass();
$ls->username_e1 = array("Username can not be blank","登入账号 - 必须填写","登入賬號 - 必須填寫");
$ls->username_e2 = array("Username - must be 6 characters and above", "登入账号 - 6个字以上","登入賬號 - 6個字以上");
$ls->username_e3 = array("Username - contain only alphabets and numbers, cannot use symbols", "登入账号 - 只可以英文字母和数字，不能有特殊字符","登入賬號 - 只可以英文字母和數字，不能有特殊字符");
$ls->username_e4 = array("Username - already in system", "登入账号 - 这个登入账号已被使用","登入賬號 - 這個登入賬號已被使用");
$ls->phone_e1    = array("Phone No - can only contain numbers", "手机号码 - 只可以数字","手機號碼 - 只可以數字");
$ls->phone_e2    = array("Phone No - must be 11 characters", "手机号码 - 必须11个数字","手機號碼 - 必須11個數字");
$ls->phone_e3    = array("Phone No - one phone no can only register ".$setup->maxaccount." accounts", "手机号码 - 一个手机号码只能注册".$setup->maxaccount."个账户","手机号码 - 一个手机号码只能注册".$setup->maxaccount."个账户");
$ls->email_e1    = array("Email - can not be blank", "电邮 - 必须填写","電郵 - 必須填寫");
$ls->email_e2    = array("Email - invalid email format", "电邮 - 电邮格式不对","電郵 - 電郵格式不對");
$ls->password_e1 = array("Password - can not be blank", "密码 - 必须填写","密碼 - 必須填寫");
$ls->password_e2 = array("Password - must be 8 characters and above", "密码 - 必须8个字以上","密碼 - 必須8個字以上");
$ls->password_e3 = array("Password - password not match", "密码 - 确认密码不匹配","密碼 - 確認密碼不匹配");

$ls->password2_e1 = array("Password - Invalid second password", "二级密码 - 二级密码错误","二級密碼 - 二級密碼錯誤");
$ls->password2_e2 = array("Second Password - must be 8 characters and above", "二级密码 - 必须8个字以上","密碼 - 必須8個字以上");
$ls->password2_e3 = array("Second Password - password not match", "二级密码 - 确认密码不匹配","密碼 - 確認密碼不匹配");

$ls->country_e1 = array("Country - Please nominate your country", "国家- 请选择国家","國家- 請選擇國家");

$ls->pin_e1      = array("PIN - Invalid PIN", "激活码 - 需要有效的激活码","激活碼 - 需要有效的激活碼");
$ls->referral_e1 = array("Sponsor - can not be blank", "推荐人账号 - 必须填写","推薦人賬號 - 必須填寫");
$ls->referral_e2 = array("Sponsor - can not find this sponsor", "推荐人账号 - 找不到这个推荐人账号","推薦人賬號 - 找不到這個推薦人賬號");

$ls->fullname_e1    = array("Fullname - one name can only register ".$setup->maxaccount." accounts", "姓名 - 一个姓名只能注册".$setup->maxaccount."个账户","姓名 - 一个姓名只能注册".$setup->maxaccount."个账户");
$ls->bankaccount_e1 = array("Bank Account - one Bank Account can only register ".$setup->maxaccount." accounts", "银行户口 - 一个银行户口只能注册".$setup->maxaccount."个账户","银行户口 - 一个银行户口只能注册".$setup->maxaccount."个账户");
$ls->alipay_e1 		= array("Alipay Account - one Alipay Account can only register ".$setup->maxaccount." accounts", "支付宝 - 一个支付宝只能注册".$setup->maxaccount."个账户","支付宝 - 一个支付宝只能注册".$setup->maxaccount."个账户");

$msg = "";
if ($user->password2=="") {
	if (strlen($transpin)<8) {
		$msg .= "<br>".$ls->password2_e2[$lang];
	} else if ($transpin <> $transpin2) {
		$msg .= "<br>".$ls->password2_e3[$lang];
	}
} else {
	if (mysqli_num_rows($db->query("select id from tblmember where id=$user->id and password2<>'' and password2='$password2_5'"))==0) {
		$msg .= "<br>".$ls->password2_e1[$lang];
	}
}

$pcount = ggFetchValue("select count(phone) from tblmember where phone='$phone'");
if ($check_phone_len && strlen($phone) <> 11) {
	$msg .= "<br>".$ls->phone_e2[$lang];
} else if (!preg_match('/^[0-9]+$/', $phone)) {
	$msg .= "<br>".$ls->phone_e1[$lang];
} else 	if ($pcount >= $setup->maxaccount && $phone<>$user->phone) {
	$msg .= "<br>".$ls->phone_e3[$lang];
}

if ($fullname <> "") {
    $fullname1 = preg_replace("/\\s+/iu","",$fullname);
	$pcount = ggFetchValue("select count(id) from tblmember where fullname='$fullname' or fullname='$fullname1'");

	if ($pcount >= $setup->maxaccount  && $fullname<>$user->fullname) {
		$msg .= "<br>".$ls->fullname_e1[$lang];
	}
}

if ($bankaccount <> "") {
    $bankaccount1 = preg_replace("/\\s+/iu","",$bankaccount);
	$pcount = ggFetchValue("select count(id) from tblmember where bankaccount='$bankaccount' or bankaccount='$bankaccount1'");

	if ($pcount >= $setup->maxaccount  && $bankaccount<>$user->bankaccount) {
		$msg .= "<br>".$ls->bankaccount_e1[$lang];
	}
}

if ($alipay <> "") {
    $alipay = preg_replace("/\\s+/iu","",$alipay);
	$pcount = ggFetchValue("select count(id) from tblmember where alipay='$alipay'");

	if ($pcount >= $setup->maxaccount && $alipay<>$user->alipay) {
		$msg .= "<br>".$ls->alipay_e1[$lang];
	}
}

if ($msg=="") {
	$rep = ggSaveMember($fullname,$bankaccount,$phone,$wechat,$alipay,$btc,$eth,$whatsapp,$line,$bankname,$bankbranch);
}

if ($msg == "") {
	echo json_encode(array('success'=>true, 'username'=>$user->username));
} else {
	$msg = "<br><br>" . $msg ."<br>";
	echo json_encode(array('msg'=>$msg));
}

function ggSaveMember($fullname,$bankaccount,$phone,$wechat,$alipay,$btc,$eth,$whatsapp,$line,$bankname,$bankbranch) {
	global $db,$user,$ls,$msg, $lang, $password2_5;
	$ret = 0;

	$rs1 = $db->query("update tblmember set fullname='$fullname',bankholder='$fullname',bankaccount='$bankaccount',phone='$phone',wechat='$wechat',alipay='$alipay',btc='$btc',eth='$eth',whatsapp='$whatsapp',line='$line',bankname='$bankname',bankbranch='$bankbranch' where id = $user->id");

	if ($user->password2 == "") {
		$rs1 = $db->query("update tblmember set password2 = '$password2_5' where id = $user->id");
	}
	return;
}

?>