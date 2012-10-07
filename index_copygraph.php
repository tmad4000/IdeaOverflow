<?php session_start();
$logged_in = 0;
if (isset($_SESSION['user_email'])){$logged_in = 1;}
else {$logged_in = 0;}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Idea Overflow</title>
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">
		navigator.geolocation.getCurrentPosition(GetLocation);
		function GetLocation(location) {
	    $.lat = location.coords.latitude;
			$.lng = location.coords.longitude;
		}

		function toggleHack(){
			var btn = $("#hackMode")
			btn.toggleClass("btn-primary")
			if (btn.val()){btn.val("on");btn.text("Disable Hack Mode");}
			else {btn.val("off");btn.text("Enable Hack Mode");}
		}

		function cont(){
			$.ajax({"url":"hackmodeonoff.php",
				"data":{"status":$("#hackMode").val(),"user_email":$("#email").val(),"lat":$.lat,"lng":$.lng},
				"success":function(data){
					localStorage.setItem("user_data", data);
					window.location.reload();
				}
			})
		}

		function load(){
			if (localStorage.getItem("user_data") != null){
				var table="<table class='table'><tr><th>Email</th><th>Login Time</th></tr>";
				var data = $.parseJSON(localStorage.getItem("user_data"));
				for (i=0;i<data.length;i++){
					var time = new Date(data[i]["status_update_time"]*1000);
					table+="<tr><td><a href='mailto:"+data[i]['email']+"'>" + data[i]['email'] + "</a> </td><td>"+time.getHours()+":"+time.getMinutes()+" "+(time.getMonth()+1)+"/"+time.getDate()+"</td></tr>";
				}
				table += "</table>";
				$("#user_data").html(table);
			}
		}

	</script>

</head>
<body onLoad="load()">
<div class="container">

	<div class="well">
	<h1><a border="0" href="http://ideaoverflow.tk"><img src="ideagraphpaintico.jpg" height="50px" width="50px" /></a> IdeaOverflow<?php if($logged_in){echo "<a id='logout' class='pull-right' href='#'><button class='btn btn-primary'>Log Out</button></a>";}?> <br>
<a href="http://instadefine.com/IdeaOverflow/ATTHackathon/git/IdeaOverflow/index_copygraph.php" style="font-size:16px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Projects_</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://hackathonprojects.tk" style="font-size:16px" target="_blank">HackathonProjects.tk</a></h1>
	</div>
	<div "width:100px;float:right">
		<?php 
			if($logged_in) {echo "<p class='lead'>Welcome {$_SESSION['user_email']}!";} 
			else {
		?>
		<div class="input-append">
			<input class="span11" id="email" type="text" placeholder="Enter email to proceed"><button class="btn" type="button" onClick="cont()">Go!</button></input>
		</div>
		<?php
			}
		?>
	</div>
	
	<br />

	<iframe src="http://instadefine.com/IdeaOverflow/ATTHackathon/git/IdeaOverflow/IdeaGrapherFishEye3/VisionCharter0.2.htm" height="600px" width="100%" scrolling="no"></iframe>
<iframe src="https://docs.google.com/document/d/1sZEa_24vyRoihwJS4eWxCMuuT3DwpXBHpIYJRsx0RE4/edit#" height="600px" width="100%"></iframe>

	<?php 
	if(!$logged_in){
//		echo '<button id="hackMode" class="btn btn-block btn-large" onclick="toggleHack()" value="off">Enable Hack Mode</button>';
}
		else {
//			echo '<button id="hackMode" class="btn btn-block btn-large" onclick="toggleHack()" value="off">Disable Hack Mode</button>';
			echo '<div id="user_data"></div>';}
	?>
	
</div>

</body>
</html>
