<?
include("../_dbconfig.php");
include("../_ggFunctions.php");
include("../_sms.php");

$id = (isset($_REQUEST['id']))? $_REQUEST['id']:22866;

$rs = $db->query("select id from tblhelp where id = $id");
while ($row=mysqli_fetch_object($rs)) {
	echo sms_match($row->id);
}
?>