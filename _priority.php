<?
include("inc/ggDbconfig.php");
include("inc/ggFunctions.php");

$id = isset($_REQUEST['id'])? $_REQUEST['id'] : 0;
$pr = isset($_REQUEST['pr'])? $_REQUEST['pr'] : 0;
$em = isset($_REQUEST['em'])? $_REQUEST['em'] : "";

if ($em <> "") {
	$mem = ggGetMemberID($em);
	echo $mem->user_id;
	$hh = ggFetchObject("select * from tblhelp	where mem_id = $mem->user_id and status='O' order by g_date limit 0,1");
	$id = $hh->id;
}

if ($id > 0 and $pr <> 0) {
	if ($rs = $db->query("update tblhelp set priority = (priority + $pr) where id = $id")) {
		echo "Success";
	} else {
		echo 'Error Update pr: '. $db->error;
	}
} else {
	echo "Invalid ID or Direction";
}
?>