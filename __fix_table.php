<?
include("inc/ggDbconfig.php");

$db->query("ALTER TABLE `tblmember` ADD `btc` VARCHAR(40) NULL DEFAULT NULL AFTER `whatsapp`, ADD `eth` VARCHAR(40) NULL DEFAULT NULL AFTER `btc`;") ;
if ($db->error=="") {
  echo "tblmember Success - add btc";
} else {
  echo "tblmember ".$db->error;
}
echo "<br>";

$db->query("ALTER TABLE `tblsetup` ADD `china_bank` INT(1) NULL DEFAULT '0' AFTER `phone_len`, ADD `btc` INT(1) NOT NULL DEFAULT '' AFTER `china_bank`;");
if ($db->error=="") {
  echo "tblsetup Success - add china_bank";
} else {
  echo "tblsetup ".$db->error;
}
echo "<br>";

$db->query("ALTER TABLE `tblsetup` ADD `eth` VARCHAR(40) NOT NULL DEFAULT '' AFTER `btc`;");
if ($db->error=="") {
  echo "tblsetup Success - add eth";
} else {
  echo "tblsetup ".$db->error;
}


echo "<br>";

$db->query("ALTER TABLE `tblsetup` ADD `use_captcha` INT(1) NULL DEFAULT '1' AFTER `eth`;");
if ($db->error=="") {
  echo "tblsetup Success - add use_captcha";
} else {
  echo "tblsetup ".$db->error;
}


