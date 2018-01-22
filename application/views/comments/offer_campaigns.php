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
                     <i class="fa fa-tag"></i> Offer Campaign
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
                     <?php if($total_sms <= 0){?>
                     <label><i class="fa fa-info-circle" style="font-size:18px;color:red;"></i> Currently No Sms Available. Please <a href="<?php echo base_url()."sms_package_list";?>">click here</a> to choose your plan.</label>
                     <?php }?>
                     <form id="offer_campaings_form_url" action="<?php echo base_url().'campaigns/offer_campaigns';?>" method="post">
                        <div class="form-group col-md-3"> 
                           <label class="control-label1" for="title">Campaign Title <span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter Campaign Title</span> </i></label>
                           <input type="text" name="title" class="form-control" id="title" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label1" for="title">Sender ID<span style="color:red;"> *</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Select Your Sender ID</span> </i> </label>
                           <select id="sender_id" name="sender_id" class="form-control common-select-box">
                              <option value="">Select SenderID</option>
                              <?php 
                                 if(!empty($my_sendeids)):
                                 	foreach($my_sendeids as $groups):?>
                              <option value="<?php echo ucfirst($groups['id']);?>"><?php echo ucfirst($groups['sender_id']);?></option>
                              <?php 
                                 endforeach;
                                 else :
                                 ?>
                              <option value="0">Default</option>
                              <?php endif;?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="campaign_start_date">Campaign Start Date <span style="color:red;">*</span></label>
                           <input type="text" name="campaign_start_date" class="form-control" id="campaign_start_date" readonly>
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="campaign_end_date">Campaign End Date <span style="color:red;">*</span></label>
                           <input type="text" name="campaign_end_date" class="form-control" id="campaign_end_date" readonly>
                        </div>
                        <div class="form-group col-md-12">
                           <label class="control-label1" for="message">Message <span style="color:red;">*</span>
                           <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Campaign Message</span> </i>  </label>
                           <label class="pull-right" style=""> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-custom-width">Sms Count will be varied based on filtred customers and sms character</span> </i> 
                           <b>Number of sms will be Debit : <span id="number_of_sms" class="square-box"><?php echo $filter_count;?></span></b></label>
                           <textarea name="message" cols="10" rows="5"  id="message" class="form-control"></textarea>
                           <div class="icon-section pull-right" style="margin-top:5px">
                              <a class="show-preview"  href="javascript:void(0)" data-toggle="modal" data-target="#confirm-modal"> <i class="fa fa-eye"></i> <b>Preview</b> </a>&nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0);" class="hastags cursor" rel="##URL##"><i class="fa fa-globe"></i>&nbsp;<b>##URL##</b></a>&nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0);"  class="hastags cursor" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0);"  class="hastags cursor" rel="##CODE##"><i class="fa fa-tag"></i>&nbsp;<b>##CODE##</b></a> &nbsp;&nbsp;&nbsp;
                              <label class="pull-right clearfix square-box-label" style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="sms_character_count" class="square-box"> 0 </span></b></label>
                           </div>
                        </div>
                        <div class="form-group col-md-6"> 
                           <label class="control-label1" for="url">Campaign Url <span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter Campaign Url</span> </i></label>
                           <input type="text" name="url" class="form-control" id="url">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="profile_image">Campaign Image <span style="color:red;">*</span></label>
                           <input type="file" class="form-control"  name="profile_image" accept="image/*">
                        </div>
                     
                           <div class="filter_type_code">
                              <div class="form-group col-md-12"> 
                                 <label class="control-label" style="margin-tOP: 4px;font-size: 15px;"><i class="fa fa-tag"></i> Select Option&nbsp;&nbsp;</label>
                                 <label class="cursor"><input type="radio" name="coupon_type" rel="1" id="filter_type_code1" class="radio clearfix cursor" checked="checked" value="1"><span>Dynamic Coupon Code  &nbsp;&nbsp;&nbsp;&nbsp;</span></label>
                                 <label class="cursor"><input type="radio" name="coupon_type" rel="2" id="filter_type_code2" class="radio clearfix cursor" value="2">  <span>Static Coupon Code &nbsp;&nbsp;&nbsp;&nbsp;</span></label>
								 <input type="text" maxlength="6" name="coupon_code" id="coupon_code" class="form-control" placeholder="Enter Coupon Code" style="display:none;width:170px;">
                              </div>
                           </div>
                   
                        <div class="control-group">
                           <div class="controls">
                              <div class="form-group col-md-7">
                                 <label class="control-label"  style="    margin-tOP: 4px;
    font-size: 15px;"for="mobile_number clearfix"><a href="javascript:void(0)"><i class="fa fa-filter"></i></a> <b>Filter Customers  By - No. Of Customers Filtered : <span id="filter_count_show" class="square-box"><?php  echo $filter_count;?></span></b></label>
                                 <input  type="hidden" name="filter_count" value="<?php  echo $filter_count;?>" id="filter_count">
                              </div>
                           </div>
                           <div class="controls">
                              <div class="form-group col-md-12 filter_types">
                                 <label for="filter_type" class="cursor"><input type="radio" name="filter_type" rel="0" id="filter_type" class="clearfix radio cursor" checked="checked" value="0"><span>&nbsp;All &nbsp;&nbsp;</span></label>
                                 <label for="filter_type_date" class="cursor"><input type="radio" name="filter_type" rel="2" id="filter_type_date" class="radio clearfix cursor" value="2"><span>&nbsp;Date Range &nbsp;&nbsp;</span></label>
                                 <label for="filter_type_bill" class="cursor"><input type="radio" name="filter_type" rel="1" id="filter_type_bill" class="radio clearfix cursor" value="1"> <span>&nbsp;&nbsp;Billing&nbsp;&nbsp;</span></label> 
                                 <label for="filter_type_visit" class="cursor"><input type="radio" name="filter_type" rel="3" id="filter_type_visit" class="radio clearfix cursor" value="3">
                                 <span>&nbsp;&nbsp;Visit Counts	&nbsp;&nbsp;</span>
                                 </label>  
                                 <label for="filter_type_group" class="cursor"><input type="radio" name="filter_type" rel="4" id="filter_type_group" class="radio clearfix cursor" value="4">  <span>&nbsp;&nbsp;Specific Groups	&nbsp;&nbsp;</span></label>
                                 <label for="filter_type_customers" class="cursor"><input type="radio" name="filter_type" rel="5" id="filter_type_customers" class="radio clearfix cursor" value="5"> <span>&nbsp;&nbsp;Specific Customers &nbsp;&nbsp;</span></label> 								
                              </div>
                           </div>
                           <div class="control-group clearfix" style="display:none;" id="date_based_section">
                              <div class="controls">
                                 <div class="form-group col-md-4">
                                    <select id="date_filter" name="date_filter" class="form-control common-select-box">
                                       <option value="">Select Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                       <option value="last_30_days">Last 30 Days</option>
                                       <option value="last_60_days">Last 60 Days</option>
                                       <option value="custom_range">Custom Range</option>
                                    </select>
                                 </div>
                                 <div  style="display:none;" class="custom_date_filter">
                                    <div class="form-group col-md-2">
                                       <input type="text" name="from_date" class="form-control" id="from_date" placeholder="From Date">
                                    </div>
                                    <div class="form-group col-md-2">
                                       <input type="text" name="to_date" class="form-control" id="to_date" placeholder="To Date">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group" style="display:none;" id="bill_amount_section">
                              <div class="controls">
                                 <div class="form-group col-md-4">
                                    <select id="bill_filter" name="bill_filter" class="form-control common-select-box">
                                       <option value="">Select Type</option>
                                       <option value="bill_amount_lessthan_10000">Bill Amount <= 1000 </option>
                                       <option value="between_1000_10000">Bill Amount >= 1000 && Bill Amount <= 10,000 </option>
                                       <option value="between_10000_50000">Bill Amount >= 10000 && Bill Amount <= 50000 </option>
                                       <option value="greaterthan_50000">Bill Amount >= 50000 </option>
                                       <option value="custom_range">Custom Range </option>
                                    </select>
                                 </div>
                                 <div  style="display:none;" class="custom_bill_filter">
                                    <div class="form-group col-md-2">
                                       <input type="number" name="bill_from" class="form-control" id="bill_from" placeholder="Bill From">
                                    </div>
                                    <div class="form-group col-md-2">	
                                       <input type="number" name="bill_to" class="form-control" id="bill_to" placeholder="Bill To">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group" style="display:none;" id="specific_number_based_section">
                              <div class="controls">
                                 <div class="form-group col-md-12">
                                    <label class="control-label" for="mobile_number">Mobile Numbers *</label>
                                    <select class="tokenize-sample" multiple="multiple" name='contact_numbers[]' id="tokenize">
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group" style="display:none;" id="visit_count_section">
                              <div class="controls">
                                 <div class="form-group col-md-4">
                                    <select id="visit_filter" name="visit_filter" class="form-control common-select-box">
                                       <option value="">Select Type</option>
                                       <option value="visit_lessthan_500">VisitCount lessthan 500 </option>
                                       <option value="between_100_500">VisitCount >= 100 && VisitCount <= 500 </option>
                                       <option value="between_500_1000">VisitCount >= 500 && VisitCount <= 1000 </option>
                                       <option value="greaterthan_1000">VisitCount >= 1000 </option>
                                       <option value="custom_range">Custom Range </option>
                                    </select>
                                 </div>
                                 <div  style="display:none;" class="custom_visit_filter">
                                    <div class="form-group col-md-2">
                                       <label class="control-label" for="visit_from">From *</label>
                                       <input type="number"  placeholder="Visit Count"  name="visit_from" class="form-control" id="visit_from">
                                    </div>
                                    <div class="form-group col-md-2">
                                       <label class="control-label" for="visit_to">To *</label>
                                       <input type="number" placeholder="Visit Count" name="visit_to" class="form-control" id="visit_to">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group clearfix" style="display:none;" id="group_section">
                              <div class="control-group">
                                 <label class="control-label" for="group_id"> &nbsp;&nbsp;&nbsp;Select Group *</label>
                                 <div class="controls">
                                    <div class="form-group col-md-4 selectbox-error">
                                       <select id="group_id" name="group_id" class="form-control common-select-box" style="" >
                                          <option value="">Select Group</option>
                                          <?php foreach($my_groups as $groups):?>
                                          <option value="<?php echo ucfirst($groups['id']);?>"><?php echo ucfirst($groups['name']);?></option>
                                          <?php endforeach;?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>
				  <div class="form-group col-md-12">
				         <div class="control-group">
						  <label for="display_as_offer" class="cursor control-label"><input type="checkbox" name="display_as_offer" rel="0" id="display_as_offer" class="clearfix checkbox cursor"><span>&nbsp;Display As Offer &nbsp;&nbsp;</span></label>
						  </div>
						  <br/>
						   <div class="control-group" style="display:none;" id="offer_section">
							  <label class="control-label" for="description">Description <span style="color:red;">*</span></label>
						   <textarea name="description" cols="10" rows="5"  id="description" class="form-control"></textarea>
					   </div>
							 
				  </div>
				 
                  <div class="box-content clearfix">
					  <button class="btn btn-primary btn-md pull-right">Send</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  <a class="btn btn-primary btn-md pull-right" href="" style="margin-right:10px;"> Cancel</a>
				 </div>
				 <div class="box-content clearfix">
					  <p class="pull-right"><i class="fa fa-info-circle"></i> Don't close the browser or refresh the page after send button clicked.</p>
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
   $('#from_date').datepicker({format: "yyyy-mm-dd"}); 
   $('#to_date').datepicker({format: "yyyy-mm-dd"}); 
   $('#campaign_start_date').datepicker({format: "yyyy-mm-dd"}); 
   $('#campaign_end_date').datepicker({format: "yyyy-mm-dd"}); 
   
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
	
	$('#display_as_offer').change(function (){
		if($(this).prop('checked')){
		$('#offer_section').show();
		}
		else{
			$('#offer_section').hide();
		}
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
   	$('#message').keyup(function () {
   		sms_counts();
   	});
   	
   	$('#offer_campaings_form_url').livequery('submit',function(){
   		var url=$("#offer_campaings_form_url").attr('action');
   		var $this=$(this);
		var form = $('#offer_campaings_form_url')[0]; 
        var formData = new FormData(form);
		formData.append('image', $('input[type=file]')[0].files[0]); 
   		$.LoadingOverlay("show");
   		$.ajax({
   			type: "POST",
   			url: url,
   			data:formData,
   			datatype:"json",
			contentType: false,
            processData: false,
   			success: function(data) {
   				$.LoadingOverlay("hide");
   				var data=jQuery.parseJSON(data);
   				
   				if(data.status=="error") {
   					$("#offer_campaings_form_url input").each(function() {
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
   				
   						$("#offer_campaings_form_url input").each(function() {
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
   					$("#offer_campaings_form_url textarea").each(function() {
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
   	
   	$('#bill_search').on('click',function(){
   	  $('#filter_type_bill').trigger('change');
   	  return false;
   	});
   	
   	$('#group_id').on("change",function() {
   		$('#filter_type_group').trigger('change');
   		return false;
   	});
   	
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
   	
   	
   	$('#visit_filter').on("change",function(){
   		$('.custom_visit_filter').hide();
   		if($('#visit_filter').val()!='') {
   			if($('#visit_filter').val()=='custom_range'){
   				$('.custom_visit_filter').show();
   			}
   			else {
   			  $('#filter_type_visit').trigger('change');
   			}
   		}
   		else {
   			return false;
   		}
   	});
   	
   	$('#visit_from').on("blur",function(){
   		$('#filter_type_visit').trigger('change');
   	});
   	
   	$('#visit_to').on("blur",function(){
   		$('#filter_type_visit').trigger('change');
   	});
   
   	$('#bill_filter').on("change",function(){
   		$('.custom_bill_filter').hide();
   		if($('#bill_filter').val()!='') {
   			if($('#bill_filter').val()=='custom_range'){
   				$('.custom_bill_filter').show();
   			}
   			else {
   			  $('#filter_type_bill').trigger('change');
   			}
   		}
   		else {
   			return false;
   		}
   	});
   				
   	$('#bill_from').on("blur",function(){
   		$('#filter_type_bill').trigger('change');
   	});
   	
   	$('#bill_to').on("blur",function(){
   		$('#filter_type_bill').trigger('change');
   	});
   	
   	$('#from_date').on("change",function(){
   		$('#filter_type_date').trigger('change');
   	});
   	
   	$('#to_date').on("change",function(){
   		$('#filter_type_date').trigger('change');
   	});
   	
   	
   	$(".filter_type_code input").on("change",function(){	
   		var filter_type=$(this).attr('rel');	
   		if(filter_type==2){
   			 $('#coupon_code').show();
   		} else {
   			$('#coupon_code').val('');
   			$('#coupon_code').hide();
   		}
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
	    $('.preview-sms').html('');		
		$('.preview-sms').html($("#message").val());
   	}
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