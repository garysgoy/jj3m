<meta http-equiv="content-type" content="text/html;charset=utf-8">
<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$username = isset($_REQUEST['username']) ? $_REQUEST['username']:'';

if ($username=="") {
	echo "Please specify username";
	exit();
}

$mem = ggFetchObject("select * from tblmember where username = '$username'");
if ($mem->username <> $username) {
	echo "Invalid username";
	exit();
}

$gh = $db->query("select * from tblhelp where mem_id = $mem->id and g_type='G' and status='O'");

$tt = $db->query("update tblmember set stats='B' where username = $username");

$i = 1;
echo "<table>";
while ($row = mysqli_fetch_object($gh)) {
	$tt = $db->query("update tblhelp set status='B' where id = $row->id");
	echo "<tr><td>$i</td><td>$row->id</td><td>$row->g_type</td><td>$row->g_amount</td><td>$row->g_date</td></tr>";
	$i += 1;
}
echo "</table>";
?>