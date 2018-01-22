<?php foreach($order_list as $list): ?>
<li class="item">
   <div class="item-row">
      <div class="item-col item-col-newtitle">
         <div class="item-heading">File Name</div>
         <div class="no-overflow"> <?php echo $list['file_name'];?>  </div>
      </div>
      <div class="item-col item-col-author">
         <div class="item-heading">Total Customers </div>
         <div class="no-overflow"><span class="btn btn-primary btn-sm"> <?php echo $list['total_rows'];?></span>  </div>
      </div>
      <div class="item-col item-col-date">
         <div class="item-heading">Status </div>
         <div class="no-overflow">
            <?php
               if(strtolower($list['status'])=='success'):?>
            <span class="btn btn-primary btn-sm">Success</span>  
            <?php else:?>
            <span class="btn btn-danger btn-sm">Failure</span>  
            <?php endif;?>										
         </div>
      </div>
      <div class="item-col item-col-category">
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
         <div class="no-overflow ">   No Datas Found </div>
      </div>
   </div>
</li>
<?php }?>