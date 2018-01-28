<?php
include_once("inc/ggInit.php");
include_once("inc/ggFunctions.php");

if ($user->logged==0 || $user->rank<1) {
  header("location: login.php");
}

if ($user->rank==1 && $user->fullname=="") {
  header("location: profile.php");
}

$pin = ggPinCount(1);

$list = new stdClass();
$list = ggMyList();


//$page_css[] = "";
$page_title = $mls->activate[$lang];
$page_nav["mem_mgt"]["sub"]["activate"]["active"] = true;

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
        <form class="form-horizontal" data-validate="parsley">
            <section class="panel panel-default">
                <header class="panel-heading">
                    <strong>激活会员</strong>
                    &nbsp;&nbsp;剩余可用激活码：<b style="color:red;"><? echo $pin; ?></b> 个
                </header>

                <div class="panel-body">
	                <div class="table-responsive" style="border: none">
	                    <table class="table table-striped b-t b-light">
	                        <thead>
	                        <tr>
	                            <th>会员账号</th>
	                            <th>状态</th>
	                            <th>操作</th>
	                            <th>真实姓名</th>
	                            <th>电话</th>
	                            <th>注册时间</th>
	                        </tr>
	                        </thead>
	                        <tbody>
	                          <? echo $list['data']; ?>
	                        </tbody>
	                    </table>
	                </div>
	               </div>
                <footer class="panel-footer">
                    <div class="text-center text-center-xs">
                      <div style="z-index: 2;
                  color: #788188;
                  cursor: default;
                  border-color: #428BCA;">
                          总计 <? echo $list['count']; ?> 条记录 1 ／ 1 页<a href=/index.php?con=ucenter&act=pt_user&p=1>第一页</a> <span href=/index.php?con=ucenter&act=pt_user&p=1 class='disabled'>上一页</span> <span href=/index.php?con=ucenter&act=pt_user&p=2 class='disabled'>下一页</span> <a href=/index.php?con=ucenter&act=pt_user&p=1>最后一页</a> 到第 <select id='select' onchange='window.location.href="/index.php?con=ucenter&act=pt_user&p="+this.value'><option value='1' selected>1</option></select> 页                         </div>

                    </div>
                </footer>

            </section>
        </form>
	  </div>
	</div>
<!--/div-->
</div> <!-- end Page Content -->
<?

function ggMyList() {
  global $db, $user;

  $ret = array();
  $data = "";

  $ret['page'] = 1;
  $rs = $db->query("select * from tblmember where referral=$user->id order by date_add desc");
  $ret['count'] = mysqli_num_rows($rs);
  while ($row = mysqli_fetch_object($rs)) {
    if ($row->pin =="") {
      $status = "<b style='color:red'>待激活</b>";
      $action = '<a class="btn btn-info btn-xs" id="btn_alive" onclick="alive_do('.$row->id.')">激活</a>&nbsp;
                <a class="btn btn-info btn-xs" id="btn_del" onclick="del_no_alive_user('.$row->id.')">删除</a>&nbsp;';
    } else {
      $status = "<b style='color:green'>正常</b>";
      $action = "暂无";
    }
    $data .= "<tr><td>$row->username</td><td>$status</td><td>$action</td><td>$row->fullname</td><td>$row->phone</td><td>$row->date_add</td></tr>";
  }
  $ret['data'] = $data;
  return $ret;
}

include("_script.php");
include("_footer.php");
?>