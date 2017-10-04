<?php

	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/

	function autoload($className)
	{
		//SQL Extension dependant class loading
		if($className == "cMSSQL")
		{
			if(function_exists("mssql_connect"))
			{
				$fileName = "cMSSQL.class.php";
			}
			else if(function_exists("sqlsrv_connect"))
			{
				$fileName = "cMSSQL.SQLSrv.class.php";
			}
		}
		else if($className == "cMySQL")
		{
			if(function_exists("mysqli_connect"))
			{
				$fileName = "cMySQL.class.php";
			}
		}
		else
		{
			$fileName = $className . ".class.php";
		}
		
		//require missing classes
		if (file_exists("classes/{$fileName}"))
		{
			require_once "classes/{$fileName}";
		}
	}

	spl_autoload_register("autoload");

?>
