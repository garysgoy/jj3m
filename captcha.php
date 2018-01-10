<?php
	session_start();
	include("./tools/phpcaptcha/phptextClass.php");

	/*create class object*/
	$phptextObj = new phptextClass();
	/*phptext function to genrate image with text 56d9ea 8c2c11*/
	$phptextObj->phpcaptcha('#45f10a','#24a618',120,35,0,10);
 ?>