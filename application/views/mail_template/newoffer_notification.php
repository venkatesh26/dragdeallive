<tr>
	<td align="left" valign="top" style="padding-left:20px;padding-top:20px;padding-bottom:20px;border:1px solid #ccc;border-width:0px 1px 0px 1px;font:normal 12px Tahoma;">
		Dear <?php echo '<span style="font-weight:bold;">'.ucfirst($user_name).'</span>'; ?>, <br/><br/>
		<?php echo ucfirst($hotel_name);?> added an new offer. <?php echo '['.ucfirst($offer_name).']';?><br/><br/>
		<a href="<?php echo $offer_link;?>">Click to View Offer </a>
		<br/>
	 <br/>
	 Thanks<br/>
	 <br/>
	 Sigin into <?php echo anchor(base_url().'login', 'hobitel'); ?>
	</td>        
</tr>