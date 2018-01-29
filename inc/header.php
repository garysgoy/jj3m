<?
$hs = new stdClass();
$hs->flag = array("us","cn","tw");
$hs->lang = array("English","简体中文","繁體中文");
?>
<!DOCTYPE html>
<html lang="en-us" <?php echo implode(' ', array_map(function($prop, $value) {
			return $prop.'="'.$value.'"';
		}, array_keys($page_html_prop), $page_html_prop)) ;?>>
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> <?php echo $page_title != "" ? $page_title." - " : ""; ?>3M System </title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.css">

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/your_style.css"> -->
<?
$use_easyui=true;
if ($use_easyui) {
?>

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/js/plugin/jquery-easyui/themes/bootstrap/easyui.css">
	  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/js/plugin/jquery-easyui/themes/icon.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/3m/toastr.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/my-style.css">
<? } ?>
<?
			if ($page_css) {
				foreach ($page_css as $css) {
					//echo '<link rel="stylesheet" type="text/css" media="screen" href="'.ASSETS_URL.'/css/'.$css.'">';
				}
			}
?>

<?
// Only show demo selection on local
if ($server==0) {
?>
		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/demo.min.css">
<? } ?>
		<!-- FAVICONS -->
		<link rel="shortcut icon" href="<?php echo ASSETS_URL; ?>/img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo ASSETS_URL; ?>/img/favicon.ico" type="image/x-icon">

		<!-- GG Disabled - GOOGLE FONT
		   <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
		-->
		<!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad-retina.png">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

		<!-- GG Use Local instead. - Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	  <script src="<? echo ASSETS_URL; ?>/js/libs/jquery211.js"></script>
	  <!-- <script src="<? echo ASSETS_URL; ?>/js/libs/jquery-3.2.1.min.js"></script> -->
<?
if ($use_easyui) {
?>
		<script src="<? echo ASSETS_URL; ?>/js/libs/jquery-ui.min.js"></script>
		<script src="<? echo ASSETS_URL; ?>/js/plugin/jquery-form/jquery-form.min.js"></script>
<? } ?>
	</head>
	<body <?php echo implode(' ', array_map(function($prop, $value) {
			return $prop.'="'.$value.'"';
		}, array_keys($page_body_prop), $page_body_prop)) ;?>>

		<!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
			 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
		<?php
			if (!$no_main_header) {
		?>
				<!-- HEADER -->
				<header id="header">
					<div id="logo-group">

						<!-- PLACE YOUR LOGO HERE -->
						<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>
						<!-- END LOGO PLACEHOLDER -->

<?
$show_activity= false;
if ($show_activity) {
?>
						<!-- Note: The activity badge color changes when clicked and resets the number to 0
						Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
						<span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>

						<!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
						<div class="ajax-dropdown">

							<!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
							<div class="btn-group btn-group-justified" data-toggle="buttons">
								<label class="btn btn-default">
									<input type="radio" name="activity" id="<?php echo APP_URL; ?>/ajax/notify/mail.php">
									Msgs (14) </label>
								<label class="btn btn-default">
									<input type="radio" name="activity" id="<?php echo APP_URL; ?>/ajax/notify/notifications.php">
									notify (3) </label>
								<label class="btn btn-default">
									<input type="radio" name="activity" id="<?php echo APP_URL; ?>/ajax/notify/tasks.php">
									Tasks (4) </label>
							</div>

							<!-- notification content -->
							<div class="ajax-notifications custom-scroll">

								<div class="alert alert-transparent">
									<h4>Click a button to show messages here</h4>
									This blank page message helps protect your privacy, or you can show the first message here automatically.
								</div>

								<i class="fa fa-lock fa-4x fa-border"></i>

							</div>
							<!-- end notification content -->

							<!-- footer: refresh area -->
							<span> Last updated on: 12/12/2013 9:43AM
								<button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
									<i class="fa fa-refresh"></i>
								</button> </span>
							<!-- end footer -->

						</div>
						<!-- END AJAX-DROPDOWN -->
<? } ?>
					</div>

<?
$show_projects = false;
if ($show_projects) {
?>

					<!-- projects dropdown -->
					<div class="project-context hidden-xs">

						<span class="label">Projects:</span>
						<span id="project-selector" class="popover-trigger-element dropdown-toggle" data-toggle="dropdown">Recent projects <i class="fa fa-angle-down"></i></span>

						<!-- Suggestion: populate this list with fetch and push technique -->
						<ul class="dropdown-menu">
							<li>
								<a href="javascript:void(0);">Online e-merchant management system - attaching integration with the iOS</a>
							</li>
							<li>
								<a href="javascript:void(0);">Notes on pipeline upgradee</a>
							</li>
							<li>
								<a href="javascript:void(0);">Assesment Report for merchant account</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);"><i class="fa fa-power-off"></i> Clear</a>
							</li>
						</ul>
						<!-- end dropdown-menu-->

					</div>
					<!-- end projects dropdown -->
<? } ?>
					<!-- pulled right: nav area -->
					<div class="pull-right">

						<!-- collapse menu button -->
						<div id="hide-menu" class="btn-header pull-right">
							<span> <a href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
						</div>
						<!-- end collapse menu -->

						<!-- #MOBILE -->
						<!-- Top menu profile link : this shows only when top menu is active -->
						<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
							<li class="">
								<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
									<img src="<?php echo ASSETS_URL; ?>/img/avatars/1.png" alt="<? echo $user->fullname; ?>" class="online" />
								</a>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="profile.php" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="login.php" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
									</li>
								</ul>
							</li>
						</ul>

						<!-- logout button -->
						<div id="logout" class="btn-header transparent pull-right">
							<span> <a href="<?php echo APP_URL; ?>/login.php" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
						</div>
						<!-- end logout button -->

