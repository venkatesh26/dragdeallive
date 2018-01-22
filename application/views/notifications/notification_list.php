<style>
.conversation-wrap{
    box-shadow: -2px 0 3px #ddd;
    padding:0;
    max-height: 400px;
    overflow: auto;
}

.conversation{
    padding:5px;
    border-bottom:1px solid #ddd;
    margin:0;

}

.message-wrap{
    box-shadow: 0 0 3px #ddd;
    padding:0;

}

.msg{
    padding:5px;
    margin:0;
}

.msg-wrap{
    padding:10px;
    max-height: 400px;
    overflow: auto;
}

.time{
    color:#bfbfbf;
}

.send-wrap{
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding:10px;
}

.send-message{
    resize: none;
}

.highlight{
    background-color: #f7f7f9;
    border: 1px solid #e1e1e8;
}

.send-message-btn{
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-left-radius: 0;

    border-bottom-right-radius: 0;
}

.msg-wrap .media-heading{
    color:#003bb3;
    font-weight: 700;
}

.msg-date{
    background: none;
    text-align: center;
    color:#aaa;
    border:none;
    box-shadow: none;
    border-bottom: 1px solid #ddd;
}                
</style>

<article class="content items-list-page">
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-clock-o"></i> Notification List
               </h3>
			   <br/>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
   <section class="section">
          <!-- /.row -->
		    <div class="container bootstrap snippet">
                        <div class="row js-response">
					
             
        
                        </div>
						</div>
                        <!-- /.row -->
                   </section>
   </div>
   <nav class="text-xs-right js-pagenation">

   </nav>
   </div>
</article>
<script>
   var url="<?php echo base_url();?>"+'notifications/my_notifications';
   function getRemainderList(url){
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