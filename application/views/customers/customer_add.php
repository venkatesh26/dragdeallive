<?php
	$total_reward_points=0;
	$total_redeemed_points=0;
	$last_bill_amount=0;
	$total_bill_amount=0;

?>
<article class="content dashboard-page customer-add-page">
	    <?php echo $this->load->view('elements/profile_complete_alert',array(),true);?>
<div class="white-bg">
	<div class="title-search-block">
		<div class="title-block1">
			<div class="row">
				<div class="col-md-6">
				   <h3 class="title">
					  <i class="fa fa-plus-circle"></i> Add Customer
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
						<div class="title-block">
							<h3 class="title" style="font-size:16px;"> <b> <i class="fa fa-search"></i>  Check Customer Availability </b>	</h3>
						</div>

							<form id="customer_check_info_url" action="<?php echo base_url().'users/check_customer_availability';?>" method="post">
								<div class="row">
									<div class="form-group col-md-4"> 
										<label class="control-label" for="mobile_number" style="font-size:14px;"><i class="fa fa-mobile"></i> Mobile Number <span class="required"> * </span></label>
										<input type="text" autocomplete="off" name="contact_number" class="form-control" id="contact_number">
									</div>
									<div class="form-group col-md-4 search-buttons"> 
									<label class="control-label" for="email"></label>
										<button class="btn btn-primary btn-md clearfix"><i class="fa fa-search color-theme-1" style="color:#fff"></i> Search</button>
										<a class="btn btn-primary btn-md" href="<?php echo base_url().'customer-list';?>" style="margin-left:22px;">Cancel</a>
									</div>
								</div>
							</form>
							<div class="box-content clearfix existingUserAdd" style="display:none;">
								<div class="control-group">
									<div class="controls">
										<p><i class="fa fa-info-circle"> </i> Customer Information Already Available. Do You Want Edit ? pls <a href="javascript:void(0)" rel="" class="edit_user_link"> Click Here</a></p>
									</div>
								</div>
							</div>
				   </div>
				</div>
				<div class="card newUserAdd" style="display:none;">
				   <div class="card-block" style="height:auto;">
					
				    	<form id="customer_form_url" action="<?php echo base_url().'customers/customer_add';?>" method="post">
							<input type="hidden" name="mobile_number" class="form-control" id="mobile_number">
							<input type="hidden" name="user_id" class="form-control" id="user_id">
	
							<div class="control-group">
								
								<div class="controls">
									<div class="title-block">
										<h3 class="title"><i class="fa fa-bullhorn"></i> Basic Information</h3>
									</div>
									<div class="row">
						
											<div class="form-group col-md-3">
												<label class="control-label" for="first_name">First Name <span style="color:red;">*</span></label>
												<input type="text" name="first_name" class="form-control" id="first_name">
											</div>
											<div class="form-group col-md-3">
												<label class="control-label" for="last_name">Last Name </label>
												<input type="text" name="last_name" class="form-control" id="last_name">
											</div>
											<div class="form-group col-md-3">
												<label class="control-label" for="address"> Address </label>
												<input type="text" name="address" class="form-control" id="address">
											</div>
											<div class="form-group col-md-3">
												 <label class="control-label" for="email">Email </label>
												 <input type="text" name="email" class="form-control" id="email" value="">
											</div>
									</div>
									
									<div class="row">
										<div class="form-group col-md-3">
											<label class="control-label" for="selectError">Select Gender <span style="color:red;">*</span></label>
											<select id="selectError" name="gender" class="common-select-box form-control" style="width:100%;">
												<option value="">Select Gender</option>
												<option value="1">Male</option>
												<option value="2">Female</option>
											</select>
										</div>
										<div class="form-group col-md-3">
											<label class="control-label" for="city_autocomplete">City </label>
											<input type="text" name="city" class="form-control" id="city_autocomplete" autocomplete="off">
											<input type="hidden" name="add_city_id" class="form-control" id="add_city_id">
										</div>
										<div class="form-group col-md-3">
											<label class="control-label" for="area_autocomplete">Area </label>
											<input type="text" name="area" class="form-control" id="area_autocomplete" autocomplete="off">
												<input type="hidden" name="add_area_id" class="form-control" id="add_city_id">
										</div>
										<div class="form-group col-md-3">
											<label class="control-label" for="area_autocomplete">ZIpCode </label>
											<input type="text" name="zipcode" class="form-control" id="zipcode" autocomplete="off">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-3">
											<label class="control-label" for="group_autocomplete">Group </label>
											<input type="text" name="group_name" class="form-control" id="group_autocomplete" autocomplete="off">
												<input type="hidden" name="group_id" class="form-control" id="group_id">
										</div>
										<div class="form-group col-md-3">
										<label class="control-label" for="dob"> Date Of Birth </label>
										<input type="text" name="dob" class="form-control" id="dob" readonly>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label" for="doa"> Date Of Anversery </label>
										<input type="text" name="doa" class="form-control" id="doa" readonly>
									</div>
									
								
									</div>
								</div>
								
								<div class="controls">
									<div class="title-block">
											<h3 class="title"><i class="fa fa-list"></i> Billing Section</h3>
										</div>
										<div class="row">

										    <div id="product_range_section">
											
												<div class="col-md-12 product-range-section"  id="">	
												
													<div class="form-group col-md-3">
														<label class="control-label" for="product_name">Product </label>
														<input type="text" rel="product_name" name="advertisment_customer_bill_details[key_0][product_name]" class="form-control products_autocomplete">
														<input type="hidden" rel="product_id" name="advertisment_customer_bill_details[key_0][product_id]" class="js_product_id">
													</div>
												
													<div class="form-group col-md-2">
														<label class="control-label" for="quantity">Qunatity </label>
														<input type="number" rel="quantity" value="1" name="advertisment_customer_bill_details[key_0][quantity]" class="form-control quantity">
													</div>
												
												
													<div class="form-group col-md-2">
														<label class="control-label" for="amount">Price </label>
														<input type="number" rel="amount" name="advertisment_customer_bill_details[key_0][amount]" class="form-control bill_amount">
													</div>
													
													<div class="form-group col-md-2">
														<label class="control-label" for="amount">Amount </label>
														<br>
														<b><span class="row_total_amount">0.00</span></b>
													</div>
													
													<div class="form-group col-md-3">
													
													
													 <label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle product-clone-data cursor"></i></label>
													&nbsp;<label class="control-label" for="email" style="margin-top:34px;color:red;">	
													 <i style="color:red;display:none;" class="fa fa-close product-clone-remove-data cursor"></i></label>
												   </div>
												  </div>
											</div>
											<div class="product-range-section-clone">

											</div>
						                    <div class="col-md-12">
											 <div class="col-md-6">
											 </div>
											 <div class="col-md-3">
											 <p style="float:right">Total : <span class="js-total-amount">0.00</span></p>
											 </div>
											<div>
										</div>

								</div>
							
								<div class="controls bg-section">
																	
									<div class="title-block">
										<h3 class="title"><i class="fa fa-calendar"></i> Remainder Settings</h3>
									</div>

										<div class="form-group col-md-3">
										<label class="control-label" for="is_active">
										<input type="checkbox" name="is_active" id="is_active"  checked="checked" class="checkbox">
										<span> Make as active</span> 
										</label>
									</div>
								<div class="form-group col-md-3">
								<label class="control-label" for="is_birthday_remainder">
									<input type="checkbox" name="is_birthday_remainder" id="is_birthday_remainder"  checked="checked" data-no-uniform="true" class="checkbox">
									<span>Birthday Remainder</span></label>
								</div>
								<div class="form-group col-md-3">
									<label class="control-label" for="is_aniversy_reminder">
									<input type="checkbox" name="is_aniversy_reminder" id="is_aniversy_reminder"  checked="checked" data-no-uniform="true" class="checkbox"><span>Aniversy Remainder</span></label>
								</div>
									<div class="form-group col-md-3">
									<label class="control-label" for="send_notification">
									<input type="checkbox" name="send_notification" id="send_notification"  checked="checked" data-no-uniform="true" class="checkbox"><span>Send Sms Notification</span></label>
								</div>
								
								<div id="range_section">
									<div class="col-md-12 range-section"  id="">							
										<div class="form-group col-md-4">
											<label class="control-label" for="email">Service Remainder <span style="color:red;">*</span></label>
											<input type="text" placeholder="Service Name" class="form-control service_name" name="service_name[]"/>
											<input type="hidden" class="form-control service_id" name="service_id[]"/>
										</div>
										<div class="form-group col-md-4">
											<label class="control-label" for="email">Date  <span style="color:red;">*</span></label>
											<input type="text" placeholder="Service Date" class="service_date form-control" name="service_date[]"/>
										</div>
										<div class="form-group col-md-4">
											<label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle clone-data cursor"></i></label>
											&nbsp;<label class="control-label" for="email" style="margin-top:34px;color:red;">	
											<i style="color:red;display:none;" class="fa fa-close clone-remove-data cursor"></i></label>
										</div>
									</div>
								</div>
							<div class="range-section-clone">

							</div>
							<div><i class="fa fa-question-circle tooltipdiv cursor"></i> If you do not have any service remainders ? Please <a target="_blank" href="<?php echo base_url().'remainders/add';?>">Click Here </a> to add remainders.</div>
					</div>
					<button class="btn btn-primary btn-md pull-right" style="margin-left:10px;">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a class="btn btn-primary btn-md pull-right" href="">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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

	function totalBillAmount(){
		
		var sub_total=0;
			$(".product-range-section").each(function() {			
				var quantity=$(this).find('.quantity').val();
				var bill_amount=$(this).find('.bill_amount').val();
				$(this).find('.row_total_amount').html(quantity*bill_amount)
				
				sub_total=sub_total+(quantity*bill_amount);
			});		
			
			$('.js-total-amount').html(sub_total);
	}

	$('#next_service_date').datepicker({format: "yyyy-mm-dd"}); 
	$('.newUserAdd').hide();
    
	
	$(document).ready(function(){	
	
	$('.products_autocomplete').livequery('keyup',function(){
	    var _this=$(this);	   
		_this.parents('div.product-range-section').find('.bill_amount').val('0.00');
		_this.parents('div.product-range-section').find('.js_product_id').val('');
		$(this).autocomplete({
			source: __cfg('path_absolute')+'advertisments_store_products/get_products_autocomplete?type=1',
			select: function(event, ui) 
			{
				_this.parents('div.product-range-section').find('.bill_amount').val(ui.item.amount);
				_this.parents('div.product-range-section').find('.js_product_id').val(ui.item.id);
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item )
		{				
			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
			return $("<li></li>")
			.data( "item.autocomplete", item )
			.append(inner_html)
			.appendTo( ul );
		}
	});
	
	$('.products_autocomplete').livequery('blur',function(){
		var _this=$(this);
		if(_this.parents('div.product-range-section').find('.js_product_id').val()==''){
			_this.parents('div.product-range-section').find('.bill_amount').val('0.00');	
			_this.parents('div.product-range-section').find('.products_autocomplete').val('');
		}
	});
   
   	$('#dob').livequery('focus',function() {
			$('#dob').datepicker({
				format: "yyyy-mm-dd",
				changeMonth: true,
				changeYear: true,
				startDate: new Date()
			});  
	});
	
	$('#dob').livequery('click',function(){
		$(this).trigger('focus');
	});
	
	$('#doa').livequery('focus',function() {
		$('#doa').datepicker({
			format: "yyyy-mm-dd",
			changeMonth: true,
			changeYear: true,
			startDate: new Date()
		});  
	});
	
	$('#doa').livequery('click',function(){
		$(this).trigger('focus');
	});
	
	$('.service_date').livequery('focus',function() {
			$('.service_date').datepicker({
				format: "yyyy-mm-dd",
				startDate: new Date()
			});  
	});
	
	$('.service_date').livequery('click',function(){
		$(this).trigger('focus');
	});
	
	$('.bill_amount,.products_autocomplete,.quantity').livequery('change',function(){
		totalBillAmount();
	});
	
   
	$('.clone-data').livequery('click',function(){
		$("#range_section div.range-section").clone().appendTo("div.range-section-clone");	
		$('div.range-section').parents('div#range_section div.range-section:last').find('input.service_date').val('');
		$('div.range-section:last').find('input.service_date').val('');
		$('div.range-section:last').find('input.service_name').val('');
		$('div.range-section:last').find('input.service_id').val('');
		$('div.range-section-clone').find('.clone-remove-data').show();
		return false;
	});

	$('.clone-remove-data').livequery('click',function(){
		$(this).parents('div.range-section').remove();
		$(this).parents('div.range-section').parents('div.range-section-clone').find('div.dummy-div').remove();
	});
	
	$('.product-clone-data').livequery('click',function(){
		$("#product_range_section div.product-range-section").clone().appendTo("div.product-range-section-clone");	
		$('div.product-range-section-clone').find('.product-clone-remove-data').show();	
		var i=0;
		$("div.product-range-section").each(function() {
			$(this).find("input").each(function() {
				var new_name='key_'+i;
				string='advertisment_customer_bill_details['+new_name+']['+$(this).attr('rel')+']';
				$(this).attr('name', string); 
			});			
			i++;
		});
		
		$("div.product-range-section:last").each(function() {
			$(this).find("input").each(function() {
				if($(this).attr('rel')!='qunatity'){
						$(this).val('');
				}
			});
		});
		return false;
	});

	$('.product-clone-remove-data').livequery('click',function(){
		$(this).parents('div.product-range-section').remove();
		$(this).parents('div.product-range-section').parents('div.product-range-section-clone').find('div.dummy-div').remove();
		var i=0;
		$("div.product-range-section").each(function() {
			$(this).find("input").each(function() {
				var new_name='key_'+i;
				string='advertisment_customer_bill_details['+new_name+']['+$(this).attr('rel')+']';
				$(this).attr('name', string); 
			});			
			i++;
		});
		totalBillAmount();
		return false;
	});
   
   var url="<?php echo base_url();?>"+"remainders/search_customers_remainders";
	   $('#tokenize').tokenize({ 
			datas: url,   
			newElements:false
	   });  
   });	
   
</script>