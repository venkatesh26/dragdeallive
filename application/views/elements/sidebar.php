
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">
                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header"></li>
						<?php if($this->session->userdata('is_merchant')==1):?>
	
                        <li <?php if($this->uri->segment('1')=='dashboard'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>dashboard"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a>
                        </li>
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-briefcase"></i><span> Manage Business</span></a>
                            <ul class="nav nav-pills nav-stacked">						
								<li <?php if($this->uri->segment('1')=='business-profile'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>business-profile" data-placement="right" data-toggle="tooltip" title="Welcome !!! Here You can Manage Your Bussiness Profile."><i class="glyphicon glyphicon-briefcase"></i><span> Profile</span></a>
								</li>								
								
								<li <?php if($this->uri->segment('1')=='gallery'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>gallery" data-placement="right" data-toggle="tooltip" title="Manage Your Bussiness Gallery."><i class="glyphicon glyphicon-picture"></i><span> Gallery </span></a>
								</li>
								
								<li <?php if($this->uri->segment('1')=='business-enquires'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>business-enquires" data-placement="right" data-toggle="tooltip" title="Manage Your Bussiness Enquires"><i class="glyphicon glyphicon-comment"></i><span> Enquires </span></a>
								</li>
								<li <?php if($this->uri->segment('1')=='business-reviews'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>business-reviews" data-placement="right" data-toggle="tooltip" title="Manage Your Bussiness Reviews"><i class="fa fa-comment"></i><span> Reviews </span></a>
								</li>
								<li <?php if($this->uri->segment('1')=='my-orders'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>my-orders" data-placement="right" data-toggle="tooltip" title="Manage Your Bussiness History"><i class="glyphicon glyphicon-shopping-cart"></i><span> Order Histroy </span></a>
								</li>
                            </ul>
                        </li>
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-user"></i><span> Manage Customers</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo base_url();?>customer-list"><i class="glyphicon glyphicon-list"></i><span> Customers List</span></a></li>
								<li><a href="<?php echo base_url();?>import-customer"><i class="glyphicon glyphicon-plus"></i><span> Import Customers</span></a></li>
								<li><a href="<?php echo base_url();?>my-groups"><i class="fa fa-group"></i><span> Groups</span></a></li>	
                            </ul>
                        </li>
						<li><a class="ajax-link" href="sms-packages"><i class="glyphicon glyphicon-tags"></i><span> Sms Plan</span></a></li>
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-comment"></i><span> Sms Campaign</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo base_url();?>general-campaign"><i class="fa fa-comment"></i><span> General Campaign</span></a></li>
                                <li><a href="<?php echo base_url();?>offer-campaign"><i class="fa fa-tag"></i><span> Offer Campaign</span></a></li>
								<li><a href="<?php echo base_url();?>campaign-histroy"><i class="fa fa-history"></i><span> Campaign History</span></a></li>
								<li><a href="<?php echo base_url();?>sms-histroy"><i class="glyphicon glyphicon-phone"></i><span> Sms Order History</span></a></li>
                            </ul>
                        </li>
						
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-time"></i><span> Manage Remainders</span></a>
                            <ul class="nav nav-pills nav-stacked">
								<li <?php if($this->uri->segment('2')=='birthday'){ echo 'class="active"';}?>><a href="<?php echo base_url();?>remainder/birthday"><i class="glyphicon glyphicon-time"></i><span> Birthday  </span></a></li>
								<li  <?php if($this->uri->segment('2')=='aniversery'){ echo 'class="active"';}?>><a href="<?php echo base_url();?>remainder/aniversery"><i class="glyphicon glyphicon-time"></i><span> Aniversery </span></a></li>
								<li  <?php if($this->uri->segment('2')=='service'){ echo 'class="active"';}?>><a href="<?php echo base_url();?>remainder/service"><i class="glyphicon glyphicon-time"></i><span> Service </span></a></li>
								<li  <?php if($this->uri->segment('2')=='histroy'){ echo 'class="active"';}?>><a href="<?php echo base_url();?>remainders/History"><i class="glyphicon glyphicon-time"></i><span> History </span></a></li>
                            </ul>
                        </li>						
						
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-fire"></i><span> Manage Coupons</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?php echo base_url();?>coupons-list"><i class="glyphicon glyphicon-list"></i><span> Coupons List</span></a></li>
                                <li><a href="<?php echo base_url();?>coupons-add"><i class="glyphicon glyphicon-plus"></i><span> Add Coupons</span></a></li>
								<li><a href="<?php echo base_url();?>downloaded-coupons-list"><i class="glyphicon glyphicon-download"></i><span> Downloaded Coupons</span></a></li>
                            </ul>
                        </li>
						<li><a class="ajax-link" href="<?php echo base_url();?>my-stastics"><i class="glyphicon glyphicon-signal"></i><span> My Stastics</span></a>
                        </li>
						<li><a class="ajax-link" href="<?php echo base_url();?>my-feedback"><i class="glyphicon glyphicon-signal"></i><span> Reports</span></a>		</li>				
						<?php else:?>
						 <li <?php if($this->uri->segment('1')=='dashboard'){ echo 'class="active"';}?>><a class="ajax-link" href="<?php echo base_url();?>dashboard"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a>
                         </li>
						
						 <li><a class="ajax-link" href="<?php echo base_url();?>my-offers"><i class="glyphicon glyphicon-tag"></i><span> My Offers</span></a>
						</li>
						 <li><a class="ajax-link" href="<?php echo base_url();?>my-reviews"><i class="glyphicon glyphicon-tag"></i><span> My Reviews</span></a>
						 </li>
						 <li><a class="ajax-link" href="<?php echo base_url();?>my-coupons"><i class="glyphicon glyphicon-tag"></i><span> My Coupons</span></a>
                         </li>
						<?php endif;?>
						<li><a class="ajax-link" href="<?php echo base_url();?>my-notifications"><i class="glyphicon glyphicon-comment"></i><span> Notification <span style="padding:3px;color:green;border:solid 1px red;border-radius:50%;background-color:red;color:#fff;"> <?php echo notifications_count($this->session->userdata('user_id'))?><span></span></a>
                        </li>
						<li><a class="ajax-link" href="<?php echo base_url();?>my-feedback"><i class="glyphicon glyphicon-comment"></i><span> Send Feedback</span></a>
                        </li>
						<li><a class="ajax-link" href="<?php echo base_url().'logout';?>"><i class="glyphicon glyphicon-off"></i><span> Logout</span></a>
                        </li>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->