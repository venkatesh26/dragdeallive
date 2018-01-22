 <?php foreach($order_list as $list): ?>
	<li class="item">
		<div class="item-row">
		   <div class="item-col item-col-category">
			  <div class="item-heading">Name</div>
			  <div class="no-overflow"> <?php echo ucwords($list['first_name']);?>  </div>
		   </div>
		   <div class="item-col item-col-newtitle">
			  <div class="item-heading">Bill AMount</div>
			  <div class="no-overflow" style="margin-left:80px"> <b><?php echo number_format($list['total_amount']);?> </b> </div>
		   </div>
		   <div class="item-col fixed item-col-title">
			  <div class="item-heading">Contact Info</div>
			  <div class="no-overflow"> 
			  <i class="fa fa-phone"></i> <?php echo ucwords($list['mobile_number']);?><br/>
			  <?php if($list['email']!=''):?><i class="fa fa-envelope"></i> <?php echo ucwords($list['email']);?><?php endif;?>  </div>
		   </div>
		   <div class="item-col item-col-author">
			  <div class="item-heading">Visit Count </div>
			  <div class="no-overflow"> <span class="btn btn-primary btn-sm"><?php echo $list['visit_count'];?> </span> </div>
		   </div>
		   <div class="item-col item-col-date">
			  <div class="item-heading">Status </div>
			  <div class="no-overflow">
				 <?php
					if(strtolower($list['is_active'])):?>
				 <span class="btn btn-primary btn-sm">Active</span>  
				 <?php else:?>
				 <span class="btn btn-danger btn-sm">InActive</span>  
				 <?php endif;?>										
			  </div>
		   </div>
		   <div class="item-col item-col-author">
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
						  <a class="remove view-btn-setting" href="#"  rel="<?php echo $list['user_id'];?>" > <i class="fa fa-list"></i> </a>
					   </li>
					   <li>
						  <a class="remove cutomer_detail_delete" href="#" rel="<?php echo $list['user_id'];?>" data-toggle="modal" data-target="#confirm-delete-modal"> <i class="fa fa-trash"></i> </a>
					   </li>
					   <li>
						  <a class="remove order_detail" href="<?php echo base_url().'customers/edit/'.$list['user_id'];?>"> <i class="fa fa-pencil"></i> </a>
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
			  <div class="no-overflow no_list_found">   No Customers Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 