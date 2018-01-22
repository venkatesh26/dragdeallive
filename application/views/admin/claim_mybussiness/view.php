<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Claim My Bussiness - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd">Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/contact_us/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Name :</label>
										<div class="controls views">
										<?php echo ucwords($contactus['name']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">
										<?php echo $contactus['email']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Mobile Number :</label>
										<div class="controls views">
										<?php echo $contactus['contact_number'];?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($contactus['created'])); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Bussiness Url:</label>
										<div class="controls views">
											<?php  echo $contactus['url']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
						   
									<div class="control-group views1">											
										<label class="control-label" for="username">Message :</label>
										<div class="controls views">
											<?php echo nl2br($contactus['description']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Account In Dialbe :</label>
										<div class="controls views">
											<?php echo nl2br($contactus['is_account']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Is Resolved:</label>
										<div class="controls views">
											<?php echo nl2br($contactus['is_resolved']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="widget-header listpadd" >Already Have An Account</div>
								<?php	
									$attributes = array('class' => 'form-horizontal','id'=>'reply_message1');
									echo form_open_multipart(ADMIN.'/claim_my_bussiness/update_account',$attributes);?>
									
									<input type="hidden" name="claim_id" value="<?php echo $contactus['id'];?>">
									
									
								    <div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">

										<input type="text" name="email" value="<?php echo ucwords($contactus['email']); ?>" id="search_email">
										&nbsp;
										<a href="javascript:void(0)" class="btn js-user-search">Search</a>
										</div> <!-- /controls -->		
											<b><p class="sucess_response" style="color:green;font-size:20px;"></p></b>
											<b><p class="error_response" style="color:red;font-size:20px;"></p></b>										
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="advertisment_id">Advertisment ID:</label>
										<div class="controls views">
											<input type="text" name="advertisment_id" value="" id="advertisment_id">
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="advertisment_id">User ID:</label>
										<div class="controls views">
											<input type="text" name="user_id" value="" id="advertisment_user_id">
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Update Account','title'=>'Create Account')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/claim_my_bussiness/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
									
									<?php echo form_close(); ?>
	                       
						  		
									<div class="widget-header listpadd" >Create Account For Contact Person</div>
								<?php	
									$attributes = array('class' => 'form-horizontal','id'=>'reply_message1');
									echo form_open_multipart(ADMIN.'/claim_my_bussiness/create_account',$attributes);?>
									<div class="control-group views1">											
										<label class="control-label" for="username">Name :</label>
										<div class="controls views">
										<input type="text" name="username" value="<?php echo ucwords($contactus['name']); ?>" required>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">

										<input type="text" name="email" value="<?php echo ucwords($contactus['email']); ?>" required>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="mobile_number">Mobile Number :</label>
										<div class="controls views">
											<input type="text" name="mobile_number" value="<?php echo ucwords($contactus['contact_number']); ?>" required>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										<div class="control-group views1">											
										<label class="control-label" for="mobile_number">Password :</label>
										<div class="controls views">
											<input type="password" name="password" value="" required>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
											<input type="hidden" name="claim_id" value="<?php echo $contactus['id'];?>">
									
									<div class="control-group views1">											
										<label class="control-label" for="advertisment_id">Advertisment ID:</label>
										<div class="controls views">
											<input type="text" name="advertisment_id" value="">
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Create Account','title'=>'Create Account')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/claim_my_bussiness/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
									
						
							
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