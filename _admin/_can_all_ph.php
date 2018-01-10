<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

/*
1. Get All Open PH
2. Delete All Oen PH
3. Set Counter
*/

$tamount = 0;
$now = ggNows();
$ph = $db->query("select * from tblhelp where g_type = 'P' and status = 'O'");
echo "<table>";
while ($row = mysqli_fetch_object($ph)) {
	$rs = $db->query("delete from tblmavro where help_id=$row->id") or die("detail: " . $db->error);
	$rs = $db->query("update tblhelp set status = 'X', date_close='$now' where id=$row->id") or die("help: ".$db->error);
	$tamount += $row->g_amount;
	echo "<tr><td>$row->id</td><td>$row->g_amount</td><td>$row->g_date</td></tr>";
}
echo "</table>";
echo number_format($tamount,0);
$tt = $db->query("ALTER TABLE  `tblhelp` AUTO_INCREMENT =10000000");
?>