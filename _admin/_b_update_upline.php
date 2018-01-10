<?
include("../inc/ggDbconfig.php");

$rs = $db->query("select * from tblmember");
while ($row = mysqli_fetch_object($rs)) {
	$ref = load_user($row->referral);
	$mgr = load_user($row->manager);
	$tt = $db->query("update tblmember set ref_name='$ref->username', mgr_name='$mgr->username' where id = $row->id");
}
?>