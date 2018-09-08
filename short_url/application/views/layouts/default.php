<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<?php
		/****************** Meta Keywords***************/ 
	$this->load->view('meta-keywords'); 
	
	?>

<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/pages/signin.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/pages/signin.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/sweetalert.css" rel="stylesheet" type="text/css">
</head>
<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="<?php echo base_url();?>">
				LTOS				
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="<?php echo base_url().'register';?>" class="">
							Don't have an account?
						</a>
						
					</li>
					
					<li class="">						
						<a href="<?php echo base_url();?>" class="">
							<i class="icon-chevron-left"></i>
							Back to Homepage
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->

<?php echo $main_content;?>
<script src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/signin.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.livequery.js"></script>
<script src="<?php echo base_url();?>assets/js/sweetalert.min.js"></script>
<script src="<?php echo base_url();?>assets/js/loadingoverlay.min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; <?php echo Date('Y');?> <a href="<?php echo base_url();?>">Url</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
</body>
<script>
var success_message='<?php echo $this->session->flashdata('success'); ?>';
var error_message='<?php echo $this->session->flashdata('error'); ?>';
console.log(error_message);
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
   alert_notification(type,msg);
}
</script>

</html>
