<?php
if(isset($_GET['clear'])) {
	header("Location: {$_SERVER['PHP_SELF']}?inpedesc=on");
}
/*$execout;
exec('pwd',&$execout);
print_r( $execout);*/
include("../mysql.php");
mysql_connect($mysql_host, $mysql_user, $mysql_password);
@mysql_select_db($mysql_database) or die( "Unable to select database");

if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
{
    //$_POST = array_map( 'stripslashes', $_POST );
    //$_GET = array_map( 'stripslashes', $_GET );
    //$_COOKIE = array_map( 'stripslashes', $_COOKIE );
}

?>
<html>
<head>
<title>Matching Macro</title>
<style type="text/css">
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	padding:10px
}
table {
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
}
td {
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
}
input[type=text] {
	border: 1px solid #CCC;
	padding:0;
	margin:0;
}
table#matchesTable th {
	padding-right:20px;
}
.normtxt {
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
}
.fainttxt {
	text-align:right;
	font-size:10px;
	color:#AAA
}
.cellPD {
	height:120px;
	width:150px;
	overflow:auto;
}
.cellD {
	height:100%;
	width:600px;
	overflow:auto;
}
.cellN {
	height:80px;
	width:150px;
	overflow:show;
}
.cell {
	height:120px;
	max-width:100px;
	overflow:auto;
}
.cellW {
	height:120px;
	max-width:100px;
	overflow:auto;
}
/*
	#matchesTable td div {
	  height:120px;
	  max-width:100px;
	  overflow:auto;
	}*/
	.highlight {
		background-color:yellow
	}
	
	
	.highlight0 {
		background-color:yellow
	}

	.highlight1 {
		background-color:pink
	}
	.highlight2 {
		background-color:chartreuse
	}
	.highlight3 {
		background-color:orange
	}
	.highlight4 {
		background-color:cyan
	}
	.highlight5 {
		background-color:beige
	}
	.highlight6 {
		background-color:gold
	}
	.highlight7 {
		background-color:silver
	}
div.main {
	padding-left: 20px
}
</style>
<style type="text/css">
.btn {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
 filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	/*-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;*/
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#777777;
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
	padding:3px 6px;
	text-decoration:none;
	text-shadow:1px 1px 0px #ffffff;
}
.btn:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
 filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}
.btn:active {
	position:relative;
	top:1px;
}
/* This imageless css button was generated by CSSButtonGenerator.com */
</style>
<link rel="stylesheet" href="__jquery.tablesorter/css/jq.css" type="text/css" media="print, projection, screen" />
<link rel="stylesheet" href="__jquery.tablesorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
<script type="text/javascript" src="__jquery.tablesorter/jquery-latest.js"></script>
<script type="text/javascript" src="__jquery.tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="__jquery.tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="__jquery.tablesorter/js/chili/chili-1.8b.js"></script>
<script type="text/javascript" src="__jquery.tablesorter/js/docs.js"></script>
<script type="text/javascript" src="__jquery.tablesorter/js/examples.js"></script>

<!-- nanoscroller --><!-- 
  <link rel="stylesheet" href="js/nanoscroller/bin/css/nanoscroller.css">
  <link rel="stylesheet" href="js/nanoscroller/bin/css/main.css">               
  <link rel="stylesheet" href="js/nanoscroller/bin/css/style.css">-->

</head>
<body>
<?php

$relationshipOpts=array('1. Bainbridge Client','1. CS Active Member','2. One Off Agreement','3. Bainbridge Former Client','4. CS Former Member','5. CS Passive Member','6. Bainbridge Hot Prospect','7. Bainbridge Prospect','8. CS / One-off Prospect','9. CS Prospect','A. CS Prospect - initial contact','B. Null'); 

function mres($q) {
    if(is_array($q)) 
        foreach($q as $k => $v) 
            $q[$k] = mres($v); //recursive
    elseif(is_string($q))
        $q = mysql_real_escape_string($q);
    return $q;
}
/*
foreach($_GET as $k=>$v)
	if($k!='submit')
		$_GET[$k]=mres($v);*/
//$_GET = array_map( 'mres', $_GET );
	
