<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  <i class="fa fa-legal"></i> My Orders
               </h3>
			   <br/>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-tag"></i> Plan Name</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-list-alt"></i> Transaction ID</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title" style="padding-left:50px;">
                  <div class=""> <span><i class="fa fa-group"></i> Buyer Information</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title" style="padding-left:90px;">
                  <div> <span><i class="fa fa-money"></i> Price</span> </div>
               </div>
               <div class="item-col item-col-header item-col-author">
                  <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"></i> Status</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-calendar"></i>  Purchased Date</span> </div>
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
   var url="<?php echo base_url();?>"+'customers/my_orders';
   function getallOrdersList(url){
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
		getallOrdersList(url);
		$('.page-item a').livequery('click',function(){
			getallOrdersList($(this).attr('href'));
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