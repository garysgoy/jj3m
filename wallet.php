<?
include_once("inc/ggInit.php");
include_once("inc/ggFunctions.php");
include_once("inc/ggValidate.php");

if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}

//$page_css[] = "";

$page_nav["wallet"]["active"] = true;
$page_title = $mls->wallet[$lang];

$ls = new stdClass();

$ls->wallet_ph = array("Help Reward","互助钱包","互助錢包");
$ls->wallet_reg = array("Register Reward","注册钱包","註冊錢包");
$ls->wallet_ref = array("Refer Reward","推荐钱包","推薦錢包");
$ls->wallet_mgr = array("Manager Reward","经理奖钱包","經理獎錢包");
$ls->rmb = array("RMB","人民币","人民幣");
$ls->wallet = array("Wallet","钱包","錢包");
$ls->record = array("Record","记录","紀錄");
$ls->withdraw = array("Withdraw","提取","提取");

$ls->sn = array("S/NO","序号","序號");
$ls->amount = array("Amount (Mavro)","金额 (Mavro)","金额 (Mavro)");
$ls->date = array("Time","下单日期","下單日期");
$ls->days = array("Days","下单天数","下單天數");
$ls->username = array("username","昵称","暱稱");
$ls->email = array("Email","电邮","電郵");
$ls->phone = array("Phone","手机号","手機號");
$ls->status = array("Status","状态","狀態");

$ls->id = array("ID","編號","編號");
$ls->type = array("Type","狀態","狀態");
$ls->created = array("created","創建日期","創建日期");
$ls->release = array("Release","解放日期","解放日期");
$ls->mavrotype = array("Mavro Type","钱包類別","钱包洛類別");
$ls->description = array("Description","說明","說明");
$ls->nominal = array("Nominal Amount","原始金額","原始金額");
$ls->target = array("Target Amount","目標金額","目標金額");
$ls->reward = array("Reward","诚信奖","诚信奖");
$ls->comment = array("Comment","備註","備註");
$ls->username = array("Username","用户名","用户名");

$ls->w_available = array("Available","流动","流動");
$ls->w_onhold = array("Onhold","待定","待定");
$ls->title = array("Mavro","馬夫洛","馬夫洛");
$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");
$ls->gh_balance = array("Balance &nbsp;","现有人民币","現有人民幣");
$ls->gh_available = array("Available","可提人民币","可提人民幣");
$ls->gh_amount = array("Help Amount","提领金额","提領金額");
$ls->gh_amountp = array("RMB","人民币","人民幣");
$ls->gh_comment = array("Message","备注","備註");
$ls->my_directs = array("My Directs","我的直推","我的直推");
$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");
$ls->ph_warning = array("I understand and accept the risk, and I decide to join this program","我已完全了解所有风险。我决定参与, 尊重3M的文化与传统","我已完全了解所有風險。我決定參與，尊重3M的文化與傳統");
$ls->close = array("Close","关闭","關閉");

include("inc/ggHeader.php");



$tt = ggRefreshPH($user->id);

$deposit    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='B' and date_release <= now()");
$referral   = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='R' and date_release <= now()");
$referralu   = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='U' and op_type='R'");
$manager    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='C' and op_type='M' and date_release <= now()");
$manageru    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='U' and op_type='M'");
$register    = ggFetchObject("select sum(future_amount) as amt from tblmavro where mem_id = $user->id and type='N'");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <? include("inc/ribbon.php"); ?>
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row" style="padding: 15px 15px;">
      <!-- GG Start -->
      <!-- Page content -->
      <!--<div class="container content-body">-->
       <!--div id="welcome-bar"><i class="fa_icon fa fa-smile-o" style="padding-top: 12px;"></i> ezmoney，欢迎回来！</div-->
       <div class="container wallet">
        <div class="col-md-4">
          <div>
            <h2><i class="fa fa-money"></i> <? echo $ls->wallet_ph[$lang]; ?></h2>
            <span><? echo number_format($deposit->amt,0); ?></span> <strong style="font-size:18px; font-weight:500;"><? echo $setup->currency; ?></strong>
            <p><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#requestHelpD"><? echo $ls->withdraw[$lang]; ?></a></p>
          </div>
        </div>
