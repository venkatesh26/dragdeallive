<!doctype html >
<html lang=en-US>
<head>

    <?php 
	/****************** Meta Keywords***************/ 
	$this->load->view('meta-keywords'); 
	/******************Common Header***************/ 
	$this->load->view('layouts/theme-commonheader'); 

	if($this->router->fetch_class()=='home' && ($this->router->fetch_method()=='register' || $this->router->fetch_method()=='contact_us' ||  $this->router->fetch_method()=='claim_my_bussiness')){
								    
	} else {?>
								 
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-2739505616311307",
    enable_page_level_ads: true
  });
</script>
<?php } ?>
</head>
<body class="home-page home">
 <?php $this->load->view('elements/google_analytics'); ?>
  <div class=td-scroll-up><i class=td-icon-menu-up></i>
    </div>
    <div class=td-menu-background></div>
    <div id=td-mobile-nav>
	<?php $this->load->view('users/mobile_nav');?>
	<?php $this->load->view('users/login_mobile');?>   
	<?php $this->load->view('mobile_search');?>   	
	    <div id=td-outer-wrap>
		<?php
			/******************Common Header***************/ 
			$this->load->view('layouts/theme-topmenu'); 
			
			/******************Main Content***************/ 
			echo $main_content;
	    ?>
		</div>
		
    <?php 
	/******************Common Header***************/ 
	$this->load->view('layouts/theme-footer'); 
	?>
</body>
</html>