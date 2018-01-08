<?
$pagetitle = "Sell PINs";
include("../_dbconfig.php");
include("../_ggFunctions.php");

echo "1";
$pinlog = $db->query("select * from tblpinlog");
echo "<br>2";
$i = 1;
while ($row = mysqli_fetch_object($pinlog)) {
	echo "<br>$row->id $row->requestby  ";
	$mem = ggFetchObject("select id from tblmember where email = '$row->requestby'") or die ("err ".$db->error);
	if ($mem->id > 0) {
		$leader = ggLeader($mem->id);
		echo " - ".$leader;
		$rs = $db->query("update tblpinlog set leader = '$leader' where id = $row->id");
	}
}

function ggLeader($id) {
	$leader = ggFetchObject("select * from tblmember where id = $id");
	$rank = $leader->rank;
	$ctr = 1;
	while ($rank <= 5 and $rank >0 and $ctr<50) {
		$leader = ggFetchObject("select * from tblmember where id = $leader->manager");
		$rank = $leader->rank;
		$ctr += 1;
		if ($ctr==50) {
			$rank = 0;
		}
		//echo "<br>$leader->id $leader->email";
	}
	if ($rank==0) {
		return ("XX");
	} else {
		return ($leader->pin);
	}
}
?>
