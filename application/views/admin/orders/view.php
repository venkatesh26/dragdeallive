<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-shopping-cart"></i>
	      				<h3>Orders - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Order Informations	<span class="create_new"><?php 
								   if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/orders/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
									} else {
										echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
									} ?></span></div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Order ID :</label>
										<div class="controls views">
										<?php echo $orders['unique_id']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Transaction ID :</label>
										<div class="controls views">
										<?php echo $orders['transaction_id']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Offer Name :</label>
										<div class="controls views">
										<?php echo $orders['offer_name']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Payment  Type:</label>
										<div class="controls views">
											<?php  echo $orders['order_type'];?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">
										<label class="control-label" for="username">Order Status:</label>
										<div class="controls views">
										<?php  if($orders['order_status']==1)
										       {
											   echo "Success";
											   }
											   else if($orders['order_status']==2)
											   {
											    echo "Canceled";
											   }
											   else
											   {
											   echo "Aborted";
											   }?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">
										<label class="control-label" for="username">Amount:</label>
										<div class="controls views">
										<?php  echo $orders['amount'];?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="widget-header listpadd" >Customer Informations	</div>
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Name:</label>
										<div class="controls views">
										<?php echo ucwords($orders['first_name']);?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Mobile Number</label>
										<div class="controls views">
										<?php if(!empty($orders['mobile_number'])) { echo nl2br($orders['mobile_number']); } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Telephone Number</label>
										<div class="controls views">
										<?php if(!empty($orders['telephone_number'])) { echo nl2br($orders['telephone_number']); } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Address :</label>
										<div class="controls views">
										<?php if(!empty($orders['address'])) { echo nl2br($orders['address']); } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="widget-header listpadd" >Profile Image :</div>
									<br/>
									<div class="control-group">			
										<?php 
									  if(file_exists('./'.$orders['image_dir'].$orders['profile_image']) && $orders['profile_image']!="") {
									  ?>
									  <div><br/>
									   <?php
									   $img_src = thumb(FCPATH.$orders['image_dir'].$orders['profile_image'],'100','100','thumb_profile');
									   $img_prp = array('src'=>base_url().$orders['image_dir'].'thumb_profile/'.$img_src,'alt'=>$orders['profile_image'],'title'=>$orders['first_name']);
									   echo img($img_prp);
									   ?>
									  </div>
									<?php } else {
									echo '<span style="color:red;">'.$this->config->item("not_available").'</span>';
									} ?>
									
									</div> <!-- /control-group -->
									
		
			
		
								</fieldset>
							</div>
						</div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
		    </div> <!-- /span8 -->
	      </div> <!-- /row -->	
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->
