<?php
include_once("inc/ggInit.php");

//$page_css[] = "";
$page_nav["announcement"]["active"] = true;
$page_title = $mls->announcement[$lang];


include("inc/ggHeader.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<? include("inc/ribbon.php"); ?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row" style="padding: 15px 15px;">
      <!-- GG Start -->
<?
    $news = $db->query("select * from tblnews where status='A' order by newsdate desc");
    while ($row = mysqli_fetch_object($news)) {
        $date = new datetime($row->newsdate);
        $day = $date->format('d');
        $month = strtoupper($date->format('M y'));
        echo "<div class='col-md-12'><div class='speech-bubble-container'><div class='dot'><p style='font-size:20px; font-weight:bold; margin-bottom: 10px;'>$day</p><p style='font-size:12px;'>$month</p></div>
            <div class='speech-bubble'>
            <h3 class='popover-title'>$row->title2</h3>
            <div>$row->content2<p style='border-top: 1px solid #ccc; margin: 10px 0 0 0; padding: 5px 0 0 0;'>Admin</p>
            </div></div></div></div>";
    }
?>

      <!-- GG End -->
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