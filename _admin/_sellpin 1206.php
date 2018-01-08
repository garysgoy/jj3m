<?
$pagetitle = "Sell PINs";
include("../_dbconfig.php");
include("../_ggFunctions.php");

$user = load_user(0);
$max = isset($_REQUEST['max'])? $_REQUEST['max']:15;

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

$setup = load_setup();

$msg = "";
if (isset($_POST['user_id']) and isset($_POST['pins'])) {
	$date = ggNows(); //ggNow();
	$user_id    = $_REQUEST['user_id'];
	$pins       = $_REQUEST['pins'];
	$paid       = $_REQUEST['paid'];
	$note       = $_REQUEST['note'];

	if ($user_id<>"" and $pins <> "" and $pins >= 0) {

		$mgr = load_user($user_id);

		$log = ggFetchObject("SELECT * FROM tblpinlog order by id desc limit 1");

		$directs = mysqli_fetch_object($db->query("select count(id) as ctr from tblmember where referral=$mgr->id"));
		$dd = 10;
		if ($mgr->id <= 3) {
			$msg = "<span class='red'>Invalid Receiver</span><br><br>";
		} else if ($mgr->rank <5 and $directs->ctr < $dd) {
			$msg = "<span class='red'>****** Need $dd Directs to be upgraded to manager, now only $directs->ctr ******</span><br><br>";
		} else if (!($log->requestby == $mgr->username && $log->pins == $pins)) {

			$msg = $mgr->username." ";
			if ($mgr->rank < 5) {
			    $r = $db->query("update tblmember set rank=5, pins=pins+$pins where id = $mgr->id") or die("d1 ".$db->error);
			    $msg .= "Upgraded <br>";
			} else {
			    $r = $db->query("update tblmember set pins = pins+$pins where id = $mgr->id") or die("d1 ".$db->error);
			}

			$leader = ggLeader($mgr->id);
			$paid = ($paid=="Y") ? "Y":"N";

			$add1 = $db->query("insert into tblpinlog (requestby,requestdate,issueby,pins, paid, note,leader) values
				          ('$mgr->username', '$date', '$user->username', $pins, '$paid','$note','$leader')") or die("Pin log ".$db->error);
			$log = mysqli_insert_id();

			for ($i=1;$i<=$pins;$i++) {
				$pin = gen_pin(20);
				$add2 = $db->query("insert into tblpin (managerid,requestdate, pin, paid, status,note) values ('$mgr->id', '$date', '$pin', '$paid','N','$log')") or die("Pins ".$db->error);
			}
			$msg .= "$pins pins generated<br><br>";
		} else {
			$msg .= "<span class='red'>****** Same Email & Pins with last entry Not Allowed  ******</span><br><br>";
		}
	} else {
		$msg .= "<span class='red'>****** Invalid Entry ******</span><br><br>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="">
  	<meta name="description" content="">
	<title>Sell Pins</title>
	<link rel="stylesheet" type="text/css" href="../easyui/themes/sunny/easyui.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/color.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#cg').combogrid({
				delay: 100,
				panelWidth:400,
				url: '_buypins_e.php',
				idField:'id',
				textField:'username',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'username',title:'username',align:'left',width:30},
					{field:'fullname',title:'fullname',align:'left',width:30},
					{field:'rank',title:'rank',align:'left',width:20}
				]]
			});
		});
	</script>
</head>
<body>
	<div class="easyui-panel" title="Sell PINs" style="width:500px;padding:10px;">
		<form id="ff" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Username:</td>
					<td><input id="cg" class="user_id" name="user_id" style="width:200px" onchange="getUpline()"></input><br></td>
				</tr>
				<tr>
					<td>Pins:</td>
					<td><input name="pins" class="f1 easyui-textbox"></input></td>
				</tr>
				<tr>
					<td>Paid:</td>
					<td><select class="f1 easyui-combobox" name="paid"><option value="Y" selected>Yes</option><option value="N">No</option></select></td>
				</tr>
				<tr valign="top">
					<td>Note:</td>
					<td><input name="note" class="f1 easyui-textbox" data-options="multiline:true" style="height:60px"></input></td>
				</tr>
				<tr>
					<td></td>
					<td>
					<input type="submit" value="Submit"></input>&nbsp;&nbsp;&nbsp;<a href="_resetpassword.php">[ Reset Password ]</a>&nbsp;&nbsp;&nbsp;<a href="_changeupline.php">[ Change Upline ]</a></input></td>
				</tr>
			</table>
		</form>
		<?
			echo "<b class='red'>". $msg ."</b>";

			$rs = $db->query("select * from tblpinlog order by id desc limit $max");
			echo "<br><table align='center' border='1' cellspacing='0' cellpadding='5'><tr bgcolor='silver'><td>id</td><td>Date</td><td>Manager</td><td>Pins</td><td>Paid</td><td>By</td><td>Note</td></tr>";
			while ($row = mysqli_fetch_object($rs)) {
				echo "<tr bgcolor='white'><td>$row->id</td><td>$row->requestdate</td><td>$row->requestby</td><td>$row->pins</td><td>$row->paid</td><td>$row->issueby</td><td>$row->note <br>$row->leader</td></tr>";
			}
			echo "</table>";
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
function ggLeader($id) {
	$leader = ggFetchObject("select * from tblmember where id = $id");
	$rank = $leader->rank;
	while ($rank <= 5 and $rank >0) {
		$leader = ggFetchObject("select * from tblmember where id = $leader->manager");
		$rank = $leader->rank;
		//echo "<br>$leader->id $leader->email";
	}
	if ($rank==0) {
		return ("XX");
	} else {
		return ($leader->username);
	}
}

function gen_pin($len) {
	$ret = "";
	while ($ret == "") {
	    $seed = str_split("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
	    for ($x=0; $x<$len; $x++) {
	       $ret .= $seed[rand(0, 45)];
	    }
	    $xx = ggFetchObject("select pin from tblpin where pin='$ret'");
	    if ($xx->pin == $ret) {
	    	$ret = "";
	    }
	}
    return $ret;
}
?>