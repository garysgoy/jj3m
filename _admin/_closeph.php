<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");


//$rr = $db->query("update tblhelp set status='C' where status = 'D'")  or die($db->error);

$idlist = array();
$rs = $db->query("select * from tblhelp where status = 'C'") or die($db->error);
while ($row = mysqli_fetch_object($rs)) {
	$sum = ggFetchObject("select sum(g_amount) as amt from tblhelpdetail where help_id = $row->id and stage = 2");
	if ($sum->amt == $row->g_amount) {
		array_push($idlist, $row->id);
	} else {
		echo "<br>$row->id $row->mem_i  $row->g_amount  - $sum->amt";
	}
}

$count = count($idlist);
echo "<br>Count = $count<br><br>";

for ($i=0;$i<$count;$i++) {
//	echo $idlist[$i]." ";
	$rs1 = $db->query("update tblhelp set status='D' where id = '".$idlist[$i]."'") or die("help: ".$db->error);
	$rs2 = $db->query("select * from tblmavro where help_id = '".$idlist[$i]. "' order by id") or die("Mavro : ".$db->error);
	$op_level = 0;
	while ($row = mysqli_fetch_object($rs2)) {
		if ($row->op_type == "M") {
			$op_level += 1;
		}
		$tt = $db->query("update tblmavro set `type`='C', date_release = now(), op_level = $op_level where id = $row->id") or die($db->error);
	}
}
echo "<br>";
//print_r($idlist);
?>