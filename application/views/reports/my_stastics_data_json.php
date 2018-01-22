 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-author">
                  <div class="item-heading"><i class="fa fa-globe"></i> Country</div>
                  <div class="no-overflow"> <?php echo $list['country'];?>  </div>
               </div>
               <div class="item-col item-col-title">
                  <div class="item-heading"><i class="fa fa-flag"></i> City</div>
                  <div class="no-overflow"> <?php echo $list['city'];?>  </div>
               </div>
               <div class="item-col item-col-title">
                  <div class="item-heading"><i class="fa fa-globe"></i> Browser</div>
                  <div class="no-overflow">  <?php echo $list['browser'];?> </div>
               </div>
			      <div class="item-col item-col-title">
                  <div class="item-heading"><i class="fa fa-globe"></i> Browser</div>
                  <div class="no-overflow">  <?php echo $list['browser'];?> </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading"><i class="fa fa-calendar"></i> Date</div>
                  <div class="no-overflow"> <?php echo date('d-M-Y',strtotime($list['created']));?> </div>
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