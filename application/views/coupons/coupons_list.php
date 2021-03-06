

<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
<?php echo $this->load->view('elements/plan_upgrade_alert',array(),true);?>
<div class="white-bg overlay-section">

   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-tag"></i> Coupons List
               </h3>
               <p class="title-description">&nbsp;</p>
				<div class="col-md-12">
					<a href="<?php echo base_url().'coupons-add';?>" class="btn btn-primary btn-sm rounded-s pull-right clearfix">
						<i class="fa fa-plus-circle"> </i> Add Coupons
					</a>
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
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-arrow-circle-up"></i> Uploads</span> </div>
               </div>
			     <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-arrow-circle-down"></i> Downloads</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div class="no-overflow"> <span> <i class="fa fa-flag"></i> Status</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Expiry Date</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Posted Date</span> </div>
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
   var url="<?php echo base_url();?>"+'coupons/coupons_list';
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
   });
</script>
<div class="modal fade" id="order-detail-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title"><i class="fa fa-legal"></i> Order Detail</h4> </div>
			<div class="modal-body">
			<div class="row">
				<fieldset>
					<div class="control-group views1">											
							<label class="control-label" for="username">Purchased Date :</label>
							<div class="controls views view_date">
							</div> 
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Transaction ID :</label>
							<div class="controls views view_payment_id">										
							</div> 			
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Plan Name :</label>
							<div class="controls views view_plan_name">
							</div> 				
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Buyer Info:</label>
							<div class="controls views view_user_info">
							</div> 			
					</div> 
					
						<div class="control-group views1">											
							<label class="control-label" for="username">Price:</label>
							<div class="controls views view_price">
							</div> 				
					</div>
					
					<div class="control-group views1">											
							<label class="control-label" for="username">Status:</label>
							<div class="controls views view_status">
							</div> 			
					</div>
			   </fieldset>
				</div>
			</div>
			<div class="modal-footer"> 
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> </div>
		</div>
	  </div>
</div>
<script>
$(document).ready(function(){
	$(document).on("click",".export_excel", function(e) {
		
		window.location.href=$(this).data('href');
	});
	
	$(document).on("click",".js-activate", function(e) {
	
		var url="<?php echo base_url().'customers/updateCoupon';?>";
		var coupon_id=$(this).attr('rel');
		if($(this).hasClass('error')){
			var status=0;
		}
		else{
			var status=1;
		}
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:{'coupon_id':coupon_id,'status':status},
			datatype:"json",
			success: function(data)
			{
				var data=jQuery.parseJSON(data);
				if(data.status==1) 
				{
					if(status==1){
						$this.removeClass('error');
						$this.addClass('success');
						console.log($this.find().next('label'));
						$this.removeClass('label-danger');
						$this.addClass('label-success');
						$this.html('');
						$this.html('Active');
					}
					else{
						$this.addClass('error');
						$this.removeClass('success');
						$this.addClass('label-danger');
						$this.removeClass('label-success');
						$this.html('');
						$this.html('In Active');

					}
				}			
			}
		});
	});
});
</script>