if(isset($_GET['submit'])) {
		$lim=100;
		if($_GET['submit']=='Submit (show 250)') 
			$lim=250;
			
		$keywords=$_GET['afield'];
		$save=false;
		foreach ($keywords as $i=>$w) {
				$okeywords[$i]=trim($okeywords[$i]);
				if($w)
					$save=true;
			}
		if(!$save)
			$keywords=array();
		
		if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
		{
			//$_POST = array_map( 'stripslashes', $_POST );
			$keywords = array_map( 'stripslashes', $keywords );
			//$_COOKIE = array_map( 'stripslashes', $_COOKIE );
		}
		$keywords=mres($keywords);
		
		
		$okeywords=$_GET['ofield'];
		
		$save=false;
		foreach ($okeywords as $i=>$w) {
				$okeywords[$i]=trim($okeywords[$i]);
				if($w)
					$save=true;
			}
		if(!$save)
			$okeywords=array();
		if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) )
		{
			//$_POST = array_map( 'stripslashes', $_POST );
			$okeywords = array_map( 'stripslashes', $okeywords );
			//$_COOKIE = array_map( 'stripslashes', $_COOKIE );
		}
		$okeywords=mres($okeywords);
		
		
				
		//Restrictions
		$qRestrictions='';
		//Min ebidta
		if($_GET['minebidta'])
			$qRestrictions.=" AND (`ebidta-min` IS NULL OR `ebidta-min`<= {$_GET['minebidta']})";
		
		//Min Revenue
		if($_GET['minrevenue'])
			$qRestrictions.=" AND (`revenue-min` IS NULL OR `revenue-min`<= {$_GET['minrevenue']})";
		
		//source
		if($_GET['sourceselect']&&count($_GET['sourceselect'])<2) {
			$qRestrictions.=" AND (";
			foreach($_GET['sourceselect'] as $source) {
				$qRestrictions.="source='$source' OR ";
			}
			$qRestrictions=substr($qRestrictions,0,strlen($qRestrictions)-3).")";
		}
		
		
		//relationship status
		  
		if($_GET['statusselect']&&count($_GET['statusselect'])<count($relationshipOpts)) {
			$qRestrictions.=" AND (";
			foreach($_GET['statusselect'] as $status) {
				if($status=='B. Null')
					$status='IS NULL';
				else
					$status='LIKE \'%'.$status.'%\'';
				$qRestrictions.="relationshipstatus $status OR ";
			}
			$qRestrictions=substr($qRestrictions,0,strlen($qRestrictions)-3).")";
		}
		
	function genDescQ($descword,$joinword,$keywords) {
			$q='';
			if($keywords) {
			foreach ($keywords as $i=>$w) {
				if($w)
					$q.="`$descword` LIKE '%".$w."%' $joinword ";
			}
			$q=substr($q,0,strlen($q)-strlen($joinword)-2);
			}
			return $q;
		}
		
					
	function makeSearchPEFirmsQ() {
		global $keywords,$okeywords,$qRestrictions,$lim;
		

$q="(SELECT relationshipstatus,id,name,'N/A','(This row is an exec/PE Firm description search)',website,description,`ebidta-min`,`ebidta-max`,`revenue-min`,`revenue-max`,`investmentsize-min`,`investmentsize-max`,industries,keypersonnel,execswdesc,country,source FROM pefirms4 WHERE ";
		$end="";
	if($_GET['submit']=='Submit + show all portf. cos.') {
			$q="(SELECT relationshipstatus,id,name,COUNT(*),GROUP_CONCAT( pdescription SEPARATOR '*<br>\n'),website,description,`ebidta-min`,`ebidta-max`,`revenue-min`,`revenue-max`,`investmentsize-min`,`investmentsize-max`,industries,keypersonnel,execswdesc,country,source FROM pefirms4 LEFT JOIN portfcos on pefirms4.srcid=portfcos.investorid WHERE ";
			$end=" GROUP BY portfcos.investorid";
		}
				
		$descword='description';
		
	
	
		//name	
		if ($_GET['pefirmname'])
			$q.="`name` LIKE '%".$_GET['pefirmname']."%' OR ";
	

	
		$dq=genDescQ($descword,"AND",$keywords);
		$q.=$dq;
		if($okeywords) {
			if($dq)
				$q.=' AND ';
			$q.='('. genDescQ($descword,'OR',$okeywords).')';
		}		
		/*
		//keywords -- description
		if($keywords) {
			foreach ($keywords as $i=>$w) {
				if($w)
					$q.="`$descword` LIKE '%".$w."%' $joinword ";
			}
			$q=substr($q,0,strlen($q)-strlen($joinword)-2);
		}*/

		$q.=$qRestrictions;
		$q.=$end;
		$q.=" ORDER BY IF(ISNULL(relationshipstatus),1,0),relationshipstatus,name LIMIT $lim)";
		
		return $q;
	}

	function makeSearchExecDescQ() {
		global $keywords,$okeywords,$qRestrictions,$lim;
		

		$q="(SELECT relationshipstatus,id,name,'N/A','(This row is an exec/PE Firm description search)',website,description,`ebidta-min`,`ebidta-max`,`revenue-min`,`revenue-max`,`investmentsize-min`,`investmentsize-max`,industries,keypersonnel,execswdesc,country,source FROM pefirms4 WHERE ";
		$end="";
		
	if($_GET['submit']=='Submit + show all portf. cos.') {
			$q="(SELECT relationshipstatus,id,name,COUNT(*),GROUP_CONCAT( pdescription SEPARATOR '*<br>\n'),website,description,`ebidta-min`,`ebidta-max`,`revenue-min`,`revenue-max`,`investmentsize-min`,`investmentsize-max`,industries,keypersonnel,execswdesc,country,source FROM pefirms4 LEFT JOIN portfcos on pefirms4.srcid=portfcos.investorid WHERE ";
			$end=" GROUP BY portfcos.investorid";
		}
	
		//$q="SELECT * FROM `pefirms` WHERE ";
		$descword='execswdesc';
		
	
	
		//name	
		if ($_GET['pefirmname'])
			$q.="`name` LIKE '%".$_GET['pefirmname']."%' OR ";
	

	
		$dq=genDescQ($descword,"AND",$keywords);
		$q.=$dq;
		if($okeywords) {
			if($dq)
				$q.=' AND ';
			$q.='('. genDescQ($descword,'OR',$okeywords).')';
		}		
		/*
		//keywords -- description
		if($keywords) {
			foreach ($keywords as $i=>$w) {
				if($w)
					$q.="`$descword` LIKE '%".$w."%' $joinword ";
			}
			$q=substr($q,0,strlen($q)-strlen($joinword)-2);
		}*/
		

		$q.=$qRestrictions;
		$q.=$end;
		$q.=" ORDER BY IF(ISNULL(relationshipstatus),1,0),relationshipstatus,name LIMIT $lim)";
		return $q;
	}



	function makeSearchPortfCosQ() {
		global $keywords,$okeywords,$qRestrictions,$lim;
		
	
		$descword='pdescription';
		$q="(SELECT relationshipstatus,id,name,COUNT(*),GROUP_CONCAT( pdescription SEPARATOR '*<br>\n'), website,description,`ebidta-min`,`ebidta-max`,`revenue-min`,`revenue-max`,`investmentsize-min`,`investmentsize-max`,industries,keypersonnel,execswdesc,country,source FROM pefirms4 LEFT JOIN portfcos on pefirms4.srcid=portfcos.investorid WHERE ";
			
		$end=" GROUP BY portfcos.investorid";
		
		//name	
		if ($_GET['pefirmname'])
			$q.="`name` LIKE '%".$_GET['pefirmname']."%' OR ";
	
			$dq=genDescQ($descword,"AND",$keywords);
		$q.=$dq;
		if($okeywords) {
			if($dq)
				$q.=' AND ';
			$q.='('. genDescQ($descword,'OR',$okeywords).')';
		}
		
		/*
		//keywords -- description
		if($keywords) {
			foreach ($keywords as $i=>$w) {
				if($w)
					$q.="`$descword` LIKE '%".$w."%' $joinword ";
			}
			$q=substr($q,0,strlen($q)-strlen($joinword)-2);
		}*/
		
		$q.=$qRestrictions;
		$q.=$end;
		$q.=" ORDER BY IF(ISNULL(relationshipstatus),1,0),relationshipstatus,name LIMIT $lim)";
		return $q;
	}
	
}
?>
<div class="main normtxt"> 
  <script>
 $(document).ready(function(){
	$("#advopt").toggle(function(event){
	  $("#advopttbl").show(50);
   },function(event){
	  $("#advopttbl").hide(50);
   }
   );
   $("#advopttbl").hide(50);
<?php
if(isset($_GET['submit'])) {
	
	$s="allkeywords=[";
	if($keywords||$okeywords) {
		$allkeywords=array_merge($keywords,$okeywords);
		foreach($allkeywords as $k)
			if($k)
				$s.="'".$k."',";
		$s=substr($s,0,strlen($s)-1);
	}
	$s.="];\n";
	print $s;
?>
<?php if($_GET['inportfcos']||$_GET['inexecdesc']||$_GET['inpedesc']) { ?>
	$('.cellPD, .cellD').each(function(index, element) {
		for(i in allkeywords)
	        $(this).html($(this).html().replace( new RegExp("("+allkeywords[i]+")","gi"),"<span class='highlight"+i%8+"'>$1</span>"));	        /*$(this).html($(this).html().replace( new RegExp(keywords[i],"gi"),"<span class='highlight'>"+keywords[i]+"</span>"));*/
    });
<?php } ?>	


	$('.cellW').each(function(index, element) {
			l=$(this).html();
			if(l.indexOf('http://')!=0)
				l="http://"+l
	        $(this).html('<a target="blank" href="'+l+'">'+$(this).html()+'</a>')
    });
	
	
	
	function fetchToolTip(word)
	 {
			$(".tooltip").show();
			
			if($('#how_to_use_home').css('display') == 'none')
				$(".tooltip").offset({ left: word.offset().left - 310/2, top: word.offset().top-205 });
			else
				$(".tooltip").offset({ left: word.offset().left - 310/2, top: word.offset().top-190 });
			$( ".tooltip .internal_tooltip_syn").html("");
			$( ".tooltip .internal_tooltip_def").html("Loading...");
			//alert(word.substring(word.indexOf("#")+1));
			word = word.attr("href");
			var d = new Date();
			$.ajax ({
						type:"GET",
						url: "index.php?p=lookup&y=" + d.getTime(),
						data: "word=" + word.substring(word.indexOf("#")+1),
						success: function(msg) {
						//alert(msg);
							$( ".tooltip .internal_tooltip_def").html(msg.substring(0,msg.indexOf('<SYNONYMS>')));
							$( ".tooltip .internal_tooltip_syn").html(msg.substring(msg.indexOf('<SYNONYMS>')+10));
						}
					});
	 }
<?php
}
?>/*

   $("table#matchesTable div.cellD").toggle(function(event){
	  $(this).animate({"height" : "100%"}, 50);
   },function(event){
	  $(this).animate({"height" : "120"}, 50);
   }
   );
   */
   $("table#matchesTable div.cellPD").toggle(function(event){
	  $(this).animate({"position":"absolute","top":"0","left":"0","height" : "100%","width" : "300px"}, 50);
   },function(event){
	  $(this).animate({"height" : "120","width" : "150px"}, 50);
   }
   );
   	
	$.tablesorter.formatInt = function (s) {
		var i = parseInt(s);
		return (isNaN(i)) ? null : i;
	};
	$.tablesorter.formatFloat = function (s) {
		var i = parseFloat(s);
		return (isNaN(i)) ? null : i;
	};/*
	$.tablesorter.sortText= function (a,b) {
		alert('h');
         if(a == '') return 1;
         else if(b == '') return -1; // force cells with just ""  always to bottom
           return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	};	*/

	$("#matchesTable").tablesorter();
	
	

 });
