<?

include("../_dbconfig.php");
include("../_ggFunctions.php");

$date = ggNows(); //ggNow();
$manager    = htmlspecialchars($_REQUEST['manager']);
$pins       = htmlspecialchars($_REQUEST['pins']);
$paid       = htmlspecialchars($_REQUEST['paid']);
$leader      = htmlspecialchars($_REQUEST['leader']);
$note       = htmlspecialchars($_REQUEST['note']);

$mgr = load_user($manager);
if ($mgr->rank < 5) {
    $r = $db->query("update tblmember set rank=5, pins+=$pins, date_manager='$date' where id = $mgr->id");
} else {
    $r = $db->query("update tblmember set pins+=$pins where id = $mgr->id");
}

$add1 = $db->query("insert into tblpinlog (requestby,issueby,pins, paid, note,leader) values ('$mgr->email', 'gary', $pins, '$paid','$note','$leader')") or die("err 1".$db->error);
$log = mysqli_insert_id();


for ($i=1;$i<=$pins;$i++) {
	echo $i." ";
	$pin = gen_pin(20);
	$add2 = $db->query("insert into tblpin (managerid,requestdate, pin, paid, status,note) values ('$mgr->id', '$date', '$pin', '$paid','N','$log')") or die("err 2".$db->error);
}

echo <<<INFO
<div style="padding:0 50px">
<p>Email: $mgr->email</p>
<p>Pins: $pins</p>
<p>Paid: $paid</p>
<p>Note: $note</p>
</div>
INFO;

function gen_pin($len) {
	$ret = "";
    $seed = str_split("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
    for ($x=0; $x<$len; $x++) {
       $ret .= $seed[rand(0, 45)];
    }
    //foreach (array_rand($ret, $len) as $k) $rand .= $seed[$k];
    return $ret;
}
?>