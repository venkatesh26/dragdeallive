<!DOCTYPE html>
<html lang="en">
<head>
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
<link href="<?php echo base_url();?>assets/css/sweetalert.css" rel="stylesheet" type="text/css">
<script>
var cfg = {"cfg":{"path_absolute":"<?php echo base_url();?>"}};
</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo base_url();?>">Drg.tw </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
			<?php $user_profile_info=$this->session->userdata('users');
			?>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $user_profile_info->first_name;?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url();?>my-profile">Profile</a></li>
              <li><a href="<?php echo base_url();?>logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>

<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="<?php if($this->uri->segment('1')=='dashboard'){echo "active";};?>"><a href="<?php echo base_url();?>dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
		<li class="<?php if($this->uri->segment('1')=='create-short-url'){echo "active";}?>"><a href="<?php echo base_url();?>create-short-url"><i class="icon-plus"></i><span>Create Short Urls</span> </a> </li>
        <li class="<?php if($this->uri->segment('1')=='list-short-url' || $this->uri->segment('1')=='shorturls'){ echo "active";}?>"><a href="<?php echo base_url();?>list-short-url"><i class="icon-list-alt"></i><span>Short Urls</span> </a> </li>
		<li class="<?php if($this->uri->segment('1')=='api-url'){ echo "active";}?>"><a href="<?php echo base_url();?>list-short-url"><i class="icon-cog"></i><span>Api</span> </a> </li>
        <li><a href="<?php echo base_url();?>report-short-url"><i class="icon-flag"></i><span>Reports</span> </a></li>
      </ul>
    </div>
    <!-- /container --> 
  </div>  
  <!-- /subnavbar-inner --> 
</div>
<div class="main">
<div class="min-inner">

<div class="container">
<?php echo $main_content;?>
</div>
</div>
</div>
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
</html>