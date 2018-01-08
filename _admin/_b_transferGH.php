<meta http-equiv="content-type" content="text/html;charset=utf-8">
<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

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

$rr = mysqli_fetch_object($db->query("select h.* from tblhelp as h, tblmember as m where h.mem_id = m.id and (m.username >= 'tan101' and m.username <= 'tan107') order by sms limit 1")) or die("err: ".$db->error);
$a_help_id = $rr->id;
$a_mem_id = $rr->mem_id;

$xx = $db->query("update tblhelp set sms = sms+1 where id=$rr->id");
$usr = load_user($rr->mem_id);

echo "$usr->username mem: $a_mem_id help: $a_help_id<br>";

$gh = $db->query("select * from tblhelp where mem_id = $mem->id and g_type='G' and status='C'");

$i = 1;
echo "<table>";
while ($row = mysqli_fetch_object($gh)) {
	$tt = $db->query("update tblhelp set status='B' where id = $row->id");
	echo "<tr><td>$i</td><td>$row->id</td><td>$row->g_type</td><td>$row->g_amount</td><td>$row->g_date</td></tr>";
	$i += 1;

	// Process Help Detail
	$ghd = $db->query("select * from tblhelpdetail where help_id=$row->id");
	while ($row1 = mysqli_fetch_object($ghd)) {
		if ($row1->stage==0) {
			$t0 = $db->query("update tblhelp set g_pending = g_pending + $row1->g_amount where id=$row1->help_id");
		}
		$t1 = $db->query("update tblhelpdetail set mem_id = $a_mem_id, help_id = $a_help_id where id = $row1->id");
		$t2 = $db->query("update tblhelpdetail set oth_id = $a_mem_id where tran_id = $row1->tran_id and g_type='P'");
	}
}
echo "</table>";
?>