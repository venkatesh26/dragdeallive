 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-newtitle">
                  <div class="item-heading">Sender ID</div>
                  <div class="no-overflow"> <?php echo $list['sender_id'];?>  </div>
               </div>
               <div class="item-col item-col-newtitle">
                  <div class="item-heading">Status </div>
                  <div class="no-overflow">
                     <?php
                     if(strtolower($list['is_active'])=='1'):?>
						<span class="btn btn-primary btn-sm">Approved</span>  
					 <?php elseif(strtolower($list['is_active'])=='2'):?>
					 <span class="btn btn-danger btn-sm">Decline</span>  
                     <?php else:?>
                     <span class="btn btn-danger btn-sm">Waiting For Approval</span>  
                     <?php endif;?>										
                  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Date</div>
                  <div class="no-overflow"> <?php echo date('d-F-Y',strtotime($list['created']));?> </div>
               </div>
            </div>
         </li>
         <?php endforeach;?> 
		<?php  if(count($order_list) <=0){?>
	<li class="item"> 	   
	   <div class="item-row">
		   <div class="item-col item-col-category no_list_found">
			  <div class="no-overflow">   No Sender ID Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 