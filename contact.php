<?
include_once("inc/ggInit.php");
include_once("_ggFunctions.php");

//$page_css[] = "";
$page_title = $mls->support[$lang];;
$page_nav["support"]["active"] = true;

$ls = new stdClass();

$user = load_user(0);

$ls->title = array("Support Ticket","联系客服","聯繫客服");
$ls->successful = array("Message Sent","信息顺利提交","信息顺利提交");

include("inc/ggHeader.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
  <? include("inc/ribbon.php"); ?>
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row" style="padding: 15px 15px;">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-envelope"></i> <? echo $ls->title[$lang]; ?></h3>
		<span class="small-tag">在这里，你可以提交你所面对的疑难，这将被发送到CRO或CRO的同事，您的请求我们将会尽快的处理。我们的服务时间是在周一至周五，北京/香港时间 9:00 到 17:00。</span>
	  </div>
	  <div class="panel-body">
		<div class="col-md-4" style="background-color:#ddd; padding-top: 10px; padding-bottom: 10px; margin-bottom: 10px;">
			<h4>提交问题</h4>
			<form action="" method="POST" id="contactForm" enctype="multipart/form-data">
				<p><label for="question">问题<br/>
					<select class="form-control" id="question" name="question">
<option value="1">系统错误</option>
<option value="2">参与者拒绝汇款</option>
<option value="3">经理操作不合理</option>
<option value="4">接款者不愿意确认收款</option>
<option value="5">汇款时，对方银行资料与系统提供的有差别</option>
<option value="6">参与者账号被封锁了</option>
<option value="7">未确认收款</option>
<option value="8">错误的操作</option>
<option value="9">无法接受手机短信</option>
<option value="10">无法提交提供帮助申请</option>
<option value="11">无法提交接收帮助申请</option>
<option value="12">系统显示的金额有误</option>
<option value="13">更换邮箱</option>
<option value="14">更换手机号码</option>
<option value="15">举报诈骗行为</option>
<option value="16">无法更新汇款状态</option>
<option value="17">无法更新接款状态</option>
<option value="18">未获得款项</option>
<option value="19">我需要更换我的经理</option>
<option value="20">其他问题</option>
						</select>
				</label></p>
				<p><label for="subject">标题<br/>
					<input type="text" name="subject" id="subject" value="" placeholder="标题" class="form-control" required />
				</label></p>
				<p><label for="message">内容<br/>
					<textarea name="message" id="message" placeholder="内容" class="form-control" row="10" cols="35" style="resize:none; height: 100px;" required></textarea>
				</label></p>
				<p><label for="upload">上传图片<br/>
					<input type="file" name="upload">
				</label></p>
				<p>
				<!-- <input type="submit" class="btn btn-default btn-primary" onclick="doSave()" id="contact-btn" value="提交" /> -->
				<a href="#" class="btn btn-default btn-primary" onclick="doSave()">提交</a>
				</p>
			</form>
		</div>
		<div class="col-md-8">
						<div class="table-responsive">
							<table class="table table-striped" id="empty-table">
								<thead>
									<tr>
										<th style="width:11%;">编号</th>
										<th style="width:13%;">时间</th>
										<th style="width:16%;">问题类别</th>
										<th style="width:22%;">发件人</th>
										<th style="width:15%;">标题</th>
										<th style="width:11%;">状态</th>
										<th style="width:10%;">操作</th>
									</tr>
								</thead>
								<tbody>
<?
$rs = $db->query("select * from tblsupport where mem_id = $user->id");
while ($row = mysqli_fetch_object($rs)) {
	if ($row->status=='') {
		$status = '等待回复';
	} else if ($row->status=='D') {
		$status = '已经处理';
	}
	echo "<tr><td>$row->id</td><td>$row->mdate</td><td>$row->question</td><td>$row->username</td><td>$row->subject</td><td>$status</td></tr>";
}
?>

								</tbody>
							</table>
						</div>
		</div>
	  </div>
	</div>
<!--/div-->
			</div> <!-- end Page Content -->

<script>
function doSave() {
	$('#contactForm').form('submit',{
		url: "contact_save.php",
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

<?
include("_script.php");
include("_footer.php");
?>