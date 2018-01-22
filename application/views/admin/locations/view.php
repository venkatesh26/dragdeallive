<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>City - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/cities/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Name :</label>
										<div class="controls views">
										<?php
										echo ucwords($cities['city_name']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										<div class="control-group views1">											
										<label class="control-label" for="username">State :</label>
										<div class="controls views">
										<?php
										echo ucwords($cities['s_name']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">					<label class="control-label" for="username">Country :</label>
										<div class="controls views">
										<?php
										echo ucwords($cities['c_name']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<?php if(!empty($cities['currency'])):?>
									<div class="control-group views1">											
										<label class="control-label" for="username">Currency:</label>
										<div class="controls views">
											<?php  echo  $cities['currency'];?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
                                     <?php endif;?>
									 	<?php if(!empty($cities['population'])):?>
									<div class="control-group views1">											
										<label class="control-label" for="username">Population:</label>
										<div class="controls views">
											<?php  echo  number_format($cities['population']);?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
                                     <?php endif;?>
				
										<?php if(!empty($cities['language'])):?>
									<div class="control-group views1">											
										<label class="control-label" for="username">Language:</label>
										<div class="controls views">
											<?php  echo  $cities['language'];?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
                                     <?php endif;?>
									 <?php if(!empty($cities['image_dir']) && !empty($cities['city_image']))
									 {?>
									 	<div class="control-group">
									<label class="control-label" for="username">Image:</label>
									<div class="controls views">
					            <?php if(file_exists('./'.$cities['image_dir'].$cities['city_image']) && $cities['city_image']!="") {
									   $img_src = thumb(FCPATH.$cities['image_dir'].$cities['city_image'],'85','60','admin_city_image');
									   $img_prp = array('src'=>base_url().$cities['image_dir'].'admin_city_image/'.$img_src,'alt'=>$cities['city_image']);
									   echo img($img_prp);
									   ?>
									  <?php } ?> 
                                    </div>
									</div>
									<?php }?>
								<?php if(!empty($place_images)):?>
									<div class="widget-header listpadd" >Place Of Interset Images</div>
							 <?php foreach($place_images as $p_images):?>
								<div class="control-group views1">		
                                  <?php 
								  if(file_exists('./'.$p_images['image_dir'].$p_images['image_name']) && $p_images['image_name']!="") {?>								
									<label class="control-label" for="username">Name : <?php echo ucwords($p_images['name']);?></label>
										<div class="controls views">
										<?php
									   $img_src = thumb(FCPATH.$p_images['image_dir'].$p_images['image_name'],'85','60','admin_place_image');
									   $img_prp = array('src'=>base_url().$p_images['image_dir'].'admin_place_image/'.$img_src,'alt'=>$p_images['image_name']);
									   echo img($img_prp);
									   ?>
									  <?php } ?> 
										</div> 				
									</div>
									<?php 
									endforeach;
									endif;?>
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