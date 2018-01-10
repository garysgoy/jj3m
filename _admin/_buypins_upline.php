<?
include ("../inc/ggDbconfig.php");
include ("../inc/ggFunctions.php");

$mem = isset($_REQUEST['mem']) ? strval($_REQUEST['mem']) : 100;
$mgr = ggFetchObject("select * from tblmember where id = $mem") or die("Select ".$db->error);

$rank = $mgr->rank;
while ($rank <> 0 and $rank <> 6) {
	echo $mgr->id." ";
	$mgr = ggFetchObject("select * from tblmember where id=$mgr->manager");
	$rank = $mgr->rank;
}

echo "<br>$mgr->id $mgr->email $mgr->rank $mgr->pin";
//echo json_encode($rows);
?>