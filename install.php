<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/
	
	if(!defined('UCVS'))
	{
		header("location:./");
	}
	
	require_once("classes/mssql.class.php");
	require_once("classes/mysql.class.php");
?>

<div id="content">
	<?php
		if(file_exists("classes/userconfig.class.php"))
		{
			echo '<div class="alert fade in">';
				echo '<strong>Warning!</strong><br> UCVS was already installed! Reinstalling will drop all user data in UCVS_VoteLog table and overwrite all settings!';
			echo '</div>';
		}
		
		if(isset($_POST['submit']))
		{
			if($_POST['dbms'] == "" || $_POST['db_host'] == "" || $_POST['db_user'] == "" || $_POST['db_pass'] == "" ||	$_POST['db_name'] == "" || $_POST['rewardMode'] == "" || $_POST['reward_amount'] == "" || $_POST['reward_delay'] == "")
			{
				echo '<div class="alert alert-error fade in">';
					echo '<strong>Error!</strong><br> You left some important fields blank!';
				echo '</div>';
				$error = true;
			}
			else
			{
				//check db settings
				if($_POST['dbms'] == 0)
				{
					$dbCon = cMSSQL::withDB($_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);
				}
				else if ($_POST['dbms'] == 1)
				{
					$dbCon = cMySQL::withDB($_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);
				}
				
				if(!$dbCon)
				{
					echo '<div class="alert alert-error fade in">';
						echo '<strong>Error!</strong><br> Couldn\'t connect to database, check your settings!';
					echo '</div>';
					$error = true;
				}
				else
				{
					if(isset($_POST['logging']))
					{
						$enableLog = 1;
					}
					else
					{
						$enableLog = 0;
					}
					
					$configContent = "<?php" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "	class userConfig extends ucvsConfig {" . "\r\n";
					$configContent .= "		/* General settings" . "\r\n";
					$configContent .= "		==================================================*/" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		//Logging function - Possible values: 0 => disabled | 1 => enabled" . "\r\n";
					$configContent .= "		var \$enableLog = {$enableLog};" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		/* Database settings" . "\r\n";
					$configContent .= "		==================================================*/" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		//Database Mode - Choose which database management system you want to use" . "\r\n";
					$configContent .= "		//Possible values: 0 => mssql | 1 => mysql" . "\r\n";
					$configContent .= "		var \$dbMode = {$_POST['dbms']};" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		var \$dbHost = '{$_POST['db_host']}';	//Database host address" . "\r\n";
					$configContent .= "		var \$dbID = '{$_POST['db_user']}';	//Username" . "\r\n";
					$configContent .= "		var \$dbPW = '{$_POST['db_pass']}';	//Password" . "\r\n";
					$configContent .= "		var \$dbName = '{$_POST['db_name']}';	//Database Name (When using UCVS for Silkroad please use Account Database name e.g. SRO_VT_ACCOUNT)" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		/* Reward settings" . "\r\n";
					$configContent .= "		==================================================*/" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		//Reward mode - Choose the way you want to reward your users" . "\r\n";
					$configContent .= "		//Possible values: 0 => Silk (Silkroad only) | 1 => Custom point system" . "\r\n";
					$configContent .= "		var \$rewardMode = {$_POST['rewardMode']};" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		//Reward amount - Choose how many points a user gets per valid vote" . "\r\n";
					$configContent .= "		var \$rewardAmount = {$_POST['reward_amount']};" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		//Vote delay - Choose how long users have to wait before being rewarded again (hours)" . "\r\n";
					$configContent .= "		var \$rewardDelay = {$_POST['reward_delay']};" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "		/* Custom point system settings" . "\r\n";
					$configContent .= "		==================================================*/" . "\r\n";
					$configContent .= "		var \$tableName = '{$_POST['custom_table']}';	//name of the table you store user info in" . "\r\n";
					$configContent .= "		var \$idColName = '{$_POST['custom_idCol']}';	//name of the column you identify the user with" . "\r\n";
					$configContent .= "		var \$pointColName = '{$_POST['custom_pointCol']}';	//name of the column you store the points in" . "\r\n";
					$configContent .= "	}" . "\r\n";
					$configContent .= "" . "\r\n";
					$configContent .= "?>" . "\r\n\r\n";
					
					if(!file_put_contents("classes/userconfig.class.php", $configContent))
					{
						echo '<div class="alert alert-error fade in">';
							echo '<strong>Error!</strong><br> Couldn\'t write config file, check folder permissions (chmod)!';
						echo '</div>';
						$error = true;
					}
					else
					{
						//TODO: create table
						if($_POST['dbms'] == 0) //MSSQL
						{
							$dbCon->execute("IF OBJECT_ID('dbo.UCVS_VoteLog', 'U') IS NOT NULL 
												 DROP TABLE [dbo].[UCVS_VoteLog]
											 GO
											 CREATE TABLE [dbo].[UCVS_VoteLog](
												 [UserID] [varchar](50) NOT NULL,
												 [xtremetop100] [int] NULL,
												 [arena-top100] [int] NULL,
												 [gtop100] [int] NULL,
												 [silkroad-servers] [int] NULL,
												 [private-server] [int] NULL,
												 [topg] [int] NULL,
												 [top100arena] [int] NULL,
											 CONSTRAINT [PK_UCVS_VoteLog] PRIMARY KEY CLUSTERED 
											 (
												 [UserID] ASC
											 )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
											 ) ON [PRIMARY]
											 GO");
						}
						else //MySQL
						{
							$dbCon->execute("DROP TABLE IF EXISTS `UCVS_VoteLog`;
											 CREATE TABLE `UCVS_VoteLog` (
												`UserID` varchar(50) NOT NULL,
												`xtremetop100` int(11) NULL,
												`arena-top100` int(11) NULL,
												`gtop100` int(11) NULL,
												`silkroad-servers` int(11) NULL,
												`private-server` int(11) NULL,
												`topg` int(11) NULL,
												`top100arena` int(11) NULL
											 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
											 ALTER TABLE `UCVS_VoteLog`
												ADD PRIMARY KEY (`UserID`);");
						}
						header("location:./");
					}
				}
			}
		}
	?>
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
			<input type="radio" id="dbms_mssql" name="dbms" value="0" <?php if(isset($_POST['dbms']) && $error == true && $_POST['dbms'] == 0) { echo 'checked'; } else { echo 'checked'; } ?> /> <label for="dbms_mssql">MSSQL</label>
			<input type="radio" id="dbms_mysql" name="dbms" value="1" <?php if(isset($_POST['dbms']) && $error == true && $_POST['dbms'] == 1) { echo 'checked'; } ?> style="margin-left:20px;" /> <label for="dbms_mysql">MySQL</label>
		</span>
		<br /><br />
		Database Host:
		<span class="install-field">
			<input type="text" name="db_host" placeholder="127.0.0.1" <?php if(isset($_POST['db_host']) && $error == true) { echo 'value="' . $_POST['db_host'] . '"'; } ?> />
		</span>
		<br /><br />
		Database Username:
		<span class="install-field">
			<input type="text" name="db_user" placeholder="Username" <?php if(isset($_POST['db_user']) && $error == true) { echo 'value="' . $_POST['db_user'] . '"'; } ?> />
		</span>
		<br /><br />
		Database Password:
		<span class="install-field">
			<input type="password" name="db_pass" placeholder="Password" />
		</span>
		<br /><br />
		Database Name:
		<span class="install-field">
			<input type="text" name="db_name" placeholder="Database Name" <?php if(isset($_POST['db_name']) && $error == true) { echo 'value="' . $_POST['db_name'] . '"'; } ?> />
		</span>
		<br />
		When using UCVS for Silkroad please use Account Database name e.g. SRO_VT_ACCOUNT
		<br /><br />
		
		<h4>Reward Settings</h4>
		Reward Mode:
		<span class="install-field">
			<input type="radio" id="reward_silk" name="rewardMode" value="0" <?php if(isset($_POST['rewardMode']) && $error == true && $_POST['rewardMode'] == 0) { echo 'checked'; } else { echo 'checked'; } ?> /> <label for="reward_silk">Silk (Silkroad Only)</label>
			<input type="radio" id="reward_points" name="rewardMode" value="1" <?php if(isset($_POST['rewardMode']) && $error == true && $_POST['rewardMode'] == 1) { echo 'checked'; } ?> style="margin-left:20px;" /> <label for="reward_points">Custom point system</label>
		</span>
		<br />
		Choose the way you want to reward your users
		<br /><br />
		Reward Amount:
		<span class="install-field">
			<input type="text" name="reward_amount" placeholder="15" <?php if(isset($_POST['reward_amount']) && $error == true) { echo 'value="' . $_POST['reward_amount'] . '"'; } ?> />
		</span>
		<br />
		Choose how many points a user gets per valid vote
		<br /><br />
		Reward Delay:
		<span class="install-field">
			<input type="text" name="reward_delay" placeholder="12" <?php if(isset($_POST['reward_delay']) && $error == true) { echo 'value="' . $_POST['reward_delay'] . '"'; } ?> />
		</span>
		<br />
		Choose how long users have to wait before being rewarded again (hours)
		<br /><br />
		
		<h4>Custom Point System Settings</h4>
		<b>Please note: if you dont use a custom point system you can leave these fields empty!</b><br /><br />
		Table Name:
		<span class="install-field">
			<input type="text" name="custom_table" placeholder="Table Name" <?php if(isset($_POST['custom_table']) && $error == true) { echo 'value="' . $_POST['custom_table'] . '"'; } ?> />
		</span>
		<br />
		Name of the table you store user info in
		<br /><br />
		ID Column:
		<span class="install-field">
			<input type="text" name="custom_idCol" placeholder="ID Column" <?php if(isset($_POST['custom_idCol']) && $error == true) { echo 'value="' . $_POST['custom_idCol'] . '"'; } ?> />
		</span>
		<br />
		Name of the column you identify the user with
		<br /><br />
		Point Column:
		<span class="install-field">
			<input type="text" name="custom_pointCol" placeholder="Point Column" <?php if(isset($_POST['custom_pointCol']) && $error == true) { echo 'value="' . $_POST['custom_pointCol'] . '"'; } ?> />
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