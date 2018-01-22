<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
	<?php echo $this->load->view('elements/plan_upgrade_alert',array(),true);?>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-legal"></i> Recent Coupons Downloads
               </h3>
               <p class="title-description">&nbsp;</p>
				<div class="col-md-12">
					<button class="btn btn-primary btn-sm pull-right js-download-coupons" data-href="<?php echo base_url().'coupons/ExportDownloadedCouponsCode';?>">Download</button>
				</div>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-list-alt"></i> Coupon Name</span> </div>
               </div>
               <div class="item-col item-col-header item-col-author">
                  <div> <span><i class="fa fa-tag"></i> Coupon Code</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-user"></i> Customer Name</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-mobile"></i> Contact Number</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Date</span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
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
   var url="<?php echo base_url();?>"+'coupons/downloaded_coupon_list';
   function getallCouponsList(url){
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			datatype:"json",
			async:true,
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				$('.js-response').html(data.main_content);
				$('.js-pagenation').html(data.pagination_link);
			}
		});
   }
   $(document).ready(function() {
		getallCouponsList(url);
		$('.page-item a').livequery('click',function(){
		getallCouponsList($(this).attr('href'));
		return false;
		});
		getallCouponsList();
	//	$('.js-download-coupons').hide();
		$(document).on("click",".js-download-coupons", function(e) { 
		window.location.href=$(this).data('href');
		});
	});
</script>