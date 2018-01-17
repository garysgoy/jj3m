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

$debug = false;
$req = ($debug)? $_GET:$_POST;

$hid = (isset($req['hid']))? $req['hid']:0;

$hd = $db->query("select * from tblhelpdetail where id = $hid");
$row = mysqli_fetch_object($hd);
$mem = load_user($row->mem_id);
$oth = load_user($row->oth_id);
$mem_mgr = load_user($mem->manager);
$oth_mgr = load_user($oth->manager);

$btn_close = "&nbsp;&nbsp;<button type='button' class='btn btn-default' data-dismiss='modal'>".$ls->close[$lang]."</button>";
if ($row->g_type=="G") {
      if ($row->stage==0 or $row->stage==2 or $row->stage==3 or $row->stage==4) {
         $action = $btn_close;
      } else {
         $action = "<button class='btn btn-success' onclick='doConfirm(".$row->id.")'>".$ls->confirm_receive[$lang]."</button>";
         $action .= "&nbsp;&nbsp;<button class='btn btn-danger' onclick='doFake(".$row->id.")'>".$ls->complain[$lang]."</button>";
         $action .= $btn_close;
      }
} else {
      if ($row->stage==1 or $row->stage==2) {
         $action = $btn_close;
      } else if ($row->stage==3) {
         $action = "<button class='btn btn-success' onclick='doStarph($row->id)'>".$ls->reupload[$lang]."</button>";
         $action .= $btn_close;
      } else {
         $action = "<button class='btn btn-success' data-toggle='modal' onclick='doPayment($row->id)'>".$ls->confirm_payment[$lang]."</button>";
         $action .= $btn_close;
      }
}

if ($row->g_type=="P") {
   $d1 = "<div class='col-sm-12 col-lg-4' align=left><div clas='form-group'>";
   $d2 = "</div></div><div class='col-sm-12 col-lg-8'><div class='form-group'>";
   $d3 = "</div></div>";
   $ret = "<div class='row'>
      $d1 Sender ID $d2 <input type='text' class='form-control input-sm' disabled value='$mem->username'>$d3
      $d1 Recipient ID $d2 <input type='text' class='form-control input-sm' disabled value='$oth->username'>$d3
      $d1 Recipient BTC Address $d2 <input id='btc' type='text' class='form-control input-sm' disabled value='$oth->btc'>$d3
      $d1 Recipient ETH Address $d2 <input type='text' class='form-control input-sm' disabled value='$oth->eth'>$d3
      $d1 Amount $ $d2 <input type='text' class='form-control input-sm' disabled value='$row->g_amount'>$d3
      $d1 Hash Key $d2 <input type='text' class='form-control input-sm' id='hash' name='hash'> $d3
      $d1 Message for Recipient $d2 <textarea rows=5 class='form-control input-sm' id='message' name='message'></textarea>$d3
      </div>";
} else {
   $ret = "<div class='row'>
      <div class='col-sm-12 col-lg-4' align=right>Sender ID</div><div class='col-sm-12 col-lg-8'>$oth->username</div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient ID</div><div class='col-sm-12 col-lg-8'>$mem->username<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient BTC Address</div><div class='col-sm-12 col-lg-8'>$mem->btc<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient ETH Address</div><div class='col-sm-12 col-lg-8'>$mem->eth<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Amount $</div><div class='col-sm-12 col-lg-8'>$row->g_amount</div>
      <div class='col-sm-12 col-lg-4' align=right>Hash Key</div><div class='col-sm-12 col-lg-8'><input class='form-control input-sm' type='text' id='hash' name='hash'></div>
      <div class='col-sm-12 col-lg-4' align=right>Message for Recipient</div><div class='col-sm-12 col-lg-8'><textarea class='form-control input-sm'  rows=5 id='message' name='message'></textarea>/div>
      </div>";
}

echo json_encode(array('success'=>1,'msg'=>$ret,'action'=>$action));
?>