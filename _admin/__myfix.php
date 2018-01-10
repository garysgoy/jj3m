<?
include("../inc/ggDbconfig.php");

$rs = $db->query("ALTER TABLE  `tblpinlog` ADD  `leader` VARCHAR( 2 ) NOT NULL , ADD INDEX (  `leader` );") or die ("Log: ".$db->error);
echo "Fix Done";
?>