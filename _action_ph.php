<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");
include("inc/ggValidate.php");

$debug = false;
$req = ($debug)? $_GET:$_POST;

$amount = $req['HelpAmount'];
$password2_5 = md5($req['pass2']);

$pin_bal = ggPinCount();
$pin_req = ggPhPin($amount);
$password2 = ggFetchValue("select password2 from tblmember where id=$user->id");

$ls = new stdClass();
$ls->amount_inlist = array("Amount Error","金额错误","金額錯誤");
$ls->pin_gt = array("Insufficient Que Pin. Required=$pin_req, Balance=$pin_bal","排单币余额不足,需要 $pin_req 个, 你只有 $pin_bal 个","排單筆餘額不足, 需要 $pin_req, 你只有 $pin_bal 個");
$ls->phdays_gt0 = array("You need to wail till previous order complete","上次挂单还没有完成","上次掛單還沒有完成");
$ls->phdays_gt1 = array("You need ","距离上次挂单还没有超过","距離上次掛單還沒有超過");
$ls->phdays_gt2 = array(" days gap to make another help","天","天");
$ls->success = array("Success","操作成功","操作成功");
$ls->password2_eq = array("Invalid second password","二级密码错误","二級密碼錯誤");

$now = new datetime("now");
$hour = $now->format("H");
$min = $now->format("i");

$g_date = ggFetchValue("select g_date from tblhelp where mem_id=$user->id and g_type='P' and status<>'X' and status<>'C' order by id desc limit 0,1");
if ($g_date == "") {
	$days = 100;
} else {
	$date = new datetime($g_date);
	$days = ggDaysDiff($date);
}

$v = new FormValidator();
//$v->addValidation(1,$password2_5,"eq=".$password2,$ls->password2_eq[$lang]);
$v->addValidation(2,$amount,"inlist=".$setup->phlist,$ls->amount_inlist[$lang]);
if ($days<100) {
	if ($setup->phdays == 99) {
		$v->addValidation(3,$days,"ge=".$setup->phdays,$ls->phdays_gt0[$lang]);
	} else {
		$v->addValidation(3,$days,"ge=".$setup->phdays,$ls->phdays_gt1[$lang].$setup->phdays.$ls->phdays_gt2[$lang]);
	}
}
$v->addValidation(4,$pin_bal,"ge=".$pin_req,$ls->pin_gt[$lang]);

if (!isset($req['act']) || $req['act'] != "PH") {
	$ret = array("status"=>"fail","msg"=>"Invalid Action");
} else if (!$v->ValidateForm()) {
  $ret = array("status"=>"fail", "msg"=>$v->getError());
} else {
	$plan="1";
	$user_id = $user->id;
	$gID = ggPH($user_id,$amount,$plan,$pin_req);
	ggAccessLog1($user->username,"PH","$gID $amount $plan");

	$ret = array("status"=>"success","msg"=>$ls->success[$lang]);
}
echo json_encode($ret);


