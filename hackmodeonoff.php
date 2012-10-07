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
$loginparams=array("'".$_REQUEST['user_email']."'",$_REQUEST['lat'],$_REQUEST['lng'],$sts,time(),"'".$_REQUEST['skills']."'","'".$_REQUEST['interests']."'");

if(count($rows)<0) { //NEVER FOR NOW
/*	if(!$_SESSION['user_email'])
		die('Need $_SESSION[\'user_email\']');
	
	$q="SELECT id FROM users WHERE email='{$_SESSION['user_email']}'";
	//echo $q."\n\n";
	$result=mysql_query($q) or die("SELECT Error: ".mysql_error());
	$rows = array();
	while($r = mysql_fetch_assoc($result)) {
		$rows[] = $r;
	}

	$q="UPDATE users (email, latitude,longitude,status,status_update_time) SET (".implode(',', $loginparams).") WHERE email='{$_SESSION['user_email']}'" ;
	echo $q."\n\n";
	$result=mysql_query($q) or die("SELECT Error: ".mysql_error());
	*/
}
else {
	$q='INSERT INTO users (email, latitude,longitude,status,status_update_time,skills,interests) VALUES ('.implode(',', $loginparams).')';
	//echo $q."\n\n";
	$result=mysql_query($q) or die("SELECT Error: ".mysql_error());
}

$_SESSION['user_email']=$_REQUEST['user_email'];


$q="SELECT * FROM users WHERE email <> '{$_SESSION['user_email']}' ORDER BY status_update_time DESC";
//echo $q."\n\n";
$result=mysql_query($q) or die("SELECT Error: ".mysql_error());

$rows = array();
while($r = mysql_fetch_assoc($result)) {
	$rows[] = $r;
}
print json_encode($rows);

?>