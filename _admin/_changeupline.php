<?
$pagetitle = "Change Upline";
include("_phead.php");

$msg = "";
if (isset($_POST['username']) && (isset($_POST['referral']) or isset($_POST['manager']))) {
	$username = $_POST['username'];
	$referral = $_POST['referral'];
	$manager = $_POST['manager'];
	changeUpline($username,$referral,$manager);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>Admin - <? echo $pagetitle ?></title>
	<link rel="stylesheet" type="text/css" href="../easyui/themes/sunny/easyui.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/color.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#cg1').combogrid({
				panelWidth:400,
				url: '_buypins_e.php',
				idField:'username',
				textField:'username',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'username',title:'username',width:70},
					{field:'email',title:'email',align:'left',width:60},
					{field:'rank',title:'rank',align:'left',width:20}
				]]
			});
			$('#cg2').combogrid({
				panelWidth:400,
				url: '_buypins_e.php',
				idField:'username',
				textField:'username',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'username',title:'username',width:70},
					{field:'email',title:'email',align:'left',width:60},
					{field:'rank',title:'rank',align:'left',width:20}
				]]
			});
			$('#cg3').combogrid({
				panelWidth:400,
				url: '_buypins_e.php',
				idField:'username',
				textField:'username',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'username',title:'username',width:70},
					{field:'email',title:'email',align:'left',width:60},
					{field:'rank',title:'rank',align:'left',width:20}
				]]
			});
		});
	</script>
</head>
<body>
	<div class="easyui-panel" title="Admin - <? echo $pagetitle ?>" style="width:400px;padding:10px;">
		<form id="ff" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>username:</td>
					<td><input id="cg1" class="username" name="username" style="width:200px" value="<? echo $username;?>"></input><br></td>
				</tr>
				<tr>
					<td>Referral:</td>
					<td><input id="cg2" class="referral" name="referral" style="width:200px" value="<? echo $referral;?>"></input><br></td>
				</tr>
				<tr>
					<td>Manager:</td>
					<td><input id="cg3" class="manager" name="manager" style="width:200px" value="<? echo $manager;?>"></input><br></td>
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
function load_byusername($username) {
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

function changeUpline($username,$referral,$manager) {
	echo "<table cellpadding=15><tr><td>Mem: $username<br>Ref: $referral<br>Mgr: $manager<br>";

	$user = load_byusername($username);
	$oref = load_byid($user->referral);
	$omgr = load_byid($user->manager);
	$ref = load_byusername($referral);
	$mgr = load_byusername($manager);
	//echo "</td><td>$user->username $user->id<br>$oref->username $oref->id <br>$omgr->username$omgr->id";
	if ($user->id <= 3) {
		echo "</td><td><b>R1 - Invalid User username</b></td></tr></table>";
	} else if ($ref->id ==0 and $mgr->id == 0) {
		echo "</td><td><b>R2 - Invalid Referral & Manager</b></td></tr></table>";
	} else {
		if ($ref->id == 0) $ref = load_user($user->referral);
		if ($mgr->id == 0) $mgr = load_user($user->manager);
		$r = $db->query("update tblmember set referral=$ref->id, manager=$mgr->id, ref_name='$ref->username', mgr_name='$mgr->username' where id=$user->id") or die("Update ".$db->error);
		$usr = load_byid($user->id);
		$ref = load_byid($usr->referral);
		$mgr = load_byid($usr->manager);
		echo "</td><td><b>$usr->username <br>$ref->username <br>$mgr->username</b></td></tr></table>";
	}
}

function load_byid($id) {
	$user = array();

	$rs_user = $db->query("SELECT * FROM tblmember where id = $id");

	if ($rs_user=="" || mysqli_num_rows($rs_user)==0) {
		$user = array(	'id'   		=> 0);
		$ret = (object) $user;
	} else {
		$row = mysqli_fetch_array($rs_user);
		$ret = (object) $row;
	}

  return ($ret);
}
?>