</script>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
    <p class="normtxt"><u>Matching Macro</u></p>
    <!--<p class="normtxt">PE Firm Name<br>
<input type="text" name="pefirmname" value="<?php echo $_GET['pefirmname'] ?>">
    <br>--> 
    <br>
    <span  class="normtxt"><u>Description Keywords:</u></span>
    <table>
      <tr>
        <td>Must include all:</td>
        <td> Must include 1 or more: </td>        
        <td>Relationship Status</td>
        <td>Source</td>
      </tr>
      <tr>
        <td>
        <?php for($i=0;$i<5;$i++) { ?>
        <input type="text" name="afield[]" value="<?php echo stripslashes($_GET['afield'][$i]) ?>">
          <br>
          <?php } ?>
          </td>
        <td>        
		<?php for($i=0;$i<5;$i++) { ?>
        <input type="text" name="ofield[]" value="<?php echo stripslashes($_GET['ofield'][$i]) ?>">
          <br>
          <?php } ?></td>
        <td><select name="statusselect[]"  multiple="multiple">
          <?php 
		  foreach($relationshipOpts as $r) {
		  	echo '<option value="'.$r.'"';
			if(!$_GET['hiderows']||!$_GET['statusselect']||in_array($r,$_GET['statusselect'])) 
				echo 'selected="selected"';
			echo ">$r</option>";
		  }
		  ?>
          
        </select></td>
        <td><select name="sourceselect[]"  multiple="multiple">
            <option value="privateequityfirms.com" <?php if(!$_GET['hiderows']||!$_GET['sourceselect']||in_array('privateequityfirms.com',$_GET['sourceselect'])) echo 'selected="selected"' ?>>PrivateEquityFirms</option>
            <option value="capitaliq.com"  <?php if(!$_GET['hiderows']||!$_GET['sourceselect']||in_array('capitaliq.com',$_GET['sourceselect'])) echo 'selected="selected"' ?>>CapitalIQ</option>
          </select></td>
      </tr>
    </table>
    <!--
    <input type="checkbox" name="allwords" <?php if($_GET['allwords']) { ?> checked="checked" <?php } ?>>
    All Words <br>-->
    
    <input type="checkbox" name="inpedesc" <?php if($_GET['inpedesc']) { ?> checked="checked" <?php } ?>>
    Search in PE firm descriptions<br>
    <input type="checkbox" name="inportfcos" <?php if($_GET['inportfcos']) { ?> checked="checked" <?php } ?>>
    Search in portfolio company descriptions <br>
    <input type="checkbox" name="inexecdesc" <?php if($_GET['inexecdesc']) { ?> checked="checked" <?php } ?>>
    Search in Executive Experience <br>
    <br>
    <input name="minebidta" type="text" value="<?php echo $_GET['minebidta'] ?>" size="10">
    Min EBIDTA is less than ($mm)<br>
    <input name="minrevenue" type="text" value="<?php echo $_GET['minrevenue'] ?>" size="10">
    Min Revenue  is less than ($mm)<br>
    <br>
    <input type="submit" class="btn" value="Submit (fast)" name="submit">
    <input type="submit" class="btn" value="Submit (show 250)" name="submit">
    <!--
    <input type="submit" value="Submit + show all portf. cos." style="margin-left:100px" name="submit"> 
    (ONLY for  'Check in portfolio company descriptions' NOT checked)-->
    <input type="submit" class="btn" value="Clear" name="clear" style="margin-left:300px">
    </p>
    <a href="#" id="advopt">Choose Columns to Display</a>
    <table id="advopttbl" style="font-size:12px;display:none">
      <tr>
        <?php $showColNum=0;
