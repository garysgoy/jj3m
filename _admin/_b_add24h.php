<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$rs = $db->query("select * from tblhelpdetail where stage <> 2 and stage <> 4");
while ($row = mysqli_fetch_object($rs)) {
	$date = new datetime($row->g_timer);
	$new  = $date->Modify("+24 Hours");
	$new_s = ggDateToString($new);
	$tt = $db->query("update tblhelpdetail set g_timer = '$new_s' where id=$row->id");
}
?>