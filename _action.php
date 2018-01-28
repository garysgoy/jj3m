<?
session_start();
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");
include("inc/ggValidate.php");

$debug = false;
$lang = ($debug)? 0:$lang;
$req  = ($debug)? $_GET:$_POST;

$ret = "";
if (!isset($req['act']) || $user->id < 1) {
  echo json_encode(array("status"=>"fail","msg"=>"Invalid Action"));
  exit;
}

$act = $req['act'];
if ($act == 'consult') {
  echo doSupport();
} else if ($act == 'activate') {
  echo doActivate();
} else if ($act == 'PH') {
  echo doPH();
} else if ($act == 'pin1') {
  echo doPin1Tran();
} else if ($act == 'pin2') {
  echo doPin2Tran();
} else if ($act == 'jsd') {
  echo dojsd();
} else if ($act == 'info') {
  echo doChangeInfo();
} else if ($act == 'pass') {
  echo doChangePass();
} else {
  echo json_encode(array("status"=>"fail","msg"=>"Invalid Action"));
}

function doSupport() {
  global $db,$user,$req,$_GET,$_POST;

  $content = $req['content'];
  $verifyCode = $req['verifyCode'];

  $v = new FormValidator();
  $v->addValidation(1,$content,"req","信息不能為空");
  $v->addValidation(2,$verifyCode,"eq=".$_SESSION['captcha_code'],"验证码错误");

  if (!$v->ValidateForm()) {
    $ret = array("status"=>"fail", "msg"=>$v->getError());
  } else if ($db->query("insert into tblsupport (mem_id,username,content,mdate) values ($user->id,'$user->username','".$content."',NOW())")) {
    $ret = array("status"=>"success","msg"=>"操作成功");
  } else {
    $ret = array("status"=>"fail","msg"=>"DB Insert Error ".$db->error);
  }
  return json_encode($ret);
}

function doActivate() {
  global $db,$req,$user,$debug,$lang;
  $id = $req['id'];

  $fs = new stdClass();
  $fs->ne_pin = array("You dont have enought activate PIN","激活码不足","激活碼不足");
  $fs->member = array("Invalid Member","找不到要激活的会员","找不到要激活的會員");
  $fs->success = array("Success","操作成功","操作成功");

  $pin = ggPinCount();
  $id_c = ggFetchValue("select id from tblmember where id=$id and pin=''");

  $v = new FormValidator();
  $v->addValidation(1,$pin,"gt=0",$fs->ne_pin[$lang]);
  $v->addValidation(2,$id,"eq=".$id_c,$fs->member[$lang]);

  if (!$v->ValidateForm()) {
    $ret = array("status"=>"fail", "msg"=>$v->getError());
  } else {
    $pin = ggFetchValue("select pin from tblpin1 where managerid = $user->id and status='N' limit 1");
    $rs1 = $db->query("update tblmember set pin='".$pin."' where id=$id") or die("Err ".$db->error);
    $usr = load_user($id);
    $rs1 = $db->query("update tblpin1 set status='U',usedate=now(), useby = '$usr->username' where managerid=$user->id and pin='$pin'");
    $ret = array("status"=>"success","msg"=>$fs->success[$lang]);
  }
  return json_encode($ret);
}

function doPH() {
  global $db,$req,$user;

  $amount = $req['fc_amount'];
  $pins   = $req['fc_amount'];
  $pass2  = $req['password2'];
  $pin = ggFetchObject("select count(id) as ctr from tblpin where managerid=$user->id and status='N'");
  $ac = $pin->ctr;
  $ac = 5;
  if ($ac < 1) {
    $ret = array("status"=>"fail","msg"=>"排单币余额不足");
  } else if (ggFetchValue("select id from tblmember where id=$user->id and pin=''")=="") {
//    $ret = array("status"=>"fail","msg"=>"需要等");
  } else {
    $plan = 1;
    ggPH($amount,$plan);
    $ret = array("status"=>"success","msg"=>"操作成功");
  }
  return json_encode($ret);
}

