<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");
include("inc/ggValidate.php");

$debug = false;
$req = ($debug)? $_GET:$_POST;

$act = isset($req['act']) ? $req['act'] : "";
$mavro = isset($req['mavro']) ? $req['mavro'] : "";
$amount = isset($req['amount']) ? $req['amount'] : 0;

$ghtype = ggGhType($mavro);

if ($act =="") {
	echo json_encode(array("status"=>"fail","msg"=>"Invalid Action"));
	exit;
} else if ($ghtype['status']=="fail") {
	echo json_encode($ghtype);
	exit;
}

$ls = new stdclass();
$ls->gh_type[0] = array("Help Bonus","互助奖金","互助獎金");
$ls->gh_type[1] = array("Referral Bonus","推荐奖金","推薦獎金");
$ls->gh_type[2] = array("Manager Bonus","经理奖金","經理獎金");
$ls->gh_type[3] = array("Level Bonus","代数奖金","代數獎金");
$ls->gh_type[4] = array("Senior Manager Bonus","高级经理奖金","高級經理獎金");

$ghdesc = $ls->gh_type[$ghtype['ctr']][$lang];

$ls->min = array("Minimum $ghdesc Amount ".$ghtype['min'],"$ghdesc ".$ghtype['min']." 起提","$ghdesc ".$ghtype['min']." 起提");
$ls->max = array("Maximum $ghdesc Amount ".$ghtype['max'],"$ghdesc ".$ghtype['max']." 封顶","$ghdesc ".$ghtype['max']." 封頂");
$ls->multi = array("$ghdesc must be multiple of ".$ghtype['multiple'],"$ghdesc 必须是 ".$ghtype['multiple']." 的倍数","$ghdesc 必須是 ".$ghtype['multiple']." 的倍數");
$ls->count = array("Can not have more than ".$ghtype['count']." pending $ghdesc"," 不能有超过 ".$ghtype['count']." 个未完成的$ghdesc","不能有超過".$ghtype['count']." 未完成的$ghdesc");
$ls->amount = array("Invalid $ghdesc Amount","$ghdesc 金额错误","$ghdesc 金額錯誤");
$ls->amount_bal = array("You dont have that much $ghdesc","$ghdesc 余额不足","$ghdesc 餘額不足");
$ls->amount_req = array("$ghdesc Amount can not be blank","$ghdesc 金额不能为空","$ghdesc 金額不能為空");

$id = $user->id;
if ($ghtype['ctr']==0) {
	$amt_max	= ggFetchValue("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='B'");
} else if ($ghtype['ctr'] == 1) {
	$amt_max	= ggFetchValue("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='R'");
} else if ($ghtype['ctr'] == 2) {
	$amt_max 	= ggFetchValue("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='M' and op_level=1");
} else if ($ghtype['ctr'] == 3) {
	$amt_max  = ggFetchValue("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='M' and op_level>1");
}

$count   		= ggFetchValue("select count(id) as icount from tblhelp where mem_id = $id and g_type='G' and status<>'X' and status <>'D' and note='$mavro'" );

$now = new DateTime("NOW");

if ($amount > 0 && doubleval($amount) % doubleval($ghtype['multiple']) == 0) {
	$multiple = 0;
} else {
	$multiple = 1;
}
$v = new FormValidator();
$v->addValidation(1,$amount,"gt=0",$ls->amount_req[$lang]);
$v->addValidation(2,$amount,"min=".$ghtype['min'],$ls->min[$lang]);
if ($ghtype['max']<>"") {
	$v->addValidation(3,$amount,"max=".$ghtype['max'],$ls->max[$lang]);
}
$v->addValidation(4,$count,"lt=".$ghtype['count'],$ls->count[$lang]);
$v->addValidation(5,$multiple,"lt=1",$ls->multi[$lang]);
$v->addValidation(6,$amount,"max=".$amt_max,$ls->amount_bal[$lang]);
if ($ghtype['count']>0) {
	$v->addValidation(7,$count,"lt=".$ghtype['count'],$ls->count[$lang]);
}
if (!$v->ValidateForm()) {
  $ret = array("status"=>"fail", "msg"=>$v->getError());
} else {
		$res = $db->query("INSERT INTO `tblhelp` (id,g_type,mem_id,mgr_id,g_date,g_plan,g_amount,g_pending,status,reentry,date_match,date_close,note)
			VALUES( null, 'G', $id, 0,'".$now->format('Y-m-d H:i:s')."','".$ghtype['code']."', $amount, $amount, 'O', 1, '0000-00-00', '0000-00-00', '$mavro')") or die('Could not connect: ' . $db->error);
		$gID = mysqli_insert_id($db);

		if ($mavro == "deposit") {
			$rs = $db->query("INSERT INTO  tblmavro (id,mem_id,email,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr)
				VALUES (NULL, $id, '', 'C',  'B','".$now->format('Y-m-d H:i:s')."',0,  '1', 4, -$amount,  -$amount, -$amount,  'From $mavro',  '$gID',0,0,0)") or die("Mavro 1 ". $db->error);
			$rs = $db->query("update tblmavro set date_close ='".$now->format('Y-m-d H:i:s')."' where mem_id=$user->id and wallet=1 and type='C' and date_close='0000-00-00 00:00:00'");
		} else {
			$rs = $db->query("INSERT INTO  tblmavro (id,mem_id,email,type,op_type,date_created,release_days,category,wallet,real_amount,nominal_amount,future_amount,comment,help_id,plan,bonus,ctr)
				VALUES (NULL, $id, '', 'C',  '".$ghtype['code']."','".$now->format('Y-m-d H:i:s')."',0,  '1', 4, -$amount,  -$amount, -$amount,  'From $mavro',  '$gID',0,0,0)") or die("Mavro 1 ". $db->error);
		}
		$ret = array('status' => "success","msg"=>"success");
}
echo json_encode($ret);


function ggGhType($ghtype) {
  global $db, $user, $setup, $req;

  $msg = "";
	if ($ghtype=="") $msg = "Invalid ghtype";
  else {
    $ghlist = explode(",",$setup->ghlist);
    $j = count($ghlist);
    for ($i=0;$i<$j;$i++) {
      if ($ghtype == $ghlist[$i]) break;
    }
    if ($i==$j) $msg = "Invalid ghtype";
    else {
      $ghmin = explode(",",$setup->ghmin);
      $ghmax = explode(",",$setup->ghmax);
      $ghmultiply = explode(",",$setup->ghmultiple);
      $ghcount = explode(",",$setup->ghcount);
      $code = strtoupper(substr($ghtype,0,1));
      $ret = array("status"=>"success","ctr"=>$i,"type"=>$ghtype,"code"=>$code,"min"=>$ghmin[$i],"max"=>$ghmax[$i],"multiple"=>$ghmultiply[$i],"count"=>$ghcount[$i]);
    }
  }
  return ($msg=="")? $ret:array("status"=>"fail","msg"=>$msg);
}

?>