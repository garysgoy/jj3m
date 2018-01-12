<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");

$ls = new stdclass();
$ls->close = array("Close","关闭","關閉");
$ls->confirm_receive = array("Confirm Receive","确认收到款","確認收到款");
$ls->complain = array("Complain","举报","據報");
$ls->upload = array("Upload","上传打款单据","上傳打款單據");
$ls->reupload = array("Upload again","重新上传打款单据","重新上傳打款單據");

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
         $action = "<button class='btn btn-success' data-toggle='modal' data-target='#upp_modal' onclick='doUpload($row->id)'>".$ls->upload[$lang]."</button>";
         $action .= $btn_close;
      }
}

if ($row->g_type=="P") {
   $ret = "<div class='row'>
      <div class='col-sm-12 col-lg-4' align=right>Time Left</div><div class='col-sm-12 col-lg-8'>Time</div>
      <div class='col-sm-12 col-lg-4' align=right>Sender ID</div><div class='col-sm-12 col-lg-8'>$mem->username</div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient ID</div><div class='col-sm-12 col-lg-8'>$oth->username<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient BTC Address</div><div class='col-sm-12 col-lg-8'>$oth->btc<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient ETH Address</div><div class='col-sm-12 col-lg-8'>$oth->eth<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Amount $</div><div class='col-sm-12 col-lg-8'>$row->g_amount</div>
      <div class='col-sm-12 col-lg-4' align=right>Hash Key</div><div class='col-sm-12 col-lg-8'>Hash</div>
      <div class='col-sm-12 col-lg-4' align=right>Message for Recipient</div><div class='col-sm-12 col-lg-8'>Message</div>
      </div>";
} else {
   $ret = "<div class='row'>
      <div class='col-sm-12 col-lg-4' align=right>Time Left</div><div class='col-sm-12 col-lg-8'>Time</div>
      <div class='col-sm-12 col-lg-4' align=right>Sender ID</div><div class='col-sm-12 col-lg-8'>$oth->username</div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient ID</div><div class='col-sm-12 col-lg-8'>$mem->username<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient BTC Address</div><div class='col-sm-12 col-lg-8'>$mem->btc<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Recipient ETH Address</div><div class='col-sm-12 col-lg-8'>$mem->eth<br></div>
      <div class='col-sm-12 col-lg-4' align=right>Amount $</div><div class='col-sm-12 col-lg-8'>$row->g_amount</div>
      <div class='col-sm-12 col-lg-4' align=right>Hash Key</div><div class='col-sm-12 col-lg-8'>Hash</div>
      <div class='col-sm-12 col-lg-4' align=right>Message for Recipient</div><div class='col-sm-12 col-lg-8'>Message</div>
      </div>";
}

echo json_encode(array('success'=>1,'msg'=>$ret,'action'=>$action));
?>