<!--
  <div class="col-md-3">
    <div>
      <h2><i class="fa fa-money"></i> <? echo $ls->wallet_reg[$lang]; ?></h2>
      <p style="color:#00bcff;"><? echo $ls->w_onhold[$lang]; ?>: <? echo number_format($referralu->amt,0); ?> <? echo $ls->rmb[$lang]; ?></p>
      <p style="color:#00ff5a;"><? echo $ls->w_available[$lang]; ?> <? echo number_format($register->amt,0); ?> <? echo $ls->rmb[$lang]; ?></p>
      <p><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#requestHelpD"><? echo $ls->withdraw[$lang]; ?></a></p>
    </div>
  </div>
-->
<div class="col-md-4">
  <div>
   <h2><i class="fa fa-money"></i> <? echo $ls->wallet_ref[$lang]; ?></h2>
   <p style="color:#00bcff;"><? echo $ls->w_onhold[$lang]; ?>: <? echo number_format($referralu->amt,0); ?> <? echo $ls->rmb[$lang]; ?></p>
   <p style="color:#00ff5a;"><? echo $ls->w_available[$lang]; ?>: <? echo number_format($referral->amt,0); ?> <? echo $ls->rmb[$lang]; ?></p>
   <p><a href="#" class="btn btn-success" data-toggle="modal" data-target="#requestHelpR"><? echo $ls->withdraw[$lang]; ?></a></p>
 </div>
</div>
<div class="col-md-4">
  <div>
   <h2><i class="fa fa-money"></i> <? echo $ls->wallet_mgr[$lang]; ?></h2>
   <p style="color:#00bcff;"><? echo $ls->w_onhold[$lang]; ?>: <? echo number_format($manageru->amt,0); ?> <? echo $ls->rmb[$lang]; ?></p>
   <p style="color:#00ff5a;"><? echo $ls->w_available[$lang]; ?>: <? echo number_format($manager->amt,0); ?> <? echo $ls->rmb[$lang]; ?></p>
   <?
   if ($user->rank < 6) {
    echo "<p><a href='#' class='btn btn-primary' data-toggle='modal' data-target='#requestHelpX'>Withdraw</a></p>";
  } else if ($user->rank >= 6) {
    echo "<p><a href='#' class='btn btn-primary' data-toggle='modal' data-target='#requestHelpM'>".$ls->withdraw[$lang]."</a></p>";
  }
  ?>
</div>
</div>
</div>

<?
include("_inc_gethelp.php");
include("_inc_gethelp_r.php");
include("_inc_gethelp_m.php");
?>

