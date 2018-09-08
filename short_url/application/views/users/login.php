<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="<?php base_url();?>" id="login_form_url" method="post">
		
			<h1 style="font-size:20px;"><i class="user-profile"></i>Login</h1>		
			
			<div class="login-fields">
				
				<p>Please provide your details</p>
				
				<div class="field">
					<label for="email">Username</label>
					<input type="text" autocomplete="off" id="email" name="email" value="" placeholder="Email-ID" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" style="display:none">
					<input type="password" autocomplete="off" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
		
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
				
				
									
				<button class="button btn btn-success btn-large">Sign In</button>
				
				
				
			</div> <!-- .actions -->
			<div class="login-actions">
			<a href="<?php base_url();?>forgot-password">Forgot Password</a>
			</div>
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">

Don't havs have an account? <a href="<?php echo base_url();?>register">Sign Up</a>

</div> <!-- /login-extra -->

<div class="login-extra">
	
</div> <!-- /login-extra -->
<br/>
<br/><br/><br/><br/>
<br/>
<br/>