<tr>
	<td align="left" valign="top" style="padding-left:20px;padding-top:20px;padding-bottom:20px;border:1px solid #ccc;border-width:0px 1px 0px 1px;font:normal 12px Tahoma;">
		Dear <?php echo $username; ?>, <br/><br/>
                Don't worry if you have lost your password. You can easily reset your password by clicking on the link.
	<br/><br/>
	<table width="511" border="0" cellspacing="0" cellpadding="0">
		 <tr>
			<td width="125" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px 8px 10px;" bgcolor="#e9e9e9">Email</td>
			<td width="386" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px;text-decoration:none;" bgcolor="#e9e9e9"><?php echo $user_email; ?></td>
		  </tr>
	</table>   
	 <br/>
	 To reset your password, <?php echo anchor($resetpassword_url, 'Click here'); ?>
	</td>        
</tr>