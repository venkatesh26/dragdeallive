 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Camaign Name</div>
                  <div class="no-overflow"> <?php echo substr($list['campaign_title'],0,60);?>  </div>
               </div>
               <div class="item-col item-col-title">
                  <div class="item-heading">Buyer Info</div>
                  <div class="no-overflow"> <i class="fa fa-user"></i> <?php echo ucwords($list['first_name']);?> <br/><i class="fa fa-mobile"></i> <?php echo ucwords($list['mobile_number']);?> </div>
               </div>
               <div class="item-col item-col-date">
                  <div class="item-heading">Visit Count </div>
                  <div class="no-overflow"> 
				  <span class="btn btn-primary btn-sm"> <?php echo $list['visit_count'];?></span>
				  
				  </div>
               </div>
               <div class="item-col item-col-date">
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
			  <div class="no-overflow">   No List Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 