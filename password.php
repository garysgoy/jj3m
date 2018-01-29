<?php
include_once("inc/ggInit.php");
if ($user->logged==0 || $user->rank<1) {
	header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
	header("location: profile.php");
}


//$page_css[] = "";
$page_title = $mls->password[$lang];
$page_nav["account"]["sub"]["password"]["active"] = true;

$ls = new stdClass();
$ls->title = array("Change Password","更改密码","更改密碼");
$ls->title2 = array("Change Transaction Pass","更改二级密码","更改二级密碼");
$ls->successful = array("Password Changed","更改密码完成","更改密碼完成");
$ls->old_pass = array("Current Password","原密码","原密碼");
$ls->new_pass = array("New Password","新密码","新密碼");
$ls->cnew_pass = array("Confirm New Password","确认新密码","確認新密碼");
$ls->old_pass2 = array("Current Transaction Password","原二级密码","原二級密碼");
$ls->new_pass2 = array("New Transaction Password","新二级密码","新二級密碼");
$ls->cnew_pass2 = array("Confirm New Transaction Password","确认新二级密码","確認新二級密碼");
$ls->submit     = array("Submit","提 交","提 交");
include("inc/ggHeader.php");

?>
<div id="main" role="main">
	<? include("inc/ribbon.php"); ?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row" style="padding: 15px 15px;">
			<div class="col-md-6">
				<div class="panel panel-bar">
					<div class="panel-heading">
						<h4><i class='fa fa-user-secret'></i>  <? echo $ls->title[$lang]; ?></h4>
					</div>
					<div class="panel-body" style="padding:10px;">

						<form action="" method="POST" id="passwordForm" data-toggle="validator">
							<div class="form-group">
								<label for="currentpassword"><? echo $ls->old_pass[$lang]; ?><span class="required-tag">*</span></label>
								<input type="password" class="form-control" name="currentpassword" id="currentpassword" placeholder="<? echo $ls->old_pass[$lang]; ?>" value="" required />
							</div>
							<div class="form-group">
								<label for="newpassword"><? echo $ls->new_pass[$lang]; ?><span class="required-tag">*</span></label>
								<input type="password" class="form-control" name="newpassword" id="newpassword" value="" placeholder="<? echo $ls->new_pass[$lang]; ?>" required />
							</div>
							<div class="form-group">
								<label for="newpassword2"><? echo $ls->cnew_pass[$lang]; ?><span class="required-tag">*</span></label>
								<input type="password" class="form-control" name="newpassword2" id="newpassword2" value="" placeholder="<? echo $ls->cnew_pass[$lang]; ?>" required />
							</div>
							<p style="text-align:center;">
								<!--				  <input type="submit" class="btn btn-default btn-success" value="提交" /> -->
								<a href="#" onclick="savePass1()" class="btn btn-default btn-success"><? echo $ls->submit[$lang]; ?></a>
							</p>
							<input type="hidden" name="mode" id="mode" value="2" />
						</form>
					</div>
				</div>
			</div>
				<div class="col-md-6">
					<div class="panel panel-bar">
						<div class="panel-heading">
							<h4><i class='fa fa-user-secret'></i>  <? echo $ls->title2[$lang]; ?></h4>
						</div>
						<div class="panel-body" style="padding:10px;">
							<form action="" method="POST" id="securepinForm" data-toggle="validator">
								<div class="form-group">
									<label for="currentpassword"><? echo $ls->old_pass2[$lang]; ?><span class="required-tag">*</span></label>
									<input type="password" class="form-control" name="currentpassword" id="currentpassword" placeholder="<? echo $ls->old_pass2[$lang]; ?>" value="" required />
								</div>
								<div class="form-group">
									<label for="newpassword"><? echo $ls->new_pass2[$lang]; ?><span class="required-tag">*</span></label>
									<input type="password" class="form-control" name="newpassword" id="newpassword" value="" placeholder="<? echo $ls->new_pass2[$lang]; ?>" required />
								</div>
								<div class="form-group">
									<label for="newpassword2"><? echo $ls->cnew_pass2[$lang]; ?><span class="required-tag">*</span></label>
									<input type="password" class="form-control" name="newpassword2" id="newpassword2" value="" placeholder="<? echo $ls->cnew_pass2[$lang]; ?>" required />
								</div>
								<p style="text-align:center;">
									<!--				  <input type="submit" class="btn btn-default btn-success" value="提交" /> -->
									<a href="#" onclick="savePass2()" class="btn btn-default btn-success"><? echo $ls->submit[$lang]; ?></a>
								</p>
								<input type="hidden" name="mode" id="mode" value="4" />
							</form>
						</div>
					</div>
				</div>
				<div>
				</div> <!-- end Page Content -->
				<script>
					function savePass1() {
						$('#passwordForm').form('submit',{
							type: 'post',
							url: "password_save1.php",
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
					function savePass2() {
						$('#securepinForm').form('submit',{
							type: 'post',
							url: "password_save2.php",
							onSubmit: function(){
								return $(this).form('validate');
							},
							success: function(res){
								var res = JSON.parse(res);
								if (res.success) {
									$.messager.alert("<? echo $ls->title2[$lang]; ?>","<? echo $ls->successful[$lang]; ?>","info",function(r){
										location.reload();
									});
								} else {
									$.messager.alert("<? echo $ls->title2[$lang]; ?>",res.msg,"error");
								}
							}
						});
					}
				</script>
				<?
				include("_script.php");
				include("_footer.php");
				?>