 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-category">
                  <div class="item-heading">Plan Name</div>
                  <div class="no-overflow"> <?php echo $list['plan_name'];?>  </div>
               </div>
               <div class="item-col item-col-newtitle">
                  <div class="item-heading">PaymentID</div>
                  <div class="no-overflow"> <?php echo $list['payment_id'];?>  </div>
               </div>
               <div class="item-col fixed item-col-title">
                  <div class="item-heading">Buyer Info</div>
                  <div class="no-overflow"> <i class="fa fa-user"></i> <?php echo ucwords($list['buyer_name']);?><br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['buyer_email']);?>  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Price </div>
                  <div class="no-overflow"> <?php echo $list['currency']." ".$list['amount'];?>  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Status </div>
                  <div class="no-overflow">
                     <?php
                        if(strtolower($list['payment_status'])=='success'):?>
                     <span class="btn btn-primary btn-sm">Success</span>  
                     <?php else:?>
                     <span class="btn btn-danger btn-sm">Failure</span>  
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
                              <a class="remove order_detail" href="#" data-price="<?php echo $list['currency']." ".$list['amount'];?> " data-date="<?php echo date('d -F-Y',strtotime($list['created']));?>" data-paymentId="<?php echo $list['payment_id'];?>"  data-plan-name="<?php echo $list['plan_name'];?>" data-toggle="modal" data-status="<?php echo $list['status'];?>" data-info='<i class="fa fa-user"></i> <?php echo ucwords($list['buyer_name']);?><br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['buyer_email']);?>' data-target="#order-detail-modal"> <i class="fa fa-list"></i> </a>
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
			  <div class="no-overflow">   No Orders Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 