<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	include_once '../cas/CAS.php';
	include '../core.php';
	
	phpCAS::client(CAS_VERSION_2_0,'cas-auth.rpi.edu',443,'/cas/');
	
	//SSL!
	phpCAS::setCasServerCACert("../cas-auth.rpi.edu");

?>

<html>
	<head>
		<title class = "title">QuickLogs</title>
		<script src="../jquery.js"></script>
		<script src="./chart.js"></script>
		<script src="./static/highchart/js/highcharts.js"></script>
		<link rel="stylesheet" type="text/css" media="all" href="./static/jsDatePick/jsDatePick_ltr.css" />
		<script src="./static/jsDatePick/jsDatePick.jquery.min.1.3.js"></script>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
		<link href="http://www.rpi.edu/favicon.ico" type="image/ico" rel="icon"/>
		<script>
			//replace the bad jschart date library
			function loadME(){
				new JsDatePick({
					useMode:2,
					target:"startField"	
				});
				new JsDatePick({
					useMode:2,
					target:"endField"	
				});
			}
		</script>
	</head>
	<body onload='loadME(); makeChart()'>
		<div id="main">
			<div id="title">
				<div class="logo"></div>
				<a href="./index.php"><div id="logo">QuickLogs</div></a>
				<div id="result"></div>
			</div>
			<div class="red_bar"></div>
			<div class="gray_bar"></div>
			<div style='display: inline;'><select id='jobType' onchange='makeChart()'><option value='Activity'>Activities</option><option value='1'>Log History</option><option value='2'>User Activity</option></select></div>
			<div style='display: inline;'><input type="radio" name="group2" value="30" checked onchange='makeChart()'> 30 Days <input type="radio" name="group2" value="90" onchange='makeChart()'> 90 Days <input type="radio" name="group2" value="365" onchange='makeChart()'> 365 Days <input type="radio" name="group2" value="all" onchange='makeChart()'> All Time </div>
			<div><input type="radio" name="group2" value="pick">Start Date:<input type='text' style='width:15%' id='startField'/>End Date:<input style='width:15%' type='text' id='endField'/></div>
			<div id="container" style='width: 100%; height: 400px;'>
				
			</div>
			<div id="footer">
				<?PHP include("./footer.php"); ?>
			</div>
		</div>
	</body>
</html>