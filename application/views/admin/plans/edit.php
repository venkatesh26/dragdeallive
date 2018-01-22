<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-book"></i>
	      				<h3>Plan - Edit</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'edit_plans');
							echo form_open(ADMIN.'/plans/edit/'.$this->uri->segment(4), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="username">Name</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'name'),set_value('name', $this->input->post('name') ? $this->input->post('name') : $plans['name'])); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Price</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'price','class'=> 'span2','id'=>'price','maxlength'=>'8'),set_value('price', $this->input->post('price') ? $this->input->post('price') : $plans['price'])); ?> &#8364;
										<span class="text-danger"><?php echo form_error('price'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Plan validity</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'plan_valid_days','class'=> 'span1','id'=>'plan_valid_days','maxlength'=>'4'),set_value('plan_valid_days', $this->input->post('plan_valid_days') ? $this->input->post('plan_valid_days') : $plans['plan_valid_days'])); ?> Days
										<span class="text-danger"><?php echo form_error('plan_valid_days'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Auction limit</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'auction_limit','class'=> 'span1','id'=>'auction_limit','maxlength'=>'5'),set_value('auction_limit', $this->input->post('auction_limit') ? $this->input->post('auction_limit') : $plans['auction_limit'])); ?>
										<span class="text-danger"><?php echo form_error('auction_limit'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Commision</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'commision','class'=> 'span1','id'=>'commision','maxlength'=>'2'),set_value('commision', $this->input->post('commision') ? $this->input->post('commision') : $plans['commision'])); ?> %
										<span class="text-danger"><?php echo form_error('commision'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('featured_home_page', '1', $plans['featured_home_page']); ?> Featured Home Page
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1', $is_active); ?> Active
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
									<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
									echo anchor(base_url().ADMIN.'/plans','Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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