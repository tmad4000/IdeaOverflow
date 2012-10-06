<?php

include("mysql.php");
	
$sts = $_REQUEST['status']=="on" ? 1 : 0;

$loginparams=array($_REQUEST['email'],$_REQUEST['lat'],$_REQUEST['lng'],$sts,time());

$q='INSERT INTO users (email, latitude,longitude,status,status_update_time) VALUES '.implode(',', $loginparams);
echo $q."\n\n";

$result=mysql_query($q) or die("SELECT Error: ".mysql_error());

	