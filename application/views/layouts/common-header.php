<?php
include_once 'mobile_detect.php';
$detect = new Mobile_Detect();
$is_thank_you =false;
if ($detect->isMobile() && !$detect->isTablet()) { ?>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<?php } ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'assets/themes/images/new_logo.png';?>">
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/reset.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts/fonts.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.min.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/selectric.css" media="screen"/>
<!--<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.css" media="screen"/>-->
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/slicknav.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/amaran.min.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/site.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/screen.css" media="screen"/>

<script>
var cfg = {"cfg":{"path_absolute":"<?php echo base_url(); ?>"}};
</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.livequery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectBox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mCustomScrollbar.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js"></script>	
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.slicknav.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.amaran.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.js"></script>
<script>
var success_message='<?php echo $this->session->flashdata('success'); ?>';
var error_message='<?php echo $this->session->flashdata('error'); ?>';
var info='<?php echo $this->session->flashdata('info'); ?>';
var type='';
var msg='';
if(success_message!='')
{
	type="success";
	msg='<?php echo $this->session->flashdata('success'); ?>';
}
if(error_message!='')
{
	type="error";
	msg='<?php echo $this->session->flashdata('error'); ?>';
}
if(info!='')
{
	type="info";
	msg='<?php echo $this->session->flashdata('info'); ?>';
}
if(msg!='' && type!='')
{
   alert_notification1(type,msg);
}

function alert_notification1(type,message)
{
	
$(function(){

    var object1 = {
		'message'   :message,
		'position'  :'top right',
		'inEffect'  :'slideTop',
		'clearAll'  :true,		
		'sticky'       :true,
        'closeOnClick'  :true,
        'closeButton'   :true
	};
	
	if(type=="success"){
		var object2 = {
		'theme'   :'colorful',
		'delay'   :'4000',
		'content' :{
					   bgcolor:"#afd136",
					   bg_colorcode:'#fff',
					   message:message
					},
		};
	} else if(type=="error"){
		var object2 = {
		'theme'   :'colorful',
		'content' :{
					   bgcolor:"#E3434B",
					   bg_colorcode:'#fff',
					   message:message
					},
		};
	}else{
		var object2 = {
		'theme'   :'awesome ok',
		'content' :{					   
                        message:message,
                        info:'',
                        icon:'fa fa-check-square-o'
					},
		};
	}
	$.extend( object1, object2 );
	$.amaran( object1 );
  });
  
}
</script>