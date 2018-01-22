<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-fire"></i>
	      				<h3>Categories - New</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'add_amenties');
							echo form_open_multipart(ADMIN.'/categories/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'name'),$this->input->post('name')); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
										<div class="control-group">											
										<label class="control-label" for="name">Main Category<span class="must">*</span></label>
										<div class="controls">
									<?php echo form_dropdown("select_category",array(""=>"Select Category")+$categories,$this->input->post('select_category') ? $this->input->post('select_category') :'','id="select_category"'); ?>								
										<span class="text-danger"><?php echo form_error('select_category'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Title</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_title','class'=> 'span3','id'=>'meta_title'),$this->input->post('meta_title')); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_description','rows'=>5,'class'=> 'span5','id'=>'meta_description'),$this->input->post('meta_description')); ?>
																	 <br/>
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
										<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Title</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_city_title','class'=> 'span3','id'=>'meta_city_title'),$this->input->post('meta_city_title')); ?>
																	 <br/>
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Description</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_city_description','rows'=>5,'class'=> 'span5','id'=>'meta_city_description'),$this->input->post('meta_city_description')); ?>
										 <br/>
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
									
										<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Area Title</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_city_area_title','class'=> 'span3','id'=>'meta_city_area_title'),$this->input->post('meta_city_area_title')); ?>
										 <br/>
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_city_area_description','rows'=>5,'class'=> 'span5','id'=>'meta_city_area_description'),$this->input->post('meta_city_area_description')); ?>
																				 <br/>
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
						
									
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
