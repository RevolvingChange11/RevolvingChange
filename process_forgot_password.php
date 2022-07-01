<?php
    include("connect.php");
    include("include/notification.class.php");
    
    $ctable		= "user";
    $email 		= $db->clean($_POST['email']);

    if($email!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
    	$check_user_r = $db->getData($ctable,"*","email = '".$email."' AND isDelete=0 AND isActive=1");
    	if(@mysqli_num_rows($check_user_r)>0)
    	{
    		$check_user_d = @mysqli_fetch_assoc($check_user_r);
    		$id 		=  $check_user_d['id'];
    		$fname 		=  $check_user_d['name'];
    		$email 		=  $check_user_d['email'];
    		
    		$random1 	= substr(md5(rand()), 0, rand(1,6));
    		$random2 	= substr(md5(rand()), 0, rand(1,7));
    		$random3 	= substr(md5(rand()), 0, rand(1,6));
    		$random4 	= substr(md5(rand()), 0, rand(1,8));
    		$fps		= rand(0,2).$random1.rand(0,3).$random2.rand(0,1).$random3.rand(0,3).$random4;
    		
    		$where		= "id=".$id;
    		$rows 		= array("forgot_string"=>$fps);
    		$db->update("user", $rows, $where);
    		$reseturl = SITEURL.'set-new-password/'.md5($id).'/'.$fps.'/';
    
    		if(ISMAIL)
    		{
     			$nt = new Notification();
     			include("mailbody/forgot_pass_user.php");
     			$subject	= SITETITLE." Password Recovery";
     			$toemail = $email;
     			// die($body); 
     		    $nt->sendEmail($toemail, $subject, $body); 
    		}

    		$_SESSION['MSG'] = "Success_Fsent";
    		$db->location(SITEURL."login/");
    		exit;
    	}
    	else
    	{
    		$_SESSION['MSG'] = 'Email_not_found';
    		$db->location(SITEURL."forgot-password/");
    		exit;
    	}
    }
    else
    {
    	$_SESSION['MSG'] = 'Invalid_Email';
    	$db->location(SITEURL."forgot-password/");
    	exit;
    }
?>