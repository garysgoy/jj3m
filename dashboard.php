<?php
include_once("inc/ggInit.php");

if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}

//$page_css[] = "";
$page_title = $mls->dashboard[$lang];
$page_nav["dashboard"]["active"] = true;

$ls = new stdClass();
$ls->title = array("Change Second Password","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");

$ls->titleph = array("Provide Help","提供帮助","提供帮助");
$ls->titlegh = array("Get Help","接受帮助","接受帮助");

$ls->i_want_ph =array("I want to provide help","我要帮助别人","我要幫助別人");
$ls->i_want_gh =array("I want to get help","我需要别人的帮助","我需要別人的幫助");
$ls->participants = array("Participants","参与者","參與者");

$ls->ph_desc = array("After submitting your PH request, please wait 10-30 days for matching ","申请完成后，请等待系统10-30日随机分配受善需求","申請完成後，請等待系統10-30日隨機分配受善需求");
$ls->ph_amount = array("Help Amount","帮助金额","幫助金額");
$ls->ph_comment = array("Message","备注","備註");
$ls->ph_commentp = array("Please indicate your message to the other party, eg: Time and Phone number to contact","填写你要传给对方的讯息，例如联络时间，联络方式等等。。。","填寫你要傳給對方的信息，例如聯繫時間，聯繫方式等等。。。");
$ls->ph_warning = array("I understand and accept the risk, and I decide to join this program","我已完全了解所有风险。我决定参与, 尊重3M的文化与传统","我已完全了解所有風險。我決定參與，尊重3M的文化與傳統");
$ls->close = array("Close","关闭","關閉");

$ls->gh_balance = array("Balance &nbsp;","现有人民币","現有人民幣");
$ls->gh_available = array("Available","可提人民币","可提人民幣");
$ls->gh_amount = array("Help Amount","提领金额","提領金額");
$ls->gh_amountp = array("RMB","人民币","人民幣");
$ls->gh_comment = array("Message","备注","備註");
$ls->my_directs = array("My Directs","我的直推","我的直推");
$ls->successfulph = array("PH Success","提供帮助顺利完成","提供帮助顺利完成");

// PH & GH Box
$ls->cancel = array("Cancel","取消","取消");
$ls->cancelled = array("Cancelled","已取消","已取消");
$ls->waiting1 = array("Waiting (","等待中 (","等待中 (");
$ls->waiting2 = array(" Days)"," 天)"," 天)");
$ls->matching = array("Matching","配对中","配對中");
$ls->w_matching = array("To be match","待配对","待配對");
$ls->aph = array("Request to Provide Help","申请提供帮助","申請提供幫助");
$ls->agh = array("Request for Get Help","申请接受帮助","申請接受幫助");
$ls->date = array("Date","日期","日期");
$ls->status = array("Status","状态","狀態");
$ls->match_code = array("Match Code","配对编号","配對編號");
$ls->detail = array("Detail","详细","詳細");
$ls->helpdetail = array("Help Detail","帮助详细","幫助詳細");
$ls->wallet = array("Wallet","钱包","錢包");
$ls->src_wallet = array("Wallet","钱包","錢包");
$ls->src_deposit = array("Deposit reward","互助","互助");
$ls->src_sponsor = array("Sponsor reward","推荐奖金","推薦獎金");
$ls->src_manager = array("Manager reward","经理奖金","經歷獎金");
$ls->src_special = array("Special reward","特别奖金","特別獎金");
$ls->matched = array("Matched","已经配对","已經配對");
$ls->completed = array("Completed","已经完成","已經完成");
$ls->failed = array("Failed","已经失效","已經失效");
$ls->blocked = array("Blocked","已经被封锁","已經被封鎖");

$ls->confirm_rec = array("Confirm Reveive","确认收款","確認收款");
$ls->confirm_rec1 = array("Confirm you reveived the payment？","确定你收到款吗？","確定你收到款嗎？");
$ls->success = array("Success","操作成功","操作成功");
$ls->complain = array("Complain","举报","據報");
$ls->complain1 = array("Are you sure you did not receive the payment?","确定你没有收到款项, 要投訴吗?","確定你沒有收到款項，要投訴嗎?");
$ls->bank_card = array("Bank Card","银行卡","銀行卡");
$ls->alipay = array("Alipay","支付宝","支付寶");
$ls->wechat = array("Wechat","微信支付","微信支付");
$ls->btc = array("Bitcoin","比特币","比特幣");
$ls->eth = array("Ether","以太币","已太幣");
$ls->choose_file = array("Choose File","选择文件","選擇文件");
$ls->payment_method = array("Payment Method","支付方式","支付方式");
$ls->upload = array("Upload","上传","上傳");
$ls->cancel0 = array("Cancel Help","取消提供帮助","取消提供幫助");
$ls->cancel1 = array("Are you sure you want to cancel this help","确定你要取消这个提供帮助吗？","確定你要取消這個提供幫助嗎？");

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
<?


