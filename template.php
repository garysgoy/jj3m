<?php
include_once("inc/ggInit.php");

//$page_css[] = "";
$page_title = "Dashboard";
$page_nav["dashboard"]["active"] = true;


include("inc/ggHeader.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<? include("inc/ribbon.php"); ?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row" style="padding-left: 15px; padding-right: 15px;">




  	</div> <!-- END ROW -->
	</div> <!-- END MAIN CONTENT -->
</div> <!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
	//include required scripts
	include("inc/scripts.php");
?>