<?
include("inc/ggDbconfig.php");

$lang=0;
$ls = new stdClass();
$ls->title = array("3M System","3M 互助系统","3M 互助系統");
$ls->login = array("Login to System","MMM 会员登入","MMM 會員登入!");
$ls->username = array("Username","用戶名","用戶名");
$ls->email = array("Can use Email as your username","用戶名或者电子邮箱","用戶名或者電子郵箱");
$ls->password = array("Login Password","登入密码","登入密碼");
$ls->sec_code = array("Security Code","验证码","驗證碼");

?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title><? echo $ls->title[$lang]; ?></title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
<!--    <link rel="stylesheet" href="css/3m/main.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
-->
<!--
    <link rel="stylesheet" href="/assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/assets/vendor/animate.css/animate.css" />
-->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/3m/style1.css">

<!--
    <link rel="stylesheet" href="/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/assets/fonts/pe-icon-7-stroke/css/helper.css" />
-->
</head>

<body class="blank" style=" background-image:url(images/bg/background1.jpg);background-origin:content;background-size:cover;background-repeat:no-repeat;">



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

        <div class="col-sm-12">
            <div class="text-center m-b-md">
            <img src="img/logo-o.png" width=80 style='margin-top: 40px;'>
            <br><b style='color:green;font-size:18px;'><? echo $ls->title[$lang]; ?></b></img>
            </div>

            <div class="hpanel" style="opacity: 0.8;">
                <div class="panel-body">
                        <form action="" id="loginForm" method="post">
                            <input type="hidden" id="act" value="login">
                            <div class="form-group">
                                <label class="control-label" for="username"><? echo $ls->username[$lang]; ?></label>
                                <input type="text" placeholder="name@163.com" title="<? echo $ls->username[$lang]; ?>" required value="" name="username" id="username" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="password"><? echo $ls->password[$lang]; ?></label>
                                <input type="password" title="请输入您的密码" placeholder="<? echo $ls->password[$lang]; ?>" required value="" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password"><? echo $ls->sec_code[$lang]; ?>
                                    <a style="margin-left:10px;" href="javascript:void(0)" class="red" onclick="document.getElementById('captcha_img').src='captcha.php'">
                                        <img id="captcha_img" src="captcha.php" width="110px">
                                    </a>
                                </label>
                                <input type="text" placeholder="<? echo $ls->sec_code[$lang]; ?>" name="sec_code" id="sec_code" class="form-control">
                            </div>
                            <button  id="login-btn" class="btn btn-success btn-block" onclick="doLogin()"><? echo $ls->login[$lang]; ?></button>
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
            <strong>Mavrodi Mondial Moneybox </strong><br> 2018 MMM All Right Reserved
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
            doLogin();
        }
    });

    function doLogin() {
        var act = $("#act").val();
        var username = $("#username").val();
        var password = $('#password').val();
        var sec_code = $('#sec_code').val();

        $.post("_action_login.php",{act:act,username:username,password:password,sec_code:sec_code},function(result){
            if(result.status == 'success') {
              document.location.href = "dashboard.php";
            } else {
                alert(result.msg);
              //show_msg(result.msg);
            }
        },"json");
    }
</script>
</body>

</html>