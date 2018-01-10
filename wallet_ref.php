<?
	include 'inc/ggDbconfig.php';
	include 'inc/ggFunctions.php';

	$user = load_user(0);
	$setup = load_setup();

	$lang=1;
	$ls = new stdClass();
	$ls->statusA = array("Active","活跃","活跃");
	$ls->statusB = array("Block","封号","封号");
	$ls->rankMgr = array("Manager","註冊经理","註冊经理");
	$ls->rankMem = array("Member","普通会员","普通会员");

	$ls->wallet1 = array("Mavro Deposit","提供幫助","提供幫助");
	$ls->wallet2 = array("Referral Bonus","推薦花紅","推薦花紅");
	$ls->wallet3 = array("Manager Bonus","經理花紅","經理花紅");
	$ls->wallet4 = array("Withdrawal","接受幫助","接受幫助");
	$ls->wallet5 = array("Level Bonus","代數花紅","代數花紅");
	$ls->wallet6 = array("Purchase PIN","购买激活码","購買激活碼");

	$ls->confirm1 = array("Unconfirm","未确认","未确认");
	$ls->confirm2 = array("Confirm","已确认","已确认");

	$ls->plan1 = array("Deposit @ 1% per day","提供幫助每天 1%","提供幫助每天1%");

	$ls->rebate = array("Pin Rebate","激活码回馈","激活碼回饋");
	$ls->selfrefer = array("Self Refer","自推薦","自推薦");

	$mem = isset($_REQUEST['mem']) ? intval($_REQUEST['mem']) : $user->id;

	$member = load_user($mem);

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';	$offset = ($page-1)*$rows;
	$offset = ($page-1)*$rows;
	$result = array();

	$rs = $db->query("select count(*) from tblmavro where mem_id=$mem and wallet=2 and type<>'X'");
	$ro = mysqli_fetch_row($rs);
	$result["total"] = $ro[0];
	$rs = $db->query("select * from tblmavro where mem_id=$mem and wallet=2 and type <> 'X' order by $sort $order limit $offset,$rows");


	$items = array();
	$date = new DateTime("NOW");
    $now = ggDateToString($date);
	while($row = mysqli_fetch_object($rs)){
		if ($row->type=="U") $color = "red";
		else if ($row->date_release <= $now) $color = "green";
		else $color = "blue";

		//$row->future = $now->format('Y-m-d H:i:s');
		$wallet = array($ls->wallet1[$lang],$ls->wallet2[$lang],$ls->wallet3[$lang],$ls->wallet4[$lang],$ls->wallet5[$lang],$ls->wallet6[$lang]);
		$row->type = ($row->type=="U") ? $ls->confirm1[$lang] : $ls->confirm2[$lang];
		$future_d = "Future";

		$row->id = ggRID($row->id);
		$row->help_id = ggHID($row->help_id);

        if ($row->wallet == 1 and $row->plan==1) {
            if ($row->date_close == '0000-00-00 00:00:00') {
                $date = new DateTime("NOW");
                $now = ggDateToString($date);
            } else {
                $now = $row->date_close;
            }
            $days = ggInterestDays($row->date_created,$now);
	    	if ($days > 30) $days = 30;
            $row->future_amount = $row->real_amount * (1 + 0.01 * $days + $row->incentive/100) + $row->bonus;
            $db->query("update tblmavro set future_amount=$row->future_amount where id=$row->id");
        }

		$row->future_amount = "<b style='color: $color'>".number_format($row->future_amount,2) . "</b> RMB";
		$row->nominal_amount= number_format($row->nominal_amount,2);
		$row->date_created = substr($row->date_created,0,10);
		$row->date_release = substr($row->date_release,0,10);
		if ($row->wallet == 1) {
			$row->wallet = $ls->plan1[$lang];
			if ($row->incentive <> 0) {
				$row->future = $row->incentive."%";
			}
		} else {
			if ($row->wallet == 6) {
				$row->wallet = $wallet[5];
				$row->help_id = $row->comment;
			} else if ($row->op_level<=1) {
				$row->wallet = $wallet[($row->wallet - 1)];
			} else {
				$row->wallet = $wallet[4] . ' '. ($row->op_level - 1);
			}
		}

		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>