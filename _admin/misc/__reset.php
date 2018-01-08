<?
include("../_util.php");
include("__util.php");

$res = $db->query("truncate table tblHelp") or die("Err ".$db->error);
$res = $db->query("truncate table tblHelpDetail") or die("Err ".$db->error);
$res = $db->query("truncate table tblMavro") or die("Err ".$db->error);

echo "Done";
?>
