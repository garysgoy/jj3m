<?
include("_dbconfig.php");
include("_ggFunctions.php");

$xx = $db->query("truncate tblmavro");
$ph = $db->query("select * from tblhelp where g_type='P' and status <> 'X'");
while ($row = mysqli_fetch_object($ph)) {
	echo "<br>".$row->id;
	$now = new datetime($row->g_date);
	$res = ggPH1($row->id, $row->mem_id,$row->g_amount,$now,$row->g_plan);
}

?>