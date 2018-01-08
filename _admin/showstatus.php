<?
$pagetitle = "Buy PINs";
include("../_dbconfig.php");
include("../_ggFunctions.php");

$user = load_user(0);

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

$msg = "";
if (isset($_POST['manager'])) {
	$date = ggNows(); //ggNow();
	$manager    = $_REQUEST['manager'];

	$mgr = load_username($manager);
	$rr = load_user($mgr->referral);
	$rm = load_user($mgr->manager);
	$msg = "username: $manager";
	$msg .= "<br>Rank: ".($mgr->rank==5? "Manager":"Member");
	$pins = mysqli_num_rows($db->query("select * from tblpin where managerid=$mgr->id"));
	$pinused = mysqli_num_rows($db->query("select * from tblpin where managerid=$mgr->id and status='U'"));
	$msg .= "<br>Pins: ". $pins . " Used: ".$pinused;
	$msg .= "<br>Mgr: ". $rm->username . "<br>Ref: ".$rr->username;

	$part = mysqli_num_rows($db->query("select * from tblmember where manager=$mgr->id"));
	$ref = mysqli_num_rows($db->query("select * from tblmember where referral=$mgr->id"));
	$msg .= "<br>Participants: ".$part;
	$msg .= "<br>Directs: ".$ref;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>Admin - Member Status</title>
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
					{field:'username',title:'username',align:'left',width:60},
					{field:'username',title:'username',width:70},
					{field:'rank',title:'rank',align:'left',width:20}
				]]
			});
		});
	</script>
</head>
<body>
	<div class="easyui-panel" title="Member Status" style="width:300px;padding:10px;">
		<form id="ff" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>username:</td>
					<td><input id="cg" class="manager" name="manager" style="width:200px" value="<? echo $manager;?>"></input><br></td>
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
				$rs = $db->query("select * from tblpinlog where requestby='$mgr->username' order by id desc limit 0,10");
				echo "<br><table width='250' align='center' border='1' cellspacing='0' cellpadding='5'><tr bgcolor='silver'><td>id</td><td>manager</td><td>pins</td><td>note</td></tr>";
				while ($row = mysqli_fetch_object($rs)) {
					echo "<tr bgcolor='white'><td>$row->id</td><td>$row->requestby</td><td>$row->pins</td><td>$row->note</td></tr>";
				}
				echo "</table>";
				listHelp($mgr->username);
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
	global $db;
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
	global $db;
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