<?
include ("../_dbconfig.php");

$setup = load_setup();
$user = load_user(0);

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

if ($setup->exrate=="3") {
	$leader = array("AY" => "Angel", "JS" => "J-Son", "SG" => "Soo", "SL" => "Super Liew");
} else {
	$leader = array("AL" => "Andy", "GG" => "Gary", "LC" => "Gary (L)", "IL" => "Ivy", "JG" => "Jason");
}

$now = new DateTime("NOW");
$today = $now->format('Y-m-d');

$start = (isset($_REQUEST['start'])) ? $_REQUEST['start']:$today;
$end = (isset($_REQUEST['end'])) ? $_REQUEST['end']:"2015-07-21";
$paid = (isset($_REQUEST['paid'])) ? $_REQUEST['paid']:"Y";
$format = (isset($_REQUEST['format'])) ? $_REQUEST['format']:"S";

$rs = $db->query("select * from tblpinlog where requestdate >= '$start' and requestdate <= '$start 23:59' and paid='$paid' order by leader, requestdate") or die("get log ".$db->error);
echo "<br><table align='center' border='1' cellspacing='0' cellpadding='5'>";
//echo "<tr bgcolor='silver'><td>id</td><td>date</td><td>manager</td><td>pins</td><td>note</td></tr>";
$grp = "";
$tot=0;
$gtot=0;
$ctr = 1;
while ($row = mysqli_fetch_object($rs)) {
	if ($grp <> $row->leader . ' '. substr($row->requestdate,0,10)) {
		if ($grp<>"") {
			if ($format=='S') {
				echo "<tr bgcolor='silver'><td colspan=2>Total</td><td>".$tot."</td></tr>";
				echo "<tr><td colspan=5>&nbsp;</td></tr>";
			} else {
				echo "<tr bgcolor='silver'><td colspan=3>&nbsp;</td><td>".$tot."</td><td>&nbsp;</td></tr>";
				echo "<tr><td colspan=5>&nbsp;</td></tr>";
			}
		}
		$grp = $row->leader . ' '. substr($row->requestdate,0,10);
		$tot =0;
		$ctr=1;
		if ($format=='S') {
			echo "<tr bgcolor='silver'><td colspan=5>".$leader[$row->leader]." ".substr($row->requestdate,0,10)."</td></tr>";
		} else {
			echo "<tr bgcolor='silver'><td colspan=5>".$leader[$row->leader]." ".substr($row->requestdate,0,10)."</td></tr>";
		}
	}
	if ($format=='S') {
		$email = ggLeftEmail($row->requestby);
		echo "<tr bgcolor='white'><td>$ctr</td><td>$email</td><td>$row->pins</td></tr>";
	} else {
		echo "<tr bgcolor='white'><td>$row->id</td><td>$row->requestdate</td><td>$row->requestby</td><td>$row->pins</td><td>$row->note </td></tr>";
	}
	$tot += $row->pins;
	$ctr++;
}
if ($format=='S') {
	echo "<tr bgcolor='silver'><td colspan=2>Total</td><td>".$tot."</td></tr>";
} else {
	echo "<tr bgcolor='silver'><td colspan=3>&nbsp;</td><td>".$tot."</td><td>&nbsp;</td></tr>";
}
echo "</table><br><br>";

function day_sum($start,$end) {
	global $setup;
	if ($setup->exrate=="3") {
		$q = "SELECT day(requestdate) as day, sum(CASE WHEN leader='AY' then pins end) as Angel,sum(CASE WHEN leader='JS' then pins end) as JSon,sum(CASE WHEN leader='SG' then pins end) as Soo, sum(CASE WHEN leader='SL' then pins end) as Super from tblpinlog  where requestdate>='2015-07-01' and paid='Y' group by day(requestdate) with rollup";
	} else {
		$q = "SELECT day(requestdate) as day, sum(CASE WHEN leader='AL' then pins end) as Andy,sum(CASE WHEN leader='GG' then pins end) as Gary,sum(CASE WHEN leader='LC' then pins end) as Lester,sum(CASE WHEN leader='IL' then pins end) as Ivy,sum(CASE WHEN leader='JG' then pins end) as Jason from tblpinlog  where requestdate>='$start' and requestdate<='$end' and paid='Y' group by day(requestdate) with rollup";
	}

	$rs = mysqli_query($q);
	echo "<table border=1 cellpadding=5 cellspacing=0 width=350 align=center>";
	if ($setup->exrate=="3") {
		echo "<tr bgcolor=silver><td>Day</td><td>Angel</td><td>Gary</td><td>J-Son</td><td>Soo</td><td>Super</td><td>Total</td></td>";
		while ($row = mysqli_fetch_object($rs)) {
			$tot = $row->Angel+$row->Gary+$row->JSon+$row->Soo+$row->Super;
			if ($row->day == "") {
				$row->day = "Total";
				if ($row->Gary=="") $row->Gary=0;
				echo "<tr bgcolor=silver align='right'><td>$row->day</td><td>$row->Angel</td><td>$row->Gary</td><td>$row->JSon</td><td>$row->Soo</td><td>$row->Super</td><td>$tot</td></tr>";
			} else {
				echo "<tr align='right'><td>$row->day</td><td>$row->Angel</td><td>$row->Gary</td><td>$row->JSon</td><td>$row->Soo</td><td>$row->Super</td><td>$tot</td></tr>";
			}
		}
	} else {
		echo "<tr bgcolor=silver><td>Day</td><td>Andy</td><td>Gary</td><td>Ivy</td><td>Jason</td><td>Total</td></td>";
		while ($row = mysqli_fetch_object($rs)) {
			$tot = $row->Andy+$row->Gary+$row->Ivy+$row->Jason+$row->Lester;
			if ($row->day == "") {
				$row->day = "Total";
				if ($row->Lester=="") $row->Lester=0;
				echo "<tr bgcolor=silver align='right'><td>$row->day</td><td>$row->Andy</td><td>".($row->Gary+$row->Lester)."</td><td>$row->Ivy</td><td>$row->Jason</td><td>$tot</td></tr>";
			} else {
				echo "<tr align='right'><td>$row->day</td><td>$row->Andy</td><td>".($row->Gary+$row->Lester)."</td><td>$row->Ivy</td><td>$row->Jason</td><td>$tot</td></tr>";
			}
		}
	}
	echo "</table>";
}

function ggLeftEmail($email) {
	$pos = strpos($email, "@");
	$ret = substr($email,0,$pos);
	return $ret;
}
?>