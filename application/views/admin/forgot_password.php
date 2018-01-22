<div class="account-container">
	<div class="content clearfix">
		<?php echo form_open(ADMIN.'/forgotpassword',array('id' => 'forgotpassword')); ?>
			<h1>Forgot Password</h1>		
			<div class="login-fields">
				<p>Please provide your details</p>
				<?php 
					if($this->session->flashdata('flash_message')){
						echo $this->session->flashdata('flash_message');
					  }
				echo validation_errors();
				?>
				<div class="field">
					<label for="username">Username</label>
					<?php echo form_input(array('name'=>'email_address','class'=> 'login username-field','placeholder'=>'User Email','id'=>'email_address'),$this->input->post('email_address')); ?>
				</div> <!-- /field -->
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<?php echo form_submit('submit', 'Submit', 'class="button btn btn-success btn-large"'); ?>
			</div> <!-- .actions -->
		<?php echo form_close(); ?>
	</div> <!-- /content -->
</div> <!-- /account-container -->

<div class="login-extra">
	<?php echo anchor(ADMIN, '<< Back to Login'); ?>
</div> <!-- /login-extra -->