if ($setup->phdays==99) {
	$ls->wait = array("<b class=red>PH Rejected</b><br><br><br>You need to wait <b class=red>","<b class=red>提供帮助失败</b><br><br><br>之前的提供帮助还未完成,不能再次提供帮助","<b class=red>提供帮助失败</b><br><br><br>之前的提供帮助还未完成,不能再次提供帮助");
} else {
	$ls->wait = array("<b class=red>PH Rejected</b><br><br><br>You need to wait <b class=red>".$setup->phdays." more days to make another PH","<b class=red>提供帮助失败</b><br><br><br>你需要等多 <b class=red>".$setup->phdays."天</b> 才能再次提供帮助","<b class=red>提供帮助失败</b><br><br><br>你需要等多 <b class=red>".$setup->phdays."天</b> 才能再次提供帮助");
}
$ls->suretocancel = array("Are you sure you want to cancel?","您确定要取消?","您確定要取消?");
$ls->ordercancel = array("Order Cancelled","已取消","已取消");
$ls->created = array("<b class=blue>PH Created</b><br><br><br>Your request to Provide Help is created and is in queue for dispatcher","<b class=blue>PH 申请成功</b><br><br><br>你的 PH 申请已完成","<b class=blue>PH 申請成功</b><br><br><br>你的 PH 申請已完成");
$uid = (isset($_REQUEST['uid']))?$_REQUEST['uid']:0;
?>

  <style>
.red {
  color: red;
}
.green {
  color: green;
}
.blue {
  color: blue;
}
<style>
.table2_1 .table2_2 table {
  width:100%;
  margin:15px 0
}
.table2_1 th {
  background-color:#93DAFF;
  color:#000000
}
.table2_2 th {
  background-color:#EF913E;
  color:#000000
}
.table2_1, .table2_2,.table2_1 th, .table2_2 th,.table2_1 td, .table2_2 td
{
  font-size:0.95em;
  text-align:center;
  padding:4px;
  border:1px solid #c1e9fe;
  border-collapse:collapse
}
.table2_1 tr:nth-child(odd){
  background-color:#138A36;
}
.table2_1 tr:nth-child(even){
  background-color:#bcd979;
}
.table2_2 tr:nth-child(odd){
  background-color:#F18F01;
}
.table2_2 tr:nth-child(even){
  background-color:#F2B560;
}
.table2_1 tr .left, .table2_2 tr .left {
  text-align: left;
}
table
{
    border-collapse: collapse; /* 'cellspacing' equivalent */
}
table td, table th
{
    padding: 2px; /* 'cellpadding' equivalent */
}
/* Digital clock style */
/* If you want you can use font-face */
@font-face {
    font-family: 'BebasNeueRegular';
    src: url('fonts/BebasNeuewebfont.eot');
    src: url('fonts/BebasNeuewebfont.eot?#iefix') format('embedded-opentype'),
         url('fonts/BebasNeuewebfont.woff') format('woff'),
         url('fonts/BebasNeuewebfont.ttf') format('truetype'),
         url('fonts/BebasNeuewebfont.svg#BebasNeueRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}
/*.container {
    width: 960px;
    margin: 0 auto;
    overflow: hidden;
}*/
.clock {
    width: 100%;
    margin: 0 auto;
    padding: 5px;
    border: 0px solid #333;
    color: #000;
    text-align:right;
}
#curTime {
    font-family: 'BebasNeueRegular', Arial, Helvetica, sans-serif;
    font-size: 1.8em;
    text-align: right;
    padding-top:10px;
}
#Date {
    font-family: 'BebasNeueRegular', Arial, Helvetica, sans-serif;
    font-size: 1.2em;
    text-align: right;
    padding-top:10px;
    /*text-shadow: 0 0 5px #00c6ff;*/
}
.clock ul {
    padding: 0px;
    list-style: none;
    text-align: right;
}
.clock ul li {
    display: inline;
    font-size: 1.5em;
    text-align: center;
    font-family: 'BebasNeueRegular', Arial, Helvetica, sans-serif;
    letter-spacing:-0.05em;
    /*text-shadow: 0 0 5px #00c6ff;*/
}
#point {
    position: relative;
    -moz-animation: mymove 1s ease infinite;
    -webkit-animation: mymove 1s ease infinite;
    padding-left: 0px;
    padding-right: 0px;
    font-weight:bold;
}
/* Simple Animation */
@-webkit-keyframes mymove {
    0% {opacity: 1.0;
    text-shadow: 0 0 20px #00c6ff;
}
50% {
    opacity: 0;
    text-shadow: none;
}
100% {
    opacity: 1.0;
    text-shadow: 0 0 20px #00c6ff;
}
}
@-moz-keyframes mymove {
    0% {
        opacity: 1.0;
        text-shadow: 0 0 20px #00c6ff;
    }
    50% {
        opacity: 0;
        text-shadow: none;
    }
    100% {
        opacity: 1.0;
        text-shadow: 0 0 20px #00c6ff;
    };
}
  /* Tooltip */
  .remarks + .tooltip > .tooltip-inner {
      background-color: #666;
      color: #FFFFFF;
      border: 1px solid #666;
      padding: 5px;
      font-size: 14px;
  }
  /* Tooltip on top */
  .remarks + .tooltip.top > .tooltip-arrow {
      border-top: 5px solid #666;
  }
