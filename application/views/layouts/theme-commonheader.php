<link rel=icon type="image/x-icon" href="<?php echo base_url().'assets/themes/images/new_logo.png';?>">
<link rel=apple-touch-icon-precomposed sizes=76x76 href="<?php echo base_url().'assets/themes/images/new_logo.png';?>"/>
<link rel=apple-touch-icon-precomposed sizes=120x120 href="<?php echo base_url().'assets/themes/images/new_logo.png';?>"/>
<link rel=apple-touch-icon-precomposed sizes=152x152 href="<?php echo base_url().'assets/themes/images/new_logo.png';?>"/>
<link rel=apple-touch-icon-precomposed sizes=114x114 href="<?php echo base_url().'assets/themes/images/new_logo.png';?>"/>
<link rel=apple-touch-icon-precomposed sizes=144x144 href="<?php echo base_url().'assets/themes/images/new_logo.png';?>"/>

<!-------------------------- Css Load -------------------------------------->
<link rel=stylesheet  href='<?php echo base_url();?>assets/themes/css/googlefont1.css' type='text/css' media=all />
<link rel=stylesheet  href='<?php echo base_url();?>assets/themes/css/googlefont.css' type='text/css' media=all />
<link rel=stylesheet  href='<?php echo base_url();?>assets/themes/css/dialbecachepart1.css' type='text/css' media=all />
<link rel=stylesheet  href='<?php echo base_url();?>assets/themes/css/dialbecachepart2.css' type='text/css' media=all />
<link rel=stylesheet  href='<?php echo base_url();?>assets/css/amaran.min.css' type='text/css' media=all />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.min.css" media="screen"/>

<script type='text/javascript' src='<?php echo base_url().'assets/themes/js/jquery.js';?>'></script>
<script type='text/javascript' src='<?php echo base_url().'assets/themes/js/jquery-migrate.min.js';?>'></script>
<script type='text/javascript' src='<?php echo base_url().'assets/themes/js/jquery-scroll-to.min.js';?>'></script>
<script type='text/javascript' src='<?php echo base_url().'assets/js/jquery-1.11.1.min.js';?>'></script>

<script>var td_is_safari=false;var td_is_ios=false;var td_is_windows_phone=false;var ua=navigator.userAgent.toLowerCase();var td_is_android=ua.indexOf('android')>-1;if(ua.indexOf('safari')!=-1){if(ua.indexOf('chrome')>-1){}else{td_is_safari=true;}}
if(navigator.userAgent.match(/(iPhone|iPod|iPad)/i)){td_is_ios=true;}
if(navigator.userAgent.match(/Windows Phone/i)){td_is_windows_phone=true;}
if(td_is_ios||td_is_safari||td_is_windows_phone||td_is_android){if(top.location!=location){top.location.replace("<?php echo base_url();?>");}}
var tdBlocksArray=[];function tdBlock(){this.id='';this.block_type=1;this.atts='';this.td_column_number='';this.td_current_page=1;this.post_count=0;this.found_posts=0;this.max_num_pages=0;this.td_filter_value='';this.is_ajax_running=false;this.td_user_action='';this.header_color='';this.ajax_pagination_infinite_stop='';}
(function(){var htmlTag=document.getElementsByTagName("html")[0];if(navigator.userAgent.indexOf("MSIE 10.0")>-1){htmlTag.className+=' ie10';}
if(!!navigator.userAgent.match(/Trident.*rv\:11\./)){htmlTag.className+=' ie11';}
if(/(iPad|iPhone|iPod)/g.test(navigator.userAgent)){htmlTag.className+=' td-md-is-ios';}
var user_agent=navigator.userAgent.toLowerCase();if(user_agent.indexOf("android")>-1){htmlTag.className+=' td-md-is-android';}
if(-1!==navigator.userAgent.indexOf('Mac OS X')){htmlTag.className+=' td-md-is-os-x';}
if(/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())){htmlTag.className+=' td-md-is-chrome';}
if(-1!==navigator.userAgent.indexOf('Firefox')){htmlTag.className+=' td-md-is-firefox';}
if(-1!==navigator.userAgent.indexOf('Safari')&&-1===navigator.userAgent.indexOf('Chrome')){htmlTag.className+=' td-md-is-safari';}})();var tdLocalCache={};(function(){"use strict";tdLocalCache={data:{},remove:function(resource_id){delete tdLocalCache.data[resource_id];},exist:function(resource_id){return tdLocalCache.data.hasOwnProperty(resource_id)&&tdLocalCache.data[resource_id]!==null;},get:function(resource_id){return tdLocalCache.data[resource_id];},set:function(resource_id,cachedData){tdLocalCache.remove(resource_id);tdLocalCache.data[resource_id]=cachedData;}};})();var tds_login_sing_in_widget="show";var td_viewport_interval_list=[{"limitBottom":767,"sidebarWidth":228},{"limitBottom":1018,"sidebarWidth":300},{"limitBottom":1140,"sidebarWidth":324}];var td_animation_stack_effect="type0";var tds_animation_stack=true;var td_animation_stack_specific_selectors=".entry-thumb, img";
var td_animation_stack_general_selectors=".td-animation-stack img, .post img";
var tds_snap_menu="smart_snap_always";var tds_logo_on_sticky="show_header_logo";var tds_more_articles_on_post_enable="show";var tds_more_articles_on_post_time_to_wait="";var tds_more_articles_on_post_pages_distance_from_top=0;var tds_theme_color_site_wide="#4ac5db";var tds_smart_sidebar="enabled";</script>
<link rel=stylesheet id=td-theme-css href='<?php echo base_url();?>assets/themes/css/new_style.css' type='text/css' media=all />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/fonts/fonts.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/custom.css" media="screen"/>
<script>
var cfg = {"cfg":{"path_absolute":"<?php echo base_url(); ?>"}};
</script>
<script>
var success_message="<?php echo $this->session->flashdata('success'); ?>";
var error_message="<?php echo $this->session->flashdata('error'); ?>";
var info="<?php echo $this->session->flashdata('info'); ?>";
var type='';
var msg='';
if(success_message!='')
{
	type="success";
	msg="<?php echo $this->session->flashdata('success'); ?>";
}
if(error_message!='')
{
	type="error";
	msg="<?php echo $this->session->flashdata('error'); ?>";
}
if(info!='')
{
	type="info";
	msg="<?php echo $this->session->flashdata('info'); ?>";
}
if(msg!='' && type!='')
{
   alert_notification1(type,msg);
}

function alert_notification1(type,message){
	
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
					   bgcolor:"#337ab7",
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