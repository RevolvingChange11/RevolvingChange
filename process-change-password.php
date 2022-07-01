<?php
    include('connect.php');
  	
  	$where = " id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']." AND isDelete=0";
  	$user_r = $db->getData("user", "*", $where,1);
  	$user_d = @mysqli_fetch_assoc($user_r);
    
    $old_password	= $user_d['password'];
    $current_password		= md5(trim($_REQUEST['cpsw']));
    $new_password		= md5(trim($_REQUEST['npsw']));
    
  	if($old_password != $current_password)
  	{
    	$_SESSION['MSG'] = 'PASS_NOT_MATCH';
    	$db->location(SITEURL."change-password/");
    	exit;
  	}
  	else
  	{
    	$rows 	= array("password" => $new_password);
    	$where	= "id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']." AND isDelete=0";
    	$db->update("user", $rows, $where);

    	$_SESSION['MSG'] = 'PASS_CHANGED';
    	$db->location(SITEURL."profile/");
    	exit;
  	}
?>