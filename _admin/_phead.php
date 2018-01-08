<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$user = load_user(0);
$max = isset($_REQUEST['max'])? $_REQUEST['max']:15;

if ($user->id == 0 || $user->rank<8) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php"; 
    </script>';
    exit(0);
}
?>
<a href="_sellpin.php">Sell Pin</a>&nbsp;&nbsp;&nbsp;
<a href="_resetpassword.php">Reset Password</a>&nbsp;&nbsp;&nbsp;
<a href="_resetpassword2.php">Reset 2nd Password</a>&nbsp;&nbsp;&nbsp;
<a href="_resetprofile.php">Reset Profile</a>&nbsp;&nbsp;&nbsp;
<a href="_changeupline.php">Change Upline</a>
<br><br>