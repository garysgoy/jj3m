<?
$db = new mysqli("127.0.0.1", "root", "root", "dream", 3306);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
} else {
  echo "success<br>";
}

if ($rs = $db->query("select id from bear_help")) {
  echo "Success ".print_r($rs);
} else {
  echo "error ".$db->error;
}


?>