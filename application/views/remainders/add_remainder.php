<article class="content dashboard-page general-campaigns">
   <?php echo $this->load->view('elements/plan_upgrade_alert',array(),true);?>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  <i class="fa fa-clock-o"></i> Add Remainder
               </h3>
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
   </div>

<?php echo $this->load->view('campaigns/sms_info',array(),true);?>
    <section class="section">
		<div class="row sameheight-container">
			 <div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
				<div class="card">
				   <div class="card-block">
				   <form id="birthday_campaings_form_url" action="<?php echo base_url().'remainders/add';?>" method="post">
				   	<div class="form-group col-md-4"> 
						<label class="control-label1" for="title">Name <span style="color:red;">*</span> <i  data-placement="right" data-toggle="tooltip" title="Enter Campaign Title" class="glyphicon glyphicon-question-sign" style="font-size:12px;"></i> </label>
						<input type="text" name="name" class="form-control" id="name" autocomplete="off">
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="remainder_type_id">Remainder Type <span style="color:red;">*</span> <i  data-placement="right" data-toggle="tooltip" title="Select Remainder Type" class="glyphicon glyphicon-question-sign" style="font-size:12px;"></i></label>
						<select id="remainder_type_id" name="remainder_type_id" class="common-select-box form-control">
							<option value="">Select Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
							<option value="1">Birthday</option>
							<option value="2">Aniversery</option>
							<option value="3">Service</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label" for="remainder_period_type">Remainder Period <span style="color:red;">*</span> <i  data-placement="right" data-toggle="tooltip" title="Select Remainder Period" class="glyphicon glyphicon-question-sign" style="font-size:12px;"></i></label>
						<select id="remainder_period_type" name="remainder_period_type" class="common-select-box form-control">
							<option value="">Select Period &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
						</select>
					</div>
					<div class="form-group col-md-12">
					<label class="control-label1" for="message">Message <span style="color:red;">*</span>
					
							<i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Message</span> </i>  </label>
								<textarea name="message" cols="10" rows="5"  id="message" class="form-control"></textarea>
								<div class="icon-section pull-right" style="margin-top:5px">
									<a class="show-preview"  href="javascript:void(0)" data-toggle="modal" data-target="#confirm-modal"> <i class="fa fa-eye"></i> <b>Preview</b> </a>&nbsp;&nbsp;&nbsp;
									<a href="javascript:void(0);" class="hastags cursor" rel="##URL##"><i class="fa fa-globe"></i>&nbsp;<b>##URL##</b></a>&nbsp;&nbsp;&nbsp;
									<a href="javascript:void(0);" class="hastags cursor" rel="##CODE##"><i class="fa fa-tag"></i>&nbsp;<b>##CODE##</b></a>&nbsp;&nbsp;&nbsp;
									<a href="javascript:void(0);"  class="hastags cursor" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
									<label class="pull-right clearfix square-box-label" style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="sms_character_count" class="square-box"> 0 </span></b></label>
								</div>
					</div>
					<div class="form-group col-md-12">
						<div id="no_of_days_section" class="col-md-4">
							<label class="control-label" for="no_of_days">Number of days <span style="color:red;">*</span> <i  data-placement="right" data-toggle="tooltip" title="Enter No Of Days to Send Remainder Notification" class="glyphicon glyphicon-question-sign" style="font-size:12px;"></i></label>
							<input type="number" min="0" name="no_of_days" class="form-control" id="no_of_days">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label" for="url">Tracking Url <span style="color:red;">*</span></label>
							<input type="text" name="url" class="form-control" id="url">
						</div>
						<div class="form-group col-md-4" style="margin-top:30px;">
								<label class="control-label cursor" for="is_active">
								<input type="checkbox" name="is_active" id="is_active"  data-no-uniform="true" class="checkbox" checked="checked">
								<span> Make as active </span></label>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>Select Option&nbsp;&nbsp;</label>
						<div class="filter_type_code">
							<div class="form-group col-md-6">
								<label class="cursor"> <input type="radio" name="coupon_type" rel="1" id="filter_type_code" class="clearfix cursor radio" checked="checked" value="1"> <span>Autogenerted Coupon Code  &nbsp;&nbsp;&nbsp;&nbsp;</span></label>
								<label class="cursor"> <input type="radio" name="coupon_type" rel="2" id="filter_type_code" class="clearfix cursor radio" value="2"> <span> Custom Coupon Code &nbsp;&nbsp;&nbsp;&nbsp;</span></label>
							</div>
							<div class="form-group col-md-4">
								<input type="text" maxlength="6" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code" style="display:none;" class="form-control">
							</div>
						</div>
					</div>
						<div class="form-group col-md-12 service_remainder_option">
								<div class="form-group col-md-6">
								<label class="control-label" for="is_custom_servicedate">
									<input type="checkbox" name="is_custom_servicedate" id="is_custom_servicedate"  data-no-uniform="true" class="checkbox"><span>Custom Remainder Date</span></label>
								</div>
								<div class="form-group col-md-6 date_section">
									<label class="control-label" for="custom_service_date">Custom Remainder Date</label>
									<input type="text" name="custom_service_date" class="form-control" id="custom_service_date" readonly>
								</div>
						</div>
						<div class="box-content clearfix">
						<button class="btn btn-primary btn-md pull-right">Send</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a class="btn btn-primary btn-md pull-right" href="<?php echo base_url();?>remainders/remainder_list" style="margin-right:10px;"> Cancel</a>
						</div>	
				   </form>
				   </div>
				</div>
			</div>
		</div>
	</section>
