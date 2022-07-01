<?php
	include("connect.php");

	$id 		= $db->clean($_POST['id']);
	$slug 		= $db->clean($_POST['slug']);
	$password 	= $db->clean($_POST['cnew_password']);

	if($id != '' && $slug!="" && $password!="")
	{
		$check_user = $db->getData("user","*","md5(id) = '".$id."' AND forgot_string='".$slug."' AND isDelete=0");
		if($check_user)
		{
			$rows 	= array(
				"password"		=> md5($password),
				"forgot_string" => ""
			);
			$db->update("user",$rows,"md5(id)='".$id."' AND isDelete=0");
			
			$_SESSION['MSG'] = 'Update_Pass';
			$db->location(SITEURL."login");
		}
		else
		{
			$_SESSION['MSG'] = 'Link_Expired';
			$db->location(SITEURL."forgot-password/");
		}
	}
	else
	{
		$_SESSION['MSG'] = "INVALID_DATA";
		$db->location(SITEURL."set-new-password/".$id."/".$slug."/");
		exit;
	}
?>