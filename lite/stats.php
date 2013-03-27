<?PHP
	// Dan Berkowitz, berkod2@rpi.edu, dansberkowitz@gmail.com, Feb 2012
	include '../core.php';

?>

<html>
	<head>
		<title class = "title">QuickLogs</title>
		<script src="../jquery.js"></script>
		<script src="./chart.js"></script>
		<script src="./static/highchart/js/highcharts.js"></script>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
		<link href="http://www.rpi.edu/favicon.ico" type="image/ico" rel="icon"/>
	</head>
	<body onload='makeChart()'>
		<div id="main">
			<div id="title">
				<div class="logo"></div>
				<a href="./index.php"><div id="logo">QuickLogs</div></a>
				<div id="result"></div>
			</div>
			<div class="red_bar"></div>
			<div class="gray_bar"></div>
			<div style='display: inline;'><select id='jobType' onchange='makeChart()'><option value='activity'>Activities</option><option value='history'>Log History</option><option value='user'>User Activity</option></select></div>
			<div style='display: inline;'><input type="radio" name="group2" value="30" checked onchange='makeChart()'> 30 Days <input type="radio" name="group2" value="90" onchange='makeChart()'> 90 Days <input type="radio" name="group2" value="365" onchange='makeChart()'> 365 Days <input type="radio" name="group2" value="all" onchange='makeChart()'> All Time </div>
			<!--<div><input type="radio" name="group2" value="pick">Start Date:<input type='text' style='width:15%' id='startField'/>End Date:<input style='width:15%' type='text' id='endField'/></div>-->
			<div id="container" style='width: 100%; height: 400px;'>
				
			</div>
			<p style='font-weight: bold; text-align:center;'><img src='./excel.png' alt='Download in Excel' height='24' width='24' /> Download Database in Excel  <a href="./chart.php?chart=excel_6months">6 Months,</a>  <a href="./chart.php?chart=excel_12months">1 Year,</a>  <a href="./chart.php?chart=excel_all">Entire Database</a></p>
			 
			
			<div id="footer">
				<?PHP include("./footer.php"); ?>
			</div>
		</div>
	</body>
</html>