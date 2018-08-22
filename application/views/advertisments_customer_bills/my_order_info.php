  <?php 
	 $sms_info=getMyBillInformation($this->session->userdata('customer_id'));
?>
	<section class="section general-campaigns">
      <div class="row sameheight-container">
         <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
            <div class="card sameheight-item stats" data-exclude="xs">
               <div class="card-block">
                  <div class="title-block">
                     <h3 class="title">
                        <b> <i class="fa fa-mobile"></i> Order Info</b>	
                     </h3>
                  </div>
                  <div class="row row-sm stats-container">
                     <div class="col-xs-12 col-sm-3 stat-col">
                        <div class="stat-icon"> <i class="fa fa-shopping-cart"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['total_revenue']);?></b> </div>
                           <div class="name"> Total Bill Amount </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 25%;"></span>
                           </div>
                        </progress>
                     </div>
					   <div class="col-xs-12 col-sm-3 stat-col">
                        <div class="stat-icon"> <i class="fa fa-mobile-phone"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['current_month_revenue']);?></b></div>
                           <div class="name"> Current Month Bill Amount </div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 75%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-3  stat-col">
                        <div class="stat-icon"> <i class="fa fa-calendar-o"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['today_revenue']);?></b> </div>
                           <div class="name"> Today Bill Amount</div>
                        </div>
                        <progress class="progress stat-progress" value="100" max="100">
                           <div class="progress">
                              <span class="progress-bar" style="width: 60%;"></span>
                           </div>
                        </progress>
                     </div>
                     <div class="col-xs-12 col-sm-3 stat-col">
                        <div class="stat-icon"> <i class="fa fa-tag"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo $sms_info['total_orders'];?> </b></div>
                           <div class="name"> Total Orders </div>
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
	  </div>
	</section>