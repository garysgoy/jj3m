<?
include ('_dbconfig.php');

$ls = new stdClass();
$ls->nopin = array("No PIN Available","没有激活码","沒有激活碼");

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
} else {
	$user = load_user(0);
	$id = $user->id;
}

$res = $db->query("select pin from tblpin where managerid=$id and status='N' limit 1");
if (mysqli_num_rows($res)==0) {
	echo $ls->nopin[$lang];
} else {
	$row = mysqli_fetch_object($res);
	echo $row->pin;
}
?>
