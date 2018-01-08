<?php

//CONFIGURATION for SmartAdmin UI

//ribbon breadcrumbs config
//array("Display Name" => "URL");

$lang = 0;
$mls = new stdClass();

$mls->home = array("Dashboard","首页","首頁");
$mls->dashboard = array("Dashboard","首页","首頁");
$mls->pin = array("PIN Management","激活码"," 激活碼");
$mls->register= array("Register New Member","注册新用户","註冊新用戶");
$mls->announcement = array("Announcement","新闻公告","新聞公告");
$mls->network = array("Network","团队管理","團隊管理");
$mls->referrals = array("Direct Referrals","直属推荐人","直屬推薦人");
$mls->members = array("Participants","我管理的参与者","我管理的參與者");
$mls->groups = array("My User Group","我的用户群","我的用戶群");
$mls->account = array("My Account","个人资料","個人資料");
$mls->profile = array("Update Profile","更改个人资料","更改個人資料");
$mls->password = array("Change Password","更改密码","更改密碼");
$mls->wallet = array("My Wallet","我的钱包","我的錢包");
$mls->support = array("Support Ticket","我的反馈","我的反饋");
$mls->logout = array("Logout","安全退出","安全退出");

$breadcrumbs = array(
	$mls->home[$lang] => APP_URL."/dashboard.php"
);


$page_nav = array(
	"dashboard" => array(
		"title" => $mls->dashboard[$lang],
		"icon" => "fa-home",
		"url" => APP_URL."/admin/dashboard.php"
	),
	"pin" => array(
		"title" => $mls->pin[$lang],
		"icon" => "fa-cogs",
		"url" => APP_URL . '/admin/pin.php'
	));

//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array("class" => "smart-style-2"); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>