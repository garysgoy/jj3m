<?
include_once("inc/ggInit.php");

//$page_css[] = "";
$page_title = $mls->pin[$lang];;
$page_nav["pin"]["active"] = true;

$ls = new stdClass();

$ls->title = array("PIN Management","激活码","激活碼");
$ls->sharepin = array("Share PIN"," 共享激活码"," 共享激活碼");
$ls->pinsharing= array("Sharing Quantity","共享数量","共享数量");
$ls->pintransfer= array("Max 100 PIN each time, PIN can share 10 times only. ","每次最多100个，每个激活码最多只能分享10次 ","每次最多100個，每個激活碼最多只能分享10次 ");
$ls->pqty = array("Quantity","数量","数量");
$ls->otheruseracc = array("Other User Account","共享给账号 ","共享給賬號");
$ls->useracc = array("User Account","用户账号","用戶賬號");
$ls->submit = array("Submit","提交","提交");
$ls->pin_avail = array("PIN available","可用激活码","可用激活碼");
$ls->pin_used = array("PIN used","已使用的激活码","已使用的激活碼");
$ls->pinrecord = array("Share PIN record","激活码共享纪录","激活碼共享纪录");
$ls->date = array("Date","日期","日期");

$ls->sn        = array("S/No","序号","序號");
$ls->apin        = array("A PIN","激活码","激活碼");
$ls->sharedfrom= array("Shared Form","分享自","分享自");
$ls->sharedto= array("Shared To","共享至","共享至");
$ls->sharedon= array("Shared On","共享日期","共享日期");
$ls->usedon= array("Used On","使用于","使用于");
$ls->usedate= array("Used Date","使用日期","使用日期");
$ls->sharecount= array("Shared Count","共享次数","共享次數");
$ls->status= array("Status","状态","狀態");
$ls->action= array("Action","操作","操作");
$ls->pinrec = array("Total 48 records，currently display 1 to 10 of records","共 48 行数据，显示 1 至 10 行数据","共 48 行數據，顯示 1 至 10 行數據");
$ls->pinsharing= array("Sharing Quantity","共享数量","共享数量");
$ls->maxpin= array("Max 100 PIN each time, PIN can share 10 times only. ","每次最多100个，每个激活码最多只能分享10次 ","每次最多100個，每個激活碼最多只能分享10次 ");
$ls->qty= array("Quantity","数量","数量");
$ls->potheruseracc = array("Other User Account","其他用户的账号 ","其他用戶的賬號");
$ls->pacc = array("User Account","户的账号","戶的賬號");
$ls->bsubmit = array("Submit","提交","提交");
$ls->successful = array("Pins transferred","激活码已共享","激活碼已共享");
$ls->secondpassword = array("Please enter your second password","请输入您的二级密码","");
$ls->psecondpassword = array("Second Password ","二级密码","二級密碼");

$ls->pin_in  = array("Transfer In ","激活码转入","激活碼轉入");
$ls->pin_out = array("Transfer Out","激活码转出","激活碼轉出");

include("inc/ggHeader.php");
include("inc/ggFunctions.php");

$pin = ggFetchObject("select count(id) as ctr from tblpin where managerid=$user->id and status='N'");

?>

