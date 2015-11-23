<?php
/***************************************/
/* UCVS - Unified Callback Vote Script */
/*		Written by LemoniscooL		   */
/*	 released under GPLv3 license	   */
/***************************************/

require_once("config.class.php");
require_once("mssql.class.php");
require_once("mysql.class.php");

class ucvsCore
{
	private var $config = new ucvsConfig(); //Declare and initialize config variable
	private var $dbCon;
	
	///<summary>
	///Constructor being executed at object creation. Will automatically choose DBMS and connect to DB.
	///Return values: none
	///</summary>
	public function __construct()
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
	///Choose the right reward function, call it and return its return value
	///Return values: Success => true | Failure => Error message
	///</summary>
	private function doReward($userID)
	{
		if($config->rewardMode == 0)
		{
			return rewardSilk($userID);
		}
		else
		{
			return rewardPoints($userID);
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
	///Check if a given IP/User in a dataset voted during the last x hours on a given page
	///Return values: true | false
	///</summary>
	private function checkDelay(array $data, $siteIP)
	{
		//TODO
	}
	
	///<summary>
	///Check if a given IP/User in a dataset voted during the last x hours on a given page
	///Return values: true | false
	///</summary>
	private function updateDelay($userID, $userIP, $siteIP)
	{
		//TODO
	}
	
	///<summary>
	///Process data sent by the toplist
	///Return values: Success => true | Failure => Error message
	///</summary>
	public function procData(array $data, $siteIP)
	{
		//TODO: check/update delay table
		switch($siteIP)
		{
			case "199.59.161.214": //xtremetop100
				$result = doReward($data['custom']);
			break;
			
			case "198.148.82.98": //gtop100
				if(abs($data['Successful') == 0)
				{
					$result = doReward($data['pingUsername');
				}
				else
				{
					$result = $data['Reason'];
				}
			break;
			
			case "104.24.15.11": //topg
				$result = doReward($data['p_resp'];
			break;
			
			case "104.24.2.32": //top100arena
				$result = doReward($data['postback'];
			break;
			
			case "198.20.70.235": //arena-top100
			case "78.46.67.100": //silkroad-servers
			case "178.63.126.52": //private-server
				if($data['voted'] == 1)
				{
					$result = doReward($data['userid']);
				}
				else
				{
					$result = "User " . $data['userid'] . " voted already today!" . PHP_EOL;
				}
			break;
		}
		
		return $result;
	}
	
	///<summary>
	///Log a given message if logging is activated
	///Return values: none
	///</summary>
	public function Log($message)
	{
		//TODO
	}
}

?>