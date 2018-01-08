<?
	include("_dbconfig.php");
	include("_ggFunctions.php");
	include("_sms.php");

	$debug = false;
	$helpid = isset($_REQUEST['helpid']) ? $_REQUEST['helpid'] : 0;

	if ($helpid > 0) {
        $tran = ggFetchObject("select tran_id from tblhelpdetail where id = $helpid");

        $rs = $db->query("update tblhelpdetail set stage = 2, g_confirm=Now() where tran_id = $tran->tran_id and stage=1");

        $helpd = $db->query("select * from tblhelpdetail where tran_id = $tran->tran_id");
        while ($row = mysqli_fetch_object($helpd)) {
        	$xx = checkclose($row->help_id);
        }

        //sms_confirm($tran->tran_id);
		$result = array('success' => 1);
	} else {
		$result = array('msg' => "Invalid ID: ".$helpid);
	}
	echo json_encode($result);


function checkclose($help_id) {
	global $debug;
	$help = ggFetchObject("select * from tblhelp where id = $help_id");
	$sum = ggFetchObject("select sum(g_amount) as amt from tblhelpdetail where help_id = $help_id and stage = 2");
	if ($debug) echo "<br>Check Close $help_id";
	if ($sum->amt == $help->g_amount) {
		$xx = closeph($help_id);
	}
}

function closeph($help_id) {
	global $db,$app_domain,$debug;
	if ($debug) echo "<br>Close $help_id";
    $h = ggFetchObject("select * from tblhelp where id = $help_id");
	if ($h->status <> 'D' or $h->date_close =='0000-00-00 00:00:00') {
		$rs1 = $db->query("update tblhelp set status='D',date_close=now() where id = $help_id");
	    $h = ggFetchObject("select * from tblhelp where id = $help_id");
	}
	$rs2 = $db->query("select * from tblmavro where help_id = $help_id order by id");
	$op_level = 0;
	while ($row = mysqli_fetch_object($rs2)) {
		if ($row->op_type == "M") {
			$op_level += 1;
		}
		if ($op_level==0) {
			if ($row->op_type=='B') {
				$tt = $db->query("update tblmavro set `type`='C', date_release = '$h->date_close', op_level = $op_level where id = $row->id");
			} else {
				$tt = $db->query("update tblmavro set `type`='C', date_release = '$h->date_close', op_level = $op_level where id = $row->id");
			}
		} else if ($op_level==1){
			$tt = $db->query("update tblmavro set `type`='C', date_release = '$h->date_close', op_level = $op_level where id = $row->id");
		} else {
			$tt = $db->query("update tblmavro set `type`='C', date_release = DATE_ADD('$h->date_close', INTERVAL 30 DAY), op_level = $op_level where id = $row->id");
		}
		if ($debug) echo "<br>$row->id $h->date_close<br>";
	}
}
?>