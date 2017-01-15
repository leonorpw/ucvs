<?php
 //TODO: check db settings, write config
 
?>

<div id="content">
	<h2>UCVS - Installation</h2>
	<div class="divider"><span></span></div>
	
	<p>
	Thanks for choosing UCVS - Unified Callback Vote Script!<br />
	You're just one step away from giving your users an opportunity to get something in return for voting for your Server.<br />
	All you have to do is to fill out the form below and send it - thats it! If your settings were correct UCVS will be up and running, waiting for the callbacks from the toplists.
	</p>
	<br />
	<form method="post" style="width: 90%; margin: 0 auto;">
		<h4>Logging</h4>
		<p>When enabled, UCVS will log all recieved callbacks to the logs folder.</p>
		<input type="checkbox" name="logging" checked/> Enable logging
		<br /><br />
		
		<h4>Database Settings</h4>
		Database Management System:
		<span class="install-field">
			<input type="radio" id="dbms_mssql" name="dbms" value="0" checked /> <label for="dbms_mssql">MSSQL</label>
			<input type="radio" id="dbms_mysql" name="dbms" value="1" style="margin-left:20px;" /> <label for="dbms_mysql">MySQL</label>
		</span>
		<br /><br />
		Database Host:
		<span class="install-field">
			<input type="text" name="db_host" placeholder="127.0.0.1" />
		</span>
		<br /><br />
		Database Username:
		<span class="install-field">
			<input type="text" name="db_user" placeholder="Username" />
		</span>
		<br /><br />
		Database Password:
		<span class="install-field">
			<input type="password" name="db_pass" placeholder="Password" />
		</span>
		<br /><br />
		Database Name:
		<span class="install-field">
			<input type="text" name="db_name" placeholder="Database Name" />
		</span>
		<br /><br />
		
		<h4>Reward Settings</h4>
		Reward Mode:
		<span class="install-field">
			<input type="radio" id="reward_silk" name="rewardMode" value="0" checked /> <label for="reward_silk">Silk (Silkroad Only)</label>
			<input type="radio" id="reward_points" name="rewardMode" value="1" style="margin-left:20px;" /> <label for="reward_points">Custom point system</label>
		</span>
		<br />
		Choose the way you want to reward your users
		<br /><br />
		Reward Amount:
		<span class="install-field">
			<input type="text" name="reward_amount" placeholder="15" />
		</span>
		<br />
		Choose how many points a user gets per valid vote
		<br /><br />
		Reward Delay:
		<span class="install-field">
			<input type="text" name="reward_delay" placeholder="12" />
		</span>
		<br />
		Choose how long users have to wait before being rewarded again (hours)
		<br /><br />
		
		<h4>Custom Point System Settings</h4>
		<b>Please note: if you dont use a custom point system you can leave these fields empty!</b><br /><br />
		Table Name:
		<span class="install-field">
			<input type="text" name="custom_table" placeholder="Table Name" />
		</span>
		<br />
		Name of the table you store user info in
		<br /><br />
		ID Column:
		<span class="install-field">
			<input type="text" name="custom_idCol" placeholder="ID Column" />
		</span>
		<br />
		Name of the column you identify the user with
		<br /><br />
		Point Column:
		<span class="install-field">
			<input type="text" name="custom_pointCol" placeholder="Point Column" />
		</span>
		<br />
		Name of the column you store the points in
		<br /><br />
		<span class="install-field">
			<input type="submit" name="submit" value="Submit" />
		</span>
	</form>
	<br /><br /><br /><br />
</div>