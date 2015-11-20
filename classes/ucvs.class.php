<?php
/***************************************/
/* UCVS - Unified Callback Vote Script */
/*		Written by LemoniscooL		   */
/*	 released under GPLv3 license	   */
/***************************************/

require_once("classes/config.class.php");
require_once("classes/mssql.class.php");
require_once("classes/mysql.class.php");

class ucvsCore
{
	private var $config = new ucvsConfig(); //Declare and initialize config variable
	private var $dbCon;
	
	///<summary>
	///Constructor being executed at object creation. Will automatically choose DBMS and connect to DB.
	///Return values: none
	///</summary>
	function __construct()
	{
		if($config->dbMode == 0)
		{
			$dbCon = cMSSQL::withDB($config->dbHost, $config->dbID, $config->dbPW, $config->$dbName);
		}
		else if ($config->dbMode == 1)
		{
			$dbCon = cMySQL::withDB($config->dbHost, $config->dbID, $config->dbPW, $config->$dbName);
		}
		else
		{
			die("You have an error in your UCVS config file, please check database settings!" . PHP_EOL);
		}
	}
	
	///<summary>
	///Reward silk to a given user id. Silkroad only, requires use of mssql
	///Return values: Success => true | Failure => Error message
	///</summary>
	private function rewardSilk($userID)
	{
		if(!empty($userID) && is_numeric($userID))
		{
			$dbCon->execute("EXEC [{$config->dbName}].[CGI].[CGI_WebPurchaseSilk] @OrderID = N'VoteSystem', @UserID = {$dbCon->secure($userID)}, @PkgID = 0, @NumSilk = {$dbCon->secure($config->rewardAmount)}, @Price = 0");
			return true;
		}
		else
		{
			return "Error: Something is wrong with the user ID! Its either empty or not numeric." . PHP_EOL . "For alphanumeric user IDs please use custom point system!" . PHP_EOL;
		}
	}
	
	///<summary>
	///Reward points to a given user id. Using custom point system
	///Return values: Success => true | Failure => Error message
	///</summary>
	private function rewardPoints($userID)
	{
		if(!empty($userID))
		{
			$dbCon->execute("UPDATE {$config->tableName} SET {$config->pointColName} = {$config->pointColName} + {$config->rewardAmount} WHERE {$config->idColName} LIKE {$dbCon->secure($userID)}");
			return true;
		}
		else
		{
			return "Error: User ID is empty!" . PHP_EOL;
		}
	}
	
	///<summary>
	///Check if a given IP is allowed to use ucvs
	///Return values: true | false | Error message
	///</summary>
	public function checkIP($ip)
	{
		if(!empty($ip))
		{
			if(in_array($ip, $config->whitelist))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return "Error: Cannot check an empty IP!" . PHP_EOL;
		}
	}
	
	///<summary>
	///Check if a given IP/User voted during the last x hours on a given page
	///Return values: true | false
	///</summary>
	public function checkDelay($userID, $ip, $page)
	{
		//TODO
	}
	
	///<summary>
	///Process data sent by xtremetop100.com
	///Return values: none
	///</summary>
	public function procXtremetop($userID, $votingIP)
	{
		//TODO: update delay table
		if($config->rewardMode == 0)
		{
			rewardSilk($userID);
		}
		else
		{
			rewardPoints($userID);
		}
	}
	
	///<summary>
	///Process data sent by VisioList based sites
	///Return values: TODO
	///</summary>
	public function procVL($userID, $userIP, $valid)
	{
		
	}
	
	///<summary>
	///Process data sent by gtop100.com
	///Return values: TODO
	///</summary>
	public function procGTop($pingUsername, $voterIP, $success, $reason)
	{
		
	}
	
	///<summary>
	///Process data sent by topg.org
	///Return values: TODO
	///</summary>
	public function procTopG($userID, $userIP)
	{
		
	}
	
	///<summary>
	///Process data sent by top100arena.com
	///Return values: TODO
	///</summary>
	public function procTop100Arena($userID)
	{
		
	}
}

?>