<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
	
	//SSL!
	phpCAS::setCasServerCACert("../cas-auth.rpi.edu");

?>


<html>
	<head>
		<title class = "title">QuickLogs</title>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
		<link href="http://www.rpi.edu/favicon.ico" type="image/ico" rel="icon">
		<!--<script src="../jquery-1.6.2.min.js"></script>-->

	</head>
	<body>
		<div id="main">
			<div id="title">
				<div class="logo"></div>
				<a href="./index.php"><div id="logo">QuickLogs</div></a>
				<div id="result"></div>
			</div>
			<div class="red_bar"></div>
		    <div class="gray_bar"></div>
			<div id="short_chart" class="chart">
				<img src="./chart.php?chart=short" alt="30 Day Type Chart"/> 
			</div>
			<div id="user_chart" class="chart">
				<img src="./chart.php?chart=users" alt="User Chart"/> 
			</div>
			<div id="long_chart" class="chart">
				<img src="./chart.php?chart=long" alt="History Chart"/> 
			</div>
			<p style='font-weight: bold;'><img src='./excel.png' alt='Download in Excel'/> Download Database in Excel</p>
			 
			<p><a href="./chart.php?chart=excel_6months">Download Excel File Containing 6 Months</a></p>
			<p><a href="./chart.php?chart=excel_12months">Download Excel File Containing 1 Year</a></p>
			<p><a href="./chart.php?chart=excel_all">Download Excel File Containing Entire Database</a></p>
			<hr>
			<div id="footer">
				<div id="Stats">					
				<?PHP 
					if (phpCAS::isAuthenticated())
					{
						echo "<a href='./logout.php' class='labels'>Logout " . phpCAS::getUser() . "</a>";
					}else
					{
						echo "<a href='./login.php' class='labels'>Login</a>";
					}
					
				?>	
				</div>
				<div id="version">v<?PHP echo QuickLogs::get_version(); ?> <a href="https://github.com/daberkow/QuickLogs">Source</a></a></div>
				<div id="switch_ver">
					<a href="http://j2ee7.server.rpi.edu:8080/helpdesk/stylesheets/welcome.faces" class="labels"> Send in a Ticket </a>
					<p style="margin: 0;"><a href="./stats.php" class="labels">See Stats</a></p>
				</div>
			</div>
		</div>
	</body>
</html>