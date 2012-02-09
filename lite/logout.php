<?PHP
	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas/');
	
	// SSL!
	phpCAS::setCasServerCACert("cas-auth.rpi.edu");
	
	if (phpCAS::isAuthenticated())
	{
		phpCAS::logout();
	}
	header( 'Location: ./index.php' );
?>


			
			