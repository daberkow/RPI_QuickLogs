<?PHP
include_once '../cas/CAS.php';
phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
phpCAS::setCasServerCACert("../cas/CACert.pem");

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
	
	public static function get_version()
	{
		return "3.3.3";
	}
	
}

class database_helper{
	//This is added part way through 3.3.0, some code will use some will not
	public static function db_return_array($passed_query)
        {
            QuickLogs::db_connect();
            $return_array = array();
            //echo $query;
            $main_result = mysql_query($passed_query);
            if ($main_result)
            {
                while($main_row = mysql_fetch_array($main_result))
                {
                    array_push($return_array, $main_row);
                }
                return $return_array;
            }else{
                echo "Error with " . $passed_query;
                return $return_array;
            }
        }
        
        //Another wrapper but for a insert comamnd
        public static function db_insert_query($passed_query)
        {
            QuickLogs::db_connect();
            $result = mysql_query($passed_query);
            if ($result)
            {
                return mysql_insert_id();
            }else{
                echo "Error on inset " . $passed_query;
                return false;
            }
        }
}


QuickLogs::db_connect();

?>
