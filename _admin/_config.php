<?
include("../config/_db.php");

error_reporting(E_ALL);

$db = new mysqli($db_server, $db_username, $db_password,$db_name);
if (mysqli_errno($db_conn)==1040 or mysqli_errno($db_conn)==1203) {
  echo "The server is too busy at the moment, come back few minutes later";
  exit();
} else if (mysqli_errno() > 0) {
  echo "Database Error: ". mysqli_error($db_conn);
}

mysqli_select_db($db_conn,$db_name) or die(mysqli_error($db_conn));
$db->query("set names 'utf8'");
date_default_timezone_set('Asia/Kuala_Lumpur');

$setup = load_setup();

function load_user($rid) {
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
    $rs_user = $db->query("SELECT * FROM tblmember where id = $user_id");
  }

  if ($rs_user=="" || mysqli_num_rows($rs_user)==0) {
    $user = array(  'id'      => 0,
            'logged'  => 0);
    $ret = (object) $user;
  } else {
    $row = mysqli_fetch_array($rs_user);
    array_push($row, array('logged' => 1,
              'name' => $row['fullname']));
    $ret = (object) $row;
  }

  return ($ret);
}


function load_setup() {
  $ret = mysqli_fetch_object($db->query("SELECT * FROM tblsetup"));
  return ($ret);
}

?>