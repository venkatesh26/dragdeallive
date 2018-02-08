<aside class="sidebar">
   <div class="sidebar-container">
      <div class="sidebar-header">
         <div class="brand">
            <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div>
            Drag-Deal 
         </div>
      </div>
      <nav class="menu">
         <ul class="nav metismenu" id="sidebar-menu">
            <li class="<?php if($this->uri->segment('1')=='dashboard') { echo "active";}?>">
               <a href="<?php echo base_url();?>dashboard"> <i class="fa fa-dashboard"></i> Dashboard </a>
            </li>
            <li class="<?php if($this->uri->segment('1')=='business-profile' || $this->uri->segment('1')=='gallery' || $this->uri->segment('1')=='business-enquires' || $this->uri->segment('1')=='my-orders' || $this->uri->segment('1')=='business-reviews' || $this->uri->segment('1')=='my-plans' || $this->uri->segment('1')=='upgrade-plan') { echo "active open";}?>">
               <a href="javscript::void(0);"> <i class="fa fa-briefcase"></i> Manage Bussiness <i class="fa arrow"></i> </a>
               <ul>
				 <li <?php if($this->uri->segment('1')=='my-plans'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>my-plans"><i class="fa fa-tag"></i> Plans</a></li>
                  <li <?php if($this->uri->segment('1')=='business-profile'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>business-profile"><i class="fa fa-user"></i> Profile</a></li>
                  <li <?php if($this->uri->segment('1')=='gallery'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>gallery"><i class="fa fa-image"></i> Gallery</a></li>
                  <li <?php if($this->uri->segment('1')=='business-enquires'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>business-enquires"><i class="fa fa-comments-o"></i> Enquires</a></li>
                  <li <?php if($this->uri->segment('1')=='business-reviews'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>business-reviews"><i class="fa fa-comment"></i> Reviews</a></li>
                  <li <?php if($this->uri->segment('1')=='my-orders'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>my-orders"><i class="fa fa-legal"></i> Purchase Histroy</a></li>
				  <li <?php if($this->uri->segment('1')=='upgrade-plan'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>upgrade-plan"><i class="fa fa-arrow-up"></i> Upgrade Plan</a></li>
               </ul>
            </li>
            <li class="<?php if($this->uri->segment('1')=='import-customer' || $this->uri->segment('1')=='customer-list'  || $this->uri->segment('1')=='my-groups' || $this->uri->segment('1')=='customer-add' || $this->uri->segment('1')=='customers' ) { echo "active open";}?>">
               <a href=""> <i class="fa fa-group"></i> Manage Customers <i class="fa arrow"></i> </a>
               <ul>
			    
                  <li <?php if($this->uri->segment('1')=='customer-list'){ echo 'class="active"';}?>> <a href="<?php echo base_url().'customer-list';?>"><i class="fa fa-user-md"></i> Customers List</a></li>
				   <li <?php if($this->uri->segment('1')=='customer-add'){ echo 'class="active"';}?>> <a href="<?php echo base_url().'customer-add';?>"><i class="fa fa-plus-circle"></i> New Entry</a></li>
                  <li <?php if($this->uri->segment('1')=='import-customer'){ echo 'class="active"';}?>> <a href="<?php echo base_url().'import-customer';?>"><i class="fa fa-cloud-upload"></i> Import Customers</a></li>
                  <li <?php if($this->uri->segment('1')=='my-groups'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>my-groups"><i class="fa fa-comment"></i> Groups</a></li>
               </ul>
            </li>
            <li  class="<?php if($this->uri->segment('1')=='my-senderID' || $this->uri->segment('1')=='sms-credit' || $this->uri->segment('1')=='sms-order-histroy' || $this->uri->segment('1')=='general-campaign' || $this->uri->segment('1')=='offer-campaign' || $this->uri->segment('1')=='campaign-histroy' || $this->uri->segment('1')=='campaign-interset') { echo "active open";}?>">
               <a href=""> <i class="fa fa fa-comments-o"></i> SMS Campaign <i class="fa arrow"></i> </a>
               <ul>
                  <li <?php if($this->uri->segment('1')=='my-senderID'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>my-senderID"><i class="fa fa-mobile"></i> Manage SenderID</a></li>
				   <li <?php if($this->uri->segment('1')=='sms-credit'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>sms-credit"><i class="fa fa-money"></i> Sms credit</a></li>
                  <li <?php if($this->uri->segment('1')=='general-campaign'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>general-campaign"><i class="fa fa-user"></i> General Campaign</a></li>
                  <li <?php if($this->uri->segment('1')=='offer-campaign'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>offer-campaign"><i class="fa fa-tag"></i> Offer Campaign</a></li>
                  <li <?php if($this->uri->segment('1')=='campaign-histroy'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>campaign-histroy"><i class="fa fa-history"></i> Campaign History</a></li>
                  <li <?php if($this->uri->segment('1')=='sms-order-histroy'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>sms-order-histroy"><i class="fa fa-shopping-cart"></i> Purchase History</a></li>
				  <li <?php if($this->uri->segment('1')=='campaign-interset'){ echo 'class="active"';}?>> <a href="<?php echo base_url();?>campaign-interset"><i class="fa fa-thumbs-o-up"></i> Offer Campaign Leads</a></li>
               </ul>
            </l	i>
            <li class="<?php if($this->uri->segment('1')=='remainders') { echo "active open";}?>">
               <a href=""> <i class="fa fa-clock-o"></i> Manage Remainders <i class="fa arrow"></i> </a>
               <ul>
                  <li class="<?php if($this->uri->segment('1')=='remainders' && ($this->uri->segment('2')=='remainder_list' || $this->uri->segment('2')=='add')) { echo "active open";}?>"> <a href="<?php echo base_url();?>remainders/remainder_list"><i class="fa fa-clock-o"></i> Remainders</a></li>
				  <li class="<?php if($this->uri->segment('1')=='remainders' && ($this->uri->segment('2')=='history')) { echo "active open";}?>"> <a href="<?php echo base_url();?>remainders/history"><i class="fa fa-user"></i> History</a></li>
               </ul>
            </li>
            <li class="<?php if($this->uri->segment('1')=='coupons-list' || $this->uri->segment('1')=='coupons-add' || $this->uri->segment('1')=='downloaded-coupons-list' || $this->uri->segment('1')=='coupons_edit') { echo "active open";}?>">
               <a href=""> <i class="fa fa-tag"></i> Manage Coupons <i class="fa arrow"></i> </a>
               <ul>
					<li class="<?php if($this->uri->segment('1')=='coupons-list' || $this->uri->segment('1')=='coupons-add' || $this->uri->segment('1')=='coupons_edit') { echo "active open";}?>"><a href="<?php echo base_url();?>coupons-list"><i class="fa fa-list"></i><span> Coupons List</span></a></li>
					<li class="<?php if($this->uri->segment('1')=='downloaded-coupons-list') { echo "active open";}?>"><a href="<?php echo base_url();?>downloaded-coupons-list"><i class="fa fa-cloud-download"></i><span> Downloaded Coupons</span></a></li>
               </ul>
            </li>
            <li class="<?php if($this->uri->segment('1')=='profile-stastics' || $this->uri->segment('1')=='campaign-stastics' || $this->uri->segment('1')=='remainder-stastics' || $this->uri->segment('1')=='campaign-tracklist') { echo "active open";}?>">
               <a href=""> <i class="fa fa-signal"></i> Reports <i class="fa arrow"></i> </a>
               <ul>
                  <li class="<?php if($this->uri->segment('1')=='profile-stastics') { echo "active open";}?>"> <a href="<?php echo base_url();?>profile-stastics"><i class="fa fa-user"></i> Profile Stastics</a></li>
                  <li class="<?php if($this->uri->segment('1')=='campaign-stastics') { echo "active open";}?>"> <a  href="<?php echo base_url();?>campaign-stastics"><i class="fa fa-comments-o"></i> Sms Campaign</a></li>
                  <li class="<?php if($this->uri->segment('1')=='remainder-stastics') { echo "active open";}?>"> <a href="<?php echo base_url();?>remainder-stastics"><i class="fa fa-clock-o"></i> Remainder History</a></li>
               </ul>
            </li>
			 <li class="<?php if($this->uri->segment('1')=='my-coupons' || $this->uri->segment('1')=='my-campaign-offers') { echo "active open";}?>">
               <a href=""> <i class="fa fa-tag"></i> My Offers <i class="fa arrow"></i> </a>
               <ul>
                  <li class="<?php if($this->uri->segment('1')=='my-coupons') { echo "active open";}?>"> <a href="<?php echo base_url();?>my-coupons"><i class="fa fa-tag"></i> My Coupons</a></li>
                  <li class="<?php if($this->uri->segment('1')=='my-campaign-offers') { echo "active open";}?>"> <a  href="<?php echo base_url();?>my-campaign-offers"><i class="fa fa-comments-o"></i> My Offers</a></li>
               </ul>
            </li>
            <li class="<?php if($this->uri->segment('1')=='my-profile') { echo "active";}?>">
               <a href="<?php echo base_url();?>my-profile"> <i class="fa fa-user"></i> My Profile </a>
            </li>
            <li> <a href="<?php echo base_url().'logout';?>">
               <i class="fa fa-power-off"></i> Logout
               </a> 
            </li>
			<footer class="sidebar-footer">
				<ul class="nav metismenu" id="customize-menu1">
				</ul>
            </footer>
         </ul>
      </nav>
   </div>
</aside>