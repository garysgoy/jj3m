<?
$pagetitle = "Reset 2nd  Password";
include("_phead.php");

$msg = "";
if (isset($_POST['username'])) {
	$username = $_POST['username'];
	$mem = ggFetchObject("select * from tblmember where username='$username'");
	if ($mem->id > 3) {
		$pass = md5("12345678");
		$mem = $db->query("update tblmember set password2 = '' where id = $mem->id");
		$msg = "$mem->username 2nd password removed";
	} else {
		$msg = "Error: Invalid username";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>Admin - Remove 2nd Password</title>
	<link rel="stylesheet" type="text/css" href="../easyui/themes/sunny/easyui.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/color.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#cg').combogrid({
				panelWidth:400,
				url: '_buypins_e.php',
				idField:'username',
				textField:'username',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'username',title:'username',width:70},
					{field:'fullname',title:'fullname',align:'left',width:60},
					{field:'rank',title:'rank',align:'left',width:20}
				]]
			});
		});
	</script>
</head>
<body>
	<div class="easyui-panel" title="Remove 2nd Password" style="width:300px;padding:10px;">
		<form id="ff" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>username:</td>
					<td><input id="cg" class="username" name="username" style="width:200px" value="<? echo $username;?>"></input><br></td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type="submit" value="Submit"></input></td>
				</tr>
			</table>
		</form>
		<?
			if ($msg<>"") {
				echo "<b class='red'>". $msg ."</b>";
			}
		?>
	</div>
	<style scoped>
		.f1{
			width:200px;
		}
	</style>
</body>
</html>
<?
function load_username($username) {
	$user = array();

	$rs_user = $db->query("SELECT * FROM tblmember where username = '$username'");

	if ($rs_user=="" || mysqli_num_rows($rs_user)==0) {
		$user = array(	'id'   		=> 0);
		$ret = (object) $user;
	} else {
		$row = mysqli_fetch_array($rs_user);
		$ret = (object) $row;
	}

  return ($ret);
}

function listHelp($username) {
	$user = load_username($username);
	echo "Member " . $user->id." ".$user->username ."<br>";
	$ph = $db->query("select * from tblhelp where mem_id = $user->id");
	while ($row = mysqli_fetch_object($ph)) {
		echo "<br>". $row->id ." ". $row->g_date." ".$row->g_amount;
		echo "<br><table width=280>";
		$mavro = $db->query("select * from tblmavro where help_id = $row->id order by id");
		while ($row1 = mysqli_fetch_object($mavro)) {
			$user1 = load_user($row1->mem_id);
			$amt = ($row1->op_type=="B"? $row1->real_amount:$row1->future_amount);
			echo "<tr><td>$row1->mem_id</td><td>$row1->op_type</td><td>$user1->username $user1->rank</td><td align=right>$amt</td></tr>";
		}
		echo "</table>";
	}
	return $user->id;
}
?>