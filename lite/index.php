<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	/// This will go and fetch the default display, that relies on the `display` table index 0 being set with boxes
	function get_default()
	{
		$Customize = false;		//Dont allow customization
		$result = mysql_query("SELECT * FROM `display` WHERE `user`='0' LIMIT 1");	
		if($result)
		{
			//successful
			$row = mysql_fetch_array($result); //Should be run once
			
			for($i = 1; $i < 11; $i++) //run through the boxes
			{
				$Button_Description[$i . "ID"] = $row['Box' . $i];
				$why_bool = mysql_query("SELECT `problem` FROM `Types` WHERE `index`='" . $row['Box' . $i] . "' AND `disabled`=0 LIMIT 1");
				$temp_holding = mysql_fetch_array($why_bool);
				$Button_Description[$i] = $temp_holding['problem'];
			}
			return $Button_Description;
		}
	}
	
	//We get to try to do custimization, Im not a english major
	function get_customized()
	{
		if(phpCAS::isAuthenticated())
		{
			$result = mysql_query("SELECT * FROM `display` WHERE `user`=(SELECT `ID` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "' LIMIT 1)");
			if($result)
			{
				//successful
				$row = mysql_fetch_array($result); //Should be run once
				for($i = 1; $i < 11; $i++)
				{
					$Button_Description[$i . "ID"] = $row['Box' . $i];
					$why_bool = mysql_query("SELECT `problem` FROM `Types` WHERE `index`='" . $row['Box' . $i] . "' AND `disabled`=0 LIMIT 1");
					$temp_holding = mysql_fetch_array($why_bool);
					$Button_Description[$i] = $temp_holding['problem'];
				}
				return $Button_Description;
			}
		}else{
			//if you arent logged in CAS then you get default
			return get_default();
		}
	}
	
	include '../core.php';
		
	//Assume that they arent a admin, then if they have authenicated take a look
	$admin=false;
	if (phpCAS::isAuthenticated())
	{
		$result = mysql_query("SELECT `type` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "' LIMIT 1");
		if($result)
		{
			//successful
			$row = mysql_fetch_array($result); //Should be run once
			if ($row['type'] == "1")
				$admin=true;
		}
	}
	
	//See if they are allowed custome settings, if they are try to get them.
	$settings = mysql_query("SELECT `Active` FROM `Settings` WHERE `setting`=1");
	$Button_Description = array();
	if ($settings AND phpCAS::isAuthenticated())
	{
		$row = mysql_fetch_array($settings);
		if ($row['Active'] == "1")//forces same options
		{
			$Button_Description = get_default();
			$Customize = false;
		}else{
			$Button_Description = get_customized();
			$Customize = true;
		}
	}else{
		$Button_Description = get_default();
		$Customize = false;
	}
	//Closing connections is always good
	QuickLogs::db_disconnect();
	
?>

<html>
	<head>
		<title class = "title">QuickLogs</title>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
		<link href="http://www.rpi.edu/favicon.ico" type="image/ico" rel="icon">
		<script src="../jquery.js"></script> <!--Only used for easy ajax requests-->
		<script>
			// Easy Way to change and not need to change pages
			//Clock and new clock were added cause touch screen kept double posting
			var clock = 0;
			function submit_options(passed_index) {
				var new_clock = ((new Date().getTime()));
				if ((clock+500)<=new_clock)
				{
					$.ajax({
						type: 'POST',
						url: "./submit.php",
						data: {Task_ID: passed_index},
						success: function(data) {
							$("#result").html(data);
							alert_user();
						},
						error: function(data) {
							$("#result").html("ERROR");
							$("#result").css("background", "red");
						}
					});
					clock = (new Date().getTime());
				}
			}
			
			function alert_user()
			{
				var color = parseInt('00ff00', 16);
				var new_color = "#" + color;
				$("#result").css("background", new_color);
				recurse_alert(color);
				
			}
			
			function recurse_alert(old_colour)
			{//old color is hex, the color is a int, new color is a string
				var the_color = old_colour + parseInt("111111", 16);
				var new_color = "#" + the_color.toString(16);
				while (new_color.length < 7)
				{
					new_color = "#0" + new_color.substr(1, new_color.length - 1);
				} 
				//$("#result").append("<p>old: " + the_color + " New: " + new_color + " " + parseInt("111111", 16).toString() + " </p>");
				$("#result").css("background", new_color);
				if( the_color<=15658734)
				{
					setTimeout(	"recurse_alert(" + the_color + ")", 50 );
				}else{
					$("#result").css("background", "white");
				}
			}
		</script>
	</head>
	<body>
		<!-- DIVS! -->
		<div id="main">
			<div id="title">
				<div class="logo"></div>
				<a href="./index.php"><div id="logo">QuickLogs</div></a>
				<div id="result"></div>
			</div>
			<div class="red_bar"></div>
			<div class="gray_bar"></div>
			<!-- Here are all my rows, and the 8 buttons -->
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["1ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[1]; ?></p></div></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["2ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[2]; ?></p></div></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["3ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[3]; ?></p></div></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["4ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[4]; ?></p></div></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["5ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[5]; ?></p></div></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["6ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[6]; ?></p></div></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["7ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[7]; ?></p></div></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["8ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[8]; ?></p></div></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["9ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[9]; ?></p></div></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["10ID"]; ?>)'><div id='text'><p><?PHP echo $Button_Description[10]; ?></p></div></div></a>
			</div>
			<!-- NEW SECTION! -->
			<hr>
			<div id="footer">
				<div id="Stats">					
					<?PHP 
						if (phpCAS::isAuthenticated())
						{//Authenacted users get logout
							echo "<a href='./logout.php' class='labels'>Logout " . phpCAS::getUser() . "</a>";
						}else
						{
							echo "<a href='./login.php' class='labels'>Login</a>";
						}
						//Admins or people who can customize get settings
						if ($Customize || $admin) { echo "<p style='margin:0;'><a href='./settings.php' class='labels'>Settings</a></p>"; }
					?>	
				</div>
				<div id="version">v<?PHP echo QuickLogs::get_version(); ?> <a href="https://github.com/daberkow/QuickLogs">Source</a></a></div> <!-- YAY -->
				<div id="switch_ver">
					<a href="http://j2ee7.server.rpi.edu:8080/helpdesk/stylesheets/welcome.faces" class="labels"> Send in a Ticket </a>
					<p style="margin: 0;"><a href="./stats.php" class="labels">See Stats</a></p>
				</div>
			</div>
		</div>
	</body>
</html>