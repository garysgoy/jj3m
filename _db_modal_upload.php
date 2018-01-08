<!-- 上传支付凭证 -->
<div class="modal fade" id="upp_modal" tabindex="-1" role="modal" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel4"></h4>
      </div>
      <div class="modal-body" id="myModalContent4">

        <form class="form-horizontal" name="ff2" id="ff2" method="post" action="_db_upload.php" enctype="multipart/form-data">
        <input type="hidden" name="help_id" id="help_id"/>
                    <div class="form-group m-b-xs">
                        <label class="col-sm-2 control-label m-t-im">选择文件</label>
                        <div class="col-sm-8 m-t-im">
                            <input name="imgFile" id="upfile" type="file" class="filestyle" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
                        </div>
                    </div>
                    <div class="form-group m-b-xs">
                        <label class="col-sm-2 control-label m-t-im">支付方式</label>
                        <div class="col-sm-7 m-t-im">
                            <select name="zflx" class="form-control">
                              <option value="支付宝">支付宝</option>
                              <option value="微信">微信</option>
                              <option value="银行卡">银行卡</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label m-t-im"></label>
                        <div class="col-sm-8 m-t-im">
<?
$use_post = false;
if ($use_post) { ?>
                          <input type="sumbit" id="ff2s" class="btn btn-success btn-s-xs btn" value="上传">
<? } else { ?>
                          <a class="btn btn-success btn-s-xs btn" id="ff2s" onclick="upload()"> 上传 </a>
<? } ?>
                        </div>
                    </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

      </div>
    </div>
  </div>
</div>

<script>
function upload() {
    $("#ff2s").prop('disabled', 'disabled');

    $("#ff2").ajaxSubmit({
        type: 'post', // 提交方式 get/post
        url: '_db_upload.php', // 需要提交的 url
        dataType: "json",
        async:true,
        success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
            if (data.status=='success') {
              $.messager.alert("提交方式","提交成功","info",function(r) {
                location.reload();
              });
            } else {
              $.messager.alert("提交失败",data.msg,"error",function(r) {
                location.reload();
              });
            }
        },
        error: function(data) {
          alert("Error In Uploading, Please contact admin");
          location.reload();
        }
    });
    return false; // 阻止表单自动提交事件
}
</script>