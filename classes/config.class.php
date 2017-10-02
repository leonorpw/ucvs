<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/

	class ucvsConfig
	{	
		/*=================================================================================*/
		/* Access settings																   */
		/*=================================================================================*/
		
		//This is a list of IPs allowed to access UCVS
		//!!!!Do NOT change this list unless you know what you are doing!!!!
		var $whitelist = Array(
			"199.59.161.214" => "xtremetop100",
			"184.154.46.76" => "arena-top100",
			"198.148.82.98" => "gtop100",
			"198.148.82.99" => "gtop100",
			"193.70.3.149" => "silkroad-servers",
			"79.137.80.26" => "private-server",
			"192.99.101.31" => "topg",
			"104.24.8.79" => "top100arena",
			"209.59.143.11" => "top100arena"
		);
	}

	include_once("userconfig.class.php");

?>









