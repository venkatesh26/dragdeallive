<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Advertisment - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/comments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
								<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($advertisments['created'])); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Company Name :</label>
										<div class="controls views">
										<?php echo ucwords($advertisments['name']); ?>
								 		</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">
										<?php echo (!empty($advertisments['email']))?$advertisments['email']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group views1">											
										<label class="control-label" for="username">Owner Name :</label>
										<div class="controls views">
										<?php echo ucwords($advertisments['owner']);  ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										<div class="control-group views1">											
										<label class="control-label" for="username">Contact Number:</label>
										<div class="controls views">
											<?php  echo (!empty($advertisments['contact_number']))?$advertisments['contact_number']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Address:</label>
										<div class="controls views">
											<?php  echo (!empty($advertisments['address_line']))?$advertisments['address_line']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
	                             <div class="control-group views1">											
										<label class="control-label" for="username">Working Time Start:</label>
										<div class="controls views">
											<?php  echo ($advertisments['working_start']!='')?$advertisments['working_start']:'Not available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									  <div class="control-group views1">											
										<label class="control-label" for="username">Working Time End:</label>
										<div class="controls views">
											<?php  echo ($advertisments['working_end']!='')?$advertisments['working_end']:'Not available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									  <div class="control-group views1">											
										<label class="control-label" for="username">Rating:</label>
										<div class="controls views">
											<?php  echo ucwords($advertisments['rating']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									  <div class="control-group views1">											
										<label class="control-label" for="username">Status:</label>
										<div class="controls views">
											<?php  echo ($advertisments['is_active']==1)?'Active':'In Active'; ?>
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