</style>
  <div align=center>
    <? echo ggNextPH("timer"); ?>
  </div>
<div class="row">
  <div class="col-md-6">
  	<div id="ph-box">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
  		<p><span class="ph-title"><? echo $ls->i_want_ph[$lang]; ?></span></p>
  		<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><button type="button" class="btn btn-success shadow btn-lg" data-toggle="modal" data-target="#provideHelp<? echo (ggNextPH('timer')=='')?'':'1'; ?>"><? echo $ls->titleph[$lang]; ?></button></p>
      <div style="clear:both;"></div>
  	</div>
  </div>

<?
include("_inc_providehelp.php");
?>
<? include("_db_modal_upload.php"); ?>
  <!-- GG Start -->
<div class="modal fade" id="provideHelp1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
                <div class="modal-header btn-success">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><? echo $ls->titleph[$lang]; ?></h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="provideHelpForm" name="provideHelpForm" class="form-control" style="height: 550px;">
                    <div class="modal-body">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                         <td colspan="2" style="text-align:left;">
                         <b class=red>申請提供幫助已達上限</b>
                         <br><br><b class=blue>下一段抢单时间 <? echo ggNextPH('period'); ?></b>
                         <br><br>每天开放四个时段抢单<br><br>中午12点<br>下午4点<br>晚上8点<br>晚上11点<br><br>透过每天严格掌握配置提供帮助的批量，来确保会员在洲际3M的安全跟长久，创造财富的路上并不孤单，因为洲际3M是最佳的选择！<br><br>洲际3M 科学控盘的品牌标竿，是我们一致的最高标准，并定下打款率100%的严格目标！<br><br>好盘不多只有洲际3M才能做到！</td>
                       </tr>
                     </table>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="modal-footer">
                      <a href="#" onclick="doClose()"class="btn btn-default" data-dismiss="modal">关闭</a>
<!--                      <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
-->
                    </div>
                  </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal -->
<!--GG End -->
  <div class="col-md-6">
  	<div id="gh-box">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
  		<p><span class="gh-title"><? echo $ls->i_want_gh[$lang]; ?></span></p>
  		<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><button type="button" class="btn btn-warning shadow btn-lg" data-toggle="modal" data-target="#requestHelpD"><? echo $ls->titlegh[$lang]; ?></button></p>
  	</div>
  </div>

<?
include("_inc_gethelp.php");
?>
<!-- Detail Start-->
  <!-- HDBox -->
    <div class="modal fade" id="detailForm" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:600px">
            <div class="modal-content">
                <div class="modal-header btn-success">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><? echo $ls->helpdetail[$lang]; ?></h4>
                </div>
                <div id="detailBody" class="modal-body">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal -->
<!-- Detail End -->
<!-- GG Star -->

