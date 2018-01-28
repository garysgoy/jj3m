<?
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');

$debug = false;
$req = ($debug)? $_GET:$_POST;

$ls = new stdClass();
$ls->notfound = array("Can not find sponsor","没有这个推荐账号","沒有這個推薦帳號");
$ls->notset   = array("Sponsor name not defined"," - 名字未设定"," 名字未設定");

$ref = "";
if (isset($req['sponsor'])) {
	$sponsor = $req['sponsor'];
	$ref = ggFetchValue("select id from tblmember where username='$sponsor'");
}
if ($ref == "") {
	echo $ls->notfound[$lang];
} else {
  $ref = load_user($ref);
	if ($ref->fullname=="") {
		echo $sponsor . $ls->notset[$lang];
	} else {
		echo $ref->fullname;
	}
}
?>
