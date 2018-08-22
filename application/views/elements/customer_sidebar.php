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
            <li class="<?php if($this->uri->segment('1')=='my-dashboard') { echo "active";}?>">
               <a href="<?php echo base_url();?>my-dashboard"> <i class="fa fa-dashboard"></i> Dashboard </a>
            </li>
  			<li class="<?php if($this->uri->segment('1')=='my-bills') { echo "active";}?>">
               <a href="<?php echo base_url();?>my-bills"> <i class="fa fa-list-alt"></i> My Bills </a>
            </li>
				<li class="<?php if($this->uri->segment('1')=='my-vendors') { echo "active";}?>">
               <a href="<?php echo base_url();?>my-vendors"> <i class="fa fa-user"></i> My Vendors </a>
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
            <li> 
			   <a href="<?php echo base_url().'logout';?>">
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