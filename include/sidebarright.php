<div class="sidebar" id="sidebarright">
	<ul>
		<!-- <li id="search">
			<h2>Search</h2>
			<form action="" method="get" id="searchform">
				<div>
					<input type="text" size="15" id="s" name="s">
					<br>
					<input type="submit" id="submit" value="Search" name="submit">
				</div>
			</form>
		</li> -->
		<li id="recent-posts">
			<h2>Weather Report</h2>
			<div class="pT5 pB5">
				<span><a class="wactive" id="weather_report_weekly" href="javascript:;">Weekly</a></span>
				<span class="pL10"><a id="weather_report_hourly" href="javascript:;">Hourly</a></span>	
			</div>
			<?php require_once($DOC_ROOT.'api/weatherAPI.php');?>
		</li>
	</ul>
</div>
<div style="clear: both;">&nbsp;</div>