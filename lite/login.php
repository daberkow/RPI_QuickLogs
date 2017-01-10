<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	// Updated from PHP 5 to PHP 7, Joshua Rosenfeld, rosenj5@rpi.edu, jomaxro@gmail.com, Jan 2017
	include '../core.php';
		
	//If not authenticated then do it
	if (!(phpCAS::isAuthenticated()))
	{
		phpCAS::forceAuthentication();
	}else{
		//We are authenticated, but we may not be in the users database		
		$mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
		
		$user_exists = mysqli_query($mysqli, "SELECT * FROM `Users` WHERE `username`='" . phpCAS::getUser() ."'");
		
		if (mysqli_num_rows($user_exists) == 0) // True is user is not in the database
		{
			$sql = mysqli_query($mysqli, "INSERT INTO `QuickLogs`.`Users` (`ID` ,`username` ,`type`) VALUES (NULL , '" . phpCAS::getUser() . "', '0');");
			if ($sql)
			{ //Insert worked, copy default display data
				mysqli_query($mysqli, "INSERT INTO `display` (`user`,`Box1`,`Box2`,`Box3`,`Box4`,`Box5`,`Box6`,`Box7`,`Box8`,`Box9`,`Box10`) (SELECT (SELECT `ID` FROM `Users` WHERE `username`='" . phpCAS::getUser() ."' LIMIT 1), `display`.`Box1`, `display`.`Box2`, `display`.`Box3`, `display`.`Box4`, `display`.`Box5`, `display`.`Box6`, `display`.`Box7`, `display`.`Box8`, `display`.`Box9`, `display`.`Box10` FROM `display` WHERE `user`=0)");
			}
		}
		QuickLogs::db_disconnect($mysqli);
	}
	header("location: ./index.php");
	?>