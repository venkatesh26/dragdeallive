  <div class=td-mobile-container>
            <div class=td-menu-socials-wrap>
                <div class=td-menu-socials>
                    <span class=td-social-icon-wrap>
<a target=_blank href="#" title=Facebook>
<i class="td-icon-font td-icon-facebook"></i>
</a>
</span>
                    <span class=td-social-icon-wrap>
<a target=_blank href="#" title=Twitter>
<i class="td-icon-font td-icon-twitter"></i>
</a>
</span>
                    <span class=td-social-icon-wrap>
<a target=_blank href="#" title=Vimeo>
<i class="td-icon-font td-icon-vimeo"></i>
</a>
</span>
                    <span class=td-social-icon-wrap>
<a target=_blank href="#" title=VKontakte>
<i class="td-icon-font td-icon-vk"></i>
</a>
</span>
                    <span class=td-social-icon-wrap>
<a target=_blank href="#" title=Youtube>
<i class="td-icon-font td-icon-youtube"></i>
</a>
</span> </div>
                <div class=td-mobile-close>
                    <a href="#"><i class=td-icon-close-mobile></i></a>
                </div>
            </div>
            <div class=td-menu-login-section>
                <div class=td-guest-wrap>
                    <div class=td-menu-avatar>
					<?php 
					$image= base_url().'assets/themes/images/message_avatar2.png';
					if($this->session->userdata('user_id')){
						$user_profile_info=user_profile_info($this->session->userdata('user_id'));
						if(!empty($user_profile_info['profile_image']) && file_exists('./'.$user_profile_info['image_dir'].$user_profile_info['profile_image']))
						{
							$img_src = thumb(FCPATH.$user_profile_info['image_dir'].$user_profile_info['profile_image'],'80','80','profile_thumb');
							$image = base_url().$user_profile_info['image_dir'].'profile_thumb/'.$img_src;
						}
					}
					?>
                        <div class=td-avatar-container><img src="<?php echo $image;?>" width=80 height=80 alt="" class="avatar avatar-80 wp-user-avatar wp-user-avatar-80 photo avatar-default" />
                        </div>
                    </div>
					<?php if(!$this->session->userdata('is_user_logged_in')):?>
                    <div class=td-menu-login><a id=login-link-mob>Sign in</a>
                    </div>
					<?php else:?>
					 <div class=td-menu-login><a href="<?php echo base_url().'my-profile';?>">My Profile</a>
                    </div>
					<?php endif;?>
                </div>
            </div>
            <div class=td-mobile-content>
                <div class=menu-main-menu-container>
                    <ul id=menu-main-menu class=td-mobile-main-menu>
						<?php if($this->session->userdata('is_user_logged_in')):?>
						<li id=menu-item-149 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-149"><a href="<?php echo base_url().'dashboard';?>">Dashboard</a>
                        </li>
						<li id=menu-item-149 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-149"><a href="<?php echo base_url().'my-profile';?>">My Profile</a>
                        </li>
						<?php endif;?>
						<?php if(!$this->session->userdata('is_user_logged_in')):?>
						<li id=menu-item-149 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-149"><a href="<?php echo base_url().'register';?>">Register</a>
                        </li>
						<?php endif;?>
						<li id=menu-item-145 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-145"><a href="<?php echo base_url().'search/chennai';?>">Yellow Pages</a>
                        </li>
						<li id=menu-item-146 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-146"><a href="<?php echo base_url().'blogs';?>">Blogs</a>  </li>
						
						<li id=menu-item-146 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-146"><a href="<?php echo base_url().'coupons';?>">Coupons</a>  </li>
						
                        <li id=menu-item-146 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-146"><a href="<?php echo base_url().'contact-us';?>">Contact Us</a>  </li>
                        <li id=menu-item-143 class="menu-item menu-item-type-post_type menu-item-object-page page_item page-item-139 current_page_item menu-item-first menu-item-143"><a href="<?php echo base_url().'search/chennai';?>">Chennai</a>
                        </li>
                        <li id=menu-item-148 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-148"><a href="<?php echo base_url().'search/banglore';?>">Banglore</a>
                        </li>
						<li id=menu-item-148 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-148"><a href="<?php echo base_url().'search/mumbai';?>">Mumbai</a>
                        </li>
						<?php if($this->session->userdata('is_user_logged_in')):?>
                        <li id=menu-item-149 class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-149"><a href="<?php ?>">Logout</a>
                        </li>
						<?php endif;?>
                    </ul>
                </div>
            </div>
        </div>