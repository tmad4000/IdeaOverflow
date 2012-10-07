
<?php
$myFile = file_get_contents('ideas.json');
$myDataArr = json_decode($myFile, true);
print_r($myDataArr);
?>
