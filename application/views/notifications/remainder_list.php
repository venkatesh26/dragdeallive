<article class="content items-list-page">
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-clock-o"></i> Remainder List
               </h3>
				<div class="col-md-12">
					<a href="<?php echo base_url().'remainders/add';?>" class="btn btn-primary btn-sm rounded-s pull-right clearfix">
						<i class="fa fa-plus-circle"> </i> Add Remainder
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
                  <div> <span>Title</span> </div>
               </div>
               <div class="item-col item-col-header item-col-author">
                  <div> <span>Remainder Type</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title" style="padding-left:90px;">
                  <div class=""> <span>Period</span> </div>
               </div>
               <div class="item-col item-col-header item-col-author">
                  <div class="no-overflow"> <span>Status</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span> Date</span> </div>
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
   var url="<?php echo base_url();?>"+'remainders/remainder_list';
   function getRemainderList(url){
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
		getRemainderList(url);
		$('.page-item a').livequery('click',function(){
			getRemainderList($(this).attr('href'));
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4>Remainder Details</h4>
			</div>
			<div class="modal-body">
				<div>
				<p><b>Posted Date : </b><span class="posted_date"></span></p>
				<p><b>Title : </b><span class="customer_name"></span></p>
				<p><b>Message: </b><span class="customer_title"></span></p>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
			</div>
		</div>
	</div>
</div>	