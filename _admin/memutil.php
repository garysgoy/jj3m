<?
include("../inc/ggDbconfig.php");

$user = load_user(0);

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

$a 		= $_REQUEST['a'];
$email 	= $_REQUEST['email'];
$manager= $_REQUEST['manager'];
$referral= $_REQUEST['referral'];

if ($a=='l' and $email <> "") {
	$user_id = listHelp($email);
} else if ($a=='ri' and $id <> "") {
	removeHelp($id);
} else if ($a=='re' and $email <> "") {
	removeHelpE($email);
} else if ($a=='cu' and $email<>"" and ($manager<>"" or $referral<>"")) {
	changeUpline($email,$referral,$manager);
} else if ($a=='redate' and $email<>"" and $newdate<>"") {
	redateHelp($email,$newdate);
} else if ($a=='pw' and $email<>"") {
	$pass = md5('12345678');
	$c = $db->query("select * from tblmember where email = '$email'");
	if ($c == "" or mysqli_num_rows($c)<1) {
		echo "Invalid Email";
	} else {
		$r = $db->query("update tblmember set password='$pass' where email = '$email'");
		echo "Password Reset";
	}
} else {
	echo "usage
		<br>?a=l&email=aaa@bbb.com (List help by email)
		<br>?a=pw&email=aa@BB.com (Reset password to 12345678)
		<br>?a=ri&id=1 (Remove help by id)
		<br>?a=re&email=aaa@bbb.com (remove help by email)
		<br>?a=cu&email=aa@bb.com&manager=aa@bb.com&referral=aa@bb.com (Change upline - soponsor and/or manager)
		<br>?a=redate&email=aaa@bbb.com&newdate=2015-06-27 10:00";
}

function changeUpline($email,$referral,$manager) {
	echo "Change Upline<br>";
	echo "<br> Mem: $email";
	echo "<br> Ref: $referral";
	echo "<br> Mgr: $manager";
	$user = load_byemail($email);
	$oref = load_byid($user->referral);
	$omgr = load_byid($user->manager);
	$ref = load_byemail($referral);
	$mgr = load_byemail($manager);
	echo "<b><br><br>usr: $user->id $user->email<br>ref: $oref->id $oref->email <br>Mgr: $omgr->id $omgr->email<br></b>";

	if ($user->id == 0) {
		echo "R1 - Invalid User Email";
	} else if ($ref->id ==0 and $mgr->id == 0) {
		echo "R2 - Invalid Referral & Manager";
	} else {
		if ($ref->id == 0) $ref->id = $user->referral;
		if ($mgr->id == 0) $mgr->id = $user->manager;
		$r = $db->query("update tblmember set referral=$ref->id, manager=$mgr->id where id=$user->id") or die("Update ".$db->error);
		echo "<br><br>R3 - Referral & Manager updated<br><br>";
		$usr = load_byid($user->id);
		$ref = load_byid($usr->referral);
		$mgr = load_byid($usr->manager);
		echo "<b><br><br>usr: $usr->email <br>ref: $ref->email <br>Mgr: $mgr->email</b>";
	}
}

function listHelp($email) {
	$user = load_byemail($email);
	echo "Member " . $user->id." ".$user->email ."<br>";
	$ph = $db->query("select * from tblhelp where mem_id = $user->id");
	while ($row = mysqli_fetch_object($ph)) {
		echo "<br>". $row->id ." ". $row->g_date." ".$row->g_amount;
		echo "<br><table width=600>";
		$mavro = $db->query("select * from tblmavro where folio = $row->id");
		while ($row1 = mysqli_fetch_object($mavro)) {
			$user1 = load_user($row1->mem_id);
			$amt = ($row1->op_type=="B"? $row1->real_amount:$row1->future_amount);
			echo "<tr><td>$row1->mem_id</td><td>$row1->op_type</td><td>$user1->email $user1->rank</td><td align=right>$amt</td><td>$row1->comment</td></td></tr>";
		}
		echo "</table>";
	}
	return $user->id;
}

function redateHelp($email,$newdate) {
	$user = load_byemail($email);
	if ($user->id > 0) {
		$ph = $db->query("select * from tblhelp where mem_id = $user->id");
		while ($row = mysqli_fetch_object($ph)) {
			echo "<br>". $row->id ." ". $row->g_date." ".$row->g_amount;
			$r = $db->query("update tblmavro set date_created = '$newdate' where folio = $row->id");
		}
		$r = $db->query("update tblhelp set g_date='$newdate' where mem_id = $user->id");
		echo "<br><br>re-dated";
	} else {
		echo "Invalid Email";
	}

}

function removeHelp($id) {
	$ph = $db->query("select * from tblhelp where mem_id = $id");
	while ($row = mysqli_fetch_object($ph)) {
		echo "<br>". $row->id ." ". $row->g_date." ".$row->g_amount;
		$r = $db->query("delete from tblmavro where folio = $row->id");
	}
	$r = $db->query("delete from tblhelp where mem_id = $id");
	echo "<br><br>REMOVED";

}

function removeHelpE($email) {
	$user = load_byemail($email);
	removeHelp($user->id);
}

function load_byemail($email) {
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
