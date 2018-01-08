$gh = $db->query("select * from tblhelp where mem_id = $mem->id and g_type='G' and ");

$i = 1;
echo "<table>";
while ($row = mysqli_fetch_object($gh)) {
	echo "<tr><td>$row-></td><td>$row-></td><td>$row-></td></tr>";
	$i += 1;
}
echo "</table>";
