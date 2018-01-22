<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-key"></i>
	      				<h3>Change Password</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
								$attributes = array('class' => 'form-horizontal', 'id' => 'change-password');
								echo validation_errors();
								if(!$this->uri->segment(4)){
									echo form_open('user/change_password/', $attributes);
								}else{
									echo form_open(ADMIN.'/'.$this->uri->segment(2).'/change_password/'.$this->uri->segment(4), $attributes);
								}
								if($this->session->flashdata('flash_message')){
									echo $this->session->flashdata('flash_message');
							  	}
							?>
        						<fieldset>
          							<div class="control-group">
            							<label for="inputError" class="control-label">Current Password <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'old_password','id'=>'old_password'),set_value('old_password'),$this->input->post('old_password')); ?>
            							</div>
          							</div> 
          							<div class="control-group">
            							<label for="inputError" class="control-label">Password <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'password','id'=>'password'),set_value('password'),$this->input->post('password')); ?>
            							</div>
          							</div>  
          							<div class="control-group">
            							<label for="inputError" class="control-label">New Password <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'password2','id'=>'password2'),set_value('password2'),$this->input->post('password2')); ?>
            							</div>
          							</div>           
          							<div class="form-actions">
            							<button type="submit" class="btn btn-primary">Save</button> 
										<?php echo anchor(base_url().ADMIN,'Cancel',array('class'=>'btn')); ?>
          							</div>
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
