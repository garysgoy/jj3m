<?php
include_once("inc/ggInit.php");

//$page_css[] = "";
$page_title = $mls->profile[$lang];
$page_nav["account"]["sub"]["profile"]["active"] = true;

$ls = new stdClass();
$ls->title = array("Update Profile","个人资料","個人資料");
$ls->profile = array("Profile","个人资料","個人資料");
$ls->username = array("Username","登入账号","");
$ls->email = array("Email","邮箱","郵箱");
$ls->fullname = array("Full Name","姓名","姓名");
$ls->mobile = array("Mobile","手机号码","手機號碼");
$ls->othcontact = array("Other Contact Info","其他联系方式","其他聯繫方式");
$ls->wechat = array("Wechat","微信","微信");
$ls->alipay = array("Alipay","支付宝","支付寶");
$ls->bankname = array("Bank name","银行名称","銀行名稱");
$ls->bankacc = array("Bank account number","银行卡号","銀行卡號");
$ls->bankbranch = array("Bank branch","银行分行","銀行分行");
$ls->btc = array("BTC Address","BTC 比特币钱包地址","BTC 比特幣錢包地址");
$ls->eth = array("ETH Address","ETH 以太币钱包地址","ETH 以太幣錢包地址");
$ls->sec_password = array("2nd Password","二级密码","二級密碼");
$ls->resec_password = array("Confirm 2nd Password","确认二级密码","確認二級密碼");
$ls->setup_password = array("Setup your 2nd Password","设定你的二级密码","設定你的二級密碼");
$ls->enter_password = array("Enter your 2nd Password","请输入你的二级密码","請輸入你的二級密碼");
$ls->submit = array("Sumbit","提交","提交");
$ls->successful = array("Profile Updated","个人资料已保存","個人資料已保存");

include("inc/ggHeader.php");
?>
<style>
#wrapper .container {
    padding: 20px !important;
}
.panel-body {
    padding: 20px !important;
}
</style>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<? include("inc/ribbon.php"); ?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row" style="padding: 15px 15px;">

		<!-- Page content -->
		<!--<div class="container content-body">-->
			<!--div id="welcome-bar"><i class="fa_icon fa fa-smile-o" style="padding-top: 12px;"></i> ezmoney，欢迎回来！</div-->
  <!--div class="container content-body"-->
	<div class="panel panel-default">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user-secret"></i> <? echo $ls->title[$lang]; ?></h3>
<!--		<span class="small-tag">请填写以下所需要 [<span class="required-tag">*</span>] 的资料，才可以继续浏览网页</span>
-->	  </div>
	  <div class="panel-body">
	  			<form action="" method="POST" id="profileForm" data-toggle="validator" autocomplete="off">
		  <div class="form-group">
			<label for="username"><? echo $ls->username[$lang]; ?> : <? echo $user->username; ?></label>
			<!--input type="text" class="form-control" name="username" id="username" value="ezmoney" disabled /-->
		  </div>
		  <!--div class="form-group">
			<label for="nickname">名字 : </label>
			<input type="text" class="form-control" name="nickname" id="nickname" value="" placeholder="昵称" disabled />
		  </div-->
		  <div class="form-group">
			<label for="email"><? echo $ls->email[$lang]; ?> : <? echo $user->email; ?></label>
			<!--input type="email" class="form-control" name="email" id="email" value="ezmoney@tmcc.us" placeholder="电邮" disabled /-->
		  </div>
		  <div class="form-group">
			<label for="fullname"><? echo $ls->fullname[$lang]; ?><span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="fullname" id="fullname" value="<? echo $user->fullname; ?>" placeholder="<? echo $ls->fullname[$lang]; ?>" <? echo ($user->fullname=="")?"required":"readonly"; ?> />
			<!--<span style="font-size:12px; color:#999;">* 一定要和银行账户姓名一样, 设定之后就不能更改</span>
		  -->
		</div>
		  <div class="form-group">
			<label for="mobile"><? echo $ls->mobile[$lang]; ?> <span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="phone" id="phone" value="<? echo $user->phone; ?>" placeholder="<? echo $ls->mobile[$lang]; ?>" <? echo ($user->phone=="")?"required":"readonly"; ?> />
		  </div>
