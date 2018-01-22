<div class="control-group">
						<div class="controls">
							<div class="form-group col-md-7">
								<label class="control-label" style="    margin-tOP: 4px;
    font-size: 15px;" for="mobile_number clearfix"><a href="javascript:void(0)"><i class="fa fa-filter"></i></a> <b>Filter Customers  By - No. Of Customers Filtered : <span id="filter_count_show" class="square-box"><?php  echo $filter_count;?></span></b></label>
								<input  type="hidden" name="filter_count" value="<?php  echo $filter_count;?>" id="filter_count">
							</div>
						</div>
						<div class="controls">
							<div class="form-group col-md-12 filter_types">
								<label for="filter_type" class="cursor"><input type="radio" name="filter_type" rel="0" id="filter_type" class="radio clearfix cursor" checked="checked" value="0"> <span>&nbsp;All&nbsp;&nbsp;</span></label>
								<label for="filter_type_date" class="cursor"><input type="radio" name="filter_type" rel="2" id="filter_type_date" class="radio clearfix cursor" value="2"><span>&nbsp;Date Range &nbsp;&nbsp;</span></label>
								<label for="filter_type_bill" class="cursor"><input type="radio" name="filter_type" rel="1" id="filter_type_bill" class="radio clearfix cursor" value="1"> <span>&nbsp;&nbsp;Billing&nbsp;&nbsp;</span></label> 
								<label for="filter_type_visit" class="cursor"><input type="radio" name="filter_type" rel="3" id="filter_type_visit" class="radio clearfix cursor" value="3"> <span>&nbsp;&nbsp;Visit Counts	&nbsp;&nbsp;</span></label>  
								<label for="filter_type_group" class="cursor"><input type="radio" name="filter_type" rel="4" id="filter_type_group" class="radio clearfix cursor" value="4"> <span> &nbsp;&nbsp;Specific Groups	&nbsp;&nbsp;</span></label>
								<label for="filter_type_customers" class="cursor"><input type="radio" name="filter_type" rel="5" id="filter_type_customers" class="radio clearfix cursor" value="5"> <span>&nbsp;&nbsp;Specific Customers &nbsp;&nbsp;</span></label> 								
							</div>
						</div>
						<div class="control-group" style="display:none;" id="date_based_section">
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
											<option value="bill_amount_lessthan_1000">Bill Amount <= 1000</option>
											<option value="between_1000_10000">Bill Amount >= 1000 && Bill Amount <= 10,000</option>
											<option value="between_10000_50000">Bill Amount >= 10,000 && Bill Amount <= 50,000</option>
											<option value="greaterthan_50000">Bill Amount >= 50,000</option>
											<option value="custom_range">Custom Range</option>
										</select>
									</div>
									<div  style="display:none;" class="custom_bill_filter">
										<div class="form-group col-md-2">
											<input type="number" name="bill_from" class="form-control" id="bill_from" placeholder="Bill From" min="1">
										</div>
										<div class="form-group col-md-2">	
											<input type="number" name="bill_to" class="form-control" id="bill_to" placeholder="Bill To" min="1" >
										</div>
									</div>
								</div>
						</div>
					
						<div class="control-group" style="display:none;" id="specific_number_based_section">
							<div class="controls">
								<div class="form-group col-md-12">
									<label class="control-label" for="mobile_number">Mobile Numbers <span style="color:red;">*</span> </label>
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
											<option value="visit_lessthan_500">VisitCount <= 500 </option>
											<option value="between_100_500">VisitCount >= 100 && VisitCount <= 500 </option>
											<option value="between_500_1000">VisitCount >= 500 && VisitCount <= 1000 </option>
											<option value="greaterthan_1000">VisitCount >= 1000 </option>
											<option value="custom_range">Custom Range </option>
										</select>
									</div>
									<div  style="display:none;" class="custom_visit_filter">
										<div class="form-group col-md-2">
											<input type="number"  placeholder="Visit Count"  min="1" name="visit_from" class="form-control" id="visit_from">
										</div>
										<div class="form-group col-md-2">
											<input type="number" placeholder="Visit Count" min="1" name="visit_to" class="form-control" id="visit_to">
										</div>
									</div>
								</div>
						</div>
						<div class="control-group" style="display:none;" id="group_section">
							<div class="control-group">
								
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
				
<script>   
function sms_counts() {	
   		$("#sms_character_count").text($("#message").val().length);
   		var no_of_sms=(Math.ceil($("#message").val().length/160)) * $('#filter_count').val();
   		$('#number_of_sms').html(no_of_sms);
	    $('.preview-sms').html('');		
		$('.preview-sms').html($("#message").val());
   	}   

   $(document).ready(function(){	

	
	$('#message').keyup(function () {
   		sms_counts();
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
   			data:$("#offer_campaings_form_url").serialize(),
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
   
 });
 </script>