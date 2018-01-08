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

$start = (isset($_REQUEST['start'])) ? $_REQUEST['start']:"2015-07-11";
$end = (isset($_REQUEST['end'])) ? $_REQUEST['end']:"2015-07-21";
$paid = (isset($_REQUEST['paid'])) ? $_REQUEST['paid']:"Y";
$format = (isset($_REQUEST['format'])) ? $_REQUEST['format']:"S";

day_sum("2015-08-20", "2015-09-01");
echo "<br><br>";


function day_sum($start,$end) {
	global $setup,$db;
	$leader = $db->query("SELECT * FROM `tblmember` WHERE rank >5 and rank <=7");
	$h = "<tr bgcolor=silver><td>Day</td>";
	$d = "echo '<tr align=right><td>$row->day</td>";
	$q = "SELECT day(requestdate) as day";
	while ($row = mysqli_fetch_object($leader)) {
		$q .= ", sum(CASE WHEN leader='". $row->pin."' then pins end) as ".$row->pin;
		$h .= "<td>".$row->pin."</td>";
		$d .= "<td>"."$"."row->".$row->pin."</td>";
	}
	$q .= " from tblpinlog  where requestdate>='$start' and requestdate<='$end' and paid='Y' group by day(requestdate) with rollup";
	$h .= "<td>Total</td></tr>";
	$d .= "</tr>'";
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
//		echo "<tr bgcolor=silver><td>Day</td><td>Andy</td><td>Gary</td><td>Ivy</td><td>Jason</td><td>Total</td></td>";
		echo $h;
		while ($row = mysqli_fetch_object($rs)) {
			$tot = $row->Andy+$row->Gary+$row->Ivy+$row->Jason+$row->Lester;
			if ($row->day == "") {
				$row->day = "Total";
				if ($row->Lester=="") $row->Lester=0;
				echo "<tr bgcolor=silver align='right'><td>$row->day</td><td>$row->Andy</td><td>".($row->Gary+$row->Lester)."</td><td>$row->Ivy</td><td>$row->Jason</td><td>$tot</td></tr>";
			} else {
				eval($d);
				//echo "<tr align='right'><td>$row->day</td><td>$row->Andy</td><td>".($row->Gary+$row->Lester)."</td><td>$row->Ivy</td><td>$row->Jason</td><td>$tot</td></tr>";
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