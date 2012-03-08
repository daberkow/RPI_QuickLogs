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
	
	QuickLogs::db_connect();

	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
	
	// SSL!
	phpCAS::setCasServerCACert("../cas-auth.rpi.edu");
		
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
		<script src="../jquery-1.6.2.min.js"></script> <!--Only used for easy ajax requests-->
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
							bpf('#00FF00');
						},
						error: function(data) {
							$("#result").html("ERROR");
							bpf('#FF0000');
						}
					});
					clock = (new Date().getTime());
				}
			}
		</script>
		
		<script type="text/javascript">
			<!-- change background color -->
			function changeBGC(color)
			{
				document.getElementByid('main').style.backgroundColor = color;
			}
		</script>
		
		<script type="text/javascript">
			<!-- button press feedback -->
			function bpf(color)
			{
				var old_color = document.getElementById('main').style.backgroundColor;
				changeBGC(color);
				setTimeout(changeBGC, 400, old_color);
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
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["1ID"]; ?>)'><text><p><?PHP echo $Button_Description[1]; ?></p></text></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["2ID"]; ?>)'><text><p><?PHP echo $Button_Description[2]; ?></p></text></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["3ID"]; ?>)'><text><p><?PHP echo $Button_Description[3]; ?></p></text></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["4ID"]; ?>)'><text><p><?PHP echo $Button_Description[4]; ?></p></text></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["5ID"]; ?>)'><text><p><?PHP echo $Button_Description[5]; ?></p></text></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["6ID"]; ?>)'><text><p><?PHP echo $Button_Description[6]; ?></p></text></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["7ID"]; ?>)'><text><p><?PHP echo $Button_Description[7]; ?></p></text></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["8ID"]; ?>)'><text><p><?PHP echo $Button_Description[8]; ?></p></text></div></a>
			</div>
			<div id="row">
				<a class="links" href="#"><div id="left" onclick='submit_options(<?PHP echo $Button_Description["9ID"]; ?>)'><text><p><?PHP echo $Button_Description[9]; ?></p></text></div></a>
				<a class="links" href="#"><div id="right" onclick='submit_options(<?PHP echo $Button_Description["10ID"]; ?>)'><text><p><?PHP echo $Button_Description[10]; ?></p></text></div></a>
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
				<div id="version">v3.2 <a href="https://github.com/daberkow/QuickLogs">Source</a></a></div> <!-- YAY -->
				<div id="switch_ver">
					<a href="http://j2ee7.server.rpi.edu:8080/helpdesk/stylesheets/welcome.faces" class="labels"> Send in a Ticket </a>
					<p style="margin: 0;"><a href="./stats.php" class="labels">See Stats</a></p>
				</div>
			</div>
		</div>
	</body>
</html>