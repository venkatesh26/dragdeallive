<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-fire"></i>
	      				<h3>Categories - Edit</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'edit_amenties');
							echo form_open_multipart(ADMIN.'/categories/edit/'.$this->uri->segment(4).'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','value'=>set_value('name', $this->input->post('name') ? $this->input->post('name') : $categories['name']),'class'=> 'span3','id'=>'name') ); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
										<div class="control-group">											
										<label class="control-label" for="name">Main Category<span class="must">*</span></label>
										<div class="controls">
									<?php echo form_dropdown("select_category",array(""=>"Select Category")+$main_categories,$this->input->post('select_category') ? $this->input->post('select_category') :$categories['parent'],'id="select_category"'); ?>								
										<span class="text-danger"><?php echo form_error('select_category'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Title</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_title','value'=>set_value('meta_title', $this->input->post('meta_title') ? $this->input->post('meta_title') : $categories['meta_title']),'class'=> 'span3','id'=>'meta_title') ); ?>
											<br/>
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
										 
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
											<textarea class="span5" name="meta_description" rows="5"><?php echo $categories['meta_description']?></textarea>
											<br/>
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Title</label>
										<div class="controls">
											<?php 
											echo form_input(array('name'=>'meta_city_title','value'=>set_value('meta_city_title', $this->input->post('meta_city_title') ? $this->input->post('meta_city_title') : $categories['meta_city_title']),'class'=> 'span3','id'=>'meta_city_title') ); ?>
											<br/>
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Description</label>
										<div class="controls">
											<textarea class="span5" name="meta_city_description" rows="5"><?php echo $categories['meta_city_description']?></textarea>
											<br/>
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Area Title</label>
										<div class="controls">
											<?php 
											echo form_input(array('name'=>'meta_city_area_title','value'=>set_value('meta_city_area_title', $this->input->post('meta_city_area_title') ? $this->input->post('meta_city_area_title') : $categories['meta_city_area_title']),'class'=> 'span3','id'=>'meta_city_area_title') ); ?>
											<br/>
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Area Description</label>
										<div class="controls">
											<textarea class="span5" name="meta_city_area_description" rows="5"><?php echo $categories['meta_city_area_description']?></textarea>
											<br/>
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1', set_value('is_active', $this->input->post('is_active') ? $this->input->post('is_active') : $is_active)); ?> Active
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/categories/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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
