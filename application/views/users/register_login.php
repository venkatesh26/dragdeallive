<div class="td-main-content-wrap td-main-page-wrap">
    <div class="td-container">
        <?php 
		/************ Bread Crumb *****************/ 
		echo $this->load->view('bread_crumb',array(),true); 
		?>
		<div class="td-page-header">
					<h1 class="entry-title td-page-title">
					<span>Register / Login</span>
					</h1>
					</div>
		
        <div class="td-pb-row">
            <div class="td-pb-span6 td-main-content" role="main">
                <div class="td-ss-main-content">
					
                    <div class="td-pb-padding-side td-page-content">
                        <div class="vc_row wpb_row td-pb-row">
                            <div class="wpb_column vc_column_container td-pb-span12">
                                <div class="wpb_wrapper">
                                    <div class="vc_row wpb_row vc_inner td-pb-row">
                                        <div class="wpb_column vc_column_container td-pb-span12">
                                            <div class="vc_column-inner ">
                                                <div class="wpb_wrapper">
                                                    <div class="wpb_raw_code wpb_content_element wpb_raw_html">
                                                        <div class="wpb_wrapper">
                                                            <h4 class="block-title"><span>New User Sign Up</span></h4>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="screen-reader-response"></div>
                                                        <form action="<?php echo base_url().'home/register';?>" method="post" id="login_form_url">
                                                            <p><span class="wpcf7-form-control-wrap your-name">
															<input type="text" name="name" placeholder="Enter Your Name *" value="" size="40"></span>
                                                            </p>
                                                            <p><span class="wpcf7-form-control-wrap your-email">
															<input type="text" name="email" placeholder="Enter Your Email *" value="" size="40"></span>
                                                            </p>
                                                            <p><span class="wpcf7-form-control-wrap your-subject">
															<input type="text" name="contact_number" placeholder="Enter Your Mobile Number *" value="" size="40">
															</span>
                                                            </p>
															 <p><span class="wpcf7-form-control-wrap your-subject">
															 <input type="password" name="password" placeholder="Enter Your Password *" value="" size="40"></span>
                                                            </p>
															 <p><span class="wpcf7-form-control-wrap your-subject"><input type="password" name="confirm_password" placeholder="Enter Your Confirm Password *" value="" size="40"></span>
                                                            </p>
                                                            <p>
                                                                <input type="submit" value="Register" class="wpcf7-form-control wpcf7-submit register-submit-button" style="float:right;">
                                                            </p>
                                                            <div class="wpcf7-response-output wpcf7-display-none"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="td-pb-span6 td-main-content">
                <div class="td-ss-main-content">
                    <div class="td-pb-padding-side td-page-content">
                        <div class="vc_row wpb_row td-pb-row">
                            <div class="wpb_column vc_column_container td-pb-span12">
                                <div class="wpb_wrapper">
                                    <div class="vc_row wpb_row vc_inner td-pb-row">
                                        <div class="wpb_column vc_column_container td-pb-span12">
                                            <div class="vc_column-inner ">
                                                <div class="wpb_wrapper">
												 <form action="<?php echo base_url().'home/login';?>" id="new_login_form_url"  method="post">
                                                    <div class="wpb_raw_code wpb_content_element">
                                                        <div class="wpb_wrapper">
                                                            <h4 class="block-title"><span>I am Already Register</span></h4>
                                                        </div>
                                                    </div>
                                                       
                                                            <p><span class="wpcf7-form-control-wrap your-name">
															<input type="text" name="email" value="" placeholder="Enter Your Email *" size="40" autocomplete="off"></span>
                                                            </p>
                                                            <p><span class="wpcf7-form-control-wrap your-email">
															<input type="password" placeholder="Enter Your Password *" name="password" value="" size="40">
															</span>
                                                            </p>
                                                           <a href="<?php echo base_url().'forgot_password';?>">Forgot Password ?</a>
                                                                <input type="submit" value="Login" class="login-button" style="align:right;">
                                                            </p>
															<div class="td-post-sharing td-post-sharing-top "> 
															<div class="td-default-sharing"> <a href="<?php echo base_url().'facebook';?>" class="td-social-sharing-buttons td-social-facebook"><i class="fa fa-facebook"></i><div class="td-social-but-text">Login Using Facebook</div></a> 

															<a href="<?php echo base_url().'twitter';?>" class="td-social-sharing-buttons td-social-twitter"><i class="fa fa-twitter"></i><div class="td-social-but-text">Login Using Twitter</div></a> 

															<a href="<?php echo base_url().'googleplus';?>" target="_blank" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-google-plus"></i><div class="td-social-but-text">Login Using G+</div></a> 
															</div> 
															</div>
                                                        
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>