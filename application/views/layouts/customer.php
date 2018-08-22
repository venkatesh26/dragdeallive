<!doctype html>
<html class="no-js" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title> Drag Deal- dragdeal.com provides a excellent information services between local business and users in various cities in India. We Provide the most accurate data to users and businesses. </title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/themes/images/new_logo.png">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.min.css" media="screen"/>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/customer/css/bootstrap-timepicker.min.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/amaran.min.css" media="screen"/>
		<link rel="stylesheet" href="<?php echo base_url();?>assets/new_customer/css/vendor.css">	
		<link rel="stylesheet"  href="<?php echo base_url();?>assets/new_customer/css/app-green.css">
		<link href='<?php echo base_url().'assets/customer';?>/css/jquery.tokenize.css' rel='stylesheet'>
		<script src="<?php echo base_url();?>assets/new_customer/js/jquery.min.js"></script>    
      <script>
        var cfg = {"cfg":{"path_absolute":"<?php echo base_url(); ?>"}};	
		var is_mobile='<?php echo $this->detect->isMobile();?>';		 
      </script>	
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
         
         function alert_notification1(type,message) {
         $(function(){
         
             var object1 = {
         		'message'   :message,
         		'position'  :'top right',
         		'delay': 3000,
         		'clearAll'  :true,		
         		'sticky'       :false,
         		'inEffect': "fadeIn",
         		'outEffect': "fadeOut",
                 'closeOnClick'  :true,
                 'closeButton'   :true
         	};
         	
         	if(type=="success"){
         		var object2 = {
         		'theme'   :'colorful',
         		'delay'   :'4000',
         		'content' :{
         					   bgcolor:"#29c065",
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
   </head>
   <body>
      <div class="main-wrapper">
         <div class="app sidebar-fixed" id="app">
            <?php 
			if($this->session->userdata('user_type')==2){
				echo $this->load->view('elements/vendor_topbar',array(),true);
				echo $this->load->view('elements/vendor_sidebar',array(),true);
			}
			else{
				echo $this->load->view('elements/topbar',array(),true);
				echo $this->load->view('elements/customer_sidebar',array(),true);
			}?>
            <div class="sidebar-overlay" id="sidebar-overlay"></div>
          
            <?php echo $main_content;?>
         </div>
      </div>
	     <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
		<script src="<?php echo base_url();?>assets/new_customer/js/vendor.js"></script>
		<script src="<?php echo base_url();?>assets/new_customer/js/app.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.amaran.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.livequery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/customer/js/jquery.tokenize.js"></script>
		<script src="<?php echo base_url();?>assets/customer/js/loadingoverlay.min.js"></script>
		<script src="<?php echo base_url();?>assets/customer/js/bootstrap-timepicker.min.js"></script>


			<link href='<?php echo base_url().'assets/customer/';?>css/jquery.timepicker.min.css' rel='stylesheet'>

		<script src="<?php echo base_url();?>assets/customer/js/jquery.timepicker.min.js"></script>
			<script src="<?php echo base_url();?>assets/customer/js/jquery.businessHours.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/customer/js/common.js"></script>
   </body>
</html>