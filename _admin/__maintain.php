<?
include ("../inc/ggDbconfig.php");

$setup = load_setup();

if ($setup->maintain == '0') {
	$ret = $db->query("update tblsetup set maintain='1'") or die("Setup ".$db->error);
	echo "Maintain is now ON";
} else {
	$ret = $db->query("update tblsetup set maintain='0'") or die("Setup ".$db->error);
	echo "Maintain is now OFF";
}

?>