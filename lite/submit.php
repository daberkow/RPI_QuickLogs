<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	// Updated from PHP 5 to PHP 7, Joshua Rosenfeld, rosenj5@rpi.edu, jomaxro@gmail.com, Jan 2017
	//Submit handles when jobs are sent in as done, and options changing
	
	include '../core.php';
	
	//Inserting a log into the log table
	if(isset($_REQUEST['Task_ID']))
	{
		$mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
	
		if (phpCAS::isAuthenticated())
		{
			$result = mysqli_query($mysqli, "INSERT INTO `QuickLogs`.`Logs` (`timestamp`, `type`, `userid`) VALUES ((SELECT UNIX_TIMESTAMP()), " . $_REQUEST['Task_ID'] . ", (SELECT `ID` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "' LIMIT 1))");
		}else{
			$result = mysqli_query($mysqli, "INSERT INTO `QuickLogs`.`Logs` (`timestamp`, `type`, `userid`) VALUES ((SELECT UNIX_TIMESTAMP()), " . $_REQUEST['Task_ID'] . ", 0);");
		}
		//The default user is user 0, this means user 0 HAS to be blank
		if($result)
		{
			$new_result = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordNumber FROM `Logs`");
			if ($new_result)
			{
				$row = mysqli_fetch_array($new_result);
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
		if (isset($_REQUEST['Box1']) AND isset($_REQUEST['Box2']) AND isset($_REQUEST['Box3']) AND isset($_REQUEST['Box4']) AND isset($_REQUEST['Box5']) AND isset($_REQUEST['Box6']) AND isset($_REQUEST['Box7']) AND isset($_REQUEST['Box8']) AND isset($_REQUEST['Box9']) AND isset($_REQUEST['Box10']))
		{
			$mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
			
			if(isset($_REQUEST['Admin']) AND phpCAS::isAuthenticated())
			{
				$admin_check = mysqli_query($mysqli, "SELECT `type` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "'");
				if ($admin_check)
				{
					$row = mysqli_fetch_array($admin_check);
					if ($row['type'] == "1")
					{
						$result = mysqli_query($mysqli, "UPDATE `QuickLogs`.`display` SET `Box1`='" . $_REQUEST['Box1'] . "', `Box2`='" . $_REQUEST['Box2'] . "', `Box3`='" . $_REQUEST['Box3'] . "', `Box4`='" . $_REQUEST['Box4'] . "', `Box5`='" . $_REQUEST['Box5'] . "', `Box6`='" . $_REQUEST['Box6'] . "', `Box7`='" . $_REQUEST['Box7'] . "', `Box8`='" . $_REQUEST['Box8'] . "', `Box9`='" . $_REQUEST['Box9'] . "', `Box10`='" . $_REQUEST['Box10'] . "' WHERE `user`=0");
						
						if ($_POST['Customize_On'])
						{
							mysqli_query($mysqli, "UPDATE `QuickLogs`.`Settings` SET `Active`='0' WHERE `setting`='1'");
						}else{
							mysqli_query($mysqli, "UPDATE `QuickLogs`.`Settings` SET `Active`='1' WHERE `setting`='1'");
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
				$result = mysqli_query($mysqli, "UPDATE `QuickLogs`.`display` SET `Box1`='" . $_REQUEST['Box1'] . "', `Box2`='" . $_REQUEST['Box2'] . "', `Box3`='" . $_REQUEST['Box3'] . "', `Box4`='" . $_REQUEST['Box4'] . "', `Box5`='" . $_REQUEST['Box5'] . "', `Box6`='" . $_REQUEST['Box6'] . "', `Box7`='" . $_REQUEST['Box7'] . "', `Box8`='" . $_REQUEST['Box8'] . "', `Box9`='" . $_REQUEST['Box9'] . "', `Box10`='" . $_REQUEST['Box10'] . "' WHERE `user`=(SELECT `ID` FROM `Users` WHERE `username`='" . phpCAS::getUser() . "' LIMIT 1)");
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