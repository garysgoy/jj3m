<?
include ("../inc/ggDbconfig.php");

echo '<a href="__status.php">Status</a>&nbsp;&nbsp;';
echo '<a href="buypins.php">Buy Pins</a>&nbsp;&nbsp;';
echo '<a href="showstatus.php">Show Status</a>&nbsp;&nbsp;';
echo '<a href="memutil.php">Member Utility</a>&nbsp;&nbsp;';
echo '<a href="showlog.php">Show Access Log</a>&nbsp;&nbsp;';
echo '<a href="addgh.php">Add GH</a>&nbsp;&nbsp;';
echo '<a href="__process1.php?id=19640001">Process 1</a>&nbsp;&nbsp;';
echo '<a href="showpinlog.php?start=2015-07-04">showpinlog</a>&nbsp;&nbsp<br><br>';
$mem = mysqli_fetch_object($db->query("select count(id) as mcount from tblmember"));
$memd = mysqli_fetch_object($db->query("select count(id) as mcount from tblmember where date_add>='2015-07-05'"));
$ph = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_type='P' and status <> 'C'"));
$phd = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_date>= '2015-07-05' and g_type='P' and status <> 'C'"));
$gh = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_type='G' and status <> 'C'"));
$ghd = mysqli_fetch_object($db->query("select count(id) as phcount, sum(g_amount) as phvalue from tblhelp where g_date>='2015-07-05' and g_type='G' and status <> 'C'"));
echo "Memer Count: $memd->mcount, PH Count: $phd->phcount,  PH Value: $phd->phvalue, GH Count: $ghd->phcount,  GH Value: $ghd->phvalue<br>";
echo "Memer Count: $mem->mcount, PH Count: $ph->phcount,  PH Value: $ph->phvalue, GH Count: $gh->phcount,  GH Value: $gh->phvalue<br>";
?>