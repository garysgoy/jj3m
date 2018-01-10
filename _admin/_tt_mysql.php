<?

include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

$rs = $db->query("SELECT DATE(g_date) as udate, sum(g_amount) as uamount
FROM tblhelp where g_type='P' and status = 'O' GROUP BY udate ORDER BY udate") or die ("err ". $db->error);

echo "<table width=500><tr valign=top><td>";
echo "<table cellpadding=2>";
$i = mysqli_num_rows($rs);
while ($row = mysqli_fetch_object($rs)) {
   echo "<tr><td>$i</td><td>$row->udate PH</td><td align=right>".number_format($row->uamount)."</td><tr>";
   $i -=1;
}
echo "</table>";

$rs = $db->query("SELECT DATE(g_date) as udate, sum(g_amount) as uamount
FROM tblhelp where g_type='G' and status = 'O'
GROUP BY udate ORDER BY udate") or die ("err ". $db->error);

$j = mysqli_num_rows($rs);
echo "</td><td><table cellpadding=2 align=right>";
while ($row = mysqli_fetch_object($rs)) {
   echo "<tr><td>$j</td><td>$row->udate GH</td><td align=right>".number_format($row->uamount)."</td><tr>";
   $j -=1;
}
echo "</table>";
echo "</td></tr></table>";
?>