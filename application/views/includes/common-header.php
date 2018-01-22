<?php
include 'mobile_detect.php';
$detect = new Mobile_Detect();
$is_thank_you =false;
if ($detect->isMobile() && !$detect->isTablet()) { ?>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
<?php } ?>
<meta name="format-detection" content="telephone=no">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link type="text/css" rel="stylesheet" href="css/reset.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="fonts/fonts.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/jquery.bxslider.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/selectric.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/jquery.mCustomScrollbar.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/jquery.fancybox.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/jquery.fancybox-buttons.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/jquery.fancybox-thumbs.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/slicknav.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/font-awesome.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/style.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="css/screen.css" media="screen"/>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<script type="text/javascript" src="js/css3-mediaqueries.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/jquery.selectBox.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-media.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-thumbs.js"></script>
<script type="text/javascript" src="js/responsiveslides.js"></script>
<script type="text/javascript" src="js/jquery.slicknav.js"></script>
<script type="text/javascript" src="js/main.js"></script>
