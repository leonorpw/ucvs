<?php

	$whitelist = Array(
		"xtremetop100" => "199.59.161.214",
		"arena-top100" => "198.20.70.235",
		"gtop100" => "198.148.82.98",
		"silkroad-servers" => "78.46.67.100",
		"private-server" => "178.63.126.52",
		"topg" => "104.24.15.11",
		"top100arena" => "104.24.2.32",
		"ich" => "5.146.225.126"
	);
	
	function checkIP($ip)
	{
		global $whitelist;
		if(in_array($ip, $whitelist))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	$reqIP = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
	
	if(checkIP($reqIP) != true)
		echo 'nope';
	else
		echo 'jup';
?>