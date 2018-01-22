<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed');?> 
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-pencil"></i>
	      				<h3>My Profile</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
								$attributes = array('class' => 'form-horizontal', 'id' => 'edit-admin-profile');
								if($this->session->flashdata('flash_message')){
									echo $this->session->flashdata('flash_message');
							  	}
								echo form_open(ADMIN.'/edit_profile/', $attributes);
							?>
        						<fieldset>
									<div class="widget-header" style="padding-left:10px;" ><i class="icon-cogs"></i> &nbsp;&nbsp; Basic Informations	</div>
									<br/>
          							<div class="control-group">
            							<label for="inputError" class="control-label">First Name <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_input(array('name'=>'first_name','value'=>set_value('first_name', $this->input->post('first_name') ? $this->input->post('first_name') : $user['first_name']),'class'=> 'span3','id'=>'first_name') ); ?>
										<span class="text-danger"><?php echo form_error('first_name'); ?>
            							</div>
          							</div> 
          							<div class="control-group">
            							<label for="inputError" class="control-label">Last Name </label>
            							<div class="controls">
            							<?php
										echo form_input(array('name'=>'last_name','value'=>set_value('last_name', $this->input->post('last_name') ? $this->input->post('last_name') : $user['last_name']),'class'=> 'span3','id'=>'last_name') ); ?>
										<span class="text-danger"><?php echo form_error('last_name'); ?>
            							</div>
          							</div> 
          							<!--<div class="control-group">
            							<label for="inputError" class="control-label">Display Name </label>
            							<div class="controls">
            							<?php echo form_input(array('name'=>'display_name','value'=>set_value('display_name', $this->input->post('display_name') ? $this->input->post('display_name') : $user['display_name']),'class'=> 'span3','id'=>'display_name') ); ?>
										<span class="text-danger"><?php echo form_error('display_name'); ?>
            							</div>
          							</div>-->
          							<div class="control-group">
            							<label for="inputError" class="control-label">Email ID (Login) <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_input(array('name'=>'email','value'=>set_value('email', $this->input->post('email') ? $this->input->post('email') : $users['email']),'class'=> 'span3','id'=>'email') );
										?>
										<span class="text-danger"><?php echo form_error('email'); ?>
            							</div>
          							</div> 
									<div class="widget-header" style="padding-left:10px;" ><i class="icon-lock"></i> &nbsp;&nbsp;Change Password </div> 
									<br/>
									
									<div class="control-group">
            							<label for="inputError" class="control-label">Current Password </label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'old_password','id'=>'old_password'),set_value('old_password'),''); ?>
										<span class="text-danger"><?php echo form_error('old_password'); ?>
            							</div>
          							</div> 
          							<div class="control-group">
            							<label for="inputError" class="control-label">Password </label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'password','id'=>'password'),set_value('password'),$this->input->post('password')); ?>
										<span><abbr title="Combinations of one digit [0-9], one alphabet [A-Z] [a-z] and one special character such as [@#&*!]"> &nbsp;Tips !!</abbr></span>
										<span class="text-danger"><?php echo form_error('password'); ?>
            							</div>
          							</div>  
          							<div class="control-group">
            							<label for="inputError" class="control-label">New Password </label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'password2','id'=>'password2'),set_value('password2'),$this->input->post('password2')); ?>
										<span class="text-danger"><?php echo form_error('password2'); ?>
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