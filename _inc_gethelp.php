    <!-- 接受帮助 Modal -->
    <div class="modal fade" id="requestHelpD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
                <div class="modal-header btn-warning">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><? echo $ls->titlegh[$lang]; ?></h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="getHelpForm" name="get_help" class="bs-docs-example form-control" style="height: 310px;">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="2" style="text-align:left;">
                            <div class="input-group" style="padding-bottom:5px;">
                              <span class="input-group-addon" id="sizing-addon1"><? echo $ls->gh_balance[$lang]; ?></span>
                              <input type="text" name="rmb" value="<? echo number_format(ggMavro(0),2); ?>" class="form-control" placeholder="人民币" aria-describedby="sizing-addon1" readonly />
                            </div>
                            <div class="input-group" style="padding-bottom:5px;">
                              <span class="input-group-addon" id="sizing-addon1"><? echo $ls->gh_available[$lang]; ?></span>
                              <input type="text" name="rmb-sell" value="<? echo number_format(ggMavro(1),2); ?>" class="form-control" placeholder="可出售人民币" aria-describedby="sizing-addon1" readonly />
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
                          <td colspan="2" style="font-weight:bold;"><? echo $ls->gh_amount[$lang]; ?></td>
                       </tr>
                        <tr>
                          <td colspan="2" align="center">
                            <div class="form-group">
                                <input name="sell_amountd" type="text" class="form-control" id="sell_amountd" placeholder="<? echo $ls->gh_amountp[$lang]; ?>" required /><!--br/><span id="currency2"></span-->
                            </div>
                          </td>
                        </tr>
<?
$use_comment = false;
if ($use_comment) { ?>
                       <tr>
                         <td colspan="2"><strong><? echo $ls->gh_comment[$lang]; ?></strong><!--span id="PHLimitBalance" style="font-size: 12px;"></span--></td>
                       </tr>
                       <tr>
                         <td colspan="2">
                            <textarea name="remarks" class="form-control" style="resize:none;" cols="30" rows="4" placeholder="<? echo $ls->ph_commentp[$lang]; ?>"></textarea>
                         </td>
                       </tr>
                          <tr><td colspan="2">&nbsp;</td>
                        </tr>
<? } ?>
                        <tr>
                          <td style="text-align:left; vertical-align:top; padding-right:5px;"><input name="checkbox" type="checkbox" id="checkbox" value="true" checked="checked" /></td>
                          <td style="text-align:left; font-size:12px;"><? echo $ls->ph_warning[$lang]; ?></td>
                          </tr>
                          <tr><td colspan="2">&nbsp;</td></tr>
                        </table>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><? echo $ls->close[$lang]; ?></button>

                        <button type="button" class="btn btn-warning" id="submit" onclick="GHAction('d')"><? echo $ls->titlegh[$lang]; ?></button>
                      </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal -->
