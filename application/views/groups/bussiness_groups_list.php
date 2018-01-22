
<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
	    <?php echo $this->load->view('elements/profile_complete_alert',array(),true);?>  
  <div class="white-bg">
   <div class="title-search-block">

      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                 <i class="fa fa-group"></i> My Groups
               </h3>
			   <a data-toggle="modal" data-target="#confirm-modal" class="btn btn-primary btn-sm rounded-s pull-right">
						<i class="fa fa-plus-circle"></i> Add New
				</a>
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
               <div class="item-col item-cl-header item-col-title cust-item-col-title">
                  <div> <span><i class="fa fa-list-alt"></i> Name</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title">
                  <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"></i> Status</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Created Date</span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
         </li>
		 <ul class="item-list js-response striped">
		 
		 </ul>
      </ul>
   </div>
   <nav class="text-xs-right js-pagenation">
   </nav>
</div>
</article>
<script>
   var url="<?php echo base_url();?>"+'groups/group_list';
   var editurl="<?php echo base_url();?>"+'groups/edit_group/';
   function getallGroupsList(url){
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
   $(document).ready(function(){
		getallGroupsList(url);
		$('.page-item a').livequery('click',function(){
			getallGroupsList($(this).attr('href'));
			return false;
		});
		
		$('.edit-group').livequery('click',function(){
			$('.edit_name').val($(this).data('name'));
			if($(this).data('status')==1){
				 $("#edit_checkbox").prop('checked');
			}
			$('.js-group-edit').attr('action',editurl+$(this).data('id'));
		});
		
		$('#group_edit_form_url').livequery('submit',function(){
		var form_url=$("#group_edit_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: form_url,
			data:$("#group_edit_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#group_edit_form_url input").each(function() {
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
						$("#group_edit_form_url input").each(function() {
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
					$("#group_edit_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$('#message').val('');
					  $('#edit-modal').modal('toggle');
			
					alert_notification('success',data.msg);
					getallGroupsList(url);
				}				
			}
		});
		return false;	
		});	
		
		$('#group_form_url').livequery('submit',function(){
		var form_url=$("#group_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: form_url,
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
						$("#group_form_url input").each(function() {
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
					$("#group_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$('#message').val('');
					  $('#confirm-modal').modal('toggle');
			
					alert_notification('success',data.msg);
					getallGroupsList(url);
				}				
			}
		});
		return false;
	});
   });
</script>
<div class="modal fade groupmodel-popup" id="confirm-modal">
    <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-group"></i> Add Group</h4> 
			</div>
			<form id="group_form_url" class="js-customer-edit" action="<?php echo base_url().'groups/add_group';?>">
				<div class="modal-body" style="height:120px;">
					<div class="control-group"> 
							<div class="form-group col-md-4">
								<label class="control-label">Name <span class="required">*</span> </label>
								<input type="text" name="name" class="form-control" id="name">
							</div>
							<div class="form-group col-md-4 groupmodal-checkbox">	
									<input class="checkbox" name="is_active" id="is_active"  type="checkbox">
									<span><label for="is_active" style="cursor:pointer;">Make As Active</label></span>
							</div>
					</div>			
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
				</div>
			</form>
		</div>
    </div>
</div>

<div class="modal fade groupmodel-popup" id="edit-modal">
    <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-group"></i> Edit Group</h4> 
			</div>
			<form id="group_edit_form_url" class="js-group-edit" action="">
				<div class="modal-body" style="height:120px;">
					<div class="control-group"> 
							<div class="form-group col-md-4">
								<label class="control-label">Name <span class="required">*</span> </label>
								<input type="text" name="name" class="form-control edit_name" id="name">
							</div>
							
							<div class="form-group col-md-4 groupmodal-checkbox">	
									<input class="checkbox" name="is_active" id="is_active_new"  type="checkbox">
									<span><label for="is_active_new" style="cursor:pointer;">Make As Active</label></span>
							</div>
							
					</div>			
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
				</div>
			</form>
		</div>
    </div>
</div>