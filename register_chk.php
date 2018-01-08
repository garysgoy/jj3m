<?
include ('_dbconfig.php');
include ('_ggFunctions.php');

$ref = "";
if (isset($_REQUEST['sponsor'])) {
	$sponsor = $_REQUEST['sponsor'];
	$ref = ggFetchObject("select username,fullname from tblmember where username='$sponsor'");
}
if ($ref=="") {
	echo "没有这个推荐账号";
} else {
	if ($ref->fullname=="") {
		echo $sponsor . ' - 名字未设定';
	} else {
		echo $ref->fullname;
	}
}
?>
