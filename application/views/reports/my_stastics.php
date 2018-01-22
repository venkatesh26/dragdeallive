
<article class="content dashboard-page">
   	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
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
                  <div class="dashboard-sales-breakdown-chart" id="dashboard-sales-breakdown-chart"></div>
				  <span class="sms_chart no_today_view" style="color: red;display:none;"> No Data Found <span></span></br></span>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card sameheight-item sales-breakdown green-border-box"  data-exclude="xs,sm,lg">
               <div class="card-header">
                  <div class="header-block">
                     <h3 class="title">
                      <i class="fa fa-thumbs-o-up green-font-icon"></i>&nbsp;    Total Views 
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
                      <i class="fa fa-rocket green-font-icon"></i>&nbsp;   Top PlatForms
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
   <div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-signal green-font-icon"></i> Latest Profile Views
               </h3>
			   <br//>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
              
               <div class="item-col item-col-header item-col-author">
                  <div> <span><i class="fa fa-globe"> </i> Country</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-flag"> </i> City</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-gift"> </i> Browser</span> </div>
               </div>
			   <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-gift"> </i> Platform</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-author">
                  <div> <span><i class="fa fa-calendar"> </i> Date</span> </div>
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
   var url="<?php echo base_url();?>"+'reports/my_stastics_data';
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