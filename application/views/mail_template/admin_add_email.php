<tr>
	<td align="left" valign="top" style="padding-left:20px;padding-top:20px;padding-bottom:20px;border:1px solid #ccc;border-width:0px 1px 0px 1px;font:normal 12px Tahoma;">
		Dear <?php echo '<span style="font-weight:bold;">'.ucfirst($user_name).'</span>'; ?>, <br/><br/>
		<?php echo ucfirst(nl2br($message)).'</span>'; ?> <br/><br/>
	 <br/>
	 <br/>
		You can access your account. <?php echo anchor(base_url().'login', 'Click here'); ?>
	</td>        
</tr>