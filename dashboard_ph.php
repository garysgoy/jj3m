<?
include("_dbconfig.php");
include("_ggFunctions.php");

$setup = load_setup();
$user = load_user(0);

$now = new datetime("now");
$hour = $now->format("H");
$min = $now->format("i");

if(isset($_REQUEST["HelpAmount"])) {
	if (ggNextPH('timer')=="") {
		$amount = $_REQUEST["HelpAmount"];
		$remarks= $_REQUEST["Remarks"];
		$plan="1";

		if ($amount > 0) {
			$user_id = $user->id;
			$rs = $db->query("select id from tblhelp where mem_id=$user_id and g_type='P' and status<>'X' and status<>'C'");
			if ($rs=="" or mysqli_num_rows($rs)==0) {

				$gID = ggPH($user_id,$amount,$plan);
				ggAccessLog1($user->username,"PH","$gID $amount $plan");

				echo json_encode(array('success'=>true));
			} else {
				$gg = mysqli_fetch_object($db->query("select g_date from tblhelp where mem_id=$user_id and g_type='P' and status<>'X' order by id desc limit 0,1"));
				$date = new datetime($gg->g_date);
				$days = ggDaysDiff($date);
				$gap = $days - $setup->phdays;
				if ($gap >= 0) {
					$gID = ggPH($user_id,$amount,$plan);
					ggAccessLog1($user->username,"PH","$gID $amount $plan");
					echo json_encode(array('success'=>true,'amount'=>$amount));
				} else {
					echo json_encode(array('msg'=> "1",'gap'=>-$gap));
				}
			}
		} else {
			echo json_encode(array('msg'=> "2"));
		}
	} else {
			echo json_encode(array('msg'=> "申請提供幫助已達上限"));
	}
} else {
	echo json_encode(array('msg'=> "2"));
}

function ggPH($mem_id,$amt,$plan) {
	global $setup,$db;
	$now = new DateTime("NOW");
	$user = load_user($mem_id);

	$hlp = ggFetchObject("select id from tblhelp order by id desc limit 1");
/*	if ($hlp=="" or $hlp->id < 1) {
		$hlp->id=0;
	}
*/
	//$nid = $hlp->id + 1;
	$nid = $hlp->id + rand(1,10);
	$res = $db->query("INSERT INTO `tblhelp` (id, g_type, mem_id, mgr_id, g_date, g_plan, g_amount, g_pending, status, reentry, date_match, date_close, note) VALUES
						($nid, 'P', $mem_id, $user->manager, '".$now->format('Y-m-d H:i:s')."', $plan, $amt, $amt, 'O', 1, '0000-00-00', '0000-00-00', '')") or die($db->error);
	$gID = $db->insert_id;

	$res = ggPH1($gID, $mem_id,$amt,$now,$plan);

	return $gID;
}


?>