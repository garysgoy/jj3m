<?php
include_once("inc/ggInit.php");

if ($user->logged==0 || $user->rank<1) {
  //header("location: login.php");
}

$page_css[] = "";
$page_nav["dashboard"]["active"] = true;
$page_title = $mls->dashboard[$lang];

$ls->title = array("Change Password","更改密码","更改密碼");
$ls->title = array("Change Second Password","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");

$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");

$ls->i_want_ph =array("I want to provide help","我要帮助别人","我要幫助別人");
$ls->i_want_gh =array("I want to get help","我需要别人的帮助","我需要別人的幫助");
$ls->participants = array("Participants","参与者","參與者");

$ls->ph_desc = array("After submitting your PH request, please wait 10-30 days for matching ","申请完成后，请等待系统10-30日随机分配受善需求","申請完成後，請等待系統10-30日隨機分配受善需求");
$ls->ph_amount = array("Help Amount","帮助金额","幫助金額");
$ls->ph_comment = array("Message","备注","備註");
$ls->ph_commentp = array("Please indicate your message to the other party, eg: Time and Phone number to contact","填写你要传给对方的讯息，例如联络时间，联络方式等等。。。","填寫你要傳給對方的信息，例如聯繫時間，聯繫方式等等。。。");
$ls->ph_warning = array("I understand and accept the risk, and I decide to join this program","我已完全了解所有风险。我决定参与, 尊重3M的文化与传统","我已完全了解所有風險。我決定參與，尊重3M的文化與傳統");
$ls->close = array("Close","关闭","關閉");

$ls->gh_balance = array("Balance &nbsp;","现有人民币","現有人民幣");
$ls->gh_available = array("Available","可提人民币","可提人民幣");
$ls->gh_amount = array("Help Amount","提领金额","提領金額");
$ls->gh_amountp = array("RMB","人民币","人民幣");
$ls->gh_comment = array("Message","备注","備註");

$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");

include("inc/ggHeader.php");
include("inc/ggFunctions.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		include("inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> <? echo $mls->dashboard[$lang]; ?> <span>> <? echo $mls->dashboard[$lang]; ?></span></h1>
			</div>
		</div>

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

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

<!-- PAGE RELATED PLUGIN(S)
<script src="..."></script>-->

<?php
	//include footer
	//include("inc/ggFooter.php");
?>