<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <?
  include("inc/ribbon.php");
  ?>

  <!-- MAIN CONTENT -->
  <div id="content">

    <div class="row" style="padding: 15px 15px 15px 0px;">
    	<!-- GG Start -->
      <div class="col-md-6">
        <div class="panel panel-bar">
          <div class="panel-heading">
            <h4><i class="fa fa-share-alt"></i> <? echo $ls->sharepin[$lang]; ?></h4>
          </div>
          <div class="panel-body" style="padding:20px;">
            <form action="" method="POST" id="sharePinForm" data-toggle="validator" autocomplete="off">
              <label for="PinQty"><? echo $ls->title[$lang]; ?></label><br/><input type="text" class="form-control" id="PinQty" name="PinQty" value="" autocomplete="off" placeholder="<? echo $ls->pqty[$lang]; ?>" required />
              <? echo $ls->maxpin[$lang]; ?>
              <br/>
              <br/>
              <label for="username"><? echo $ls->otheruseracc[$lang]; ?></label>
              <br/><input type="text" class="form-control" id="username" name="username" value="" placeholder="<? echo $ls->useracc[$lang]; ?>" autocomplete="off" required />
              <span id="errMsg" style="font-size:12px; color:#ff0000;"></span> <span id="successMsg" style="font-size:12px;"></span>
              <br/>
              <label for="password2"><? echo $ls->secondpassword[$lang]; ?></label>
              <br/><input type="password" class="form-control" id="password2" name="password2" value="" placeholder="<? echo $ls->psecondpassword[$lang]; ?>" autocomplete="off" required />
              <span id="errMsg" style="font-size:12px; color:#ff0000;"></span> <span id="successMsg" style="font-size:12px;"></span>
              <br/>
              <a href="#" class="btn btn-default btn-success" onclick="doTransfer()"><? echo $ls->bsubmit[$lang]; ?></a><br>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6 pin-status">
        <div class="col-md-6 col-left">
          <p><? echo $ls->pin_avail[$lang]; ?></p>
          <span><? echo $pin->ctr; ?></span>
        </div>
      </div>
    </div>

    <div>
      <span class="purple lighten-5">Purple l5</span>
      <span class="purple lighten-4">Purple l4</span>
      <span class="purple lighten-3">Purple l3</span>
      <span class="purple lighten-2">Purple l2</span>
      <span class="purple lighten-1">Purple l1</span>
    </div>
    <div class="row" style="padding: 15px;">
      <div class="panel panel-bar">
        <div class="panel-heading">
          <h4><i class="fa fa-share-alt"></i> <? echo $ls->sharepin[$lang]; ?></h4>
        </div>
        <div class="panel-body">
          <div class="easyui-tabs" style="width:auto;height:auto">
            <div title="<? echo $ls->pin_avail[$lang]; ?>" style="padding:5px">
              <table id="dg" class="easyui-datagrid" style="width:100%;"
              data-options="url:'pin_t1.php',
              pagination:true, pageSize:10,
              fitColumns:true, singleSelect:true">
              <thead>
                <tr>
                  <th field="sn" width="10" sortable="true"><? echo $ls->sn[$lang] ?></th>
                  <th field="pin" width="25" sortable="true"><? echo $ls->apin[$lang] ?></th>
                  <th field="requestdate" width="18" sortable="true"><? echo $ls->date[$lang] ?></th>
                  <th field="sharedfrom" width="15" sortable="true"><? echo $ls->sharedfrom[$lang] ?></th>
                  <th field="action" width="15" sortable="true"><? echo $ls->action[$lang] ?></th>
                </tr>
              </thead>
            </table>
          </div>
          <div title="<? echo $ls->pin_used[$lang]; ?>" style="padding:5px">
            <table id="dg" class="easyui-datagrid" style="width:100%;"
            data-options="url:'pin_t2.php',
            pagination:true, pageSize:10,
            fitColumns:true, singleSelect:true">
            <thead>
              <tr>
                <th field="sn" width="10" sortable="true"><? echo $ls->sn[$lang] ?></th>
                <th field="pin" width="25" sortable="true"><? echo $ls->pin[$lang] ?></th>
                <th field="requestdate" width="18" sortable="true"><? echo $ls->date[$lang] ?></th>
                <th field="useby" width="12" sortable="true"><? echo $ls->usedon[$lang] ?></th>
                <th field="usedate" width="20" sortable="true"><? echo $ls->usedate[$lang] ?></th>
                <th field="action" width="15" sortable="true"><? echo $ls->action[$lang] ?></th>
              </tr>
            </thead>
          </table>
        </div>
        <div title="<? echo $ls->pin_in[$lang]; ?>" style="padding:5px">
          <table id="dg" class="easyui-datagrid" style="width:100%;"
          data-options="url:'pin_t3.php',
          pagination:true, pageSize:10,
          fitColumns:true, singleSelect:true">
          <thead>
            <tr>
              <th field="sn" width="10" sortable="true"><? echo $ls->sn[$lang] ?></th>
              <th field="efrom" width="25" sortable="true"><? echo $ls->useracc[$lang] ?></th>
              <th field="qty" width="18" sortable="true"><? echo $ls->pqty[$lang] ?></th>
              <th field="trdate" width="12" sortable="true"><? echo $ls->date[$lang] ?></th>
            </tr>
          </thead>
        </table>
      </div>

      <div title="<? echo $ls->pin_out[$lang]; ?>" style="padding:5px">
        <table id="dg" class="easyui-datagrid" style="width:100%;"
        data-options="url:'pin_t4.php',
        pagination:true, pageSize:10,
        fitColumns:true, singleSelect:true">
        <thead>
          <tr>
            <th field="sn" width="10" sortable="true"><? echo $ls->sn[$lang] ?></th>
            <th field="eto" width="25" sortable="true"><? echo $ls->useracc[$lang] ?></th>
            <th field="qty" width="18" sortable="true"><? echo $ls->pqty[$lang] ?></th>
            <th field="trdate" width="12" sortable="true"><? echo $ls->date[$lang] ?></th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>
  <!-- GG End -->
</div> <!-- END ROW -->
</div> <!-- END MAIN CONTENT -->
</div> <!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->
<script>
  function doTransfer() {
    $('#sharePinForm').form('submit',{
      url: "_action_pin.php",
      onSubmit: function(){
        return $(this).form('validate');
      },
      success: function(res){
        var res = JSON.parse(res);
        if (res.success) {
          $.messager.alert("<? echo $ls->title[$lang]; ?>","<? echo $ls->successful[$lang]; ?>","info",function(r){
            location.reload();
          });
        } else {
          $.messager.alert("<? echo $ls->title[$lang]; ?>",res.msg,"error");
        }
      }
    });
  }
</script>
<!-- PAGE FOOTER -->
<?php
include("inc/ggFooter.php");
?>