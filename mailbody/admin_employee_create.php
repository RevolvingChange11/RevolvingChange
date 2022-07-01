<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";

$re = "margin:0 auto; background-image:url(".$bg_img."); background-repeat:no-repeat;background-size:cover; padding:20px 20px; color:#404040; font-family:lato";
$body = '<table width="600px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom:50px; border:none; text-align:center;"><img src="'.SITEURL.'images/email-logo.png" style="width:150px; margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="background-color:#fff; border:none; border-radius:5px;">
			<table width="100%" border="0" style="font-size: 16px; padding:10px;">
				<tr>
					<td>
						Hello ' . $name . ', <br /><br />
					</td>
				</tr> 
				<tr>
					<td>
						Site admin has created your account on ' . SITETITLE . '. <br /><br />
					</td>
				</tr> 
				<tr>
					<td>
						The details are as follows: <br />
					</td>
				</tr> 
				<tr>
					<td>
						<strong>Email:</strong> ' . $email . '
					</td>
				</tr> 
				<tr>
					<td>
						<strong>Password:</strong> ' . $password . ' <br /><br />
					</td>
				</tr> 
				<tr>
					<td>
						Greetings, <br />
						<strong>' . SITETITLE . '</strong> Team.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>