<?
include("../_dbconfig.php");
include("../_ggFunctions.php");
include("../_sms.php");

$rs = $db->query("select * from tblhelp where sms=0 and (status='P' or status='C') limit 3") or die("Err ".$db->error);
$ctr = mysqli_num_rows($rs);
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<? if ($ctr>0) { ?>
<META HTTP-EQUIV=Refresh CONTENT="4; URL=<? echo '_b_sms.php'; ?>"></META>
<? } ?>
</head>
<?
while ($row = mysqli_fetch_object($rs)) {
	$tt = $db->query("update tblhelp set sms = 1 where id = $row->id") or die("Err ".$db->error);
	echo sms_match($row->id);
	//echo $row->id;
}
?>