<script src="<?php echo base_url();?>assets/customer/js/bootstrap-datepicker.min.js"></script>
<script>
$(document).ready(function(){
	
	$('#message').change(function (){
	   	$('.preview-sms').html('');		
		$('.preview-sms').html($("#message").val());
	});
		
	$('.show-preview').hide();
	$('#senderid').livequery('change',function(){
		if($('#title').val()!='' && $('#message').val()!=''){
			$('.show-preview').show();
		}
		else{
			$('.show-preview').hide();
		}
	});
	
	$('.show-preview,#title,#senderid,#message').livequery('keyup',function(){
		if($('#title').val()!='' && $('#message').val()!=''){
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
	
	$('.date_section').hide();
	$('#no_of_days_section').hide();
	$('.service_remainder_option').hide();
	$('#custom_service_date').datepicker({format: "yyyy-mm-dd"}); 
	$('#message').keyup(function () {
		sms_counts();
	});
	function showDates(){
	    setTimeout(function(){
		var isactive=$('#is_custom_servicedate').val();
		if(isactive=='on'){
			$('.date_section').show();	
		}else{
			$('.date_section').hide();
		}},500);
	} 
	
	$('#birthday_campaings_form_url').livequery('submit',function(){
		var url=$("#birthday_campaings_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#birthday_campaings_form_url").serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") {
					$("#birthday_campaings_form_url input").each(function() {
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
				
						$("#birthday_campaings_form_url input").each(function() {
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
					$("#birthday_campaings_form_url textarea").each(function() {
							$(this).next('span.login-error').remove();
					});
					$('#message').val('');
					
					location.reload();
				}				
			}
		});
		return false;
	});	
	
	$('.hastags').on('click',function(){
		var filter_val=$(this).attr('rel');
		insertAtCaret('message',filter_val);
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
		
	$('#date_filter').on("change",function(){
		$('.custom_date_filter').hide();
		if($('#date_filter').val()!='') {
			if($('#date_filter').val()=='custom_range'){
				$('.custom_date_filter').show();
			}
			else {
			  $('#filter_type_date').trigger('change');
			}
		}
		else {
			return false;
		}
	});
		
	$('.filter_type_code input[type=radio]').on("change",function(){	
		var filter_type=$(this).attr('rel');	
		if(filter_type==2){
			 $('#coupon_code').show();
		} else {
			$('#coupon_code').val('');
			$('#coupon_code').hide();
		}
	});
	
	$('#name').keyup(function (){
		$('.preview-title').html('');
		$('.preview-title').html($('#name').val());
	});
	
	$('#senderid').change(function (){
		$('.preview-sender').html('');
		$('.preview-sender').html($('#senderid option:selected').text());
	});
	
	$(".filter_types input").on("change",function(){	
	    var filter_type=$(this).attr('rel');
		$('#bill_amount_section').hide();
		$('#specific_number_based_section').hide();
		$('#date_based_section').hide();
		$('#group_section').hide();
		$('#visit_count_section').hide();
		$('#filter_count_show').html(0);
		$('#filter_count').val(0);	
		$('#tokenize').tokenize().clear();
		sms_counts();
		if(filter_type==1){
			$('#bill_amount_section').show();
			if($('#bill_filter').val()==''){
				return false;
			}
			if($('#bill_filter').val()=='custom_range' && $('#bill_from').val() =='' || $('#bill_to').val() ==''){
				return false;
			}
		}
		else if(filter_type==2){
			$('#date_based_section').show();
			if($('#date_filter').val()==''){
				return false;
			}
			else if($('#date_filter').val()=='custom_range' &&  ($('#from_date').val()=='' || $('#to_date').val()=='')){
				return false;
			}
		}
		else if(filter_type==3){
			$('#visit_count_section').show();
			if($('#visit_filter').val()==''){
				return false;
			}
			if($('#visit_filter').val()=='custom_range' && ($('#visit_from').val() =='' || $('#visit_to').val() =='')){
				return false;
			}
		}
		else if(filter_type==4){
			$('#group_section').show();
			if($('#group_id').val() ==''){
				return false;
			}
		}
		else if(filter_type==5){
			$('#specific_number_based_section').show();
			return false;
		}
		var url='campaigns/get_customer_counts';
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#general_campaings_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);	
                $('#filter_count_show').html(data.total_count);	
				$('#filter_count').val(data.total_count);	
				sms_counts();
			}
		});
		return false;
	});
	
	function sms_counts() {	
		$("#sms_character_count").text($("#message").val().length);
		var no_of_sms=(Math.ceil($("#message").val().length/160)) * $('#filter_count').val();
		$('#number_of_sms').html(no_of_sms);	
	}
	
	$('#remainder_type_id').on('change',function(){

			var type=$(this).val();
			var birthdayOption='<option value="1" rel="">Before  Birthday</option><option value="2">After Birthday</option><option value="3">On Birthday</option>';
			var anvOption='<option value="1">Before  Aniversery</option><option value="2">After Aniversery</option><option value="3">On Aniversery</option>';
			var servOption='<option value="1">Before Service Date</option><option value="2">After Service Date</option><option value="3">On Service Date</option>';
			$('#remainder_period_type').html('');
			$('#remainder_period_type').html('<option>Select Period</option>');
			if(type==1) {
				$('#remainder_period_type').append(birthdayOption);
			}
			else if(type==2) {
				$('#remainder_period_type').append(anvOption);
			}
			else {
				$('#remainder_period_type').append(servOption);
			}
	});
	
	$('#remainder_period_type').on('change',function(){
	      var type=$(this).val();
		  if(type==3){
			  $('#no_of_days_section').hide();
		  }else{
			  $('#no_of_days_section').show();
		  }
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
				<h4 class="modal-title"><i class="fa fa-comments-o" style="color:#fff;"></i> Preview Sms</h4> 
			</div>
			<form id="group_form_url" class="js-group-edit" action="">
				<div class="modal-body" style="height:auto;"> 
				<h5 style="font-size:16px;"><i class="fa fa-list-alt"></i> <b class="preview-title"> </b></h5>
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