<?
error_reporting(E_ALL);

$db = new mysqli("localhost", "root", "root","dream");
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

$db->query("set names 'utf8'");

date_default_timezone_set('Asia/Kuala_Lumpur');

$setup = load_setup();

$user = load_user(101);

function load_user($rid) {
  global $db;
  $setup = load_setup();
  $user = array();

  if ($rid == 0) {
    $pid = $_COOKIE["pid"];

    list ($user_id, $chid) = explode ('-', $pid, 2);
    if ($chid == md5($setup->masterpass)) {
      $rs_user = $db->query("SELECT * FROM bear_users where user_id = $user_id");
    } else {
      $rs_user = $db->query("SELECT * FROM bear_users where user_id = $user_id and password = '$chid'");
    }
  } else {
    $user_id = $rid;
    $rs_user = $db->query("SELECT * FROM bear_users where user_id = $user_id") or die ($db->error);
  }

  if ($rs_user->num_rows==0) {
    $user = array('id' => 0,
            'logged'  => 0);
    $ret = (object) $user;
  } else {
    $row = $rs_user->fetch_assoc();
    $row['logged'] = 1;
    $ret = (object) $row;
  }

  return ($ret);
}

function load_setup() {
  global $db;
  $rs = $db->query("SELECT * FROM bear_setup") or die($db->error);
  $ret = $rs->fetch_object();
  return $ret;
}

?>