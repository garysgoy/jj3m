<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$mgr = $db->query("select * from tblmember where note1 <> '' order by nickname") or die("err ".$db->error);
echo "<table border=1 cellspacing=0 cellpadding=5>";
echo "<tr><td>序号</td><td>Email</td><td>昵称</td><td>电话</td><td>微信</td><td>Line</td><td>经理奖</td><td>代数奖</td></tr>";
$mamount = 0;
$lamount = 0;
$i = 1;
while ($row = mysqli_fetch_object($mgr)) {
    $manager    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $row->id and type='C' and op_type='M' and op_level=1 and date_release <= now()");
    $levels     = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $row->id and type='C' and op_type='M' and op_level>1 and date_release <= now()");
	echo "<tr><td>$i</td><td>$row->email</td><td>$row->nickname</td><td>$row->phone</td><td>$row->wechat</td><td>$row->line</td><td align=right>".number_format($manager->amt)."</td><td align=right>".number_format($levels->amt)."</td></tr>";
	$i += 1;
	$mamount += $manager->amt;
	$lamount += $levels->amt;
}
echo "<tr bgcolor=yellow><td colspan=6>&nbsp;</td><td align=right>".number_format($mamount)."</td><td align=right>".number_format($lamount)."</td></tr>";
echo "</table>";
?>