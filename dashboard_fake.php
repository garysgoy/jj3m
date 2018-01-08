<?
	include("_dbconfig.php");
	include("_ggFunctions.php");

	$helpid = isset($_REQUEST['helpid']) ? $_REQUEST['helpid'] : 0;

	if ($helpid > 0) {
        $tran = ggFetchObject("select tran_id from tblhelpdetail where id = $helpid") or die ("Err: get tran id ".$db->error);
        $rs = $db->query("update tblhelpdetail set stage = 3 where tran_id = $tran->tran_id")or die ("Err: update tran id ".$db->error);
		$result = array('success' => 1);
	} else {
		$result = array('msg' => "Invalid ID: ".$helpid);
	}
	echo json_encode($result);
?>