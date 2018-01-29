<?
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');

if (isset($_POST['id'])) {
	$id = $_POST['id'];
} else {
	$user = load_user(0);
	$id = $user->id;
}

$lang=1;
$ls = new stdClass();

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
$offset = ($page-1)*$rows;

$result = array();
$items = array();

$rs = $db->query("select * from tblpintran where idfrom=$id order by $sort $order limit $offset,$rows") or die("err ".$db->error);
$ctr = mysqli_fetch_array($db->query("select count(id) as ctr from tblpin where managerid = $id and status='U'")) or die("Err ". $db->error);

$result["total"] = $ctr[0];

$now = new DateTime();
$ctr = $offset + 1;
while($row = mysqli_fetch_object($rs)) {
	$row->sn = $ctr;
	//$tmp = ggFetchValue("select username from tblmember where id = $row->useby");
	array_push($items, $row);
	$ctr++;
}
$result["rows"] = $items;
echo json_encode($result);
?>