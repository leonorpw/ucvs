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
			"xtremetop100" => "199.59.161.214",
			"arena-top100" => "184.154.46.75",
			"arena-top100" => "184.154.46.76",
			"gtop100" => "198.148.82.98",
			"silkroad-servers" => "193.70.3.149",
			"private-server" => "79.137.80.26",
			"topg" => "104.24.15.11",
			"top100arena" => "104.24.2.32"
		);
	}

	include_once("userconfig.class.php");

?>









