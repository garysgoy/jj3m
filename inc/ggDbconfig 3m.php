<?
/*----------
1. Detect Local or server and connect DB
2. Set timezone
3. Load setup from database (Change to setup.php?)
4.
-----------*/

$server = ($_SERVER['SERVER_ADDR']=="::1")? 0:1;
$app_code = "jj";

if ($server==0) {
  $db = new mysqli("localhost", "root", "root","jj3m");
  error_reporting(E_ALL);
} else {
  $db = new mysqli("localhost", "mlmsolution_net", "AEhr3yJ56y","mlmsolution_net");
  error_reporting(E_ALL & ~E_NOTICE);
}

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    echo "<br>Server =".$server;
    exit();
}

$db->query("set names 'utf8'");

date_default_timezone_set('Asia/Kuala_Lumpur');

$setup = load_setup();

$user = load_user(0);

if ($setup->lang >= 90) {
  $lang = $setup->lang - 90;
} else {
  $lang = (isset($_COOKIE['lang']) && $_COOKIE['lang']>=0)? $_COOKIE['lang']:0;
}

function load_user($rid) {
  global $db;
  $setup = load_setup();
  $user = array();

  if ($rid == 0) {
    // Need some check if what to remove notice of offset
    $pid = isset($_COOKIE["pid"]) ? $_COOKIE["pid"]:"0-xxx";

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

  if ($rs_user=="" || $rs_user->num_rows==0) {
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
  global $db, $setup,$app_code;
  $rs = $db->query("SELECT * FROM tblsetup where app_code='$app_code'") or die($db->error);
  $ret = $rs->fetch_object();
  return $ret;
}

?>