 <?php foreach($order_list as $key=>$list):?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-author">
                  <div class="item-heading">Name</div>
                  <div class="no-overflow"> <?php echo ucwords($list['name']);?>  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Status </div>
                  <div class="no-overflow">
                     <?php
                        if(strtolower($list['is_active'])=='1'):?>
                     <span class="btn btn-primary btn-sm">Active</span>  
                     <?php else:?>
                     <span class="btn btn-danger btn-sm">Inactive</span>  
                     <?php endif;?>										
                  </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Created Date</div>
                  <div class="no-overflow" style="padding-left:145px;"> <?php echo date('d-M-Y',strtotime($list['created']));?> </div>
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
                              <a class="remove edit-group" href="#" data-toggle="modal" data-target="#edit-modal" data-status="<?php echo $list['is_active'];?>" data-name="<?php echo  $list['name'];?>" data-id="<?php echo  $list['id'];?>"> <i class="fa fa-pencil"></i> </a>
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
         <div class="no-overflow ">   No Datas Found </div>
      </div>
   </div>
</li>
<?php }?>