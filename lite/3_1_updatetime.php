<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	//This file is to update a 3.0 database to a 3.1 database, only use once, then delete file
	
	include '../core.php';

	QuickLogs::db_connect();
	
	$why_bool = mysql_query("SELECT * FROM `Logs`");
	while ($temp_holding = mysql_fetch_array($why_bool))
	{
		echo "<p>Converting " . $temp_holding['timestamp'];
		
		$position = strpos($temp_holding['timestamp'], "-");
 
		if ($position === false)
		{
		    echo "Not found</p>";
		}else{
		
		    echo "Match found ";
		    $new_data = mysql_query("INSERT INTO `QuickLogs`.`Logs` (`timestamp`, `type`, `userid`) VALUES ((SELECT UNIX_TIMESTAMP('" . $temp_holding['timestamp'] . "')), '" . $temp_holding['type'] . "', '" . $temp_holding['userid'] . "');");
		    if ($new_data)
		    {
		    	//inserted now delete old log
		    	$new_delete = mysql_query("DELETE FROM `QuickLogs`.`Logs` WHERE `Logs`.`timestamp` = '" . $temp_holding['timestamp'] . "' AND `Logs`.`type` = " . $temp_holding['type'] . " AND `Logs`.`userid` = " . $temp_holding['userid'] . " LIMIT 1");
			    if ($new_delete)
				{
					echo "complete</p>";
				}
		    	
		    }else{
		    	echo "convert error</p>";
		    }
	    }
		//DELETE FROM `QuickLogs`.`Logs` WHERE `Logs`.`timestamp` = '0000-00-00 00:00:00' AND `Logs`.`type` = 1 AND `Logs`.`userid` = 1 LIMIT 1
		
		
	}
				
	QuickLogs::db_disconnect();	
?>