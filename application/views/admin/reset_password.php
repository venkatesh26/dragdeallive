<div class="account-container">
	<div class="content clearfix">
		<?php echo form_open(ADMIN.'/resetpassword',array('id' => 'resetpassword')); ?>
			<h1>Reset Password</h1>		
			<div class="login-fields">
				<p>Please provide your details</p>
				<?php
				if(isset($message_error) && $message_error){
					  echo '<div class="alert alert-error">';
						echo '<a class="close" data-dismiss="alert">×</a>';
						echo 'Email ID does not exist!';
					  echo '</div>';             
				  }
				  if($this->session->flashdata('flash_message')=="done") {
					echo '<div class="alert alert-success"><a class="close" 
						data-dismiss="alert">×</a><strong>';
						echo "Mail has been sent to u successfully !";	
						echo '</strong></div>';	
				  }
				  if(isset($message) && $message){
				  echo $message;
				  }
				?>
				<?php echo form_input(array('name'=>'uid','style'=>'display:none','value'=> $UID)); ?>
					
					<div class="field">			
					<label for="password">Password:</label>
					<?php echo form_password(array('name'=>'password','class'=> 'login password-field','placeholder'=>'Password','id'=>'password'),''); ?> </div>
					
					<div class="field">
					<label for="password">Password:</label>
					<?php echo form_password(array('name'=>'password2','class'=> 'login password-field','placeholder'=>'Confirm Password','id'=>'password2'),''); ?>					
				</div> <!-- /field -->
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<?php echo form_submit('submit', 'Submit', 'class="button btn btn-success btn-large"'); ?>
			</div> <!-- .actions -->
		<?php echo form_close(); ?>
	</div> <!-- /content -->
</div> <!-- /account-container -->

<div class="login-extra">
	<?php echo anchor(ADMIN, '<< Go to Login'); ?>
</div> <!-- /login-extra -->