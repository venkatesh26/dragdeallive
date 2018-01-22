<?php 
$ok = "Yes";
if($ok=="Yes") {
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
	<?php 
if($this->session->flashdata('flash_message')){
	echo $this->session->flashdata('flash_message');
}
?>
      <div class="row">
        <div class="span6">
		
            <div class="widget widget-nopad">
				<div class="widget-header"> <i class="icon-list-alt"></i>
				  <h3>Customer Statistics</h3>
				</div>
				<div class="widget-content">
					<div class="widget big-stats-container">
						<div class="widget-content">
						  <h6 class="bigstats">Today Active status following few modules as given below like Total Logins(Users),Sign up Users.</h6>
						  
							<div id="big_stats" class="cf">
							
								<div class="stat" title="Today Total Signup"> <i class="icon-group"></i> <span class="value"><?php echo $today_signups; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Today Total G+ Signup"> <i class="icon-google-plus"></i> <span class="value"><?php echo $today_google_signups; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Today Total Twitter Signup"> <i class="icon-twitter"></i> <span class="value"><?php echo $today_twitter_signups; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Today Total Facebook Signup"> <i class="icon-facebook"></i> <span class="value"><?php echo $today_facebook_signups; ?></span>
								</div>
								<!-- .stat -->
							</div>
							<h6 class="bigstats">Total Active status following few modules as given below like Total Logins(Users),Sign up Users.</h6>
								<div id="big_stats" class="cf">
							
								<div class="stat" title="Today Total Logins"> <i class="icon-signin"></i> <span class="value"><?php echo $today_logins; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Total Users"> <i class="icon-bell"></i> <span class="value"><?php echo $total_users; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Total Active Users"> <i class="icon-bolt"></i> <span class="value"><?php echo $total_active_users; ?></span>
								</div>
								<!-- .stat -->
								<div class="stat" title="Total Inactive Users"> <i class="icon-exclamation"></i> <span class="value"><?php echo $total_inactive_users; ?></span>
								</div>
								<!-- .stat -->
							</div>
						</div>
					</div>
				</div>
			
			
			
			</div>
			
			   <div class="widget widget-nopad">
				<div class="widget-header"> <i class="icon-list-alt"></i>
				  <h3>Contact Statistics</h3>
				</div>
				<div class="widget-content">
					<div class="widget big-stats-container">
						<div class="widget-content">
						  <h6 class="bigstats">Contact Statistics For the the follwing module such as contact,keyword,enquiry.</h6>
							<div id="big_stats" class="cf">
							
								<div class="stat" title="Today Total Contacts"> <i class="icon-user-md"></i> <span class="value"><?php echo $today_total_contacts; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Today Total Enquiry"> <i class="icon-keyboard"></i> <span class="value"><?php echo $today_total_enquiry; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Today Bussiness Claims"> <i class="icon-lock"></i> <span class="value"><?php echo $today_total_claims; ?></span>
								</div>
								<!-- .stat -->
								
								<div class="stat" title="Today Total Keyword Enquiry"> <i class="icon-key"></i> <span class="value"><?php echo $today_total_keyword_enquiry; ?></span>
								</div>
								<!-- .stat -->
							</div>
						</div>
					</div>
				</div>
			
			
			
			</div>
		
          <div class="widget">
		  
            <div class="widget-header"> <i class="icon-cloud"></i>
              <h3>Dialbe Statistics</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
			<h6 class="bigstats">
			<small class="pull-right"><a href="javascript:void(0)" class="advanced-search-toggle<?php echo $this->uri->segment(2) ;?>">- Advance Search</a></small>
			<div class="clearfix"></div>
			<div class="advenced_search_container search-filter-home" id="" style="display:none;">
			  <label>From Date - To Date</label>
			   <?php echo form_input(array('placeholder'=>'YYYY-MM-DD','name'=>'checkin','class'=> 'span3','id'=>'checkin'),$this->input->post('checkin')); ?>
			   <?php echo form_input(array('placeholder'=>'YYYY-MM-DD','name'=>'checkin','class'=> 'span3','id'=>'checkout'),$this->input->post('checkin')); ?>
			   <select name="filter" id="filter" class="span3">
			   <option value="" selected="selected">Type</option>
			   <option value="today">Today</option>
			   <option value="yesterday">YesterDay</option>
			   <option value="last-week">Last Week</option>
			   <option value="this-month">This Month</option>
			   <option value="last-month">Last Month</option>
			   <option value="all-time">All Time</option>
			   </select>
			   <input type="submit" name="submit-advanced-search" value="S" class="advance-submit btn-primary" title="Submit">
				</div>
			</h6>
              <canvas id="bar-chart" class="chart-holder" height="250" width="538"> </canvas>
              <!-- /area-chart --> 
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
        <!-- /span6 -->
        <div class="span6">
          <div class="widget">
		  	<div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Yellow Pages Statistics</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h6 class="bigstats">Today Statistics for following few modules as given below like Total Yellowpages, Inactive Yellowpages Etc.</h6>
                <div id="big_stats" class="cf">

                    <div class="stat" title="Today Advertisements"> <i class="icon-bullhorn"></i> <span class="value"><?php echo $today_advertisements; ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat" title="Today Advertisements Active"> <i class="icon-bell"></i> <span class="value"><?php echo $today_advertisements_active; ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat" title="Today Advertisements Inactive"> <i class="icon-exclamation"></i> <span class="value"><?php echo $today_advertisements_inactive; ?></span> </div>
                    <!-- .stat --> 
                  </div>						  
				<h6 class="bigstats">Total Statistics for following few modules as given below like Total Yellowpages, Inactive Yellowpages Etc.</h6>
				<div id="big_stats" class="cf">
                    <div class="stat" title="Total Advertisements"> <i class="icon-bullhorn"></i> <span class="value"><?php echo number_format($total_advertisements); ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat" title="Total Advertisements Active"> <i class="icon-bell"></i> <span class="value"><?php echo number_format($total_advertisements_active); ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat" title="Total Advertisements Inactive"> <i class="icon-exclamation"></i> <span class="value"><?php echo number_format($total_advertisements_inactive); ?></span> </div>
                    <!-- .stat --> 
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
			
			
          </div>
          <!-- /widget -->
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Important Shortcuts</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts">
			  <?php 
				echo anchor(base_url().ADMIN.'/import_datas', '<i class="shortcut-icon icon-flag"></i><span class="shortcut-label">Import Excel</span>',array('class'=>'shortcut')); 
				echo anchor(base_url().ADMIN.'/users', '<i class="shortcut-icon icon-user"></i><span class="shortcut-label">Users</span>',array('class'=>'shortcut'));
				echo anchor(base_url().ADMIN.'/advertisments', '<i class="shortcut-icon icon-home"></i><span class="shortcut-label">Advertisments</span>',array('class'=>'shortcut'));
				echo anchor(base_url().ADMIN.'/user_logins', '<i class="shortcut-icon icon-signal"></i><span class="shortcut-label">Login History</span>',array('class'=>'shortcut'));
				echo anchor(base_url().ADMIN.'/contact_us', '<i class="shortcut-icon icon-user"></i><span class="shortcut-label">Contact Us</span>',array('class'=>'shortcut'));
				echo anchor(base_url().ADMIN.'/settings', '<i class="shortcut-icon icon-cog"></i><span class="shortcut-label">Settings</span>',array('class'=>'shortcut'));
				echo anchor(base_url().ADMIN.'/comments', '<i class="shortcut-icon icon-comments"></i><span class="shortcut-label">Comments</span>',array('class'=>'shortcut'));
				echo anchor(base_url().ADMIN.'/pages', '<i class="shortcut-icon icon-credit-card"></i><span class="shortcut-label">Pages</span>',array('class'=>'shortcut'));
			  ?>
				</div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-cloud"></i>
              <h3>Advertisments Datas</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
			<h6 class="bigstats">
			<small class="pull-right"><a href="javascript:void(0)" class="advanced-search-toggle<?php echo $this->uri->segment(2) ;?>">- Advance Search</a></small>
			<div class="clearfix"></div>
			<div class="advenced_search_container search-filter-home" id="" style="display:none;">
			  <label>From Date - To Date</label>
			   <?php echo form_input(array('placeholder'=>'YYYY-MM-DD','name'=>'checkin','class'=> 'span3','id'=>'checkin'),$this->input->post('checkin')); ?>
			   <?php echo form_input(array('placeholder'=>'YYYY-MM-DD','name'=>'checkin','class'=> 'span3','id'=>'checkout'),$this->input->post('checkin')); ?>
			   <select name="filter" id="filter" class="span3">
			   <option value="" selected="selected">Type</option>
			   <option value="today">Today</option>
			   <option value="yesterday">YesterDay</option>
			   <option value="last-week">Last Week</option>
			   <option value="this-month">This Month</option>
			   <option value="last-month">Last Month</option>
			   <option value="all-time">All Time</option>
			   </select>
			   <input type="submit" name="submit-advanced-search" value="S" class="advance-submit btn-primary" title="Submit">
				</div>
			</h6>
              <canvas id="area-chart" class="chart-holder" height="250" width="538"> </canvas>
              <!-- /area-chart --> 
            </div>
            <!-- /widget-content --> 
          </div>
		  
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<script src="assets/js/admin/excanvas.min.js"></script> 
<script src="assets/js/admin/chart.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="assets/js/admin/base.js"></script> 
<script src="assets/js/admin/jquery.datetimepicker.js"></script>
<script>  
	var lineChartData = {
		labels: ["Aug 14", "Sep 14", "Oct 14", "Nov 14", "Dec 14", "Jan 15", "Feb 15"],
		datasets: [
			{
				fillColor: "rgba(220,220,220,0.5)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				data: [65, 59, 90, 81, 56, 55, 40]
			},
			{
				fillColor: "rgba(151,187,205,0.5)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				data: [28, 48, 40, 19, 96, 27, 100]
			},
			{
				fillColor: "rgba(151,187,205,0.5)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				data: [58, 18, 20, 19, 96, 57, 500]
			}
		]

	};

    var myLine = new Chart(document.getElementById("bar-chart").getContext("2d")).Bar(lineChartData);
	var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);
    </script>
<?php } else { ?>
<div class="main">
	<div class="main-inner">
		<div class="container">
		<?php echo anchor(base_url().ADMIN, img(base_url().'assets/img/admin/under_construction.png'), array('class' => 'brand')); ?>
		</div>
	</div>
</div>
<?php } ?>
<script>
$("#checkin").datepicker({
	  dateFormat: "yy-mm-dd",
	  yearRange: '-3:+3',
      defaultDate: "+1w",
      numberOfMonths: 1,
	  maxDate: new Date(),
	  changeMonth: true,
	  changeYear: true,
      onClose: function(selectedDate) {
        $("#checkout").focus();
      }
    });
 $("#checkout").datepicker({
	  beforeShow : function(){ 
			$( this ).datepicker('option','minDate', $('#checkin').val() );
	  },
	  dateFormat: "yy-mm-dd",
	  yearRange: '-3:+3',
     maxDate: new Date(),
      defaultDate: "+1w",
      numberOfMonths: 1,
	  changeMonth: true,
	  changeYear: true,
    });
</script>