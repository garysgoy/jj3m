<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");
include("inc/ggValidate.php");
//include("_sms.php");

$debug=false;
$req = ($debug)? $_GET:$_POST;

$act = $req['act'];
$hash = $req['hash'];
$message = $req['message'];

echo json_encode(array("status"=>"success","msg"=>"act $act $hash $message"));
?>
