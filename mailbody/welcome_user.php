<?php
$bg_img = SITEURL."mailbody/images/bg1.jpg";
$sitelogo_img = SITEURL."images/email-logo.png";

$ta = "margin:0 auto; padding: 20px 20px; color: #404040; font-family: 'Space Grotesk', sans-serif; border-radius: 10px; background: #fff";
$body = '
<table width="700px" border="0" style="'.$ta.'">
	<tr>
		<td style="margin: 7px;vertical-align: middle; text-align: center;"><img src='.$sitelogo_img.' style="margin-bottom: 10px; max-width: 250px; margin-left: auto; margin-right: auto; display: block; text-align: center;"></td>
	</tr>
	<tr>
		<td style="padding:0; border:none; border-radius: 10px;">
			<table width="100%" border="0" style="text-align: left;">
				<tr>
					<td style="font-size: 20px; padding:0px 50px 15px;font-family: Space Grotesk, sans-serif; color: #000;">Hello ' . $name . ',</td>
				</tr>
				<tr>
					<td style="font-size: 16px; padding:0px 50px 10px; font-family: Space Grotesk, sans-serif; color: #000;">Your '.SITENAME.' profile has been activated.</td>
				</tr>
				<tr>
					<td style="font-size: 16px; padding:0px 50px 5px;line-height: 24px; font-family: Space Grotesk, sans-serif; color: #000;">You can access your account below:
					</td>
				</tr>
				<tr>
					<td style="padding:10px 84px 30px; text-align: center;"><a href="'.SITEURL.'login/" style="padding:11px 15px;display:inline-block;font-size: 16px; color: #fff;background-color: hsl(224deg 62% 39%); text-decoration:none; text-align:center; font-family: Space Grotesk, sans-serif; font-weight: 700;border-radius: 10px; width:205px;">Login</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>