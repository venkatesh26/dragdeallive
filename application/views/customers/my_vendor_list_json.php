 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Name</div>
                  <div class="no-overflow"> <?php echo $list['shop_name'];?>  </div>
               </div>

			     <div class="item-col item-col-title">
                  <div class="item-heading">Contact Info</div>
                  <div class="no-overflow"> <?php echo $list['contact_phone_number'];?>  </div>
               </div>

			   
			     <div class="item-col item-col-newtitle">
                  <div class="item-heading">Total Reward Points</div>
                  <div class="no-overflow"> <?php echo $list['shop_name'];?>  </div>
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