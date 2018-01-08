<?php
include("../_util.php");
include("__util.php");


	$now = new DateTime("NOW");

	$amt = rand(1,77)*100;
	$mem_id = rand(11,30);
	$rs = $db->query("select * from tblhelp where g_type = 'G' and mem_id=$mem_id and status <> 'C'");
	if (mysqli_num_rows($rs)==0) {
		$res = $db->query("INSERT INTO `tblhelp` (id,g_type,mem_id,mgr_id,g_date,g_plan,g_amount,g_pending,status,reentry,date_match,date_close,note)
			VALUES( null, 'G', $mem_id, 0,'".$now->format('Y-m-d H:i:s')."','P2', $amt, $amt, 'O', 1, '0000-00-00', '0000-00-00', '')") or die('Could not connect: ' . $db->error);
		$gID = mysqli_insert_id();
		echo "Get Help - Record $gID, User $mem_id, Amount $amt";
	} else {
		echo "Duplicated ID not ok";
	}

	echo "<br><br>";
    gStatus();

?>