<?PHP
	//Check if all varibles passed, ones that were not get a null, just so no errors come up later
	if(isset($_REQUEST['cat_selectable']))
	{
		$QL_Task_Type = $_REQUEST['cat_selectable'];
	}else{
		$QL_Task_Type = "";
	}
	if(isset($_REQUEST['summary_selectable']))
	{
		$QL_Task_Brief = $_REQUEST['summary_selectable'];
	}else{
		$QL_Task_Brief = "";
	}
	if(isset($_REQUEST['problem_selectable']))
	{
		$QL_Task_Problem = $_REQUEST['problem_selectable'];
	}else{
		$QL_Task_Problem = "";
	}
	if(isset($_REQUEST['solution_selectable']))
	{
		$QL_Task_Solution = $_REQUEST['solution_selectable'];
	}else{
		$QL_Task_Solution = "";
	}
	mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
	mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
	$result = mysql_query("INSERT INTO `QuickLogs`.`ExtLogs` (`index` , `type` , `brief` , `problem` , `solution`) VALUES (NULL , '" . $QL_Task_Type . "', '" . $QL_Task_Brief . "', '" . $QL_Task_Problem . "', '" . $QL_Task_Solution . "');");
	//error_reporting(E_ALL);
	if($result)
	{
		header("location: ./case.php?id=" . mysql_insert_id());
		echo "Recorded, entry: #" . mysql_insert_id();
	}else{
		echo "Error Saving Entry.";
	}
?>