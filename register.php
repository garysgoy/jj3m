<?

include_once("inc/ggInit.php");
//$page_css[] = "";
$page_title = $mls->register[$lang];
$page_nav["register"]["active"] = true;

$setup = load_setup();

$ls = new stdClass();
$ls->title = array("Register New User","注册新用户","註冊新用戶");
$ls->username = array("Username","登入账号","登入帳號");
$ls->country = array("Country","国家","國家");
$ls->phoneno = array("Phone No","手机号码","手機號碼");
$ls->email = array("E-mail","邮箱","郵箱");
$ls->password = array("Password","登入密码","登入密碼");
$ls->cpassword = array("Confirm Password","确认登入密码","確認登入密碼");
$ls->sponsorusername = array("Sponsor's Userame","推荐人账号","推薦人帳號");
$ls->confirmsponsor = array("Confirm Sponsor Name","确认推荐人名字 ","確認推薦人姓名");
$ls->pinno = array("PIN No","激活码","激活碼");
$ls->secondpass = array("Please enter your second password","请输入您的二级密码","請輸入你的二級密碼");
$ls->bconfirm = array("Register","注册","註冊");
$ls->bcancel = array("Cancel","取消","取消");
$ls->terms = array("I fully understand and agree all the Terms and Conditions.","我已经完全了解条规。","我已經完全了解條規");

$ls->pusername = array("username must be $setup->username_len characters and above, only alphabets and numbers", "登入账号 - 6个字以上，只可以英文字母和数字，不能有特殊字符","登入賬號 - 6個字以上，只可以英文字母和數字，不能有特殊字符");
$ls->pcountry = array("Select Country","选择国籍","選擇國籍");
$ls->pphoneno = array("Phone no." ,"手机号码","手機號碼");
$ls->pemail   = array("E-mail","邮箱","郵箱");
$ls->ppassword = array("Password - must be $setup->password_len characters and above, must contain a least one digit","登入密码 - 最少 $setup->password_len 个字以上，最少要有一个数字","登入密碼 - 最少 $setup->password_len 個字以上，最少要有一個數字");
$ls->pconfirmpassword = array("Confirm Password ","确认登入密码","確認登入密碼");
$ls->psponsorusername = array("Sponsored By","介绍人账号","介紹人賬號");
$ls->psecondpassword = array("Second Password ","二级密码","二級密碼");
$ls->successful = array("Added Successfully","注册顺利完成","註冊順利完成");
$ls->load_pincode = array("Load PIN","提取激活码","提取激活碼");

