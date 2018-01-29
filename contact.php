<?
include_once("inc/ggInit.php");
include_once("inc/ggFunctions.php");

//$page_css[] = "";
$page_title = $mls->support[$lang];;
$page_nav["support"]["active"] = true;

$ls = new stdClass();

$user = load_user(0);

$ls->title = array("Support Ticket","联系客服","聯繫客服");
$ls->successful = array("Message Sent","信息顺利提交","信息顺利提交");
$ls->th = array('<th>S/No</th><th>Time</th><th>Send By</th><th>Subject</th><th>Message</th><th>Status</th><th>Action</th>',
	'<th style="width:5%;">编号</th><th style="width:19%;">时间</th><th style="width:22%;">发件人</th><th style="width:15%;">标题</th><th style="width:11%;">信息</th><th style="width:11%;">状态</th><th style="width:10%;">操作</th>',
	'<th style="width:5%;">編號</th><th style="width:19%;">時間</th><th style="width:22%;">發件人</th><th style="width:15%;">標題</th><th style="width:11%;">信息</th><th style="width:11%;">狀態</th><th style="width:10%;">操作</th>');
$ls->successful = array("Message Sent","信息顺利提交","信息顺利提交");
$ls->submit_requet = array("Submit Request"," 提交问题","提交問題");
$ls->issue = array("Issue"," 问题","問題");
$ls->subject = array("Subject","标题","標題");
$ls->message = array("message","内容","內容");
$ls->submit = array("Submit","提交","提交");
$ls->pending = array("Pending","等待回复","等待回覆");
$ls->done = array("Replied","已经回复","已經回覆");

include("inc/ggHeader.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<? include("inc/ribbon.php"); ?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row" style="padding: 15px 15px;">
			<div class="panel panel-bar">
				<div class="panel-heading">
					<h4><i class="fa fa-envelope"></i> <? echo $ls->title[$lang]; ?></h4>
					<!--<span class="small-tag">在这里，你可以提交你所面对的疑难，这将被发送到CRO或CRO的同事，您的请求我们将会尽快的处理。我们的服务时间是在周一至周五，北京/香港时间 9:00 到 17:00。</span>-->
				</div>
				<div class="panel-body">
					<div class="col-md-4" style="padding: 20px">
						<h4><? echo $ls->submit_request[$lang]; ?></h4>
						<form action="" method="POST" id="contactForm" enctype="multipart/form-data">
							<?
							$subject=false;
							if ($subject) {
								?>
								<p><label for="question"><? echo $ls->issue[$lang]; ?><br/>
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
								</label>
							</p>
							<? } ?>
							<p><label for="subject"><? echo $ls->title[$lang]; ?><br/>
								<input type="text" name="subject" id="subject" value="" placeholder="<? echo $ls->subject[$lang]; ?>" class="form-control" required />
							</label>
						</p>
						<p><label for="message"><? echo $ls->message[$lang]; ?><br/>
							<textarea name="message" id="message" placeholder="<? echo $ls->message[$lang]; ?>" class="form-control" row="10" cols="35" style="resize:none; height: 100px;" required></textarea>
						</label></p>
						<?
						$upload=false;
						if ($upload){
							?>
							<p><label for="upload"><? echo $ls->upload_pic[$lang]; ?><br/>
								<input type="file" name="upload">
							</label></p>
							<? } ?>
							<p>
								<!-- <input type="submit" class="btn btn-default btn-primary" onclick="doSave()" id="contact-btn" value="提交" /> -->
								<a href="#" class="btn btn-default btn-primary" onclick="doSave()"><? echo $ls->submit[$lang]; ?></a>
							</p>
						</form>
					</div>
					<div class="col-md-8" style="padding: 20px">
						<div class="table-responsive">
							<table class="table table-striped" id="empty-table">
								<thead>
									<tr>
										<? echo $ls->th[$lang]; ?>
									</tr>
								</thead>
								<tbody>
									<?
									$rs = $db->query("select * from tblsupport where mem_id = $user->id");
									while ($row = mysqli_fetch_object($rs)) {
										if ($row->status=='') {
											$status = $ls->pending[$lang];
										} else if ($row->status=='D') {
											$status = $ls->done[$lang];
										}
										echo "<tr><td>$row->id</td><td>$row->mdate</td><td>$row->username</td><td>$row->subject</td><td>$row->content</td><td>$status</td><td>&nbsp;</td></tr>";
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