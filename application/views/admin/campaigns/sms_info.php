     <?php $sms_info=getSmsInforamtion($this->session->userdata('user_id'));
	 $my_sendeids=my_sendIds($this->session->userdata('user_id'));
	 ?>
	<section class="section">
      <div class="row sameheight-container">
         <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
            <div class="card sameheight-item stats" data-exclude="xs">
               <div class="card-block">
                  <div class="title-block">
                     <h3 class="title">
                        <b> <i class="fa fa-mobile"></i>  Sms Info</b>	
						<?php if(empty($my_sendeids)){?>
							<label style="font-size:14px;float:right;"><i class="fa fa-info-circle" style="font-size:14px;color:red;"></i>  Sender ID Not Available. Please <a href="<?php echo base_url()."my-senderID";?>">click here</a> to add Sender ID.</label>
							<?php }?>
                     </h3>
                  </div>
                  <div class="row row-sm stats-container">
                     <div class="col-xs-12 col-sm-3 stat-col">
                        <div class="stat-icon"> <i class="fa fa-shopping-cart"></i> </div>
                        <div class="stat">
                           <div class="value"> <b><?php echo number_format($sms_info['total_sms_left']);?></b> </div>
                           <div class="name"> Sms Left </div>
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
                           <div class="value"> <b><?php echo number_format($sms_info['total_number_of_sms_send']);?></b></div>
                           <div class="name"> Total sms sent </div>
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
                           <div class="value"> <b><?php echo number_format($sms_info['today_send_sms_count']);?></b> </div>
                           <div class="name"> Today sms sent</div>
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
                           <div class="value"> <b><?php echo $sms_info['sms_plan_name'];?> </b></div>
                           <div class="name"> SMS Plan </div>
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
