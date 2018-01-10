<?php
	session_start();
	include("./phptextClass.php");

	/*create class object*/
	$phptextObj = new phptextClass();
	/*phptext function to genrate image with text*/
	$phptextObj->phpcaptcha('#000','#FEC',120,40,5,80);
 ?>