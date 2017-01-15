<?php
	
	class userConfig extends ucvsConfig {
		/* General settings
		==================================================*/
		
		//Logging function - Possible values: 0 => disabled | 1 => enabled
		var $enableLog = 1;
		
		
		
		/* Database settings
		==================================================*/
		
		//Database Mode - Choose which database management system you want to use
		//Possible values: 0 => mssql | 1 => mysql
		var $dbMode = 0;
		
		var $dbHost = "";	//Database host address
		var $dbID = "";	//Username
		var $dbPW = "";	//Password
		var $dbName = "";	//Database Name (when using UCVS for Silkroad please use Account Database name e.g. SRO_VT_ACCOUNT)
		
		
		
		/* Reward settings
		==================================================*/
		
		//Reward mode - Choose the way you want to reward your users
		//Possible values: 0 => Silk (Silkroad only) | 1 => Custom point system
		var $rewardMode = 1;
		
		//Reward amount - Choose how many points a user gets per valid vote
		var $rewardAmount = 15;
		
		//Vote delay - Choose how long users have to wait before being rewarded again (hours)
		var $rewardDelay = 12;
		
		
		
		/* Custom point system settings
		==================================================*/
		var $tableName = "";	//name of the table you store user info in
		var $idColName = "";	//name of the column you identify the user with
		var $pointColName = "";	//name of the column you store the points in
	}

?>