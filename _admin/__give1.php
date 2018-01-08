<?php
include("../_util.php");
include("__util.php");


	$amt = rand(10,77)*100;
	$mem_id = rand(11,30);

	$res = ggPH($mem_id,$amt);
echo "<br><br>";
gStatus();

function ggAddMavro($mem_id,$amount) {
	$now = new DateTime("NOW");
	$now1 = clone $now;
	$now1->modify("+14 day");
	$amount1 = $amount * 0.95 * 1.14;
	$userinfo = load_userinfo($mem_id);
	$username = $userinfo['username'];

	$rs = $db->query("INSERT INTO  tblmavro (id,username,type,op_type,date_created,release_days,category,real_amount,nominal_amount,future_amount,comment,folio)
		VALUES (NULL, '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."',14,  '1',  $amount,  $amount,  $amount1,  '',  '')") or die("Mavro ". $db->error);
}


function ggPH($mem_id,$amt) {
	$now = new DateTime("NOW");

	$rs = $db->query("select * from tblhelp where g_type = 'P' and mem_id=$mem_id and status <> 'C'");
	if (mysqli_num_rows($rs)==0) {
		$res = $db->query("INSERT INTO `tblhelp` (id, g_type, mem_id, mgr_id, g_date,g_plan,g_amount,g_pending,status,reentry,date_close,note)
			VALUES ( null, 'P', $mem_id,0, '".$now->format('Y-m-d H:i:s')."','P1', $amt, $amt, 'O', 1, '0000-00-00', '')") or die('Add Error: ' . $db->error);
		$gID = mysqli_insert_id();
		echo "Provide Help - Record $gID, User $mem_id, Amount $amt";
		$res = ggPH1($gID, $mem_id,$amt,$now);
	}else {
		echo "Duplicated ID not ok";
	}
}

function ggPH1($gID, $mem_id, $amount,$now) {
	$ref = 0.1;
	$mgr1 = 0.05;
	$mgr2 = 0.03;
	$mgr3 = 0.01;

	//$now = new DateTime($now);
	$now1 = clone $now;
	$now1->modify("+14 day");
	$amount1 = $amount * 0.95 * 1.14;
	$user = load_user($mem_id);
	$username = $user->email;

	// Member
	$rs = $db->query("INSERT INTO  tblmavro (id,mem_id,email,`type`,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,folio)
		VALUES (NULL, '$mem_id', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."',14,  '1', 1,  $amount,  $amount,  $amount1,  '',  '$gID')") or die("Mavro 1 ". $db->error);
	/*
    // Referrer
	$amt = $amount * $ref;
	$mem = mysqli_fetch_object($db->query("select * from tblMember where id = $mem_id"));
	$rs = $db->query("INSERT INTO  tblMavro (id,mem_id,username,`type`,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,folio)
		VALUES (NULL, '$mem->ref', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."',0,  '1',2,  0,0,  $amt,  '',  '$gID')") or die("Mavro 2 ". $db->error);

	// Manager 1
	if ($mem->leader1 > 0) {
		$amt = $amount * $mgr1;
		$rs = $db->query("INSERT INTO  tblMavro (id,mem_id,username,`type`,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,folio)
			VALUES (NULL, '$mem->leader1', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."',0,  '1', 3,0,0,  $amt,  '',  '$gID')") or die("Mavro 3 ". $db->error);
	}

	// Manager 2
	if ($mem->leader2 > 0) {
		$amt = $amount * $mgr2;
		$rs = $db->query("INSERT INTO  tblMavro (id,mem_id,username,`type`,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,folio)
			VALUES (NULL, '$mem->leader2', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."',0,  '1',3,  0,0,  $amt,  '',  '$gID')") or die("Mavro 4 ". $db->error);
	}

	// Manager 3
	if ($mem->leader3 > 0) {
		$amt = $amount * $mgr3;
		$rs = $db->query("INSERT INTO  tblMavro (id,mem_id,username,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,folio)
			VALUES (NULL, '$mem->leader3', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."',0,  '1',3,  0,0,  $amt,  '',  '$gID')") or die("Mavro 5 ". $db->error);
	}
	*/
}

?>
