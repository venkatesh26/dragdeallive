 <?php foreach($order_list as $list): 
 ?>
	<li class="item">
		<div class="item-row">
		     <div class="item-col item-col-title">
			  <div class="item-heading">Date</div>
			  <div class="no-overflow"> <?php echo date('d-M-Y',strtotime($list['created']));?> </div>
		   </div>
		  <div class="item-col item-col-title">
			  <div class="item-heading">Offer Name</div>
			  <div class="no-overflow" style="margin-left:0px"> <b><?php echo $list['title'];?> </b> </div>
		   </div>
		   <div class="item-col item-col-date">
			  <div class="item-heading">Status </div>
			  <div class="no-overflow">
				 <?php
					if($list['is_redeemed']==1):?>
				 <span class="btn btn-primary btn-sm">Reedmed</span>  
				 <?php else:?>
				 <span class="btn btn-danger btn-sm">Not Used Yet</span>  
				 <?php endif;?>										
			  </div>
		   </div>
		
		   <div class="item-col fixed item-col-actions-dropdown">
		   <?php if($list['is_redeemed']==0):?>
			  <div class="item-actions-dropdown">
				 <a class="item-actions-toggle-btn"> <span class="inactive">
				 <i class="fa fa-cog"></i>
				 </span> <span class="active">
				 <i class="fa fa-chevron-circle-right"></i>
				 </span> </a>
				 <div class="item-actions-block">
					<ul class="item-actions-list">
					   <li>
						  <a data-toggle="modal" data-target="#confirm-reedem-modal" class="remove offer-reedme view-btn-setting" href="#"  rel="<?php echo $list['id'];?>" > <i class="fa fa-gift" title="Reedem"></i> </a>
					   </li>
					</ul>
				 </div>
			  </div>
			  <?php endif;?>
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