function ggPH($mem_id,$amt,$plan,$pins) {
	global $setup,$db;
	$now = new DateTime("NOW");
	$user = load_user($mem_id);

	$hlp = ggFetchObject("select id from tblhelp order by id desc limit 1");
//	if ($hlp=="" or $hlp->id < 1) {
//		$hlp->id=0;
//	}

	//$nid = $hlp->id + 1;
	$nid = $hlp->id + rand(1,1);
	$res = $db->query("INSERT INTO `tblhelp` (id, g_type, mem_id, mgr_id, g_date, g_plan, g_amount, g_pending, status, reentry, date_match, date_close, note) VALUES
						($nid, 'P', $mem_id, $user->manager, '".$now->format('Y-m-d H:i:s')."', $plan, $amt, $amt, 'O', 1, '0000-00-00', '0000-00-00', '')") or die("Insert Help: ".$db->error);
	$gID = $db->insert_id;

  if ($pins >0) {
    $rs = $db->query("select pin from tblpin2 where managerid = $user->id and status='N' limit $pins");
    while ($row = mysqli_fetch_object($rs)) {
      $rs1 = $db->query("update tblpin2 set status='U',usedate=now(), useby = '$gID' where managerid=$user->id and pin='$row->pin'");
    }
  }
	$res = ggPH1($gID, $mem_id,$amt,$now,$plan);

	return $gID;
}

function ggPH1($gID, $mem_id, $amount,$now,$plan) {
  global $db;
  $setup = load_setup();

  // Manager Bonus after L5 Unlimited
  $mbonus = array(0.06,0.03,0.01,0.0025,0.001);

  // Manager Bonus Manager>= 7 after L6 Unlimited
  $mbonus1 = array(0.06,0.03,0.02,0.01,0.0025,0.001);

  $user = load_user($mem_id);

  $phcount = mysqli_num_rows($db->query("select id from tblmavro where mem_id = $mem_id and wallet=1"));

  $phcount1 = mysqli_num_rows($db->query("select id from tblmavro where mem_id = $mem_id and wallet=1 and date_created >= '2015-11-10'"));
  if ($phcount=="" || $phcount==0) {
    $rebate = $setup->pinrebate;
  }
  if ($phcount1=="" || $phcount1==0) {
    $refer = 0.05;
    $refer1 = 0;
    $ctr = 1;
  } else {
    $refer = 0.05;
    $refer1 = 0.00;
    $rebate = 0;
    $ctr=$phcount+1;
  }
  //$now = new DateTime($now);
  $now1 = clone $now;
  if ($plan==1) {
    $now1->modify("+15 day");
    $amount1 = $amount * (1.00 + $refer1) + $rebate;
    $rel = 15;
  } else if ($plan==15) {
    $now1->modify("+15 day");
    $amount1 = $amount * (1.10 + $refer1) + $rebate;
    $rel = 15;
  } else if ($plan==30) {
    $now1->modify("+30 day");
    $amount1 = $amount * (1.35 + $refer1) + $rebate;
    $rel = 30;
  }
  $bonus = $amount*$refer1 + $rebate;
  $user = load_user($mem_id);
  $username = $user->username;

  // Member
  if ($plan==1) {
    $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,date_release, release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr,incentive)
      VALUES (NULL, '$mem_id', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."','0000-00-00',$rel,  '1', 1,  $amount,  $amount,  $amount1,  '$username',  '$gID',$plan,$bonus,$ctr,0)") or die($db->error);
  } else {
    $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,date_release, release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr,incentive)
      VALUES (NULL, '$mem_id', '$username', 'U',  'B','".$now->format('Y-m-d H:i:s')."','".$now1->format('Y-m-d H:i:s')."',$rel,  '1', 1,  $amount,  $amount,  $amount1,  '$username',  '$gID',$plan,$bonus,$ctr,0)") or die("Mavro 1 ". $db->error());
  }

//    Repeat Sales have Referral & Manager Bonus
//    Taiwan dont pay, jj3m pay
//    if ($phcount1 == 0) {
      // Referrer
    $amt = $amount * $refer;
    $mem = mysqli_fetch_object($db->query("select * from tblmember where id = $mem_id"));
    if ($mem->referral >0 && $amt >0) {
      $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,incentive)
        VALUES (NULL, '$mem->referral', '$username', 'U',  'R','".$now->format('Y-m-d H:i:s')."',0,  '1',2,  0,$amount,  $amt,  '$username',  '$gID',0)") or die("Mavro 2 ". mysqli_error($db_comm));
    }

    // Manager
    $i = 0;
    $i1 = 0;
    $op_level = 1;
    $op_level1 = 1;
    While ($mem->manager > 0) {
      $amt = $amount * $mbonus[$i];
//      $amt1 = $amount * $mbonus1[$i1];
      $amt1 = $amount * $mbonus1[$i];
      $mgr = load_user($mem->manager);
      if ($mgr->rank>=7) {
//        $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,op_level,incentive)
//          VALUES (NULL, '$mem->manager', '$username', 'U',  'M','".$now->format('Y-m-d H:i:s')."',0,  '1', 3,0,$amount,  $amt1,  '$username',  '$gID',$op_level1,0)") or die("Mavro 3 ". mysqli_error($db_comm));
        $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,op_level,incentive)
          VALUES (NULL, '$mem->manager', '$username', 'U',  'M','".$now->format('Y-m-d H:i:s')."',0,  '1', 3,0,$amount,  $amt1,  '$username',  '$gID',$op_level,0)") or die("Mavro 3 ". mysqli_error($db_comm));
        if ($i1 < 6) $i1 += 1;
        $op_level1 += 1;
      } else {
        $rs = $db->query("INSERT INTO  tblmavro (id,mem_id,username,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,op_level,incentive)
          VALUES (NULL, '$mem->manager', '$username', 'U',  'M','".$now->format('Y-m-d H:i:s')."',0,  '1', 3,0,$amount,  $amt,  '$username',  '$gID',$op_level,0)") or die("Mavro 3 ". mysqli_error($db_comm));
      }
      if ($i < 5) $i += 1;
      $op_level += 1;
      $mem = mysqli_fetch_object($db->query("select * from tblmember where id = $mem->manager"));
    }
//  } Repeat Comm
}

function ggPhPin($amt) {
  global $setup;
  $ret = 0;
  if ($setup->phpin<>"") {
    $phlist = explode(",",$setup->phlist);
    $phpin = explode(",",$setup->phpin);
    $ctr = count($phlist);
    $i = 0;
    while ($i < $ctr) {
      if ($phlist[$i]==$amt) {
        break;
      }
      $i = $i + 1;
    }
    $ret = $phpin[$i];
  }
  return $ret;
}
?>