<meta http-equiv="content-type" content="text/html;charset=utf-8">
<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$rs = $db->query("select * from tblmember where status='B' order by username");

echo "<table border=1 cellspacing=0 cellpadding=4>";
$i = 1;
while ($row=mysqli_fetch_object($rs)) {
	echo "<tr><td>$i</td><td>$row->username</td><td>$row->fullname</td><td>$row->phone</td><td>$row->alipay</td></tr>";
	$i += 1;
}
echo "</table>";
?>