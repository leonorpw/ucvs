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
	var $config;
	var $dbCon;
	
	///<summary>
	///Constructor being executed at object creation. Will automatically choose DBMS and connect to DB.
	///Return values: none
	///</summary>
	public function __construct()
	{
		$this->config = new ucvsConfig();
		
		if($this->config->dbMode == 0)
		{
			$this->dbCon = cMSSQL::withDB($this->config->dbHost, $this->config->dbID, $this->config->dbPW, $this->config->dbName);
		}
		else if ($config->dbMode == 1)
		{
			$this->dbCon = cMySQL::withDB($this->config->dbHost, $this->config->dbID, $this->config->dbPW, $this->config->dbName);
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
			$this->dbCon->execute("EXEC [{$this->config->dbName}].[CGI].[CGI_WebPurchaseSilk] @OrderID = N'VoteSystem', @UserID = {$this->dbCon->secure($userID)}, @PkgID = 0, @NumSilk = {$this->dbCon->secure($this->config->rewardAmount)}, @Price = 0");
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
			$this->dbCon->execute("UPDATE {$this->config->tableName} SET {$this->config->pointColName} = {$this->config->pointColName} + {$this->config->rewardAmount} WHERE {$this->config->idColName} LIKE {$this->dbCon->secure($userID)}");
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
		if($this->config->rewardMode == 0)
		{
			return $this->rewardSilk($userID);
		}
		else
		{
			return $this->rewardPoints($userID);
		}
	}
	
	///<summary>
	///Check if a given IP is allowed to use ucvs
	///Return values: true | false
	///</summary>
	public function checkIP($ip)
	{
		if(in_array($ip, $this->config->whitelist))
		{
			return true;
		}
		else
		{
			return false;
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
				$result = $this->doReward($data['custom']);
			break;
			
			case "198.148.82.98": //gtop100
				if(abs($data['Successful']) == 0)
				{
					$result = $this->doReward($data['pingUsername']);
				}
				else
				{
					$result = $data['Reason'];
				}
			break;
			
			case "104.24.15.11": //topg
				$result = $this->doReward($data['p_resp']);
			break;
			
			case "104.24.2.32": //top100arena
				$result = $this->doReward($data['postback']);
			break;
			
			case "198.20.70.235": //arena-top100
			case "78.46.67.100": //silkroad-servers
			case "178.63.126.52": //private-server
			case "5.146.225.126": //test
				if($data['voted'] == 1)
				{
					$result = $this->doReward($data['userid']);
				}
				else
				{
					$result = "User " . $data['userid'] . " voted already today!" . PHP_EOL;
				}
			break;
			default:
				$result = "Wrong IP called!";
			break;
		}
		
		return $result;
	}
	
	///<summary>
	///Extracts the user name/id from a given dataset
	///Return values: Success => user name/id | Failure => false
	///</summary>
	public function getUser(array $data)
	{
		if(isset($data['custom']))
		{
			return $data['custom'];
		}
		else if(isset($data['pingUsername']))
		{
			return $data['pingUsername'];
		}
		else if(isset($data['p_resp']))
		{
			return $data['p_resp'];
		}
		else if(isset($data['postback']))
		{
			return $data['postback'];
		}
		else if(isset($data['userid']))
		{
			return $data['userid'];
		}
		else
		{
			return false;
		}
	}
	
	///<summary>
	///Gets the site name from whitelist by a given IP
	///Return values: Success => site name | Failure => false
	///</summary>
	public function getSite($ip)
	{
		$result = false;
		while ($value = current($this->config->whitelist))
		{
			if ($value == $ip)
			{
				$result = key($this->config->whitelist);
			}
			next($this->config->whitelist);
		}
		return $result;
	}
	
	///<summary>
	///Log a given message if logging is activated
	///Return values: Success => number of bytes written | Failure => false
	///</summary>
	public function Log($message)
	{
		
			//error_log(date('[Y-m-d H:i] '). $message . PHP_EOL, 3, "ucvs.log");
			//file_put_contents("ucvs.log", date('[Y-m-d H:i] ') . $message . "\n", FILE_APPEND) or print_r(error_get_last());
			return @file_put_contents("logs/ucvs_" . date("Ymd") . ".log", 
				"[" . date("H:i:s") . "] " . $message . "\r\n",
				FILE_APPEND
			);
		
	}
}

?>