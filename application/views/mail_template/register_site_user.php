<tr>
	<td align="left" valign="top" style="padding-left:20px;padding-top:20px;padding-bottom:20px;border:1px solid #ccc;border-width:0px 1px 0px 1px;font:normal 12px Tahoma;">
		Dear <?php echo '<span style="font-weight:bold;">'.ucfirst($user_name).'</span>'; ?>, <br/><br/>
		Your <?php echo admin_settings_initialize('sitename'); ?> account has been created successfully. Please click the link to verify your account with us by using the login credentials
		<br/><br/>
	   <table width="511" border="0" cellspacing="0" cellpadding="0">
			 <tr>
				<td width="125" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px 8px 10px;" bgcolor="#e9e9e9">Email</td>
				<td width="386" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px;text-decoration:none;" bgcolor="#e9e9e9"><?php echo $user_email; ?></td>
			  </tr>
			  
			    <tr>
				<td width="125" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px 8px 10px;" bgcolor="#e9e9e9">Password</td>
				<td width="386" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px;text-decoration:none;" bgcolor="#e9e9e9"><?php echo $password; ?></td>
			  </tr>
	 </table>
	 <br/>
	 Please <?php echo anchor(base_url().'users/verify/'.$verifylink, 'Click here'); ?> to  verify your Email <br/>
	 <br/>
	Once your account is verified, you can access your account please <?php echo anchor(base_url().'login', 'Click here'); ?>
	</td>        
</tr>
