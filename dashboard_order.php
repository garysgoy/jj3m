<?
include ('_util.php');
include ('_ggFunctions.php');

	$user = load_user(0);
	$ls = new stdClass();
	$lang = 'cn';
	if ($lang == "cn") {
		$ls->status_O = "正在等待处理";
		$ls->status_P = "订单创建中";
		$ls->status_C = "订单创建了(+)";
		$ls->status_D = "申请被处理了";
		$ls->status_X = "已删除";
		$ls->cancel   = "取消申请";
	} else {
		$ls->status_O = "Is in queue for dispatcher";
		$ls->status_P = "Order Creating";
		$ls->status_C = "Order Created(+)";
		$ls->status_D = "Request Processed";
		$ls->status_X = "Deleted";
		$ls->cancel	  = "Cancel Order";
	}
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST['id'];
	} else {
		$id = $user->id;
	}

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
	$offset = ($page-1)*$rows;

	$result = array();
	$items = array();

	//echo "id = ".$id." userid = ".$user->id;
	$where = "mem_id = ".$id;

	$ctr = mysqli_fetch_array($db->query("select count(*) from tblhelp where $where"));
	$rs = $db->query("select * from tblhelp where $where order by id desc");

	$result["total"] = ($ctr[0]);

	// Add to final result
	while($row = mysqli_fetch_object($rs)){
		if ($rs1 = $db->query("select nickname from tblmember where id=".$row->mem_id)) {
			$rs2 = mysqli_fetch_array($rs1);
			$row->nickname = $rs2[0];
		} else {
			$row->nickname = "Not Found";
		}
		$cancel = "";
		if ($row->status=="O") {
			$cancel = "<a href='#' onclick='doCancel(".$row->id.")'>$ls->cancel</a>";
			$row->status_d = $ls->status_O;
		} else if ($row->status=="P") {
			$row->status_d = $ls->status_P;
		} else if ($row->status=="C") {
			$row->status_d = $ls->status_C;
		} else if ($row->status=="D") {
			$row->status_d = $ls->status_D;
		} else {
			$row->status_d = $ls->status_X;
		}
		$row->cancel = $cancel;
		$row->id = ggZID($row->id);
		$row->g_amount = number_format($row->g_amount,0) .' NT';
		//$row->g_date = substr($row->g_date,0,10);
		$row->g_date = $row->g_date;
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);
?>