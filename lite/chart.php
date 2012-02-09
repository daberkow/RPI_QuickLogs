<?php
	include "../libchart/classes/libchart.php";
	
	mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
	mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
	
	switch ($_REQUEST['chart']) {
		case "long":
			header("Content-type: image/png");
		
			$chart = new VerticalBarChart(500,250);
			
			$dataSet = new XYDataSet();
			
			//24 hours
			$new_result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>(CURRENT_TIMESTAMP - " . 86400 . ")");
			if ($new_result)
			{
				$row = mysql_fetch_array($new_result);
				$dataSet->addPoint(new Point("24 Hours", $row['RecordNumber']));
			}
			
			//A week
			$new_result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>(CURRENT_TIMESTAMP - " . (86400 * 7) . ")");
			if ($new_result)
			{
				$row = mysql_fetch_array($new_result);
				$dataSet->addPoint(new Point("7 Days", $row['RecordNumber']));
			}
			
			//A month
			$new_result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>(CURRENT_TIMESTAMP - " . (86400 * 30) . ")");
			if ($new_result)
			{
				$row = mysql_fetch_array($new_result);
				$dataSet->addPoint(new Point("30 Days", $row['RecordNumber']));
			}
		
			//90 Days
			$new_result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>'(CURRENT_TIMESTAMP - " . (86400 * 90) . ")';");
			if ($new_result)
			{
				$row = mysql_fetch_array($new_result);
				$dataSet->addPoint(new Point("90 Days", $row['RecordNumber']));
			}
			
			//365 Days
			$new_result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `timestamp`>'(CURRENT_TIMESTAMP - " . (86400 * 365) . ")';");
			if ($new_result)
			{
				$row = mysql_fetch_array($new_result);
				$dataSet->addPoint(new Point("365 Days", $row['RecordNumber']));
			}
			$chart->setTitle("Helpdesk Tickets");
			$chart->setDataSet($dataSet);
			$chart->render();
			break;
			
		case "short":
			header("Content-type: image/png");
			$chart = new PieChart(500, 250);
			$dataSet = new XYDataSet();
			$new_result = mysql_query("SELECT DISTINCT `type` AS Type_ID FROM `Logs` WHERE `timestamp`>(CURRENT_TIMESTAMP - 2592000);");
			if ($new_result)
			{
				while ($row = mysql_fetch_array($new_result))
				{
					$result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `type`='" . $row['Type_ID'] . "';");
					if ($result)
					{
						$rowz = mysql_fetch_array($result);
							
						$name = mysql_query("SELECT `problem` FROM `Types` WHERE `index`='" . $row['Type_ID'] . "';");
						if ($name)
						{
							$rowy = mysql_fetch_array($name);
							$dataSet->addPoint(new Point($rowy['problem'], $rowz['RecordNumber']));
						}else{
							$dataSet->addPoint(new Point($row['Type_ID'], $rowz['RecordNumber']));
						}
						
					}
					
				}
			}
			$chart->setTitle("Last 30 Days By Type");
				
			$chart->setDataSet($dataSet);
			$chart->render();
			break;
			
		case "users":
			header("Content-type: image/png");
			$chart = new PieChart(500, 250);
			$dataSet = new XYDataSet();
			
			$new_result = mysql_query("SELECT DISTINCT `userid` AS User_ID FROM `Logs` WHERE `timestamp`>(CURRENT_TIMESTAMP - 2592000);");
			if ($new_result)
			{
				while ($row = mysql_fetch_array($new_result))
				{
					$result = mysql_query("SELECT COUNT(*) AS RecordNumber FROM `Logs` WHERE `userid`='" . $row['User_ID'] . "';");
					if ($result)
					{
						$rowz = mysql_fetch_array($result);
						
						$name = mysql_query("SELECT `username` FROM `Users` WHERE `ID`='" . $row['User_ID'] . "';");
						if ($name)
						{
							$rowy = mysql_fetch_array($name);
							$dataSet->addPoint(new Point($rowy['username'], $rowz['RecordNumber']));
						}else{
							$dataSet->addPoint(new Point($row['User_ID'], $rowz['RecordNumber']));
						}
					}
					
				}
			}
						
			$chart->setTitle("Last 30 Days By Users");
			$chart->setDataSet($dataSet);
			$chart->render();
			break;
			
		case "excel":
			header("Content-type: application/csv; ");
			header("Content-Disposition: attachment; filename=\"Helpdesk_QuickLogs.csv\""); 
			
			echo "timestamp,problem,user\n";
			
			$users = array ();
			$problems = array();
			$new_result = mysql_query("SELECT `ID`,`username` FROM `Users`;");
			if ($new_result)
			{
				while ($row = mysql_fetch_array($new_result))
				{
					$users[$row['ID']] = $row['username'];
				}
			}
			$new_result = mysql_query("SELECT `index`,`problem` FROM `Types`;");
			if ($new_result)
			{
				while ($row = mysql_fetch_array($new_result))
				{
					$problems[$row['index']] = $row['problem'];
				}
			}
			$new_result = mysql_query("SELECT * FROM `Logs`;");
			if ($new_result)
			{
				while ($row = mysql_fetch_array($new_result))
				{
					echo $row['timestamp'] . "," . $problems[$row['type']] . "," . $users[$row['userid']] . "\n";
				}
			}

			break;
			
	}

	mysql_close();
?>