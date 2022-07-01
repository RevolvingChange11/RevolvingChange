<?php 
	include("connect.php");

	$activation_code = $db->clean($_REQUEST['activation_code']);
	$id = $db->clean($_REQUEST['uid']);

	if($activation_code != "")
	{
		$check_dup = $db->getValue("user", 'id', "confirmation_string = '".$activation_code."' AND isDelete=0");

		if(!$check_dup)
		{
			$_SESSION['MSG'] = "Something_Wrong";
			$db->location(SITEURL."signup/");
			exit;
		}
		else
		{
			$ctable_d = @mysqli_fetch_assoc($check_dup);

			$where = "confirmation_string='".$activation_code."' AND isDelete=0";
			$row = array(
				"isActive" => '1'
			);
			$check = $db->update('user', $row, $where);

			if( $check )
			{
				/* START: send confirmation/welcome email */
                include("include/notification.class.php");
                $nt = new Notification();

                $rsuser = $db->getData('user', 'id, name, email', $where);
                $rowuser = @mysqli_fetch_assoc($rsuser);
                $name = $rowuser['name'];
                $email = $rowuser['email'];

                $subject = SITETITLE." Account Activated";
                include("mailbody/welcome_user.php");

                // die($body);
                $toemail = $email;
                $nt->sendEmail($toemail, $subject, $body);
				/* END: send confirmation/welcome email */

				$_SESSION['MSG'] = "Activate_account_success";
				$db->location(SITEURL.'login/');
				exit;
			}
		}
	}
	else
	{
		$_SESSION['MSG'] = "Something_Wrong";
		$db->location(SITEURL."signup/");
		exit;
	}
?>