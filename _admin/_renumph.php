<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

// Renumber PH to remove jumping numbers
// Need to run dashboard_rph.php for commission recalculation

$rs = $db->query("select * from tblhelp order by id");
$i = 1;
while ($row = mysqli_fetch_object($rs)) {
	echo "<br>$i";
	$db->query("update tblhelp set id = $i where id = $row->id") or die ("Err ID ".$db->error);
	$i += 1;
}
// Reset Auto Couter
$tt = $db->query("ALTER TABLE  `tblhelp` AUTO_INCREMENT =1");
?>