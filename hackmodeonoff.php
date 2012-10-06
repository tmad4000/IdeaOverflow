<?php
session_start();

include("mysql.php");
	
/*$q="SELECT id FROM users WHERE email='{$_REQUEST['email']}'";
echo $q."\n\n";
$result=mysql_query($q) or die("SELECT Error: ".mysql_error());

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
	$rows[] = $r;
}
print json_encode($rows);
*/
	
$sts = $_REQUEST['status']=="on" ? 1 : 0;
$loginparams=array("'".$_REQUEST['email']."'",$_REQUEST['lat'],$_REQUEST['lng'],$sts,time());

$q='INSERT INTO users (email, latitude,longitude,status,status_update_time) VALUES ('.implode(',', $loginparams).')';
echo $q."\n\n";
$result=mysql_query($q) or die("SELECT Error: ".mysql_error());


$_SESSION['user_email']=$_REQUEST['user_email'];
?>