$showColRay=$_GET['showCol'];
$hideRows=$_GET['hiderows'];
 if(!is_array($showColRay)) {
 	$showColRay=array(); 
	$showColRay[]=$_GET['showCol']; 
 }
?>
        <input type="hidden" name="hiderows" value="true">
        <td>Relationship Status <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>" ></td>
	<td>ID 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>" ></td>
	<td>PE Firm Name 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td># Portf Co Shown 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Portf Co Desc 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Website 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Business Description 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Min EBIDTA ($mm) 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Max EBIDTA ($mm) 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Min Total Revenues ($mm) 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Max Total Revenues ($mm) 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Min Investment Size($mm) 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Max Investment Size ($mm) 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Industries of Interest 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Key Personnel 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Execs w/ Descs 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Country 
	  <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
	<td>Source <input type="checkbox" name="showCol[]" <?php if(!$hideRows||in_array($showColNum,$showColRay)) echo 'checked="checked"' ?> value="<?php echo ($showColNum++); ?>"></td>
</tr></table>
  </form>
  <?php 

if(isset($_GET['submit'])&&($_GET['inpedesc']||$_GET['inportfcos']||$_GET['inexecdesc'])) {
	$q='';
	if($_GET['inpedesc']) {
		$q.=makeSearchPEFirmsQ();
	}
	if($_GET['inportfcos']) {
		if($q)
			$q.=' UNION ALL ';
		$q.=makeSearchPortfCosQ();
	}
	if($_GET['inexecdesc']) {
		if($q)
			$q.=' UNION ALL ';
		$q.=makeSearchExecDescQ();
	}
	$q.=" ORDER BY IF(ISNULL(relationshipstatus),1,0),relationshipstatus,name LIMIT $lim";
		
	print "<div style='display:none'><span class='fainttxt'>".$q."</span></div><br />\n";
	
	$result = mysql_query( "$q" ) or die("SELECT Error: ".mysql_error()); 
	$num_rows = mysql_num_rows($result); 
	if ($num_rows>=$lim)
		$num_rows.="+";

	if($_GET['submit']=='Submit + show all portf. cos.') 
		$num_rows="at least ".$num_rows."; number maybe lower than Submit (Fast)";
	print "<span style='font-size:10px'>There are <b>$num_rows matches.</b></span>"; 
	//print "<table width='400' border='1' cellpadding='0' cellspacing='0' >\n";  
	?>
  <!--  <input type="button" value="Copy Results" id="copybtn"> --> 
  <script type="text/javascript">
    function selectElementContents(el) {
        var body = document.body, range, sel;
        if (body.createTextRange) {
            range = body.createTextRange();
            range.moveToElementText(el);
            range.select();
        } else if (document.createRange && window.getSelection) {
            range = document.createRange();
            range.selectNodeContents(el);
            sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        }
    }
</script> 
  &nbsp;&nbsp;&nbsp;&nbsp;
  <input type="button" class="btn" value="Select Table"
   onclick="selectElementContents( document.getElementById('matchesTable') );">
  <span  class="normtxt">(drag selected table to Excel; drag from any cell not the header)</span>
  <table id="matchesTable" class="tablesorter" width="400" cellspacing="1">
    <thead>
      <tr>
        <?php $showColNum=0;
	if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Relation. Status</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>ID</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th width="200">PE Firm Name</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th># Portf Co Shown</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th width="200">Portf Co Desc</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Website</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Business Description</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Min EBIDTA ($mm)</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Max EBIDTA ($mm)</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Min Total Revenues ($mm)</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Max Total Revenues ($mm)</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Min Investment Size($mm)</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Max Investment Size ($mm)</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Industries of Interest</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Key Personnel</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Execs w/ Descs</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th>Country</th>
        <?php } $showColNum++; if(!$hideRows||in_array($showColNum,$showColRay)) { ?>
        <th width="50">Source</th>
        <?php } ?>
        <!--
