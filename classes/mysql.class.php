<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/

	class cMySQL
	{
		var $dbLink;	//Stores the DB connection result set
		var $dbSelected;	//Flag that signals wheather the Database was selected or not
		
		///<summary>
		///Constructor being executed at object creation, initialize members.
		///Return values: none
		///</summary>
		public function __construct()
		{
			$dbLink = false;
			$dbSelected = false;
		}
		
		///<summary>
		///Destructor being executed at object destruction. Will automatically close DB connection.
		///Return values: none
		///</summary>
		public function __destruct()
		{
			$this->close();
		}
		
		///<summary>
		///Create a new instance of cMySQL, connect to db server and select database
		///Return values: new instance of cMySQL with db connected
		///</summary>
		public static function withDB($host, $id, $pw, $db) {
			$instance = new self();
			$instance->connect($host, $id, $pw);
			$instance->selectDB($db);
			return $instance;
		}
		
		///<summary>
		///Connect to the DB Server with given connection details
		///Return values: none
		///</summary>
		private function connect($host, $id, $pw)
		{
			if(!$this->dbLink)
			{
				$this->dbLink = mysqli_connect($host, $id, $pw);
				if(!$this->dbLink)
				{
					trigger_error("MySQLi Error: Couldn't connect to database! Check your database settings." . PHP_EOL);
					cLog::ErrorLog("MySQLi Error: Couldn't connect to database! Check your database settings.");
				}
			}
			else
			{
				exit;
			}
		}
		
		///<summary>
		///Select database to use with this class, neccessery for this to work!
		///[Optional]You can change the database used during runtime by calling this.
		///Return values: none
		///</summary>
		public function selectDB($dbName)
		{
			if($this->dbLink)
			{
				$this->dbSelected = mysqli_select_db($this->dbLink, $dbName);
				if(!$this->dbSelected)
				{
					trigger_error("MySQLi Error: Couldnt select database!" . PHP_EOL . mysqli_error($this->dbLink) . PHP_EOL);
					cLog::ErrorLog("MySQLi Error: Couldnt select database!" . PHP_EOL . "\t" . mysqli_error($this->dbLink));
				}
			}
			else
			{
				exit;
			}
		}
		
		///<summary>
		///Execute given SQL Command and return the result set. Used for SELECT, SHOW, DESCRIBE, EXPLAIN, etc.
		///Return values: Success => MySQL-Result Set | Failure => false
		///</summary>
		public function query($sqlString)
		{
			if($this->dbLink && $this->dbSelected)
			{
				$result = mysqli_query($this->dbLink, $sqlString);
				if($result)
				{
					return $result;
				}
				else
				{
					trigger_error("MySQLi Error: " . mysqli_error($this->dbLink) . PHP_EOL);
					cLog::ErrorLog("MySQLi Error: " . mysqli_error($this->dbLink));
					return false;
				}
			}
			else
			{
				trigger_error("MySQLi Error: Not connected to a database server or database not selected!" . PHP_EOL);
				cLog::ErrorLog("MySQLi Error: " . mysqli_error($this->dbLink));
				return false;
			}
		}
		
		///<summary>
		///Execute given SQL Command without returning any result sets. Used for INSERT, UPDATE, DELETE, DROP, etc.
		///Return values: Success => True | Failure => false
		///</summary>
		public function execute($sqlString)
		{
			if($this->dbLink && $this->dbSelected)
			{
				$result = mysqli_query($this->dbLink, $sqlString);
				if($result)
				{
					return true;
				}
				else
				{
					trigger_error("MySQLi Error: " . mysqli_error($this->dbLink) . PHP_EOL);
					cLog::ErrorLog("MySQLi Error: " . mysqli_error($this->dbLink));
					return false;
				}
			}
			else
			{
				trigger_error("MySQLi Error: Not connected to a database server or database not selected!" . PHP_EOL);
				cLog::ErrorLog("MySQLi Error: Not connected to a database server or database not selected!");
				return false;
			}
		}
		
		///<summary>
		///Execute given SQL command and return number of results.
		///Return values: Success => Number of results | Failure => false
		///</summary>
		public function numRows($sqlString)
		{
			if($this->dbLink && $this->dbSelected)
			{
				if($result = mysqli_query($this->dbLink, $sqlString))
					return mysqli_num_rows($result);
				else
					return 0;
			}
			else
			{
				trigger_error("MySQLi Error: Not connected to a database server or database not selected!" . PHP_EOL);
				cLog::ErrorLog("MySQLi Error: Not connected to a database server or database not selected!");
				return false;
			}
		}
		
		///<summary>
		///Fetch a result row as an associative array, a numeric array, or both
		///Return values: Success => Array | Failure: false
		///</summary>
		function fetchArray($sqlString) {
			$arr = mysqli_fetch_array($this->query($sqlString));
			if(!$arr)
			{
				trigger_error("MySQLi Error: " . mysqli_error($this->dbLink) . PHP_EOL);
				cLog::ErrorLog("MySQLi Error: " . mysqli_error($this->dbLink));
				return false;
			}
			else
			{
				return $arr;
			}
		}
		
		///<summary>
		///Secures given data for use with SQL Queries, prevents basic SQL injections
		///Return values: secured data
		///</summary>
		public function secure($data)
		{
			$non_displayables = array('/%0[0-8bcef]/', '/%1[0-9a-f]/', '/[\x00-\x08]/', '/\x0b/', '/\x0c/', '/[\x0e-\x1f]/');
			
			if (!isset($data) || empty($data))
			{
				return '';
			}
			if (is_numeric($data))
			{
				return $data;
			}
			
			foreach ($non_displayables as $regex)
			{
				$data = preg_replace($regex, '', $data);
			}
			
			$data = str_replace("'", "''", $data);
			
			return mysqli_real_escape_string($data);
		}
		
		///<summary>
		///Closes connection to DB
		///Return values: none
		///</summary>
		public function close()
		{
			mysqli_close($this->dbLink);
		}
	}
?>