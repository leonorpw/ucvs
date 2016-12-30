<?php
/***************************************/
/* UCVS - Unified Callback Vote Script */
/*		Written by LemoniscooL		   */
/*	 released under GPLv3 license	   */
/***************************************/

class ucvsConfig
{
	/*=================================================================================*/
	/* General settings																   */
	/*=================================================================================*/
	
	//Logging function - Possible values: 0 => disabled | 1 => enabled
	var $enableLog = 1;
	
	
	/*=================================================================================*/
	/* Database settings															   */
	/*=================================================================================*/
	
	//Database Mode - Choose which database management system you want to use
	//Possible values: 0 => mssql | 1 => mysql
	var $dbMode = 0;
	
	var $dbHost = "";	//Database host address
	var $dbID = "";	//Username
	var $dbPW = "";	//Password
	var $dbName = "";	//Database Name (when using UCVS for Silkroad please use Account Database name e.g. SRO_VT_ACCOUNT)
	
	
	/*=================================================================================*/
	/* Reward settings																   */
	/*=================================================================================*/
	
	//Reward mode - Choose the way you want to reward your users
	//Possible values: 0 => Silk (Silkroad only) | 1 => Custom point system
	var $rewardMode = 1;
	
	//Reward amount - Choose how many points a user gets per valid vote
	var $rewardAmount = 15;
	
	//Vote delay - Choose how long users have to wait before being rewarded again (hours)
	//!!!!This function is not included in this version yet, it will come later!!!!
	//var $rewardDelay = 12;
	
	//Custom point system settings
	var $tableName = "";	//name of the table you store user info in
	var $idColName = "";	//name of the column you identify the user with
	var $pointColName = "";	//name of the column you store the points in
	
	
	/*=================================================================================*/
	/* Access settings																   */
	/*=================================================================================*/
	
	//This is a list of IPs allowed to access UCVS
	//!!!!Do NOT change this list unless you know what you are doing!!!!
	var $whitelist = Array(
		"xtremetop100" => "199.59.161.214",
		"arena-top100" => "198.20.70.235",
		"gtop100" => "198.148.82.98",
		"silkroad-servers" => "193.70.3.149",
		"private-server" => "193.70.3.149",
		"topg" => "104.24.15.11",
		"top100arena" => "104.24.2.32"
	);
}

?>















