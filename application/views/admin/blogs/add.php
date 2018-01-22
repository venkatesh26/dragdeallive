<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-fire"></i>
	      				<h3>Blog - New</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal');
							echo form_open_multipart(ADMIN.'/blogs/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Title<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'name'),$this->input->post('name')); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="short_description">Short Description<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'short_description','class'=> 'span3','id'=>'name','style'=>'width:700px;'),$this->input->post('name')); ?>
										<span class="text-danger"><?php echo form_error('short_description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="description">Description<span class="must">*</span></label>
										<div class="controls">
										<?php
										$txtattribute = array('name'=>'description','id'=>'description');
										echo form_textarea($txtattribute); 
										echo display_ckeditor($txtattribute);?>
										<span class="text-danger"><?php echo form_error('description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="blog_category_id">Category<span class="must">*</span></label>
										<div class="controls">
									<?php echo form_dropdown("blog_category_id",array(""=>"Select Category")+$categories,$this->input->post('blog_category_id') ? $this->input->post('blog_category_id') :'','id="blog_category_id"'); ?>								
										<span class="text-danger"><?php echo form_error('blog_category_id'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
	                               <div class="control-group">											
										<label class="control-label" for="meta_keywords">Meta Keywords<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_keywords','class'=> 'span3','id'=>'meta_keywords'),$this->input->post('meta_keywords')); ?>
										<span class="text-danger"><?php echo form_error('meta_keywords'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->		


                                    <div class="control-group">											
										<label class="control-label" for="meta_description">Meta Description<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_description','class'=> 'span3','id'=>'name','style'=>'width:700px;'),$this->input->post('meta_description')); ?>
										<span class="text-danger"><?php echo form_error('meta_description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->									

									
									<div class="control-group">
										<label for="inputError" class="control-label">Image <span class="must">*</span><br /></label>
										<div class="controls">
										  <?php echo form_upload(array('name'=>'image','id'=>'images')); ?></br>
										  <span>( jpg, jpeg, png, gif only ) Size : 420X420</span>
										  <span class="text-danger"><?php echo form_error('image'); ?></span>
										  <!--<span class="help-inline">Woohoo!</span>-->
										  <?php 
										  $value=0;
										  if(isset($result[0]['city_image']))
										  {
										  $value=1;
										  
										  }?>
										  <input type="hidden" value="<?php echo $value; ?>" id="js-image-id">
										</div>
									</div>										
									
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1',TRUE); ?> Active
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/blogs/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
								</fieldset>
							<?php echo form_close(); ?>
							</div>
						</div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
		    </div> <!-- /span8 -->
	      </div> <!-- /row -->	
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->