<div style="clear:both;"></div>
<div class="container" style="width: 60%;">
	<div class="col-md-2" style="font-size:16px; padding-top:5px;"><? echo $ls->participants[$lang]; ?>：</div>
	<div class="col-md-8">
		<select name="mygroup" class="form-control" onchange="window.location = this.options[this.selectedIndex].value;">
			<option value="dashboard.php?uid=<? echo $user->id; ?>">YOU</option>
      <optgroup label="-------------------------------------------------"></optgroup><optgroup label="<? echo $ls->my_directs[$lang]; ?>"></optgroup>
<?
$dir = $db->query("select * from tblmember where referral=$user->id");
$ctr = 0;
while ($row = mysqli_fetch_object($dir)) {
  if ($row->id==$uid) {
    $ctr +=1;
  }
  $name = $row->fullname;
  if ($name=="") {
    $name = "未设定";
  }
  echo "<option value='dashboard.php?uid=$row->id' ".(($row->id==$uid)?"selected":"").">$row->username ($name)</option>";
}
echo "<optgroup label='-------------------------------------------------''></optgroup>";
$oth = $db->query("select * from tblmember where manager=$user->id and referral<>$user->id");
if (mysqli_num_rows($oth)>0) {
  echo "<optgroup label='经理与会员'></optgroup>";
}
while ($row = mysqli_fetch_object($oth)) {
  if ($row->id==$uid) {
    $ctr +=1;
  }
  $name = $row->fullname;
  if ($name=="") {
    $name = "未设定";
  }
  echo "<option value='dashboard.php?uid=$row->id' ".(($row->id==$uid)?"selected":"").">$row->username ($name)</option>";
}
// GG Reset $uid if not in list to top
if ($ctr == 0) {
  $uid = $user->id;
}
?>
      </select>
	</div>
</div>
<!--div class="container">
	<div id="context"></div>
</div-->
<div class="clear:both;"></div>
    <!-- Stack the columns on mobile by making one full-width and the other half-width -->

<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#groupA" data-toggle="tab"><? echo $ls->titleph[$lang]; ?> (<? echo ggHelpCount('P'); ?>)</a></li>
    <li role="presentation"><a href="#groupC" data-toggle="tab"><? echo $ls->titleph[$lang]; ?> (<? echo ggHelpCount('G'); ?>)</a></li>
</ul>
<div class="container" style="border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color:#fff; padding: 10px 0; margin-bottom: 20px;">
  <div class="tab-content">
    <div id="groupA" class="tab-pane fade in active">
      <div class="col-md-9" style="background-color:#fff;">
      <div class="table-responsive">
        <?
          echo ggPhDBox();
        ?>
      </div>
    </div>
    <div class="col-md-3">
<?
  echo ggPhBox();
?>
      <table id="dgin" width=100%></table>
 </div>
  <div class="clear:both;"></div>
    </div>
        <div id="groupC" class="tab-pane fade">
        <div class="col-md-9" style="background-color:#fff;">
      <div class="table-responsive">
        <?
          echo ggGhDBox();
        ?>

      </div>
    </div>
    <div class="col-md-3">
<?
  echo ggGhBox();
?>
 </div>
 <!-- <div class="clear:both;"></div>-->
</div>
</div>
</div>
</div>
</div>
</div>
<!-- GG Complete -->
<?
$upload_win = 1;
if ($upload_win) {
?>

   <div id="complete" class="easyui-window" title="上传打款单据" data-options="modal:false,minimizable:false,maximizable:false,collapsible:false,closed:true,iconCls:'icon-save'" style="width:500px;height:400px;padding:10px;">
        <form id="ff2" method="post">
            请选择你要上传的打款单据。系统只接受 JPG, PNG, GIF 档案 (限制 5MB)<br>
            <input id="fileToUpload" type="file" name="fileToUpload">
            <input id="help_id" type="hidden" name="help_id" value="">
            <img id="imagePreview" style="display: none; max-width: auto; height: 200px;" src="#" alt="Transaction Confirmation" /><br><br>
            <button class="btn btn-success" style="padding-left: 25px;" type="submit">上传图档</button>
            <a href="#" class="btn btn-default" onclick="$('#complete').window('close')">关闭</a>
        </form>
    </div>
<?
}
?>
<!-- GG End Complete -->


<!-- end Page Content -->
<!-- GG Scripts -->

