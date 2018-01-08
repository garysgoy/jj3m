<?php
include_once("inc/ggInit.php");

//$page_css[] = "";
$page_title = $mls->profile[$lang];
$page_nav["account"]["sub"]["profile"]["active"] = true;

$ls = new stdClass();
$ls->title = array("Profile","个人资料","");
$ls->username = array("Username","登入账号","");
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
		<h3 class="panel-title"><i class="fa fa-user-secret"></i> 个人资料</h3>
		<span class="small-tag">请填写以下所需要 [<span class="required-tag">*</span>] 的资料，才可以继续浏览网页</span>
	  </div>
	  <div class="panel-body">
	  			<form action="" method="POST" id="profileForm" data-toggle="validator" autocomplete="off">
		  <div class="form-group">
			<label for="username">登入账号 : <? echo $user->username; ?></label>
			<!--input type="text" class="form-control" name="username" id="username" value="ezmoney" disabled /-->
		  </div>
		  <!--div class="form-group">
			<label for="nickname">名字 : </label>
			<input type="text" class="form-control" name="nickname" id="nickname" value="" placeholder="昵称" disabled />
		  </div-->
		  <div class="form-group">
			<label for="email">电邮 : <? echo $user->email; ?></label>
			<!--input type="email" class="form-control" name="email" id="email" value="ezmoney@tmcc.us" placeholder="电邮" disabled /-->
		  </div>
		  <div class="form-group">
			<label for="fullname">姓名<span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="fullname" id="fullname" value="<? echo $user->fullname; ?>" placeholder="银行账户姓名" <? echo ($user->fullname=="")?"required":"readonly"; ?> />
			<span style="font-size:12px; color:#999;">* 一定要和银行账户姓名一样, 设定之后就不能更改</span>
		  </div>
		  <div class="form-group">
			<label for="mobile">手机号码 <span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="phone" id="phone" value="<? echo $user->phone; ?>" placeholder="手机号码" <? echo ($user->phone=="")?"required":"readonly"; ?> />
		  </div>
		  <br/>
		  <label for="others">其它联系方式</label><br/>
		  <div class="input-group">
			<span class="input-group-addon" id="wechat"><i class="fa fa-weixin"></i></span>
			<input type="text" class="form-control" name="wechat" placeholder="微信" aria-describedby="wechat" value="<? echo $user->wechat; ?>" />
		  </div>
		  <br/>
		  <div class="input-group">
			<span class="input-group-addon" id="whatsapp"><i class="fa fa-whatsapp"></i></span>
			<input type="text" class="form-control" name="whatsapp" placeholder="Whatsapp" aria-describedby="whatsapp" value="<? echo $user->whatsapp; ?>" />
		  </div>
		  <br/>
		  <div class="input-group">
			<span class="input-group-addon" id="line"><i class="fa fa-comment"></i></span>
			<input type="text" class="form-control" name="line" placeholder="Line" aria-describedby="line" value="<? echo $user->line; ?>" />
		  </div>
		  <br/>
		  <!--div class="radio form-group">
			<span style="font-weight:bold;">微信支付号</span><br/>
			  <label>
				<input type="radio" name="weixin" id="weixin0" value="0" checked> 无
			  </label>
		  </div>
		  <div class="radio form-group">
			  <label>
				<input type="radio" name="weixin" id="weixin1" value="1" > <input type="text" class="form-control" name="weixin_acc" id="weixin_acc" placeholder="微信支付号" value="" />
				<br/>想以微信钱包汇款或接款，请输入你的微信号
			  </label>
		  </div>
		  <br/>
		  <div class="radio form-group">
			<span style="font-weight:bold;">联系微信号</span><br/>
			  <label>
				<input type="radio" name="weixin_no" id="weixin_no0" value="0" checked> 无
			  </label>
		  </div>
		  <div class="radio form-group">
			  <label>
				<input type="radio" name="weixin_no" id="weixin_no1" value="1" > <input type="text" class="form-control" name="weixin_contact" id="weixin_contact" value="" placeholder="联系微信号" />
				<br/>想以微信联系，请输入你的微信号&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  </label>
		  </div-->
		  <br/>
		  <div class="form-group">
			<label for="alipay">支付宝</label><br/>
				<input type="text" class="form-control" name="alipay" id="alipay" value="<? echo $user->alipay; ?>" placeholder="支付宝" <? echo ($user->alipay=="")?"required":"readonly"; ?> />
		  </div>
		  <div class="form-group">
			<label for="bankname">银行名称<span class="required-tag">*</span></label>
			<select name="bankname" class="form-control">
   <?
    	$setup = load_setup();
        $banklist = explode(",",$setup->banklist);
        $count = count($banklist);
        for ($i=0; $i < $count; $i++) {
        	$bank = $banklist[$i];
            echo "<option value='$bank' ".(($bank==$user->bankname)? "selected":"").">$bank</option>";
        }
    ?>
</select>
			<!--input type="text" class="form-control" name="bankname" id="bankname" value="44" placeholder="银行名称" required /-->
		  </div>
		  <!--div class="form-group">
			<label for="bankholder">银行账户姓名</label>
			<input type="text" class="form-control" name="bankholder" id="bankholder" value="GOY TIAN SENG" placeholder="银行账户姓名" readonly />
		  </div-->
		  <div class="form-group">
			<label for="bankbranch">银行分行 (支行)</label>
			<input type="text" class="form-control" name="bankbranch" id="bankbranch" value="<? echo $user->bankbranch; ?>" placeholder="银行分行 (支行)" />
		  </div>
		  <div class="form-group">
			<label for="bankholder">银行账户号码<span class="required-tag">*</span></label>
			<input type="text" class="form-control" name="bankacc" id="bankacc" value="<? echo $user->bankaccount; ?>" placeholder="银行账户号码" <? echo ($user->bankaccount=="")?"required":"readonly"; ?> />
		  </div>
<?
if($user->password2=="") {
	$prompt = "请设定二级密码";
} else {
	$prompt = "请输入你的二级密码";
}
?>
		  <div class="form-group">
			<label for="transpin"><? echo $prompt; ?><span class="required-tag">*</span></label>
			<input type="password" class="form-control" name="transpin" id="transpin" placeholder="二级密码" required />
		  </div>
<?
if($user->password2=="") {
?>
		  <div class="form-group">
			<label for="transpin2">确认二级密码<span class="required-tag">*</span></label>
			<input type="password" class="form-control" name="transpin2" id="transpin2" placeholder="确认二级密码" required />
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
	  		  <a href="#" class="btn btn-default btn-success" onclick="doSave()">提交</a>
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