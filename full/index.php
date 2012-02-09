<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./style.css"/>
	</head>
	<body>
		<div id="main">
			<div id="title">
				<div id="logo">QuickLogs</div>
				<div id="search">
				<form action="./search.php" method="post">
					<input type="text" id="search_box"/>
					<input TYPE="submit" id="search_button" VALUE="Search Cases"/>
				</form>
				</div>
			</div>
			<div>
				<form action="./submit.php" method="post">
					<div id="category">
						<p class="label">Category</p>
						<select name='cat_selectable' id='cat_selectable'>
							<?PHP
								mysql_connect("localhost", "QuickLogs", "sera5jL6XVRsuXHG") or die("Could Not Connect To MYSQL");
								mysql_select_db("QuickLogs") or die ("Could Not Connect to DATABASE");
								$result = mysql_query("SELECT * FROM `Types` WHERE `disabled` = 0 LIMIT 0, 100"); //limit just in case
								//error_reporting(E_ALL);
								if($result)
								{
									while ($row = mysql_fetch_array($result))//Should be run once
									{
										echo "<option value=" . $row['index'] . ">" . $row['problem'] . "</option>";
									}
									mysql_close();
								}else{
									echo "<option value=0>Other</option>";
								}
							?>
						</select>
					</div>
					
					<div id="summary">
						<p class="label">Brief Summary</p>
						<input class='input_box' type='text' name='summary_selectable' id='summary_selectable'/>
					</div>
					
					
					<div id="problem">
						<p class="label">Problem</p>
						<textarea name='problem_selectable' id='problem_selectable'></textarea>
					</div>
					
					
					<div id="solution">
						<p class="label">Solution</p>
						<textarea name='solution_selectable' id='solution_selectable'></textarea>
					</div>
					<div id="buttonz">
						<input TYPE="submit" id="cmdSubmit" VALUE="Submit"/>
					</div>
				</form>
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