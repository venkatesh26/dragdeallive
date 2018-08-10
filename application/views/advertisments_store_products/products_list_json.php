 <?php foreach($order_list as $list): ?>
	<li class="item">
		<div class="item-row">
		   <div class="item-col item-col-newtitle">
			  <div class="item-heading">Name</div>
			  <div class="no-overflow"> <?php echo ucwords($list['name']);?>  </div>
		   </div>
		   <div class="item-col item-col-newtitle">
			  <div class="item-heading">Price</div>
			  <div class="no-overflow" style="margin-left:100px"> <b><?php echo number_format($list['price']);?> </b> </div>
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
						  <a class="remove product_detail_delete" href="#" rel="<?php echo $list['product_id'];?>" data-toggle="modal" data-target="#confirm-delete-modal"> <i class="fa fa-trash"></i> </a>
					   </li>
					   <li>
						  <a class="remove order_detail" href="<?php echo base_url().'advertisments_store_products/edit/'.$list['id'];?>"> <i class="fa fa-pencil"></i> </a>
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
			  <div class="no-overflow no_list_found">   No Products Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 