<?php
/***************************************/
/* UCVS - Unified Callback Vote Script */
/*		Written by LemoniscooL		   */
/*	 released under GPLv3 license	   */
/***************************************/

class ucvsConfig
{
	/*=================================================================================*/
	/* Database settings															   */
	/*=================================================================================*/
	
	//Database Mode - Choose which database management system you want to use
	//Possible values: 0 => mssql | 1 => mysql
	public var $dbMode = 0;
	
	public var $dbHost = "";	//Database host address
	public var $dbID = "";	//Username
	public var $dbPW = "";	//Password
	public var $dbName = "";	//Database Name (when using UCVS for Silkroad please use Account Database name e.g. SRO_VT_ACCOUNT)
	
	
	/*=================================================================================*/
	/* Reward settings																   */
	/*=================================================================================*/
	
	//Reward mode - Choose the way you want to reward your users
	//Possible values: 0 => Silk (Silkroad only) | 1 => Custom point system
	public var $rewardMode = 0;
	
	//Reward amount - Choose how many points a user gets per valid vote
	public var $rewardAmount = 15;
	
	//Vote delay - Choose how long users have to wait before being rewarded again (hours)
	public var $rewardDelay = 12;
	
	//Custom point system settings
	public var $tableName = "";	//name of the table you store user info in
	public var $idColName = "";	//name of the column you identify the user with
	public var $pointColName = "";	//name of the column you store the points in
	
	
	/*=================================================================================*/
	/* Access settings																   */
	/*=================================================================================*/
	
	//This is a list of IPs allowed to access UCVS
	//Do NOT change this list unless you know what you are doing!
	public var $whitelist = Array(
		"xtremetop100" => "199.59.161.214",
		"arena-top100" => "198.20.70.235",
		"gtop100" => "198.148.82.98",
		"silkroad-servers" => "78.46.67.100",
		"private-server" => "178.63.126.52",
		"topg" => "104.24.15.11",
		"top100arena" => "104.24.2.32"
	);
	
	
	/*=================================================================================*/
	/* Debug settings																   */
	/* These settings are solely for debug purposes, dont change anything here!		   */
	/*=================================================================================*/
	
	//Logging function - Possible values: 0 => disabled | 1 => enabled
	public var $enableLog = 1;
	
	//Uncomment to show all errors except notice and warnings
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	
	//in case no errors are shown uncomment this
	ini_set("display_errors", 0);
}

?>















