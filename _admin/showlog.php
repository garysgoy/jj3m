<?
$pagetitle = "Buy PINs";
include("../inc/ggDbconfig.php");

$max = isset($_REQUEST['max'])? $_REQUEST['max']:50;

$rs = $db->query("select * from tblaccesslog order by id desc limit 0,$max");

echo "<table cellpadding=5>";
while ($row = mysqli_fetch_object($rs)) {
	if ($row->success==0) {
		echo "<tr bgcolor=silver><td>$row->id</td><td>$row->email</td><td>$row->date</td><td>$ip</td><td>$row->success</td><td>$row->str</td></td>";
	} else {
		echo "<tr><td>$row->id</td><td>$row->email</td><td>$row->date</td><td>$ip</td><td>$row->success</td><td>$row->str</td></td>";
	}
}
echo "</table>";