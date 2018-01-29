<?php
include_once("inc/ggInit.php");
if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}

$ll = ($lang>0)? "&l=".$lang:"";
if ($server==0) {
  $refurl = "http://localhost/php/jj3m/reg.php?ref=".$user->username.$ll;
} else if ($app_code=="jj") {
  $refurl = "http://mlmsolution.net/_jj3m3/reg.php?ref=".$user->username.$ll;
} else {
  $refurl = "http://mlmsolution.net/3m/reg.php?ref=".$user->username.$ll;
}
include ("tools/phpqrcode/qrlib.php");
$file = "uploads/".$user->id.".png";
QRcode::png($refurl, $file, "H", 10, 2);


//$page_css[] = "";
$page_title = $mls->reflink[$lang];
$page_nav["mem_mgt"]["sub"]["reflink"]["active"] = true;

$ls = new stdClass();
$ls->reflink = array("Referral Link","推荐链接","推薦連結");
$ls->scan = array("Scan QRCode","扫描二维码","掃描二維碼");

include("inc/ggHeader.php");

?>
<div id="main" role="main">
  <? include("inc/ribbon.php"); ?>
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row" style="padding:15px;">
      <div class="panel panel-bar">
        <div class="panel-heading">
          <h4><i class="fa fa-user"></i> <? echo $ls->reflink[$lang]; ?></h4>
        </div>
        <div class="panel-body" style="padding:20px;">
          <a target="_blank" style="color:#d84646; text-transform:lowercase;" href="<? echo $refurl; ?>" id="to_copy_text"><b><? echo "&nbsp;&nbsp;&nbsp;".$refurl; ?></b></a><br>
          <img width="250px;" height="250px;" src="<? echo $file; ?>"/><br>
          <? echo "&nbsp;&nbsp;&nbsp;".$ls->scan[$lang]; ?>
        </div>
      </div>
    </div>

  </div>
</div> <!-- end Page Content -->

<?
include("_script.php");
include("_footer.php");
?>