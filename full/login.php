<?PHP

	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas/');
	
	if (!(phpCAS::isAuthenticated()))
	{
		phpCAS::forceAuthentication();
	}
				
	mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
	mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
	
	$user_exists = mysql_query("SELECT * FROM `Users` WHERE `username`='" . phpCAS::getUser() ."'");
	
	if (mysql_num_rows($user_exists) > 0)
	{
		$new_cookie = md5(phpCAS::getUser() . time());
				
		$sql = mysql_query("UPDATE `QuickLogs`.`Users` SET `COOKIE` = '" . $new_cookie . "' WHERE `Users`.`username` =" . phpCAS::getUser() . ";");
		if ($sql)
		{//set cookie on machine, end look (just in case) and return
			setcookie("QuickLogs", $new_cookie, time()+60*60*24*30);
		}
	}else{
		$new_cookie = md5(phpCAS::getUser() . time());
				
		$sql = mysql_query("INSERT INTO `QuickLogs`.`Users` (`ID` ,`username` ,`type` ,`COOKIE`) VALUES (NULL , '" . phpCAS::getUser() . "', '0', '" . $new_cookie . "');");
		if ($sql)
		{//set cookie on machine, end look (just in case) and return
			setcookie("QuickLogs", $new_cookie, time()+60*60*24*30);
		}
		
		mysql_query("INSERT INTO `display` (`user`,`Box1`,`Box2`,`Box3`,`Box4`,`Box5`,`Box6`,`Box7`,`Box8`) (SELECT '5', `display`.`Box1`, `display`.`Box2`, `display`.`Box3`, `display`.`Box4`, `display`.`Box5`, `display`.`Box6`, `display`.`Box7`, `display`.`Box8` FROM `display` WHERE `user`=0)");
	}
	
	//header("location: ./index.php");
?>