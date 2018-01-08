<?
require_once("inc/ggDbconfig.php");

if ($user->id == 0) {
  header("location: login.php");
}

require_once("inc/init.php");
require_once("inc/config.ui.php");
?>