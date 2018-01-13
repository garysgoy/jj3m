<!-- 提供帮助 Modal -->
    <div class="modal fade" id="provideHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:300px">
            <div class="modal-content">
                <div class="modal-header btn-success">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><? echo $ls->titleph[$lang]; ?></h4>
                </div>
                <div class="modal-body">
                  <form action="" method="post" id="provideHelpForm" name="provideHelpForm" class="form-control" style="height: 275px;">
                    <input type="hidden" id="act" name="act" value="PH">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                         <td colspan="2" style="text-align:left;"><? echo $ls->ph_desc[$lang]; ?></td>
                         </tr>
                       <tr>
                         <td colspan="2" style="text-align:left;">&nbsp;</td>
                       </tr>
                       <tr>
                         <td colspan="2"><strong><? echo $ls->ph_amount[$lang]; ?></strong><br/><!--span id="PHLimitBalance" style="font-size: 12px;"></span--></td>
                       </tr>
                       <tr>
                         <td colspan="2" style="text-align:center;">
                          <div class="form-group">
                            <select id="HelpAmount" name="HelpAmount" class="form-control">
                              <? echo ggPhAmounts(); ?>
                            </select>
                          </div>
                         </td>
                       </tr>
<?
$use_comment = false;
if ($use_comment) { ?>
                       <tr>
                         <td colspan="2"><strong><? echo $ls->ph_comment[$lang]; ?></strong><!--span id="PHLimitBalance" style="font-size: 12px;"></span--></td>
                       </tr>
                       <tr>
                         <td colspan="2">
                            <textarea name="remarks" id="remarks" class="form-control" style="resize:none;" rows="4" placeholder="<? echo $ls->ph_commentp[$lang]; ?>"></textarea>
                         </td>
                       </tr>
                       <tr>
                         <td style="text-align:left;">&nbsp;</td>
                         <td style="text-align:left;">&nbsp;</td>
                       </tr>
<? } ?>
                       <tr>
                         <td style="text-align:left; vertical-align:top; padding-right:5px;"><input name="check-list" type="checkbox" id="checkbox4" value="true" checked="checked" required /></td>
                         <td style="text-align:left; font-size:12px;"><? echo $ls->ph_warning[$lang]; ?></td>
                       </tr>
                       <tr><td colspan="2">&nbsp;</td></tr>
                     </table>
                    <div style="clear:both;"></div>
                    <div class="modal-footer">
                      <a href="#" onclick="doPH()" class="btn btn-success" onclick="doPH()"><? echo $ls->titleph[$lang]; ?></a>
                      <a href="#" onclick="doClose()" class="btn btn-default" data-dismiss="modal"><? echo $ls->close[$lang]; ?></a>
                    </div>
                  </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal -->
