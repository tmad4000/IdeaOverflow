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
				var table="<table class='table'><tr><th>Email</th></tr>";
				var data = $.parseJSON(localStorage.getItem("user_data"));
				for (i=0;i<data.length;i++){
					table+="<tr><td>"+data['email']+"</td></tr>";
				}
				table += "</table>
				$("#user_data").html(table);
			}
		}

	</script>

</head>
<body onLoad="load()">
<div class="container">

	<div class="well">
	<h1>IdeaOverflow <?php if($logged_in){echo "<a id='logout' class='pull-right' href='#'><button class='btn btn-primary'>Log Out</button></a>";}?></h1>
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

	<?php 
		if(!$logged_in){echo '<button id="hackMode" class="btn btn-block btn-large" onclick="toggleHack()" value="off">Enable Hack Mode</button>';}
		else {echo '<div id="user_data"></div>';}
	?>
	
</div>

</body>
</html>
