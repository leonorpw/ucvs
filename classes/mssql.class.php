<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/

	class cMSSQL
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
		///Create a new instance of cMSSQL, connect to db server and select database
		///Return values: new instance of cMSSQL with db connected
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
				$this->dbLink = mssql_connect($host, $id, $pw);
				if(!$this->dbLink)
				{
					trigger_error("MSSQL Error: Couldn't connect to database! Check your database settings." . PHP_EOL);
					cLog::ErrorLog("MSSQL Error: Couldn't connect to database! Check your database settings.");
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
				$this->dbSelected = mssql_select_db("[" . $dbName . "]", $this->dbLink);
				if(!$this->dbSelected)
				{
					trigger_error("MSSQL Error: Couldnt select database!" . PHP_EOL . mssql_get_last_message() . PHP_EOL);
					cLog::ErrorLog("MSSQL Error: Couldnt select database!" . PHP_EOL . "\t". mssql_get_last_message());
				}
			}
			else
			{
				exit;
			}
		}
		
		///<summary>
		///Execute given SQL Command and return the result set. Used for SELECT, SHOW, DESCRIBE, EXPLAIN, etc.
		///Return values: Success => MSSQL-Result Set | Failure => false
		///</summary>
		public function query($sqlString)
		{
			if($this->dbLink && $this->dbSelected)
			{
				$result = mssql_query($sqlString, $this->dbLink);
				if($result)
				{
					return $result;
				}
				else
				{
					trigger_error("MSSQL Error: " . mssql_get_last_message() . PHP_EOL);
					cLog::ErrorLog("MSSQL Error: " . mssql_get_last_message());
					return false;
				}
			}
			else
			{
				trigger_error("MSSQL Error: Not connected to a database server or database not selected!" . PHP_EOL);
				cLog::ErrorLog("MSSQL Error: Not connected to a database server or database not selected!");
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
				$result = mssql_query($sqlString, $this->dbLink);
				if($result)
				{
					return true;
				}
				else
				{
					trigger_error("MSSQL Error: " . mssql_get_last_message() . PHP_EOL);
					cLog::ErrorLog("MSSQL Error: " . mssql_get_last_message());
					return false;
				}
			}
			else
			{
				trigger_error("MSSQL rror: Not connected to a database server or database not selected!" . PHP_EOL);
				cLog::ErrorLog("MSSQL rror: Not connected to a database server or database not selected!");
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
				$result = mssql_query($sqlString, $this->dbLink);
				return mssql_num_rows($result);
			}
			else
			{
				trigger_error("MSSQL Error: Not connected to a database server or database not selected!" . PHP_EOL);
				cLog::ErrorLog("MSSQL Error: Not connected to a database server or database not selected!");
				return false;
			}
		}
		
		///<summary>
		///Fetch a result row as an associative array, a numeric array, or both
		///Return values: Success => Array | Failure: Error Message
		///</summary>
		function fetchArray($sqlString) {
			$arr = mssql_fetch_array($this->query($sqlString));
			if(!$arr)
			{
				trigger_error("MSSQL Error: " . mssql_get_last_message() . PHP_EOL);
				cLog::ErrorLog("MSSQL Error: " . mssql_get_last_message());
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
			
			return mysql_real_escape_string($data);
		}
		
		///<summary>
		///Closes connection to DB
		///Return values: none
		///</summary>
		public function close()
		{
			mssql_close($this->dbLink);
		}
	}

?>