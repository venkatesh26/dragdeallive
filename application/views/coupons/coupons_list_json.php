 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Name</div>
                  <div class="no-overflow"> <?php echo $list['name'];?>  </div>
               </div>
			   
               <div class="item-col item-col-date">
                  <div class="item-heading">Coupons Info</div>
                  <div class="no-overflow"><span class="btn btn-primary btn-sm" title="Total Coupons" data-placement="right" data-toggle="tooltip"><i class="fa fa-arrow-circle-up"></i> <?php echo $list['total_count'];?></span>
               </div>
			   </div>
				<div class="item-col item-col-date">
                  <div class="item-heading">Coupons Info</div>
                  <div class="no-overflow"><span class="btn btn-primary btn-sm" title="Total Coupons" data-placement="right" data-toggle="tooltip"><i class="fa fa-arrow-circle-down"></i> <?php echo $list['total_coupons_download'];?></span> </div>
				</div>			   
               <div class="item-col item-col-date">
                  <div class="item-heading">Status </div>
                  <div class="no-overflow">
                     <?php
                        if(strtolower($list['is_active'])=='1'):?>
                     <span class="btn btn-primary btn-sm">&nbsp;Active&nbsp;&nbsp;</span>  
                     <?php else:?>
                     <span class="btn btn-danger btn-sm">InActive</span>  
                     <?php endif;?>										
                  </div>
               </div>
			    <div class="item-col item-col-date">
                  <div class="item-heading">Date</div>
                  <div class="no-overflow"> <?php echo date('d-M-Y',strtotime($list['exipry_date']));?> </div>
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
                              <a class="remove order_detail" href="<?php echo base_url().'coupons_edit/'.$list['id'];?>"> <i class="fa fa-edit"></i> </a>
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
			  <div class="no-overflow no_list_found">   No Coupons Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 