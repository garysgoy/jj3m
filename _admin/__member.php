<?
include("../_util.php");
include("__util.php");
include("../inc/ggFunctions.php");

$mem_id = rand(2,10);
$amount = rand(1,7)*1000;

$name1a = array("Adam","Bobby","Cat","Doris","Eddie","Fanny","Gary","Henry","Irene","James","Kenneth","Lary","Marry","Namcy","Orange","Peter","Quennie","Rose","Susan","Tom","Uma","Vincent","Watter","Xero","Yvonne","Zee");
$name2a = array("Ang","Boon","Chan","Toh","Chin","Foo","Lim","Pang","Tang","Ho","Liew","Quek","Tan");

$name1 = $name1a[rand(1,25)];
$name2 = $name2a[rand(1,12)];

$name  = $name1 ." ". $name2;
$email = $name1."@gmail.com";

ggAddMember($name1,$name2,$email);

//ggAddMavro($mem_id, $amount);
echo "<br><br>";
gStatus();

function ggAddMember($name1,$name2,$email) {
	$user = load_user(0);
	$ref = $user->id;

	$username = left($name1,1).generatePassword(6);
	$password = md5(left($name1,4));
	$last = mysqli_fetch_object($db->query("select id from tblMember where currency='$user->currency' order by id desc limit 1"));
	$phone = ""; // "+" . (85260000000 + rand(1,999999));

	$row = ggSQLObject("select * from tblMember where id=$ref");
	if ($row->rank > 0) {
	   $mgr = $row->id;
	} else {
	   $mgr = $row->manager;
	}

	$rs = $db->query("INSERT INTO  tblMember (id,username,fname,lname, email,password,phone,ref,manager,join_date,rank,country,currency,language, region,referrals,status,directs,accounts,vacation,created,last_access,last_ip)
		VALUES (NULL ,  '$username',  '$name1', '$name2', '$email',  '$password',  '$phone',  '$ref', $mgr, NOW( ) ,  '0',  '$row->country',  '$row->currency', '$row->language', '',  '',  '',  '',  '',  '', NOW( ) ,  '',  '')") or die($db->error);
}
?>