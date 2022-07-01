<?php
	ob_start();
    error_reporting(E_ALL);
	//error_reporting(E_ALL);
	session_start();
	date_default_timezone_set('Australia/Melbourne');
	
	include("include/define.php");
	include("include/function.class.php");

    /* START: for Australia Post */ 
    // $strauth = base64_encode(API_KEY . ':' . API_SECRET);
    // $headers = array(
    //     "Content-Type: application/json", 
    //     "Accept: application/json", 
    //     "Account-Number: ".ACNO_EPARCEL_INTERNATIONAL,
    //     "Authorization: Basic ".$strauth
    // );
    // $url = PRODUCTION_URL;  // TESTBED_URL / PRODUCTION_URL
    /* END: for Australia Post */ 

	$db = new Cart();

?>