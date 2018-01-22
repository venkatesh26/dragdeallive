<div class="login-register">
<div class="login-main registration-main">
    <div class="login-inner">
		<h3>My Profile</h3>
		<div class="border-class">
		<form id="new_profile_form_url" action="<?php echo base_url().'home/my_profile';?>" method="post">
			<div class="input">
				<input type="text" autocomplete="off" id="name" name="name" value="<?php echo $user_data['first_name'];?>" placeholder="Name *" />
			</div>
			<div class="input">
				<input type="text" autocomplete="off" id="contact_number" name="contact_number" value="<?php echo $user_data['mobile_number'];?>" placeholder="Contact Number *" />
			</div>
			<div class="input">
				<input type="text" autocomplete="off" id="email" name="email" value="<?php echo $user_data['email'];?>" placeholder="Email *" />
			</div>		
			<div class="input">
				<input type="file" name="profile_image" class="file_error" accept="image/*">
			</div>
			<div class="submit">
				<input type="submit" name="submit" value="Submit" title="Submit" />
		</div>			
		</form>
		</div>
	</div>
</div>
<?php if($this->session->userdata('register_type')=='1' || $this->session->userdata('register_type')=='4'):?>
<div class="login-main">
	<div class="login-inner">
		<h3>Change Password</h3>
	<div class="border-class">
		<form id="new_change_form_url" autocomplete="off" action="<?php echo base_url().'home/change_password';?>" method="post">
			<div class="input">
				<input type="password" autocomplete="off" name="old_password" placeholder="Old Password" />
			</div>
			<div class="input">
				<input type="password" autocomplete="off" name="password" placeholder="New Password" />
			</div>
			<div class="input">
				<input type="password" autocomplete="off" name="password1" placeholder="Confirm Password" />
			</div>
			<div class="submit change-pass">
				<input type="submit" name="submit" class="no-change" value="Change Password" title="Change Password" />
			</div>			
		</form>
	</div>
	</div>
</div>
<?php endif;?>
</div>