<?
include_once("inc/ggInit.php");

if ($user->rank<8) {
  header("location: login.php");
}
$page_css[] = "";
$page_title = $mls->sellpin[$lang];
$page_nav["sellpin"]["active"] = true;

$ls->title = array("Change Password","更改密码","更改密碼");
$ls->title = array("Change Second Password","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");

$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");
$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");

include("inc/ggHeader.php");
include("inc/ggFunctions.php");

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
	echo "<table cellpadding=5>";
	$rs = $db->query("select * from tblmember order by id");
	while ($row = mysqli_fetch_object($rs)) {
		echo "<tr><td>$row->id</td><td>$row->username</td><td>$row->fullname</td></tr>";
	}
	echo "</table>";
?>

  </div>
</div>

<?
include("inc/ggFooter.php");
?>