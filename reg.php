<?
require_once("inc/ggDbconfig.php");
require_once("inc/init.php");
require_once("inc/config.ui.php");

//$page_css[] = "";
$page_title = $mls->register[$lang];
$page_nav["mem_mgt"]["sub"]["register"]["active"] = true;
$ref= (isset($_GET['ref']))? $_GET['ref']:"mem002";
$lang= (isset($_GET['l']))? $_GET['l']:"0";
setcookie("lang", $lang);

$setup = load_setup();

$ls = new stdClass();
$ls->title = array("Member Registration","注册新会员","註冊新会员");
$ls->username = array("Username","登入账号","登入帳號");
$ls->fullname = array("Fullname","姓名","姓名");
$ls->country = array("Country","国家","國家");
$ls->phoneno = array("Phone No","手机号码","手機號碼");
$ls->email = array("E-mail","邮箱","郵箱");
$ls->password = array("Password","登入密码","登入密碼");
$ls->cpassword = array("Confirm Password","确认登入密码","確認登入密碼");
$ls->sponsorusername = array("Refer By","推荐人账号","推薦人帳號");
$ls->confirmsponsor = array("Confirm Sponsor Name","确认推荐人名字 ","確認推薦人姓名");
$ls->pinno = array("PIN No","激活码","激活碼");
$ls->secondpass = array("Please enter your second password","请输入您的二级密码","請輸入你的二級密碼");
$ls->bconfirm = array("Register","注册","註冊");
$ls->bcancel = array("Cancel","取消","取消");
$ls->terms = array("I fully understand and agree all the Terms and Conditions.","我已经完全了解条规。","我已經完全了解條規");

$ls->pusername = array("username must be $setup->username_len characters and above, only alphabets and numbers", "登入账号 - 6个字以上，只可以英文字母和数字，不能有特殊字符","登入賬號 - 6個字以上，只可以英文字母和數字，不能有特殊字符");
$ls->pfullname = array("Fullname as per your ID card", "姓名 - 可以填写中文名","姓名 - 可以填寫中文名");
$ls->pcountry = array("Select Country","选择国籍","選擇國籍");
$ls->pphoneno = array("Phone no." ,"手机号码","手機號碼");
$ls->pemail   = array("E-mail","邮箱","郵箱");
$ls->ppassword = array("Password - must be $setup->password_len characters and above, must contain a least one digit","登入密码 - 最少 $setup->password_len 个字以上，最少要有一个数字","登入密碼 - 最少 $setup->password_len 個字以上，最少要有一個數字");
$ls->pconfirmpassword = array("Confirm Password ","确认登入密码","確認登入密碼");
$ls->psponsorusername = array("Referred By","介绍人账号","介紹人賬號");
$ls->psecondpassword = array("Second Password ","二级密码","二級密碼");
$ls->successful = array("Added Successfully","注册顺利完成","註冊順利完成");
$ls->load_pincode = array("Load PIN","提取激活码","提取激活碼");

$rank = 5;
include("inc/header0.php");
?>
<!-- Page content -->
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
		<form method="POST" id="regForm" name="regForm">
		  <div class="form-group register-form col-md-6">
			<label for="username"><? echo $ls->username[$lang]; ?> <span class="require-field">*</span></label> <span id="errmsg1" style="font-size:10px; color:#ff0000;"></span>
			<input type="text" class="form-control" name="username" id="username" value="<? echo $username; ?>" placeholder="<? echo $ls->pusername[$lang]; ?>" />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="email"><? echo $ls->email[$lang]; ?> <span class="require-field">*</span></label> <!--span id="errmsg3" style="font-size:10px; color:#ff0000;"></span-->
			<input type="email" class="form-control" name="email" id="email" value="<? echo $email; ?>" placeholder="<? echo $ls->email[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="phone"><? echo $ls->fullname[$lang]; ?>. <span class="require-field">*</span></label>
			<input type="text" class="form-control" name="fullname" id="fullname" value="<? echo $fullname; ?>" placeholder="<? echo $ls->pfullname[$lang]; ?>" required />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="phone"><? echo $ls->phoneno[$lang]; ?>. <span class="require-field">*</span></label>
			<input type="text" class="form-control" name="phone" id="phone" value="<? echo $phone; ?>" placeholder="<? echo $ls->pphoneno[$lang]; ?>" required />
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
      <input type="text" tabindex=-1 class="form-control" name="sponsor" id="sponsor" value="<? echo $ref; ?>" placeholder="<? echo $ls->psponsorusername[$lang]; ?>" readonly />
      </div>

<!--
		  <div class="form-group register-form col-md-6">
			<label for="sponsor"><? echo $ls->sponsorusername[$lang]; ?> <span class="require-field">*</span></label>
			<input type="text" class="form-control" name="sponsor" id="sponsor" onblur="checkSponsor()" value="<? echo $user->username; ?>" placeholder="<? echo $ls->psponsorusername[$lang]; ?>" readonly />
		  </div>
		  <div class="form-group register-form col-md-6">
			<label for="sponsor2"><? echo $ls->confirmsponsor[$lang]; ?> <span class="require-field">&nbsp;</span></label>
			<input type="text" class="form-control" name="sponsor2" id="sponsor2" value="" readonly />
		  </div>
-->
<?
$use_pin=false;
if ($use_pin) {
?>
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
<? } ?>
		  <div class="form-group col-md-6">
				<label for="agree">
				  &nbsp;&nbsp;<input type="checkbox" name="agree" id="agree" value="1" required /> <? echo $ls->terms[$lang]; ?>
				</label>
		  </div>
		  <p style="text-align:center;">
			  <button class="btn btn-default btn-success" onclick="doSubmit(this)" value="reg"><? echo $ls->bconfirm[$lang]; ?></button>
		  </p>
		</form>
	  </div>
	</div>
</div>

<script>
function doSubmit(n) {
  n.disabled = true;
  $.ajax({
    url:"_action_" + n.value + ".php",
    type: "POST",
    data: $("#"+n.value+"Form").serialize(),
    dataType: "json",
    success:function(res){
      if (res.status=="success") {
				$.messager.alert("<? echo $ls->title[$lang]; ?>","<b style='color: blue;'>"+ res.username +"<br><br><? echo $ls->successful[$lang]; ?>","info",function(r){
	          location.href = "login.php";
				});
      } else {
				$.messager.alert("<? echo $ls->title[$lang]; ?>",res.msg,"error");
      }
      n.disabled = false;
    },
    error:function(XMLHttpRequest, textStatus, errorThrown){
      alert(txtStatus);
      n.disabled = false;
    }
  });
}

function doSave(btn) {
	btn.disabled = true;
	$('#regForm').form('submit',{
		url: "register_add.php",
		success: function(res){
			var res = JSON.parse(res);
			if (res.status == "success") {
				$.messager.alert("<? echo $ls->title[$lang]; ?>","<b style='color: blue;'>"+ res.username +"<br><br><? echo $ls->successful[$lang]; ?>","info",function(r){
				location.href="login.php";
				});
			} else {
				$.messager.alert("<? echo $ls->title[$lang]; ?>",res.msg,"error");
			}
		}
	});
}
function checkSponsor() {
	var sponsor = document.getElementById("sponsor").value;
	$.post('register_chk.php', {sponsor: sponsor}, function(data) {
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
//include("_script.php");
  include("inc/scripts.php");
  //include("_footer.php");
?>