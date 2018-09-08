<div class="account-container">
	
	<div class="content clearfix">
		
		<form id="common_form_url" action="<?php echo base_url();?>reset_password/<?php echo $slug;?>" method="post">
		
			<h1 style="font-size:15px;">Reset Password</h1>		
			
			<div class="login-fields">
				
				<p>Please provide your details</p>
				
				<div class="field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login username-field" />
				</div> <!-- /field -->
				
					<div class="field">
					<label for="confirm_password">Password</label>
					<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Confirm password" class="login username-field" />
				</div> <!-- /field -->
				
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">

									
				<button class="button btn btn-success btn-large">Submit</button>
				
			</div> <!-- .actions -->
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<br><br><br><br><br><br><br><br><br><br><br><br>