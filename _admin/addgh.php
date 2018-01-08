<?
$pagetitle = "Add GH";
include("../_dbconfig.php");
include("../_ggFunctions.php");
include("__util.php");

$user = load_user(0);
/*
if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}
*/
$setup = load_setup();

$now = new DateTime("NOW");


$msg = "";
if (isset($_POST['member']) and isset($_POST['amount'])) {
	$date = ggNows(); //ggNow();
	$member    = $_REQUEST['member'];
	$amt       = $_REQUEST['amount'];
	$note      = $_REQUEST['note'];

	$mem_id = $member;
	$usr = load_user($member);

	$res = $db->query("INSERT INTO tblhelp (g_type,mem_id,mgr_id,g_date,g_amount,g_pending,status,reentry,note,priority)
			VALUES ('G', '$mem_id', '$usr->rid', '".$date."',$amt, $amt, 'O', 1, '',4)") or die('GH Error: ' . $db->error);
	$gID = mysqli_insert_id();
	$msg = "Get Help - $usr->username Record $gID, User $mem_id, Amount $amt";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="">
 	<meta http-equiv="refresh" content="300" />
  	<meta name="description" content="">
 <? if ($setup->exrate == "3.6") { ?>
 		<title>WW - Add GH</title>
<? } else { ?>
		<title>Happy - Add GH</title>
<? } ?>
	<link rel="stylesheet" type="text/css" href="../easyui/themes/sunny/easyui.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../easyui/themes/color.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="../easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#cg').combogrid({
				delay: 200,
				panelWidth:400,
				url: '_buypins_e1.php',
				idField:'id',
				textField:'username',
				mode:'remote',
				fitColumns:true,
				columns:[[
					{field:'username',title:'username',width:30},
					{field:'fullname',title:'fullname',align:'left',width:50}
				]]
			});
		});
	</script>
</head>
<body>
	<div class="easyui-panel" title="Add GHs" style="width:500px;padding:10px;">
		<? echo "<b class='red'>". $msg ."</b>"; ?>
		<form id="ff" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Username:</td>
					<td><input id="cg" class="member" name="member" style="width:200px"></input><br></td>
				</tr>
				<tr>
					<td>GH Amount:</td>
					<td><input name="amount" class="f1 easyui-textbox"></input></td>
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
	</div>

	<? gStatus(10) ?>
	<style scoped>
		.f1{
			width:200px;
		}
	</style>
</body>
</html>