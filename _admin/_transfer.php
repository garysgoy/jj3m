<?
$pagetitle = "Sell PINs";
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$max = (isset($_REQUEST['max']))? $_REQUEST['max']:50;

$user = load_user(0);

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

$setup = load_setup();

$msg = "";
if (isset($_POST['manager']) and isset($_POST['pins'])) {
	$date = ggNows(); //ggNow();
	$manager    = $_REQUEST['manager'];
	$pins       = $_REQUEST['pins'];
	$paid       = $_REQUEST['paid'];
	$note       = $_REQUEST['note'];

	if ($manager>3 and $pins <> "" and $pins >= 0) {

		$mgr = load_user($manager);

		$log = ggFetchObject("SELECT * FROM tblpinlog order by id desc limit 1");

		if ($log->requestby <> $mgr->email) {

			$msg = $mgr->email." ";
			if ($mgr->rank < 5) {
			    $r = $db->query("update tblmember set rank=5, pins=pins+$pins where id = $mgr->id") or die("d1 ".$db->error);
			    $msg .= "Upgraded <br>";
			} else {
			    $r = $db->query("update tblmember set pins = pins+$pins where id = $mgr->id") or die("d1 ".$db->error);
			}

			$leader = ggLeader($manager);
			$paid = ($paid=="Y") ? "Y":"N";

			$add1 = $db->query("insert into tblpinlog (requestby,requestdate,issueby,pins, paid, note,leader) values
				          ('$mgr->email', '$date', 'gary', $pins, '$paid','$note','$leader')") or die("Pin log ".$db->error);
			$log = mysqli_insert_id();

			for ($i=1;$i<=$pins;$i++) {
				$pin = gen_pin(20);
				$add2 = $db->query("insert into tblpin (managerid,requestdate, pin, paid, status,note) values ('$mgr->id', '$date', '$pin', '$paid','N','$log')") or die("Pins ".$db->error);
			}
			$msg .= "$pins pins generated<br><br>";
		} else {
			$msg .= "<span class='red'>****** Same Email with last entry Not Allowed  ******</span><br><br>";
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
 	<meta http-equiv="refresh" content="1800" />
  	<meta name="description" content="">
 <? if ($setup->exrate == "3.6") { ?>
 		<title>WW - Sell Pins</title>
<? } else if ($setup->exrate == "35") { ?>
		<title>Happy - Sll Pins</title>
<? } else { ?>
		<title>Happy - Sll Pins</title>
<? } ?>
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
				textField:'email',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'email',title:'Email',width:70},
					{field:'rank',title:'rank',align:'left',width:20},
					{field:'nickname',title:'nickname',align:'left',width:50}
				]]
			});
		});
		$(function(){
			$('#cg2').combogrid({
				delay: 100,
				panelWidth:400,
				url: '_buypins_e.php',
				idField:'id',
				textField:'email',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'email',title:'Email',width:70},
					{field:'rank',title:'rank',align:'left',width:20},
					{field:'nickname',title:'nickname',align:'left',width:50}
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
					<td>From:</td>
					<td><input id="cg" class="manager" name="from" style="width:200px" onchange="getUpline()"></input><br></td>
				</tr>
				<tr>
					<td>To:</td>
					<td><input id="cg2" class="manager" name="to" style="width:200px" onchange="getUpline()"></input><br></td>
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
					<input type="submit" value="Submit"></input></td>
				</tr>
			</table>
		</form>
		<?
			echo "<b class='red'>". $msg ."</b>";

			$rs = $db->query("select * from tblpinlog order by id desc limit $max");
			echo "<br><table align='center' border='1' cellspacing='0' cellpadding='5'><tr bgcolor='silver'><td>id</td><td>Date</td><td>Manager</td><td>Pins</td><td>Paid</td><td>Note</td></tr>";
			while ($row = mysqli_fetch_object($rs)) {
				echo "<tr bgcolor='white'><td>$row->id</td><td>$row->requestdate</td><td>$row->requestby</td><td>$row->pins</td><td>$row->paid</td><td>$row->note <br>$row->leader</td></tr>";
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
	}
	if ($rank==0) {
		return ("XX");
	} else {
		return ($leader->pin);
	}
}
?>