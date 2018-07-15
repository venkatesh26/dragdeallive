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
                  <div class="no-overflow"> <i class="fa fa-user"></i> <?php echo ucwords($list['first_name'])." - ".ucwords($list['contact_number']);?><br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['email']);?>  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Rating </div>
                  <div class="no-overflow"> 
					  <?php
						$rating=$list['rating'];
						for($i=1;$i<=$rating;$i++):
						 echo "<i class='fa fa-star'></i>";
						endfor;
						for($i=abs($rating-5);$i>=1;$i--):
						 echo "<i class='fa fa-star-o'></i>";
						endfor;
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
                     <span class="btn btn-danger btn-sm">In Active</span>  
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
                              <a class="remove change_status" data-rel="<?php echo $list['id'];?>" data-status="<?php echo $list['is_active'];?>" href="#" data-target="#confirm-change-modal" data-toggle="modal" title="Change Status">
							   <?php if($list['is_active']==1):?>
								<i class="fa fa-check"></i>
									<?php else: ?>
								<i class="fa fa-ban"></i>
								<?php endif;?>
							  </a>
						   </li>
                           <li>
                              <a class="remove review_detail" title="View Detail"  href="#" 
							  data-rating="<?php
								$rating=$list['rating'];
								for($i=1;$i<=$rating;$i++):
								 echo "<i class='fa fa-star'></i>";
								endfor;
								for($i=abs($rating-5);$i>=1;$i--):
								 echo "<i class='fa fa-star-o'></i>";
								endfor;
								?>"
							  data-info='<i class="fa fa-user"></i> <?php echo ucwords($list['first_name']);?><br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['email']);?>' data-date="<?php echo date('d -F-Y',strtotime($list['created']));?> " data-title="<?php echo $list['title'];?>" data-message="<?php echo $list['comments'];?>" data-status="<?php echo $list['is_active'];?>" data-toggle="modal" data-target="#review-detail-modal"> <i class="fa fa-list"></i> </a>
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
		  <div class="no-overflow">   No Reviews Found</div>
		</div>
		</div>
		</li>
		<?php }?> 