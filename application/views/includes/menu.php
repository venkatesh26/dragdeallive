<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="<?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/dashboard', '<i class="icon-dashboard"></i><span>Dashboard</span>'); ?> </li>
		<?php if(sub_admin_menu_check('webusers')) { ?>
		<li class="<?php echo ($this->uri->segment(2) == 'users') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/users', '<i class="icon-user"></i><span>Users</span>'); ?></li><?php } 
		if(sub_admin_menu_check('webusers')) { ?>
		<li class="<?php echo ($this->uri->segment(2) == 'advertisments') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/advertisments', '<i class="icon-home"></i><span>Advertisment</span>'); ?></li><?php } 
        if(sub_admin_menu_check('pages')) { ?>
		<?php } $masters=$this->config->item('master_menus'); ?>
        <li id="whoimg" class="dropdown<?php if(in_array($this->uri->segment(2),array_keys($masters))) { echo ' active'; } ?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-briefcase"></i><span>Masters</span> <b class="caret"></b></a>
          <ul class="dropdown-menu" id="nav_menu">
			<?php foreach($masters as $maskey=>$masval) {
					if(sub_admin_menu_check($maskey)) { 
			?>
				<li class="<?php echo ($this->uri->segment(2) == $maskey) ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/'.$maskey, $masval); ?></li>
			<?php }	} ?>
		  </ul>
        </li>
		<?php $reports=array('user_logins'); 
		if(sub_admin_menu_check('user_logins')) { ?>
		<li id="whoreport" class="dropdown<?php if(in_array($this->uri->segment(2),$reports)) { echo ' active'; } ?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-list-alt"></i><span>Reports</span> <b class="caret"></b></a>
          <ul class="dropdown-menu" id="nav_menus">		 
			<li class="<?php echo ($this->uri->segment(2) == 'user_logins') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/user_logins', 'User Logins'); ?></li>
			 <li class="<?php echo ($this->uri->segment(2) == 'comments') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/comments', 'Comments'); ?></li>
			  <li class="<?php echo ($this->uri->segment(2) == 'claim_my_bussiness') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/claim_my_bussiness', 'Bussiness Claims'); ?></li>
			  <li class="<?php echo ($this->uri->segment(2) == 'plan_clicks') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/plan_clicks', 'Plan Clicks'); ?></li> 
			  <li class="<?php echo ($this->uri->segment(2) == 'plan_orders') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/plan_orders', 'Plan Orders'); ?></li>
			  <li class="<?php echo ($this->uri->segment(2) == 'feed_backs') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/feed_backs', 'Feed Backs'); ?></li>
			  <li class="<?php echo ($this->uri->segment(2) == 'advertisment_enquiry') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/advertisment_enquiry', 'Advertisment Enquiry'); ?></li>
			   <li class="<?php echo ($this->uri->segment(2) == 'keyword_enquiry') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/keyword_enquiry', 'Keyword Enquiry'); ?></li>
			   <li class="<?php echo ($this->uri->segment(2) == 'advertisment_customer_list') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/advertisment_customer_list', 'Advertisment Customer List'); ?></li>
			    <li class="<?php echo ($this->uri->segment(2) == 'coupons') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/coupons', 'Coupons'); ?></li>
			  <li class="<?php echo ($this->uri->segment(2) == 'sender_ids') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/sender_ids', 'Sender Ids'); ?></li>
		  </ul>
        </li>
		<?php }
        if(sub_admin_menu_check('contact_us')) { ?>
		<li class="<?php echo ($this->uri->segment(2) == 'contact_us') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/contact_us', '<i class="icon-user"></i><span>Contact Us</span>'); ?> </li>
		<?php }
		if(sub_admin_menu_check('campaigns')) { ?>
		<li id="whoreport" class="dropdown<?php if(in_array($this->uri->segment(2),$reports)) { echo ' active'; } ?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i><span>Campaigns</span> <b class="caret"></b>
		  <ul class="dropdown-menu" id="nav_menus">		 
			<li class="<?php echo ($this->uri->segment(2) == 'campaigns') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/campaigns', 'Sms Campaigns'); ?></li>
			<li class="<?php echo ($this->uri->segment(2) == 'customer_campaigns') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/customer_campaigns', 'Customer Campaigns'); ?></li>
		  </ul>
		</li>
		<?php }
		if(sub_admin_menu_check('remainders')) { ?>
		<li id="whoreport" class="dropdown<?php if(in_array($this->uri->segment(2),$reports)) { echo ' active'; } ?>"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-time"></i><span>Remainders</span> <b class="caret"></b>
		  <ul class="dropdown-menu" id="nav_menus">		 
			<li class="<?php echo ($this->uri->segment(2) == 'customer_remainders' && $this->uri->segment(3) == 'birthday')  ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/customer_remainders/birthday', 'Birthday Remainders'); ?></li>
			<li class="<?php echo ($this->uri->segment(2) == 'customer_remainders' && $this->uri->segment(3) == 'aniversery') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/customer_remainders/aniversery', 'Aniversery Remainders'); ?></li>
			<li class="<?php echo ($this->uri->segment(2) == 'customer_remainders' && $this->uri->segment(3) == 'service') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/customer_remainders/service', 'Service Remainders'); ?></li>
			<li class="<?php echo ($this->uri->segment(3) == 'customer_remainder_histroy') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/customer_remainder_histroy', 'Remainders History'); ?></li>
			<li class="<?php echo ($this->uri->segment(3) == 'reaminder_analysis') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/reaminder_analysis', 'Remainders Analysis'); ?></li>
		  </ul>
		</li>
		<?php }
		if(sub_admin_menu_check('blogs')) { ?>
		<li class="<?php echo ($this->uri->segment(2) == 'blogs') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/blogs', '<i class="icon-cog"></i><span>Blogs</span>'); ?> </li>
		<?php }
        if(sub_admin_menu_check('import_excel')) { ?>
		<li class="<?php echo ($this->uri->segment(2) == 'import_datas') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/import_datas', '<i class="icon-flag"></i><span>Import Excel</span>'); ?> </li>
		<?php }?>
		<li class="<?php echo ($this->uri->segment(2) == 'export_datas') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/export_datas', '<i class="icon-download"></i><span>Export Excel</span>'); ?> </li>
		
		<li class="<?php echo ($this->uri->segment(2) == 'jobs') ? 'active' : ''; ?>"><?php echo anchor(base_url().ADMIN.'/jobs', '<i class="icon-briefcase"></i><span>Jobs</span>'); ?> </li>
      </ul>
    </div> 
  </div> 
</div>