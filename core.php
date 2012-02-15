<?PHP

class QuickLogs {

	public static function db_connect()
	{
		mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
		mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
	}
	
	public static function db_disconnect()
	{
		mysql_close();
	}
	
}

?>