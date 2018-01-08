<?
	include("_dbconfig.php");
	include("_ggFunctions.php");

	$msg = "";
	$user = load_user(0);
	$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	$nows = ggNows();
	$now = new DateTime("NOW");

	$rs = $db->query("select id,g_date from tblhelp where id=$id");
    $ctr = mysqli_num_rows($rs);
	if ($id == 0 || $ctr == 0) {
		$msg = "没有这个订单";
	} else {
		$ph = mysqli_fetch_object($rs);
		$g_date = new DateTime($ph->g_date);
		$interval = $now->diff($g_date);
        $days = $interval->format("%d");
        if ($days < 99) {
			$rs = $db->query("delete from tblmavro where help_id=$id") or die("detail: " . $db->error);
			$rs = $db->query("update tblhelp set status = 'X',date_close= '$nows' where id=$id") or die("help: ".$db->error);
			$hlp = ggFetchObject("select * from tblhelp where id=$id") or die("help: ".$db->error);
			ggAccessLog1($user->username,"XPH","$id $hlp->g_amount");
		} else {
			$msg = "订单已超过7天，不能取消";
		}
	}
	if ($msg=="") {
		$result = array('success' => 1);
	} else {
		$result = array('msg' => $msg);
	}
	echo json_encode($result);
?>