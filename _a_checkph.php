<?php
include_once("inc/ggInit.php");

if ($user->rank<1) {
  header("location: login.php");
}
//$page_css[] = "";
$page_title = $mls->dashboard[$lang];
$page_nav["dashboard"]["active"] = true;

$ls = new stdClass();
$ls->title = array("Change Password","更改密码","更改密碼");
$ls->title = array("Change Second Password","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");

$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");
$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");

include("inc/ggHeader.php");
include("inc/ggFunctions.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
<?
  include("inc/ribbon.php");
?>
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row">
      <div class="col-sm-12">
        <? echo showPending(0); ?>
      </div>
    </div>
  </div>

  </div>
</div>

<?
include("inc/ggFooter.php");

function checkHelp() {
  $idlist = array();
  $rs = $db->query("select * from tblhelp where status = 'C'") or die($db->error);
  while ($row = mysqli_fetch_object($rs)) {
    $sum = ggFetchObject("select sum(g_amount) as amt from tblhelpdetail where help_id = $row->id");
    if ($sum->amt == "" or $sum->amt <> $row->g_amount) {
      array_push($idlist, $row->id);
    }
  }
  $count = count($idlist);
  for ($i=0;$i<$count;$i++) {
    $id = $idlist[$i];
    $tt = showPH($id);
  }
}

function showPH($id) {
  $hh = mysqli_fetch_object($db->query("select * from tblhelp where id = $id"));
  $dd = $db->query("select * from tblhelpdetail where help_id = $id order by id");
  echo "<br><br>Help $id - $hh->g_amount $hh->g_date";
  while ($row = mysqli_fetch_object($dd)) {
    echo "<br>$row->id $row->g_date $row->g_amount $row->stage";

  }
}

function showPending($option) {
  global $db;
  if ($option==0) {
      $gd = $db->query("select * from tblhelpdetail where stage <> 2 and stage <> 4 and g_type='P' order by help_id") or die("err ".$db->error);
  } else {
      $gd = $db->query("select * from tblhelpdetail where (stage = 1 or stage = 3) and g_type='P' order by help_id") or die("err ".$db->error);
  }

  $ret = "Help Count: ".mysqli_num_rows($gd)."<br><br>";

  $ret .= "<table class='table table-striped table-bordered table-hover'>";
  $ret .= "<thead><tr class='bg-color-blue'><td>No</td><td>ID</td><td>Help ID</td><td>Date/Time</td><td>Mem_ID</td><td>T</td><td>Mem_id2</td><td>Amount</td><td>STG</td></tr></thead><tbody>";

  $ctr = 1;
  $tot = 0;
  $gtot = 0;
  $help_id = 0;
  $d_now = new datetime("now");
  $i = 1;
  while ($row = mysqli_fetch_object($gd)) {
    if ($help_id <> $row->help_id) {
      if ($help_id <> 0) {
        $ret .= "<tr class='bg-color-yellow'><td colspan=7>&nbsp;</td><td align=right>$tot</td><td>&nbsp;</td></tr>";
      }
      $help_id = $row->help_id;
      $tot = 0;
    }

    $mem = load_user($row->mem_id);
    $oth = load_user($row->oth_id);
    $leader = ggLeader($row->mem_id);
    $leader1 = ggLeader($row->oth_id);

    //$future_date = new DateTime($row->g_timer);
    $remain = ggTimeRemain($d_now,$row->g_timer);

    $ret .= "<tr><td>$ctr</td><td>$row->id</td><td>$row->help_id</td><td>$row->g_date - $remain</td><td>$mem->username - $leader</td><td>$row->g_type</td><td>$oth->username - $leader1 $oth->fullname</td><td align=right>$row->g_amount</td><td align=right>$row->stage</td></tr>";
    $ctr = $ctr + 1;
    $tot = $tot + $row->g_amount;
    $gtot = $gtot + $row->g_amount;
  }
  $ret .= "<tr class='bg-color-yellow'><td colspan=7>&nbsp;</td><td align=right>$tot</td><td>&nbsp;</td></tr>";
  $ret .= "<tr class='bg-color-yellow'><td colspan=7>&nbsp;</td><td align=right>$gtot</td><td>&nbsp;</td></tr>";

  $ret .= "</table>";

  return $ret;
}

function ggLeader($id) {
  $leader = ggFetchObject("select * from tblmember where id = $id");
  $rank = $leader->rank;
  $mgr = $leader->mgr_name;
  while ($rank <= 5 and $rank >0) {
    $leader = ggFetchObject("select * from tblmember where id = $leader->manager");
    $rank = $leader->rank;
  }
  if ($rank==0) {
    return ("XX");
  } else {
    return ($mgr . ' / ' . $leader->username);
  }
}


?>
