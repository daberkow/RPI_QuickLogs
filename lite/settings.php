<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	include '../core.php';
	
	/// This will go and fetch the default display, that relies on the `display` table index 0 being set with boxes
	function get_default()
	{
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
	
	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
	
	// SSL!
	phpCAS::setCasServerCACert("../cas-auth.rpi.edu");
	
	QuickLogs::db_connect();
	
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
			{
				$def_OPTIONS = get_default();
				$admin=true;
			}
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
			$Button_Description = get_customized();
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
	//Exept when page needs it again anyway
	//QuickLogs::db_disconnect();

?>


<html>
	<head>
		<title class = "title">QuickLogs</title>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
		<link href="http://www.rpi.edu/favicon.ico" type="image/ico" rel="icon">
		<script src="../jquery.js"></script>
		<script>
			var Changed_Items=new Array();
			function submit_options(passed_index) {
				$.ajax({
						type: 'POST',
						url: "./submit.php",
						data: {Task_ID: passed_index},
						success: function(data) {
							$("#result").html(data);
						},
					});
			}
			
			function change_option(passed_ID, passed_started_checked) {
				//Passed_started_checked comes in as what the check box was origianlly, so 1 is checked and 0 is not
				var New_Box_setting;
				if (typeof Changed_Items[passed_ID] === 'undefined') {
					New_Box_setting = (passed_started_checked + 1) % 2;
					
					Changed_Items[passed_ID] = New_Box_setting;
				}else{
					New_Box_setting = (Changed_Items[passed_ID] + 1) % 2;
					
					Changed_Items[passed_ID] = New_Box_setting;
				}
			
				$("#result").html(New_Box_setting);
					$.ajax({
						type: 'POST',
						url: "./change.php",
						data: {Part: passed_ID, Change_To: New_Box_setting},
						success: function(data) {
							$("#result").html(data);
						},
					});
				
			}
			</script>
	</head>
	<body>
		<div id="main">
			<div id="title">
				<a href="./index.php"><div id="logo">QuickLogs</div></a>
				<div id="result"></div>
			</div>
			<form action="./submit.php" method="post">
			<?PHP 
				if (!$Customize)
					echo "Custom Loaded but not in use";
					
				//removed mysql disconenct and reconnect	
					
				$result = mysql_query("SELECT `index`,`problem` FROM `Types` WHERE `disabled`=0 LIMIT 0, 100"); //limit just in case
				//error_reporting(E_ALL);
				$OPTIONS = array();
				$OPTIONS_ID = array();
				if($result)
				{
					while ($row = mysql_fetch_array($result))
					{
						//echo $row['problem'] . $row['index'];
						array_push($OPTIONS, $row['problem']);
						array_push($OPTIONS_ID, $row['index']);
						//echo $OPTIONS[count($OPTIONS)];
					}
				}
			?>
				<h3>My Options</h3>
				<div id="row">
					<a class="links"><div id="left" ><select name='Box1' id='Box1'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["1ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
					<a class="links"><div id="right" ><select name='Box2' id='Box2'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["2ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
				</div>
				<div id="row">
					<a class="links"><div id="left" ><select name='Box3' id='Box3'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["3ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
					<a class="links"><div id="right" ><select name='Box4' id='Box4'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["4ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
				</div>
				<div id="row">
					<a class="links"><div id="left" ><select name='Box5' id='Box5'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["5ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
					<a class="links"><div id="right" ><select name='Box6' id='Box6'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["6ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
				</div>
				<div id="row">
					<a class="links"><div id="left" ><select name='Box7' id='Box7'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["7ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
					<a class="links"><div id="right" ><select name='Box8' id='Box8'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["8ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
				</div>
				<div id="row">
					<a class="links"><div id="left" ><select name='Box9' id='Box9'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["9ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
					<a class="links"><div id="right" ><select name='Box10' id='Box10'>
						<?PHP 
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							if ($Button_Description["10ID"] == $OPTIONS_ID[$i])
							{
								echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
							}else{
								echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
							}
						}
						?></select></div></a>
				</div>
				<div id="buttonz">
					<input TYPE="submit" id="cmdSubmit" VALUE="Update Settings"/>
				</div>
			</form>
			<?PHP
			
			if ($admin)
			{
				echo "<hr>
						<h3>All Users Default</h3>
						<form action='./submit.php' method='post'>
							<input type='hidden' name='Admin' id='Admin' value='Admin'>
							<input type='checkbox' id='Customize_On' name='Customize_On' value='Customize_On' "; if ($Customize) {echo "checked";} 
				echo		"/> Allow Users to Customize Their Options
							<div id='row'>
								<a class='links'><div id='left' ><select name='Box1' id='Box1'>";
									
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["1ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
								<a class='links'><div id='right'><select name='Box2' id='Box2'>";
									
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["2ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
							</div>
							<div id='row'>
								<a class='links'><div id='left'><select name='Box3' id='Box3'>";
				
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["3ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
								<a class='links'><div id='right' ><select name='Box4' id='Box4'>";
									 
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["4ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo					"</select></div></a>
							</div>
							<div id='row'>
								<a class='links'><div id='left' ><select name='Box5' id='Box5'>";
									 
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["5ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
								<a class='links'><div id='right' ><select name='Box6' id='Box6'>";
									 
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["6ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo					"</select></div></a>
							</div>
							<div id='row'>
								<a class='links'><div id='left' ><select name='Box7' id='Box7'>";

									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["7ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
								<a class='links'><div id='right' ><select name='Box8' id='Box8'>";
									
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["8ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
							</div>
							<div id='row'>
								<a class='links'><div id='left' ><select name='Box9' id='Box9'>";
							
							for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["9ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
								<a class='links'><div id='right' ><select name='Box10' id='Box10'>";
									
									for($i = 0; $i < count($OPTIONS); $i++)
									{
										if ($def_OPTIONS["10ID"] == $OPTIONS_ID[$i])
										{
											echo "<option value=" . $OPTIONS_ID[$i] . " selected='selected'>" . $OPTIONS[$i] . "</option>";
										}else{
											echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
										}
									}
				echo				"</select></div></a>
							</div>
							
							<div id='buttonz'>
									<input TYPE='submit' id='cmdSubmit' VALUE='Update Settings'/>
							</div>
						</form>
						<hr>
						<p>Enabled Options(reload page to make selectable):</p>";

						$result = mysql_query("SELECT `index`,`problem` FROM `Types` WHERE `disabled`<'2' LIMIT 0, 100"); //limit just in case
						//error_reporting(E_ALL);
						$OPTIONS = array();
						$OPTIONS_ID = array();
						if($result)
						{
							while ($row = mysql_fetch_array($result))
							{
								//echo $row['problem'] . $row['index'];
								array_push($OPTIONS, $row['problem']);
								array_push($OPTIONS_ID, $row['index']);
								//echo $OPTIONS[count($OPTIONS)];
							}
						}
						
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							//Trying to work on split, at this point for the few times this is used, a list is good
							echo "<div id='selection_of_options" . 0 . "'>";
							echo 	"<input type='checkbox' value=" . $OPTIONS_ID[$i] . " onclick='change_option(" . $OPTIONS_ID[$i];
							
							$result = mysql_query("SELECT `disabled` FROM `Types` WHERE `index`='" . $OPTIONS_ID[$i] . "'");
							
							if($result)
							{
								$row = mysql_fetch_array($result);
								if ($row['disabled'] == "0")
								{
									echo ",0)' checked";
								}else{
									echo ",1)' ";
								}
							}else{
								echo ")' ";
							}
							
							echo "/>" . $OPTIONS[$i] . "";
							echo "</div>";
						}
						
						
						echo "<p>New Option:</p><form action='./change.php' method='post'>
							<input class='input_box' type='text' name='New_term' id='New_term'/>
						<input TYPE='submit' id='cmdSubmit' VALUE='New Option'/></form>";
						
						
						echo "<p>Delete Option:</p><form action='./change.php' method='post'><select name='Kill' id='Kill'>";
						for($i = 0; $i < count($OPTIONS); $i++)
						{
							echo "<option value=" . $OPTIONS_ID[$i] . ">" . $OPTIONS[$i] . "</option>";
						}
						echo "</select><input TYPE='submit' id='cmdSubmit' VALUE='Delete Option'/></form>";
				}
			?>
			<hr>
			<div id="footer">
				<div id="Stats">					
				<?PHP 
					if (phpCAS::isAuthenticated())
					{
						echo "<a href='./logout.php' class='labels'>Logout " . phpCAS::getUser() . "</a>";
					}else
					{
						echo "<a href='./login.php' class='labels'>Login</a>";
					}
					if ($Customize || $admin) { echo "<p style='margin:0;'><a href='./settings.php' class='labels'>Settings</a></p>"; }
					
					QuickLogs::db_disconnect();
				?>	
				</div>
				<div id="version">v<?PHP echo QuickLogs::get_version(); ?> <a href="https://github.com/daberkow/QuickLogs">Source</a></a></div>
				<div id="switch_ver">
					<a href="http://j2ee7.server.rpi.edu:8080/helpdesk/stylesheets/welcome.faces" class="labels"> Send in a Ticket </a>
					<p style="margin: 0;"><a href="./stats.php" class="labels">See Stats</a></p>
				</div>
			</div>
		</div>
	</body>
</html>