<script type="text/javascript">
var module="<?php echo $this->uri->segment(2) ;?>";
</script>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container"> 
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> 
			</a>
			<?php echo anchor(base_url().ADMIN, img(base_url().'assets/themes/images/footer_logo1.png'), array('class' => 'brand')); ?>
			<div class="nav-collapse">
				<ul class="nav pull-right">
				<?php if($this->session->userdata('is_logged_in')){ ?>
				  <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog"></i> Account <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  	<li class="<?php echo ($this->uri->segment(2) == 'settings') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/settings', '<i class="icon-wrench"></i> Settings'); ?></li>
						<li class="<?php echo ($this->uri->segment(2) == 'edit_profile') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/edit_profile', '<i class="icon-user"></i> My Profile'); ?></li>
					</ul>
				  </li>
				  <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-user"></i> <?php echo $this->session->userdata('user_names'); ?> <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  <li><?php echo anchor(base_url(),'<i class="icon-globe"></i> Visit Site',array('target'=>'_blank')); ?></li>
					  <li><?php echo anchor(base_url().ADMIN.'/logout','<i class="icon-off"></i> Logout'); ?></li>
					  
					</ul>
				  </li>
				<?php } else { ?>
					<li class="">						
						<a href="<?php echo base_url(); ?>" class="">
							<i class="icon-chevron-left"></i>
							Go Back to Site
						</a>
					</li>
				<?php } ?>
				</ul>
			</div>
			<!--/.nav-collapse --> 
		</div>
		<!-- /container --> 
	</div>
	<!-- /navbar-inner --> 
</div>
<!-- /navbar -->
