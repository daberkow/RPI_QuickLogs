<?PHP
	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas/');
	
	// SSL!
	phpCAS::setCasServerCACert("cas-auth.rpi.edu");

	//Inserting a log into the log table
	if(isset($_REQUEST['Task_ID']))
	{
		mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
		mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
	
		if (phpCAS::isAuthenticated())
		{
			$result = mysql_query("INSERT INTO `QuickLogs`.`Logs` (`timestamp`, `type`, `userid`) VALUES (CURRENT_TIMESTAMP, " . $_REQUEST['Task_ID'] . ", (SELECT `ID` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "' LIMIT 1))");
		}else{
			$result = mysql_query("INSERT INTO `QuickLogs`.`Logs` (`timestamp`, `type`, `userid`) VALUES (CURRENT_TIMESTAMP, " . $_REQUEST['Task_ID'] . ", 0);");
		}
		//The default user is user 0, this means user 0 HAS to be blank
		if($result)
		{
			$new_result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs`");
			if ($new_result)
			{
				$row = mysql_fetch_array($new_result);
				echo "Recorded, entry: #" . $row['RecordNumber'];
			}else{
				echo "Recorded.";
			}
		}else{
			echo "Error Recording.";
		}
	}
	else
	{
		if (isset($_REQUEST['Box1']) AND isset($_REQUEST['Box2']) AND isset($_REQUEST['Box3']) AND isset($_REQUEST['Box4']) AND isset($_REQUEST['Box5']) AND isset($_REQUEST['Box6'])  AND isset($_REQUEST['Box7'])  AND isset($_REQUEST['Box8']))
		{
			mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
			mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
			
			if(isset($_REQUEST['Admin']) AND phpCAS::isAuthenticated())
			{
				$admin_check = mysql_query("SELECT `type` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "'");
				if ($admin_check)
				{
					$row = mysql_fetch_array($admin_check);
					if ($row['type'] == "1")
					{
						$result = mysql_query("UPDATE `QuickLogs`.`display` SET `Box1`='" . $_REQUEST['Box1'] . "', `Box2`='" . $_REQUEST['Box2'] . "', `Box3`='" . $_REQUEST['Box3'] . "', `Box4`='" . $_REQUEST['Box4'] . "', `Box5`='" . $_REQUEST['Box5'] . "', `Box6`='" . $_REQUEST['Box6'] . "', `Box7`='" . $_REQUEST['Box7'] . "', `Box8`='" . $_REQUEST['Box8'] . "' WHERE `user`=0");
						
						if ($_POST['Customize_On'])
						{
							mysql_query("UPDATE `QuickLogs`.`Settings` SET `Active`='0' WHERE `setting`='1'");
						}else{
							mysql_query("UPDATE `QuickLogs`.`Settings` SET `Active`='1' WHERE `setting`='1'");
						}
						if ($result)
						{
							header("location: ./settings.php");
						}else{
							echo "Error Saving";
						}
					}else{
						echo "PERMISSION DENIED";
					}
				}			
			}
	
			if (phpCAS::isAuthenticated() AND !isset($_REQUEST['Admin'])) // this should be true
			{
				$result = mysql_query("UPDATE `QuickLogs`.`display` SET `Box1`='" . $_REQUEST['Box1'] . "', `Box2`='" . $_REQUEST['Box2'] . "', `Box3`='" . $_REQUEST['Box3'] . "', `Box4`='" . $_REQUEST['Box4'] . "', `Box5`='" . $_REQUEST['Box5'] . "', `Box6`='" . $_REQUEST['Box6'] . "', `Box7`='" . $_REQUEST['Box7'] . "', `Box8`='" . $_REQUEST['Box8'] . "' WHERE `user`=(SELECT `ID` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "' LIMIT 1)");
				if ($result)
				{
					header("location: ./index.php");
				}else{
					echo "Error Saving";
				}
			}
		}else{
			//Wrong answers get a wait
			sleep(1);
			echo "Error No Data Passed";
		}
	}
?>