<?php
/***************************************/
/* UCVS - Unified Callback Vote Script */
/*		Written by LemoniscooL		   */
/*	 released under GPLv3 license	   */
/***************************************/

require_once("classes/ucvs.class.php");

$ucvs = new ucvsCore();

//Check witch request method was used and create a reference
switch($_SERVER['REQUEST_METHOD'])
{
	case 'GET':
		$the_request = &$_GET;
	break;
	
	case 'POST':
		$the_request = &$_POST;
	break;
}

//store requesting IP in a variable | compatibility with CloudFlare
$reqIP = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

//Check if requesting IP is whitelisted
$check = $ucvs->checkIP($reqIP);
if($check !== true) //IP is invalid or not whitelisted
{
	if($check !== false)
	{
		//TODO: logging
		echo $check; //IP is invalid
	}
	else
	{
		//TODO: logging
		echo 'Wrong IP!'; //IP is not whitelisted
	}
}
else 
{
	$result = $ucvs->procData($the_request, $reqIP); //IP is whitelisted, process data
	if($result !== true)//Processing failed, output error
	{
		//TODO: logging
		echo $result;
	}
	else
	{
		//TODO: logging
		echo 'OK';
	}
}

?>