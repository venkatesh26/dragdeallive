 <?php foreach($order_list as $list):
            ?>
         <li class="item">
            <div class="item-row">
               <div class="item-col item-col-title">
                  <div class="item-heading">Reaminder Name</div>
                  <div class="no-overflow"> <?php echo $list['name'];?>  </div>
               </div>
               <div class="item-col fixed item-col-author">
                  <div class="item-heading">Number Of Customer Recieved</div>
                <div class="no-overflow">
				  <span class='btn btn-primary btn-sm'><i title="No Of Sms Send" class="cursor fa fa-cloud-upload"></i> <?php echo $list['number_of_user_send'];?></span>
				    <span class='btn btn-primary btn-sm'><i title="No Of Sms Recieved" class="cursor fa fa-cloud-download"></i> <?php echo ucwords($list['number_of_user_received']);?></span>
				</div>
				</div>
               <div class="item-col item-col-author">
                  <div class="item-heading">Type </div>
                  <div class="no-overflow remainder_type">
				   <?php 
					  if($list['remainder_type_id']==1) {
						 echo "<span class='btn btn-primary btn-sm'><i class='fa fa-birthday-cake cursor' title='Birthday' style='color:#fff;'></i> Birthday</span> ";
						 
					  }
					  else if($list['remainder_type_id']==2) {						   
						    echo "<span class='btn btn-primary btn-sm'><i class='fa fa-gift cursor' title='Aniversery' style='color:#fff;'></i> Aniversery</span> ";
						 
					  }
					  else {  
					    echo "<span class='btn btn-primary btn-sm'><i class='fa fa-shield cursor' title='Service' style='color:#fff;'></i> Service</span> ";
					  }
				  ?>
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
			  <div class="no-overflow no_list_found">  No Histroy Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 