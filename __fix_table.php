<?
include("_dbconfig.php");

$db->query("ALTER TABLE `tblmember` ADD `btc` VARCHAR(40) NULL DEFAULT NULL AFTER `whatsapp`, ADD `eth` VARCHAR(40) NULL DEFAULT NULL AFTER `btc`;") ;
if ($db->error=="") {
  echo "tblmember Success";
} else {
  echo "tblmember ".$db->error;
}
echo "<br>";

$db->query("ALTER TABLE `tblsetup` ADD `china_bank` INT(1) NULL DEFAULT '0' AFTER `phone_len`, ADD `btc` INT(1) NOT NULL DEFAULT '1' AFTER `china_bank`;");
if ($db->error=="") {
  echo "tblsetup Success";
} else {
  echo "tblsetup ".$db->error;
}


