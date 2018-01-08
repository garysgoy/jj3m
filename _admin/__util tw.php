<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?

function gStatus() {
	$user = load_user(0);
	$setup = load_setup();
	$email = "";

	if ($setup->exrate=="3") {
		$ph = $db->query("select * from tblhelp where g_type='P' and (status='O' or status='P') and g_plan=30 and g_date < '2015-08-02' order by g_type, priority, g_date limit 0,100") or die("err ".$db->error);
		//$ph = $db->query("select * from tblhelp where g_type='P' and (status='O' or status='P') order by g_type, priority, g_date limit 0,500") or die("err ".$db->error);
	} else {
//		$ph = $db->query("select * from tblhelp where g_type='P' and g_date < '2015-06-25' and (status='O' or status='P') order by g_type, priority, g_date limit 0,250") or die("err ".$db->error);
		if ($email == "") {
			$ph = $db->query("select * from tblhelp where g_type='P' and g_date<= '2015-08-30' and (status='O' or status='P') order by g_type, priority, g_date limit 0,250") or die("err ".$db->error);
		} else {
			$ph = $db->query("select tblhelp.* from tblmember, tblhelp where tblhelp.mem_id = tblmember.id and tblmember.email like '$email' and g_type='P' and g_date<= '2015-09-21' and (tblhelp.status='O' or tblhelp.status='P') order by g_type, priority, g_date limit 0,250") or die("err ".$db->error);
		}
	}
	$gh = $db->query("select * from tblhelp where g_type='G' and status<>'D' and status<>'X' order by g_type, priority, g_date") or die("err ".$db->error);
	$pDate = array('2015-08-20 23:59:59','2015-08-21 23:59:59','2015-08-22 23:59:59','2015-08-23 23:59:59','2015-08-24 23:59:59','2015-08-25 23:59:59','2015-08-26 23:59:59','2015-08-27 23:59:59','2015-08-28 23:59:59','2015-08-29 23:59:59','2015-08-30 23:59:59','2015-08-31 23:59:59','2015-09-01 23:59:59','2015-09-02 23:59:59','2015-09-03 23:59:59','2015-09-04 23:59:59','2015-09-05 23:59:59','2015-09-06 23:59:59','2015-09-07 23:59:59','2015-09-08 23:59:59','2015-09-09 23:59:59','2015-09-10 23:59:59');
	$tph1 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date<='".$pDate[0]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph2 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[0]."' and g_date<='".$pDate[1]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph3 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[1]."' and g_date<='".$pDate[2]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph4 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[2]."' and g_date<='".$pDate[3]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph5 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[3]."' and g_date<='".$pDate[4]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph6 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[4]."' and g_date<='".$pDate[5]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph7 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[5]."' and g_date<='".$pDate[6]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph8 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[6]."' and g_date<='".$pDate[7]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph9 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[7]."' and g_date<='".$pDate[8]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph10 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[8]."' and g_date<='".$pDate[9]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph11 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[9]."' and g_date<='".$pDate[10]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph12 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[10]."' and g_date<='".$pDate[11]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph13 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[11]."' and g_date<='".$pDate[12]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph14 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[12]."' and g_date<='".$pDate[13]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph15 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[13]."' and g_date<='".$pDate[14]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph16 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[14]."' and g_date<='".$pDate[15]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph17 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[15]."' and g_date<='".$pDate[16]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph18 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[16]."' and g_date<='".$pDate[17]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph19 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[17]."' and g_date<='".$pDate[18]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph20 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[18]."' and g_date<='".$pDate[19]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph21 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[19]."' and g_date<='".$pDate[20]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph22 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[20]."' and g_date<='".$pDate[21]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph23 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[21]."' and g_date<='".$pDate[22]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph24 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[22]."' and g_date<='".$pDate[23]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tph25 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$pDate[23]."' and g_date<='".$pDate[24]."' and g_type='P' and status<>'D' and status<>'X'") or die("err ".$db->error);

	$gDate = array('2015-09-07 23:59:59','2015-09-08 23:59:59','2015-09-09 23:59:59','2015-09-10 23:59:59','2015-09-11 23:59:59','2015-09-12 23:59:59','2015-09-13 23:59:59','2015-09-14 23:59:59','2015-09-15 23:59:59');
	$tgh1 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date<='".$gDate[0]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tgh2 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$gDate[0]."' and g_date<='".$gDate[1]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tgh3 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$gDate[1]."' and g_date<='".$gDate[2]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tgh4 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$gDate[2]."' and g_date<='".$gDate[3]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tgh5 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$gDate[3]."' and g_date<='".$gDate[4]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tgh6 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$gDate[4]."' and g_date<='".$gDate[5]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$tgh7 = ggFetchObject("select sum(g_pending) as amt from tblhelp where g_date>'".$gDate[5]."' and g_date<='".$gDate[6]."' and g_type='G' and status<>'D' and status<>'X'") or die("err ".$db->error);
	$show = 1;  // 1 = show only outstanding
	if ($show == 0) {
		$gd = $db->query("select * from tblhelpdetail order by help_id") or die("err ".$db->error);
	} else {
	  	$gd = $db->query("select * from tblhelpdetail where stage <> 2 order by help_id") or die("err ".$db->error);
	}
	//$mem = $db->query("select * from tblmember where currency='$user->currency' order by id limit 0,50;") or die("err ".$db->error);

	echo "<table border=1 cellspacing=0 cellpadding=2 width=100%>";
	echo "<tr valign=top><td>";
	echo "<b>".substr($pDate[0],0,10)." PH = ".number_format($tph1->amt,2)."</b><br>";
	echo "<b>".substr($pDate[1],0,10)." PH = ".number_format($tph2->amt,2)."</b><br>";
	echo "<b>".substr($pDate[2],0,10)." PH = ".number_format($tph3->amt,2)."</b><br>";
	echo "<b>".substr($pDate[3],0,10)." PH = ".number_format($tph4->amt,2)."</b><br>";
	echo "<b>".substr($pDate[4],0,10)." PH = ".number_format($tph5->amt,2)."</b><br>";
	echo "<b>".substr($pDate[5],0,10)." PH = ".number_format($tph6->amt,2)."</b><br>";
	echo "<b>".substr($pDate[6],0,10)." PH = ".number_format($tph7->amt,2)."</b><br>";
	echo "<b>".substr($pDate[7],0,10)." PH = ".number_format($tph8->amt,2)."</b><br>";
	echo "<b>".substr($pDate[8],0,10)." PH = ".number_format($tph9->amt,2)."</b><br>";
	echo "<b>".substr($pDate[9],0,10)." PH = ".number_format($tph10->amt,2)."</b><br>";
	echo "<b>".substr($pDate[10],0,10)." PH = ".number_format($tph11->amt,2)."</b><br>";
	echo "<b>".substr($pDate[11],0,10)." PH = ".number_format($tph12->amt,2)."</b><br>";
	echo "<b>".substr($pDate[12],0,10)." PH = ".number_format($tph13->amt,2)."</b><br>";
	echo "<b>".substr($pDate[13],0,10)." PH = ".number_format($tph14->amt,2)."</b><br>";
	echo "<b>".substr($pDate[14],0,10)." PH = ".number_format($tph15->amt,2)."</b><br>";
	echo "<b>".substr($pDate[15],0,10)." PH = ".number_format($tph16->amt,2)."</b><br>";
	echo "<b>".substr($pDate[16],0,10)." PH = ".number_format($tph17->amt,2)."</b><br>";
	echo "<b>".substr($pDate[17],0,10)." PH = ".number_format($tph18->amt,2)."</b><br>";
	echo "<b>".substr($pDate[18],0,10)." PH = ".number_format($tph19->amt,2)."</b><br>";
	echo "<b>".substr($pDate[19],0,10)." PH = ".number_format($tph20->amt,2)."</b><br>";
	echo "<b>".substr($pDate[20],0,10)." PH = ".number_format($tph21->amt,2)."</b><br>";
	echo "<b>".substr($pDate[21],0,10)." PH = ".number_format($tph22->amt,2)."</b><br>";
	echo "<b>".substr($pDate[22],0,10)." PH = ".number_format($tph23->amt,2)."</b><br>";
	echo "<b>".substr($pDate[23],0,10)." PH = ".number_format($tph24->amt,2)."</b><br>";
	echo "<b>".substr($pDate[24],0,10)." PH = ".number_format($tph25->amt,2)."</b><br>";

	echo "<table border=1 cellspacing=0 cellpadding=2>";
	echo "<tr><td>No</td><td>ID</td><td>PR</td><td>User ID</td><td>Email</td><td>Date</td><td>Status</td><td>Amount</td><td>Pending</td><PRr>";

	// Provide Help
	$ctr = 1;
	$tot = 0;
	while ($row = mysqli_fetch_object($ph)) {
		$date = new datetime($row->g_date);
		$days = ggDaysDiff($date);
		$link = "$row->id";
		$usr = load_user($row->mem_id);
		$email =$usr->email.' - '.$usr->nickname;
		if ($row->status =="O" or $row->status == "P") $link = "<a href='__process1.php?id=$row->id'>$row->id</a>";
		$up = "<a href='_priority.php?id=$row->id&pr=-1'>+</a>";
		$dn = "<a href='_priority.php?id=$row->id&pr=+1'>-</a>";
	   	echo "<tr><td>$ctr</td><td>$link</td><td>$row->priority | $up | $dn &nbsp;</td><td>$row->mem_id</td><td>$email</td><td>$row->g_date $days</td><td>$row->status<br>$row->g_plan</td><td align=right>$row->g_amount</td><td align=right>$row->g_pending</td></tr>";
	   	$ctr = $ctr + 1;
	   	$tot = $tot + $row->g_pending;
	}
    echo "<tr><td colspan=7><a href='__process1.php?id=19640001'>Process</a></td><td align=right>$tot</td><td>&nbsp;</td></tr>";

	echo "</table>";
	echo "</td><td>";
	echo "<b>".substr($gDate[0],0,10)." GH = ".number_format($tgh1->amt,2)."</b><br>";
	echo "<b>".substr($gDate[1],0,10)." GH = ".number_format($tgh2->amt,2)."</b><br>";
	echo "<b>".substr($gDate[2],0,10)." GH = ".number_format($tgh3->amt,2)."</b><br>";
	echo "<b>".substr($gDate[3],0,10)." GH = ".number_format($tgh4->amt,2)."</b><br>";
	echo "<b>".substr($gDate[4],0,10)." GH = ".number_format($tgh5->amt,2)."</b><br>";
	echo "<b>".substr($gDate[5],0,10)." GH = ".number_format($tgh6->amt,2)."</b><br>";
	echo "<b>".substr($gDate[6],0,10)." GH = ".number_format($tgh7->amt,2)."</b><br>";
	echo "<table border=1 cellspacing=0 cellpadding=2>";
	echo "<tr><td>No</td><td>ID</td><td width='55'>PR</td><td>Created</td><td>User ID</td><td>Email</td><td>Status</td><td>Amount</td><td>Pending</td></tr>";

	// Get Help
	$ctr = 1;
	$tot = 0;
	while ($row = mysqli_fetch_object($gh)) {
		$usr = load_user($row->mem_id);
		$email =$usr->email .' '.$usr->nickname;
		$up = "<a href='_priority.php?id=$row->id&pr=-1'>+</a>";
		$dn = "<a href='_priority.php?id=$row->id&pr=+1'>-</a>";
		echo "<tr><td>$ctr</td><td>$row->id</td><td Width='55'>$row->priority | $up | $dn &nbsp;</td><td>$row->g_date</td><td>$row->mem_id</td><td>$email</td><td>$row->status</td><td align=right>$row->g_amount</td><td align=right>$row->g_pending</td></tr>";
		$ctr = $ctr + 1;
		$tot = $tot + $row->g_pending;
	}
    echo "<tr><td colspan=8>&nbsp;</td><td align=right>$tot</td></tr>";

	echo "</table>";
/*
	echo "<table border=1 cellspacing=0 cellpadding=2>";
	echo "<tr><td>No</td><td>ID</td><td>Help ID</td><td>Mem_ID</td><td>Type</td><td>Mem_id2</td><td>Tran ID</td><td>Amount</td><td>STG</td></tr>";


	// Details
	$ctr = 1;
	$tot = 0;
	$help_id = 0;
	while ($row = mysqli_fetch_object($gd)) {
		if ($help_id <> $row->help_id) {
			if ($help_id <> 0) {
				echo "<tr bgcolor=silver><td colspan=7>&nbsp;</td><td align=right>$tot</td></tr>";
			}
			$help_id = $row->help_id;
			$tot = 0;
		}
		$mem = load_user($row->mem_id);
		$oth = load_user($row->oth_id);
		echo "<tr><td>$ctr</td><td>$row->id</td><td>$row->help_id</td><td>$row->mem_id $mem->email</td><td>$row->g_type</td><td>$row->oth_id $oth->email</td><td>$row->tran_id</td><td align=right>$row->g_amount</td><td align=right>$row->stage</td></tr>";
		$ctr = $ctr + 1;
		$tot = $tot + $row->g_amount;
	}
	echo "<tr bgcolor=silver><td colspan=7>&nbsp;</td><td align=right>$tot</td></tr>";

	echo "</table>";
*/
	echo "</td><tr>";
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
$mem = mysqli_fetch_object($db->query("select count(id) as mcount from tblmember"));
$memd = mysqli_fetch_object($db->query("select count(id) as mcount from tblmember where date_add>='2015-07-05'"));
$ph = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_type='P' and status <> 'C'"));
$phd = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_date>= '2015-07-05' and g_type='P' and status <> 'C'"));
$gh = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_type='G' and status <> 'C'"));
$ghd = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_date>='2015-07-05' and g_type='G' and status <> 'C'"));
echo "Memer Count: $memd->mcount, PH Count: $phd->phcount,  PH Value: $phd->phvalue, GH Count: $ghd->phcount,  GH Value: $ghd->phvalue<br>";
echo "Memer Count: $mem->mcount, PH Count: $ph->phcount,  PH Value: $ph->phvalue, GH Count: $gh->phcount,  GH Value: $gh->phvalue<br>";
?>