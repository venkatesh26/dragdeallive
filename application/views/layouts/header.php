<header>
	<div class="wrapper">
		<article>
			<div class="slicknav_menu"></div>
			<h1 class="logo">
			<?php 
			$sitename=admin_settings_initialize('sitename');?>
				<a href="<?php echo base_url();?>" title="<?php echo ucwords($sitename);?>"><?php echo ucwords($sitename);?></a>
			</h1>
			<?php 
			if(!$this->session->userdata('is_user_logged_in'))
			{
				$dont_show='1';
				if(isset($reg_login))
				{
				 $dont_show='0';
				}
				if($dont_show)
				{
			?>
			<ul class="header-list">
				<li>
					<a href="<?php echo base_url().'user_login';?>" title="Login" class="fancybox fancybox.ajax">Login</a>				
				</li>
				<li>
					<a href="<?php echo base_url().'register';?>" title="Register" class="register fancybox1 fancybox1.ajax">Register</a>
				</li>	
			</ul>
			<?php 
			}
			}
			else
			{
				$user_profile_info=user_profile_info($this->session->userdata('user_id'));
				if(!empty($user_profile_info['profile_image']) && !empty($user_profile_info['image_dir']) && file_exists('././'.$user_profile_info['image_dir'].$user_profile_info['profile_image']))
				{
					 $img_src = thumb(FCPATH.$user_profile_info['image_dir'].$user_profile_info['profile_image'],'25','25','my_thumb_profile');
					 $image = array('src'=>base_url().$user_profile_info['image_dir'].'my_thumb_profile/'.$img_src,'alt'=>$user_profile_info['profile_image']);				
				}
				else
				{		
					$image=array('src'=>base_url().'assets/images/profileimage.png');
				}			
				?>
			<div class="header-profile">
				<div class="header-user">
					<a href="#" title="<?php echo ucwords($user_profile_info['name']);?>">
					<?php echo img($image);?>
					<span>Welcome </span><span><?php echo ucwords($user_profile_info['name']);?></span></a>
					<ul>
						<li class="profile"><a href="<?php echo base_url().'my_profile';?>" title="Profile">My Profile</a></li>
						<li class="business"><a href="<?php echo base_url().'register-your-business';?>" title="Profile">Business Profile</a></li>
						<li class="logout"><a href="<?php echo base_url().'logout';?>" title="Logout">Logout</a></li>
					</ul>
				</div>
			</div>
			<?php }?>
		</article>
		<nav class="primary-menu">
			<ul>
			<?php
			$my_menus=get_menus();
			foreach($my_menus as $menu)
			{?>
				<li>
					<a href="<?php echo base_url().'home-search/'.url_title(strtolower($menu['name']));?>" title="<?php echo ucwords($menu['name']);?>"><?php echo ucwords($menu['name']);?></a>
				</li>
				
			<?php
			}
			?>
			</ul>
		</nav>
		
	</div>
</header>