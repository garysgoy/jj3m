<?
include("../inc/ggDbconfig.php");

$fix = $_REQUEST['fix'];
if ($fix==1) {
	fix1();
} else if ($fix==2) {
	fix2();
} else {
	echo "?fix=1 Remove Duplicate Helps<br>
		  ?fox=2 Remove Duplicate Member";
}

function fix1() {
	//Remove duplicated data for Help & Mavro
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
		$rs1 = $db->query("delete from tblhelp where id = ".$idlist[$i]) or die("help : ".$db->error);
		$rs2 = $db->query("delete from tblmavro where help_id = ".$idlist[$i]) or die("Mavro : ".$db->error);
	}
	echo "<br>";
	print_r($idlist);
}

function fix2() {
	$idlist = array();
	$rs = $db->query("select * from tblmember order by email");
	$email = "";
	while ($row = mysqli_fetch_object($rs)) {
		if ($email == $row->email) {
			echo "$row->id $row->email<br>";
			array_push($idlist, $row->id);
		} else {
			$email = $row->email;
		}
	}
	$count = count($idlist);

	for ($i=0;$i<$count;$i++) {
		echo $idlist[$i]." ";
		$rs1 = $db->query("delete from tblmember where id = ".$idlist[$i]) or die("help : ".$db->error);
	}
	echo "<br>";
	print_r($idlist);
}
?>