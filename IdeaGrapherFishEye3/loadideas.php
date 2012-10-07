<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Load Ideas List</title>
</head>

<body>
<?php

function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
                $res = strpos($haystack, $needle, $offset);
                if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
}
function get_hashtags($idea)
{
    $matches = array();
    preg_match_all('/#\S*\w/i', $idea, $matches);
    return $matches[0];
}

function parseIdea($idea) {
	$TITLE_DELIMS=array('--',':');
	$TITLE_MAX_CHARS=50;
	
	$idea=trim(trim($idea),'-');
	if(strlen($idea)<=0)
		return FALSE;
	$ideaStart=substr($idea,0,$TITLE_MAX_CHARS);
	
	$titleP=strposa($ideaStart,$TITLE_DELIMS);
	if($titleP==false)
		$titleP=$TITLE_MAX_CHARS;
	$title=substr($ideaStart,0,$titleP);
	//if($titleP>=$titleMaxChars-1) {
	//	$title.='...';
	//}
	

	$tags=	get_hashtags($idea);
	//print_r($tags);
	return array('title'=>$title,'idea'=>$idea,'tags'=>$tags);
}

if(isset($_POST['submit'])) {

	include("mysql.php");
	

	$ideasray= array_filter(array_map(parseIdea,split("\n",$_POST['ideasdoc'])));
	//print_r($ideasray);
	
	$sql = array(); 
	foreach( $ideasray as $row ) {
		$sql[] = '("'.mysql_real_escape_string($row['title']).'", "'.$row['idea'].'")';
	}
	$q='INSERT INTO ideasdb (title, ideatxt) VALUES '.implode(',', $sql);
	echo $q."\n\n";
	$result=mysql_query($q) or die("SELECT Error: ".mysql_error());
	
	//$result = mysql_query( "$q" ) or die("SELECT Error: ".mysql_error()); 
	$sth = mysql_query("SELECT * FROM ideasdb WHERE 1");
	$rows = array();
	while($r = mysql_fetch_assoc($sth)) {
		$rows[] = $r;
	}
	print json_encode($rows);
}
?>
Enter List
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
<textarea cols="200" rows="20" name="ideasdoc" ></textarea><br>
<input type="submit" name="submit" />
</form>    
    <?php
$myFile = file_get_contents('ideas.json');
$myDataArr = json_decode($myFile, true);
//print_r($myDataArr);
?>
</body>
</html>