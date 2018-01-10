<?
	include("inc/ggDbconfig.php");
	include("inc/ggFunctions.php");

	$mavro = isset($_REQUEST['mavro']) ? $_REQUEST['mavro'] : "";
	$amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : 0;

	$user = load_user(0);
	$id = $user->id;

    $deposit    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='B'");
    $referral   = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='R'");
    $manager    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='M' and op_level=1");
    $levels     = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='M' and op_level>1");
    $help       = ggFetchObject("select count(id) as icount from tblhelp where mem_id = $id and g_type='G' and status<>'X' and status <>'D'" );

	$now = new DateTime("NOW");
	if ($amount < 100 || $amount =="") {
		$result = array("msg" =>"金额必需 >= RMB 100");

	} else if ($mavro == "deposit" && $deposit->amt > 0 && $amount <= $deposit->amt) {
	    $help = ggFetchObject("select count(id) as icount from tblhelp where mem_id = $id and g_type='G' and status<>'X' and status <>'D' and note='deposit'" );
		if ($help->icount > 0) {
   			$result = array("msg" =>"只能有一个未完成的接受幫助");
		} else if ($amount > 0 and intval($amount/100) <> $amount/100) {
			$result = array("msg" =>"金额必需是 RMB 100 的倍数");
   		} else {
			$res = $db->query("INSERT INTO `tblhelp` (id,g_type,mem_id,mgr_id,g_date,g_plan,g_amount,g_pending,status,reentry,date_match,date_close,note)
				VALUES( null, 'G', $id, 0,'".$now->format('Y-m-d H:i:s')."','D', $amount, $amount, 'O', 1, '0000-00-00', '0000-00-00', 'deposit')") or die('Could not connect: ' . $db->error);
			$gID = mysqli_insert_id();
			$rs = $db->query("INSERT INTO  tblmavro (id,mem_id,email,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr)
				VALUES (NULL, $id, '', 'C',  'B','".$now->format('Y-m-d H:i:s')."',0,  '1', 4, -$amount,  -$amount, -$amount,  'From Deposit',  '$gID',0,0,0)") or die("Mavro 1 ". $db->error);
			$rs = $db->query("update tblmavro set date_close ='".$now->format('Y-m-d H:i:s')."' where mem_id=$user->id and wallet=1 and type='C' and date_close='0000-00-00 00:00:00'");
			$result = array('success' => 1);
   		}
	} else if ($mavro =="referral" && $referral->amt > 0 && $amount <= $referral->amt) {
	    $help = ggFetchObject("select count(id) as icount from tblhelp where mem_id = $id and g_type='G' and status<>'X' and status <>'D' and note='referral'" );
	    $thelp = ggFetchObject("select sum(g_amount) as iamt from tblhelp where mem_id = $id and g_type='G' and status<>'X' and note='referral'" );
		if ($help->icount > 0) {
   			$result = array("msg" =>"只能有一个未完成的推荐奖提现");
	   	} else if ($amount > 0 and intval($amount/50) <> $amount/50) {
			$result = array("msg" =>"推荐奖金额必需是 RMB 50 的倍数");
	   	} else if ($amount < 1750 && $thelp->iamt < 1750) {
			$result = array("msg" =>"推荐奖金第一次必需是 USD 250 (RMB 1750) 以上");
		} else {
			$res = $db->query("INSERT INTO `tblhelp` (id,g_type,mem_id,mgr_id,g_date,g_plan,g_amount,g_pending,status,reentry,date_match,date_close,note)
				VALUES( null, 'G', $id, 0,'".$now->format('Y-m-d H:i:s')."','R', $amount, $amount, 'O', 1, '0000-00-00', '0000-00-00', 'referral')") or die('Could not connect: ' . $db->error);
			$gID = mysqli_insert_id();
			$rs = $db->query("INSERT INTO  tblmavro (id,mem_id,email,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr)
				VALUES (NULL, $id, '', 'C',  'R','".$now->format('Y-m-d H:i:s')."',0,  '1', 4, -$amount,  -$amount, -$amount,  'From Referral',  '$gID',0,0,0)") or die("Mavro 1 ". $db->error);
			$result = array('success' => 1);
		}
	} else if ($mavro =="manager" && $manager->amt > 0 && $amount <= $manager->amt) {
	    $help = ggFetchObject("select count(id) as icount from tblhelp where mem_id = $id and g_type='G' and status<>'X' and status <>'D' and note='manager'" );
		if ($help->icount > 0) {
   			$result = array("msg" =>"只能有一个未完成的经理奖提现");
	   	} else if ($amount > 0 and intval($amount/50) <> $amount/50) {
			$result = array("msg" =>"经理奖金额必需是 RMB 50 的倍数");
	   	} else if ($amount > 7000 && $user->rank<=6) {
			$result = array("msg" =>"经理奖金周封顶是 RMB 7000");
	   	} else if ($amount > 14000 && $user->rank==7) {
			$result = array("msg" =>"高级经理奖金周封顶是 RMB 14000");
   		} else {
			$res = $db->query("INSERT INTO `tblhelp` (id,g_type,mem_id,mgr_id,g_date,g_plan,g_amount,g_pending,status,reentry,date_match,date_close,note)
				VALUES( null, 'G', $id, 0,'".$now->format('Y-m-d H:i:s')."','M', $amount, $amount, 'O', 1, '0000-00-00', '0000-00-00', 'manager')") or die('Could not connect: ' . $db->error);
			$gID = mysqli_insert_id();
			$rs = $db->query("INSERT INTO  tblmavro (id,mem_id,email,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr)
				VALUES (NULL, $id, '', 'C',  'M','".$now->format('Y-m-d H:i:s')."',0,  '1', 4, -$amount,  -$amount, -$amount,  'From Manager',  '$gID',0,0,0)") or die("Mavro 1 ". $db->error);
			$result = array('success' => 1);
		}
	} else {
		$result = array('msg' => "金額錯誤");
	}
	echo json_encode($result);
?>