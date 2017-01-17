<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script 				 */
	/*		Written by LemoniscooL		   					 */
	/*	 released under GPLv3 license	  						 */
	/***************************************/

	class cMSSQL
	{
		var $dbLink;	//Stores the DB connection result set
		
		///<summary>
		///Constructor being executed at object creation, initialize members.
		///Return values: none
		///</summary>
		public function __construct()
		{
			$dbLink = false;
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
			$instance->connect($host, $id, $pw, $db);
			return $instance;
		}
		
		///<summary>
		///Get error messages and warnings about the last SQLSRV operation performed and return them in a readable way.
		///Possible error levels: SQLSRV_ERR_ALL, SQLSRV_ERR_ERRORS, SQLSRV_ERR_WARNINGS
		///Return values: Error message(s) from sqlsrv_errors()
		///</summary>
		private function getLastErrors($level = SQLSRV_ERR_ALL)
		{
			$errors = sqlsrv_errors($level);
			$messages = "";
			
			foreach($errors as $error)
			{
				$messages .= "[" . $error['SQLSTATE'] . "] " . "[Code: " . $error['code'] . "] " . $error['message'] . PHP_EOL;
			}
			
			return $messages;
		}
		
		///<summary>
		///Connect to the DB Server with given connection details
		///Return values: none
		///</summary>
		private function connect($host, $id, $pw, $db)
		{
			if(!$this->dbLink)
			{
				$this->dbLink = sqlsrv_connect($host, array("Database" => $db, "UID"=>$id, "PWD"=>$pw));
				if(!$this->dbLink)
				{
					trigger_error("Couldn't connect to database!" . PHP_EOL . $this->getLastErrors() . PHP_EOL);
				}
			}
			else
			{
				exit;
			}
		}
		
		///<summary>
		///Execute given SQL Command and return the result set. Used for SELECT, SHOW, DESCRIBE, EXPLAIN, etc.
		///Return values: Success => MSSQL-Result Set | Failure => Error Message
		///</summary>
		public function query($sqlString)
		{
			if($this->dbLink)
			{
				$result = sqlsrv_query($this->dbLink, $sqlString);
				if($result)
				{
					return $result;
				}
				else
				{
					return "Error: " . $this->getLastErrors() . PHP_EOL;
				}
			}
			else
			{
				return "Error: Not connected to a database server!" . PHP_EOL;
			}
		}
		
		///<summary>
		///Execute given SQL Command without returning any result sets. Used for INSERT, UPDATE, DELETE, DROP, etc.
		///Return values: Success => True | Failure => Error Message
		///</summary>
		public function execute($sqlString)
		{
			if($this->dbLink)
			{
				$result = sqlsrv_query($this->dbLink, $sqlString);
				if($result)
				{
					return true;
				}
				else
				{
					return "Error: " . $this->getLastErrors() . PHP_EOL;
				}
			}
			else
			{
				return "Error: Not connected to a database server or database not selected!" . PHP_EOL;
			}
		}
		
		///<summary>
		///Execute given SQL command and return number of results.
		///Return values: Success => Number of results | Failure => Error Message
		///</summary>
		public function numRows($sqlString)
		{
			if($this->dbLink)
			{
				$result = sqlsrv_query($this->dbLink, $sqlString);
				return sqlsrv_num_rows($result);
			}
			else
			{
				return "Error: Not connected to a database server or database not selected!" . PHP_EOL;
			}
		}
		
		///<summary>
		///Fetch a result row as an associative array, a numeric array, or both
		///Return values: Success => Array | Failure: Error Message
		///</summary>
		function fetchArray($sqlString) {
			$arr = sqlsrv_fetch_array($this->query($sqlString));
			if(!$arr)
			{
				return "Error: " . $this->getLastErrors() . PHP_EOL;
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
			sqlsrv_close($this->dbLink);
		}
	}

?>