<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Suitables - New</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'add_amenties');
							echo validation_errors();
							echo form_open(ADMIN.'/suitables/add/'.$this->uri->segment(4).'', $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="username">Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'name'),$this->input->post('name')); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1', TRUE); ?> Active
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
										<button type="submit" class="btn btn-primary">Save</button> 
										<?php echo anchor(base_url().ADMIN.'/suitables','Cancel',array('class'=>'btn')); ?>
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