<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	//Here we are changing some of the options for what options are allowed, this is a admin only panel, but the security for it is really anyone who knows and has authenticated. We are honor systeming it mostly.
	include '../core.php';
	
	//Submitting for disabling a option,
	if(phpCAS::isAuthenticated() AND isset($_REQUEST['Part']) AND isset($_REQUEST['Change_To']))
	{
		$result = mysql_query("UPDATE `QuickLogs`.`Types` SET `disabled` ='" . $_REQUEST['Change_To'] . "' WHERE `index`='" . $_REQUEST['Part'] . "'");
		echo "UPDATE `QuickLogs`.`Types` SET `disabled` ='" . $_REQUEST['Change_To'] . "' WHERE `index`='" . $_REQUEST['Part'] . "'";
		if ($result)
		{
			echo "Edited";
		}
		
	}else
	{
		//Marking a option deleted, not actually deleting for data integrety
		if (phpCAS::isAuthenticated() AND isset($_REQUEST['Kill']))
		{
			$result = mysql_query("UPDATE `QuickLogs`.`Types` SET `disabled` ='2' WHERE `index`='" . $_REQUEST['Kill'] . "'");
			if ($result)
			{
				//echo "Edited";
				header("location: ./settings.php");
			}
		}else{
			if (phpCAS::isAuthenticated() AND isset($_REQUEST['New_term'])){
				//add a option to the list
				$result = mysql_query("INSERT INTO `QuickLogs`.`Types` (`index`, `problem`, `disabled`) VALUES (NULL, '" . $_REQUEST['New_term'] . "', '0');");
				if ($result)
				{
					//echo "Edited";
					header("location: ./settings.php");
				}
			}else{
				echo "No Data Passed";
			}
		}
	}
	
	QuickLogs::db_disconnect();
?>