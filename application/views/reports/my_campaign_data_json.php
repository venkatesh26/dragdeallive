 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Camaign Name</div>
                  <div class="no-overflow"> <?php echo substr($list['campaign_title'],0,55);?>  </div>
               </div>
               <div class="item-col item-col-title">
                  <div class="item-heading">Buyer Info</div>
                  <div class="no-overflow"> <i class="fa fa-user"></i> <?php echo ucwords($list['mobile_number']);?><br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['email']);?>  </div>
               </div>	
               <div class="item-col item-col-author">
                  <div class="item-heading">Type </div>
                  <div class="no-overflow"> 
				  <?php
                        if(strtolower($list['camping_type_id'])==1):?>
                     <span class="btn btn-danger btn-sm">General</span>  
                     <?php else:?>
                     <span class="btn btn-primary btn-sm">Success</span>  
                     <?php endif;?>	
				  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Status &nbsp;&nbsp;</div>
                  <div class="no-overflow">
                     <?php
                        if(strtolower($list['status'])==0):?>
                     <span class="btn btn-danger btn-sm">Failure</span>  
                     <?php else:?>
                     <span class="btn btn-primary btn-sm">Success</span>  
                     <?php endif;?>										
                  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Date</div>
                  <div class="no-overflow"> <?php echo date('d-F-Y',strtotime($list['created']));?> </div>
               </div>
            </div>
         </li>
  <?php endforeach;
  if(count($order_list) <=0){?>
	<li class="item"> 	   
	   <div class="item-row">
		   <div class="item-col item-col-category no_list_found">
			  <div class="no-overflow">   No History Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 