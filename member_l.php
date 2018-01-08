<?
error_reporting(E_ALL);
include ('_dbconfig.php');
include ('_ggFunctions.php');


	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	} else {
		$user = load_user(0);
		$id = $user->id;
	}

	$ls->statusA = array("Active","活跃","活跃");
	$ls->statusB = array("Block","封号","封号");
	$ls->rankMgr = array("Manager","註冊经理","註冊经理");
	$ls->rankMem = array("Member","普通会员","普通会员");

	$ls->nofullname = array("Name Not Set","尚未设定","尚未設定");

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'username';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';	$offset = ($page-1)*$rows;

	$result = array();
	$items = array();

	// Add Manager Group
	if ($user->rank==1) {
		// Normal Member
		$rs = $db->query("select id, email, fullname, phone,referral,ref_name,manager,mgr_name,rank,username,date_add,last_ph,directs,status  from tblmember where referral=$id order by $sort $order limit $offset,$rows");
		$ctr = mysqli_fetch_array($db->query("select count(*) from tblmember where referral=$id"));
	} else if ($user->rank>=5) {
		// Manager
		$rs = $db->query("select id, email, fullname, phone,referral,ref_name,manager,mgr_name,rank,username,date_add,last_ph,directs,status  from tblmember where manager=$id order by $sort $order limit $offset,$rows");
		$ctr = mysqli_fetch_array($db->query("select count(*) from tblmember where manager=$id"));
	}

	// Add to counter
	$result["total"] = ($ctr[0]);

	// Add to final result
	while($row = mysqli_fetch_object($rs)){
		$row->rank = ggRank($row->rank,1);
		if ($row->status=="A") {
			$row->status = $ls->statusA[$lang];
		} else if ($row->status == "B") {
			$row->status = $ls->statusB[$lang];
		}
		$row->date_add = substr($row->date_add,0,10);

		$directs = mysqli_fetch_object($db->query("select count(id) as ctr from tblmember where referral=$row->id"));
		$row->directs = $directs->ctr;

		if ($row->fullname == "") {
			$row->fullname = $ls->nofullname[$lang];
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

		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>