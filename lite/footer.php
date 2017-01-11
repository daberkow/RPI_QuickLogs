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
	<a href="http://leet.arc.rpi.edu/forum" class="labels"> Send in a Ticket </a>
	<p style="margin: 0;"><a href="./stats.php" class="labels">See Stats</a></p>
</div>