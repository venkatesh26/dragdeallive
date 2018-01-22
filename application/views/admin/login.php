<div class="account-container">
	<div class="content clearfix">
		<?php echo form_open(ADMIN.'/login',array('id' => 'loginform')); ?>
			<h1>Login</h1>		
			<div class="login-fields">
				<p>Please provide your details</p>
				<?php
				if(isset($message_error) && $message_error){
					  echo '<div class="alert alert-error">';
						echo '<a class="close" data-dismiss="alert">×</a>';
						echo 'Invalid User Email or Password.';
					  echo '</div>';             
				  }
				  if(isset($message) && $message){
				  echo $message;
				  }
				  if($this->session->flashdata('flash_message')=="pwrd_updated") {
					echo '<div class="alert alert-success"><a class="close" 
						data-dismiss="alert">×</a><strong>';
						echo "Password updated succesfully.";	
						echo '</strong></div>';	
				  }
				?>
				<div class="field">
					<label for="username">Username</label>
					<?php echo form_input(array('name'=>'user_name','class'=> 'login username-field','placeholder'=>'User Email','id'=>'user_name'),$this->input->post('user_name')); ?>
				</div> <!-- /field -->
				<div class="field">
					<label for="password">Password:</label>
					<?php echo form_password(array('name'=>'password','class'=> 'login password-field','placeholder'=>'Password','id'=>'password'),''); ?>
				</div> <!-- /password -->
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<?php echo form_submit('submit', 'Sign In', 'class="button btn btn-success btn-large"'); ?>
			</div> <!-- .actions -->
		<?php echo form_close(); ?>
	</div> <!-- /content -->
</div> <!-- /account-container -->

<div class="login-extra">
	<?php echo anchor(ADMIN.'/forgotpassword', 'Forgot your password ?'); ?>
</div> <!-- /login-extra -->