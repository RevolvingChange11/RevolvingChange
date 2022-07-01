<?php
$bg_img = SITEURL."mailbody/images/bg1.jpg";
// $ta = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
$ta = "margin:0 auto;background-color:#fff;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
$body = '
<table width="600px" border="0" style="'.$ta.'">
	<tr>
		<td style="padding-bottom: 36px;border:none; text-align: center;"><img src="'.SITEURL.'mailbody/images/email-logo.png" style="width:180px;margin-top:5px;"></td>
	</tr>
	<tr>
		<td style="padding:30px 0px 0px 0px; background-color: #fff;border:none; border-radius: 5px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:0px 50px 5px;">Thanks for signing up!</td>
				</tr>
				<tr>
					<td style="font-size: 14px; font-weight:normal;padding:0 30px 30px;line-height: 20px;">Your account has been created, you can login after you have activated your account by clicking the activate account button below.
					</td>
				</tr>
				<tr>
					<td style="padding:0 84px 30px;"><a href="'.SITEURL.'activate-account/'.md5($uid).'/'.$confirmation_string.'/" style="padding: 15px; display: inline-block !important; color: #ffffff; line-height: 32px; text-align: center; border-radius: 8px; background: hsl(224deg 62% 39%); min-width: 162px; display: flex; justify-content: center; align-items: center; font-family: \'Mier A\'; font-weight: 700; font-size: 24px; text-decoration: none; margin: 4px 2px; cursor: pointer;">Activate Account</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>