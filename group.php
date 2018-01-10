<?php
include_once("inc/ggInit.php");
if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}


//$page_css[] = "";
$page_title = $mls->groups[$lang];
$page_nav["network"]["sub"]["groups"]["active"] = true;


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
//$lang=1;
$ls = new stdClass();
$ls->sn = array("S/NO","序号","序號");
$ls->amount = array("Amount","金额","金额");
$ls->date = array("Time","下单日期","下單日期");
$ls->days = array("Days","下单天数","下單天數");
$ls->username = array("username","昵称","暱稱");
$ls->email = array("Email","电邮","電郵");
$ls->phone = array("Phone","手机号","手機號");
$ls->status = array("Status","状态","狀態");

$ls->sn = array("S/NO","序号","序號");
$ls->amount = array("Amount","金额","金额");
$ls->date = array("Time","下单日期","下單日期");
$ls->days = array("Days","下单天数","下單天數");
$ls->username = array("username","昵称","暱稱");
$ls->email = array("Email","电邮","電郵");
$ls->phone = array("Phone","手机号","手機號");
$ls->status = array("Status","状态","狀態");
$ls->title  = array("Users Group","我的用户群","我的用戶群");
$ls->ph  = array("Provide Help","提供帮助","提供幫助");
$ls->gh  = array("Get Help","接受帮助","接受幫助");
?>

  <div id="p" class="easyui-panel" title="&nbsp;<i class='fa fa-home'></i>  <? echo $ls->title[$lang]; ?>" style="width:98%;">
    <div class="easyui-tabs" style="width:auto;height:auto">
        <div title="<? echo $ls->ph[$lang] ?>" style="padding:10px">
      <table id="dg" class="easyui-datagrid" style="width:98%;"
          data-options="url:'group_ph.php',
          pagination:true, pageSize:20,
          fitColumns:true, singleSelect:true">
        <thead>
          <tr>
            <th field="id" width="10" sortable="true"><? echo $ls->sn[$lang] ?></th>
            <th field="g_amount" width="10" sortable="true"><? echo $ls->amount[$lang] ?></th>
            <th field="g_date" width="18" sortable="true"><? echo $ls->date[$lang] ?></th>
            <th field="days" width="8" sortable="true"><? echo $ls->days[$lang] ?></th>
            <th field="username" width="15" sortable="true"><? echo $ls->username[$lang] ?></th>
            <th field="email" width="20" sortable="true"><? echo $ls->email[$lang] ?></th>
            <th field="phone" width="12" sortable="true"><? echo $ls->phone[$lang] ?></th>
            <th field="status" width="20" sortable="true"><? echo $ls->status[$lang] ?></th>
          </tr>
        </thead>
      </table>
        </div>
       <div title="<? echo $ls->gh[$lang] ?>" style="padding:10px">
      <table id="dg1" class="easyui-datagrid" style="width:98%;"
          data-options="url:'group_gh.php',
          pagination:true, pageSize:20,
          fitColumns:true, singleSelect:true">
        <thead>
          <tr>
            <th field="id" width="10" sortable="true"><? echo $ls->sn[$lang] ?></th>
            <th field="g_amount" width="10" sortable="true"><? echo $ls->amount[$lang] ?></th>
            <th field="g_date" width="18" sortable="true"><? echo $ls->date[$lang] ?></th>
            <th field="days" width="8" sortable="true"><? echo $ls->days[$lang] ?></th>
            <th field="username" width="15" sortable="true"><? echo $ls->username[$lang] ?></th>
            <th field="email" width="20" sortable="true"><? echo $ls->email[$lang] ?></th>
            <th field="phone" width="12" sortable="true"><? echo $ls->phone[$lang] ?></th>
            <th field="status" width="20" sortable="true"><? echo $ls->status[$lang] ?></th>
          </tr>
        </thead>
      </table>
        </div>
    </div>
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