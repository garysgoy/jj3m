<?
include("_dbconfig.php");
include("_ggFunctions.php");

$ls = new stdClass();
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

$ls->ph_group = array("Sender ID<br>Fullname<br>Bank name<br>Bank Branch<br>Bank Account<br>Alipay<br>Wechat<br>Phone<br><br>Payer Manager<br>Manager Fullname<br>Manager Phone");

$debug=false;
$req = ($debug)? $_GET:$_POST;


$hid = (isset($req['hid']))? $req['hid']:0;

$hd = $db->query("select * from tblhelpdetail where id = $hid");
$row = mysqli_fetch_object($hd);
$mem = load_user($row->mem_id);
$oth = load_user($row->oth_id);
$mem_mgr = load_user($mem->manager);
$oth_mgr = load_user($oth->manager);
$ret1 = "$oth->username<br>$oth->fullname<br>$oth->bankname<br>$oth->bankbranch<br>
      $oth->bankaccount<br>
      $oth->alipay<br>
      $oth->wechat<br>
      $oth->phone<br><br>
      $oth_mgr->username<br>
      $oth_mgr->fullname<br>
      $oth_mgr->phone<br><br>
      ";
$ret2 = "$mem->username<br>
      $mem->fullname<br>
      $mem->bankname<br>
      $mem->bankbranch<br>
      $mem->bankaccount<br>
      $mem->alipay<br>
      $mem->wechat<br>
      $mem->phone<br><br><br>
      $mem_mgr->username<br>
      $mem_mgr->fullname<br>
      $mem_mgr->phone<br><br>
      ";
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
$ret =  "<table width=100%>";
$ret .= "<tr><td><table width=100% border=1 style='background-color:green'><tr><td colspan=2 align=center>Provide Help</td></tr><tr><td valign=top>".$ls->ph_group[$lang]."</td><td>$ret1</td></tr></table></td>";
$ret .= "<td><table width=100% border=1 style='background-color:yellow'><tr><td colspan=2 align=center>Get Help</td></tr><tr><td valign=top>".$ls->ph_group[$lang]."</td><td>$ret1</td></tr></table></td></tr>";

echo json_encode(array("success"=>1,"msg"=>$ret,"action"=>$action));

?>