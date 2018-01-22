<?php 
$height='90px';
if($this->detect->isMobile() || $this->detect->isTablet()):
$height='180px';
endif; 
?>
<div class="td-header-wrap td-header-style-2">
	<div class="td-header-top-menu-full">
        <div class="td-container td-header-row td-header-top-menu">
                    <div class=top-bar-style-1>
                        <div class=td-header-sp-top-menu>
                            <div class=td_data_time>
                                <div>
                                    <?php echo date("D , M Y");?>
                                </div>
                            </div>
							<ul class="top-header-menu td_ul_login">
								<li class=menu-item><a class="" href="<?php echo base_url();?>" data-effect=mpf-td-login-effect>Home</a><span class="td-sp-ico-login td_sp_login_ico_style"></span>
								</li>
							</ul>
							<?php if(!$this->session->userdata('is_user_logged_in')):?>
								<ul class="top-header-menu td_ul_login">
									<li class=menu-item><a class="td-login-modal-js menu-item" href="#login-form" data-effect=mpf-td-login-effect>Login</a><span class="td-sp-ico-login td_sp_login_ico_style"></span>
									</li>
								</ul>
								<?php else:?>
								 <ul class="top-header-menu td_ul_login">
									<li class=menu-item><a class="" href="<?php echo base_url().'dashboard';?>" data-effect=mpf-td-login-effect>Go To Dashboard</a><span class="td-sp-ico-login td_sp_login_ico_style"></span>
									</li>
									 <li class=menu-item><a class="" href="<?php echo base_url().'logout';?>" data-effect=mpf-td-login-effect>Logout</a><span class="td-sp-ico-login td_sp_login_ico_style"></span>
									</li>	
								</ul>
							<?php endif;?>
                            <div class=menu-top-container>
                                <ul id=menu-top-menu class=top-header-menu>
									<?php if(!$this->session->userdata('is_user_logged_in')):?>
                                    <li class="menu-item"><a href="<?php echo base_url().'register';?>">Register</a>
                                    </li>
									<?php endif;?>	
                                    <li  class="menu-item"><a href="<?php echo base_url().'search/chennai/';?>">YellowPages</a>
                                    </li>
                                   
                                    <li  class="menu-item"><a href="<?php echo base_url().'contact-us'; ?>">Contact Us</a>
                                    </li>
									<li class="menu-item"><a href="<?php echo base_url().'claim-my-bussiness'; ?>">Claim My Bussiness</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class=td-header-sp-top-widget>
							<span class=td-social-icon-wrap>
							<a target=_blank href="#" title=Facebook>
								<i class="fa fa-facebook"></i>
							</a>
							</span>
							<span class=td-social-icon-wrap>
							<a target=_blank href="#" title=Twitter>
							<i class="fa fa-twitter"></i>
							</a>
							</span>
							<span class=td-social-icon-wrap>
							<a target=_blank href="#" title=VKontakte>
							<i class="fa fa-google-plus"></i>
							</a>
							</span>
							<span class=td-social-icon-wrap>
							<a target=_blank href="#" title=Youtube>
							<i class="fa fa-youtube"></i>
							</a>
							</span>
                        </div>
                    </div>
                    <div id=login-form class="white-popup-block mfp-hide mfp-with-anim">
                        <ul class=td-login-tabs>
                            <li><a>LOG IN</a>
                            </li>
                        </ul>
                        <div class=td-login-wrap>
                            <div class=td_display_err></div>
                            <div id=td-login-div class="">
								<form method="post" action="<?php echo base_url().'home/login';?>" id="new_login_form_url_popup">
                                <div class=td-login-panel-title>Welcome! Log into your account</div>
                                <input class=td-login-input type=text name=email  placeholder="Your Email *" value="">
                                <input class=td-login-input type=password name=password  placeholder="Your Password *">
                                <input type=submit name=login_button class="wpb_button btn td-login-button" value="Log In">
								</form>
								<div class="wpb_wrapper">
									<div class="td-post-sharing td-post-sharing-top "> 
										<div class="td-default-sharing"> <a href="<?php echo base_url().'facebook';?>" class="td-social-sharing-buttons td-social-facebook"><i class="fa fa-facebook"></i></a> 

										<a href="<?php echo base_url().'twitter';?>" class="td-social-sharing-buttons td-social-twitter"><i class="fa fa-twitter"></i></a> 

										<a href="<?php echo base_url().'googleplus';?>" target="_blank" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-google-plus"></i></a> 
										</div> 
									</div>
								</div>
                                <div class=td-login-info-text><a href="#" id=forgot-pass-link>Forgot your password?</a>
                                </div>
                            </div>

							<form method="post" action="<?php echo base_url().'home/forgot_password';?>" id="forgotpassword_url_popup">
                            <div id=td-forgot-pass-div class=td-display-none>
                                <div class=td-login-panel-title>Recover your password</div>
                                <input class=td-login-input type=text name=email_address id=forgot_email placeholder="Enter Your Email *" value="">
                                <input type=submit name=forgot_button class="wpb_button btn td-login-button" value="Send My Pass">
                            </div>
							</form>
                        </div>
                    </div>
					
					<div id=enquiry-form class="white-popup-block enquiry-popup-block mfp-hide mfp-with-anim">
                        <ul class=td-login-tabs>
                            <li><a>Enquiry</a>
                            </li>
                        </ul>
                        <div class=td-login-wrap>
                            <div class=td_display_err></div>
                            <div id=td-login-div class="">
								<form method="post" action="<?php echo base_url().'home/enquiry';?>" id="new_enquiry_form_url_popup">
                                <div class=td-login-panel-title>Send enquiry to <span class="enquiry_form_title"></span></div>
								<div class="enquiry_form_inputs">
									<div>
										<input class=td-login-input type=text name=name  placeholder="Enter Your Name *" value="">
									</div>
									<div>
									<input class=td-login-input type=text name=email  placeholder="Enter Your Email *" value="">
									</div>
								</div>
								<div class="enquiry_form_inputs">
									<div>	
										<input class=td-login-input type=text name=contact_no  placeholder="Enter Your Contact Number *" value="">
									</div>
									<div>	
										<input class=td-login-input type=text name=title  placeholder="Enquiry Title" value="">
										<input class="enquiry_advertisment_id" type=hidden name=advertisment_id  value="" id="enquiry_advertisment_id">
										<input class="advertisment_email" type=hidden name=advertisment_email  value="" id="advertisment_email">
										<input class="advertisment_user_id" type=hidden name=advertisment_user_id  value="" id="advertisment_user_id">
									</div>
								</div>
                                <textarea class="td-login-input enquiry-textarea" placeholder="Your Message" value="" name="message" width="100%"></textarea>
								<input type=submit name=login_button class="wpb_button btn td-login-button td-enquiry-button" value="Send Enquiry">
								</form>
                            </div>
                        </div>
                    </div>
					
						<a href="#enquiry-form1" class="js-keyword-enquiry td-keyword-modal-js" data-effect="mpf-td-login-effect"></a>
					<div id="enquiry-form1" class="white-popup-block enquiry-popup-block mfp-hide mfp-with-anim">
                        <ul class="td-login-tabs">
                            <li>
							<a>Fill this form and get best deals from <b>"<span class="keyword_enquiry_keyword"></span>"</b>
								<br>- <b><span class="keyword_enquiry_city">  </span> </b>
								<b> <span class="keyword_enquiry_area"></span></b>
								</a>
                            </li>
                        </ul>
                        <div class=td-login-wrap>
                            <div class=td_display_err></div>
                            <div id=td-login-div class="keyword_enquiry_popup">
								<form method="post" action="<?php echo base_url().'home/keyword_enquiry';?>" id="new_keyword_enquiry_form_url_popup">
                                <div class=td-login-panel-title>Send enquiry to <span class="keyword_enquiry_form_title"></span></div>
								<div>
										<input class="td-login-input" type=text name=name  placeholder="Enter Your Name *" value="">
									</div>
									<div>
									<input class="td-login-input" type=text name=email  placeholder="Enter Your Email *" value="">
									</div>
									<div>	
										<input class=td-login-input type=text name=contact_no  placeholder="Enter Your Contact Number *" value="">
									</div>
									<input  type=hidden name="keyword" id="keyword_enquiry_keyword">
									<input  type=hidden name=city id="keyword_enquiry_city">
									<input  type=hidden name=area id="keyword_enquiry_area">
								<input type=submit name=login_button class="wpb_button btn td-login-button td-enquiry-button" value="Submit">
									<p style="clear:both;"><i class="fa fa-check-circle" style="color:green;"></i> We share your contact information to best bussiness  service agency.</p>
									<p><i class="fa fa-check-circle" style="color:green;"></i> We send you best service provider information in your nearset location.</p>
								</form>
                            </div>
                        </div>
                    </div>
					
					
					<a href="#coupon-download" class="js-coupon-enquiry td-coupon-modal-js" data-effect="mpf-td-login-effect"></a>
					<div id="coupon-download" class="white-popup-block enquiry-popup-block mfp-hide mfp-with-anim" style="height:auto;">
					   <ul class="td-login-tabs">
                            <li>
							<?php if(isset($result['name'])):?>
								<a><b class="download_coupon_title"> <?php echo ucwords($result['name']);?></b></a>
							<?php endif;?>
                            </li>
                        </ul>
                        <div class=td-login-wrap>
                            <div class=td_display_err></div>
                            <div id=td-login-div class="keyword_enquiry_popup" style="background: #eee;padding: 17px;">
							        <div class="success_message">
										<p style="clear:both;font-size:16px;"><i class="fa fa-gift" style="color:#ff9632;"></i> Thanks for downloading coupon.</p>
										<p  style="clear:both;font-size:16px;"><i class="fa fa-info-circle"  style="color:#ff9632;"></i> Please use the following code at store to avail this offer.<b class="js_coupon_code"> </b></p>
										<p class="mobile_send" style="display:none;clear:both;font-size:18px;"> <i class="fa fa-mobile" style="color:#ff9632;"></i>  We also Sent this offer to your mobile.</p>
									</div>
                            </div>
                        </div>
                    </div>
					
                </div>
            </div>
			            <div class=td-header-menu-wrap-full>
                <div class="td-header-menu-wrap td-header-gradient">
                    <div class="td-container td-header-row td-header-main-menu">
                        <div id=td-header-menu role=navigation>
                            <div id=td-top-mobile-toggle><a href="#"><i class="td-icon-font td-icon-mobile"></i></a>
                            </div>
                            <div class="td-main-menu-logo td-logo-in-header">
                                <a class="td-mobile-logo td-sticky-header" href="<?php echo base_url();?>">
                                    <img class=td-retina-data data-retina="<?php echo base_url().'assets/themes/images/footer_logo1.png'?>" src="<?php echo base_url().'assets/themes/images/footer_logo1.png'?>" alt="" />
                                </a>
                                <a class="td-header-logo td-sticky-header" href="<?php echo base_url();?>">
                                    <img class=td-retina-data data-retina="<?php echo base_url().'assets/themes/images/footer_logo1.png'?>" src="<?php echo base_url().'assets/themes/images/footer_logo1.png'?>" alt="" />
                                </a>
                            </div>
                            <div class=menu-main-menu-container>
                                <ul id=menu-main-menu-1 class=sf-menu>
									<li class="menu-item td-menu-item td-normal-menu"><a href="<?php echo base_url().'search/chennai'?>"><i class="fa fa-home"></i> YellowPages</a></li>
									<?php if(!$this->session->userdata('is_user_logged_in')):?>
									<li class="menu-item td-menu-item td-normal-menu"><a class="td-login-modal-js menu-item" href="#login-form" data-effect="mpf-td-login-effect"><i class="fa fa-lock"></i> Login</a></li>
									<li class="menu-item td-menu-item td-normal-menu"><a href="<?php echo base_url().'register'?>"><i class="fa fa-group"></i> Register</a></li>
									<?php else:?>
										<li class="menu-item td-menu-item td-normal-menu"><a href="<?php echo base_url().'dashboard'?>"><i class="fa fa-dashboard"></i> My Dashboard</a></li>
									<?php endif;?>
								
									<li class="menu-item td-menu-item td-normal-menu"><a href="<?php echo base_url().'contact-us'?>"><i class="fa fa-mobile"></i> Contact Us</a></li>
									
								    <?php 
									$headerCities=header_cities();
									$cities_1=array_slice($headerCities,0,6);
									$cities_2=array_slice($headerCities,6,7);
							
									?>                                
                                    <li class="menu-item menu-item-type-custom  dfmenu-item-150">
										<a href="#">More</a>
                                        <ul class>
                                        <?php 
										foreach($cities_1 as $city){
											$city_link=base_url().'search/'.url_title(strtolower($city['name']));
											echo '<li class="menu-item  page_item page-item-139  td-menu-item td-normal-menu"><a href="'.$city_link.'">'.ucfirst($city['name']).'</a></li>';
										}?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class=td-search-wrapper>
                            <div id=td-top-search>
                                <div class=header-search-wrap>
                                    <div class="dropdown header-search">
                                        <a id=td-header-search-button href="#" role=button class="dropdown-toggle " data-toggle=dropdown><i class=td-icon-search></i></a>
                                        <a id=td-header-search-button-mob href="#" role=button class="dropdown-toggle " data-toggle=dropdown><i class=td-icon-search></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=header-search-wrap>
                            <div class="dropdown header-search topmenu-home-search" >
                                <div class=td-drop-down-search style="width:540px;">
                                   <form id="home-search" class="normal" method="GET" action="<?php echo base_url().'listings';?>">
								   
								   <div class="location-wrapper">
									    <?php 
										$select_city=(isset($_GET['city']))?$_GET['city']:'';
										$select_city_id=(isset($_GET['city_id']))?$_GET['city_id']:'';
										$select_area=(isset($_GET['area']))?$_GET['area']:'';
										$select_area_id=(isset($_GET['area_id']))?$_GET['area_id']:'';
										$category=(isset($_GET['category']))?$_GET['category']:'';
										$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';
										?>
										<div class="top_home_search">
											<input type="text" name="city" id="home-city" autocomplete="off" width="50%" placeholder="Search City" value="<?php echo $select_city;?>">
											<input type="hidden" name="city_id" value="<?php echo $select_city_id?>" id="city_id"/>
											<input type="text" name="area" id="home-area" autocomplete="off" width="50%" value="<?php echo $select_area;?>" placeholder="Search Location"/>
											<input type="hidden" name="area_id" value="<?php echo $select_area_id;?>" id="area_id"/>
										</div>
										&nbsp;
										</div>
										<div class=td-head-form-search-wrap>
									        <input type="text"  autocomplete="off" name="keyword" value="<?php echo $keyword;?>" id="td-header-search-new" placeholder="Search Keyword"/>
											<input type="hidden" name="category" value="<?php echo $category;?>" id="category_id"/>
											<input type="hidden" name="listing_name" value="" id="listing_name"/>	
											<input class="wpb_button wpb_btn-inverse btn" type=submit id=td-header-search-top value=Search />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php if(!isset($is_header_hide)) :?>	
			 <div class=td-banner-wrap-full>
                <div class="td-container td-header-row td-header-header">
                    <div class=td-header-sp-logo>
						<h1 class=td-logo> <a class=td-main-logo href="<?php echo base_url();?>">
						<img class=td-retina-data data-retina="<?php echo base_url().'assets/themes/images/new_logo.png';?>" src="<?php echo base_url().'assets/themes/images/new_logo.png';?>" alt=""/>
						<span class=td-visual-hidden>Dragdeal</span>
						</a>
						</h1> </div>
                    <div class=td-header-sp-recs>
                  
                        <div class=td-header-rec-wrap style="min-height:90px;width:100% !important;">
                            <div class="td-a-rec td-a-rec-id-header top_header_list_section" style="width:100% !important;padding-top:10px;padding-left:10px;">
                                <div>
								<?php
								if($this->router->fetch_class()=='home' && ($this->router->fetch_method()=='register' || $this->router->fetch_method()=='contact_us' ||  $this->router->fetch_method()=='claim_my_bussiness')){
								    
								}    
							else if(($this->router->fetch_class()=='listings' && $this->router->fetch_method()=='view') || ($this->router->fetch_class()=='listings' && $this->router->fetch_method()=='index') || ($this->router->fetch_class()=='jobs' && $this->router->fetch_method()=='view') || ($this->router->fetch_class()=='jobs' && $this->router->fetch_method()=='index')){?>
						<?php	if($this->detect->isMobile() || $this->detect->isTablet()):?>
							
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- Link ads -->
								<ins class="adsbygoogle"
									 style="display:block"
									 data-ad-client="ca-pub-2739505616311307"
									 data-ad-slot="8317491279"
									 data-ad-format="link"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
						<?php else: ?>	
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- green -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="3266599894"
     data-ad-format="link"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
								<br/>
						<?php	
						endif;
							}else{?>
				
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- new_theme_top_responsive -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="6108851673"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
		<?php 	} ?>
		
              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  <?php endif;?>
			</div>
