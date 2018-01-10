<?
include("../inc/ggDbconfig.php");

$a = List_1(); // Switch Referral / Manager



function list_1() {
	$rs = $db->query("select * from tblaccesslog order by id desc limit 0,100");
	echo "<table width=700 border=1 cellspacing=0>";
	echo "<tr><td>id</td><td>email</td><td>date</td><td>success</td></tr>";
	$i = 1;
	while ($row = mysqli_fetch_object($rs)) {
		echo "<tr><td>$row->id</td><td>$row->email</td><td>$row->date</td><td>$row->success $row->str</td></tr>";
		$i++;
	}
	echo "</table>";
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