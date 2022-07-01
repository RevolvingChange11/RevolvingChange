<?php 
	if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'pc-54' || $_SERVER['HTTP_HOST'] == 'pc-50' ||  $_SERVER['HTTP_HOST'] == '192.168.0.111'){

	    $Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";
		
	    $SITEURL = $Protocol.$_SERVER['HTTP_HOST']."/JRR2401/";
	    $ADMINURL = $Protocol.$_SERVER['HTTP_HOST']."/JRR2401/apanel/";
	}
	else 
	{
	    $SITEURL = "http://finitycodes.com/works/revolvingchange/";
	    $ADMINURL = "http://finitycodes.com/works/revolvingchange/apanel/";
	}       
		
	define('SITEURL', $SITEURL);
	define('ADMINURL', $ADMINURL);
	define('SITENAME','Revolving Change');
	define('SITETITLE','Revolving Change');
	define('ADMINTITLE','Revolving Change');
	define('CURR','&dollar;');				
?>