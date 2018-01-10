<?php
include_once("inc/ggInit.php");

if ($user->rank<5) {
  header("location: login.php");
}
//$page_css[] = "";
$page_title = $mls->dashboard[$lang];
$page_nav["dashboard"]["active"] = true;

$ls = new stdClass();
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
  </div>
</div>

<?
include("inc/ggFooter.php");
?>