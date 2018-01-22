 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
           
               <div class="item-col item-col-newtitle">
                  <div class="item-heading">Title</div>
                  <div class="no-overflow"> <?php echo $list['title'];?>  </div>
               </div>
               <div class="item-col fixed item-col-title">
                  <div class="item-heading">Customer Info</div>
                  <div class="no-overflow"> <i class="fa fa-user"></i> <?php echo ucwords($list['first_name']);?><br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['email']);?>  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Rating </div>
                  <div class="no-overflow"> <?php echo $list['rating'];?>  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Status </div>
                  <div class="no-overflow">
                     <?php
                        if(strtolower($list['is_active'])=='1'):?>
                     <span class="btn btn-primary btn-sm">Active</span>  
                     <?php else:?>
                     <span class="btn btn-danger btn-sm">In Active</span>  
                     <?php endif;?>										
                  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Date</div>
                  <div class="no-overflow"> <?php echo date('d -F-Y',strtotime($list['created']));?> </div>
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
                              <a class="remove" href="#" data-toggle="modal" data-target="#confirm-modal"> <i class="fa fa-list"></i> </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         <?php endforeach;?> 
		 		<?php if(count($order_list) <=0){?>
		<li class="item"> 	   
		<div class="item-row">
		<div class="item-col item-col-category no_list_found">
		  <div class="no-overflow">   No List Found</div>
		</div>
		</div>
		</li>
		<?php }?> 