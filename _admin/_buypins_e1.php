<?

$q = isset($_POST['q']) ? strval($_POST['q']) : '';

include ("../_dbconfig.php");

$mem = $db->query("select * from tblmember where username like '$q%' order by username") or die($db->error);
$rows = array();
while($row = mysqli_fetch_assoc($mem)){
	if ($row['rank']==5) {
		$row['rank']="*注册经理";
	} else if ($row['rank']==6) {
		$row['rank']="** 合格经理";
	} else if ($row['rank']>=7) {
		$row['rank']="*** 高级经理";
	} else {
		$row['rank']="普通会员";
	}
	$rows[] = $row;
}
echo json_encode($rows);
?>