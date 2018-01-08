<?
	include("../_dbconfig.php");
	$rs = $db->query("ALTER TABLE  `tblmavro` ADD  `date_release` DATETIME NOT NULL DEFAULT  '0000-00-00', ADD  `op_level` INT NOT NULL DEFAULT  '0'") or die("err ". $db->error);

?>