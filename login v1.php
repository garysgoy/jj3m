<?
include("inc/ggDbconfig.php");

$ls = new stdClass();
$ls->title = array("3M System","3M 互助系统","3M 互助系統");
$ls->login = array("Login to System","会员登入","會員登入!");
$ls->username = array("Username","用戶名","用戶名");
$ls->email = array("Can use Email as your username","用戶名或者电子邮箱","用戶名或者電子郵箱");
$ls->password = array("Login Password","登入密码","登入密碼");
$ls->sec_code = array("Security Code","验证码","驗證碼");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><? echo $ls->title[$lang]; ?></title>
	<link rel="shortcut icon" type="image/ico" href="images/<? echo $app_code; ?>/favicon.ico" />

	<link rel="stylesheet" href="css/bootstrap.min.css" />
<!--
	<link rel="stylesheet" href="css/3m/style1.css">
-->
<style>
.hpanel > .panel-heading{color:inherit;font-weight:600;transition:all .3s;border:1px solid transparent;padding:10px 4px;}
.hpanel > .panel-footer{color:inherit;border:1px solid #e4e5e7;border-top:none;font-size:90%;background:#f7f9fa;}
.hpanel.panel-collapse > .panel-heading,.hpanel .hbuilt{background:#fff;border:1px solid #e4e5e7;border-radius:2px;border-color:#e4e5e7;padding:10px;}
.hpanel .panel-body{background:#fff;border:1px solid #e4e5e7;border-radius:2px;position:relative;padding:20px;}
.panel-collapse .panel-body{border:none;}
.hpanel{background-color:none;border:none;box-shadow:none;margin-bottom:25px;}
.panel-tools{display:inline-block;float:right;margin-top:0;position:relative;padding:0;}
.hpanel .alert{margin-bottom:0;border-radius:0;border:1px solid #e4e5e7;border-bottom:none;}
.panel-tools a{margin-left:5px;color:#9d9fa2;cursor:pointer;}
.hpanel.hgreen .panel-body{border-top:2px solid #62cb31;}
.hpanel.hblue .panel-body{border-top:2px solid #3498db;}
.hpanel.hyellow .panel-body{border-top:2px solid #ffb606;}
.hpanel.hviolet .panel-body{border-top:2px solid #9b59b6;}
.hpanel.horange .panel-body{border-top:2px solid #e67e22;}
.hpanel.hred .panel-body{border-top:2px solid #e74c3c;}
.hpanel.hreddeep .panel-body{border-top:2px solid #c0392b;}
.hpanel.hnavyblue .panel-body{border-top:2px solid #34495e;}
.hpanel.hbggreen .panel-body{background:#62cb31;color:#fff;border:none;}
.hpanel.hbgblue .panel-body{background:#3498db;color:#fff;border:none;}
.hpanel.hbgyellow .panel-body{background:#ffb606;color:#fff;border:none;}
.hpanel.hbgviolet .panel-body{background:#9b59b6;color:#fff;border:none;}
.hpanel.hbgorange .panel-body{background:#e67e22;color:#fff;border:none;}
.hpanel.hbgred .panel-body{background:#e74c3c;color:#fff;border:none;}
.hpanel.hbgreddeep .panel-body{background:#c0392b;color:#fff;border:none;}
.hpanel.hbgnavyblue .panel-body{background:#34495e;color:#fff;border:none;}
</style>
</head>

<? $bgfile = ($app_code=="jj")? "1":"2"; ?>
<body class="blank" style=" background-image:url(images/bg/background<? echo $bgfile; ?>.jpg);background-origin:content;background-size:cover;background-repeat:no-repeat;">

<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="login-container">
	<div class="row">
		<div class="col-sm-12">
			<div class="text-center m-b-md">
<?
$logo = ($app_code=="3m")? "images/logo.png":"img/logo-o.png";
?>				
			<img src="images/<? echo $app_code; ?>/logo.png" style='margin-top: 40px; width: 200px;'>
			<br><b style='color:green;font-size:18px;'><? echo $ls->title[$lang]; ?></b></img>
			</div>

			<div class="hpanel" style="opacity: 0.5;">
				<div class="panel-body">
						<form action="" id="loginForm" method="post">
							<input type="hidden" id="act" value="login">
							<div class="form-group">
								<label class="control-label" for="username"><? echo $ls->username[$lang]; ?></label>
								<input type="text" placeholder="name@163.com" title="<? echo $ls->username[$lang]; ?>" required value="" name="username" id="username" autocomplete="off" class="form-control">
							</div>

							<div class="form-group">
								<label class="control-label" for="password"><? echo $ls->password[$lang]; ?></label>
								<input type="password" title="password" placeholder="<? echo $ls->password[$lang]; ?>" required value="" name="password" id="password" autocomplete="off" class="form-control">
							</div>
<? if ($setup->use_captcha==1) { ?>
							<div class="form-group">
								<label class="control-label" for="password"><? echo $ls->sec_code[$lang]; ?>
									<a tabindex=-1 style="margin-left:10px;" href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='captcha.php'">
										<img id="captcha_img" src="captcha.php" width="110px">
									</a>
								</label>
								<input type="text" placeholder="<? echo $ls->sec_code[$lang]; ?>" name="sec_code" id="sec_code" class="form-control">
							</div>
<? } ?>
							<button  id="login-btn" class="btn btn-success btn-block" onclick="doSubmit(this)" value="login"><? echo $ls->login[$lang]; ?></button>
<!--
							<a class="btn btn-default btn-block" href="/web/index/forgot_password">忘记密码？</a>
-->
						</form>
				</div>
			</div>
		</div>
	</div>

</div>
</div>
</div>

<!-- Vendor scripts -->
<script src="./js/libs/jquery-3.2.1.min.js"></script>
<script src="./js/bootstrap/bootstrap.min.js"></script>

<!--
<script src="./js/3m/toastr.min.js"></script>
<script src="./js/libs/jquery-ui-1.10.3.min.js"></script>
<script src="/assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="/assets/vendor/iCheck/icheck.min.js"></script>
<script src="/assets/vendor/sparkline/index.js"></script>
<script src="/assets/vendor/toastr/build/toastr.min.js"></script>
-->
<script>
$(document).ready(function(){
	$("#loginForm").submit(function(event){
		event.preventDefault();
	});
});

$(document).keypress(function (e) {
	if (e.which == 13) {
		if ($("#login_btn").attr("disabled") == false) {
			doLogin();
		}
	}
});

function doSubmit(n) {
	n.disabled = true;
	$.ajax({
		url:"_action_" + n.value + ".php",
		type: "POST",
		data: $("#"+n.value+"Form").serialize(),
		dataType: "json",
		success:function(result){
		  if (result.status=="success") {
					if (result.url) {
					  location.href = result.url;
					} else {
					  location.reload();
					}
		  } else {
					alert(result.msg);
		  }
		  n.disabled = false;
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
		  alert(txtStatus);
		  n.disabled = false;
		}
  });
}

</script>
</body>
</html>