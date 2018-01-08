    <!-- 接受帮助 Modal -->
    <div class="modal fade" id="requestHelpR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
                <div class="modal-header btn-warning">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><? echo $ls->titlegh[$lang]; ?> - 推荐</h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="getHelpForm" name="get_help" class="bs-docs-example form-control" style="height: 480px;">
                    <div class="modal-body">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="2" style="text-align:left;">
                            <div class="input-group" style="padding-bottom:5px;">
                              <span class="input-group-addon" id="sizing-addon1">现有人民币</span>
                              <input type="text" name="rmb" value="<? echo number_format(ggRefer(0),2); ?>" class="form-control" placeholder="人民币" aria-describedby="sizing-addon1" readonly />
                            </div>
                            <div class="input-group" style="padding-bottom:5px;">
                              <span class="input-group-addon" id="sizing-addon1">可提人民币</span>
                              <input type="text" name="rmb-sell" value="<? echo number_format(ggRefer(1),2); ?>" class="form-control" placeholder="可出售人民币" aria-describedby="sizing-addon1" readonly />
			   			      <input type="hidden" name="balance_difference" value="0">
				 </div>
                            <!--div class="input-group" style="padding-bottom:5px;">
                              <span class="input-group-addon" id="sizing-addon1">最低出售量</span>
                              <input type="text" name="min-sell" class="form-control" placeholder="最低出售量" aria-describedby="sizing-addon1">
                            </div>
                            <div class="input-group" style="padding-bottom:5px;">
                              <span class="input-group-addon" id="sizing-addon1">剩余出售限额</span>
                              <input type="text" name="rmb-remain" class="form-control" placeholder="剩余出售限额" aria-describedby="sizing-addon1">
                            </div-->
                          </td>
                       </tr>
                       <tr>
                         <td colspan="2" style="text-align:left;">&nbsp;</td>
                       </tr>
                        <tr>
                          <td colspan="2" style="font-weight:bold;">提领金额</td>
                       </tr>
                        <tr>
                          <td colspan="2" align="center">
                            <div class="form-group">
                                <input name="sell_amountr" type="text" class="form-control" id="sell_amountr" placeholder="人民币" required /><!--br/><span id="currency2"></span-->
                            </div>
                          </td>
                        </tr>
                       <tr>
                         <td colspan="2"><strong>备注</strong><!--span id="PHLimitBalance" style="font-size: 12px;"></span--></td>
                       </tr>
                       <tr>
                         <td colspan="2">
                            <textarea name="remarks" class="form-control" style="resize:none;" cols="30" rows="5" placeholder="给对方的留言，例如联络时间，联络方法等等。。。"></textarea>
                         </td>
                       </tr>
                        <tr>
                          <td style="text-align:left; vertical-align:top; padding-right:5px;"><input name="checkbox" type="checkbox" id="checkbox" value="true" checked="checked" /></td>
                          <td style="text-align:left; font-size:12px;">警告，我已完全了解所有风险。我决定参与洲际 3M, 尊重洲际 3M 文化与传统。</td>
                          </tr>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

                        <button type="button" class="btn btn-warning" id="submit" onclick="GHAction('r')">接受帮助</button>
                      </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal -->