//<th>Aerospace & Defense</th><th>Ballistic Acessories</th><th>Other</th><th>Agriculture</th><th>Farm Products and Services</th><th>Fertilizer Production & Distribution</th><th>Food Production</th><th>Nitrogen Production</th><th>Other</th><th>Business Services</th><th>Advertising</th><th>Affinity Marketing</th><th>Business Process Outsourcing</th><th>Data Analytics</th><th>Faciliites Maintenance</th><th>Information Security</th><th>Intelligence and Consulting</th><th>Lead Generation</th><th>Legal Support Services</th><th>Pest Control</th><th>Screening Services</th><th>Search and Recruitment</th><th>Security Services</th><th>Translation Services</th><th>Linen & Uniform Services</th><th>Auction Services</th><th>Other</th><th>Chemicals</th><th>Chlorine Services</th><th>Specialty Chemical Distribution</th><th>Specialty Chemical Manufacturing</th><th>Other</th><th>Construction</th><th>Architecture</th><th>Building Materials</th><th>Engineering &  Construction</th><th>Heating, Ventilating & Air Conditioning (HVAC)</th><th>Marine Construction & Dock Services</th><th>Other</th><th>Consumer Goods & Services</th><th>Oral Care Products</th><th>Pet Products</th><th>Action Sports</th><th>Photography Services</th><th>Romantic Merchandise</th><th>Ticketing</th><th>Other</th><th>Education</th><th>Learning Services</th><th>Online Education</th><th>Other</th><th>Electronics</th><th>Electric Equipment Repair</th><th>Other</th><th>Energy & Utilities</th><th>Energy Equipment</th><th>Energy Service Companies (ESCO)</th><th>Oil & Natural Gas Gathering</th><th>Oil & Natural Gas Processing</th><th>Oil & Natural Gas Exploration & Production</th><th>Oil & Natural Gas Transmission</th><th>Oil Field Services</th><th>Propane Marketing and Distribution</th><th>Water Infrastructure</th><th>Wind Energy</th><th>Other</th><th>Environmental Services & Equipment</th><th>Environmental Services</th><th>Other</th><th>Financial Services</th><th>Accounts Receivable Management</th><th>Payment Processing</th><th>Purchase Programs</th><th>Revenue Cycle Management</th><th>Insurance</th><th>Other</th><th>Food & Beverage</th><th>Candy & Confections</th><th>Concessions</th><th>Sauces & Condiments</th><th>Food Services</th><th>Food Equipment</th><th>Ethnic Foods</th><th>Food Distribution</th><th>Food Processing</th><th>Ingredients</th><th>Specialty Beverage</th><th>Specialty Food</th><th>Sweeteners</th><th>Other</th><th>Healthcare Goods & Services</th><th>Ambulatory Surgical Centers</th><th>Assisted Living Services</th><th>Behavioral Healthcare</th><th>Clinical Research Organizations (CROs)</th><th>Dental Labs</th><th>Healthcare Benefits Management</th><th>Healthcare Billing & Coding</th><th>Healthcare Claims Management</th><th>Healthcare Communications</th><th>Healthcare Consulting</th><th>Healthcare Cost Management</th><th>Healthcare IT</th><th>Medical Devices</th><th>Medical Equipment Leasing</th><th>Medical Imaging</th><th>Medical Record Systems</th><th>Medical Supplies Distribution</th><th>Nutraceuticals</th><th>Orthotics & Prosthetics</th><th>Pathology</th><th>Pharmacy Benefit Management</th><th>Physical Therapy Products</th><th>Veterinary Distribution</th><th>Workers Compensation Services</th><th>Other</th><th>Industrial Goods & Services</th><th>Water Pumps & Valves</th><th>Automated Material Handling</th><th>Control Systems</th><th>Filtration</th><th>Fogging Systems</th><th>Power Generation Equipment</th><th>Power Metal Precision Components</th><th>Industrial Hoses</th><th>Waste Services</th><th>Industrial Safety</th><th>Industrial Supply Distribution</th><th>Materials Supply</th><th>Non-Destructive Testing</th><th>Packaging</th><th>Paper</th><th>Pipe Rehabilitation</th><th>Pipe Manufacturing</th><th>Plastics</th><th>Power Supplies</th><th>Print Packaging</th><th>Remediation</th><th>Rendering</th><th>Shock Absorption</th><th>Steel</th><th>Tank Manufacturing</th><th>Testing Equipment Manufacturing</th><th>Other</th><th>Information Technology</th><th>Fiber Optics</th><th>IT Consulting</th><th>Network Infrastructure</th><th>Other</th><th>Metals & Mining</th><th>Aluminum Extrusion</th><th>Open Pit Mining (Minerals)</th><th>Other</th><th>Security Products & Services</th><th>Corrections</th><th>Prison Services</th><th>Other</th><th>Software</th><th>Enterprise Software</th><th>Software Security</th><th>Other</th><th>Telecom</th><th>Telecom Consulting</th><th>Other</th><th>Tranportation & Storage</th><th>Automotive Aftermarket</th><th>Bulk Coal Handling & Storage</th><th>Bulk Storage & Materials Handing</th><th>Petrochemical Distribution</th><th>Contract Carrier</th><th>Diesel Distributor</th><th>Terminals & Terminal Operators</th><th>Fluid Handling</th><th>Liquid Transportation & Storage</th><th>Logistics</th><th>Third Party Logistics (3PL)</th><th>Marine Services</th><th>Marine Transportation & Logistics</th><th>Pipeline Transportation</th><th>Rail Transport & Storage</th><th>Rail Switching & Short-line Railroads</th><th>Railroad Operation</th><th>Railroad Services</th><th>RFID & Tracking Systems</th><th>Supply Chain Management</th><th>Transloading</th><th>Warehousing & Storage</th><th>Other</th>
-->
    </thead>
    <tbody>
      <?php
