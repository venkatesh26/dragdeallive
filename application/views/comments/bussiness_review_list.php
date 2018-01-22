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
                  <i class="fa fa-comment"></i> My Profile Reviews
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
                  <div> <span><i class="fa fa-list-alt"></i> Title</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div class=""> <span><i class="fa fa-group"></i> Customer Information</span> </div>
               </div>
               <div class="item-col item-col-header item-col-author">
                  <div> <span><i class="fa fa-star"></i> Rating</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category">
                  <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"></i> Status</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date" style="padding-left:0px;">
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
   var url="<?php echo base_url();?>"+'comments/review_list';
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
   			$('.js-response').html('');
			$('.js-response').html(data.main_content);
			$('.js-pagenation').html(data.pagination_link);
   		}
   	});
   }
    function changeStatus(id,status){
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: 'comments/change_status',
			datatype:"json",
			async:true,
			data:{'id':id,'is_active':status},
			success: function(data) {
				$.LoadingOverlay("hide");
				var new_url=url;
				if(typeof $('.pagination li.active a').html()!='undefined'){
					
					new_url=new_url+'/'+$('.pagination li.active a').html();
				}
				
				getallOrdersList(new_url);
			}
		});
	}
   
   $(document).ready(function(){
		getallOrdersList(url);
		$('.page-item a').livequery('click',function(){
			getallOrdersList($(this).attr('href'));
			return false;
		});
		$('.review_detail').livequery('click',function(){
			$('.view_date').html($(this).data('date'));
			$('.view_user_info').html($(this).data('info'));
			var status='<span class="btn btn-danger btn-sm">InActive</span>';
			if($(this).data('status')==1){
               status='<span class="btn btn-primary btn-sm">Active</span>';			
			}
			$('.view_status').html(status);
			$('.view_message').html($(this).data('message'));
			$('.view_title').html($(this).data('title'));
			$('.view_rating').html($(this).data('rating'));
		});
		
		
		$('.change-button-confirm').livequery('click',function() {
			var id=$(this).data('rel');
			var status=($(this).data('status')==1) ? 0 : 1;
			changeStatus(id,status);
		});	
		
		$('.change_status').livequery('click',function(){
			$('.change-button-confirm').data('status',$(this).data('status'));
			$('.change-button-confirm').data('rel',$(this).data('rel'));
		});
   });
</script>
<div class="modal fade" id="confirm-change-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">&times;</span>
    				</button>
                                <h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4> </div>
                            <div class="modal-body">
                                <p>Are you sure want to do change Status ? </p>
                            </div>
                            <div class="modal-footer"> <button rel="" data-status="" type="button" class="btn btn-primary change-button-confirm" data-dismiss="modal">Confirm</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="review-detail-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title"><i class="fa fa-comment"></i> Review Detail</h4> </div>
			<div class="modal-body">
			<div class="row">
				<fieldset>
					<div class="control-group views1">											
							<label class="control-label" for="username">Posted Date :</label>
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
							<div class="controls views view_message">
							</div> 				
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Customer Info :</label>
							<div class="controls views view_user_info">
							</div> 				
					</div>
					<div class="control-group views1">											
							<label class="control-label" for="username">Rating :</label>
							<div class="controls views view_rating">
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