$rank = 5;
include("inc/ggHeader.php");
?>
<!-- Page content -->
<div id="main" role="main">
  <? include("inc/ribbon.php"); ?>
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row" style="padding: 15px 15px;">

	<!--div id="welcome-bar"><i class="fa_icon fa fa-smile-o" style="padding-top: 12px;"></i> ezmoney，歡迎回來！</div-->
  <!--div class="container content-body"-->
	<div class="panel panel-default">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user"></i> <? echo $ls->title[$lang]; ?></h3>
	  </div>
	  <div class="panel-body">
		<form method="POST" id="regForm">
		  <div class="form-group register-form col-md-6">
			<label for="username"><? echo $ls->username[$lang]; ?> <span class="require-field">*</span></label> <span id="errmsg1" style="font-size:10px; color:#ff0000;"></span>
			<input type="text" class="form-control" name="username" id="username" value="<? echo $username; ?>" placeholder="<? echo $ls->pusername[$lang]; ?>" />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="email"><? echo $ls->email[$lang]; ?> <span class="require-field">*</span></label> <!--span id="errmsg3" style="font-size:10px; color:#ff0000;"></span-->
			<input type="email" class="form-control" name="email" id="email" value="<? echo $email; ?>" placeholder="<? echo $ls->email[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="phone"><? echo $ls->phoneno[$lang]; ?>. <span class="require-field">*</span></label>
			<input type="text" class="form-control" name="phone" id="phone" value="<? echo $phone; ?>" placeholder="<? echo $ls->pphoneno[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="country"><? echo $ls->country[$lang]; ?> <span class="require-field">*</span></label>
			<select name="country" class="form-control" style="width:98%;">
				<option value="NA"><? echo $ls->pcountry[$lang]; ?></option>
				<option value="CN">&#20013;&#22269; China</option>
				<option value="HK">&#39321;&#28207; Hong Kong</option>]
				<option value="ID">&#21360;&#24230;&#23612;&#35199;&#20122; Indonesia</option>
				<option value="MY">&#39532;&#26469;&#35199;&#20122; Malaysia</option>
				<option value="SG">&#26032;&#21152;&#22369; Singapore</option>
				<option value="TW">&#21488;&#28286; Taiwan</option>
				<option value="TL">&#27888;&#22269; Thailand</option>
			</select>
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="password"><? echo $ls->password[$lang]; ?> <span class="require-field">*</span></label>
			<input type="password" class="form-control" name="password" id="password" value="<? echo $password; ?>" placeholder="<? echo $ls->ppassword[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="password2"><? echo $ls->cpassword[$lang]; ?> <span class="require-field">*</span></label>
			<input type="password" class="form-control" name="repassword" id="repassword" value="<? echo $password2; ?>" placeholder="<? echo $ls->pconfirmpassword[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="sponsor"><? echo $ls->sponsorusername[$lang]; ?> <span class="require-field">*</span></label>
			<input type="text" class="form-control" name="sponsor" id="sponsor" onblur="checkSponsor()" value="<? echo $sponsor; ?>" placeholder="<? echo $ls->psponsorusername[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="sponsor2"><? echo $ls->confirmsponsor[$lang]; ?> <span class="require-field">&nbsp;</span></label>
			<input type="text" class="form-control" name="sponsor2" id="sponsor2" value="" readonly />
		  </div>
		  <div class="row">
		  <div class="form-group register-form col-md-6">
				<label for="pin"><? echo $ls->pinno[$lang]; ?>.&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="#" class="btn btn-default btn-success btn-xs" onclick="getpin()"><? echo $ls->load_pincode[$lang]; ?></a>
				</label>
				<input type="text" class="form-control" name="pin" id="pin" value=""/>
		  </div>
		  <div class="form-group register-form col-md-6">
				<label for=""><? echo $ls->secondpass[$lang]; ?></label>
				<input type="password" class="form-control" name="password2" id="password2" value="<? echo $password2; ?>" placeholder="<? echo $ls->psecondpassword[$lang]; ?>" required style="width:99%;" required />
		  </div>
			</div>
		  <!--div class="form-group">
			<label for="exampleInputFile">File input</label>
			<input type="file" id="exampleInputFile">
			<p class="help-block">Example block-level help text here.</p>
		  </div-->
		  <div class="form-group col-md-6">
				<label for="agree">
				  &nbsp;&nbsp;<input type="checkbox" name="agree" id="agree" value="1" required /> <? echo $ls->terms[$lang]; ?>
				</label>
		  </div>
		  <p style="text-align:center;">
			  <a href="#" class="btn btn-default btn-success" onclick="doSave()"><? echo $ls->bconfirm[$lang]; ?></a>
			  <a href="dashboard.php" class="btn btn-default btn-danger"><? echo $ls->bcancel[$lang]; ?></a>
		  </p>
		</form>
	  </div>
	</div>
</div>

<script>
function doSave() {
	$('#regForm').form('submit',{
		url: "register_add.php",
		success: function(res){
			var res = JSON.parse(res);
			if (res.status == "success") {
				$.messager.alert("<? echo $ls->title[$lang]; ?>","<b style='color: blue;'>"+ res.username +"<br><br><? echo $ls->successful[$lang]; ?>","info",function(r){
				location.reload();
				});
			} else {
				$.messager.alert("<? echo $ls->title[$lang]; ?>",res.msg,"error");
			}
		}
	});
}
function checkSponsor() {
	var Sponsor = document.getElementById("sponsor").value;
	$.get('register_chk.php', {sponsor: Sponsor}, function(data) {
  		document.getElementById("sponsor2").value = data;
	});
}
function getpin() {
	$.get('register_pin.php', {data: 1}, function(data){
    	document.getElementById("pin").value = data;
	});
}
</script>
<?
include("_script.php");
include("_footer.php");
?>