<?php
   $sms_info=getSmsInforamtion($this->session->userdata('user_id'));

   $remInfo=remHistory($this->session->userdata('user_id'));
   ?>
<article class="content dashboard-page white-bg-art">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>

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
                           <div class="name"> Total Sms Sent </div>
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
                           <div class="name"> Sms Left </div>
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
                           <div class="name"> Today Sms Sent </div>
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
                           <div class="name"> Yesterday Sms Sent </div>
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
                           <div class="name"> <?php echo Date('F');?> month sms sent </div>
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
                     <h4 class="title"> <i class="fa fa-history green-font-icon"></i> &nbsp; <b>Sms Send History</b></h4>
                  </div>

               </div>
               <div class="card-block">
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade active in" id="visits">
                        <p class="title-description">  Last 10 days Sms Send <span class="rem_sms_chart no_remainder_data" style="display:none;color:red;"> - No Data Found <span></p>
                        <div id="dashboard-downloads-chart" class="dashboard-remainder-chart"></div>
                     </div>
   
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="section">
   
   <section class="section">
      <div class="row sameheight-container">
         <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                       <i class="fa fa-calendar green-font-icon"></i>&nbsp;  Today Sent Sms - <?php echo date('M,d');?> 
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div class="dashboard-sales-breakdown-chart"  id="dashboard-rem-today-sms-send"  rel="<?php echo $remInfo['today_send_sms_count'];?>"></div>
				  <span class="sms_chart no_today_smsfound_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
		     <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box" data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-rocket green-font-icon"></i>&nbsp;   Yesterday Sent Sms
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div class="dashboard-sales-breakdown-chart1" id="dashboard-rem-yesterday-chart" rel="<?php echo $remInfo['yesterday_send_sms_count'];?>"></div>
				   <span class="sms_chart no_yesterday_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box"  data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-rocket green-font-icon"></i>&nbsp;    Current Month SMS Sent 
                     </h3>
                  </div>
               </div>
               <div class="card-block">
                  <div class="dashboard-sales-breakdown-chart1" id="dashboard-month-total-sms-send" rel="<?php echo $sms_info['remainder_month_send_sms_count'];?>"></div>
				   <span class="sms_chart no_month_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
      </div>
   </section>
   <div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-clock-o green-font-icon"></i> Remainder History
               </h3>
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
              
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-list-alt"></i> Remainder Name</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-group"></i> Customer Info</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-date">
                  <div class=""> <span><i class="fa fa-list-alt"></i> Type</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-list-alt"></i> Status</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Date</span> </div>
               </div>
            </div>
         </li>
      </ul>
	  <ul class="item-list striped js-response">
	  
	  </ul>
   </div>
   <nav class="text-xs-right js-pagenation">

   </nav>
   </div>

   </article>
<script>
   var url="<?php echo base_url();?>"+'reports/my_remainder_campaign_data';
   function getallList(url){
	$.LoadingOverlay("show");
   	$.ajax({
   		type: "POST",
   		url: url,
   		datatype:"json",
   		async:false,
   		success: function(data) {
			$.LoadingOverlay("hide");
			var data=jQuery.parseJSON(data);
			$('.js-response').html(data.main_content);
			$('.js-pagenation').html(data.pagination_link);
   		}
   	});
   }
   $(document).ready(function() {
		getallList(url);
		
		$('.page-item a').livequery('click',function(){
			getallList($(this).attr('href'));
			return false;
		});
		
		$('.order_detail').livequery('click',function(){
			$('.view_date').html($(this).data('date'));
			$('.view_payment_id').html($(this).data('paymentid'));
			$('.view_plan_name').html($(this).data('plan-name'));
			$('.view_user_info').html($(this).data('info'));
			$('.view_price').html($(this).data('price'));
			$('.view_status').html($(this).data('status'));
		});
   });
</script>
<script src="<?php echo base_url();?>assets/customer/js/bootstrap-datepicker.min.js"></script>
<script>
$('.date').datepicker({
     format: "yyyy-mm-dd"
});  
</script>