<div class="container">
	<div class="panel panel-bar">
   <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-book"></i> <? echo $ls->wallet[$lang]; ?> <? echo $ls->record[$lang]; ?></h3>
  </div>
  <div class="panel-body" style="padding:5px">
    <div class="easyui-tabs" style="width:auto;height:auto">
      <div title="<? echo $ls->wallet_ph[$lang]; ?>" style="padding:0px 5px 0px 0px">
        <table id="dg" class="easyui-datagrid" style="width:100%"
        url="wallet_ph.php"
        pagination="true" pageSize="10" nowrap="true"
        fitColumns="true" singleSelect="true">
        <thead>
          <tr>
            <th field="id" sortable="true" width="28"><? echo $ls->id[$lang] ?></th>
            <th field="date_created" sortable="true" width="28"><? echo $ls->created[$lang] ?></th>
            <th field="date_release" sortable="true" width="28"><? echo $ls->release[$lang] ?></th>
            <th field="type" sortable="true" width="20"><? echo $ls->type[$lang] ?></th>
            <th field="wallet" sortable="true" width="43"><? echo $ls->mavrotype[$lang] ?></th>
            <th field="help_id" sortable="true" width="30"><? echo $ls->description[$lang] ?></th>
            <th field="nominal_amount" sortable="true" width="25" align="right"><? echo $ls->nominal[$lang] ?></th>
            <th field="future_amount" sortable="true" width="30" align="right"><? echo $ls->target[$lang] ?></th>
            <th field="reward" sortable="true" width="18"><? echo $ls->reward[$lang] ?></th>
            <th field="future" sortable="true" width="30"><? echo $ls->comment[$lang] ?></th>
          </tr>
        </thead>
      </table>

    </div>

    <!-- GG REF -->
    <div title="<? echo $ls->wallet_ref[$lang]; ?>" style="padding:0px 5px 0px 0px">
      <table id="dg" class="easyui-datagrid" style="width:100%"
      url="wallet_ref.php"
      pagination="true" pageSize="10" nowrap="false"
      fitColumns="true" singleSelect="true">
      <thead>
        <tr>
          <th field="id" sortable="true" width="28"><? echo $ls->id[$lang] ?></th>
          <th field="date_created" sortable="true" width="28"><? echo $ls->created[$lang] ?></th>
          <th field="date_release" sortable="true" width="28"><? echo $ls->release[$lang] ?></th>
          <th field="type" sortable="true" width="25"><? echo $ls->type[$lang] ?></th>
          <th field="wallet" sortable="true" width="30"><? echo $ls->mavrotype[$lang] ?></th>
          <th field="help_id" sortable="true" width="30"><? echo $ls->description[$lang] ?></th>
          <th field="comment" sortable="true" width="30"><? echo $ls->username[$lang] ?></th>
          <th field="nominal_amount" sortable="true" width="25" align="right"><? echo $ls->nominal[$lang] ?></th>
          <th field="future_amount" sortable="true" width="35" align="right"><? echo $ls->target[$lang] ?></th>
          <th field="future" sortable="true" width="35"><? echo $ls->comment[$lang] ?></th>
        </tr>
      </thead>

    </table>
  </div>
  <!-- GG MGR -->
  <div title="<? echo $ls->wallet_mgr[$lang]; ?>" style="padding:0px 5px 0px 0px">

    <table id="dg" class="easyui-datagrid" style="width:100%"
    url="wallet_mgr.php"
    pagination="true" pageSize="10" nowrap="false"
    fitColumns="true" singleSelect="true">
    <thead>
      <tr>
        <th field="id" sortable="true" width="28"><? echo $ls->id[$lang] ?></th>
        <th field="date_created" sortable="true" width="28"><? echo $ls->created[$lang] ?></th>
        <th field="date_release" sortable="true" width="28"><? echo $ls->release[$lang] ?></th>
        <th field="type" sortable="true" width="25"><? echo $ls->type[$lang] ?></th>
        <th field="wallet" sortable="true" width="30"><? echo $ls->mavrotype[$lang] ?></th>
        <th field="help_id" sortable="true" width="30"><? echo $ls->description[$lang] ?></th>
        <th field="comment" sortable="true" width="30"><? echo $ls->username[$lang] ?></th>
        <th field="nominal_amount" sortable="true" width="25" align="right"><? echo $ls->nominal[$lang] ?></th>
        <th field="future_amount" sortable="true" width="35" align="right"><? echo $ls->target[$lang] ?></th>
        <th field="future" sortable="true" width="35"><? echo $ls->comment[$lang] ?></th>
      </tr>
    </thead>

  </table>

</div> <!-- Manager / Supermanager Bonus -->
</div>
</div> <!-- end Page Content -->
</div>
</div>
</div> <!-- end Page Content -->
</div>
</div>
<script>
  function GHAction(type) {
    var act = "GH";
    var mavro = "deposit";
    var amount = document.getElementById('sell_amount'+type).value;

    jQuery.ajax({
      type: "POST",
      url: '_action_gh.php',
      data: {act:act, mavro:mavro,type:type,amount:amount},
      success: function(res) {
        var res = JSON.parse(res);
        if (res.status == 'success') {
          $.messager.alert("<? echo $ls->titlegh[$lang];?>","<b class=blue><? echo $ls->success[$lang]; ?></b>","info",function(r) {
            location.reload();
          });
        } else {
          $.messager.alert("<?php echo $ls->titlegh[$lang]; ?>",res.msg,"error");
        }
      }
    });
  }
</script>
<?
include("inc/ggFooter.php");
?>