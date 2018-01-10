<?php
	session_start();
	include("./phptextClass.php");

	/*create class object*/
	$phptextObj = new phptextClass();
	/*phptext function to genrate image with text*/

  $txtColor = "#".$_GET['txtColor'];
  $bgColor  = "#".$_GET['bgColor'];
  $width = 120;
  $height = 40;
  $nLine = 5;
  $nDot = 10;
  //$nColor = $_POST['P7'];
  // txtColor, bgColor, width, heigth, noiceLine, noiceDot, noiceColor
	$phptextObj->phpcaptcha($txtColor, $bgColor, $width, $height, $nLine, $nDot);
 ?>