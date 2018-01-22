<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>User - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/users/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Name :</label>
										<div class="controls views">
										<?php echo $users['profile']['first_name']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">
										<?php echo $users['profile']['email']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Display Name :</label>
										<div class="controls views">
										<?php echo '@'.$users['profile']['display_name']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Registered Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($users['profile']['created'])); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<!--<div class="control-group views1">											
										<label class="control-label" for="username">Date of birth :</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['dob']) && $users['profile']['dob']!="0000-00-00") { echo date('d-M-Y',strtotime($users['profile']['dob'])); } else { echo $this->config->item("not_available");} ?>
									</div>  -->
									
									<div class="control-group views1">
										<label class="control-label" for="username">Gender:</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['gender_id'])) { 
										echo array_search($users['profile']['gender_id'],array_flip($this->config->item('gender'))); 
										} else {
											echo $this->config->item('not_available');
										} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">
										<label class="control-label" for="username">Register From(Via):</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['register_type'])) { 
										echo array_search($users['profile']['register_type'],array_flip($this->config->item('user_register_types'))); 
										} else {
											echo $this->config->item('not_available');
										} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Status :</label>
										<div class="controls views">
										<?php  if($users['profile']['is_active']==1) { echo '<i class="btn-icon-only btn-success">Active</i>'; } else { echo '<i class="btn-icon-only btn-danger">Inactive</i>'; } ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="widget-header listpadd" >Contact Informations	</div>
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Mobile Number :</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['mobile_number'])) { echo nl2br($users['profile']['mobile_number']); } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Telephone Number</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['telephone_number'])) { echo nl2br($users['profile']['telephone_number']); } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Address :</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['address'])) { echo nl2br($users['profile']['address']); } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="widget-header listpadd" >Profile Image :</div>
									<br/>
									<div class="control-group">			
										<?php 
									  if(file_exists('./'.$users['profile']['image_dir'].$users['profile']['profile_image']) && $users['profile']['profile_image']!="") {
									  ?>
									  <div><br/>
									   <?php
									   $img_src = thumb(FCPATH.$users['profile']['image_dir'].$users['profile']['profile_image'],'100','100','thumb_profile');
									   $img_prp = array('src'=>base_url().$users['profile']['image_dir'].'thumb_profile/'.$img_src,'alt'=>$users['profile']['profile_image'],'title'=>$users['profile']['first_name']);
									   echo img($img_prp);
									   ?>
									  </div>
									<?php } else {
									echo '<span style="color:red;">'.$this->config->item("not_available").'</span>';
									} ?>
									
									</div> <!-- /control-group -->
									
									<div class="widget-header listpadd" >Preferred Locations:</div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Preferred Country:</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['preferred_country'])) { echo $users['profile']['preferred_country']; } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Preferred State:</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['preferred_state'])) { echo $users['profile']['preferred_state']; } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Preferred City:</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['preferred_city'])) { echo $users['profile']['preferred_city']; } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Preferred Area:</label>
										<div class="controls views">
										<?php if(!empty($users['profile']['preferred_area'])) { echo $users['profile']['preferred_area']; } else { echo $this->config->item("not_available");} ?>
										</div> <!-- /controls -->				
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