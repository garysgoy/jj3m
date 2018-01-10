<?
//include("../_util.php");
include("../inc/ggDbconfig.php");
include("__util.php");
include("../inc/ggFunctions.php");
include("../_sms.php");

$id = $_REQUEST['id'];
$confirm = $_REQUEST['confirm'];
$pr = isset($_REQUEST['pr']) ? $_REQUEST['pr']:5;

if ($id > 0) {
	if ($id == 19640001) {
		$rs = mysqli_fetch_object($db->query("select * from tblhelp where g_type='P' and g_date<= '2015-07-26' and (status='O' or status='P') order by g_type, priority, g_date limit 1")) or die("err sel ".$db->error);
		$id = $rs->id;
		echo "$rs->id $rs->g_type $rs->priority $rs->g_date $rs->g_amount<br>";
	}
	if (ggCanProcess1($id)) {
		ggProcess1($id);
		echo "<br>Processed Help_Id = $id<br><br>";
	} else {
		echo "<br><b class='red'>NOT ENOUGH GH TO PROCESS</b><br><br><br>";
	}
} else if (isset($_REQUEST['date_end'])) {
	$date_end = $_REQUEST['date_end'];
	$rs = $db->query("select * from tblhelp where g_type='P' and g_date<= '$date_end 23:59:59' and priority<=$pr and (status='O' or status='P')  order by g_type, priority, g_date") or die("err sel ".$db->error);
	$rs1 = mysqli_fetch_object($db->query("select count(id) as ctr, sum(g_amount) as amt from tblhelp where g_type='P' and g_date<= '$date_end 23:59:59' and priority<=$pr and (status='O' or status='P')  order by g_type, priority, g_date")) or die("err sel ".$db->error);
	echo "Total PH Count = $rs1->ctr  PH Amount = ".number_format($rs1->amt,2)."<br>";

	if ($confirm=="Y") {
		$ctr=1;
		while ($row = mysqli_fetch_object($rs)) {
//			echo "<br>$ctr Help ID: $row->id PH Amount: ".number_format($row->g_amount,0);
			$id = $row->id;
			if (ggCanProcess1($id)) {
				ggProcess1($id);
				echo "<br>Processed $ctr Help_Id = $id PH Amount = ".number_format($row->g_amount,0);
			}
			$ctr++;
		}
		echo "<br><br>";
	}

} else {
		echo "<br>ID not specified<br><br><br>";
}


gStatus($pr);
exit(0);

function ggCanProcess1($id) {
	$ret = false;
	$rs = $db->query("select * from tblhelp where g_type='P' and id=$id");
	if (mysqli_num_rows($rs)>0) {
		$rec1 = mysqli_fetch_object($rs);
		if ($rec1->status <> "C" and $rec1->g_pending > 0) {
			$rec2 = mysqli_fetch_object($db->query("select sum(g_pending) as pending from tblhelp where g_type='G' and (status = 'O' or status = 'P')"));
			if ($rec2->pending >= 1 and $rec2->pending >= $rec1->g_pending) {
				$ret = true;
			}
		}
	}
	return ($ret);
}

function ggProcess1($id) {
	global $app_domain;
	$prime = "P";
	$second = "G";

	$now = new DateTime("NOW");
	$s_now = ggDateToString($now);

    $timer = ggAddHours($now,36);

	$s_timer = ggDateToString($timer);
	//echo "Server Time: " . $s_now . " ". $s_timer."<br><br>";

	// GG Change tblcounter to last tran_id from tblhelpdetail
	$rs = mysqli_fetch_object($db->query("select tran_id from tblhelpdetail order by tran_id desc limit 1"));
	$g_ctr = $rs->tran_id+1;

	$rec = mysqli_fetch_object($db->query("select * from tblhelp where g_type='$prime' and id=$id"));
	$bal = $rec->g_pending;
	$gID = $rec->id;
	$mem_id = $rec->mem_id;

	// Process Pending first
	while ($row = mysqli_fetch_object($db->query("select * from tblhelp where g_type='$second' and status = 'P' and mem_id <> $mem_id order by id limit 1")) and $bal > 0) {
		if ($row->g_pending > $bal) {
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($gID, $g_ctr, $mem_id,'$prime',$row->mem_id,'$s_now',$bal,'$s_timer',0)") or die('Error 1: ' . $db->error);
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($row->id, $g_ctr, $row->mem_id,'$second',$mem_id,'$s_now',$bal,'$s_timer',0)") or die('Error 2: ' . $db->error);
			$res = $db->query("update tblhelp set g_pending = g_pending - $bal, status='P' where id =". $row->id ) or die('Error 2: ' . $db->error);
			$bal = 0;
			$g_ctr += 1;
		} else {
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($gID, $g_ctr, $mem_id,'$prime',$row->mem_id,'$s_now',$row->g_pending,'$s_timer',0)") or die('Error 3: ' . $db->error);
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($row->id, $g_ctr, $row->mem_id,'$second',$mem_id,'$s_now',$row->g_pending,'$s_timer',0)") or die('Error 4: ' . $db->error);

			$res = $db->query("update tblhelp set g_pending = 0, status='C',date_match = '$s_now'  where id =". $row->id ) or die('Error 4: ' . $db->error);
			$bal = $bal - $row->g_pending;
			$g_ctr += 1;
		}
	}

	$ids = array();
	// Process Open
	while ($row = mysqli_fetch_object($db->query("select * from tblhelp where g_type='$second' and status = 'O' and mem_id <> $mem_id order by g_type,priority,g_date limit 1")) and $bal > 0) {
		if ($row->g_pending > $bal) {
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($gID, $g_ctr, $mem_id,'$prime',$row->mem_id,'$s_now',$bal,'$s_timer',0)") or die('Error 1: ' . $db->error);
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($row->id, $g_ctr, $row->mem_id,'$second',$mem_id,'$s_now',$bal,'$s_timer',0)") or die('Error 2: ' . $db->error);
			$res = $db->query("update tblhelp set g_pending = g_pending - $bal, status='P' where id =". $row->id ) or die('Error 2: ' . $db->error);
			$bal = 0;
			$g_ctr += 1;
		} else {
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($gID, $g_ctr, $mem_id,'$prime',$row->mem_id,'$s_now',$row->g_pending,'$s_timer',0)") or die('Error 3: ' . $db->error);
			$res1 = $db->query("insert into tblhelpdetail (help_id, tran_id, mem_id, g_type, oth_id, g_date, g_amount,g_timer,status) VALUES ($row->id, $g_ctr, $row->mem_id,'$second',$mem_id,'$s_now',$row->g_pending,'$s_timer',0)") or die('Error 4: ' . $db->error);

			$res = $db->query("update tblhelp set g_pending = 0, status='C',date_match = '$s_now'  where id =". $row->id ) or die('Error 4: ' . $db->error);
			$bal = $bal - $row->g_pending;
			$g_ctr += 1;
		}

		//echo sms_match($row->id);
		array_push($ids, $row->id);
	}

	$tem = $db->query("update tblcounter set value=$g_ctr where code = 'GIVE'");
	$tem = $db->query("update tblhelp set status='C', g_pending=0, date_match = '$s_now' where id=".$rec->id);

	//echo sms_match($id);
	array_push($ids,$id);

	$j = count($ids);
	for($i = 0; $i < $j ; $i++) {
		echo sms_match($ids[$i]);
	}
}

?>