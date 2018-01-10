<?
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');

if (isset($_POST['id'])) {
	$id = $_POST['id'];
} else {
	$user = load_user(0);
	$id = $user->id;
}

$lang=$_COOKIE['lang'];
$ls = new stdClass();

$ls->statusO = array("Waiting","等待中","等待中");
$ls->statusC = array("Matched","配对完成","配對完成");
$ls->statusX = array("Cancelled","取消","取消");
$ls->statusD = array("Paid","完成付款","完成付款");

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'g_date';
$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
$offset = ($page-1)*$rows;

$result = array();
$items = array();

$rs = $db->query("select h.*,m.email,m.username,m.phone,m.referral,m.manager from tblmember as m, tblhelp as h where h.mem_id = m.id and (m.manager = $id or m.referral = $id) and (g_type='G') and (h.status='O' or h.status='P' or h.status='C' or h.status='D') order by $sort $order limit $offset,$rows") or die("err ".$db->error);
$ctr = mysqli_fetch_array($db->query("select count(h.id) as ctr from tblmember as m, tblhelp as h where h.mem_id = m.id and (m.manager = $user->id or m.referral = $user->id) and (g_type='G') and (h.status='O' or h.status='P' or h.status='C' or h.status='D')")) or die("Err ". $db->error);

$result["total"] = $ctr[0];

$now = new DateTime();
$ctr = $offset + 1;
while($row = mysqli_fetch_object($rs)) {
	$date = new datetime($row->g_date);
	$row->days = ggDaysDiff($date);
	if ($row->status=="O") {
		$row->status = $ls->statusO[$lang];
	} else if ($row->status == "D") {
		$row->status = "<b class='green'>".$ls->statusD[$lang]."</b>";
	} else if ($row->status == "C" || $row->status == "P") {
		$row->status = "<b class='blue'>".$ls->statusC[$lang];

		$help = $db->query("select * from tblhelpdetail where help_id = ".$row->id." and stage<>2");
		$help_date = "";
		while ($r1 = mysqli_fetch_object($help)) {
			if ($help_date =="" || $help_date <= $r1->g_timer) {
				$help_date = $r1->g_timer;
			}
		}
		$future_date = new DateTime($help_date);
		$interval = $future_date->diff($now);
		if ($now < $future_date) {
			$row->remain = "- ".ggTimeRemain($now,$help_date)."</b>";
		} else {
			$row->remain = "- </b><b class='red'>超時了</b>";
		}
		$row->status .= " ".$row->remain;
	} else if ($row->status == "X") {
		$row->status = "<b class='red'>".$ls->statusX[$lang]."</b>";
	}
	$row->id = ggHID($row->id);
	array_push($items, $row);
	$ctr++;
}
$result["rows"] = $items;
echo json_encode($result);
?>