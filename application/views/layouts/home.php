<!doctype html >
<html lang=en-US>
<head>
<meta name="p:domain_verify" content="62b9462e4d5ef77088781880c4abb04d"/>
<meta name="google-site-verification" content="LG_Fhar_yf4lLNu8kkUgciknljTtqGDcTEgLZK92-oQ" />
    <?php 
	/****************** Meta Keywords***************/ 
	$this->load->view('meta-keywords'); 
	/******************Common Header***************/ 
	$this->load->view('layouts/theme-commonheader'); 
	?>
</head>
<body class="home-page">
 <?php $this->load->view('elements/google_analytics'); ?>
    <div class=td-scroll-up><i class=td-icon-menu-up></i>
    </div>
    <div class=td-menu-background></div>
    <div id=td-mobile-nav>
    <?php $this->load->view('users/mobile_nav');?>
	<?php $this->load->view('users/login_mobile');?>
	<?php $this->load->view('users/login_enquiry');?>
	<?php $this->load->view('mobile_search');?>
    <div id=td-outer-wrap>
            <?php
				/******************Common Header***************/ 
				$this->load->view('layouts/theme-topmenu'); 
			?>
            <div class="td-main-content-wrap td-main-page-wrap">
               <div class=td-container>
				   <?php $this->load->view('advertisments/home_coupon_list'); ?>
				   <?php $this->load->view('categories/home_cities'); ?>
                </div>
            </div>
			
			<div class="td-main-content-wrap td-main-page-wrap">
			  <div class=td-container>
				<?php $this->load->view('advertisments/home_premium_list'); ?>
               </div>
            </div>
			
			<!--------- Latest Articles-------------->
            <div class="td-container td-pb-article-list">
                <div class=td-pb-row>
				<?php   
					/******************Home List***************/ 
					$this->load->view('advertisments/home_list'); 
					$this->load->view('advertisments/home_side_widget'); 
				?>
                </div>
            </div>
        </div>
    <?php 
	/******************Common Header***************/ 
	$this->load->view('layouts/theme-footer'); 
	?>
</body>
</html>