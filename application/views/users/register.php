<div class="login-main registration-main">
    <div class="login-inner">
		<h2>Sign Up</h2>
		<form id="login_form_url" action="<?php echo base_url().'home/register';?>" method="post">
			<div class="input">
				<input type="text" autocomplete="off"  name="name" placeholder="Name *" />
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="contact_number" placeholder="Mobile Number *" />
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="email" placeholder="Email *" />
			</div>
			<div class="input">
				<input type="password" name="password" placeholder="Password *"/>
			</div>
			<div class="input">
				<input type="password" name="confirm_password" placeholder="Confirm Password *" />
			</div>
			<div class="submit">
				<input type="submit" name="submit" value="Submit" title="Submit" />
				<input type="button" name="Cancel" class="cancel-button" value="Cancel" title="Cancel" />
			</div>			
		</form>
	</div>
</div>