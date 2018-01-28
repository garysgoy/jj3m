<?
error_reporting(E_ALL);
include ('inc/ggDbconfig.php');
include ('inc/ggFunctions.php');

$debug=false;
$req = ($debug)? $_GET:$_POST;

	$rank_c = array("Member","Manager","Senior Manager","Country Manager");

	if (isset($req['id'])) {
		$id = $req['id'];
	} else {
		$id = $user->id;
	}

	$ls = new stdClass();
	$ls->statusA = array("Active","正常","正常");
	$ls->statusB = array("Block","封号","封号");
	$ls->statusW = array("Inactivate","待激活","待激活");
	$ls->rankMgr = array("Manager","註冊经理","註冊经理");
	$ls->rankMem = array("Member","普通会员","普通会员");
	$ls->nofullname = array("Name Not Set","尚未设定","尚未設定");
	$ls->activate = array("Activate","激活","激活");
	$ls->delete = array("Delete","删除","刪除");
	$ls->none = array("None","暂无","暫無");

	$page = isset($req['page']) ? intval($req['page']) : 1;
	$rows = isset($req['rows']) ? intval($req['rows']) : 10;
	$sort = isset($req['sort']) ? strval($req['sort']) : 'date_add';
	$order = isset($req['order']) ? strval($req['order']) : 'desc';
	$offset = ($page-1)*$rows;

	$result = array();
	$items = array();

		// Normal Member
	$rs = $db->query("select id, email, pin, fullname,phone,referral,rank,username,date_add,last_ph,directs,status from tblmember where referral=$id order by $sort $order limit $offset,$rows");
	$ctr = mysqli_fetch_array($db->query("select count(*) from tblmember where referral=$id"));

	// Add to counter
	$result["total"] = ($ctr[0]);

	// Add to final result
	while($row = mysqli_fetch_object($rs)){
		//if ($row->rank >= 3) $row->rank = $rank_c[3];
		//else $row->rank = $rank_c[$row->rank];

		if ($row->status=="A") {
			$row->status = $ls->statusA[$lang];
		} else if ($row->status == "B") {
			$row->status = $ls->statusB[$lang];
		}

    if ($row->pin =="") {
      $row->status = "<b style='color:red'>".$ls->statusW[$lang]."</b>";
      $row->action = '<a class="btn btn-success btn-xs" id="btn_alive" onclick="doActivate('.$row->id.')">'.$ls->activate[$lang].'</a>&nbsp;
                <a class="btn btn-danger btn-xs" id="btn_del" onclick="doDelete('.$row->id.')">'.$ls->delete[$lang].'</a>&nbsp;';
    } else {
      $row->status = "<b style='color:green'>".$ls->statusA[$lang]."</b>";
      $row->action = $ls->none[$lang];
    }

		$ph = $db->query("select * from tblhelp where mem_id = $row->id and g_type='P' and status='O' order by id limit 0,1");
		$phc = mysqli_num_rows($db->query("select * from tblhelp where mem_id = $row->id and g_type='P' and status='O'"));
		$row->ph = "";
		while ($ph1 = mysqli_fetch_object($ph)) {
			$row->ph = $ph1->g_amount. ' ' .$ph1->g_date;
			if ($phc>1) {
				$row->ph .= ' - <b class=blue>'.$phc. ' PH</b>';
			}
		}
		$row->rank = ggRank($row->rank,1);
		if ($row->fullname == "") {
			$row->fullname = $ls->nofullname[$lang];
		}
		//$row->date_add = substr($row->date_add,0,10);
		array_push($items, $row);
	}	$result["rows"] = $items;

	echo json_encode($result);

?>