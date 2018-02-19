<?
include_once("inc/ggInit.php");

if ($user->rank<1) {
  header("location: login.php");
}
//$page_css[] = "";
$page_nav["matching"]["active"] = true;
$page_title = $mls->matching[$lang];

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
        <? echo ggPhQue(6); ?>
      </div>
      <div class="col-sm-12 col-md-6">
        <? echo ggGhQue(6); ?>
      </div>
    </div>
  </div>

</div>
<script>
function doPriority(id,pr) {
    $.post("_priority.php",{id:id,pr:pr},function(data){
    //alert(data);
    document.location.href = document.location.href;
  },
  "text");
}

function doMatch(id,pr) {
    $.post("__process1.php",{id:id,pr:pr},function(data){
    alert(data);
    document.location.href = document.location.href;
  },
  "text");
}
</script>

<?
include("inc/ggFooter.php");

function ggPhQue($pr) {
  global $db;

  $ph = $db->query("select * from tblhelp where g_type='P' and g_date<= '2018-08-30' and (status='O' or status='P') order by g_type, priority, g_date limit 0,250") or die("err ".$db->error);

  $ret = '<table class="table table-striped table-bordered table-hover" width="100%">';
  $ret .= "<thead><tr class='bg-color-blueLight'><td>No</td><td>ID</td><td>PR</td><td>Email</td><td>Date</td><td>ST</td><td>Amount</td></tr></thead><tbody>";

  // Provide Help
  $ctr = 1;
  $tot = 0;
  while ($row = mysqli_fetch_object($ph)) {

    $date = new datetime($row->g_date);
    $days = ggDaysDiff($date);
    $link = "$row->id";
    $usr = load_user($row->mem_id);
    $leader = ggLeader($row->mem_id);

    $username =$usr->username.' - '.$leader.'<br>'.$usr->fullname;
    if ($row->status =="O" or $row->status == "P")
       $link = "<button class='btn-success btn-xs' onclick='doMatch($row->id,$pr)'>Match</button>";
    $up = "<button class='btn-success btn-xs' onclick='doPriority($row->id,-1)'><i class='fa fa-arrow-up'></i></button>";
    $dn = "<button class='btn-danger  btn-xs' onclick='doPriority($row->id,+1)'><i class='fa fa-arrow-down'></i></button>";

    if ($usr->fullname=="" or ($usr->alipay=="" && $usr->bankaccount=="")) {
        $ret .= "<tr bgcolor=silver><td>$ctr</td><td>$link</td><td>$row->priority  $up  $dn &nbsp;</td><td>$username</td><td>$row->g_date <b>$days</b></td><td>$row->status<br>P $row->g_plan</td><td align=right>$row->g_amount</td></tr>";
    } else {
        $ret .= "<tr><td>$ctr</td><td>$link</td><td>$up $row->priority $dn</td><td>$username</td><td>$row->g_date <b>$days</b></td><td>$row->status<br>P $row->g_plan</td><td align=right>$row->g_amount</td></tr>";
        $ctr = $ctr + 1;
        $tot = $tot + $row->g_pending;
    }

  }

  $ret .= "<tr class='bg-color-blueLight'><td colspan=6><button class='btn btn-success btn-xs' onclick='doMatch(19640001,$pr)'>Match 1st Available</a></td><td align=right>$tot</td></tr>";
  $ret .= "</tbody></table>";
  return $ret;
}

function ggGhQue($pr) {
  global $db;
  $ret = "";
  $gh = $db->query("select * from tblhelp where g_type='G' and (status='O' or status='P') and (note='deposit' or note='') order by g_type, priority, g_date") or die("err 5 ".$db->error);

  $ret = '<table class="table table-striped table-bordered table-hover" width="100%">';
  $ret .= "<thead><tr class='bg-color-blueLight'><td>No</td><td>ID</td><td>PR</td><td>Created</td><td>Email</td><td>St</td><td>Amount</td><td>Pending</td></tr></thead><tbody>";

  $ctr = 1;
  $tot = 0;
  while ($row = mysqli_fetch_object($gh)) {
    $usr = load_user($row->mem_id);
    $leader = ggLeader($row->mem_id);
    $email =$usr->username .'<br>'.$leader;
    $up = "<button class='btn-success btn-xs' onclick='doPriority($row->id,-1)'><i class='fa fa-arrow-up'></i></button>";
    $dn = "<button class='btn-danger  btn-xs' onclick='doPriority($row->id,+1)'><i class='fa fa-arrow-down'></i></button>";
    $n = "";
    if ($n <> 'downline' or $row->status=='Bonus' or $usr->fullname=="" or ($usr->alipay=="" && $usr->bankaccount=="")) {
      $ret .= "<tr class='bg-color-yellow'><td>$ctr</td><td>$row->id</td><td>$up $row->priority $dn</td><td>$row->g_date</td><td>$email</td><td>$row->status</td><td align=right>$row->g_amount</td><td align=right>$row->g_pending $n</td></tr>";
    } else {
      $ret .= "<tr><td>$ctr</td><td>$row->id</td><td>$row->$up $row->priority $dn</td><td>$row->g_date</td><td>$email</td><td>$row->status</td><td align=right>$row->g_amount</td><td align=right>$row->g_pending $n</td></tr>";
    }
    $ctr = $ctr + 1;
    $tot = $tot + $row->g_pending;
  }

  $ret .= "<tr class='bg-color-blueLight'><td colspan='7'>&nbsp;</td><td align=right>$tot</td></tr>";
  $ret .= "</tbody></table>";
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
    return ($mgr . ' / ' . $leader->user_name);
  }
}
?>
