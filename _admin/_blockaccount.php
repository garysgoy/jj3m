<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

/*
1. Get all expired PH
2. Update tblmember status = 'B'
3. Cancel all pending PH & GH
4. Mark Manager record
5. update tblhelpdetails
*/

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

// Step 1 -- tblmember.status = 'B'
$u1 = $db->query("update tblmember set status='B' where id = $mem->id") or die($db->error);

// Step 2 -- tblhelp cancel all open PH & GH
$hh = $db->query("select * from tblhelp where mem_id = $mem->id and status = 'O'") or die($db->error);
while ($row = mysqli_fetch_object($hh)) {
	$u2 = $db->query("delete from tblmavro where help_id=$row->id") or die("detail: " . $db->error);
	$u3 = $db->query("update tblhelp set status = 'X' where id=$row->id") or die($db->error);
}

// Step 3 -- update details
$phd = $db->query("select * from tblhelpdetail where mem_id = $mem->id and stage<>2") or die($db->error);
echo "<table>";
while ($row = mysqli_fetch_object($phd)) {
	$u4 = $db->query("update tblhelpdetail set stage = 4, status = 'E' where tran_id = $row->tran_id");
	$gh = ggFetchObject("select * from tblhelpdetail where tran_id = $row->tran_id and g_type='G'");
	$ph = ggFetchObject("select * from tblhelpdetail where tran_id = $row->tran_id and g_type='P'");
	$u3 = $db->query("update tblhelp set status='P', g_pending=g_pending+$row->g_amount where id = $gh->help_id");
	$u2 = $db->query("update tblhelp set status='F' where id = $ph->help_id");
	echo "<tr><td>$row->id</td><td>$row->g_amount</td><td>$row->g_date</td></tr>";
}
echo "</table>";
?>