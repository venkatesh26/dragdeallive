 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Name</div>
                  <div class="no-overflow"> 
					  <i class="fa fa-tag"></i> <?php echo ucwords($list['name']);?><br/> 
					  <i class="fa fa-list-alt"></i> <?php echo ucwords($list['add_name']);?> <br/> 
					  <i class="fa fa-mobile"></i> <?php echo $list['contact_number'];?>  
				  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Coupon Code</div>
                  <div class="no-overflow"> <?php echo $list['code'];?>  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Expiry Date  </div>
                  <div class="no-overflow">  <?php echo date('d-M-Y',strtotime($list['exipry_date']));?></div>
				</div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Date</div>
                  <div class="no-overflow"> <?php echo date('d-M-Y',strtotime($list['created']));?> </div>
               </div>
			     <div class="item-col item-col-date">
                  <div class="item-heading">Status</div>
                  <div class="no-overflow">
				  <?php
				      $today=date('Y-m-d');
					  if($today < date('Y-m-d',strtotime($list['exipry_date']))):
					  echo '<span class="btn btn-primary btn-sm">Active</span>';
					  
					  else:
					  echo '<span class="btn btn-danger btn-sm">Expired</span>';
					  endif;
				  ?>
				 </div>
               </div>
            </div>
         </li>
  <?php endforeach;
  if(count($order_list) <=0){?>
	<li class="item"> 	   
	   <div class="item-row">
		   <div class="item-col item-col-category no_list_found">
			  <div class="no-overflow no_list_found">   No Downloads Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 