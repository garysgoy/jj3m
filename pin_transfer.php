<?
include ('_dbconfig.php');
include ('_ggFunctions.php');

if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}

$debug = false;
$lang = isset($lang)? $lang:0;
$req = ($debug)? $_GET:$_POST;

$pinqty 	= $req['PinQty'];
$username 	= $req['username'];
$password2_5 = md5($req['password2']);


$ls = new stdClass();
$ls->pinqty_e1   = array("Pin Quantity - can only be 1 to 100", "共享数量 - 请输入 1 到 100 之间","共享數量 - 請輸入 1 到 100 之間");
$ls->pinqty_e2   = array("Pin Quantity - You don't have enough pins to transfer", "共享数量 - 共享数量 > 可共享数量","共享數量 - 共享數量 > 可共享數量");

$ls->username_e1 = array("Username can not be blank","用户账号 - 必须填写","用戶賬號 - 必須填寫");
$ls->username_e2 = array("Username - not found in system", "用户账号 - 没有这个账号","用戶賬號 - 沒有這個賬號");
$ls->username_e3 = array("Username - can not transfer to non-manager", "用户账号 - 这个账号不是经理级别，不能转","用戶賬號 - 這個賬號不是經理級別，不能轉");
$ls->username_e4 = array("Username - Can not transfer to yourself","用户账号 - 不能共享给自己","用戶賬號 - 不能共享給自己");
$ls->password2_e1 = array("Password - Invalid second password", "二级密码 - 二级密码错误","二級密碼 - 二級密碼錯誤");

$msg = "";
if (mysqli_num_rows($db->query("select id from tblmember where id=$user->id and password2<>'' and password2='$password2_5'"))==0) {
	$msg .= "<br>".$ls->password2_e1[$lang];
} else {
	if ($pinqty=="" || $pinqty < 0 || $pinqty > 100) {
		$msg .= "<br>".$ls->pinqty_e1[$lang];
	}
	if ($username=="") {
		$msg .= "<br>".$ls->username_e1[$lang];
	}
	if ($msg=="") {
		$rep = ggPinTransfer($pinqty,$username);
	}
}

if ($msg == "") {
	echo json_encode(array('success'=>true, 'pinqty'=>$pinqty, 'username'=>$username));
} else {
	$msg = "<br><br>" . $msg ."<br>";
	echo json_encode(array('msg'=>$msg));
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
	$log = mysqli_insert_id($db);

	$pin = $db->query("select * from tblpin where managerid = $from and status = 'N' limit $qty");
	while ($row = mysqli_fetch_object($pin)) {
		$u = $db->query("update tblpin set status='O', useby=$to, usedate='$date',note1='$log' where id = $row->id");
		$add2 = $db->query("insert into tblpin (managerid,requestdate, pin, paid, status,note1,note) values ('$to', '$date', '$row->pin', '$row->paid','N','$log','')") or die("Pins ".$db->error);
	}
}
?>