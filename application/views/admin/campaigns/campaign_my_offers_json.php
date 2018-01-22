 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Campaign Name</div>
                  <div class="no-overflow"> <?php echo substr($list['title'],0,85);?>  </div>
               </div>
			     <div class="item-col fixed item-col-title">
                  <div class="item-heading">Shop Info</div>
                  <div class="no-overflow"> 
				  <a target="_blank" href="<?php echo base_url().'business/'.$list['add_id'].'/'.url_title($list['add_name']).'/'.$list['city_name'];?>">  
				  <i class="fa fa-user"></i> <?php echo ucwords($list['add_name']);?></a>
				  <br/><i class="fa fa-envelope"></i> <?php echo ucwords($list['contact_number']);?>  </div>
               </div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Date</div>
                  <div class="no-overflow"> <?php echo date('d-M-Y',strtotime($list['created']));?> </div>
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