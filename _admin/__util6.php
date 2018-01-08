<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<style>
.red {
  color: red;
}

.green {
  color: green;
}

.blue {
  color: blue;
}
</style>
<?

function gStatus($pr) {
	$user = load_user(0);
	$setup = load_setup();
	$email = "";

	if ($setup->exrate=="3") {
		$plan = 30;
		$ph = $db->query("select * from tblhelp where g_type='P' and (status='O' or status='P') and g_plan=$plan  order by g_type, priority, g_date limit 0,70") or die("err ".$db->error);
	} else {
		if ($email == "") {
			$ph = $db->query("select * from tblhelp where g_type='P' and priority<=$pr and (status='O' or status='P') order by g_type, g_date, priority limit 0,50") or die("err ".$db->error);
		} else {
			$ph = $db->query("select tblhelp.* from tblmember, tblhelp where tblhelp.mem_id = tblmember.id and tblmember.email like '$email' and g_type='P' and (tblhelp.status='O' or tblhelp.status='P') order by g_type, priority, g_date limit 0,100") or die("err ".$db->error);
		}
	}
	$gh = $db->query("select * from tblhelp where g_type='G' and status<>'D' and status<>'X' order by g_type, priority, g_date") or die("err ".$db->error);
	if ($show == 0) {
		$gd = $db->query("select * from tblhelpdetail order by help_id") or die("err ".$db->error);
	} else {
	  	$gd = $db->query("select * from tblhelpdetail where stage <> 2 order by help_id") or die("err ".$db->error);
	}
	//$mem = $db->query("select * from tblmember where currency='$user->currency' order by id limit 0,50;") or die("err ".$db->error);

	echo "<table><tr valign=top><td>";

// Summary
echo "<b>";
$rs = $db->query("SELECT DATE(g_date) as udate, sum(g_amount) as uamount
FROM tblhelp where g_type='P' and status = 'O' GROUP BY udate ORDER BY udate") or die ("err ". $db->error);

echo "<table width=600><tr valign=top><td>";
echo "<table cellpadding=2>";
$i = mysqli_num_rows($rs)-1;
$uamount = 0;
while ($row = mysqli_fetch_object($rs)) {
	$uamount += $row->uamount;
    echo "<tr><td>$i</td><td>$row->udate PH</td><td align=right>".number_format($row->uamount)."</td><td align=right><b class='blue'>".number_format($uamount)."</b></td><tr>";
    $i -=1;
}
echo "</table>";

$rs = $db->query("SELECT DATE(g_date) as udate, sum(g_amount) as uamount
FROM tblhelp where g_type='G' and status = 'O'
GROUP BY udate ORDER BY udate") or die ("err ". $db->error);

$j = mysqli_num_rows($rs)-1;
$uamount = 0;
echo "</td><td><table cellpadding=2 align=right>";
while ($row = mysqli_fetch_object($rs)) {
	$uamount += $row->uamount;
   echo "<tr><td>$j</td><td>$row->udate GH</td><td align=right>".number_format($row->uamount)."</td><td align=right><b class='blue'>".number_format($uamount)."</b></td><tr>";
   $j -=1;
}
echo "</table>";
echo "</td></tr></table>";
echo "</b>";

// PH
	echo "<table border=1 cellspacing=0 cellpadding=2>";
	echo "<tr><td>No</td><td>ID</td><td>PR</td><td>User ID</td><td>Email</td><td>Date</td><td>ST</td><td>Amount</td></tr>";

	// Provide Help
	$ctr = 1;
	$tot = 0;
	while ($row = mysqli_fetch_object($ph)) {
		$date = new datetime($row->g_date);
		$days = ggDaysDiff($date);
		$link = "$row->id";
		$usr = load_user($row->mem_id);
		$leader = ggLeader($row->mem_id);

		$email =$usr->email.' - '.$usr->nickname.'<br>'.$leader;
		if ($row->status =="O" or $row->status == "P") $link = "<a href='__process1.php?id=$row->id'>$row->id</a>";
		$up = "<a href='_priority.php?id=$row->id&pr=-1'>+</a>";
		$dn = "<a href='_priority.php?id=$row->id&pr=+1'>-</a>";
	   	echo "<tr><td>$ctr</td><td>$link</td><td>$row->priority | $up | $dn &nbsp;</td><td>$row->mem_id</td><td>$email</td><td>$row->g_date <b>$days</b></td><td>$row->status<br>P $row->g_plan</td><td align=right>$row->g_amount</td></tr>";
	   	$ctr = $ctr + 1;
	   	$tot = $tot + $row->g_pending;
	}
    echo "<tr><td colspan=7><a href='__process1.php?id=19640001'>Process</a></td><td align=right>$tot</td></tr>";
	echo "</table>";
	echo "</td><td>";
	echo "<table border=1 cellspacing=0 cellpadding=2>";
	echo "<tr><td>No</td><td>ID</td><td width='55'>PR</td><td>Created</td><td>User ID</td><td>Email</td><td>Status</td><td>Amount</td><td>Pending</td></tr>";

	// Get Help
	$ctr = 1;
	$tot = 0;
	while ($row = mysqli_fetch_object($gh)) {
		$usr = load_user($row->mem_id);
		$leader = ggLeader($row->mem_id);
		$email =$usr->email .' - '.$usr->nickname.'<br>'.$leader;
		$up = "<a href='_priority.php?id=$row->id&pr=-1'>+</a>";
		$dn = "<a href='_priority.php?id=$row->id&pr=+1'>-</a>";
		echo "<tr><td>$ctr</td><td>$row->id</td><td Width='55'>$row->priority | $up | $dn &nbsp;</td><td>$row->g_date</td><td>$row->mem_id</td><td>$email</td><td>$row->status</td><td align=right>$row->g_amount</td><td align=right>$row->g_pending</td></tr>";
		$ctr = $ctr + 1;
		$tot = $tot + $row->g_pending;
	}
    echo "<tr><td colspan=8>&nbsp;</td><td align=right>$tot</td></tr>";

	echo "</td></tr>";
	echo "</table>";

}

echo '<a href="__status.php">Status</a>&nbsp;&nbsp;';
echo '<a href="_sellpin.php">Sell Pins</a>&nbsp;&nbsp;';
echo '<a href="showstatus.php">Show Status</a>&nbsp;&nbsp;';
echo '<a href="memutil.php">Member Utility</a>&nbsp;&nbsp;';
echo '<a href="showlog.php">Show Access Log</a>&nbsp;&nbsp;';
echo '<a href="addgh.php">Add GH</a>&nbsp;&nbsp;';
echo '<a href="__process1.php?id=19640001">Process 1</a>&nbsp;&nbsp;';
echo '<a href="_checkPH.php?before=2015-06-25">Check PH</a>&nbsp;&nbsp;';
echo '<a href="showpinlog.php?start=2015-07-04">showpinlog</a>&nbsp;&nbsp<br><br>';

function ggLeader($id) {
	$leader = ggFetchObject("select * from tblmember where id = $id");
	$rank = $leader->rank;
	while ($rank <= 5 and $rank >0) {
		$leader = ggFetchObject("select * from tblmember where id = $leader->manager");
		$rank = $leader->rank;
	}
	if ($rank==0) {
		return ("XX");
	} else {
		return ($leader->pin);
	}
}
?>