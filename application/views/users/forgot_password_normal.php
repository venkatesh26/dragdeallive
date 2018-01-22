<div class="td-main-content-wrap td-main-page-wrap">
    <div class="td-container">
        <?php 
		/************ Bread Crumb *****************/ 
		echo $this->load->view('bread_crumb',array(),true); 
		?>
		<div class="td-page-header">
					<h1 class="entry-title td-page-title">
					<span>Forgot Password ?</span>
					</h1>
					</div>
        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content" role="main">
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
                                                            <h4 class="block-title"><span>ForGot Password</span></h4>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="screen-reader-response"></div>
                                                        <form action="<?php echo base_url().'home/forgot_password';?>" method="post" id="forgotpassword_url">
                                                            <p><span class="wpcf7-form-control-wrap your-email">
															<input type="text" name="email_address" placeholder="Enter Your Email *" value="" size="40"></span>
                                                            </p>
                                                            <p>
                                                                <input type="submit" value="Send Reset Link" class="wpcf7-form-control wpcf7-submit" style="float:right;">
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
        </div>
    </div>
</div>