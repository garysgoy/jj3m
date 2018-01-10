<meta http-equiv="content-type" content="text/html;charset=utf-8">
<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$rs = $db->query("select h.* from tblhelp as h, tblmember as m where h.mem_id=m.id and h.status='B' order by username");

echo "<table border=1 cellspacing=0 cellpadding=4><tr><td>NO</td><td>用户名</td><td>姓名</td><td>电话</td><td>金额</td></tr>";
$i = 1;
while ($row=mysqli_fetch_object($rs)) {
	$usr = load_user($row->mem_id);
	echo "<tr><td>$i</td><td>$usr->username</td><td>$usr->fullname</td><td>$usr->phone</td><td>$row->g_pending</td></tr>";
	$i += 1;
}
echo "</table>";
?>