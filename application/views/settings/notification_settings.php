<?php 
$customer_thanks_id='';
$cusomer_message='';
$enquiry_thanks_id='';
$cusomer_enquiry_message='';
$coupon_thanks_id='';
$cusomer_couppon_message='';
$is_active1='';
$is_active2='';
$is_active3='';
foreach($notification_data as $data):

	if(isset($data['type_id']) && $data['type_id']==1){
		
		$customer_thanks_id=$data['id'];	
		$cusomer_message=$data['message'];
		$is_active1=($data['is_active'] ==1) ? 'checked=checked' : '';
	}
	else if(isset($data['type_id']) && $data['type_id']==2){
		$enquiry_thanks_id=$data['id'];	
		$cusomer_enquiry_message=$data['message'];
		$is_active2=($data['is_active'] ==1) ? 'checked=checked' : '';
	}
	else if(isset($data['type_id']) && $data['type_id']==3){
		$coupon_thanks_id=$data['id'];	
		$cusomer_couppon_message=$data['message'];
		$is_active3=($data['is_active'] ==1) ? 'checked=checked' : '';
	}
endforeach;
?>
<article class="content cards-page white-bg-art" style="background:#fff">
	<div class="bread-crumb-data">
	   <?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <section class="section">
    <div class="col-xl-12">
	  
         <div class="card sameheight-item border-card-section">
            <div class="card-block">
			 
               <!-- Nav tabs -->
               <div class="card-title-block">
                  <h3 class="title">
                    <i class="fa fa-comment-o"></i> Notification Settings
                  </h3>
               </div>
               <ul class="nav nav-tabs nav-tabs-bordered" id="tabs1">
                  <li class="nav-item"> <a data-step-complete="1" rel="1" class="step1 nav-link active cursor" data-target="#step1" data-toggle="tab" aria-controls="step1" role="tab"><i class="fa fa-info-circle"></i> Customer Thanks Sms</a> </li>
				   <li class="nav-item"> <a data-step-complete="2" rel="2" class="step1 nav-link cursor" data-target="#step2" data-toggle="tab" aria-controls="step2" role="tab"><i class="fa fa-info-circle"></i> Enquiry SMS </a> </li>
				    <li class="nav-item"> <a data-step-complete="3" rel="3" class="step1 nav-link cursor" data-target="#step3" data-toggle="tab" aria-controls="step3" role="tab"><i class="fa fa-info-circle"></i> Coupons SMS</a> </li>
               </ul>
               <!-- Tab panes -->
				   <div class="tab-content tabs-bordered">
				     <!------- Basic Informations --------->
						<div id="step1" class="tab-pane in fade active clearfix">
					        <form id="customer_notification_form_url" class="customer_notification_form_url" action="<?php echo base_url().'settings/notification_settings';?>" method="Post">
								<div class="form-group col-md-12">
								<input type="hidden" name="type_id" value="1">
								<input type="hidden" name="id" value="<?php echo $customer_thanks_id;?>">
								<label class="control-label1" for="thanks_message">Message <span style="color:red;">*</span>
										<i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Customer Notification Message</span> </i>  </label>
									   <textarea name="message" cols="10" rows="5"  id="thanks_message" class="form-control message-counts" data-field="thanks_sms_character_count"><?php echo $cusomer_message;?></textarea>
										<div class="icon-section pull-right" style="margin-top:5px">
											<a href="javascript:void(0);" class="hastags cursor" data-field="thanks_message" rel="##SHOPURL##"><i class="fa fa-globe"></i>&nbsp;<b>##SHOPURL##</b></a>&nbsp;&nbsp;&nbsp;
											<a href="javascript:void(0);"  class="hastags cursor" data-field="thanks_message" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
											<a href="javascript:void(0);"  class="hastags cursor" data-field="thanks_message" rel="##SHOPNAME##"><i class="fa fa-bank"></i>&nbsp;<b>##SHOPNAME##</b></a> &nbsp;&nbsp;&nbsp;
											<label class="pull-right clearfix square-box-label" style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="thanks_sms_character_count" class="square-box"> 0 </span></b></label>
										</div>
								</div>
								<div class="form-group col-md-12">
									<label class="control-label" for="is_active">
									<input type="checkbox" name="is_active" id="is_active" data-no-uniform="true" class="checkbox" <?php echo $is_active1?>><span>I want to activate this sms notification.</span></label>
								</div>
								<div class="box-content clearfix">
									<i class="fa fa-info-circle green-font-icon" style="font-size:14px;"></i><label style="font-size:14px;color:#4f5f6f;">&nbsp;&nbsp;Used to send thanks notification to customer.</label>
									<button class="btn btn-primary btn-md pull-right">Save Settings</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
							</form>
						</div>
						
						
							<div id="step2" class="tab-pane in fade clearfix">
								<form id="enquiry_notification_form_url" class="customer_notification_form_url" action="<?php echo base_url().'settings/notification_settings';?>" method="Post">
									<div class="form-group col-md-12">
									<input type="hidden" name="type_id" value="2">
									<input type="hidden" name="id" value="<?php echo $enquiry_thanks_id;?>">
									<label class="control-label1" for="enquiry_thanks_message">Message <span style="color:red;">*</span>
											<i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Enquiry Notification Message</span> </i>  </label>
										   <textarea name="message" cols="10" rows="5"  id="enquiry_thanks_message" data-field="enq_sms_character_count" class="form-control message-counts"><?php echo $cusomer_enquiry_message;?></textarea>
											<div class="icon-section pull-right" style="margin-top:5px">
												<a href="javascript:void(0);" class="hastags cursor" data-field="enquiry_thanks_message" rel="##SHOPURL##"><i class="fa fa-globe"></i>&nbsp;<b>##SHOPURL##</b></a>&nbsp;&nbsp;&nbsp;
												<a href="javascript:void(0);"  class="hastags cursor" data-field="enquiry_thanks_message" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
												<a href="javascript:void(0);"  class="hastags cursor" data-field="enquiry_thanks_message" rel="##SHOPNAME##"><i class="fa fa-bank"></i>&nbsp;<b>##SHOPNAME##</b></a> &nbsp;&nbsp;&nbsp;
												<label class="pull-right clearfix square-box-label" style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="enq_sms_character_count" class="square-box"> 0 </span></b></label>
											</div>
									</div>
									<div class="form-group col-md-12">
										<label class="control-label" for="is_active1">
										<input type="checkbox" name="is_active" id="is_active1" data-no-uniform="true" class="checkbox" <?php echo $is_active1?>><span>I want to activate this sms notification.</span></label>
									</div>
									<div class="box-content clearfix">
										<i class="fa fa-info-circle green-font-icon" style="font-size:14px;"></i><label style="font-size:14px;color:#4f5f6f;">&nbsp;&nbsp;Used to send enquiry thanks notification to customer.</label>
										<button class="btn btn-primary btn-md pull-right">Save Settings</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</div>
								</form>
							</div>
						
						
						<div id="step3" class="tab-pane in fade clearfix">
						<form id="coupon_notification_form_url" class="customer_notification_form_url" action="<?php echo base_url().'settings/notification_settings';?>" method="Post">
							<div class="form-group col-md-12">
							<input type="hidden" name="type_id" value="3">
							<input type="hidden" name="id" value="<?php echo $coupon_thanks_id;?>">
							<label class="control-label1" for="coupon_message">Message <span style="color:red;">*</span>
									<i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Coupon Message</span> </i>  </label>
										<textarea name="message" cols="10" rows="5"  id="coupon_message" data-field="coupon_sms_character_count" class="form-control message-counts"><?php echo $cusomer_couppon_message;?></textarea>
										<div class="icon-section pull-right" style="margin-top:5px">
											<a href="javascript:void(0);" class="hastags cursor" data-field="coupon_message" rel="##SHOPURL##"><i class="fa fa-globe"></i>&nbsp;<b>##SHOPURL##</b></a>&nbsp;&nbsp;&nbsp;
											<a href="javascript:void(0);" class="hastags cursor" data-field="coupon_message" rel="##SHOPNAME##"><i class="fa fa-globe"></i>&nbsp;<b>##SHOPNAME##</b></a>&nbsp;&nbsp;&nbsp;
											<a href="javascript:void(0);"  class="hastags cursor" data-field="coupon_message" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
											<label class="pull-right clearfix square-box-label"data-field="coupon_message"  style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="coupon_sms_character_count" class="square-box"> 0 </span></b></label>
										</div>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="is_active3">
								<input type="checkbox" name="is_active" id="is_active3" data-no-uniform="true" class="checkbox" <?php echo $is_active1?>><span>I want to activate this sms notification.</span></label>
							</div>
							<div class="box-content clearfix">
										<i class="fa fa-info-circle green-font-icon" style="font-size:14px;"></i><label style="font-size:14px;color:#4f5f6f;">&nbsp;&nbsp;Used to send Coupon thanks notification to customer.</label>
										<button class="btn btn-primary btn-md pull-right">Save Settings</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</div>
							</form>
						</div>
					
					
				   </div>
               </div>
            <!-- /.card-block -->
         </div>
	</div>
   </section>
