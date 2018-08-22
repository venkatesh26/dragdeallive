 <?php foreach($order_list as $list): ?>
	<li class="item">
		<div class="item-row">
		   <div class="item-col item-col-newtitle">
			  <div class="item-heading">Name</div>
			  <div class="no-overflow"> <?php echo Ucfirst($list['shop_name']);?>  </div>
		   </div>
		     <div class="item-col item-col-newtitle">
			  <div class="item-heading">Mobile Number</div>
			  <div class="no-overflow">   <i class="fa fa-phone"></i> <?php echo ucwords($list['contact_phone_number']);?><br/>
			  <?php if($list['email']!=''):?><i class="fa fa-envelope"></i> <?php echo ucwords($list['contact_email']);?><?php endif;?> </div>
		   </div>
		   <div class="item-col item-col-newtitle">
			  <div class="item-heading">Price</div>
			  <div class="no-overflow" style="margin-left:100px"> <b><?php echo number_format($list['amount']);?> </b> </div>
		   </div>
		   
		   <div class="item-col item-col-date">
			  <div class="item-heading">Date</div>
			  <div class="no-overflow"> <?php echo date('d-M-Y',strtotime($list['created']));?> </div>
		   </div>
		   <div class="item-col fixed item-col-actions-dropdown">
			  <div class="item-actions-dropdown">
				 <a class="item-actions-toggle-btn"> <span class="inactive">
				 <i class="fa fa-cog"></i>
				 </span> <span class="active">
				 <i class="fa fa-chevron-circle-right"></i>
				 </span> </a>
				 <div class="item-actions-block">
					<ul class="item-actions-list">
					   <li>
						  <a class="remove order_detail" target="_blank" href="<?php echo base_url().'advertisments_customer_bills/my_order_detail/'.$list['id'];?>"> <i class="fa fa-list-alt"></i> </a>
					   </li>
					</ul>
				 </div>
			  </div>
		   </div>
		</div>
	</li>
  <?php endforeach;
  if(count($order_list) <=0){?>
	<li class="item"> 	   
	   <div class="item-row">
		   <div class="item-col item-col-category no_list_found">
			  <div class="no-overflow no_list_found">   No Orders Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 