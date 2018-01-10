<?
include_once("inc/ggInit.php");
$page_css[] = "";
$page_title = "Dashboard";
$page_nav["dashboard"]["active"] = true;

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

//include("inc/ggHeader.php");
//include("inc/ggFunctions.php");
?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
<?
//  include("../inc/ribbon.php");
?>

  <!-- MAIN CONTENT -->
  <div id="content">


  </div>
</div>


