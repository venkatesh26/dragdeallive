<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	   <title><?php echo admin_settings_initialize('sitename'); ?>.com : Mailer</title>
	</head>
	<body>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		   <tr>
				<td align="center" valign="top">
					 <table width="550" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
						   <tr bgcolor="#ffffff;">
							   <td align="center" valign="top" style="border:1px solid #ccc;background:#eee !important;padding:10px 20px"><?php echo anchor(base_url(), img(base_url().'assets/themes/images/new_logo.png')); ?></td>
							</tr>
							<?php echo $contents; ?>
							<tr style="background:#eee !important;"><td style="padding-left:20px;padding-top:0px;padding-bottom:20px;padding-right:20px;border:1px solid #ccc;border-width:0px 1px 1px 1px;font:normal 12px Tahoma;">
							<span style="display:block;background:#ccc;height:1px;margin-bottom:20px;"></span>
							<strong>Thanks & Regards,</strong> </br></br></br><span style="color: #8c9398;font-weight: bold;display:block;margin-top:10px;"><?php echo admin_settings_initialize('sitename'); ?> Support Team</span> </td></tr>
				  </table>
			  </td>
		  </tr>
	   </table>
	</body>
</html>