<?
include_once("inc/ggInit.php");

if ($user->rank<8) {
  header("location: login.php");
}

//$page_css[] = "";
$page_title = $mls->addgh[$lang];
$page_nav["addgh"]["active"] = true;

$ls = new stdClass();
$ls->title = array("Change Password","更改密码","更改密碼");
$ls->title = array("Change Second Password","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");

$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");
$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");

include("inc/ggHeader.php");
include("_ggFunctions.php");

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
	$gID = mysqli_insert_id($db);
	$msg = "Get Help - $usr->username Record $gID, User $mem_id, Amount $amt";
}

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
<?
  include("inc/ribbon.php");
?>

  <!-- MAIN CONTENT -->
  <div id="content">

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


	<style scoped>
		.f1{
			width:200px;
		}
	</style>
</div>
</div>
<?
include("inc/ggFooter.php");
?>