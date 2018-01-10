<?
include("../inc/ggDbconfig.php");

$fix = $_REQUEST['fix'];
$a   = $_REQUEST['a'];

if ($fix==1) {
	fix_1(); // Remove duplicated help
} else if ($fix==2) {
	fix_2(); // Remove error data from tblmember & Mavro
} else if ($fix==3) {
	fix_3(); // Remove error data from tblmember & Mavro
} else {
	echo "?fix=1 (remove duplicated help)<br>";
	echo "?fix=2 (Remove duplicated member)<br>";
	echo "?fix=3 (Remove error data from tblmember & Mavro)<br>";
}

function fix_1() {
	global $a;
	$idlist = array();
	$rs = $db->query("select * from tblhelp order by id");
	$mem_id = 0;
	while ($row = mysqli_fetch_object($rs)) {
		if ($mem_id == $row->mem_id) {
			$user= load_user($row->mem_id);
			echo "$row->id $row->mem_id $user->email<br>";
			array_push($idlist, $row->id);
		} else {
			$mem_id = $row->mem_id;
		}
	}
	$count = count($idlist);

	for ($i=0;$i<$count;$i++) {
		echo $idlist[$i]." ";
		if ($a == "go") {
			$rs1 = $db->query("delete from tblhelp where id = ".$idlist[$i]) or die("help : ".$db->error);
			$rs2 = $db->query("delete from tblmavro where folio = ".$idlist[$i]) or die("Mavro : ".$db->error);
		}
	}
	if ($a <> "go") {
		echo "<br><br>No Action on database unless added a=go to parameter";
	}

	echo "<br>";
	print_r($idlist);
}

function fix_2() {
	global $a;
	$idlist = array();
	$rs = $db->query("select * from tblmember order by email,id");
	$id = 0;
	while ($row = mysqli_fetch_object($rs)) {
		if ($id == $row->id) {
			$user= load_user($row->id);
			echo "$row->id $user->email<br>";
			array_push($idlist, $row->id);
		} else {
			$id = $row->id;
		}
	}
	$count = count($idlist);

	for ($i=0;$i<$count;$i++) {
		echo $idlist[$i]." ";
		if ($a == "go") {
			$rs1 = $db->query("delete from tblmember where id = ".$idlist[$i]) or die("tblmember : ".$db->error);
		}
	}
	if ($a <> "go") {
		echo "<br><br>No Action on database unless added a=go to parameter";
	}
	echo "<br>";
	print_r($idlist);
}

function fix_3() {
	global $a;
	$idlist = array();
	$rs = $db->query("select * from tblmember where referral>id or manager>id");
	$id = 0;
	while ($row = mysqli_fetch_object($rs)) {
		$ref = load_user($row->referral);
		$mgr = load_user($row->manager);
		echo "id: $row->id $row->email <br>referral: $row->referral $ref->email<br>manager: $row->manager $mgr->email<br><br>";
		array_push($idlist, $row->id);
	}
	if ($a <> "go") {
		echo "<br><br>No Action on database unless added a=go to parameter";
	}
}
?>
