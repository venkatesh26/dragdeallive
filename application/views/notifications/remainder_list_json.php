 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Title </div>
                  <div class="no-overflow"> <?php echo $list['name'];?>  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Remainder Type</div>
                  <div class="no-overflow remainder_type"> 
				  <?php 
					  if($list['remainder_type_id']==1) {
						 echo "<i class='fa fa-birthday-cake cursor' title='Birthday'></i>";
					  }
					  else if($list['remainder_type_id']==2) {
						   echo "<i class='fa fa-gift cursor' title='Aniversery'></i>";
					  }
					  else {  
						echo "<i class='fa fa-shield cursor' title='Service'></i>";
					  }
				  ?>
				  </div>
               </div>
               <div class="item-col fixed item-col-title">
                  <div class="item-heading">Period</div>
                  <div class="no-overflow">  
					  <?php 
						  if($list['remainder_period_type']==1) {
							 echo "Before Remainder Date";
						  }
						  else if($list['remainder_period_type']==2) {
							   echo "On Remainder Date";
						  }
						  else {  
							   echo "After Remainder Date";
						  }
					  ?>
				  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Status </div>
                  <div class="no-overflow">
                     <?php
                        if(strtolower($list['is_active'])=='1'):?>
                     <span class="btn btn-primary btn-sm">Active</span>  
                     <?php else:?>
                     <span class="btn btn-danger btn-sm">InActive</span>  
                     <?php endif;?>										
                  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading"> Date</div>
                  <div class="no-overflow"> <?php echo date('d-m-Y',strtotime($list['created']));?> </div>
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
                              <a class="remove order_detail" href="#" data-date="<?php echo date('d -F-Y',strtotime($list['created']));?>"  data-target="#order-detail-modal"> <i class="fa fa-list"></i> </a>
                           </li>
						    <li>
                              <a class="remove order_detail" href="#" data-date="<?php echo date('d -F-Y',strtotime($list['created']));?>"  data-target="#order-detail-modal"> <i class="fa fa-list"></i> </a>
                           </li>
						    <li>
                              <a class="remove order_detail" href="#" data-date="<?php echo date('d -F-Y',strtotime($list['created']));?>"  data-target="#order-detail-modal"> <i class="fa fa-list"></i> </a>
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
		   <div class="item-col item-col-category">
			  <div class="no-overflow no_list_found">   No List Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 