</article>
<script>
$(document).ready(function(){
		
	$('.customer_notification_form_url').livequery('submit',function(){
		var formnID=$(this).attr('id');
		var url=$("#"+formnID).attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#"+formnID).serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				
				if(data.status=="error") {
					$("#"+formnID+" textarea").each(function() {
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
						$("#"+formnID+" textarea").each(function() {
							$(this).next('span.login-error').remove();
					    });
						
						if(typeof data.errorfields!='undefined' && data.errorfields.length > 0)
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
							$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please complete the required fields.');
					}
				}
				else {
					$("#"+formnID+" textarea").each(function() {
							$(this).next('span.login-error').remove();
					});
				   alert_notification('success',data.msg);
				}				
			}
		});
		return false;
	});
	
	$('.message-counts').on('keyup',function(){
		sms_counts($(this).attr('id'),$(this).data('field'));
	});
	
	$('.message-counts').trigger('keyup');
	
	$('.hastags').on('click',function(){
   		var filter_val=$(this).attr('rel');
		var field=$(this).data('field');
   		insertAtCaret(field, filter_val);
   		return false;
   	});
   
   	function insertAtCaret(areaId, text) {
   		var txtarea = document.getElementById(areaId);
   		if (!txtarea) { return; }
   
   		var scrollPos = txtarea.scrollTop;
   		var strPos = 0;
   		var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
   			"ff" : (document.selection ? "ie" : false ) );
   		if (br == "ie") {
   			txtarea.focus();
   			var range = document.selection.createRange();
   			range.moveStart ('character', -txtarea.value.length);
   			strPos = range.text.length;
   		} else if (br == "ff") {
   			strPos = txtarea.selectionStart;
   		}
   
   		var front = (txtarea.value).substring(0, strPos);
   		var back = (txtarea.value).substring(strPos, txtarea.value.length);
   		txtarea.value = front + text + back;
   		strPos = strPos + text.length;
   		if (br == "ie") {
   			txtarea.focus();
   			var ieRange = document.selection.createRange();
   			ieRange.moveStart ('character', -txtarea.value.length);
   			ieRange.moveStart ('character', strPos);
   			ieRange.moveEnd ('character', 0);
   			ieRange.select();
   		} else if (br == "ff") {
   			txtarea.selectionStart = strPos;
   			txtarea.selectionEnd = strPos;
   			txtarea.focus();
   		}
   
   		txtarea.scrollTop = scrollPos;
   	}
});

function sms_counts(id, field) {	
	$("#"+field).text($("#"+id).val().length);
	var no_of_sms=(Math.ceil($("#"+id).val().length/160));
}   
</script>