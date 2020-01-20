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
      <div class="col-sm-12 col-md-6">
        <? echo ggPhByDate(6); ?>
      </div>
      <div class="col-sm-12 col-md-6">
        <? echo ggGhByDate(6); ?>
      </div>
    </div>
  </div>

  </div>
</div>

<?
include("inc/ggFooter.php");

function ggPhByDate($pr) {
  global $db;
  $ret = "";
  $rs = $db->query("SELECT date(g_date) as udate, sum(g_pending) as uamount, count(id) as ucount
    FROM tblhelp where g_type='P' and (status = 'O' or status = 'P') and priority <= $pr GROUP BY udate ORDER BY udate") or die ("err 7 ". $db->error);

    $ret = '<table class="table table-striped table-bordered table-hover" width="100%">';
    $ret .= '<thead><tr class="bg-color-blueLight"><td>Day</td><td>PH Date</td><td align=right>Count</td><td align=right>Amount</td><td align=right>Running</td></tr></thead><tbody>';
    $i = mysqli_num_rows($rs)-1;

    $uamount = 0;
    while ($row = mysqli_fetch_object($rs)) {
      $uamount += $row->uamount;
      $ret .=  "<tr><td>$i</td><td>$row->udate</td><td align=right>".number_format($row->ucount)."</td><td align=right><b class='txt-color-blue'>".number_format($row->uamount)."</b></td><td align=right>".number_format($uamount)."</td><tr>";
      $i -=1;
    }
    $ret .= "</tbody></table><br><br>";
    return $ret;
}

function ggGhByDate($pr) {
  global $db;
  $ret = "";
  $rs = $db->query("SELECT date(g_date) as udate, sum(g_pending) as uamount, count(id) as ucount
    FROM tblhelp where g_type='G' and (status = 'O' or status = 'P') and priority <= $pr
    GROUP BY udate ORDER BY udate") or die ("err ". $db->error);

    $ret = '<table class="table table-striped table-bordered table-hover" width="100%">';
    $ret .= '<thead><tr class="bg-color-blueLight"><td>Day</td><td>GH Date</td><td align=right>Count</td><td align=right>Amount</td><td align=right>Running</td></tr></thead><tbody>';
    $i = mysqli_num_rows($rs)-1;

    $uamount = 0;
    while ($row = mysqli_fetch_object($rs)) {
      $uamount += $row->uamount;
      $ret .=  "<tr><td>$i</td><td>$row->udate</td><td align=right>".number_format($row->ucount)."</td><td align=right><b class='txt-color-blue'>".number_format($row->uamount)."</b></td><td align=right>".number_format($uamount)."</td><tr>";
      $i -=1;
    }
    $ret .= "</tbody></table><br><br>";
    return $ret;
}

?>
