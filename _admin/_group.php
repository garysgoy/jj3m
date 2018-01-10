<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$rs = $db->query("select * from tblmember where email='mmm.rayzie@gmail.com' or email='dzull182@yahoo.com.my' or email='mmm.rayzie@gmail.com' or email='mmm.rayzie@gmail.com'");
$ctr = 1;

while ($row = mysqli_fetch_object($rs)) {
	echo "<br>$row->email</b>";
	if ($rr = $db->query("select * from tblmember where referral=$row->id")) {
		while ($row1 = mysqli_fetch_object($rr)) {
			echo "<br>$row1->email";
			$ctr++;
			getDirects($row1->id);
		}
	}
}

function getDirects($id) {
	global $ctr;
	$rs1 = $db->query("select * from tblmember where referral=$id");
	while ($ref = mysqli_fetch_object($rs1)) {
		echo "<br>$ref->email";
		$ctr++;
	}
}

?>