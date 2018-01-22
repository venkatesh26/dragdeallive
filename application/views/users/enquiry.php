<div class="login-main">
	<div class="login-inner">
		<h2>Login to Your Account</h2>
		<form id="new_login_form_url" action="<?php echo base_url().'home/login';?>" method="post">
			<div class="input">
				<input type="text" name="email" placeholder="Your E-mail ID" />
			</div>
			<div class="input">
				<input type="password" name="password" placeholder="Password" />
			</div>
			<input type="hidden" name="redirect_url" placeholder="Url" value="<?php echo $redirect_url;?>"/>
			<div class="submit">
				<a href="<?php echo base_url().'forgot_password';?>" class="register fancybox1 fancybox1.ajax" title="Forgot Your Password">Forgot Your Password ?</a>
				<input type="submit" name="submit" value="Submit" title="Submit" />
			</div>			
		</form>
	</div>
	<div class="social-login">
		<a href="<?php echo base_url().'facebook';?>" target="_blank" title="Sign In with Facebook" class="facebook">Facebook</a>
		<a href="<?php echo base_url().'googleplus';?>" title="Sign In with Google+" target="_blank" class="googleplus">Google+</a>
		<a href="<?php echo base_url().'twitter';?>" title="Sign In with Twitter" target="_blank" class="twitter">Twitter</a>
	</div>
</div>
