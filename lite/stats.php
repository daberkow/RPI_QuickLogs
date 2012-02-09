<?PHP
	include_once '../cas/CAS.php';
	
	phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas/');
	
	//SSL!
	phpCAS::setCasServerCACert("cas-auth.rpi.edu");

?>


<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
		<!--<script src="../jquery-1.6.2.min.js"></script>-->

	</head>
	<body>
		<div id="main">
			<div id="title">
				<a href="./index.php"><div id="logo">QuickLogs</div></a>
				<div id="result"></div>
			</div>
			<div id="short_chart" class="chart">
				<img src="./chart.php?chart=short" alt="30 Day Type Chart"/> 
			</div>
			<div id="user_chart" class="chart">
				<img src="./chart.php?chart=users" alt="User Chart"/> 
			</div>
			<div id="long_chart" class="chart">
				<img src="./chart.php?chart=long" alt="History Chart"/> 
			</div>
			<a href="./chart.php?chart=excel">Download Excel File</a>
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
					if ($Customize || $admin) { echo "<p style='margin:0;'><a href='./settings.php' class='labels'>Settings</a></p>"; }
				?>	
				</div>
				<div id="version">v3.0</div>
				<div id="switch_ver">
					<a href="http://j2ee7.server.rpi.edu:8080/helpdesk/stylesheets/welcome.faces" class="labels"> Send in a Ticket </a>
					<p style="margin: 0;"><a href="./stats.php" class="labels">See Stats</a></p>
				</div>
			</div>
		</div>
	</body>
</html>