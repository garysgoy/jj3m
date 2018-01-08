<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$rs = $db->query("select * from tblemail_m");
$ctr = 1;
while ($row = mysqli_fetch_object($rs)) {
	if ($mem = ggFetchObject("select * from tblmember where email = '$row->email'")) {
		echo "<br>$ctr $row->email $mem->id $mem->nickname $mem->bankaccount $mem->bankholder";
		if($help = ggFetchObject("select * from tblhelp where mem_id = $mem->id order by g_date limit 0,1")) {
			echo "  <b>$help->id $help->g_date $help->g_amount</b><br>";
			$upd = $db->query("update tblhelp set priority = 1 where id = $help->id");
		}
	} else {
		echo "<br><b font-color=red>$ctr $row->email</b>";
	}
	$ctr++;
}
?>