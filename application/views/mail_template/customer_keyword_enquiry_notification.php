<tr>
	<td align="left" valign="top" style="padding-left:20px;padding-top:20px;padding-bottom:20px;border:1px solid #ccc;border-width:0px 1px 0px 1px;font:normal 12px Tahoma;">
		Dear <?php echo '<span style="font-weight:bold;">'.ucfirst($user_name).'</span>'; ?>, <br/><br/>
		<p>Thanks for spending a valueable time.The following best bussines details we shared to you.</p><br/>
		<br/><br/>
	 <br/>     
	  <?php 
	  foreach($bData as $data):
	  ?>
		  <table width="511" border="0" cellspacing="0" cellpadding="0">
				 <tr>
					<td width="125" align="left" valign="top" style="font:normal 12px Tahoma;color:#585858;padding:8px 0px 8px 10px;" bgcolor="#e9e9e9"><?php echo $data;?></td>
				  </tr>
		 </table>
	 <?php endforeach;?>
</tr>