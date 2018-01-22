<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-fire"></i>
	      				<h3>Jobs - Edit</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php

							$attributes = array('class' => 'form-horizontal');
							echo form_open_multipart(ADMIN.'/jobs/edit/'.$jobs['id'].'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Title<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'name','value'=>set_value('name', $this->input->post('name') ? $this->input->post('name') : $jobs['name'])),$this->input->post('name')); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group">		
										<label class="control-label" for="name">Company Name<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'company_name','class'=> 'span3','id'=>'company_name','value'=>set_value('company_name', $this->input->post('company_name') ? $this->input->post('company_name') : $jobs['company_name'])),$this->input->post('company_name')); ?>
										<span class="text-danger"><?php echo form_error('company_name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
			                        	<div class="control-group">											
										<label class="control-label" for="name">Qualification<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'qualification','class'=> 'span3','id'=>'qualification','value'=>set_value('qualification', $this->input->post('qualification') ? $this->input->post('qualification') : $jobs['qualification'])),$this->input->post('qualification')); ?>
										<span class="text-danger"><?php echo form_error('qualification'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">Age Limit<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'age_limit','class'=> 'span3','id'=>'age_limit','value'=>set_value('age_limit', $this->input->post('age_limit') ? $this->input->post('age_limit') : $jobs['age_limit'])),$this->input->post('age_limit')); ?>
										<span class="text-danger"><?php echo form_error('age_limit'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">No Of Vacancy<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'no_of_vacancy','class'=> 'span3','id'=>'no_of_vacancy','value'=>set_value('no_of_vacancy', $this->input->post('no_of_vacancy') ? $this->input->post('name') : $jobs['name'])),$this->input->post('no_of_vacancy')); ?>
										<span class="text-danger"><?php echo form_error('no_of_vacancy'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">Pay Scale<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'pay_scale','class'=> 'span3','id'=>'pay_scale','value'=>set_value('pay_scale', $this->input->post('pay_scale') ? $this->input->post('pay_scale') : $jobs['pay_scale'])),$this->input->post('pay_scale')); ?>
										<span class="text-danger"><?php echo form_error('pay_scale'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										<div class="control-group">											
										<label class="control-label" for="name">Skills<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'skills','class'=> 'span3','id'=>'skills','value'=>set_value('skills', $this->input->post('skills') ? $this->input->post('skills') : $jobs['skills'])),$this->input->post('skills')); ?>
										<span class="text-danger"><?php echo form_error('skills'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">City<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'city','class'=> 'span3','id'=>'city','value'=>set_value('city', $this->input->post('city') ? $this->input->post('city') : $jobs['city'])),$this->input->post('city')); ?>
										<span class="text-danger"><?php echo form_error('city'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="name">Area<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'area','class'=> 'span3','id'=>'area','value'=>set_value('area', $this->input->post('area') ? $this->input->post('area') : $jobs['area'])),$this->input->post('area')); ?>
										<span class="text-danger"><?php echo form_error('area'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
											
									<div class="control-group">											
										<label class="control-label" for="name">Selection Process<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'selection_process','class'=> 'span3','id'=>'selection_process','value'=>set_value('selection_process', $this->input->post('selection_process') ? $this->input->post('selection_process') : $jobs['name'])),$this->input->post('selection_process')); ?>
										<span class="text-danger"><?php echo form_error('selection_process'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
                                    <div class="control-group">											
										<label class="control-label" for="short_description">Short Description<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'short_description','class'=> 'span3','id'=>'name','value'=>set_value('short_description',$this->input->post('short_description') ? $this->input->post('short_description') : $jobs['short_description']),'style'=>'width:700px;'),$this->input->post('short_description')); ?>
										<span class="text-danger"><?php echo form_error('short_description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->		
									
									
									
									<div class="control-group">											
										<label class="control-label" for="description">Description<span class="must">*</span></label>
										<div class="controls">
										<?php
										$txtattribute = array('name'=>'description','id'=>'description','value'=>$this->input->post('description'), 'value'=>set_value('description', htmlentities($this->input->post('description')) ? htmlentities($this->input->post('description')) : htmlentities($jobs['description'])));
										echo form_textarea($txtattribute); 
										echo display_ckeditor($txtattribute);?>
										<span class="text-danger"><?php echo form_error('description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
	                               <div class="control-group">											
										<label class="control-label" for="meta_keywords">Meta Keywords<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_keywords','class'=> 'span3','id'=>'meta_keywords','value'=>set_value('meta_keywords',$this->input->post('meta_keywords') ? $this->input->post('meta_keywords') : $jobs['meta_keywords'])),$this->input->post('meta_keywords')); ?>
										<span class="text-danger"><?php echo form_error('meta_keywords'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->		


                                    <div class="control-group">											
										<label class="control-label" for="meta_description">Meta Description<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_description','class'=> 'span3','id'=>'name','value'=>set_value('meta_description',$this->input->post('meta_description') ? $this->input->post('meta_description') : $jobs['meta_description']),'style'=>'width:700px;'),$this->input->post('meta_description')); ?>
										<span class="text-danger"><?php echo form_error('meta_description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->	

				
									<div class="control-group">											
										<label class="control-label" for="name">Last Date to Apply<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'last_date_apply','class'=> 'span3','id'=>'last_date_apply','value'=>set_value('last_date_apply',$this->input->post('last_date_apply') ? $this->input->post('last_date_apply') : $jobs['last_date_apply'])), $this->input->post('last_date_apply')); ?>
										<span class="text-danger"><?php echo form_error('last_date_apply'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->									

		<div class="control-group">											
										<label class="control-label" for="name">Which Link to Apply<span class="must"> *</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'website','class'=> 'span3','id'=>'website'),$this->input->post('website')); ?>
										<span class="text-danger"><?php echo form_error('website'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->									

									
									<div class="control-group">
										<label for="inputError" class="control-label">Image <span class="must">*</span><br /></label>
										<div class="controls">
										  <?php echo form_upload(array('name'=>'image','id'=>'images')); ?></br>
										  <span>( jpg, jpeg, png, gif only ) Size : 420X420</span>
										  <span class="text-danger"><?php echo form_error('image'); ?></span>
										  <?php 
										  $value=0;
										  if(isset($jobs['image_name']))
										  {
										  $value=1;
										  
										  }?>
										  <input type="hidden" value="<?php echo $value; ?>" id="js-image-id">
										<?php 
										if(file_exists('./'.$jobs['image_dir'].$jobs['image_name']) && $jobs['image_name']!="") {
										?>
										<div>
										<?php
										$img_src = thumb(FCPATH.$jobs['image_dir'].$jobs['image_name'],'135','70','blog_image');
										$img_prp = array('src'=>base_url().$jobs['image_dir'].'blog_image/'.$img_src,'alt'=>$jobs['image_name']);
										echo img($img_prp);
										?>
										</div>
										<?php } ?>
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
										echo anchor(base_url().ADMIN.'/jobs/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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
<div class="ck_content_data" style="display:none;">
<?php
if($this->input->post('description')){
echo html_entity_decode($this->input->post('description'));
}
else{ echo $jobs['description']; 
	}?>
</div>
<script>
setTimeout(function(){
CKEDITOR.instances['description'].setData($('.ck_content_data').html());
	}, 1000);
</script>