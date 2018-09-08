
<div class="account-container register">
	
	<div class="content clearfix">
		
		<form id="common_form_url" action="<?php echo base_url();?>users/register" method="post">
		
			<h1 style="font-size:15px;">Create a Free Account</h1>			
			
			<div class="login-fields">

				<div class="field">
					<label for="first_name">First Name:</label>
					<input type="text" id="first_name" name="first_name" value="" placeholder="First Name" class="login" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="last_name">Last Name:</label>	
					<input type="text" id="last_name" name="last_name" value="" placeholder="Last Name" class="login" />
				</div> <!-- /field -->
				
				
				<div class="field">
					<label for="email">Email Address:</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="confirm_password">Confirm Password:</label>
					<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Confirm Password" class="login"/>
				</div> <!-- /field -->
			
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
							
				<button class="button btn btn-primary btn-large">Create Account</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

<!-- Text Under Box -->
<div class="login-extra">
	
	By creating an account, you agree to 
drg.tw Terms of Service and Privacy Policy.
Already have an account? <a href="<?php echo base_url();?>login">Sign In</a>

</div> <!-- /login-extra -->
<br/>