<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Sub Admin - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/subadmin/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
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
										<label class="control-label" for="username">Created Date :</label>
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
										<?php if($users['profile']['gender_id']==1) echo "Male";else echo "Female"; ?>
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
