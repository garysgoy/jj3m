<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");

$ls = new stdclass();
$ls->close = array("Close","关闭","關閉");
$ls->confirm_receive = array("Confirm Receive","确认收到款","確認收到款");
$ls->complain = array("Complain","举报","據報");
$ls->upload = array("Upload","上传打款单据","上傳打款單據");
$ls->reupload = array("Upload again","重新上传打款单据","重新上傳打款單據");
$ls->confirm_payment = array("Confirm Payment","确认付款","確認付款");

$ls->sender_id = array("Sender ID","打款者","打款者");
$ls->receipient_id = array("Receipient ID","收款者","收款者");
$ls->btc_address = array("Receipient BTC Address","收款者比特币钱包 (BTC)","收款者比特币钱包 (BTC)");
$ls->eth_address = array("Receipient ETH Address","收款者以太币錢包 (ETH)","收款者以太币錢包 (ETH)");
$ls->amount = array("Amount ".$setup->currency,"金额 (".$setup->currency.")","金額 (".$setup->currency.")");
$ls->hash_key = array("Hash Key","哈希值 (Hash Key)","哈希值 (Hash Key)");
$ls->message = array("Message for Recepient","留言给收款者","留言給收款者");

$debug = false;
$req = ($debug)? $_GET:$_POST;

$hid = (isset($req['hid']))? $req['hid']:0;

$hd = $db->query("select * from tblhelpdetail where id = $hid");
$row = mysqli_fetch_object($hd);
$mem = load_user($row->mem_id);
$oth = load_user($row->oth_id);
$mem_mgr = load_user($mem->manager);
$oth_mgr = load_user($oth->manager);

if ($setup->china_bank==0) {
  $btn_close = "&nbsp;&nbsp;<button type='button' class='btn btn-default' data-dismiss='modal'>".$ls->close[$lang]."</button>";
  if ($row->g_type=="G") {
    $disabled = "disabled";
    if ($row->stage==1) {
      $action = "<button class='btn btn-success' onclick='doConfirm(".$row->id.")'>".$ls->confirm_receive[$lang]."</button>";
      $action .= "&nbsp;&nbsp;<button class='btn btn-danger' onclick='doFake(".$row->id.")'>".$ls->complain[$lang]."</button>";
      $action .= $btn_close;
    } else {
      $action = $btn_close;
    }
  } else {
    $disabled = "";
    if ($row->stage==1 or $row->stage==2) {
       $action = $btn_close;
       $disabled = "disabled";
    } else if ($row->stage==3) {
       $action = "<button class='btn btn-success' onclick='doStarph($row->id)'>".$ls->reupload[$lang]."</button>";
       $action .= $btn_close;
    } else {
       $action = "<button class='btn btn-success' data-toggle='modal' onclick='doPayment($row->id)'>".$ls->confirm_payment[$lang]."</button>";
       $action .= $btn_close;
    }
  }

  $d1 = "<div class='col-sm-12 col-lg-4' align=left><div clas='form-group'>";
  $d2 = "</div></div><div class='col-sm-12 col-lg-8'><div class='form-group'>";
  $d3 = "</div></div>";
  if ($row->g_type=="P") {
    $p1 = $mem;
    $p2 = $oth;
  } else {
    $p1 = $oth;
    $p2 = $mem;
  }
  $ret = "<div class='row'>
    $d1 ".$ls->sender_id[$lang]." $d2 <input type='text' class='form-control input-sm' disabled value='$p1->username'>$d3
    $d1 ".$ls->receipient_id[$lang]." $d2 <input type='text' class='form-control input-sm' disabled value='$p2->username'>$d3
    $d1 ".$ls->btc_address[$lang]." $d2 <input id='btc' type='text' class='form-control input-sm' disabled value='$p2->btc'>$d3
    $d1 ".$ls->eth_address[$lang]." $d2 <input type='text' class='form-control input-sm' disabled value='$p2->eth'>$d3
    $d1 ".$ls->amount[$lang]." $d2 <input type='text' class='form-control input-sm' disabled value='$row->g_amount'>$d3
    $d1 ".$ls->hash_key[$lang]." $d2 <input type='text' class='form-control input-sm' id='hash' name='hash' $disabled value='$row->hash'> $d3
    $d1 ".$ls->message[$lang]."$d2 <textarea rows=3 class='form-control input-sm' id='message' $disabled name='message'>$row->message</textarea>$d3
    </div>";
}
echo json_encode(array('success'=>1,'msg'=>$ret,'action'=>$action));
?>