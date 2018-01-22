
<article class="content dashboard-page general-campaigns">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  <i class="fa fa-comments-o"></i> Sms Notification Settings
               </h3>
			   
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
   </div>
  

    <section class="section">
    <div class="row sameheight-container">
         <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
            <div class="card">
               <div class="card-block">
			   			  
			   <form id="general_campaings_form_url" action="<?php echo base_url().'campaigns/general_campaigns';?>" method="post">
					<div>
					<div class="form-group col-md-12">
					  <label for="display_as_offer" class="cursor control-label"><input type="checkbox" name="display_as_offer" rel="0" id="display_as_offer" class="clearfix checkbox cursor"><span>&nbsp;Customer Thanks Notification &nbsp;&nbsp;</span></label>
						  </div>
					<label class="control-label1" for="message">Message <span style="color:red;">*</span>
					
							<i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Campaign Message</span> </i>  </label>
								<textarea name="message" cols="10" rows="5"  id="message" class="form-control"></textarea>
								<div class="icon-section pull-right" style="margin-top:5px">
									<a class="show-preview"  href="javascript:void(0)" data-toggle="modal" data-target="#confirm-modal"> <i class="fa fa-eye"></i> <b>Preview</b> </a>&nbsp;&nbsp;&nbsp;
									<a href="javascript:void(0);" class="hastags cursor" rel="##URL##"><i class="fa fa-globe"></i>&nbsp;<b>##URL##</b></a>&nbsp;&nbsp;&nbsp;
									<a href="javascript:void(0);"  class="hastags cursor" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
									<label class="pull-right clearfix square-box-label" style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="sms_character_count" class="square-box"> 0 </span></b></label>
								</div>
					</div>
									
				<div class="box-content clearfix">
					<button class="btn btn-primary btn-md pull-right">Save Settings</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>
			   </form>
			   </div>
			</div>
		</div>
	</div>
	</section>
</div>
</article>
<script src="<?php echo base_url();?>assets/customer/js/bootstrap-datepicker.min.js"></script>
<script>
$(document).ready(function(){
	
	
	$('.show-preview').hide();
	$('#senderid').livequery('change',function(){
		if($('#title').val()!='' && $('#senderid').val()!='' && $('#message').val()!=''){
			$('.show-preview').show();
		}
		else{
			$('.show-preview').hide();
		}
	});
	
	$('#from_date').livequery('focus',function(){
			   $('#from_date').datepicker({format: "yyyy-mm-dd"}); 
		});
		$('#from_date').livequery('click',function(){
            $(this).trigger('focus');
		});
		
		$('#to_date').livequery('focus',function(){
			   $('#to_date').datepicker({format: "yyyy-mm-dd"}); 
		});
		$('#to_date').livequery('click',function(){
            $(this).trigger('focus');
		});
	
	$('.show-preview,#title,#senderid,#message').livequery('keyup',function(){
		if($('#title').val()!='' && $('#senderid').val()!='' && $('#message').val()!=''){
			$('.show-preview').show();
		}
		else{
			$('.show-preview').hide();
		}
	});
	
	$('#title').keyup(function (){
		$('.preview-title').html('');
		$('.preview-title').html($('#title').val());
	});
	$('#senderid').change(function (){
		$('.preview-sender').html('');
		$('.preview-sender').html($('#senderid option:selected').text());
	});

	$('#tokenize').tokenize({ 
		datas: "campaigns/search_customers_mobile_numbers",   
		newElements:false,
		onAddToken: function(value, text, e){
			var total_customer=parseInt($('#filter_count').val()) + 1;
			$('#filter_count').val(total_customer);
			$('#filter_count_show').html(total_customer);
			sms_counts();	
		},
		onRemoveToken: function(value, text, e){
			
			if($('#filter_count').val() > 1){				
				var total_customer=parseInt($('#filter_count').val()) - 1;
				$('#filter_count').val(parseInt(total_customer));
				$('#filter_count_show').html(parseInt(total_customer));		
			}
			sms_counts();
        },
	}); 
	
	$('#general_campaings_form_url').livequery('submit',function(){
		var url=$("#general_campaings_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#general_campaings_form_url").serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				
				if(data.status=="error") {
					$("#general_campaings_form_url input").each(function() {
						$(this).next('span.login-error').remove();
					});
					$('.rate_it_error').html('');
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else if(data.sts=="custom_mess_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{	
				
						$("#general_campaings_form_url input").each(function() {
							$(this).next('span.login-error').remove();
					    });
						
						if(typeof data.errorfields!='undefined' && data.errorfields.length > 0)
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
							if(value.field=='score'){
									$('.rate_it_error').html(error);
							} else {
									$this.find("[name="+value.field+"]").after(error);
							}
						});
						
						alert_notification('error','Please complete the required fields.');
					}
					
				}
				else
				{
					$("#general_campaings_form_url textarea").each(function() {
							$(this).next('span.login-error').remove();
					});
					$('#message').val('');
					location.reload();
				}				
			}
		});
		return false;
	});	
	
});
</script>
<div class="modal fade" id="confirm-modal">
    <div class="modal-dialog" role="document" style="width: 350px;">
		<div class="modal-content">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-comments-o"></i> Preview Sms</h4> 
			</div>
			<form id="group_form_url" class="js-group-edit" action="">
				<div class="modal-body" style="height:auto;"> 
				<h5 style="font-size:16px;"><i class="fa fa-list-alt"></i> <b class="preview-title"> </b></h5>
				<h5 style="font-size:16px;"><i class="fa fa-history"></i> From : <b class="preview-sender"> </b></h5>
					<div class="control-group"> 
						<div class="form-group col-md-12">
							<div class="preview-sms" style="height:130px;overflow:scroll;">
							</div>
						</div>
					</div>					
				</div>
				<div class="modal-footer" style="clear:both;"> 
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
				</div>
			</form>
		</div>
    </div>
</div>
	