<?PHP
	
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
	</head>
	<body>
		<div id="main">
			<div id="title">
				<div id="logo"><a href="./" style="color: black; text-decoration: none;">QuickLogs</a></div>
				<div id="search">
				<form action="./search.php" method="post">
					<input type="text" id="search_box"/>
					<input TYPE="submit" id="search_button" VALUE="Search Cases"/>
				</form>
				</div>
			</div>
			<div>
				<?PHP
				if(!isset($_REQUEST['id']))
				{
					echo "<script type='text/javascript'>
							window.alert('No Case Passed, Enter one or go to Search')
							</script>";
				}else{
				
					mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
					mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
					$result = mysql_query("SELECT * FROM `ExtLogs` WHERE `index` = '" . $_REQUEST['id'] . "'"); 
					if($result)
					{
						while ($row = mysql_fetch_array($result))//Should be run once
						{
							$new_result = mysql_query("SELECT `problem` FROM `Types` WHERE `index`='" . $row['type'] . "'");
							$new_row = mysql_fetch_array($new_result);
							echo "<table border='0'>
								<tr>
									<td><p class='label'>Category</p></td>
									<td><p class='output'>" . $new_row['problem'] . "</p></td>
								</tr>
								<tr>
									<td><p class='label'>Brief Summary</p></td>
									<td><p class='output'>" . $row['brief'] . "</p></td>
								</tr>
								<tr>
									<td><p class='label'>Problem</p></td>
									<td><p class='output'>" . $row['problem'] . "</p></td>
								</tr>
								<tr>
									<td><p class='label'>Solution</p></td>
									<td><p class='output'>" . $row['solution'] . "</p></td>
								</tr>
							</table>";
						}
						mysql_close();
					}else{
						echo "Error Retrieving Case";
					}
				}
				
				?>
			</div>
			
			<div id="footer">
			<hr>
				<div id="Stats"><a href="/stats.php" class="labels">See Stats</a></div>
				<div id="version">v3.0</div>
				<div id="switch_ver"><a href="../lite/"> Switch to Lite Site </a></div>
			</div>
		</div>
	</body>
</html>