<?
include_once("inc/ggInit.php");

if ($user->rank<8) {
  header("location: login.php");
}

$pintype = "1";

//$page_css[] = "";
$page_nav["sellpin"]["active"] = true;
$page_title = $mls->sellpin[$lang];

$ls = new stdClass();
$ls->title = array("Change Password","更改密码","更改密碼");
$ls->title = array("Change Second Password","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");

$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");
$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");

include("inc/ggHeader.php");
include("_ggFunctions.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
<?
  include("inc/ribbon.php");
?>

  <!-- MAIN CONTENT -->
  <div id="content">
<?


$msg = "";
if (isset($_POST['user_id']) and isset($_POST['pins'])) {
	$date = ggNows(); //ggNow();
	$user_id    = $_REQUEST['user_id'];
	$pins       = $_REQUEST['pins'];
	$paid       = $_REQUEST['paid'];
	$note       = $_REQUEST['note'];

	if ($user_id<>"" and $pins <> "" and $pins >= 0) {

		$mgr = load_user($user_id);

		$log = ggFetchObject("SELECT * FROM tblpinlog".$pintype." order by id desc limit 1");

		$directs = mysqli_fetch_object($db->query("select count(id) as ctr from tblmember where referral=$mgr->id"));
		$dd = 10;
		if ($mgr->id <= 3) {
			$msg = "<span class='red'>Invalid Receiver</span><br><br>";
		} else if ($mgr->rank <5 and $directs->ctr < $dd) {
			$msg = "<span class='red'>****** Need $dd Directs to be upgraded to manager, now only $directs->ctr ******</span><br><br>";
		} else if (!($log->requestby == $mgr->username && $log->pins == $pins)) {

			$msg = $mgr->username." ";
			if ($mgr->rank < 5) {
			    $r = $db->query("update tblmember set rank=5 where id = $mgr->id") or die("d1 ".$db->error);
			    $msg .= "Upgraded <br>";
			}

			$leader = ggLeader($mgr->id);
			$paid = ($paid=="Y") ? "Y":"N";

			$add1 = $db->query("insert into tblpinlog".$pintype." (requestby,requestdate,issueby,pins, paid, note,leader) values
				          ('$mgr->username', '$date', '$user->username', $pins, '$paid','$note','$leader')") or die("Pin log ".$db->error);
			$log = mysqli_insert_id($db);

			for ($i=1;$i<=$pins;$i++) {
				$pin = gen_pin(20);
				$add2 = $db->query("insert into tblpin".$pintype." (managerid,requestdate, pin, paid, status,note) values ('$mgr->id', '$date', '$pin', '$paid','N','$log')") or die("Pins ".$db->error);
			}
			$msg .= "$pins pins generated<br><br>";

			$tt = $db->query("insert into tblpintran".$pintype." (idfrom,idto,efrom,eto,qty,trdate) values ($user->id,$mgr->id,'$user->username','$mgr->username',$pins,'$date')");

		} else {
			$msg .= "<span class='red'>****** Same Email & Pins with last entry Not Allowed  ******</span><br><br>";
		}
	} else {
		$msg .= "<span class='red'>****** Invalid Entry ******</span><br><br>";
	}
}
?>

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
	<div class="easyui-panel" title="Sell PINs" style="width:600px;padding:10px;">
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
					<input type="submit" value="Submit"></input></td>
				</tr>
			</table>
		</form>
		<?
			echo "<b class='red'>". $msg ."</b>";

			$rs = $db->query("select * from tblpinlog".$pintype." order by id desc limit 50");
			echo "<br><table align='center' border='1' cellspacing='1' cellpadding='5' width=100%><tr bgcolor='silver'><td>id</td><td>Date</td><td>Manager</td><td>Pins</td><td>Paid</td><td>By</td><td>Note</td></tr>";
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
</div>
</DIV>
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

include("inc/ggFooter.php");
?>