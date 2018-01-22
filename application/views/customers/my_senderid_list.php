<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-mobile"></i> Manage Sender ID
				   <a data-toggle="modal" data-target="#confirm-modal" class="btn btn-primary btn-sm rounded-s pull-right">
						<i class="fa fa-plus-circle"></i> Add New
				</a>
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
                  <div> <span><i class="fa fa-list-alt"></i> Sender ID</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"></i> Status</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Posted Date</span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
         </li>
        <ul class="item-list striped js-response">
	  
		</ul>
      </ul>
   </div>
   <nav class="text-xs-right js-pagenation">

   </nav>
</div>
</article>
<script>
   var url="<?php echo base_url();?>"+'customers/my_senderid';
   function getallSenderIdList(url){
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
   
   $(document).ready(function(){
		getallSenderIdList(url);
		$('.page-item a').livequery('click',function(){
			getallSenderIdList($(this).attr('href'));
			return false;
		});
		$('#group_form_url').livequery('submit',function(){
		var posturl=$("#group_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: posturl,
			data:$("#group_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#group_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else
					{	
						$("#feedback_form_url input").each(function() {
							$(this).next('span').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please complete the required fields.');
					}
				}
				else
				{
					$("#feedback_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$('#message').val('');
					alert_notification('success',data.msg);
					$('#confirm-modal').hide();
					getallSenderIdList(url);
				}				
			}
		});
		return false;
	});
   });
</script>
<div class="modal fade" id="confirm-modal">
    <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-mobile"></i> Add Sender ID</h4> 
			</div>
			<form id="group_form_url" class="js-customer-edit" action="<?php echo base_url().'customers/add_senderid';?>">
				<div class="modal-body" style="height:120px;">
					<div class="control-group"> 
					<label class="control-label">Sender ID * </label>
							<div class="form-group col-md-4">
								<input type="text" name="sender_id" class="form-control" required id="sender_id">
							</div>
					</div>			
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary button-close" data-dismiss="modal">Cancel</button> 
				</div>
			</form>
		</div>
    </div>
</div>