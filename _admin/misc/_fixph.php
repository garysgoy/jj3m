<?
include("../inc/ggDbconfig.php");
include("../inc/ggFunctions.php");

// When confirm PH (Mainlty for Happy and also for WW)
// 1. Mavro confirm Immediate or Matuyrity of PH
// 2. Sponsor & Manager is immediate
// 3. Level is 30 days after expiry or 30 days from today


// Get all Completed Helps
// Update Mavros
//$rs = $db->query("select * from tblhelp where id =<> 2512");

$rs = $db->query("select * from tblhelp where id <> 2512");
while ($help = mysqli_fetch_object($rs)) {
	echo "<br>$app_domain $help->id <b>$help->status</b> $help->g_type $help->date_close<br>";
	$ss = closeph($help->id, $help->g_plan,$help->date_close,$help->status);
}

function closeph($help_id, $plan,$date_close,$status) {
	global $app_domain;
//	echo "<br>$help_id";
	$rs2 = $db->query("select * from tblmavro where help_id = $help_id order by id") or die("Mavro : ".$db->error);
	$op_level = 0;

	while ($row = mysqli_fetch_object($rs2)) {
		if ($status=="D") {
			if ($row->op_type == "M") {
				$op_level += 1;
			}
			echo "$app_domain 1 $op_level $row->op_type $row->date_created $row->date_release<br>";
			if ($app_domain=="mmmww.me") {
				if ($op_level==0) {
					$tt = $db->query("update tblmavro set `type`='C', date_release = '$date_close', op_level = $op_level where id = $row->id") or die("L0 ".$db->error);
				} else if ($op_level==1){
					$tt = $db->query("update tblmavro set `type`='C', date_release = '$date_close', op_level = $op_level where id = $row->id") or die("L1 ".$db->error);
				} else {
					$tt = $db->query("update tblmavro set `type`='C', date_release = DATE_ADD('$date_close', INTERVAL 30 DAY), op_level = $op_level where id = $row->id") or die("L2 ".$db->error);
				}
			} else {
				if ($op_level==0) {
					if ($row->op_type=='B') {
						$tt = $db->query("update tblmavro set `type`='C', date_release = DATE_ADD(date_created, INTERVAL $plan DAY), op_level = $op_level where id = $row->id") or die($db->error);
					} else {
						$tt = $db->query("update tblmavro set `type`='C', date_release = '$date_close', op_level = $op_level where id = $row->id") or die($db->error);
					}
				} else if ($op_level==1){
					$tt = $db->query("update tblmavro set `type`='C', date_release = '$date_close', op_level = $op_level where id = $row->id") or die($db->error);
				} else {
					$tt = $db->query("update tblmavro set `type`='C', date_release = DATE_ADD('$date_close', INTERVAL 30 DAY), op_level = $op_level where id = $row->id") or die($db->error);
				}
			}
		} else {
			if ($row->op_type == "M") {
				$op_level += 1;
			}
			echo "$app_domain 2 $op_level $row->op_type $row->date_created $row->date_release<br>";
			if ($app_domain=="mmmww.me") {
				if ($op_level==0) {
					if ($row->type =="U" and $row->op_type=="B") {
						$tt = $db->query("update tblmavro set date_release='0000-00-00 00:00:00', op_level = $op_level where id = $row->id") or die("L0 ".$db->error);
					} else if ($row->type =="C" and $row->op_type=="B") {
						$tt = $db->query("update tblmavro set date_release='$date_close', op_level = $op_level where id = $row->id") or die("L0 ".$db->error);
					} else {
						$tt = $db->query("update tblmavro set op_level = $op_level where id = $row->id") or die("L0 ".$db->error);
					}
				} else {
					$tt = $db->query("update tblmavro set date_release='0000-00-00 00:00:00', op_level = $op_level where id = $row->id") or die("L1 ".$db->error);
				}
			} else {
				if ($op_level==0) {
					if ($row->op_type=='B') {
						$tt = $db->query("update tblmavro set date_release = DATE_ADD(date_created, INTERVAL $plan DAY), op_level = $op_level where id = $row->id") or die($db->error);
					} else {
						$tt = $db->query("update tblmavro set date_release='0000-00-00 00:00:00', op_level = $op_level where id = $row->id") or die($db->error);
					}
				} else {
					$tt = $db->query("update tblmavro set date_release='0000-00-00 00:00:00', op_level = $op_level where id = $row->id") or die($db->error);
				}
			}
		}
	}
}

?>