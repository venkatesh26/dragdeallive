<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Campaign - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/campaigns/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Title :</label>
										<div class="controls views">
										<?php echo ucwords($campaign['title']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">
										<?php echo $campaign['email']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									 <div class="control-group views1">											
										<label class="control-label" for="username">Contact Number :</label>
										<div class="controls views">
										<?php echo $campaign['contact_number']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group views1">											
										<label class="control-label" for="username">Message :</label>
										<div class="controls views">
										<?php echo ucwords($campaign['message']);  ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Campaign Type :</label>
										<div class="controls views">
										<?php if($campaign['campaign_type_id']==1){ echo "General Campaign";}else if($campaign['campaign_type_id']==2){ echo "Offer Campaign";};  ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group views1">											
										<label class="control-label" for="username">
										Campaign Short URL :</label>
										<div class="controls views">
											<?php  echo $campaign['campaign_url_short']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($campaign['created'])); ?>
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