<?php
include("../_dbconfig.php");


if ($user->id == 0 || $user->rank<9) {
    echo '<script language="JavaScript" type="text/javascript">
    top.location.href = "../index.php";
    </script>';
    exit(0);
}

include("__util.php");
/*
$user = load_user(0);
if ($user->id==0) {
	echo '<script language="JavaScript" type="text/javascript">top.location.href = "login.php";</script>';
	exit();
}
*/
?>
