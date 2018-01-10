<?
$pagetitle = "Buy PINs";
include("../inc/ggDbconfig.php");

$max = isset($_REQUEST['max'])? $_REQUEST['max']:50;

$rs = $db->query("select * from tblaccesslog1 order by id desc limit 0,$max");
echo "Access Log<br>";
echo "<table>";
$amount = 0;
while ($row = mysqli_fetch_object($rs)) {
	echo "<tr><td>$row->id</td><td>$row->l_date</td><td>$row->l_type</td><td>$row->username</td><td>$row->l_note</td><td>$row->str</td></td>";
}
echo "</table>";