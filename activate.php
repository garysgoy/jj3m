<?php
include_once("inc/ggInit.php");
if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}


//$page_css[] = "";
$page_title = $mls->activate[$lang];
$page_nav["mem_mgt"]["sub"]["activate"]["active"] = true;

$ls = new stdClass();
$ls->username = array("Username","登入账号","登入賬號");
$ls->email = array("Email","电邮","電郵");
$ls->status = array("Status","状态","狀態");
$ls->action = array("Action","操作","操作");
$ls->fullname = array("Fullname","姓名","姓名");
$ls->rank = array("Rank","阶级","階級");
$ls->phone = array("Phone","电话号码","電話號碼");
$ls->manager = array("Manager","注册经理","註冊經理");
$ls->status = array("Status","状态","狀態");
$ls->directs = array("Directs","下线","下線");
$ls->date_add = array("Date Add","注册日期","註冊日期");
$ls->ph = array("Last PH","最近一次的提供帮助","最近一次的提供幫助");
$ls->title = array("Direct Referrals","直属推荐人","直屬推薦人");


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
      <div id="p" class="easyui-panel" title="&nbsp;<i class='fa fa-home'></i>  <? echo $page_title; ?>" style="width:98%;">
      <table id="dg" class="easyui-datagrid" style="width:100%;"
          url="activate_l.php"
          pagination="true" pageSize="10"
          fitColumns="true" singleSelect="true">
        <thead>
          <tr>
            <th field="username" width="20" sortable="true"><? echo $ls->username[$lang] ?></th>
            <th field="phone" width="25" sortable="true"><? echo $ls->phone[$lang] ?></th>
            <th field="status" width="15" sortable="true"><? echo $ls->status[$lang] ?></th>
            <th field="action" width="30" sortable="true"><? echo $ls->action[$lang] ?></th>
            <th field="date_add" width="30" sortable="true"><? echo $ls->date_add[$lang] ?></th>
          </tr>
        </thead>
      </table>
      </div>
      <!-- GG End -->
    </div> <!-- END ROW -->
  </div> <!-- END MAIN CONTENT -->
</div> <!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->
<script>
function doActivate(id) {
	var act = 'activate';
	$.post("_action.php",{act:act,id:id},function(result){
	  if(result.status == 'success')
	  {
	    alert("操作成功");
	    location.reload();
	  }
	  else
	  {
	    alert(result.msg);
	    location.reload();
	  }

	},"json");
}

function doDelete(id) {
	alert("Delete "+id);
}
</script>
<!-- PAGE FOOTER -->
<?php
  include("inc/footer.php");
  include("inc/scripts.php");
?>