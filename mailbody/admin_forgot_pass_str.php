<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";
$reseturl 	= ADMINURL."set-new-password/".md5($id)."/".$fps."/";

$re = "margin:0 auto; background-image:url(".$bg_img."); background-repeat:no-repeat; background-size:cover; padding:20px 20px; color:#404040; font-family:lato";
$body = '<table width="600px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom: 50px;border:none; text-align: center;"><img src="'.SITEURL.'images/email-logo.png" style="width:150px; margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="background-color:#fff; border:none; border-radius:5px;">
			<table width="100%" border="0" style="font-size: 16px; padding:10px;">
				<tr>
					<td style="padding-bottom: 30px; font-weight:bold;">
						We have received a request to reset your password. You can reset by clicking the button below. 
					</td>
				</tr> 
				<tr>
					<td align="center">
						<a href="'.$reseturl.'" style="background-color:#555555; border:none; color:white; padding:15px 32px; text-align:center; text-decoration:none; display:inline-block; font-size:16px; margin:4px 2px; cursor:pointer;" class="button">Reset Your Password</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>