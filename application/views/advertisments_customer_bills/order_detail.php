<article class="content items-list-page content dashboard-page">

	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
		

   <div class="white-bg">
    
	<div class="row">
               <fieldset>
                  <div class="control-group views1">
                     <label class="control-label" for="username">Order Date :</label>
                     <div class="controls views posted_date"><?php echo date('Y-m-d H:i:s', strtotime($order_detail['created']));?></div>
                  </div>
				  <?php if($order_detail['order_id']!=''):?>	
				  <div class="control-group views1">
                     <label class="control-label" for="username">Order ID :</label>
                     <div class="controls views posted_date"><?php echo ucwords($order_detail['order_id']);?></div>
                  </div>
				  <?php endif;?>
                  <div class="control-group views1">
                     <label class="control-label" for="username">First Name :</label>
                     <div class="controls views first_name"><?php echo ucwords($order_detail['first_name']);?></div>
					 
                  </div>
				  <?php if($order_detail['last_name']!=''):?>
				   <div class="control-group views1">
				    <label class="control-label" for="username">Last Name :</label>
                     <div class="controls views last_name"><?php echo $order_detail['last_name'];?></div>
				   </div>
				  <?php endif;?>
				  
				   <?php if($order_detail['email']!=''):?>
					  <div class="control-group views1">
						 <label class="control-label" for="username">Email :</label>
						 <div class="controls views email"><?php echo $order_detail['email'];?></div>
					  </div>
					<?php endif;?>
				  
				<?php if($order_detail['mobile_number']!=''):?>				  
				  <div class="control-group views1">
                     <label class="control-label" for="username">Contact Number :</label>
                     <div class="controls views contact_number"><?php echo $order_detail['mobile_number'];?></div>
                  </div>
				 <?php endif;?>

				<?php if($order_detail['city']!=''):?>					 
				   <div class="control-group views1">
                     <label class="control-label" for="username">City :</label>
                     <div class="controls views city_name"><?php echo $order_detail['city'];?></div>
                  </div>
				 
				<?php  endif;?>				 
				  
				  <?php if($order_detail['area']!=''):?>	
				   <div class="control-group views1">
                     <label class="control-label" for="username">Area :</label>
                     <div class="controls views area_name"><?php echo $order_detail['area'];?></div>
                  </div>
				<?php  endif;?>					
				
					  <?php if($order_detail['address']!=''):?>	
				   <div class="control-group views1">
                     <label class="control-label" for="username">Address :</label>
                     <div class="controls views address"><?php echo $order_detail['address'];?></div>
                  </div>
				  <?php endif;?>
               </fieldset>
            </div>
			 <div class="row">
			 <br/>
               <div class="col-md-12">
                  <h3 class="title">
                     <i class="fa fa-shopping-cart"></i> Orders Details
                  </h3>	
			 <br/>				  
            </div>
			</div>
			     <div class="card items">
         <ul class="item-list striped">
            <li class="item item-list-header hidden-sm-down td-header-bar">
               <div class="item-row">
                  <div class="item-col item-col-header item-col-title">
                     <div> <span><i class="fa fa-list-alt"> </i> Name</span> </div>
                  </div>
				   <div class="item-col item-col-header item-col-title">
                     <div> <span><i class="fa fa-money"> </i> Quantity</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-title">
                     <div> <span><i class="fa fa-money"> </i> Order Amount</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-date">
                     <div> <span> <i class="fa fa-calendar"> </i>  Amount</span> </div>
                  </div>
                  <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
               </div>
            </li>
         </ul>
         <ul class="item-list striped js-response">
		  <?php foreach($order_detail['product_order_details'] as $list): ?>
	<li class="item">
		<div class="item-row">
		   <div class="item-col item-col-title">
			  <div class="item-heading">Name</div>
			  <div class="no-overflow"> <?php echo ucwords($list['product_name']);?>  </div>
		   </div>
		   <div class="item-col item-col-newtitle">
			  <div class="item-heading">Quantity</div>
			  <div class="no-overflow" style="margin-left:80px"> <b><?php echo number_format($list['quantity']);?> </b> </div>
		   </div>
		    <div class="item-col item-col-newtitle">
			  <div class="item-heading">Amount</div>
			  <div class="no-overflow" style="margin-left:80px"> <b><?php echo number_format($list['price']);?> </b> </div>
		   </div>
		    <div class="item-col item-col-newtitle">
			  <div class="item-heading">Total Amount</div>
			  <div class="no-overflow" style="margin-left:80px"> <b><?php echo number_format($list['total_price']);?> </b> </div>
		   </div>
		</div>
	</li>
  <?php 
  endforeach;
  echo "<br/>";
  echo "<div class='col-md-12'><div class='col-md-6'></div><div class='col-md-6'><span style='float:right'>Total Amount: <b>". $order_detail['amount']."</b></span></div></div>";
  if(isset($order_detail['product_order_details']) && count($order_detail['product_order_details']) <=0){?>
	<li class="item"> 	   
	   <div class="item-row">
		   <div class="item-col item-col-category no_list_found">
			  <div class="no-overflow no_list_found">   No Customers Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 
         </ul>
      </div>
         </div>

			
	</div>
</article> 	
	