<?
include("../_dbconfig.php");

$a = List_1(); // Switch Referral / Manager
$a = List_2();
$a = List_3();
$a = List_4();


function list_1() {
	global $db;
		$rs = $db->query("select * from tblmember where id>5 and rank < 5 order by email");
	echo "<br><br>List 1 -Switch Referral & Manager<br>";
	echo "<table width=1000 border=1 cellspacing=0>";
	echo "<tr><td>SN</td><td>Member</td><td>Referral</td><td>Manager (Wrong)</td><td>Manager (Should Be)</td><td>PH</td></tr>";
	$i = 1;
	while ($row = mysqli_fetch_object($rs)) {
		$manager = load_byid($row->manager);
		$manager1 = load_byid($manager->manager);
		$referral = load_byid($row->referral);
		$ph = $db->query("select * from tblhelp where mem_id = $row->id");
		if ($ph=="" or mysqli_num_rows($ph)==0) {
			$phs = 0;
			$phdetail = "0";
		} else {
			$phs = mysqli_num_rows($ph);
			$phd = mysqli_fetch_object($ph);
			$phdetail = $phs ." ".$phd->g_amount;
		}
		if ($manager->rank<5 and $referral->rank==5) {
			echo "<tr><td>$i</td><td>$row->email</td><td>$referral->email</td><td>$manager->email</td><td>$manager1->email $manager1->rank</td><td>$phdetail</td></tr>";
			$i++;
		}
	}
	echo "</table>";
}

function list_2() {
	global $db;
		$rs = $db->query("select * from tblmember where id>5 and rank < 5 order by email");
	echo "<br><br>List 2 - UU Line Manager (Only change manager)<br>";
	echo "<table width=1000 border=1 cellspacing=0>";
	echo "<tr><td>SN</td><td>Member</td><td>Referral</td><td>Manager (Wrong)</td><td>Manager (Should Be)</td><td>PH</td></tr>";
	$i = 1;
	while ($row = mysqli_fetch_object($rs)) {
		$manager = load_byid($row->manager);
		$manager1 = load_byid($manager->manager);
		$referral = load_byid($row->referral);
		$ph = $db->query("select * from tblhelp where mem_id = $row->id");
		if ($ph=="" or mysqli_num_rows($ph)==0) {
			$phs = 0;
			$phdetail = "0";
		} else {
			$phs = mysqli_num_rows($ph);
			$phd = mysqli_fetch_object($ph);
			$phdetail = $phs ." ".$phd->g_amount;
		}
		if ($manager->rank<5 and $manager1->rank==5) {
			echo "<tr><td>$i</td><td>$row->email</td><td>$referral->email</td><td>$manager->email</td><td>$manager1->email $manager1->rank</td><td>$phdetail</td></tr>";
			$i++;
		}
	}
	echo "</table>";
}

function list_3() {
	global $db;
		$rs = $db->query("select * from tblmember where id>5 and rank < 5 order by email");
	echo "<br><br>List 3 - Change only Manager 2 ";
	echo "<table width=1000 border=1 cellspacing=0>";
	echo "<tr><td>SN</td><td>Member</td><td>Referral</td><td>Manager (Wrong)</td><td>Manager (Should Be)</td><td>PH</td></tr>";
	$i = 1;
	while ($row = mysqli_fetch_object($rs)) {
		$manager = load_byid($row->manager);
		$manager1 = load_byid($manager->manager);
		$manager2 = load_byid($manager1->manager);
		$referral = load_byid($row->referral);
		$ph = $db->query("select * from tblhelp where mem_id = $row->id");
		if ($ph=="" or mysqli_num_rows($ph)==0) {
			$phs = 0;
			$phdetail = "0";
		} else {
			$phs = mysqli_num_rows($ph);
			$phd = mysqli_fetch_object($ph);
			$phdetail = $phs ." ".$phd->g_amount;
		}
		if ($manager->rank<5 and $manager1->rank==1 & $manager2->rank==5) {
			echo "<tr><td>$i</td><td>$row->email</td><td>$referral->email</td><td>$manager->email</td><td>$manager2->email $manager2->rank</td><td>$phdetail</td></tr>";
			$i++;
		}
	}
	echo "</table>";
}
function list_4() {
	global $db;
		$rs = $db->query("select * from tblmember where id>5 and rank < 5 order by email");
	echo "<br><br>List 4 - Change only Manager 3? ";
	echo "<table width=1000 border=1 cellspacing=0>";
	echo "<tr><td>SN</td><td>Member</td><td>Referral</td><td>Manager (Wrong)</td><td>Manager (Should Be)</td><td>PH</td></tr>";
	$i = 1;
	while ($row = mysqli_fetch_object($rs)) {
		$manager = load_byid($row->manager);
		$manager1 = load_byid($manager->manager);
		$manager2 = load_byid($manager1->manager);
		$manager3 = load_byid($manager2->manager);
		$manager4 = load_byid($manager3->manager);
		$manager5 = load_byid($manager4->manager);
		$referral = load_byid($row->referral);
		$ph = $db->query("select * from tblhelp where mem_id = $row->id");
		if ($ph=="" or mysqli_num_rows($ph)==0) {
			$phs = 0;
			$phdetail = "0";
		} else {
			$phs = mysqli_num_rows($ph);
			$phd = mysqli_fetch_object($ph);
			$phdetail = $phs ." ".$phd->g_amount;
		}
		if ($manager->rank<5 and $manager1->rank==1 & $manager2->rank<5) {
			$m = 0;
			if ($manager3->rank==5) {
				$m = 3;
			} else if ($manager4->rank==5) {
				$m = 4;
			} else if ($manager5->rank==5) {
				$m = 5;
			} else {
				$m = 0;
			}
			echo "<tr><td>$i</td><td>$row->email</td><td>$referral->email</td><td>$manager->email</td><td>$manager2->email $manager2->rank $m</td><td>$phdetail</td></tr>";
			$i++;
		}
	}
	echo "</table>";
}

function load_byemail($email) {
	global $db;
		$user = array();

	$rs_user = $db->query("SELECT * FROM tblmember where email = '$email'");

	if ($rs_user=="" || mysqli_num_rows($rs_user)==0) {
		$user = array(	'id'   		=> 0);
		$ret = (object) $user;
	} else {
		$row = mysqli_fetch_array($rs_user);
		$ret = (object) $row;
	}

  return ($ret);
}

function load_byid($id) {
	global $db;
	$user = array();

	$rs_user = $db->query("SELECT * FROM tblmember where id = $id");

	if ($rs_user=="" || mysqli_num_rows($rs_user)==0) {
		$user = array(	'id'   		=> 0);
		$ret = (object) $user;
	} else {
		$row = mysqli_fetch_array($rs_user);
		$ret = (object) $row;
	}

  return ($ret);
}



?>