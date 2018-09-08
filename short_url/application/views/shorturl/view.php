
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Short URl - Details</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" > 
									
									<?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().'shorturls/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
								<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($data['created'])); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Name :</label>
										<div class="controls views">
										<?php echo ucwords($data['name']); ?>
								 		</div> <!-- /controls -->			
									
									</div> <!-- /control-group -->
									
						
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Original URL :</label>
										<div class="controls views">
										<?php echo (!empty($data['long_url']))?$data['long_url']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group views1">											
										<label class="control-label" for="username">Short URL :</label>
			

			<div class="controls">
				<input autocomplete="off" disabled type="text" class="span4" value="<?php echo base_url().$data['code'];?>" id="short_url" name="short_url">&nbsp;<a href="javascript:void(0);" onclick="copy()"><i class="icon-copy"></i></a>
			</div>												
									</div> <!-- /control-group -->
										<div class="control-group views1">											
										<label class="control-label" for="username">Visit Count:</label>
										<div class="controls views">
											<?php  echo (!empty($data['visit_count']))?$data['visit_count']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									  <div class="control-group views1">											
										<label class="control-label" for="username">Status:</label>
										<div class="controls views">
											<?php  echo ($data['is_active']==1)?'Active':'In Active'; ?>
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
