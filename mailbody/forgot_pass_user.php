<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";
$reseturl 	= SITEURL."set-new-password/".md5($id)."/".$fps."/";
//$sitelogo_img = SITEURL."images/logo-mobile.png";
$sitelogo_img = SITEURL."images/email-logo.png";

$ta = "margin:0 auto; padding: 20px 20px; color: #404040; font-family: 'Space Grotesk', sans-serif; border-radius: 10px; background: #fff";

$body = '
<table width="700px" border="0" style="'.$ta.'">
	<tr>
		<td style="margin: 7px;vertical-align: middle; text-align: center;"><img src='.$sitelogo_img.' style="margin-bottom: 10px; max-width: 250px; margin-left: auto; margin-right: auto; display: block; text-align: center;"></td>
	</tr>
	<tr>
		<td style="padding:0px 0px 0px 0px; border:none; border-radius: 10px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size: 20px; font-weight:700;padding:0px 50px 5px; font-family: Space Grotesk, sans-serif; color: #000;">Hi ' . $fname . '!</td>
				</tr>
				<tr>
					<td style="font-size: 16px; font-weight:normal;padding:0 30px 30px;line-height: 24px; font-family: Space Grotesk, sans-serif; color: #000;">
					We have received a request to reset your <strong>'.SITETITLE.'</strong> account password. If you did not request a password reset, please ignore this email or reply to let us know. You can reset by clicking the button below.
					</td>
				</tr>
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:0px 50px 30px;">
						<a href="'.$reseturl.'" style="padding: 9px 15px; display: inline-block !important; color: #ffffff; line-height: 32px; text-align: center; border-radius: 10px; background: hsl(224deg 62% 39%); min-width: 205px; display: flex; justify-content: center; align-items: center; font-family: Space Grotesk, sans-serif; font-weight: 700; font-size: 16px; text-decoration: none; margin: 4px 2px; cursor: pointer;">Reset Your Password</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>


