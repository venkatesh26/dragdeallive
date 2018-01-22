 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-category">
                  <div class="item-heading">Country</div>
                  <div class="no-overflow"> <?php echo $list['country'];?>  </div>
               </div>
               <div class="item-col item-col-newtitle">
                  <div class="item-heading">City</div>
                  <div class="no-overflow"> <?php echo $list['city'];?>  </div>
               </div>
               <div class="item-col fixed item-col-title">
                  <div class="item-heading">Browser</div>
                  <div class="no-overflow">  <?php echo $list['browser'];?> </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Platform </div>
                  <div class="no-overflow"> <?php echo $list['platform'];?>  </div>
               </div>
               <div class="item-col item-col-author">
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
			  <div class="no-overflow">   No Orders Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 