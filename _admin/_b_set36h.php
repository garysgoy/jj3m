<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$date = new datetime("now");
$new  = $date->Modify("+36 Hours");
$rs = $db->query("select * from tblhelpdetail where stage <> 2 and stage <> 4");

while ($row = mysqli_fetch_object($rs)) {
	echo "$row->g_amont <br>";
	$new_s = ggDateToString($new);
	$tt = $db->query("update tblhelpdetail set g_timer = '$new_s' where id=$row->id");
}
?>