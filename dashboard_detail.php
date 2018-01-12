<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");

$debug = false;
$req = ($debug)? $_GET:$_POST;

$hid = (isset($req['hid']))? $req['hid']:0;

$hd = $db->query("select * from tblhelpdetail where id = $hid");
$row = mysqli_fetch_object($hd);
$mem = load_user($row->mem_id);
$oth = load_user($row->oth_id);
$mem_mgr = load_user($mem->manager);
$oth_mgr = load_user($oth->manager);
$ret1 = "$oth->username<br>
      $oth->fullname<br>
      $oth->bankname<br>
      $oth->bankbranch<br>
      $oth->bankaccount<br>
      $oth->alipay<br>
      $oth->wechat<br>
      $oth->phone<br><br><br>
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
if ($row->g_type=="G") {
      if ($row->stage==0 or $row->stage==2 or $row->stage==3 or $row->stage==4) {
         $action = "<a href='javascript:void(0)' class='btn btn-default' onclick='". '$("#complete").window("close")'.">Close</a>";
      } else {
         $action = "<a href='javascript:void(0)' class='btn btn-success' onclick='doConfirm(".$row->id.")'>确认收到款项</a>";
         $action .= "<a href='javascript:void(0)' class='btn btn-danger' onclick='doFake(".$row->id.")'>没收到款项，假收据</a>";
      }
	echo json_encode(array('success'=>1,'msg1'=>$ret1,'msg2'=>$ret2,'action'=>$action));
} else {
      if ($row->stage==1 or $row->stage==2) {
         $action = "<a href='javascript:void(0)' class='btn btn-default' onclick='". '$("#complete").window("close")'.">Close</a>";
      } else if ($row->stage==3) {
         $action = "<a href='javascrip3:void(0)' class='btn btn-success' onclick='doStarph($row->id)'>重新上传打款单据</a>";
      } else {
         $action = "<a href='javascrip3:void(0)' class='btn btn-success' data-toggle='modal' data-target='#upp_modal' onclick='doUpload($row->id)'>上传打款单据</a>";
      }
	echo json_encode(array('success'=>1,'msg1'=>$ret2,'msg2'=>$ret1,'action'=>$action));
}
?>