<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$id = isset($_REQUEST['id'])? $_REQUEST['id'] : 0;
$pr = isset($_REQUEST['pr'])? $_REQUEST['pr'] : 0;
$em = isset($_REQUEST['em'])? $_REQUEST['em'] : "";

if ($em <> "") {
	$mem = ggGetMemberID($em);
	echo $mem->user_id;
	$hh = ggFetchObject("select * from bear_help	where mem_id = $mem->user_id and status='O' order by g_date limit 0,1");
	$id = $hh->id;
}

if ($id > 0 and $pr <> 0) {
	if ($rs = $db->query("update bear_help set priority = priority + $pr where id = $id")) {
		$help = ggFetchObject("select * from bear_help whrere id=$id");
		$mem = ggFetchObject("select * from bear_users whrere user_id=$help->mem_id");
		header("location: __status.php");
	} else {
		die('update pr: '. $db->error);
	}
} else {
	echo "usage ?id=99&pr=-1";
	header("location: __status.php");
}
?>