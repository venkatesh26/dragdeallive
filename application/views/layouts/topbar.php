   <header class="header">
                    <div class="header-block header-block-collapse hidden-lg-up"> 
					<button class="collapse-btn" id="sidebar-collapse-btn">
    			<i class="fa fa-bars"></i>
    		</button> </div>
                    <div class="header-block header-block-buttons">
					   <?php 
					   $addId=get_my_addId($this->session->userdata('user_id'));
					   $style='display:none';
					   if($addId >0):
					   $style='';
					   endif;?>
                        <a style="<?php echo $style;?>" target="_blank" href="<?php echo base_url();?>listings/preview" class="btn btn-sm rounded-s header-btn"> <i class="fa fa-eye"></i> Preview Profile </a>
						<a target="_blank" href="<?php echo base_url();?>" class="btn btn-sm rounded-s header-btn"> <i class="fa fa-globe"></i> Visit Site </a>	
                    </div>
					
					
                    <div class="header-block header-block-nav">
                        <ul class="nav-profile">
						<?php 
						$list=notifications_list($this->session->userdata('user_id'));
						if(count($list) > 0):
						?>
                            <li class="notifications new">
									<a href="" data-toggle="dropdown"> <i class="fa fa-bell-o"></i> <sup>
						  <span class="counter"><?php echo $notifications_count=notifications_count($this->session->userdata('user_id'));?></span>
						</sup> </a>
									<div class="dropdown-menu notifications-dropdown-menu">
										<ul class="notifications-container">
										<?php foreach($list as $lis):?>
											<li>
												<a href="" class="notification-item">
													<div class="img-col">
														<div class="img" style="background-image: url('assets/faces/3.jpg')"></div>
													</div>
													<div class="body-col">
														<p><i class="fa fa-info-circle"></i> <span class="accent"><?php echo $lis['title'];?></span> : <span class="accent"><?php echo $lis['message'];?></span>. </p>
													</div>
												</a>
											</li>
										<?php endforeach;?>
										</ul>
										<footer>
											<ul>
												<li> <a href="">
								View All
							  </a> </li>
											</ul>
										</footer>
									</div>
                            </li>
							<?php endif;?>
                            <li class="profile dropdown">
							<?php    
								$user_profile_info=user_profile_info($this->session->userdata('user_id'));
								$image=base_url().'assets/new_customer/assets/message_avatar2.png';
								if(!empty($user_profile_info['profile_image']) && file_exists('./'.$user_profile_info['image_dir'].$user_profile_info['profile_image'])) {
								   $img_src = thumb(FCPATH.$user_profile_info['image_dir'].$user_profile_info['profile_image'],'30','30','profile_image_thumb');
								   $image = base_url().$user_profile_info['image_dir'].'profile_image_thumb/'.$img_src;$no_image=false;
								}
							?>
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="img" style="background-image: url('<?php echo $image;?>');"> </div> 
									<span class="name">
									<?php echo $user_profile_info['name'];?> 
									</span> </a>
                                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="<?php echo base_url().'my-profile';?>"> <i class="fa fa-user icon"></i> Profile </a>
                                    <a class="dropdown-item" href="<?php echo base_url().'my-notifications';?>"> <i class="fa fa-bell icon"></i> Notifications </a>
									<a class="dropdown-item" href="<?php echo base_url().'my-notifications-settings';?>"> <i class="fa fa-cog icon"></i> Notification Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?php echo base_url().'logout';?>"> <i class="fa fa-power-off icon"></i> Logout </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>