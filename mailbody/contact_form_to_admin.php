<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";


//$re = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
$re = "margin:0 auto;background-color:#fff;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
$body = '<table width="600px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom:30px; border:none; text-align:center;"><img src="'.SITEURL.'images/email-logo.png" style="width:180px;margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="padding:30px; background-color:#fff; border:none; border-radius:5px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size:16px;" align="left">
						Hello Administrator, <br /><br />
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:30px;" align="left">
						You have received a new contact request from '.$name.'.
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:30px;" align="left">
						The details are as follows:
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Email : </strong> ' .$email. ' 
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Contact Number : </strong> ' .$phone_number. ' 
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Subject : </strong> ' . $subject . ' 
					</td>
				</tr> 
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Message : </strong> ' . $message . '
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:30px;" align="left">
						'.SITETITLE.' Team.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>