<?
$show_search = false;
if ($show_search) {
?>
						<!-- search mobile button (this is hidden till mobile view port) -->
						<div id="search-mobile" class="btn-header transparent pull-right">
							<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
						</div>
						<!-- end search mobile button -->

						<!-- input: search field -->
						<form action="<?php echo APP_URL; ?>/search.php" class="header-search pull-right">
							<input type="text" name="param" placeholder="Find reports and more" id="search-fld">
							<button type="submit">
								<i class="fa fa-search"></i>
							</button>
							<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
						</form>
						<!-- end input: search field -->
<? } ?>

<?
$show_fullscreen=false;
if ($show_fullscreen) {
?>
						<!-- fullscreen button -->
						<div id="fullscreen" class="btn-header transparent pull-right">
							<span> <a href="javascript:void(0);" title="Full Screen" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i></a> </span>
						</div>
						<!-- end fullscreen button -->
<? } ?>

<?
$show_speech = false;
if ($show_speech) {
?>
						<!-- #Voice Command: Start Speech -->
						<div id="speech-btn" class="btn-header transparent pull-right hidden-sm hidden-xs">
							<div>
								<a href="javascript:void(0)" title="Voice Command" data-action="voiceCommand"><i class="fa fa-microphone"></i></a>
								<div class="popover bottom"><div class="arrow"></div>
									<div class="popover-content">
										<h4 class="vc-title">Voice command activated <br><small>Please speak clearly into the mic</small></h4>
										<h4 class="vc-title-error text-center">
											<i class="fa fa-microphone-slash"></i> Voice command failed
											<br><small class="txt-color-red">Must <strong>"Allow"</strong> Microphone</small>
											<br><small class="txt-color-red">Must have <strong>Internet Connection</strong></small>
										</h4>
										<a href="javascript:void(0);" class="btn btn-success" onclick="commands.help()">See Commands</a>
										<a href="javascript:void(0);" class="btn bg-color-purple txt-color-white" onclick="$('#speech-btn .popover').fadeOut(50);">Close Popup</a>
									</div>
								</div>
							</div>
						</div>
						<!-- end voice command -->
<? } ?>
<?
if ($setup->lang<90 || $server==0 || $app_code=="jj") {
// This app use 90 meaning only english
?>

						<!-- multiple lang dropdown : find all flags in the flags page -->
						<ul class="header-dropdown-list hidden-xs">
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-<? echo $hs->flag[$lang];?>" alt="China"> <span> <?echo $hs->lang[$lang];?> </span> <i class="fa fa-angle-down"></i> </a>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="javascript:changeLang(0);"><img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-us" alt="United States"> <? echo $hs->lang[0];?></a>
									</li>
									<li>
										<a href="javascript:changeLang(1);"><img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-cn" alt="China"> <? echo $hs->lang[1];?></a>
									</li>
									<li>
										<a href="javascript:changeLang(2);"><img src="<?php echo ASSETS_URL; ?>/img/blank.gif" class="flag flag-tw" alt="China"> <? echo $hs->lang[2];?></a>
									</li>
								</ul>
							</li>
						</ul>
						<!-- end multiple lang -->
<? } ?>
					</div>
					<!-- end pulled right: nav area -->
		<script>
			function changeLang(code) {
				document.cookie =  "lang=" + code;
				document.location="index.php";
			}
		</script>
				</header>
				<!-- END HEADER -->

<?
$show_shortcut=false;
if ($show_shortcut) {
?>

				<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
				Note: These tiles are completely responsive,
				you can add as many as you like
				-->
				<div id="shortcut">
					<ul>
						<li>
							<a href="<?php echo APP_URL; ?>/inbox.php" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/calendar.php" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/gmap-xml.php" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/invoice.php" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/gallery.php" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/profile.php" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
						</li>
					</ul>
				</div>
				<!-- END SHORTCUT AREA -->
<? } ?>
<? } ?>