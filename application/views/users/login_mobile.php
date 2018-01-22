       <div id=login-form-mobile class=td-register-section>
            <div id=td-login-mob class="td-login-animation td-login-hide-mob">
                <div class=td-login-close>
                    <a href="#" class=td-back-button><i class=td-icon-read-down></i></a>
                    <div class=td-login-title>Sign in</div>
                    <div class=td-mobile-close>
                        <a href="#"><i class=td-icon-close-mobile></i></a>
                    </div>
                </div>
                <div class=td-login-form-wrap>
					<form action="<?php echo base_url().'home/login';?>" method="post" id="new_login_form_url_popup">
						<div class=td-login-panel-title><span>Welcome!</span>Log into your account</div>
						<div class=td_display_err></div>
						<div class=td-login-inputs>
							<input class=td-login-input type=text name=email id=login_email-mob value="">
							<label>Your Email</label>
						</div>
						<div class=td-login-inputs>
							<input class=td-login-input type=password name=password id=login_pass-mob value="">
							<label>Your Password</label>
						</div>
						<input type=submit name=login_button class=td-login-button value="LOG IN">
						<div class="wpb_wrapper">
									<div class="td-post-sharing td-post-sharing-top "> 
										<div class="td-default-sharing"> <a href="<?php echo base_url().'facebook';?>" class="td-social-sharing-buttons td-social-facebook"><i class="fa fa-facebook"></i></a> 

										<a href="<?php echo base_url().'twitter';?>" class="td-social-sharing-buttons td-social-twitter"><i class="fa fa-twitter"></i></a> 

										<a href="<?php echo base_url().'googleplus';?>" target="_blank" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-google-plus"></i></a> 
										</div> 
									</div>
								</div>
						<div class=td-login-info-text><a href="#" id=forgot-pass-link-mob>Forgot your password?</a>
						</div>
					</form>
                </div>
            </div>
            <div id=td-forgot-pass-mob class="td-login-animation td-login-hide-mob">
                <div class=td-forgot-pass-close>
                    <a href="#" class=td-back-button><i class=td-icon-read-down></i></a>
                    <div class=td-login-title>Password recovery</div>
                </div>
                <div class=td-login-form-wrap>
                    <div class=td-login-panel-title>Recover your password</div>
                    <div class=td_display_err></div>
						<form action="<?php echo base_url().'home/forgot_password';?>" method="post" id="forgotpassword_url_popup">
                    <div class=td-login-inputs>
                        <input class=td-login-input type=text name=email_address id=forgot_email-mob value="">
                        <label>Your Email *</label>
                    </div>
                    <input type=submit name=forgot_button class=td-login-button value="Send My Pass">
					</form>
                </div>
            </div>
        </div>
    </div>