<?php
   $addId=get_my_addId($this->session->userdata('user_id'));
   $dashboardData=get_customer_dashboard_data($addId);
   $businnesInformation=getBusinessInforamtion($addId,$this->session->userdata('user_id'));
   $sms_info=getSmsInforamtion($this->session->userdata('user_id'));
   $customers_info=getCustomersInforamtion($this->session->userdata('user_id'));
   $latest_camp_list=getCampaignTrackList($this->session->userdata('user_id'));
   $latest_camp_lead_list = getCampaignLeadList($this->session->userdata('user_id'));
?>

<article class="content dashboard-page white-bg-art">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <section class="section dashboard-page-card-block">
     <div class="row">
    <div class="col-xl-12">
		    <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
				 <div class="card-header">
					  <div class="header-block">
						 <h3 class="title">
						   <i class="fa fa-bookmark green-font-icon"></i>&nbsp; Important Shortcuts
						 </h3>
					  </div>
				</div>
				<div class="widget-content">
              <div class="shortcuts">
			  <a href="<?php echo base_url();?>business-profile" class="shortcut"><i class="fa fa-briefcase"></i><br/><span class="shortcut-label">Profile</span></a>
			  
			  <a href="<?php echo base_url();?>customer-list" class="shortcut"><i class="fa fa-group"></i><br/><span class="shortcut-label">Customers</span></a>
			  
			   <a href="<?php echo base_url();?>my-plans" class="shortcut"><i class="fa fa-tag"></i><br/><span class="shortcut-label">Plans</span></a>
			  <a href="<?php echo base_url();?>general-campaign" class="shortcut"><i class="fa fa fa-comments-o"></i><br/><span class="shortcut-label">Campagin</span></a>
			  
				<a href="<?php echo base_url();?>coupons-list" class="shortcut"><i class="fa fa-tag"></i><br/><span class="shortcut-label">Coupons</span></a>
			  
			   <a href="<?php echo base_url();?>sms-credit" class="shortcut"><i class="fa fa-plus-circle"></i><br/><span class="shortcut-label">Credit</span></a>		
	
			  </div>
              <!-- /shortcuts --> 
            </div>
            </div>
		
		 </div>
   </div>
      <div class="row">
         <!-- /.col-xl-4 -->
         <div class="col-xl-3">
            <div class="card card-primary">
               <div class="card-header">
                  <div class="header-block dashbord-card-icon">
                     <p class="title" style="color:#fff"><i class="fa fa-thumbs-o-up"></i>  Total Views </p>
                  </div>
               </div>
               <div class="card-block dashbord-card-block">
                  <p><b><?php echo number_format($businnesInformation['total_view_count']['total_view_count']);?></b></p>
               </div>
               <div class="card-footer dashbord-card-footer"><i class="fa fa-info-circle"></i> Total number of times profile viewed.</div>
            </div>
         </div>
         <div class="col-xl-3">
            <div class="card card-primary">
               <div class="card-header">
                  <div class="header-block dashbord-card-icon">
                     <p class="title" style="color:#fff"><i class="fa fa-calendar"></i>  Today Views </p>
                  </div>
               </div>
               <div class="card-block dashbord-card-block">
                  <p><b><?php echo number_format($businnesInformation['today_view_count']['today_view_count']);?></b> </p>
               </div>
               <div class="card-footer dashbord-card-footer"><i class="fa fa-info-circle"></i> Total number of times profile viewed today.</div>
            </div>
         </div>
         <div class="col-xl-3">
            <div class="card card-primary">
               <div class="card-header">
                  <div class="header-block dashbord-card-icon">
                     <p class="title" style="color:#fff"><i class="fa fa-tag"></i> Current Plan </p>
                  </div>
               </div>
               <div class="card-block dashbord-card-block">
                  <p><b><?php echo $dashboardData['plan_name']; ?></b></p>
               </div>
               <div class="card-footer dashbord-card-footer"><i class="fa fa-info-circle"></i> Now you subscribed as <?php echo $dashboardData['plan_name']; ?> Plan.</div>
            </div>
         </div>
         <div class="col-xl-3">
            <div class="card card-primary">
               <div class="card-header">
                  <div class="header-block dashbord-card-icon">
                     <p class="title" style="color:#fff"><i class="fa fa-briefcase"></i>  Profile Status </p>
                  </div>
               </div>
               <div class="card-block dashbord-card-block">
                  <p><b><?php if(isset($dashboardData['status']) && $dashboardData['status']==1){ echo "Active";}else{ echo "Not Active Yet";}?></b> </p>
               </div>
               <div class="card-footer dashbord-card-footer"><i class="fa fa-info-circle"></i>
                  <?php 
                     if(isset($dashboardData['expiry_date']) && $dashboardData['expiry_date']!='' && $dashboardData['expiry_date']!='0000-00-00' && date('Y-m-d') > $dashboardData['expiry_date']){
                     	echo "Sorry Your Plan Expired";
                     }
                     else if(isset($dashboardData['expiry_date']) && $dashboardData['expiry_date']!='' && $dashboardData['expiry_date']!='0000-00-00'){
                     	echo "Your Plan Activated Till - ".$dashboardData['expiry_date'];
                     }
                     else {
                     	echo "Your have not choosed any plan.";
                     }?>
               </div>
            </div>
         </div>
      </div>
      <!-- /.row -->
   </section>
   <section class="section">
      <div class="row sameheight-container">
         <div class="col col-xs-12 col-sm-12 col-md-6 col-xl-5 stats-col">
            <div class="card sameheight-item stats" data-exclude="xs">
               <div class="card-block green-border-box">
                  <div class="title-block">
                     <h3 class="title">
                        <i class="fa fa-mobile green-font-icon"></i><b> Sms Metrics</b>	
						
			
                     </h3>
                  </div>
                  <div class="row row-sm stats-container">
                     <div class="col-xs-12 col-sm-6 stat-col">
                        <div class="stat-icon"> <i class="fa fa-mobile-phone"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['total_number_of_sms_send']);?></b></div>
                           <div class="name"> Total sms sent </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 75%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-6 stat-col">
                        <div class="stat-icon"> <i class="fa fa-shopping-cart"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['total_sms_left']);?></b> </div>
                           <div class="name"> Sms left </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 25%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-6  stat-col">
                        <div class="stat-icon"> <i class="fa fa-calendar-o"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['today_send_sms_count']);?></b> </div>
                           <div class="name"> Today sms sent </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 60%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-6  stat-col">
                        <div class="stat-icon"> <i class="fa  fa-list-alt"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['yesterday_send_sms_count']);?></b> </div>
                           <div class="name"> Yesterday sms sent </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 34%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-6  stat-col">
                        <div class="stat-icon"> <i class="fa fa-line-chart"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['month_send_sms_count']);?></b> </div>
                           <div class="name"> <?php echo Date('F');?> month sms sent</div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 100%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-6 stat-col">
                        <div class="stat-icon"> <i class="fa fa-tag"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo $sms_info['sms_plan_name'];?> </b></div>
                           <div class="name"> SMS Plan </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 15%;"></span>
                           </div>
                        </progress>
                     </div>
					 
					  <div class="col-xs-12 col-sm-6  stat-col">
                        <div class="stat-icon"> <i class="fa fa-clock-o"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['remainder_month_send_sms_count']);?></b> </div>
                           <div class="name"> <?php echo Date('F');?> Remainder Sent </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 100%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-6 stat-col">
                        <div class="stat-icon"> <i class="fa fa-clock-o"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['rem_last_month_sms_count']);?></b></div>
                           <div class="name"> <?php echo Date('F',strtotime('-1 month'));?> Remainder Sent</div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 15%;"></span>
                           </div>
                        </progress>
                     </div>
					
                  </div>				  
			   </div>
            </div>
         </div>
		  
         <div class="col col-xs-12 col-sm-12 col-md-6 col-xl-7 history-col">
            <div class="card sameheight-item green-border-box" data-exclude="xs">
               <div class="card-header card-header-sm bordered">
                  <div class="header-block">
                     <h4 class="title"> <i class="fa fa-history green-font-icon"></i> &nbsp; <b>Sms Sent History</b></h4>
                  </div>
                  <ul class="nav nav-tabs pull-right margin-top-10" role="tablist">
                     <li class="nav-item"> <a class="nav-link active" href="#visits" role="tab" data-toggle="tab"><i class="fa fa-comments-o green-font-icon"></i> &nbsp;Campaign Sms</a> </li>
					 <li class="nav-item"> <a class="nav-link" href="#downloads" role="tab" data-toggle="tab"><i class="fa fa-clock-o green-font-icon"></i> &nbsp;Remainder Sms</a> </li>
                  </ul>
               </div>
               <div class="card-block">
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade active in" id="visits">
                        <p class="title-description">  Last 10 days Sms Sent <span class="sms_chart no_sms_data" style="display:none;color:red;"> - No Data Found <span></p>
                        <div id="dashboard-visits-chart"></div>
                     </div>
                     <div role="tabpanel" class="tab-pane fade in" id="downloads">
                        <p class="title-description"> Last 10 days Sms Sent <span class="rem_sms_chart no_remainder_data" style="display:none;color:red;"> - No Data Found <span></p>
                        <div id="dashboard-downloads-chart"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="section">
   <div class="row sameheight-container">
        <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
            <div class="card sameheight-item stats green-border-box" data-exclude="xs">
               <div class="card-block">
                  <div class="title-block">
                     <h4 class="title">
                        <b> <i class="fa fa-user-md green-font-icon"></i> Customer Metrics</b>	
                     </h4>
                  </div>
					<div class="row row-sm stats-container">
						 <div class="col-xs-12 col-sm-3 stat-col">
							<div class="stat-icon"> <i class="fa fa-group"></i> </div>
							<div class="stat">
							   <div class="value"> <b><?php echo number_format($customers_info['users_count']);?></b></div>
							   <div class="name"> Total Customers </div>
							</div>
							<progress class="progress stat-progress" value="100" max="100">
							   <div class="progress">
								  <span class="progress-bar" style="width: 75%;"></span>
							   </div>
							</progress>
						 </div>
						 <div class="col-xs-12 col-sm-3 stat-col">
							<div class="stat-icon"> <i class="fa fa-line-chart"></i> </div>
							<div class="stat">
							   <div class="value"> <b><?php echo number_format($customers_info['current_month_users_count']);?></b></div>
							   <div class="name">This Month</div>
							</div>
							<progress class="progress stat-progress" value="100" max="100">
							   <div class="progress">
								  <span class="progress-bar" style="width: 75%;"></span>
							   </div>
							</progress>
						 </div>
						  <div class="col-xs-12 col-sm-3 stat-col">
							<div class="stat-icon"> <i class="fa fa-list-alt"></i> </div>
							<div class="stat">
							   <div class="value"> <b><?php echo number_format($customers_info['last_month_users_count']);?></b></div>
							   <div class="name"> Last Month </div>
							</div>
							<progress class="progress stat-progress" value="100" max="100">
							   <div class="progress">
								  <span class="progress-bar" style="width: 75%;"></span>
							   </div>
							</progress>
						 </div>
						  <div class="col-xs-12 col-sm-3 stat-col">
							<div class="stat-icon"> <i class="fa fa-group"></i> </div>
							<div class="stat">
							   <div class="value"> <b><?php echo number_format($customers_info['group_count']);?></b></div>
							   <div class="name"> Total Groups </div>
							</div>
							<progress class="progress stat-progress" value="100" max="100">
							   <div class="progress">
								  <span class="progress-bar" style="width: 75%;"></span>
							   </div>
							</progress>
						 </div>
					 </div>
				</div>
			</div>
		</div>
	</div>
	</section>
   <section class="section">
      <div class="row sameheight-container">
         <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-calendar green-font-icon"></i>&nbsp;  Today Profile Views - <?php echo date('M,d');?> 
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart">
				  </div>
					<span class="sms_chart no_today_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                       <i class="fa fa-thumbs-o-up green-font-icon"></i>&nbsp; Total Views 
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart1"></div>
				  <span class="sms_chart no_total_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-rocket green-font-icon"></i>&nbsp;  Top PlatForms
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart2"></div>
				  <span class="sms_chart no_platform_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="section">
      <div class="row sameheight-container">
         <div class="col-xl-4">
		             <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                       <i class="fa fa-comments-o green-font-icon"></i>&nbsp; Sms Info 
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div style="height:180px;" class="dashboard-sales-breakdown-chart1" id="dashboard-sms-chart" rel="<?php echo $sms_info['total_sms_left'];?>">
				   	<span class="sms_chart no_smsfound_view" style="color: red;display:none;"> No Sms Available <span></span></span>
				  </div>
				  	  
               </div>
            </div>
		 </div>
		 <div class="col-xl-8">
            <div class="card sameheight-item items green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header bordered">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-comments-o green-font-icon"></i> &nbsp; Latest Campaign Customer Visit 
					  <?php if(count($latest_camp_list) > 0): ?>- <a href="<?php echo base_url();?>campaign-stastics" class="pull-right" style="color:#85CE36 !important;text-decoration:none;font-size:15px;margin-top:2px;"> &nbsp;View All</a><?php endif;?>
                     </h3>
                  </div>
               </div>
               <ul class="item-list striped">
                  <li class="item item-list-header hidden-sm-down">
                     <div class="item-row">
                        <div class="item-col item-col-header item-col-title xs">
                           <div> <span><i class="fa fa-list-alt"></i> Campaign Name</span> </div>
                        </div>
                        <div class="item-col item-col-header item-col-title xs">
                           <div> <span><i class="fa fa-group"></i> Cutomer Info</span> </div>
                        </div>
						<div class="item-col item-col-header item-col-date xs">
                           <div> <span><i class="fa fa-calendar"></i> Visit Date</span> </div>
                        </div>
                     </div>
                  </li>
				<?php if(count($latest_camp_list) <=0){?>
						<li class="item"> 	   
						   <div class="item-row">
							   <div class="item-col item-col-category no_list_found">
								  <div class="no-overflow no_list_found">   No Campaign List Found</div>
							   </div>
						   </div>
						</li>
				<?php }?> 
				  
				  <?php foreach($latest_camp_list as $list):?>
                  <li class="item">
                     <div class="item-row">
                        <div class="item-col fixed item-col-img xs">
                           <a href="">
						   <?php
								$image=base_url().'assets/new_customer/assets/message_avatar2.png';
								if(!empty($list['profile_image']) && file_exists('./'.$list['image_dir'].$list['profile_image'])) {
								   $img_src = thumb(FCPATH.$list['image_dir'].$list['profile_image'],'30','30','profile_image_thumb');
								   $image = base_url().$list['image_dir'].'profile_image_thumb/'.$img_src;$no_image=false;
								}?>	
                              <div class="item-img xs rounded" style="background-image: url(<?php echo $image;?>)"></div>
                           </a>
                        </div>
                        <div class="item-col item-col-title no-overflow">
                           <div>
                                 <h4 class="item-title no-wrap">
                                    <?php echo substr(ucwords($list['title']),0,25).'...';?>
                                 </h4>
                           </div>
                        </div>
						<div class="item-col item-col-title no-overflow">
                           <div>
                                 <h4 class="item-title no-wrap">
                                    <i class="fa fa-user-md green-font-icon"></i> <?php echo ucwords($list['name']);?><br/>
									<i class="fa fa-mobile green-font-icon"></i> <?php echo $list['mobile_number'];?>
                                 </h4>
                
                           </div>
                        </div>
						<div class="item-col item-col-date no-overflow">
                           <div>
                                 <h4 class="item-title no-wrap">
										<?php echo date('d,M Y',strtotime($list['created']));?>
                                 </h4>
                
                           </div>
                        </div>
                     </div>
                  </li>
				  <?php endforeach;?>
               </ul>
            </div>
         </div>
		 
		
		 
		 
		 <div class="col-xl-12">
            <div class="card sameheight-item1 items green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header bordered">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-comments-o green-font-icon"></i> &nbsp; Latest Offer Campaign Leads 
					  <?php if(count($latest_camp_lead_list) > 0): ?>- <a href="<?php echo base_url();?>campaign-interset" class="pull-right" style="color:#85CE36 !important;text-decoration:none;font-size:15px;margin-top:2px;"> &nbsp;View All</a><?php endif;?>
                     </h3>
                  </div>
               </div>
               <ul class="item-list striped">
                  <li class="item item-list-header hidden-sm-down">
                     <div class="item-row">
                        <div class="item-col item-col-header item-col-title xs">
                           <div> <span><i class="fa fa-list-alt"></i> Campaign Name</span> </div>
                        </div>
                        <div class="item-col item-col-header item-col-title xs">
                           <div> <span><i class="fa fa-group"></i> Cutomer Info</span> </div>
                        </div>
						<div class="item-col item-col-header item-col-date xs">
                           <div> <span><i class="fa fa-calendar"></i> Visit Date</span> </div>
                        </div>
                     </div>
                  </li>
				<?php if(count($latest_camp_lead_list) <=0){?>
						<li class="item"> 	   
						   <div class="item-row">
							   <div class="item-col item-col-category no_list_found">
								  <div class="no-overflow no_list_found">   No Leads Found</div>
							   </div>
						   </div>
						</li>
				<?php }?> 
				  
				  <?php foreach($latest_camp_lead_list as $list):?>
                  <li class="item">
                     <div class="item-row">
                        <div class="item-col fixed item-col-img xs">
                           <a href="">
						   <?php
								$image=base_url().'assets/new_customer/assets/message_avatar2.png';
								if(!empty($list['profile_image']) && file_exists('./'.$list['image_dir'].$list['profile_image'])) {
								   $img_src = thumb(FCPATH.$list['image_dir'].$list['profile_image'],'30','30','profile_image_thumb');
								   $image = base_url().$list['image_dir'].'profile_image_thumb/'.$img_src;$no_image=false;
								}?>	
                              <div class="item-img xs rounded" style="background-image: url(<?php echo $image;?>)"></div>
                           </a>
                        </div>
                        <div class="item-col item-col-title no-overflow">
                           <div>
                                 <h4 class="item-title no-wrap">
                                    <?php echo substr(ucwords($list['title']),0,25).'...';?>
                                 </h4>
                           </div>
                        </div>
						<div class="item-col item-col-title no-overflow">
                           <div>
                                 <h4 class="item-title no-wrap">
                                    <i class="fa fa-user-md green-font-icon"></i> <?php echo ucwords($list['name']);?><br/>
									<i class="fa fa-mobile green-font-icon"></i> <?php echo $list['mobile_number'];?>
                                 </h4>
                
                           </div>
                        </div>
						<div class="item-col item-col-date no-overflow">
                           <div>
                                 <h4 class="item-title no-wrap">
										<?php echo date('d,M Y',strtotime($list['created']));?>
                                 </h4>
                
                           </div>
                        </div>
                     </div>
                  </li>
				  <?php endforeach;?>
               </ul>
            </div>
         </div>
          
		
	  </div>
   </section>
</article>
<style>

</style>