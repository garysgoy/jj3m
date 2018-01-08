<?

include("../_dbconfig.php");
include("../_ggFunctions.php");

$rs = $db->query("SELECT * FROM  `tblhelp` WHERE id IN ( 15035, 15036, 15048, 15051, 15052, 15053, 15073, 15077, 15079, 15106, 15107, 15122, 15123, 15125, 15134, 15137, 15138, 15141, 15143, 15149, 15153, 15188, 15213, 15214, 15215 )");

while ($row = mysqli_fetch_object($rs)) {
   $user = load_user($row->mem_id);
   echo "<br>$user->email";
}

?>