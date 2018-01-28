<?php

//CONFIGURATION for SmartAdmin UI

$mls = new stdClass();

$mls->home = array("Dashboard","首页","首頁");
$mls->dashboard = array("Dashboard","首页","首頁");
$mls->pin = array("PIN Management","激活码"," 激活碼");
$mls->mem_mgt= array("Member Management","会员管理","會員管理");
$mls->reflink= array("Refer Link","推荐链接","推薦連結");
$mls->register= array("Member Registration","注册新会员","註冊新會員");
$mls->activate= array("Activate Member","激活新会员","激活新會員");
$mls->announcement = array("Announcement","新闻公告","新聞公告");
$mls->network = array("Network","团队管理","團隊管理");
$mls->referrals = array("Direct Referrals","直属推荐人","直屬推薦人");
$mls->members = array("Participants","我管理的参与者","我管理的參與者");
$mls->groups = array("My Group Help Info","我的用戶帮助情况","我的用戶幫助情況");
$mls->account = array("My Account","个人资料","個人資料");
$mls->profile = array("Update Profile","更改个人资料","更改個人資料");
$mls->password = array("Change Password","更改密码","更改密碼");
$mls->wallet = array("My Wallet","我的钱包","我的錢包");
$mls->support = array("Support Ticket","我的反馈","我的反饋");
$mls->logout = array("Logout","安全退出","安全退出");

$mls->pin_mgt = array("Sell PIN","出售激活码","出售激活碼");
$mls->pin0 = array("Sell Register PIN","出售注册码","出售註冊碼");
$mls->pin1 = array("Sell Activate PIN","出售激活码","出售激活碼");
$mls->pin2 = array("Sell Que PIN","出售排单币","出售排單幣");
$mls->sellpin = array("Sell PIN","出售激活码","出售激活碼");

$mls->addgh = array("Add GH","新增接受帮助","新增接受幫助");
$mls->memberlist = array("Member List","会员列表","會員列表");
$mls->matching = array("Matching","帮助匹配","幫助匹配");
$mls->checkph = array("Pending PH","PH 清单","PH 清单");
$mls->upgrade = array("Upgrade Manager","升级为经理","升級為經歷");

$news_count = 0;// ggFetchValue("select count(id) from tblnews");
// ribbon breadcrumbs config
// array("Display Name" => "URL");
$breadcrumbs = array(
	$mls->home[$lang] => APP_URL."/dashboard.php"
);

$page_nav["dashboard"] = array(
		"title" => $mls->dashboard[$lang],
		"icon" => "fa-home",
		"url" => APP_URL."/dashboard.php"
);

// Rank >= 5 mean only manager
if ($user->rank>=1) {
	$page_nav["pin"] = array(
		"title" => $mls->pin[$lang],
		"icon" => "fa-exchange",
		"url" => APP_URL . '/pin.php'
	);

	$page_nav["mem_mgt"] = array(
		"title" => $mls->mem_mgt[$lang],
		"icon" => "fa-user",
		"sub" => array(
			"reflink" => array(
				"title" => $mls->reflink[$lang],
				"url" => APP_URL."/reflink.php"
			),
			"register" => array(
				"title" => $mls->register[$lang],
				"url" => APP_URL."/register.php"
			),
			"activate" => array(
				"title" => $mls->activate[$lang],
				"url" => APP_URL."/activate.php"
			)
		)
	);

}

$page_nav["network"] = array(
	"title" => $mls->network[$lang],
	"icon" => "fa-sitemap",
	"sub" => array(
		"referrals" => array(
			"title" => $mls->referrals[$lang],
			"url" => APP_URL."/referrals.php"
		),
		"members" => array(
			"title" => $mls->members[$lang],
			"url" => APP_URL."/members.php"
		),
		"groups" => array(
			"title" => $mls->groups[$lang],
			"url" => APP_URL."/group.php"
		)
	)
);

$page_nav["account"] = array(
	"title" => $mls->account[$lang],
	"icon" => "fa-folder",
	"sub" => array(
		"profile" => array(
			"title" => $mls->profile[$lang],
			"url" => APP_URL."/profile.php"
		),
		"password" => array(
			"title" => $mls->password[$lang],
			"url" => APP_URL."/password.php"
		)
	)
);

$page_nav["wallet"] = array(
	"title" => $mls->wallet[$lang],
	"icon" => "fa-money",
	"url" => APP_URL."/wallet.php"
);

if ($news_count > 0) {
	$page_nav["announcement"] = array(
		"title" => $mls->announcement[$lang],
		"icon" => "fa-comment",
		"url" => APP_URL . '/announcement.php',
		"label_htm" => '<span class="badge pull-right inbox-badge margin-right-13">$news_count</span>'
	);
} else {
	$page_nav["announcement"] = array(
		"title" => $mls->announcement[$lang],
		"icon" => "fa-comment",
		"url" => APP_URL . '/announcement.php'
	);
}

$page_nav["support"] = array(
	"title" => $mls->support[$lang],
	"icon" => "fa-comments",
	"url" => APP_URL."/contact.php"
);

$page_nav["logout"] = array(
	"title" => $mls->logout[$lang],
	"icon" => "fa-sign-out",
	"url" => APP_URL."/logout.php"
);


if ($user->rank>=8) {
	$breadcrumbs = array(
	$mls->home[$lang] => APP_URL."/_a_dashboard.php"
);

	$page_nav = array(
		"dashboard" => array(
			"title" => $mls->dashboard[$lang],
			"icon" => "fa-home",
			"url" => APP_URL."/_a_dashboard.php"
		),
		"matching" => array(
			"title" => $mls->matching[$lang],
			"icon" => "fa-cogs",
			"url" => APP_URL . '/_a_matching.php'
		),
		"pin_mgt" => array(
			"title" => $mls->pin_mgt[$lang],
			"icon" => "fa-sitemap",
			"sub" => array(
				"pin0" => array(
					"title" => $mls->pin0[$lang],
					"url" => APP_URL."/_a_sellpin.php"
				),
				"pin1" => array(
					"title" => $mls->pin1[$lang],
					"url" => APP_URL."/_a_sellpin1.php"
				),
				"pin2" => array(
					"title" => $mls->pin2[$lang],

					"url" => APP_URL."/_a_sellpin2.php"
				)
			)
		),
		"addgh" => array(
			"title" => $mls->addgh[$lang],
			"icon" => "fa-plus",
			"url" => APP_URL . '/_a_addgh.php'
		),
		"checkph" => array(
			"title" => $mls->checkph[$lang],
			"icon" => "fa-user",
			"url" => APP_URL . '/_a_checkph.php'
		),
		"memberlist" => array(
			"title" => $mls->memberlist[$lang],
			"icon" => "fa-user",
			"url" => APP_URL . '/_a_member.php'
		),
		"upgrade" => array(
			"title" => $mls->upgrade[$lang],
			"icon" => "fa-user",
			"url" => APP_URL . '/_a_upgrade.php'
		),
		"logout" => array(
		"title" => $mls->logout[$lang],
		"icon" => "fa-lock",
		"url" => APP_URL."/logout.php"
		)
	);
}
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
if ($user->rank >= 8) {
	$page_body_prop = array("class" => "smart-style-7"); //optional properties for <body>
} else {
	if ($app_code=="jj") {
		$page_body_prop = array("class" => "smart-style-3"); //optional properties for <body>
	} else {
		$page_body_prop = array("class" => "smart-style-7"); //optional properties for <body>
	}
}
$page_html_prop = array(); //optional properties for <html>
?>