<script type="text/javascript">
   $(document).ready(function() {
        var options = {
            url: 'dashboard_upload.php',
            success: showResponse
        };
        $('#ff2').submit(function(event) {
            event.preventDefault();
             if ($('#imagePreview').attr('src') == '' || $('#imagePreview').attr('src') == '#' || $('#imagePreview').attr('src').length <= 10) {
                $.messager.alert("请选择一个档案!");
            } else {
          			//$("#loading").show();
                $(this).ajaxSubmit(options);
            }
            return false;
        });
        var imagePreview = $("#imagePreview");
        $('.panel-tool-close').click(function(event) {
            imagePreview.replaceWith( imagePreview = imagePreview.clone( true ) );
            $('#imagePreview').attr('src','#');
            $('#imagePreview').css({'display':'none'});
        });
    });
    function showResponse(responseText, statusText, xhr, $form) {
      	$("#loading").hide();
        var res = JSON.parse(responseText);
        if (!res.success) {
            $.messager.alert("上传打款单据","错误信息: " + res.msg, "error");
        } else {
            $.messager.alert("上传打款单据","已经收到你打款的单据","info",function(){
              	$("#loading").show();
                location.reload();
            });
        }
    }
    function showResponse1(responseText, statusText, xhr, $form) {
        alert("ok");
    }

     $("#fileToUpload").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').css({'display':'initial'});
                $('#imagePreview').attr('src', reader.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
$(function(){
/*toastr.options = {
    "closeButton": true,
    "timeOut": "180000",
}; */
<?
/*
if ($sys_msg<>"") {
  echo "toastr.warning('$sys_msg')";
}
*/
?>
});
function doPH() {
  $('#provideHelpForm').form('submit',{
    url: "_action_ph.php",
    onSubmit: function(){
      return $(this).form('validate');
    },
    success: function(res){
      var res = JSON.parse(res);
      if (res.status =="success") {
        $.messager.alert("<? echo $ls->titleph[$lang]; ?>","<? echo $ls->successfulph[$lang]; ?>","info",function(r){
          location.reload();
        });
      } else {
        $.messager.alert("<? echo $ls->titleph[$lang] ?>",res.msg,"error",function(r){
          location.reload();
        });
      }
    }
  });
}

function doCancel(id) {
    $.messager.confirm('<? echo $ls->cancel0[$lang]; ?>', '<? echo $ls->cancel1[$lang]; ?>', function(r){
        if (r) {
              $("#loading").show();
              jQuery.ajax({
                type: "POST",
                url: 'dashboard_cancel.php',
                data: {id: id},
                success: function(res) {
                      $("#loading").hide();
                      var res = JSON.parse(res);
                    if (res.success) {
                        $.messager.alert("<? echo $ls->cancel0[$lang]; ?>","<b class=blue><? echo $ls->success[$lang]; ?></b>","info",function(r) {
                            location.reload();
                        });
                    } else {
                        $.messager.alert("<? echo $ls->cancel0[$lang]; ?>", res.msg);
                    }
                }
            });
        }
    });
}
function doDetail(hid) {
  //document.getElementById("helpdetail").innerHTML = id;
  $("#loading").show();
  $.post("dashboard_detail.php",{hid: hid},function(res){
      var res = JSON.parse(res);
      if (res.success) {
        $("#detailBody").html(res.msg+'<br><br>&nbsp;&nbsp;'+res.action);
      	$("#loading").hide();
      }
  });
}
// doStar
function doStarph(hid) {
    $("#loading").show();
    var frm = document.getElementById('uploadForm');
    var help_id = document.getElementById('help_id');
    $('#complete').window('open');  // open a window
    help_id.value = hid;
    $("#loading").hide();
}
function doStargh(hid) {
    $("#loading").show();
    var frm = document.getElementById('uploadForm');
    var gh_id = document.getElementById('gh_id');
    $('#confirm').window('open');  // open a window
    gh_id.value = hid;
    $("#loading").hide();
}
function doUpload() {
    var options = {
        url: 'dashboard_upload.php',
        success: showResponse
    };
    if ($('#imagePreview').attr('src') == '' || $('#imagePreview').attr('src') == '#' || $('#imagePreview').attr('src').length <= 10) {
        //toastr.error("Please select a file!");
        alert("Please select a file!");
    } else {
        toastr.success("Uploading image, do not refresh page!");
        $(this).ajaxSubmit(options);
    }
}
function openComplete() {
    $('#complete').window('open');  // open a window
    var frm = document.getElementById('uploadForm');
    //frm.innerHTML = '<form id="ff1" action="#" method="post" enctype="multipart/form-data">Attach image (scans, screen shots) confirming this transaction<br><br><input id="fileToUpload" type="file" name="fileToUpload"><br><br>Documents addition is desired, but not requirted.<br>Acceptable file formats are JPG, PNG, GIF (mamum 2MB)<br><br><a href="#" class="btn2 close" onclick="closeComplete()"><span class="btn btncancel">Close</span></a><a href="#" class="btn2 save" onclick="uploadFile()"><span class="btn btnsave2">Upload File</span></a><input type="Submit"></form>';
}

function GHAction(type) {
    var act = "GH";
    var mavro = "deposit";
    var amount = document.getElementById('sell_amount'+type).value;

      jQuery.ajax({
          type: "POST",
          url: '_action_gh.php',
          data: {act:act, mavro: mavro, amount: amount},
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

/*
  $('#clock').countdown('<? echo ggNextPH("countdown"); ?>')
    .on('update.countdown', function(event) {
       var format = '%M 分 %S 秒';
       $(this).html(event.strftime(format));
  })
    .on('finish.countdown', function(event) {
    location.reload();
  });
*/
function doUpload(id) {
  $("#help_id").val(id);
  $('#detailForm').modal('hide');
}
function doClose() {
  location.reload();
}
function doChange() {
  //alert("change");
}

function doConfirm(helpid) {
    $.messager.confirm("<? echo $ls->confirm_rec[$lang]; ?>", "<? echo $ls->confirm_rec1[$lang]; ?>", function(r){
        if (r) {
            $("#loading").show();
            jQuery.ajax({
                type: "POST",
                url: 'dashboard_confirm.php',
                data: {helpid: helpid},
                success: function(res) {
                    $("#loading").hide();
                    var res = JSON.parse(res);
                    if (res.success) {
                        $.messager.alert("<? echo $ls->confirm_rec[$lang]; ?>","<b class=blue><? echo $ls->success[$lang]; ?></b>","info",function(r) {
            				$("#loading").show();
                            location.reload();
                        });
                    } else {
                        $.messager.alert("<? echo $ls->confirm_rec[$lang]; ?>","Error Msg: " + res.msg);
                    }
                }
            });
        }
    });
}

function doFake(helpid) {
    $.messager.confirm('<? echo $ls->complain[$lang]; ?>', '<b class=red><? echo $ls->complain1[$lang]; ?></b>', function(r){
        if (r) {
            $("#loading").show();
            jQuery.ajax({
                type: "POST",
                url: 'dashboard_fake.php',
                data: {helpid: helpid},
                success: function(res) {
                    $("#loading").hide();
                    var res = JSON.parse(res);
                    if (res.success) {
                        $.messager.alert("<? echo $ls->complain[$lang]; ?>","<b class=blue>已经标识为假收据</b>","info",function(r) {
            				      $("#loading").show();
                            location.reload();
                        });
                    } else {
                        $.messager.alert("<? echo $ls->complain[$lang]; ?>","出错: " + res.msg);
                    }
                }
            });
        }
    });
}
</script>

<?
function ggPhAmounts() {
  global $setup;
  $ret='';
  $phlist = explode(",",$setup->phlist);
  $count = count($phlist);
  for ($i=0; $i < $count; $i++) {
      $amt = $phlist[$i] * $setup->exrate;
      $ret .= "<option value='$amt' ".($i==0? "selected":"").">$amt</option>";
  }
  return $ret;
}

function ggHelpCount($t) {
  global $user;
  $help = ggFetchValue("select count(id) from tblhelp where mem_id = $user->id and g_type='$t' and status<>'X'");
  return $help;
}

function ggPhDBox() {
    global $db, $setup, $user, $ls, $lang, $uid;

    $now = new datetime("now");
    $rs = $db->query("select * from tblhelpdetail where mem_id=$uid and g_type='P' order by id desc");
    while ($row = mysqli_fetch_object($rs)) {
        $class = ($row->g_type=='P')? 'table2_1':'table2_2';
        $oth = load_user($row->oth_id);
        $mem = load_user($uid);
        if ($row->stage == 2 || $row->stage == 4) {
          $time_remain = "";
        } else {
          $time_remain = ggTimeRemain($now,$row->g_timer);
        }
        echo "<table width='100%' class='$class'>";
        echo "<tr><td>".$ls->status[$lang]."</td><td>".$ls->match_code[$lang]."</td><td><? echo $ls->titleph[$lang]; ?></td><td></td><td>".$ls->ph_amount[$lang]."</td><td></td><td><? echo $ls->titlegh[$lang]; ?></td></tr>";

        $preview = "";
        if ($row->images<>"") {
          $preview = "<a href='$row->images' target='_blank'><img src='images/preview.jpg' width='25px' height='25px'></a>";
        }

        if ($row->stage<3) {
          $img = "star".($row->stage+1).".png";
        } else if ($row->stage==3) {
          $img = "question.png";
        } else {
          $img = "cross.png";
        }

        if ($row->g_type=='P') {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$mem->username<br>$mem->fullname<br>$mem->bankname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$oth->username<br>$oth->fullname<br>$oth->bankname</td></tr>";
        } else {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$oth->username<br>$oth->fullname<br>$oth->bankname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$mem->username<br>$mem->fullname<br>$mem->bankname</td></tr>";
        }
        echo "</table><p style='height: 1px'></p>";
    }

}

function ggGhDBox() {
  global $db, $setup, $user, $lang, $ls,$uid;
    $now = new datetime("now");
    $rs = $db->query("select * from tblhelpdetail where mem_id=$uid and g_type='G' order by id desc");
    while ($row = mysqli_fetch_object($rs)) {
        $class = ($row->g_type=='P')? 'table2_1':'table2_2';
        $oth = load_user($row->oth_id);
        $mem = load_user($uid);
        if ($row->stage == 2 || $row->stage == 4) {
          $time_remain = "";
        } else {
          $time_remain = ggTimeRemain($now,$row->g_timer);
        }
        echo "<table width='100%' class='$class'>";
        echo "<tr><td>".$ls->status[$lang]."</td><td>".$ls->match_code[$lang]."</td><td><? echo $ls->titleph[$lang]; ?></td><td></td><td>".$ls->gh_amount[$lang]."</td><td></td><td><? echo $ls->titlegh[$lang]; ?></td></tr>";

        $preview = "";
        if ($row->images<>"") {
          $preview = "<a href='$row->images' target='_blank'><img src='images/preview.jpg' width='25px' height='25px'></a>";
        }

        if ($row->stage<3) {
          $img = "star".($row->stage+1).".png";
        } else if ($row->stage==3) {
          $img = "question.png";
        } else {
          $img = "cross.png";
        }

        if ($row->g_type=='P') {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$mem->username<br>$mem->fullname<br>$mem->bankname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$oth->username<br>$oth->fullname<br>$oth->bankname</td></tr>";
        } else {
          echo "<tr><td><img src='images/$img' width=40 height=40></td><td>".ggAID($row->id)."<br>".substr($row->g_date,0,16)."<br><b class='red'>$time_remain</b></td><td width=100>$oth->username<br>$oth->fullname<br>$oth->bankname</td><td>-></td><td>$row->g_amount $setup->currency<br>$preview <button onclick='doDetail($row->id)' type='button' class='btn btn-success' data-toggle='modal' data-target='#detailForm'>".$ls->detail[$lang]."</button></td><td>-></td><td width=100>$mem->username<br>$mem->fullname<br>$mem->bankname</td></tr>";
        }
        echo "</table><p style='height: 1px'></p>";
    }
    return $ret;
}

function ggPhBox() {
    global $db, $setup, $user, $ls, $lang, $uid;
    $ret = "";

    if ($rs = $db->query("select * from tblhelp where mem_id=$uid and g_type='P' and status<>'X' order by g_date desc")) {
    $now = new DateTime("NOW");
    while ($row = mysqli_fetch_object($rs)) {
      $class = ($row->g_type=='P')? 'table2_1':'table2_2';
      $g_date = new DateTime($row->g_date);
      $interval = $now->diff($g_date);
      $days = $interval->format("%d");

      if ($row->status=="X") {
         $color = 'silver';
         $status = $ls->cancelled[$lang];
      } else if ($row->status=="P") {
         $color = '#bcd979';
         $status = $ls->matching[$lang];
         $pending1 = $ls->w_matching[$lang]."<br>";
         $pending2 = number_format($row->g_pending)."  $setup->currency<br>";
      } else if ($row->status=="C") {
         $color = '#bcd979';
         $status = $ls->matched[$lang];
      } else if ($row->status=="D") {
         $color = '#bcd979';
         $status = $ls->completed[$lang];
      } else if ($row->status=="F") {
         $color = '#bcd979';
         $status = "<b class=red>".$ls->failed[$lang]."</b>";
      } else if ($row->status=="B") {
         $color = '#bcd979';
         $status = "<b class=red>".$ls->blocked[$lang]."</b>";
      } else {
         $color = '#bcd979';
         $status = $ls->waiting1[$lang].$days.$ls->waiting2[$lang];
      }
      $cancel = "";
      if ($row->status=="O" and $days < 7) {
          $cancel = "<br><a ref='#' class='btn btn-danger' onclick='doCancel($row->id)'>".$ls->cancel[$lang]."</a>";
      }
      // GG PHBox2
      $ret .= "<table width='100%' class=$class>";
      $uname = ggFetchValue("select username from tblmember where id = $row->mem_id");
      $ret .= "<tr bgcolor=green><td colspan=2 style='color: white; font-size:100%;'>".$ls->aph[$lang].": <br>".ggHID($row->id)."</td></tr>";
      $ret .= "<tr><td style='text-align:left; vertical-align:top;'>".$ls->participants[$lang].":<br>".$ls->ph_amount[$lang].":<br>$pending1 ".$ls->date[$lang].":<br>".$ls->status[$lang].":</td><td style='text-align:left; vertical-align:top;'>$uname<br>".number_format($row->g_amount)." $setup->currency<br>$pending2 ".substr($row->g_date,0,16)."<br>$status $cancel</td></tr>";
      $ret .= "</table><br>";
    }
  }
  return $ret;
}


function ggGhBox() {
  global $db, $setup, $user,$uid,$ls,$lang;
  $ret = "";

  if ($rs = $db->query("select * from tblhelp where mem_id=$uid and g_type='G' and status<>'X'")) {
    $now = new DateTime("NOW");
    while ($row = mysqli_fetch_object($rs)) {
      $class = ($row->g_type=='P')? 'table2_1':'table2_2';
      $g_date = new DateTime($row->g_date);
      $interval = $now->diff($g_date);
      $days = $interval->format("%d");

      $pending1="";
      $pending2 = "";
      if ($row->status=="X") {
         $color = 'silver';
         $status = $ls->cancelled[$lang];
      } else if ($row->status=="P") {
         $color = '#bcd979';
         $status = $ls->matching[$lang];
         $pending1 = $ls->w_matching[$lang]."<br>";
         $pending2 = number_format($row->g_pending)."  $setup->currency<br>";
      } else if ($row->status=="D") {
         $color = '#bcd979';
         $status = $ls->completed[$lang];
       } else if ($row->status=="C") {
         $color = '#bcd979';
         $status = $ls->matched[$lang];
      } else if ($row->status=="B") {
         $color = '#bcd979';
         $status = "<b class=red>".$ls->blocked[$lang]."</b>";
      } else {
         $color = '#bcd979';
         $status = $ls->waiting1[$lang].$days.$ls->waiting2[$lang];
      }

      $source1 = $ls->src_wallet[$lang].":<br>";
      if ($row->note == 'deposit') {
        $source2 = $ls->src_deposit[$lang]."<br>";
      } else if ($row->note == 'referral') {
        $source2 = $ls->src_sponsor[$lang]."<br>";
      } else if ($row->note == 'manager') {
        $source2 = $ls->src_manager[$lang]."<br>";
      } else {
        $source2 = $ls->src_special[$lang]."<br>";
      }

      $cancel = "";
      if ($row->status=="O" and $days < 7) {
          $cancel = "<br><a ref='#' class='btn btn-danger' onclick='doCancel($row->id)'>".$ls->cancel[$lang]."</a>";
      }
      // GG PHBox2
      $ret .= "<table width='100%' class=$class>";
      $uname = ggFetchValue("select username from tblmember where id = $row->mem_id");
      $ret .= "<tr bgcolor=green><td colspan=2 style='color: white; font-size:100%;'>".$ls->agh[$lang].": <br>".ggHID($row->id)."</td></tr>";
      $ret .= "<tr><td style='text-align:left; vertical-align:top;'>".$ls->participants[$lang].":<br>".$ls->gh_amount[$lang].":<br>$pending1 $source1 ".$ls->date[$lang].":<br>".$ls->status[$lang].":</td><td style='text-align:left; vertical-align:top;'>$uname<br>".number_format($row->g_amount)." $setup->currency<br>$pending2 $source2".substr($row->g_date,0,16)."<br>$status $cancel</td></tr>";
      $ret .= "</table><br>";
    }
  }
  return $ret;
}

include("inc/ggFooter.php");
?>