while ($get_info = mysql_fetch_row($result)) { 
	print "<tr>\n"; 
	?>
      <?php
	foreach ($get_info as $i=>$field) {

		$cls='cell';
		if($i==6)
			$cls='cellD';		
		if($i==15)
			$cls='cellPD';		
		if($i==2)
			$cls='cellN';
		if($i==4)
			$cls='cellPD';
		if($i==5)
			$cls='cellW';
		//if($i==1)
		//	$cls='cellN';
		 if(!$hideRows||in_array($i,$showColRay))
		 	print "\t<td><div id=\"about\" class=\"nano\"><div class='$cls content col{$i}'>$field</div></div></td>\n"; 
		if(false) {		//if($i==0) {
			?>
      <!--
<td>
<div class="cellPD">
<i>Interchem</i>:	Leading producer of veterinary products in North Africa
<br><i>Medis</i>:	Medis laboratories are a pharmaceutical company producing and marketing high quality generic products. Although its relatively of  young age, it's know how to develop a wide range of strategically important products, has placed the company in a leading position within the local pharmaceutical industry.
<br><i>Nouvelair</i>:	NOUVELAIR is an airline charter company which has taken over the activities of AIR LIBERTE (Tunisia) .The success of the company comes from the development of the Tunisian tourism market, a rigorous manage-ment style and privileged relations with Tour Operators, including partnerships with several of them.
<br><i>Tunisavia</i>:	TUNISAVIA is an airline company specialized in charter flights and helicopter transport mainly on behalf of oil companies. Its fleet consists of three19-seat planes and five helicopters. The company maintained for a long time high activity levels and distributed substantial dividends.
<br><i>Tecno Catering</i>:	The BAGUETTE & BAGUETTE line is to offer a large variety of sandwiches, beverages, cakes and recently 'Reed?s' ice cream
<br><i>STHS</i>:	Hotel management.
<br><i>Sti (Accor) Hotels</i>:	Hotel Management.
<br><i>Tunisie Factoring</i>:	Leading Factoring company in Tunisia.
<br><i>Tunisie Valeurs</i>:	TUNISIE VALEURS is a stockbrokerage firm that offers a large range of financial services to individuals, companies and institutional investors. To individuals, TUNISIE VALEURS offers several formulas from the simple custody of securities to personalized portfolio management. It manages more than 1 billion dinars in the form of Mutual Funds, Securities Accounts and a variety of managed portfolio accounts: OPTIMA, CEA, CGP. To companies, TUNISIE VALEURS offers services to raise funds either in the form of equity or bonds. It arranges as well listing of companies on the Tunisian Stock Exchange. Its credentials include the largest number of issues made by a single stockbroker in Tunisia and numerous assignments in the area of mergers and acquisitions.
<br><i>Sunsource Holdings, Inc</i>:	SunSource is the largest independent distributor of fluid power products and systems in the United States. Through 38 locations nationwide, SunSource also provides complementary value-added services including the engineering and design of fluid power systems for OEMs, assembly, repair and technical training. SunSource sells 100,000 unique products manufactured by 300 leading vendors to more than 17,000 customers. The company is headquartered in Addison, Illinois.
<br>
</div>

</td>            
       -->
    </tbody>
  </table>
  <?php
		}
	}
	print "</tr>\n"; 
} 
//print "</table>\n"; 
	
}
?>
  <br>
  <br>
</div>

<!--
  <script type="text/javascript" src="js/nanoscroller/bin/javascripts/overthrow.min.js"></script>
  <script type="text/javascript" src="js/nanoscroller/bin/javascripts/jquery.nanoscroller.js"></script>
  <script type="text/javascript" src="js/nanoscroller/bin/javascripts/main.js"></script>-->
</body>
</html>
