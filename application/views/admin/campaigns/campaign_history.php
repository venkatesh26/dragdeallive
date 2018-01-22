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
                  <i class="fa fa-history"></i> Campaign Histroy
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
                  <div> <span><i class="fa fa-list-alt"></i> Campaign Name</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category">
                  <div> <span><i class="fa fa-comments-o"></i> Sms Info</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category" style="padding-left:130px;">
                  <div> <span><i class="fa fa-list-alt"></i> Type</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category">
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
   var url="<?php echo base_url();?>"+'campaigns/campaign_histroy';
   function getallOrdersList(url){
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
		getallOrdersList(url);
		$('.page-item a').livequery('click',function(){
			getallOrdersList($(this).attr('href'));
			return false;
		});
		
		$('.campaign_detail').livequery('click',function(){
			$('.view_title').html($(this).data('title'));
			$('.view_date').html($(this).data('date'));
			$('.view_msg').html($(this).data('msg'));
			$('.sms_send').html($(this).data('sendsms'));
			$('.sms_rec').html($(this).data('recsms'));
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
			<h4 class="modal-title"><i class="fa fa-legal"></i> Campaign Detail</h4> </div>
			<div class="modal-body">
			<div class="row">
				<fieldset>
					<div class="control-group views1">											
							<label class="control-label" for="username">Created Date :</label>
							<div class="controls views view_date">
							</div> 
					</div>
						<div class="control-group views1">											
							<label class="control-label" for="username">Title :</label>
							<div class="controls views view_title">
							</div> 
					</div>
						<div class="control-group views1">											
							<label class="control-label" for="username">Message :</label>
							<div class="controls views view_msg">
							</div> 
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Total Sms Send : </label>
							<div class="controls views sms_send">										
							</div> 			
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Total Sms Received : </label>
							<div class="controls views sms_rec">
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