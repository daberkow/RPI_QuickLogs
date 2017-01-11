<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	// Updated from PHP 5 to PHP 7, Joshua Rosenfeld, rosenj5@rpi.edu, jomaxro@gmail.com, Jan 2017
	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
	
	// SSL!
	phpCAS::setCasServerCACert("../cas-auth.rpi.edu");
	
	if (phpCAS::isAuthenticated())
	{
		phpCAS::logout();
	}
	header( 'Location: ./index.php' );
?>