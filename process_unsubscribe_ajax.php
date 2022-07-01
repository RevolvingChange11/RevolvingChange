<?php

include 'connect.php';

	if($_REQUEST['id']!="" && !empty($_REQUEST['id']))
	{
		
		$update_array=array(
			"opt_out" 			=> 1,
		);		
		$db->update("stay_connected",$update_array,"id=".$_REQUEST['id']);
		$_SESSION['MSG'] = "Successfully unsubscribe";
		
	}

?>