function ggPH($amt,$plan) {
  global $setup,$db, $user;
  $now = new DateTime("NOW");

  $hlp = ggFetchObject("select id from tblhelp order by id desc limit 1");
  $nid = $hlp->id + rand(1,1);
  $res = $db->query("INSERT INTO `tblhelp` (id, g_type, mem_id, mgr_id, g_date, g_plan, g_amount, g_pending, status, reentry, date_match, date_close, note) VALUES
            ($nid, 'P', $mem_id, $user->manager, '".$now->format('Y-m-d H:i:s')."', $plan, $amt, $amt, 'O', 1, '0000-00-00', '0000-00-00', '')") or die("Insert Help ".$db->error);
  $gID = $db->insert_id;

  $res = ggPH1($gID, $mem_id,$amt,$now,$plan);

  return $gID;
}

function doPin1Tran() {
  global $db, $user, $req;
  if (!isset($req['act']) || !isset($req['username']) || !isset($req['PinQty']) || !isset($req['password2'])) {
      return json_encode(array("status"=>"fail","msg"=>"资料不全：无法执行"));
  }

  $act = $req['act'];
  $username = $req['username'];
  $PinQty = $req['PinQty'];
  $password2 = $req['password2'];

  if ($act<>'pin1' || $username=='' || $PinQty<1 || $password2 == '') {
    return json_encode(array("status"=>"fail","msg"=>"资料错误：无法执行"));
  }

  $password2_5 = md5($password2);
  if ($username == ggFetchValue("select username from tblmember where username='$username'") &&
    $PinQty <= ggPin1Count() && $password2_5 == ggFetchValue("select password2 from tblmember where id=$user->id and password2 ='$password2_5'")) {

  }
}

function doPin2Tran() {
  return json_encode(array("status"=>"fail","msg"=>"Error"));
}

function ggPinTransfer($pinqty,$username) {
  global $db,$user,$ls,$msg, $lang;
  $ret = 0;

  $user1 = ggFetchObject("select * from tblmember where username='$username'");

  if ($user1 =="") {
    $msg .= "<br>".$ls->username_e2[$lang];
  } else {
    $dir = ggFetchObject("select count(id) as ctr from tblmember where referral=$user1->id");

      if ($user->username == $user1->username) {
      $msg .= "<br>".$ls->username_e4[$lang];
    } else if ($user1->rank < 5 and $dir->ctr < 10) {
      $bal = 10 - $dir->ctr;
      $msg .= "<br>".$ls->username_e3[$lang]."<br>** 继续推荐多 ".$bal." 个人就能自动升为注册经理 **";
    } else if (mysqli_num_rows($db->query("select id from tblpin where managerid=$user->id and status='N'"))<$pinqty) {
      $msg .= "<br>".$ls->pinqty_e2[$lang];
    } else {
      $oth = ggFetchObject("select * from tblmember where username='$username'");
      if ($oth=="") {
        $msg .= "<br>".$ls->username_e2[$lang];
      } else {

        $oth_id = $oth->id;
        $oth_rank = $oth->rank;
        if ($user1->rank < 5) {
          $xx = $db->query("update tblmember set rank = 5 where id= $user1->id");
        }
        $tt = ggTransPin($user->id,$oth->id,$user->username,$oth->username,$pinqty);
      }
    }
  }
  return;
}

function ggTransPin($from,$to,$efrom,$eto,$qty) {
  global $db;
  $date = ggNows(); //ggNow();
  $add1 = $db->query("insert into tblpintran (idfrom, idto,efrom,eto, qty,trdate) values ($from, $to, '$efrom', '$eto', $qty, '$date')");
  $log = mysqli_insert_id();

  $pin = $db->query("select * from tblpin where managerid = $from and status = 'N' limit $qty");
  while ($row = mysqli_fetch_object($pin)) {
    $u = $db->query("update tblpin set status='O', useby=$to, usedate='$date',note1='$log' where id = $row->id");
    $add2 = $db->query("insert into tblpin (managerid,requestdate, pin, paid, status,note1,note) values ('$to', '$date', '$row->pin', '$row->paid','N','$log','')") or die("Pins ".$db->error);
  }
}

function doChangePass() {
  global $db,$user,$req,$lang;

  $ls = new stdClass();
  $ls->password_ok = array("Invalid Current Password","原密码错误","原密碼錯誤");
  $ls->password_match = array("New Password Not Match","新密码不匹配","新密碼不匹配");
  $ls->password_len = array("Password must be at least 6 characters","密码最少需要6个字","密碼最少需要6個字");

  $passtype = $_REQUEST['lx'];
  $currentpassword = $_REQUEST['oldpassword'];
  $newpassword  = $_REQUEST['password'];
  $newpassword2 = $_REQUEST['repassword'];
  $currentpassword_5 = md5($currentpassword);
  $newpassword_5 = md5($newpassword);

  $fld = ($passtype=="1")? "password":"password2";
  $password_ok = ggFetchValue("select count(id) from tblmember where id=$user->id and ".$fld."= '$currentpassword_5'");

  $v = new FormValidator();
  $v->addValidation(1,$password_ok,"gt=0",$ls->password_ok[$lang]);
  $v->addValidation(2,$newpassword,"minlen=6",$ls->password_len[$lang]);
  $v->addValidation(3,$newpassword,"eq=".$newpassword2,$ls->password_match[$lang]);

  if (!$v->ValidateForm()) {
    $ret = array("status"=>"fail", "msg"=>$v->getError());
  } else {
    $db->query("update tblmember set $fld = '$newpassword_5' where id=$user->id");
    $ret = array("status"=>"success", "msg"=>"操作成功");

  }
  echo json_encode($ret);
}

function doChangeInfo() {
  global $db,$user,$req,$lang;

  $setup->maxaccount = 1;
  $ls = new stdClass();
  $ls->fullname_req = array("Full name can not be blank", "真实姓名不能为空","真實姓名不能為空");
  $ls->bankname_req = array("Bank info can not be blank", "开户行不能为空","開戶行不能為空");
  $ls->bankaccount_req = array("Bank account can not be blank", "银行卡号不能为空","銀行卡號不能為空");

  $ls->bankaccount_count = array("One Bank Account can only register ".$setup->maxaccount." accounts", "一个银行户口只能注册".$setup->maxaccount."个账户","一个银行户口只能注册".$setup->maxaccount."个账户");
  $ls->alipay_count      = array("One Alipay account can only register ".$setup->maxaccount." accounts", "一个支付宝只能注册".$setup->maxaccount."个账户","一个支付宝只能注册".$setup->maxaccount."个账户");
  $ls->wechat_count      = array("One Wechat account can only register ".$setup->maxaccount." accounts", "一个微信只能注册".$setup->maxaccount."个账户","一个微信只能注册".$setup->maxaccount."个账户");
  $ls->password2_req      = array("Second password can not be blank", "二级密码不能为空","二級密碼不能為空");
  $ls->password2_ok      = array("Invalid second password", "二级密码错误","二級密碼錯誤");

  $fullname   = $_REQUEST['fullname'];
  $wechat   = $_REQUEST['wechat'];
  $alipay   = $_REQUEST['alipay'];
  $bankname   = $_REQUEST['bank_info'];
  $bankaccount = $_REQUEST['bank_kh'];
  $password2   = $_REQUEST['password'];
  $password2_5  = md5($password2);

  $bankaccount = preg_replace("/\\s+/iu","",$bankaccount);
  $password_ok = ggFetchValue("select count(id) from tblmember where id=$user->id and password2 = '$currentpassword_5'");
  $alipay_count = ($alipay=="")? 0:ggFetchValue("select count(id) from tblmember where alipay='$alipay'");
  $wechat_count = ($wechat=="")? 0:ggFetchValue("select count(id) from tblmember where wechat='$wechat'");
  $password2_ok = ggFetchValue("select count(id) from tblmember where id=$user->id and password2='$password2_5'");

  $v = new FormValidator();
  $v->addValidation(1,$fullname ,"req",$ls->fullname_req[$lang]);
  $v->addValidation(2,$bankname,"req",$ls->bankname_req[$lang]);
  $v->addValidation(3,$bankaccount,"req",$ls->bankaccount_req[$lang]);
  $v->addValidation(4,$bankaccount_count,"lt=".$setup->maxaccount,$ls->bankaccount_count[$lang]);
  $v->addValidation(5,$alipay_count,"lt=".$setup->maxaccount,$ls->alipay_count[$lang]);
  $v->addValidation(6,$wechat_count,"lt=".$setup->maxaccount,$ls->wechat_count[$lang]);
  $v->addValidation(7,$password2,"req",$ls->password2_req[$lang]);
  $v->addValidation(8,$password2_ok,"eq=1",$ls->password2_ok[$lang]);

  if (!$v->ValidateForm()) {
    $ret = array("status"=>"fail", "msg"=>$v->getError());
  } else {
    $db->query("update tblmember set fullname='$fullname',bankname='$bankname',bankaccount='$bankaccount',alipay='$alipay',wechat='$wechat' where id=$user->id");
    if ($db->error =="") {
      $ret = array("status"=>"success", "msg"=>"操作成功");
    } else {
      $ret = array("status"=>"fail", "msg"=>$db->error);
    }
  }
  echo json_encode($ret);
}

function dojsd() {
  global $db, $user, $req;

  $ret = "";
  $id = $req['id'];
  $rs = $db->query("select * from tblhelpdetail where help_id=$id");
  while ($row = mysqli_fetch_object($rs)) {
    $user_o = load_user($row->oth_id);
    $user_r = load_user($user_o->referral);
    $ret .= "<p>打款人姓名：$user_o->fullname<br>打款人电话：$user_o->phone<br>推荐人姓名：$user_r->fullname<br>推荐人电话：$user_r->phone<br>金额：$row->g_amount<br>打款时间：$row->g_payment<br>支付凭证：<a href='$row->images' target='_blank' class='btn btn-info'>查看</a>";
  }
    return json_encode(array("status"=>"fail","msg"=>$ret));
}
?>