<?
if ($setup->china_bank==1) {
?>
		  <div class="form-group">
			<label for="wechat"><? echo $ls->wechat[$lang]; ?></label><br/>
				<input type="text" class="form-control" name="wechat" id="wechat" value="<? echo $user->wechat; ?>" placeholder="<? echo $ls->wechat[$lang]; ?>" <? echo ($user->wechat=="")?"required":"readonly"; ?> />
		  </div>
		  <div class="form-group">
			<label for="alipay"><? echo $ls->alipay[$lang]; ?></label><br/>
				<input type="text" class="form-control" name="alipay" id="alipay" value="<? echo $user->alipay; ?>" placeholder="<? echo $ls->alipay[$lang]; ?>" <? echo ($user->alipay=="")?"required":"readonly"; ?> />
		  </div>
		  <div class="form-group">
			<label for="bankname"><? echo $ls->bankname[$lang]; ?><span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="bankname" id="bankname" value="<? echo $user->bankname[$lang]; ?>" placeholder="<? echo $ls->bankname[$lang]; ?>" />
		  <!--input type="text" class="form-control" name="bankname" id="bankname" value="44" placeholder="银行名称" required /-->
		  </div>
		  <div class="form-group">
			<label for="bankholder"><? echo $ls->bankacc[$lang]; ?><span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="bankaccount" id="bankaccount" value="<? echo $user->bankaccount; ?>" placeholder="<? echo $ls->bankacc[$lang]; ?>" <? echo ($user->bankaccount=="")?"required":"readonly"; ?> />
		  </div>
		  <div class="form-group">
			<label for="bankbranch"><? echo $ls->bankbranch[$lang]; ?></label>
			<input type="text" class="form-control" name="bankbranch" id="bankbranch" value="<? echo $user->bankbranch; ?>" placeholder="<? echo $ls->bankbranch[$lang]; ?>" />
		  </div>
<? } ?>
<?
if ($setup->btc==1) {
?>
		  <div class="form-group">
			<label for="btc"><? echo $ls->btc[$lang]; ?></label><br/>
				<input type="text" class="form-control" name="btc" id="btc" value="<? echo $user->btc; ?>" placeholder="<? echo $ls->btc[$lang]; ?>" <? echo ($user->btc=="")?"required":"readonly"; ?> />
		  </div>
		  <div class="form-group">
			<label for="eth"><? echo $ls->eth[$lang]; ?></label><br/>
				<input type="text" class="form-control" name="eth" id="eth" value="<? echo $user->eth; ?>" placeholder="<? echo $ls->eth[$lang]; ?>" <? echo ($user->eth=="")?"required":"readonly"; ?> />
		  </div>
<? } ?>
		  <!--div class="form-group">
			<label for="bankholder">银行账户姓名</label>
			<input type="text" class="form-control" name="bankholder" id="bankholder" value="GOY TIAN SENG" placeholder="银行账户姓名" readonly />
		  </div-->
<?
if($user->password2=="") {
	$prompt = $ls->setup_password[$lang];
} else {
	$prompt = $ls->enter_password[$lang];
}
?>
		  <div class="form-group">
			<label for="transpin"><? echo $prompt; ?><span class="required-tag">*</span></label>
			<input type="password" class="form-control" name="transpin" id="transpin" placeholder="<? echo $ls->sec_password[$lang]; ?>" required />
		  </div>
<?
if($user->password2=="") {
?>
		  <div class="form-group">
			<label for="transpin2"><? echo $ls->resec_password[$lang]; ?><span class="required-tag">*</span></label>
			<input type="password" class="form-control" name="transpin2" id="transpin2" placeholder="<? echo $ls->resec_password[$lang]; ?>" required />
		  </div>
<? } ?>
<!--
		  <div class="form-group">
			<label for="exampleInputFile">File input</label>
			<input type="file" id="exampleInputFile">
			<p class="help-block">Example block-level help text here.</p>
		  </div>
		  <div class="form-group">
			<label for="agree">
			  <input type="checkbox" name="agree" id="agree" value="1" required /> 我已经完全了解风险。
			</label>
		  </div-->
		  <p style="text-align:center;">
	  		  <a href="#" class="btn btn-default btn-success" onclick="doSave()"><? echo $ls->submit[$lang]; ?></a>
		  </p>
		  <input type="hidden" id="uid" name="uid" value="384" />
		</form>
			  </div>
	</div>
<!--/div-->
			</div> <!-- end Page Content -->
<script>
function doSave() {
	$('#profileForm').form('submit',{
		url: "profile_save.php",
		onSubmit: function(){
			return $(this).form('validate');
		},
		success: function(res){
			var res = JSON.parse(res);
			if (res.success) {
				$.messager.alert("<? echo $ls->title[$lang]; ?>","<? echo $ls->successful[$lang]; ?>","info",function(r){
					location.reload();
				});
			} else {
				$.messager.alert("<? echo $ls->title[$lang]; ?>",res.msg,"error");
			}
		}
	});
}
</script>

<?
include("_script.php");
include("_footer.php");
?>