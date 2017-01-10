<?PHP
	include_once '../cas/CAS.php';
	phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
	phpCAS::setCasServerCACert("../cas/CACert.pem");
	
	class QuickLogs {
	
		public static function db_connect()
		{
		 return mysqli_connect("localhost", "database_user", "database_password", "database_name") or die("Could Not Connect To MYSQL or DATABASE");
		}
		
		public static function db_disconnect($mysqli)
		{
		 mysqli_close($mysqli);
		}
		
		public static function get_version()
		{
			return "3.3.4";
		}
		
	}
	
	class database_helper{
		//This is added part way through 3.3.0, some code will use some will not
		public static function db_return_array($passed_query)
			{
				$mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
				$return_array = array();
				//echo $query;
				$main_result = mysqli_query($mysqli, $passed_query);
				if ($main_result)
				{
					while($main_row = mysqli_fetch_array($main_result))
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
				$mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
				$result = mysqli_query($mysqli, $passed_query);
				if ($result)
				{
					return mysqli_insert_id($mysqli);
				}else{
					echo "Error on inset " . $passed_query;
					return false;
				}
			}
	}
	
	
	$mysqli = mysqli_connect("localhost", "root", "bacon", "QuickLogs") or die("Could Not Connect To MYSQL or DATABASE");
	
	?>