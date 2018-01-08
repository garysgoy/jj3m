<!DOCTYPE html>
<html lang="zh-TW" dir="ltr" class="client-nojs">
<head>
<meta charset="UTF-8" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>My MMM System</title>
<link rel="stylesheet" type="text/css" href="pop_win1.css" />
<style>
body {
  background: #FEEEBD;
}
div #main {
position: absolute;
top: 130px;
left: 0;
}
</style>
<body>
<div id="overlay"></div>
<!-- End Overlay -->
<!-- Start Special Centered Box -->
<div id="specialBox1">
<!--<div id="Header">Provide Help</div>-->
<span class="title">This is the title</span></a>
<a href="" class="close" onmousedown="WindowOff()"><span>Close</span></a>

<div class="popScroll">
  <p class="innertube">
    <form id="myForm" method="post" onsubmit="return false;">
		<div id="xx">
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		this is content<br>
		</div>
		<div id="xx1"></div>
    </form>
  </p>
</div>
<p class="footer">  <button onmousedown="toggleOverlay(1)">Send</button>
</p>

</div>

<div class="main">
<?
include("_util.php");
include("_ggFunctions.php");
include("__util.php");

	$KoolControlsFolder = "../KoolControls";


    require $KoolControlsFolder."/KoolAjax/koolajax.php";
    $koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	if($koolajax->isCallback)
	{
		sleep(1); //Slow down 1s to see loading effect
	}

	echo $koolajax->Render();


$res = $db->query("select * from tblMavro order by mem_id,id");
echo "<table border=1 cellspacing=0 cellpadding=2 width=100%><tr><td>id</td><td>Type</td><td>Date Created</td><td>Release</td><td>Nominal Sum</td><td>Wallet</td><td>Description</td><td>Today/Date of defrost</td><td>Future</td><td>Comment</td></tr>";
$mem_group = "";
while ($row = mysqli_fetch_object($res)) {
	if ($mem_group <> $row->mem_id) {
		$mem_group = $row->mem_id;
		$mem = mysqli_fetch_object($db->query("select * from tblMember where id = $row->mem_id"));

		echo "<tr><td colspan=10 bgcolor=silver>$row->mem_id $mem->name $mem->email $mem->leader1 $mem->leader2 $mem->leader3 </td></tr>";
	}

	if ($row->type =="U") {
		$type = "Unconfirmed";
		$color = "Red";
	} else {
		$type = "Confirmed";
		$color = "Green";
	}

	$release = "";
	if ($row->release_days > 0) {
		$release = new datetime($row->date_created);
		$now = new datetime("now");
		$nominal_amount = number_format($row->nominal_amount,2) . " HKD";
		$release->Modify("+ 14 days");
		$days = -ggDaysDiff($release); //1; //$now->diff($release);
		$release = $release->format('Y-m-d H:i:s');
		$future = "Amount at the date of<br> defrost. Left until<br> defrost ($days) days";
	} else {
		$future = "<a href='' onmousedown='toggleOverlay(1)'>Future</a>";
		$nominal_amount = "";
	}


	switch ($row->wallet) {
		case 1: $wallet = "<a href='' onmousedown='getTransaction($row->id)'>Growth of 30% per month</a>"; break;
		case 2: $wallet = "<a href='' onmousedown='getTransaction($row->id)'>Referal Bonus</a>"; break;
		case 3: $wallet = "<a href='' onmousedown='getTransaction($row->id)'>Leader Bonus</a>"; break;
	}

	echo "<tr><td>A1230000$row->id</td><td>$type</td><td>$row->date_created</td><td>$release</td><td>$nominal_amount</td><td>$wallet</td><td>Z3330000$row->folio</td><td align=right><span style='color: $color'>".number_format($row->future_amount,2)."</span> Mavro-HKD</td><td>$future</td><td>Comment</td></tr>";
}
echo "</table>";
?>
</div>
</body>

<script type="text/javascript">

function getTransaction(lid) {
	x = WindowOn();
}
function WindowOn() {
	var overlay = document.getElementById('overlay');
	var specialBox = document.getElementById('specialBox1');
	overlay.style.opacity = .2;
	overlay.style.display = "block";
	specialBox.style.display = "block";
}
function WindowOff() {
	var overlay = document.getElementById('overlay');
	var specialBox = document.getElementById('specialBox1');
	overlay.style.opacity = .2;
	overlay.style.display = "none";
	specialBox.style.display = "none";
}
</script>