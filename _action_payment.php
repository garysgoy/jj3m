<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");
include("inc/ggValidate.php");
//include("_sms.php");

$debug=false;
$req = ($debug)? $_GET:$_POST;

$act = $req['act'];
$hash = $req['hash'];
$message = $req['message'];
$help_id = $req['hid'];

$ls = new stdClass();
$ls->hash_req = array("Hash key can not be blank","哈希值不能为空","哈希值不能為空");
$ls->helpid_req = array("Hash key can not be blank","哈希值不能为空","哈希值不能為空");

$v = new FormValidator();
$v->addValidation(1,$hash,"req",$ls->hash_req[$lang]);

if (!isset($req['act']) || $req['act'] != "payment") {
  $ret = array("status"=>"fail","msg"=>"Invalid Action");
}else if (!isset($req['hid']) || $req['hid'] < 1) {
  $ret = array("status"=>"fail","msg"=>"Invalid Help ID");
} else if (!$v->ValidateForm()) {
  $ret = array("status"=>"fail","msg"=>$v->getError());
} else {
  $now = new DateTime("NOW");

  $tran = ggFetchObject("select * from tblhelpdetail where id = $help_id");
  $future_date = new DateTime($tran->g_timer);

  $s_future_date = ggDateToString($future_date);
  $interval = $now->diff($future_date);

  $hours = $interval->format("%d") * 24 + $interval->format("%h");

  $incentive = 0;
  if ($incentive > 0) {
      $inct = "<b class='green'>".$ls->reward1[$lang] ." ". $incentive."%</b>";
  } else if ($incentive < 0) {
      $inct = "<b class='red'>".$ls->reward2[$lang] ." ". $incentive."%</b>";
  } else {
      $inct = "";
  }

  $s_now = ggDateToString($now);
  $timer = ggAddHours($now,24);
  $s_timer = ggDateToString($timer);

  $rs = $db->query("update tblhelpdetail set stage = 1, images ='$save_file',g_timer = '$s_timer', g_payment=Now(), hash='$hash',message='$message' where tran_id = $tran->tran_id") or die ("update tran id ".$db->error);
  $rs1 = $db->query("update tblmavro set incentive = $incentive where help_id = $tran->help_id and op_type='B'") or die ("update tran id ".$db->error);

  // Save file name
  //sms_gh($tran->tran_id);

  $ret = array("status"=>"success","msg"=>"Success");
}

echo json_encode($ret);
?>
