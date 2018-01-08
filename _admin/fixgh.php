<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

fix1();
fix2();

function fix1() {
	// Remove Error GH
	$rs = $db->query("select * from tblhelp where g_type='G' and status<>'X' and status<>'D'");

	$i = 0;
	while ($row = mysqli_fetch_object($rs)) {
		$tt = ggFetchObject("select count(help_id) as cc from tblmavro where help_id = $row->id and wallet=4");
		if ($tt->cc > 0) {
			//echo "<br>Good $row->id $row->g_date $row->g_amount $tt->mem_id";
		} else {
			$i++;
			$user = load_user($row->mem_id);
			echo "<br>$i $row->id $row->g_date $row->g_amount $row->mem_id $user->email";
			$db->query("delete from tblhelp where id=$row->id");
		}
	}
}

function fix2() {
	// Set Dates
	$rs = $db->query("select * from tblmavro where wallet=4 and comment='From Deposit' order by mem_id, id");

	$idlist = array();
	$mem_id = 0;
	while ($row = mysqli_fetch_object($rs)) {
		if ($mem_id <> $row->mem_id) {
			$mem_id = $row->mem_id;
			$tt = $db->query("update tblmavro set date_close = '$row->date_created' where mem_id = $row->mem_id and wallet=1 and type='C'") or die("Uodate: ".$db->error);
		} else {
			$user = load_user($row->mem_id);
			$help = ggFetchObject("select * from tblhelp where id=$row->help_id");
			if ($help->status == "O") {
				array_push($idlist, $row->help_id);
				echo "<br>$row->help_id $row->mem_id $user->email $row->nominal_amount $help->status";
			}
		}
	}

	$count = count($idlist);

	for ($i=0;$i<$count;$i++) {
		$rs1 = $db->query("delete from tblhelp where  id = '".$idlist[$i]."'") or die("help: ".$db->error);
		$rs2 = $db->query("delete from tblmavro where help_id = '".$idlist[$i]. "' order by id") or die("Mavro : ".$db->error);
	}

}
?>