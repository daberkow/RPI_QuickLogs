<?PHP

class QuickLogs {

	public static function db_connect()
	{
		mysql_connect("localhost", "QuickLogs", "6BU44XjpTmXnCaQD") or die("Could Not Connect To MYSQL");
		mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
	}
	
	public static function db_disconnect()
	{
		mysql_close();
	}
	
	public function get_version()
	{
		return "3.2.3";
	}
	
}

?>
