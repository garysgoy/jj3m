<?
function sms_match($ph_id) {
	$help = ggFetchObject("select * from tblhelp where id=$ph_id");
	$mem = load_user($help->mem_id);
	$mobile = $mem->phone;
	if ($help->g_type=='P') {
		$content = "$mem->username 你的提供帮助订单 " .ggHID($help->id). " 已匹配，请在36小时内付款。";
	} else {
		$content = "$mem->username 恭喜你！您的接受帮助订单 " .ggHID($help->id). " 已匹配，请留意确认。";		
	}
	if (substr($mobile,0,1)=='1') {
		$res = sendSMS($mobile,$content);
	} else {
		$res = '<b>Invalid Number '.$mobile.'</b>';
	}
	return "Mobile: $mobile Help id: $ph_id Res: $res<br>";
}

function sms_ph36h($ph_id) {
	$help = ggFetchObject("select * from tblhelp where id=$ph_id and g_type='P'");
	$mem = load_user($help->mem_id);
	$mobile = $mem->phone;
	$content = "$mem->username 你的提供帮助订单 " .ggHID($help->id). " 时间重设为36小时，让家人能获得诚信奖励。";
	if (substr($mobile,0,1)=='1') {
		$res = sendSMS($mobile,$content);
	} else {
		$res = '<b>Invalid Number '.$mobile.'</b>';
	}
	return "Mobile: $mobile Help id: $ph_id Res: $res<br>";
}

function sms_gh($tran_id) {
	$help = ggFetchObject("select * from tblhelpdetail where tran_id=$tran_id and g_type='G'");
	$mem = load_user($help->mem_id);
	$oth = load_user($help->oth_id);
	$mobile = $mem->phone;
	$content = "$mem->username 您的订单 " .ggHID($help->help_id). " 已经收到 $oth->username ￥".number_format($help->g_amount,0)." 的帮助, 请尽快确认。";
	$res = sendSMS($mobile,$content);
	return "Mobile: $mobile Help id: $help->help_id Res: $res<br>";
}

function sms_confirm($tran_id) {
	//$mobile = '13510628616,13902313664'; //Peter
	$help = ggFetchObject("select * from tblhelpdetail where tran_id=$tran_id and g_type='P'");
	$mem = load_user($help->mem_id);
	$oth = load_user($help->oth_id);
	$mobile = $mem->phone;
	$content = "$mem->username 您给予 $oth->username 的帮助, 已经确认收到了。";
	$res = sendSMS($mobile,$content);
	return "Mobile: $mobile Help id: $help->help_id Res: $res<br>";
}

function sendSMS1($mobile,$content) {
// No action
}

function sendSMS($mobile,$content) {
	$http = 'http://api.sms.cn/mtutf8/'; //短信接口
	$uid = 'jj3m'; //用户账号
	$pwd = '78081315'; //密码
	$time = '';
	$mid = '';
	$mobileids = 'jj3m12345678'; //号码唯一编号
	$data = array
	(
		'uid'=>$uid, //用户账号
		'pwd'=>md5($pwd.$uid), //MD5位32密码,密码和用户名拼接字符
		'mobile'=>$mobile, //号码
		'content'=>$content, //内容
		'mobileids'=>$mobileids,
		'time'=>$time //定时发送
	);
	$re= postSMS($http,$data); //POST方式提交
	return $re;
}

function postSMS($url,$data='') {
	$port="";
	$post="";
	$row = parse_url($url);
	$host = $row['host'];
	$port = $row['port'] ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) {
		$post .= rawurlencode($k)."=".rawurlencode($v)."&"; //转URL标准码
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	if (!$fp) {
		return "$errstr ($errno)\n";
	} else {
		$receive = '';
		$out = "POST $file HTTP/1.1\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Content-Length: $len\r\n\r\n";
		$out .= $post;
		fwrite($fp, $out);
		while (!feof($fp)) {
			$receive .= fgets($fp, 128);
		}
		fclose($fp);
		$receive = explode("\r\n\r\n",$receive);
		unset($receive[0]);
		return implode("",$receive);
	}
}
?>