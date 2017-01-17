<?php
/***************************************/
/* UCVS - Unified Callback Vote Script */
/*		Written by LemoniscooL		   */
/*	 released under GPLv3 license	   */
/***************************************/


/*=================================================================================*/
/* Debug settings																   */
/* These settings are solely for debug purposes, dont change anything here!		   */
/*=================================================================================*/

//Uncomment to show all errors except notice and warnings
error_reporting(E_ALL);

//in case no errors are shown uncomment this
ini_set("display_errors", 1);

require_once("classes/ucvs.class.php");

$ucvs = new ucvsCore();

//Check wich request method was used and create a reference
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
if($check != true)
{
	$ucvs->Log("Wrong IP requested UCVS! - IP: " . $reqIP);
	die('Wrong IP!');
}
else 
{
	$result = $ucvs->procData($the_request, $reqIP);
	if($result !== true)
	{
		$ucvs->Log("Error while processing data: " . $result . " - User ID: " . $ucvs->getUser($the_request) . " Site: " . $ucvs->getSite($reqIP));
		echo $result;
	}
	else
	{
		$ucvs->Log("Valid UCVS request finished successfull" . " - User ID: " . $ucvs->getUser($the_request) . " Site: " . $ucvs->getSite($reqIP));
		echo 'OK';
	}
}

?>