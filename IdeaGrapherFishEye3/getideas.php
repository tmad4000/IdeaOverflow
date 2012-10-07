{"nodes":
<?php
//$myFile = file_get_contents('ideas.json');
//$myDataArr = json_decode($myFile, true);
//print_r($myDataArr);
include("mysql.php");
$s=mysql_real_escape_string($_GET['suggest']);
if(!$s) {
	$q="SELECT title as 'name','1' as 'group' FROM ideasdb WHERE 1";
}
else
	$q="SELECT title as 'name','1' as 'group' FROM ideasdb WHERE ideatxt LIKE '%{$s}%'";

$sth = mysql_query($q);
//$sth = mysql_query("SELECT * FROM ideasdb WHERE 1");
$rows = array();
while($r = mysql_fetch_assoc($sth)) {
	$rows[] = $r;
}
print json_encode($rows);
//{"nodes":[{"name":"Myriel","group":1},{"name":"Napoleon","group":1}],"links":[{"source":1,"target":0,"value":1}]}

?>
,"links":[{"source":1,"target":0,"value":1}]}