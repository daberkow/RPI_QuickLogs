<?php
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	// Updated from PHP 5 to PHP 7, Joshua Rosenfeld, rosenj5@rpi.edu, jomaxro@gmail.com, Jan 2017
	include '../core.php';
	 $mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
	if (!isset($_REQUEST['chart']))
	{
		echo "Invalid Post";
		return;
	}
	switch ($_REQUEST['chart']) {
		case "excel_6months":
			header("Content-type: application/csv; ");
			header("Content-Disposition: attachment; filename=\"Helpdesk_QuickLogs_6mth.csv\""); 
			
			echo "timestamp,problem,user\n";
			
			$users = array ();
			$problems = array();
			$new_result = mysqli_query($mysqli, "SELECT `ID`,`username` FROM `Users`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					$users[$row['ID']] = $row['username'];
				}
			}
			$new_result = mysqli_query($mysqli, "SELECT `index`,`problem` FROM `Types`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					$problems[$row['index']] = $row['problem'];
				}
			}
			$new_result = mysqli_query($mysqli, "SELECT * FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - (6 * 30 * 24 * 60 * 60));");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					echo $row['timestamp'] . "," . $problems[$row['type']] . "," . $users[$row['userid']] . "\n";
				}
			}
	
			break;
			
		case "excel_12months":
			header("Content-type: application/csv; ");
			header("Content-Disposition: attachment; filename=\"Helpdesk_QuickLogs_12mth.csv\""); 
			
			echo "timestamp,problem,user\n";
			
			$users = array ();
			$problems = array();
			$new_result = mysqli_query($mysqli, "SELECT `ID`,`username` FROM `Users`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					$users[$row['ID']] = $row['username'];
				}
			}
			$new_result = mysqli_query($mysqli, "SELECT `index`,`problem` FROM `Types`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					$problems[$row['index']] = $row['problem'];
				}
			}
			$new_result = mysqli_query($mysqli, "SELECT * FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - (12 * 30 * 24 * 60 * 60));");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					echo $row['timestamp'] . "," . $problems[$row['type']] . "," . $users[$row['userid']] . "\n";
				}
			}
	
			break;
			
		case "excel_all":
			header("Content-type: application/csv; ");
			header("Content-Disposition: attachment; filename=\"Helpdesk_QuickLogs_all.csv\""); 
			
			echo "timestamp,problem,user\n";
			
			$users = array ();
			$problems = array();
			$new_result = mysqli_query($mysqli, "SELECT `ID`,`username` FROM `Users`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					$users[$row['ID']] = $row['username'];
				}
			}
			$new_result = mysqli_query($mysqli, "SELECT `index`,`problem` FROM `Types`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					$problems[$row['index']] = $row['problem'];
				}
			}
			$new_result = mysqli_query($mysqli, "SELECT * FROM `Logs`;");
			if ($new_result)
			{
				while ($row = mysqli_fetch_array($new_result))
				{
					echo $row['timestamp'] . "," . $problems[$row['type']] . "," . $users[$row['userid']] . "\n";
				}
			}
			break;
		case "json_activity":
			$returning_Data = array();
			if (isset($_REQUEST['startTime']) && isset($_REQUEST['endTime']))
			{
				$new_result = mysqli_query($mysqli, "SELECT DISTINCT `type` AS Type_ID FROM `Logs` WHERE `timestamp`>(" . mysqli_real_escape_string($mysqli, $_REQUEST['startTime']) . ") AND `timestamp`<(" . mysqli_real_escape_string($mysqli, $_REQUEST['endTime']) . ");");
				//echo "SELECT DISTINCT `type` AS Type_ID FROM `Logs` WHERE `timestamp`>(" . mysql_real_escape_string($_REQUEST['startTime']) . ") AND `timestamp`<(" . mysql_real_escape_string($_REQUEST['endTime']) . ");";
				if ($new_result)
				{
					if (isset($_REQUEST['id']))
					{
						array_push($returning_Data, $_REQUEST['id']);
					}
					while ($row = mysqli_fetch_array($new_result))
					{
						$result = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `type`='" . $row['Type_ID'] . "' AND `timestamp`>(" . mysqli_real_escape_string($mysqli, $_REQUEST['startTime']) . ") AND `timestamp`<(" . mysqli_real_escape_string($mysqli, $_REQUEST['endTime']) . ");");
						if ($result)
						{
							$rowz = mysqli_fetch_array($result);	
							$name = mysqli_query($mysqli, "SELECT `problem` FROM `Types` WHERE `index`='" . $row['Type_ID'] . "'");
							if ($name)
							{
								$rowy = mysqli_fetch_array($name);
								$tempArray = array();
								array_push($tempArray, $rowy['problem']);
								
								array_push($tempArray, intval($rowz['RecordNumber']));
								array_push($returning_Data, $tempArray);
								
							}else{
								$tempArray = array();
								array_push($tempArray, $row['Type_ID']);
								array_push($tempArray, intval($rowz['RecordNumber']));
								array_push($returning_Data, $tempArray);
							}	
						}		
					}
					echo json_encode($returning_Data);
				}else{
					echo "Error with request";
				}
				
			}else{
				echo "Error with request";
			}
			break;
		case "json_total":
			$Returning_array = array();
			$labels_element = array();
			$data_element = array();
			$result = database_helper::db_return_array("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - " . 86400 . ");");
			array_push($labels_element, "24 Hours");
			array_push($data_element, intval($result[0][0]));
			
			$result = database_helper::db_return_array("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - " . (86400*7) . ");");
			array_push($labels_element, "7 Days");
			array_push($data_element, intval($result[0][0]));
			
			$result = database_helper::db_return_array("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - " . (86400*30) . ");");
			array_push($labels_element, "30 Days");
			array_push($data_element, intval($result[0][0]));
			
			$result = database_helper::db_return_array("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - " . (86400*90) . ");");
			array_push($labels_element, "90 Days");
			array_push($data_element, intval($result[0][0]));
			
			$result = database_helper::db_return_array("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>((SELECT UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) - " . (86400*365) . ");");
			array_push($labels_element, "365 Days");
			array_push($data_element, intval($result[0][0]));
			
			$result = database_helper::db_return_array("SELECT COUNT(*) AS RecordNumber FROM `Logs`;");
			array_push($labels_element, "All Time");
			array_push($data_element, intval($result[0][0]));
			
			array_push($Returning_array, $labels_element);
			array_push($Returning_array, $data_element);
			
			echo json_encode($Returning_array);
			break;
		case "json_user":
			if (isset($_REQUEST['startTime']) && isset($_REQUEST['endTime']))
			{
				$returned_result = array();
				$new_result = mysqli_query($mysqli, "SELECT DISTINCT `userid` AS User_ID FROM `Logs` WHERE `timestamp`>(" . mysqli_real_escape_string($mysqli, $_REQUEST['startTime']) . ") AND `timestamp`<(" . mysqli_real_escape_string($mysqli, $_REQUEST['endTime']) . ");");
				if ($new_result)
				{
					while ($row = mysqli_fetch_array($new_result))
					{
						$result = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `userid`='" . $row['User_ID'] . "' AND `timestamp`>(" . mysqli_real_escape_string($mysqli, $_REQUEST['startTime']) . ") AND `timestamp`<(" . mysqli_real_escape_string($mysqli, $_REQUEST['endTime']) . ");");
						if ($result)
						{
							$rowz = mysqli_fetch_array($result);
							$name = mysqli_query($mysqli, "SELECT `username` FROM `Users` WHERE `ID`='" . $row['User_ID'] . "';");
							if ($name)
							{
								$rowy = mysqli_fetch_array($name);
								$thisRow = array();
								array_push($thisRow, $rowy['username']);
								array_push($thisRow, intval($rowz['RecordNumber']));
								array_push($returned_result, $thisRow);
							}else{
								$thisRow = array();
								array_push($thisRow, $row['User_ID']);
								array_push($thisRow, intval($rowz['RecordNumber']));
								array_push($returned_result, $thisRow);
							}
						}
					}
					echo json_encode($returned_result);
				}else{
					echo "Error in lookup";
				}
			}else{
				echo "Invalid Request";
			}
			break;
		case "json_trend":
			$hashArray = array();
			$start = time() - (60*60*24*7);
			$end = time();
			$returned_result = array();
			$new_result = database_helper::db_return_array("SELECT * FROM  `Types`");
			foreach($new_result as $row)
			{
				$hashArray[$row['index']] = $row['problem'];
			}
			for ($i = 0; $i < 4; $i++)
			{
				$thisweek = array();
				$new_result = database_helper::db_return_array("SELECT DISTINCT `type` AS Type_ID FROM `Logs` WHERE `timestamp`>(" . $start . ") AND `timestamp`<(" . $end . ");");
				
				foreach($new_result as $thisItem)//0 is type
				{
					$result = database_helper::db_return_array("SELECT COUNT(`timestamp`) FROM `Logs` WHERE `type`='" . $thisItem[0] . "' AND `timestamp`>(" . $start . ") AND `timestamp`<(" . $end . ");");
					//confused here, stopped here
				}
				echo ",";
				$start = $start - (60*60*24*7);
				$end = $end - (60*60*24*7);
			}
				
			break;
	}
	
	QuickLogs::db_disconnect($mysqli);
	?>