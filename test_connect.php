<?
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
$db_name = "crypto";
$db_user = "crypto";
$db_pass = "cY518888";

$db = new mysqli("localhost", $db_user, $db_pass,$db_name);

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    exit();
} else {
  echo "Successfully connected to MySQL database: $db_name<br><br>";

  if (isset($_GET['a']) && $_GET['a']=='remove_tables') {
    $rs = $db->query("show tables from $db_name");
    while ($row = mysqli_fetch_row($rs)) {
      echo "Deleting Table: {$row[0]}<br>";
      $db->query("drop table $row[0]");
    }
  } else {
    $rs = $db->query("show tables from $db_name");
    while ($row = mysqli_fetch_row($rs)) {
      echo "Table: {$row[0]}<br>";
    }
    if (mysqli_num_rows($rs)>0) {
      echo "<br><br>";
      echo '<a href="?a=remove_tables">Click here to remove all tables</a>';
    } else {
      echo "There is no table in the database<br><br><br><b style='color:red'>NOTE: Ther will be option to delete tables if tables exist in db</b>";
    }
  }
}

?>
