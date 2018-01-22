<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Blogs - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/blogs/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
								<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($blogs['created'])); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Blog Name :</label>
										<div class="controls views">
										<?php echo ucwords($blogs['name']); ?>
								 		</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Short Description :</label>
										<div class="controls views">
										<?php echo (!empty($blogs['short_description']))?$blogs['short_description']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group views1">											
										<label class="control-label" for="username">Description :</label>
										<div class="controls views">
										<?php echo (!empty($blogs['description']))?$blogs['description']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										<div class="control-group views1">											
										<label class="control-label" for="username">Meta Keywords:</label>
										<div class="controls views">
											<?php  echo (!empty($blogs['meta_keywords']))?$blogs['meta_keywords']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
											<div class="control-group views1">											
										<label class="control-label" for="username">Meta Description:</label>
										<div class="controls views">
											<?php  echo (!empty($blogs['meta_description']))?$blogs['meta_description']:'Not Available'; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										<div class="control-group views1">											
										<label class="control-label" for="username">Blog Image:</label>
										<div class="controls views">
										<?php 
										if(file_exists('./'.$blogs['image_dir'].$blogs['image_name']) && $blogs['image_name']!="") {
										?>
										<?php
										$img_src = thumb(FCPATH.$blogs['image_dir'].$blogs['image_name'],'135','70','blog_image');
										$img_prp = array('src'=>base_url().$blogs['image_dir'].'blog_image/'.$img_src,'alt'=>$blogs['image_name']);
										echo img($img_prp);
										} ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
																		  <div class="control-group views1">											
										<label class="control-label" for="username">Status:</label>
										<div class="controls views">
											<?php  echo ($blogs['is_active']==1)?'Active':'In Active'; ?>
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