<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url().'assets/themes/images/new_logo.png';?>">
	<?php $this->load->view('meta-keywords');?>
    <!-- The styles -->
    <?php $this->load->view('elements/customer_css'); ?>
    <!-- jQuery -->
    <script src="<?php echo base_url().'assets/customer';?>/bower_components/jquery/jquery.min.js"></script>
    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">
	<script>
var cfg = {"cfg":{"path_absolute":"<?php echo base_url(); ?>"}};
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
					   bgcolor:"#2962ff",
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
<?php $this->load->view('elements/topbar'); ?>
<div class="ch-container">
<div class="row">
<?php $this->load->view('elements/sidebar'); ?>
<div id="content" class="col-lg-10 col-sm-10">
 <!-- content starts -->
<?php $this->load->view('elements/breadcrumb');
$addId=get_my_addId($this->session->userdata('user_id'));
$businnesInformation=getBusinessInforamtion($addId,$this->session->userdata('user_id'));
$dashboardData=get_customer_dashboard_data($addId);
$couponsData=my_total_coupons($this->session->userdata('user_id'));
$total_view_mess="No Views yet.";
if($businnesInformation['total_view_count']['total_view_count'] > 0){
$total_view_mess="Total no. of times  your profile viewed - ".$businnesInformation['total_view_count']['total_view_count'];
}
$today_view_mess="No Views yet.";
if($businnesInformation['today_view_count']['today_view_count'] > 0){
$today_view_mess="Total no. of times  your profile viewed today - ".$businnesInformation['today_view_count']['today_view_count'];
}


$plan_till_mess="No Plan Choosed";
if(isset($dashboardData['expiry_date']) && $dashboardData['expiry_date']!='' && $dashboardData['expiry_date']!='0000-00-00'){
$plan_till_mess="Your Profile is Activated till - ".$dashboardData['expiry_date'];
}

$coupon_mess="No Coupons Activated";
if(isset($couponsData['total_active_coupons']['total_active_coupons']) && $couponsData['total_active_coupons']['total_active_coupons'] > 0 ){
$coupon_mess="No.of Coupons Activated - ".$couponsData['total_active_coupons']['total_active_coupons'];
}

$plan_s_mess="Your Profile is Not Activated Yet";
if(isset($dashboardData['status']) && $dashboardData['status']==1){
$plan_s_mess="Your Profile is Activated";
}
$plan_mess="No Plan Choosed";
if(isset($dashboardData['plan_name'])){
$plan_mess="Now your in ".$dashboardData['plan_name']." Plan";
}
?>
<br/>
<div class=" row">
    <div class="col-md-2 col-sm-2 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $total_view_mess;?>" class="well top-block" href="#">
            <i class="glyphicon glyphicon-thumbs-up color-theme-2"></i>
            <div class="dash-label">Total Views</div>
            <div class="dash-label"><?php echo $businnesInformation['total_view_count']['total_view_count'];?></div>
        </a>
    </div>
	<div class="col-md-2 col-sm-2 col-xs-6">
        <a data-toggle="tooltip"  title="<?php echo $today_view_mess;?>" class="well top-block" href="#">
            <i class="glyphicon glyphicon-calendar color-theme-2"></i>
            <div class="dash-label">Today Views</div>
            <div class="dash-label"><?php echo $businnesInformation['today_view_count']['today_view_count'];?></div>
        </a>
    </div>
    <div class="col-md-2 col-sm-2 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="#" title="<?php echo $coupon_mess;?>">
            <i class="glyphicon glyphicon-user color-theme-2"></i>
            <div class="dash-label">Total Coupons</div>
            <div class="dash-label"><?php echo $couponsData['total_active_coupons']['total_active_coupons'];?></div>
        </a>
    </div>

	
	<div class="col-md-2 col-sm-2 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="#"  title="<?php echo $plan_till_mess;?> ">
            <i class="glyphicon glyphicon-calendar color-theme-2"></i>
            <div class="dash-label">Exipry  Date  </div>
            <div class="dash-label">
			
			<?php 
			if(isset($dashboardData['expiry_date']) && $dashboardData['expiry_date']!='' && $dashboardData['expiry_date']!='0000-00-00' && isset($dashboardData['plan_name']) && $dashboardData['plan_name']=='Life Time' || $dashboardData['plan_name']=='life time'){
			
				echo "No Expiry Date";	
			}else{
				echo (isset($dashboardData['expiry_date']) && $dashboardData['expiry_date']!='' && $dashboardData['expiry_date']!='0000-00-00') ? $dashboardData['expiry_date'] : '-'; 
			}
			?></div>
        </a>
    </div>
	
	<div class="col-md-2 col-sm-2 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="#" title="<?php echo $plan_s_mess;?> .">
            <i class="glyphicon glyphicon-briefcase color-theme-2"></i>
            <div class="dash-label">Status</div>
            <div class="dash-label"><?php echo (isset($dashboardData['status']) && $dashboardData['status']==1) ? ' Active ':' InActive '; ?></div>
        </a>
    </div>
	
	<div class="col-md-2 col-sm-2 col-xs-6">
        <a data-toggle="tooltip" class="well top-block" href="#" title=" <?php echo $plan_mess;?> .">
            <i class="glyphicon glyphicon-tags color-theme-2"></i>
            <div class="dash-label">My Plan</div>
            <div class="dash-label"><?php echo (isset($dashboardData['plan_name'])) ? $dashboardData['plan_name']:'Free'; ?></div>
        </a>
    </div>
</div>
<?php echo $main_content;?>
<!-- content ends -->
    </div><!--/#content.col-md-0-->
	
</div><!--/fluid-row-->
                <br>
                <br>
                <br>
                <br>
    <footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="<?php echo base_url();?>" target="_blank">Dialbe</a></p>
    </footer>
</div>
<?php $this->load->view('elements/customer_js'); ?>
</body>
</html>
