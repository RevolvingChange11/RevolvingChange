<?php
include("connect.php");

$email 		= $db->clean($_REQUEST['email']);
$password 	= $db->clean($_REQUEST['password']);
if($email!="" && $password!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	$check_user_r = $db->getData("user", "*", "email = '".$email."' AND  password = '".md5($password)."' AND isDelete=0");
	$check_user_d = @mysqli_fetch_assoc($check_user_r);

	if($check_user_d)
	{
		if($check_user_d['isActive']==1)
		{
			$id 	=  $check_user_d['id'];
			$name 	=  $check_user_d['name'];
			$email 	=  $check_user_d['email'];

			$_SESSION[SESS_PRE.'_SESS_USER_ID'] 	= 	$id;
			$_SESSION[SESS_PRE.'_SESS_USER_NAME'] 	= 	$name;
			$_SESSION[SESS_PRE.'_SESS_USER_EMAIL'] 	= 	$email;

			$_SESSION['MSG'] = 'Success_Login';
			$db->location(SITEURL);
		}
		else
		{
			$_SESSION['MSG'] = 'Acc_Not_Verified';
			$db->location(SITEURL."login/");
		}
	}
	else
	{
		$_SESSION['MSG'] = 'Invalid_Email_Password';
		$db->location(SITEURL."login/");
	}
}
else
{
	$_SESSION['MSG'] = 'Something_Wrong';
	$db->location(SITEURL."login/");
}
?>