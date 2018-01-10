<meta charset="utf-8">
<?
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');

$user = load_user(0);
$setup = load_setup();
$setup->maxaccount = 16;

$username   = $_REQUEST['username'];
$email    = $_REQUEST['email'];
$password   = $_REQUEST['password'];
$password2  = $_REQUEST['password2'];
$pass2      = $_REQUEST['pass2'];
$fullname   = $_REQUEST['fullname'];
$phone    = $_REQUEST['phone'];
$referral   = $_REQUEST['sponsor'];
$country  = $_REQUEST['country'];
$pin    = $_REQUEST['pin'];
$password2_5 = md5($_REQUEST['pass2']);
// Remove space from Chinese preg_replace("/\\s+/iu","",$txt)
/*
if ($pin=='auto1123') {
  $pin = ggFetchValue("select pin from tblpin where managerid=$user->id and status='N' limit 1");
}
*/

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
$ls->password_e4 = array("Password - Invalid second password", "二级密码 - 二级密码错误","二級密碼 - 二級密碼錯誤");

$ls->country_e1 = array("Country - Please nominate your country", "国家- 请选择国家","國家- 請選擇國家");

$ls->pin_e1      = array("PIN - Invalid PIN", "激活码 - 激活码无效","激活碼 - 激活碼無效");
$ls->referral_e1 = array("Sponsor - can not be blank", "推荐人账号 - 必须填写","推薦人賬號 - 必須填寫");
$ls->referral_e2 = array("Sponsor - can not find this sponsor", "推荐人账号 - 找不到这个推荐人账号","推薦人賬號 - 找不到這個推薦人賬號");


echo "ok 0<br>";
ggRegister1(22);
echo "ok 1"

?>