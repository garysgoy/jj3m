<?
if ($_SERVER['HTTP_HOST']<>"jj3m.com" && $_SERVER['HTTP_HOST']<> "localhost") {
	//header("location: http://jj3m.com/login.php");
}
include ("_login_chk.php");

$username = "";
$password = "";
if(isset($_POST['username'])) {
$username = $_POST['username'];
$password = $_POST['password'];
}

$lang=1;
$ls = new stdClass();
$ls->login = array("Login to System","MMM 会员登入","MMM 會員登入!");
$ls->email = array("Email","电子邮箱","電子郵箱");
$ls->password = array("password","登入密码","登入密碼");
?>
<!DOCTYPE html>

<html>

<head>



    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">



    <!-- Page title -->

    <title>洲际 3M</title>



    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->



    <!-- Vendor styles -->

    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/font-awesome.css" />

    <link rel="stylesheet" href="/assets/vendor/metisMenu/dist/metisMenu.css" />

    <link rel="stylesheet" href="/assets/vendor/animate.css/animate.css" />

    <link rel="stylesheet" href="css/bootstrap.css" />



    <!-- App styles -->

    <link rel="stylesheet" href="/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />

    <link rel="stylesheet" href="/assets/fonts/pe-icon-7-stroke/css/helper.css" />

    <link rel="stylesheet" href="css/style1.css">

</head>

<body class="blank" style=" background-image:url(images/bg/background1.jpg);background-origin:content;background-position:50% 50%; background-size:cover;background-repeat:no-repeat;">



<!-- Simple splash screen-->

<!--[if lt IE 7]>

<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>

<![endif]-->



<div class="color-line"></div>



<div class="pull-left m">

    <!--

    <a href="" class="btn btn-primary">规则</a>

    -->

</div>



<div class="login-container">

    <div class="row">

        <div class="col-md-12">

            <div class="text-center m-b-md">
            <img src="images/logo-jj.png" width=300></img>
            <!--
				<font color="#CCCCCC">
                <h3>登录会员社区</h3>

                <small>我们需要你给予这个世界更多的爱心</small>
				</font>
                -->
            </div>

            <div class="hpanel" style="opacity: 0.9;">

                <div class="panel-body">

                        <form action="" id="loginForm" method="post">

						<!--<strong style="color:red">抱歉，现在系统暂停维护中，稍后开放，谢谢您的等待</strong>-->


                            <div class="form-group">

                                <label class="control-label" for="username">用户名</label>

                                <input type="text" placeholder="name@161.com" title="请输入你的邮箱地址" required value="" name="username" id="username" class="form-control">

                                <span class="help-block small">邮箱为您的用户名</span>

                            </div>

                            <div class="form-group">

                                <label class="control-label" for="password">密码</label>

                                <input type="password" title="请输入您的密码" placeholder="" required value="" name="password" id="password" class="form-control">

                                <span class="help-block small">登录密码</span>

                            </div>

<?
if ($ErrMsg<>"") {
  echo "<h3 style='color:red'>$ErrMsg</h3>";
}
?>
                            <button class="btn btn-success btn-block">登录</button>
<!--
                            <a class="btn btn-default btn-block" href="/web/index/forgot_password">忘记密码？</a>
-->
                        </form>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-12 text-center">



            <strong>Mavrodi Mondial Moneybox </strong> - 中国社区 <br/> 2015 MMM All Right Reserved

        </div>

    </div>

</div>



</div>



</div>



<!-- Vendor scripts -->

<script src="/js/dist/jquery.min.js"></script>

<script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>

<script src="/assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>

<script src="/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="/assets/vendor/metisMenu/dist/metisMenu.min.js"></script>

<script src="/assets/vendor/iCheck/icheck.min.js"></script>

<script src="/assets/vendor/sparkline/index.js"></script>

<script src="/assets/vendor/toastr/build/toastr.min.js"></script>





<script src="/assets/scripts/alert.js?v=1448013120"></script>
<!-- App scripts -->

<script src="/assets/scripts/homer.js"></script>
<script>
 toastr.options = {
          "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "5000",
  "hideDuration": "5000",
  "timeOut": "5000",
  "extendedTimeOut": "5000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
        };
$(document).ready(function() {
	 //toastr.warning('注意， 系统在北京时间下午5:30进行系统维护，维护期间无法登录，6:30系统恢复正常，谢谢');
	});

</script>

</body>

</html>