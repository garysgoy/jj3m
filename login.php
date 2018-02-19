<?
include("inc/ggDbconfig.php");

$ls = new stdClass();
$ls->title = array("3M System","3M 互助系统","3M 互助系統");
$ls->login = array("Login","会员登入","會員登入!");
$ls->username = array("Username","用戶名","用戶名");
$ls->email = array("Can use Email as your username","用戶名或者电子邮箱","用戶名或者電子郵箱");
$ls->password = array("Login Password","登入密码","登入密碼");
$ls->sec_code = array("Security Code","验证码","驗證碼");
$ls->noaccount = array("No account?","没有账号？","");
$ls->register = array("Register here","注册账号","驗證碼");

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
	<link rel="stylesheet" href="css/my-login.min.css" />
</head>
<? $bgfile = ($app_code=="jj")? "1":"2"; ?>
<body class="my-login-page" style=" background-image:url(images/bg/background<? echo $bgfile; ?>.jpg);background-origin:content;background-size:cover;background-repeat:no-repeat;">

<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="images/<? echo $app_code; ?>/logo.png"></img>
					</div>
					<div class="brand-text">
						<? echo $ls->title[$lang]; ?>
					</div>
					<div class="card fat">
						<div class="card-body">
						<form action="" id="loginForm" method="post">

								<div class="form-group">
									<label for="username"><? echo $ls->username[$lang]; ?></label>
									<input id="username" type="text" class="form-control" name="username" value="" required autofocus>
								</div>

								<div class="form-group">
									<label for="password"><? echo $ls->password[$lang]; ?>
										<!--
										<a href="forgot.html" class="float-right">
											Forgot Password?
										</a> -->
									</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								</div>
<? if ($setup->use_captcha==1) { ?>
								<div class="form-group">
									<label for="password"><? echo $ls->sec_code[$lang]; ?>
									<a tabindex=-1 style="margin-left:10px;" href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='captcha.php'">
										<img id="captcha_img" src="captcha.php" width="110px">
									</a>
									</label>
									<input id="sec_code" type="text" class="form-control" name="sec_code" required>
								</div>
<? } ?>
<!--								<div class="form-group">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div> -->

								<div class="form-group">
									<button  id="login-btn" class="btn btn-success btn-block" onclick="doSubmit(this)" value="login"><? echo $ls->login[$lang]; ?></button>
								</div>
								
								<div class="margin-top20 text-center">
									<? echo $ls->noaccount[$lang]; ?> <a href="reg.php"><? echo $ls->register[$lang];?></a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2018 &mdash; <? echo $ls->title[$lang]; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery211.min.js"></script>
	<script src="js/bootstrap337.min.js"></script>
	<script src="js/my-login.min.js"></script>
</body>
</html>