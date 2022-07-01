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
					<td style="font-size: 16px; font-weight:700;padding:0px 50px 5px;">Exolore the learning path with new course</td>
				</tr>
				<tr>
					<td style="font-size: 14px;">Hi '.$name_row['name'].',</td>
				</tr>
				<tr>
					<td style="font-size: 14px; font-weight:normal;padding:0 30px 30px;line-height: 20px;">We are exited to inform you that Revolving Change published new course of <b>'.$isPublish_r['name'].'</b>.It helps you to incresse your knowledge. you can get more details of '.$isPublish_r['name'].' in <a href="'.SITEURL.'courses/">Revolving Change</a>
					</td>
				</tr>
				<tr>
					<td style="padding:0 48px 30px;"><a href="'.SITEURL.'process-unsubscribe/'.$name_row['id'].'/">Unsubscribe</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>
