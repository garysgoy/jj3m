<?
include("../_dbconfig.php");
include("../_ggFunctions.php");

$q1 = $db->query("update tblmember set nickname=email, phone='',bankbranch='',bankaccount='',bankholder='',fullname=email,wechat='' where pin like 'xxwilson%'") or die($db->error);
$q = $db->query("select * from tblmember where fullname like 'goy%' order by id");

$i = 1;
echo "<table><tr><td>SN</td><td>Email</td><td>Nickname</td><td>Fullname</td><td>manager</td><td>Bankaccount</td><td>date</td></tr>";
while ($row = mysqli_fetch_object($q)) {
	$mm = ggFetchObject("select email from tblmember where id = $row->manager");
	echo "<tr><td>$i</td><td>$row->email</td><td>$row->nickname</td><td>$row->fullname</td><td>$mm->email</td><td>$row->bankaccount</td><td>$row->last_login</td></tr>\n";
	$i +=1;
}
echo "</table>";
?>