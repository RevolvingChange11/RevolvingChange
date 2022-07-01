<?php
/*echo "<pre>";
print_r($_POST);die();*/
include("connect.php");
$last_login = date('Y-m-d H:i:s');
$last_ip 	= $db->get_client_ip();
$email 		= $db->clean($_POST['email']);
$password 	= $db->clean($_POST['password']);

if($email!="" && $password!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	$check_user_r2 = $db->getData(CTABLE_ADMIN,"*","email = '".$email."' AND  password = '".md5($password)."' AND isDelete=0");

	if(@mysqli_num_rows($check_user_r2)>0)
	{
		$check_user_r1 = $db->getData(CTABLE_ADMIN,"*","email = '".$email."' AND  password = '".md5($password)."' AND isDelete=0 AND active_account=1");
		
		if(@mysqli_num_rows($check_user_r1)>0)
		{
			$check_user_r = $db->getData(CTABLE_ADMIN,"*","email = '".$email."' AND  password = '".md5($password)."' AND isDelete=0 AND active_account=1 AND isApproved=1");
		
			if(@mysqli_num_rows($check_user_r)>0)
			{
				$check_user_d = @mysqli_fetch_assoc($check_user_r);

				$id 		=  $check_user_d['id'];
				$name 		=  $check_user_d['name'];
				
				$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] 		= 	$id;
				$_SESSION[SESS_PRE.'_ADMIN_SESS_NAME'] 		= 	$name;
				
				$rows 	= array("last_login"=>$last_login,"last_ip"=>$last_ip);
				$where	= "id='".$id."'";
				$db->update(CTABLE_ADMIN,$rows,$where);
				
				if(isset($_REQUEST['from']) && $_REQUEST['from']!="")
				{
					$db->location($_REQUEST['from']);
					exit;
				}
				else
				{
					$_SESSION['MSG'] = 'login_success';
					$db->location(ADMINURL."dashboard/");
					exit;
				}
			}
			else
			{
				$_SESSION['MSG'] = 'Not_approved';
				$db->location(ADMINURL);
			}
		}
		else
		{
			$_SESSION['MSG'] = 'Activate_account';
			$db->location(ADMINURL);
		}
	}
	else
	{
		$_SESSION['MSG'] = 'Invalid_Email_Password';
		$db->location(ADMINURL);
	}
}
else
{
	$_SESSION['MSG'] = 'Something_Wrong';
	$db->location(ADMINURL);
}
?>