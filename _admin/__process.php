<?
include("../_util.php");
include("__util.php");

$main = "P";
if ($main=="G") {
   $prime = "G";
   $second = "P";
} else {
   $prime = "P";
   $second = "G";
}

$now = new DateTime("NOW");

$rec = mysqli_fetch_object($db->query("select * from tblhelp where g_type='$prime' and status<>'C' order by id limit 1"));
$bal = $rec->g_pending;
$gID = $rec->id;
$mem_id = $rec->mem_id;

while ($row = mysqli_fetch_object($db->query("select * from tblhelp where g_type='$second' and status = 'P' and mem_id <> $mem_id order by id limit 1")) and $bal > 0) {
    //echo "Processing P....<br><br>";
	if ($row->g_pending > $bal) {
	    $res1 = $db->query("insert into tblhelpdetail (gh_id, gh_mem, ph_id, ph_mem, g_date, g_amount) VALUES ($row->id, $row->mem_id,$gID,$mem_id,now(),$bal)") or die('Error 1: ' . $db->error);
		$res = $db->query("update tblHelp set g_pending = g_pending - $bal, status='P' where id =". $row->id ) or die('Error 2: ' . $db->error);
		$bal = 0;
		//echo $bal."  ". $row->id."<br>";
	} else {
	    $res1 = $db->query("insert into tblhelpdetail (gh_id, gh_mem, ph_id, ph_mem, g_date, g_amount) VALUES ($row->id, $row->mem_id,$gID,$mem_id,'".$now->format('Y-m-d H:i:s')."',$row->g_pending)") or die('Error 3: ' . $db->error);
		$res = $db->query("update tblHelp set g_pending = 0, status='C',date_close = '".$now->format('Y-m-d H:i:s')."'  where id =". $row->id ) or die('Error 4: ' . $db->error);
        $bal = $bal - $row->g_pending;
		//echo $bal."  ". $row->id."<br>";
	}
}

while ($row = mysqli_fetch_object($db->query("select * from tblHelp where g_type = '$second' and status = 'O' and mem_id <> $mem_id order by id limit 1")) and $bal > 0) {
    //echo "Processing O....<br><br>";
	if ($row->g_pending > $bal) {
	    $res1 = $db->query("insert into tblhelpdetail (gh_id, gh_mem, ph_id, ph_mem, g_date, g_amount) VALUES ($row->id, $row->mem_id,$gID,$mem_id,'".$now->format('Y-m-d H:i:s')."',$bal)") or die('Error 1: ' . $db->error);
		$res = $db->query("update tblHelp set g_pending = g_pending - $bal, status='P' where id =". $row->id ) or die('Error 2: ' . $db->error);
		$bal = 0;
		//echo $bal."  ". $row->id."<br>";
	} else {
	    $res1 = $db->query("insert into tblhelpdetail (gh_id, gh_mem, ph_id, ph_mem, g_date, g_amount) VALUES ($row->id, $row->mem_id,$gID,$mem_id,'".$now->format('Y-m-d H:i:s')."',$row->g_pending)") or die('Error 3: ' . $db->error);
		$res = $db->query("update tblHelp set g_pending = 0, status='C', date_close = '".$now->format('Y-m-d H:i:s')."'  where id =". $row->id ) or die('Error 4: ' . $db->error);
        $bal = $bal - $row->g_pending;
		//echo $bal."  ". $row->id."<br>";
	}
}

//echo "Update Status...<br><br>";
$tem = $db->query("update tblhelp set status='C', g_pending=0, date_close = '".$now->format('Y-m-d H:i:s')."' where id=".$rec->id);

gStatus();
?>