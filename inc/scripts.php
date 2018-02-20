<!--================================================== -->
<!-- IMPORTANT: APP CONFIG -->
<script src="<?php echo ASSETS_URL; ?>/js/app.config.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="<?php echo ASSETS_URL; ?>/js/bootstrap337.min.js"></script>

<!-- JQUERY VALIDATE -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-validate/jquery.validate.min.js"></script>

<!-- browser msie issue fix -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

<!-- Easyui: For data grids -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-easyui/jquery.easyui.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jquery-easyui/jquery.easyui.mobile.js"></script>

<!--[if IE 8]>
<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
<![endif]-->

<? if($server==0) { ?>
	<!-- Demo purpose only -->
	<script src="<?php echo ASSETS_URL; ?>/js/demo.min.js"></script>
<? } ?>
<!-- MAIN APP JS FILE -->
<script src="<?php echo ASSETS_URL; ?>/js/app.min.js"></script>


<script type="text/javascript">
// DO NOT REMOVE : GLOBAL FUNCTIONS!
$(document).ready(function() {
	pageSetUp();
})
</script>