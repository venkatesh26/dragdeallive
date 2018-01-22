<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-comment"></i>
	      				<h3>Notification Type - New</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal');
							echo form_open_multipart(ADMIN.'/notification_type/edit/'.$this->uri->segment(4).'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Code<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'code','value'=>set_value('code', $this->input->post('code') ? $this->input->post('name') : $notification_type['code']),'class'=> 'span3','id'=>'code'),$this->input->post('code')); ?>
										<span class="text-danger"><?php echo form_error('code'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','value'=>set_value('name', $this->input->post('name') ? $this->input->post('name') : $notification_type['name']),'class'=> 'span3','id'=>'name'),$this->input->post('name')); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">Title<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'template_title','value'=>set_value('template_title', $this->input->post('template_title') ? $this->input->post('template_title') : $notification_type['template_title']),'class'=> 'span3','id'=>'template_title'),$this->input->post('template_title')); ?>
										<span class="text-danger"><?php echo form_error('template_title'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
		
									
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Message *</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'template','value'=>set_value('template', $this->input->post('template') ? $this->input->post('template') : $notification_type['template']),'rows'=>5,'class'=> 'span5','id'=>'template'),$this->input->post('template')); ?>
											<span class="text-danger"><?php echo form_error('template'); ?></span>
										

																	 <br/>
											 ##NAME##
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
										echo anchor(base_url().ADMIN.'/notificationtype/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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