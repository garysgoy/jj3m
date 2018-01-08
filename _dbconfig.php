<?
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
$server=0;
if ($server==1) {
  $db = new mysqli("localhost", "mlmsolution_net", "AEhr3yJ56y","mlmsolution_net");
} else {
  $db = new mysqli("localhost", "root", "root","jj3m");
}
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: GG (" . $db->connect_errno . ") " . $db->connect_error;
    echo "<br>Server =".$server;
    exit();
}

$db->query("set names 'utf8'");

date_default_timezone_set('Asia/Kuala_Lumpur');

$setup = load_setup();

$user = load_user(0);

$lang = isset($_COOKIE['lang'])? $_COOKIE['lang']:0;


function load_user($rid) {
  global $db;
  $setup = load_setup();
  $user = array();

  if ($rid == 0) {
    $pid = $_COOKIE["pid"];

    list ($user_id, $chid) = explode ('-', $pid, 2);
    if ($chid == md5($setup->masterpass)) {
      $rs_user = $db->query("SELECT * FROM tblmember where id = $user_id");
    } else {
      $rs_user = $db->query("SELECT * FROM tblmember where id = $user_id and password = '$chid'");
    }
  } else {
    $user_id = $rid;
    $rs_user = $db->query("SELECT * FROM tblmember where id = $user_id") or die ($db->error);
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
  $rs = $db->query("SELECT * FROM tblsetup") or die($db->error);
  $ret = $rs->fetch_object();
  return $ret;
}

?>