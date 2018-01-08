<?php
include_once("inc/ggInit.php");

if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

//$page_css[] = "";
$page_title = $mls->members[$lang];
$page_nav["dashboard"]["active"] = true;


include("inc/ggHeader.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <? include("inc/ribbon.php"); ?>
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row" style="padding: 15px 15px;">
	<!-- GG Start -->
<?
$lang = 1; // (isset($_REQUEST['lang'])) ? $_REQUEST['lang']:2;
$ls->username = array("Username","登入账号","登入賬號");
$ls->email = array("Email","电邮","電郵");
$ls->fullname = array("Fullname","姓名","姓名");
$ls->rank = array("Rank","阶级","階級");
$ls->phone = array("Phone","电话号码","電話號碼");
$ls->manager = array("Manager","注册经理","註冊經理");
$ls->status = array("Status","状态","狀態");
$ls->directs = array("Directs","下线","下線");
$ls->date_add = array("Date Add","注册日期","註冊日期");
$ls->ph = array("Last PH","最近一次的提供帮助","最近一次的提供幫助");
$ls->title = array("Direct Referrals","直属推荐人","直屬推薦人");

?>
  <div id="p" class="easyui-panel" title="&nbsp;<i class='fa fa-home'></i>  <? echo $ls->title[$lang]; ?>" style="width:100%;height:350px;padding:10px;">
  <table id="dg" class="easyui-datagrid" style="width:100%;"
      url="referral_l.php"
      pagination="true" pageSize="10"
      fitColumns="true" singleSelect="true">
    <thead>
      <tr>
        <th field="username" width="20" sortable="true"><? echo $ls->username[$lang] ?></th>
        <th field="rank" width="20" sortable="true"><? echo $ls->rank[$lang] ?></th>
        <th field="fullname" width="40" sortable="true"><? echo $ls->fullname[$lang] ?></th>
        <th field="phone" width="25" sortable="true"><? echo $ls->phone[$lang] ?></th>
        <th field="mgr_name" width="50" sortable="true"><? echo $ls->manager[$lang] ?></th>
        <th field="directs" width="10" sortable="false" align="center"><? echo $ls->directs[$lang] ?></th>
        <th field="date_add" width="25" sortable="true"><? echo $ls->date_add[$lang] ?></th>
<!--        <th field="ph" width="60" sortable="false"><? echo $ls->ph[$lang] ?></th>
-->
        <th field="status" width="15" sortable="false"><? echo $ls->status[$lang] ?></th>
      </tr>
    </thead>
  </table>
    </div>
  </div>
	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
	//include required scripts
	include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) -->
  <link rel="stylesheet" type="text/css" href="js/plugin/jquery-easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="js/plugin/jquery-easyui/themes/icon.css">
   <script type="text/javascript" src="js/plugin/jquery-easyui/jquery.easyui.min.js"></script>

<script>


</script>

<?php
	//include footer
	//include("inc/google-analytics.php");
?>