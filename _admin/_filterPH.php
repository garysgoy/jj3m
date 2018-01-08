<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$max = 2000;
$help = $db->query("select * from tblhelp where g_type='P' and (status='O' or status='P') order by priority desc, g_date limit $max") or die("err ".$db->error);
echo "<table>";
$i = 1;
while ($row = mysqli_fetch_object($help)) {
	$email = ggGetMemberEmail($row->mem_id);
	$ph = ggFetchObject("select count(id) as cc from tblhelp where mem_id = $row->mem_id and g_type='P' and status='C'");
	$gh = ggFetchObject("select count(id) as cc from tblhelp where mem_id = $row->mem_id and g_type='G'  and (status='C' or status='O') and note = 'deposit'");
	$comment = "PH = {$ph->cc}  GH = {$gh->cc}";
	echo "<tr><td>$i</td><td>$row->id</td><td>$row->mem_id</td><td>$email</td><td>$row->priority</td><td>$row->g_date</td><td align=right>$row->g_amount</td><td>$comment</td></tr>";
	$i += 1;
	if ($ph->cc >0 or $gh->cc >0) {
		$xx = $db->query("update tblhelp set priority=6 where id = $row->id") or die($db->error);
	} else {
		$xx = $db->query("update tblhelp set priority=5 where id = $row->id") or die($db->error);
	}
}
echo "</table>";
?>