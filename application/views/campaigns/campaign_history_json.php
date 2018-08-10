 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Campaign Name</div>
                  <div class="no-overflow"> <?php echo substr($list['title'],0,85);?>  </div>
               </div>
			   <div class="item-col fixed item-col-author" style="padding-left:45px;">
                  <div class="item-heading">No Of Sms Delivered</div>
                <div class="no-overflow">
				  <span class='btn btn-primary btn-sm'><i title="No Of Sms Send" class="cursor fa fa-cloud-upload"></i> <?php echo $list['number_of_user_send'];?></span>
				    <span class='btn btn-primary btn-sm'><i title="No Of Sms Delivered" class="cursor fa fa-cloud-download"></i> <?php echo ucwords($list['number_of_user_received']);?></span>
				</div>
				</div>
			    <div class="item-col item-col-author">
                  <div class="item-heading">No Of Sms Delivered</div>
				  <div class="no-overflow"> <?php
                    if($list['campaign_type_id']==1){
						
						echo '<span class="btn btn-primary btn-sm">General</span>';
					}
					else{
						
						echo '<span class="btn btn-danger btn-sm">Offer</span>';
					} ?>
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
                              <a class="remove campaign_detail" href="#" data-title="<?php echo $list['title'];?>" data-msg="<?php echo $list['message'];?>" data-recsms="<?php echo $list['number_of_user_received'];?>" data-sendsms="<?php echo $list['number_of_user_send'];?>" data-date="<?php echo date('d-F-Y',strtotime($list['created']));?>" data-toggle="modal" data-target="#order-detail-modal"> <i class="fa fa-list"></i> </a>
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
			  <div class="no-overflow no_list_found">   No Histroy Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 