<?php
   $mobile_number=(isset($user_data['mobile_number']))?$user_data['mobile_number']:'';
   $email=(isset($user_data['email']))?$user_data['email']:'';
   $first_name=(isset($user_data['first_name']))?$user_data['first_name']:'';
   $last_name=(isset($user_data['last_name']))?$user_data['last_name']:'';
   $email=(isset($user_data['email']))?$user_data['email']:'';
   $mobile_number=(isset($user_data['mobile_number']))?$user_data['mobile_number']:'';
   $telephone_number=(isset($user_data['telephone_number']))?$user_data['telephone_number']:'';
   $address=(isset($user_data['address']))?$user_data['address']:'';
   $dob=(isset($user_data['dob']) && $user_data['dob']!='0000-00-00')?$user_data['dob']:'';
   $doa=(isset($user_data['doa']) && $user_data['doa']!='0000-00-00')?$user_data['doa']:'';
   $next_service_date=(isset($user_data['next_service_date']) && $user_data['next_service_date']!='0000-00-00')?$user_data['next_service_date']:'';
   $city_name=(isset($user_data['city_name']))?$user_data['city_name']:'';
   $area_name=(isset($user_data['area_name']))?$user_data['area_name']:'';
   $gender=(isset($user_data['gender_id']))?$user_data['gender_id']:'';
   $last_bill_amount=(isset($user_data['last_bill_amount_paid']))?$user_data['last_bill_amount_paid']:0;
   $total_bill_amount=(isset($user_data['total_amount']))?$user_data['total_amount']:0;
   $is_birthday_remainder=(isset($user_data['is_birthday_remainder']) && $user_data['is_birthday_remainder']==1)?$user_data['is_birthday_remainder']:0;
   $is_aniversy_reminder=(isset($user_data['is_aniversy_reminder']) && $user_data['is_aniversy_reminder']==1)?$user_data['is_aniversy_reminder']:0;
   $is_active=(isset($user_data['is_active']) && $user_data['is_active']==1)?$user_data['is_active']:0;
   $zip=(isset($user_data['zip']) && $user_data['zip'])?$user_data['zip']:'';
   $group_name=(isset($user_data['group_name']) && $user_data['group_name'])?$user_data['group_name']:'';
   $city_id=(isset($user_data['city_id']) && $user_data['city_id'])?$user_data['city_id']:'';
   
   $total_reward_points=(isset($user_data['total_reward_points']))?$user_data['total_reward_points']:0;
   $total_redeemed_points=(isset($user_data['total_redeemed_points']))?$user_data['total_redeemed_points']:0;
   $parent_user_id=(isset($user_data['parent_user_id']))?$user_data['parent_user_id']:0;
   ?>
<article class="content dashboard-page general-campaigns">
   <div class="white-bg">
      <div class="title-search-block">
         <div class="title-block1">
            <div class="row">
               <div class="col-md-6">
                  <h3 class="title">
                     <i class="fa fa-user"></i> Edit Customer
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
                        <h3 class="title">
                           <i class="fa fa-bullhorn"></i> Basic Information
                        </h3>
                     </div>
                     <form id="customer_form_url" action="<?php echo base_url().'customers/edit/'.$edit_id;?>" method="post">
                        <div class="control-group">
                           <div class="controls">
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="mobile_number">Mobile Number <span style="color:red;">*</span></label>
                                 <input type="text" name="mobile_number" class="form-control" id="mobile_number" value="<?php echo $mobile_number?>" readonly>
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="first_name">First Name <span style="color:red;">*</span></label>
                                 <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo $first_name?>" >
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="last_name">Last Name </label>
                                 <input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo $last_name?>">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="address"> Address </label>
                                 <input type="text" name="address" class="form-control" id="address" value="<?php echo $address;?>">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="selectError">Select Gender <span class="required">*</span></label>
                                 <select id="selectError" name="gender" class="common-select-box form-control">
                                    <option value="">Select Gender</option>
                                    <option value="1" <?php if($gender==1){ echo "Selected";}?>>Male</option>
                                    <option value="2" <?php if($gender==2){ echo "Selected";}?>>Female</option>
                                 </select>
                                 <span id="custom_error" class="login_error"></span>
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="email">Email <span style="color:red;">*</span></label>
                                 <input type="text" name="email" class="form-control" id="email"  value="<?php echo $email;?>">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="city_autocomplete">City </label>
                                 <input type="text" name="city" class="form-control" id="city_autocomplete" autocomplete="off" value="<?php echo $city_name;?>">
                                 <input type="hidden" name="add_city_id" class="form-control" id="add_city_id" value="<?php echo $city_id;?>">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="area_autocomplete">Area </label>
                                 <input type="text" name="area" class="form-control" id="area_autocomplete" autocomplete="off" value="<?php echo $area_name;?>">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="group_autocomplete">Group </label>
                                 <input type="text" name="group_name" class="form-control" id="group_autocomplete" autocomplete="off" value="<?php echo $group_name;?>">
                                 <input type="hidden" name="group_id" class="form-control" id="group_id">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="last_bill_amount_paid">Bill Amount </label>
                                 <input type="text" name="last_bill_amount_paid" class="form-control" id="last_bill_amount_paid">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="dob"> Date Of Birth </label>
                                 <input type="text" name="dob" class="form-control" id="dob" readonly value="<?php echo $dob;?>">
                              </div>
                              <div class="form-group col-md-3">
                                 <label class="control-label" for="doa"> Date Of Aniversery </label>
                                 <input type="text" name="doa" class="form-control" id="doa" readonly value="<?php echo $doa;?>">
                              </div>
                              <div class="form-group col-md-3 checkbox-margin">
                                 <label class="control-label" for="is_active">
                                 <input type="checkbox" name="is_active" id="is_active"  data-no-uniform="true" class="checkbox" <?php if($is_active){ echo "checked=cheked";}?>><span>Make As Active</span> </label>
                              </div>
                              <div class="form-group col-md-3 checkbox-margin">
                                 <label class="control-label" for="is_birthday_remainder">
                                 <input type="checkbox" name="is_birthday_remainder" id="is_birthday_remainder"  data-no-uniform="true" class="checkbox" <?php if($is_birthday_remainder){ echo "checked=cheked";}?>><span>Birthday Remainder</span></label>
                              </div>
                              <div class="form-group col-md-3 checkbox-margin">
                                 <label class="control-label" for="is_aniversy_reminder">
                                 <input type="checkbox" name="is_aniversy_reminder" id="is_aniversy_reminder"  data-no-uniform="true" class="checkbox" <?php if($is_aniversy_reminder){ echo "checked=cheked";}?>><span>Aniversy Remainder</span></label>
                              </div>
                              <div class="form-group col-md-3 checkbox-margin">
                                 <label class="control-label" for="send_notification">
                                 <input type="checkbox" name="send_notification" id="send_notification"  checked="checked" data-no-uniform="true" class="checkbox"><span>Send Sms Notification</span></label>
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
							
							  
							  
                              <div id="range_section">
                                 <div class="form-group range-section col-md-12" id="">
                                    <div class="col-md-4">
                                       <label class="control-label" for="email">Service Remainder <span style="color:red;">*</span></label>
                                       <input type="text" placeholder="Service Name" class="form-control service_name" name="service_name[]"/>
                                       <input type="hidden" class="form-control service_id" name="service_id[]"/>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="control-label" for="email">Date  <span style="color:red;">*</span></label>
                                       <input type="text" placeholder="Service Date" class="service_date form-control" name="service_date[]"/>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle clone-data cursor"></i></label>
                                       &nbsp;<label class="control-label" for="email" style="margin-top:34px;color:red;">	
                                       <i style="color:red;display:none;" class="fa fa-close clone-remove-data cursor"></i></label>
                                    </div>
                                 </div>
                              </div>
                              <div class="range-section-clone">
                                 <?php
                                    foreach($remainder_data as $key=>$data):
                                    ?>
                                 <div class="form-group range-section col-md-12"  id="">
                                    <div class="col-md-4">
                                       <label class="control-label" for="email">Service Remainder <span style="color:red;">*</span></label>
                                       <input type="text" placeholder="Service Name" class="form-control service_name" name="service_name[]" value="<?php echo $data['name'];?>"/>
                                       <input type="hidden" class="form-control service_id" name="service_id[]" value="<?php echo $data['remainder_setting_id'];?>"/>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="control-label" for="email">Date  <span style="color:red;">*</span></label>
                                       <input type="text" placeholder="Service Date" class="service_date form-control" name="service_date[]" value="<?php echo $data['service_date'];?>"/>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle clone-data cursor"></i></label>
                                       &nbsp;
                                       <label class="control-label" for="email" style="margin-top:34px;color:red;">	
                                       <i style="color:red;" class="fa fa-close clone-remove-data cursor"></i></label>
                                    </div>
                                 </div>
                                 <?php endforeach;?>
                              </div>
                           </div>
                           <div><i class="fa fa-question-circle tooltipdiv cursor"></i> If you do not have any service remainders ? Please <a target="_blank" href="<?php echo base_url().'remainders/add';?>">Click Here </a> to add remainders.</div>
                           <div class="box-content clearfix" >
                              <div class="box-header well" data-original-title="">
                                 <div class="title-block">
                                    <h3 class="title">
                                       <i class="fa fa-gift"></i> Offers
                                    </h3>
                                 </div>
                              </div>
                              <div class="card items">
                                 <ul class="item-list striped">
                                    <li class="item item-list-header hidden-sm-down td-header-bar">
                                       <div class="item-row">
										  <div class="item-col item-col-header item-col-title">
                                             <div> <span> <i class="fa fa-calendar"> </i> Offer Posted Date</span> </div>
                                          </div>
                                          <div class="item-col item-col-header item-col-title">
                                             <div> <span><i class="fa fa-money"> </i> Offer Name</span> </div>
                                          </div>
                                          <div class="item-col item-col-header item-col-author">
                                             <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"> </i> Status</span> </div>
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
                           <?php if($total_bill_amount > 0):?>
                           <div class="box-content clearfix" >
                              <div class="box-header well" data-original-title="">
                                 <div class="title-block">
                                    <h3 class="title">
                                       <i class="fa fa-list-alt"></i> Rewards and Billing Information
                                    </h3>
                                 </div>
                                 <div class="controls">
                                    <div class="form-group col-md-3">
                                       <label class="control-label" for="first_name">Last Bill Amount : <b style="color:green;"><?php echo number_format($last_bill_amount);?></b></label>
                                    </div>
                                    <div class="form-group col-md-3">
                                       <label class="control-label" for="first_name">Total Bill Amount : <b style="color:green;"><?php echo number_format($total_bill_amount);?></b></label>
                                    </div>
                                     <div class="form-group col-md-3">
                                       <label class="control-label" for="first_name">Total Redeemed Points : <b style="color:green;"><?php echo number_format($total_redeemed_points);?></b></label>
                                    </div>
									<div class="form-group col-md-3">
                                       <label class="control-label" for="first_name">Total Reward Points : <b style="color:green;"><?php echo number_format($total_reward_points);?></b></label>
                                    </div>
									<div class="form-group col-md-3">
                                           <label class="control-label" for="points">How much Point to reedem ? </label>
									<input type="number" name="points" class="form-control" id="points" autocomplete="off" value="">
									<input type="hidden" name="parent_user_id" id="parent_user_id" value="<?php echo $parent_user_id;?>">
                                    </div>
									<div class="form-group col-md-2">
									 <label class="control-label" for="points">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
									 <a class="btn btn-primary btn-md pull-right js-reddem-points">Reedem</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									 </div>
                                    <br/>
                                 </div>
                              </div>
                           </div>
                           <?php endif;?>   
                           <div class="box-content clearfix">
                              <button class="btn btn-primary btn-md pull-right">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a class="btn btn-primary btn-md pull-right" href="<?php echo base_url().'customer-list';?>" style="margin-right:10px;">Cancel</a>
                           </div>
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
	

   var offer_url="<?php echo base_url();?>"+'customers/user_offer_list';
   var reedem_url="<?php echo base_url();?>"+'customers/reedem_offer';
   var reedem_points_url="<?php echo base_url();?>"+'customers/reedem_points';
   var parent_user_id=$('#parent_user_id').val();
   var customer_id="<?php echo $this->uri->segment(3); ?>";
    function reedemPoints(reedem_points_url) {
		var points=$('#points').val();
		$.LoadingOverlay("show");
   		$.ajax({
   			type: "POST",
   			url: reedem_points_url,
   			datatype:"json",
   			data: {'parent_user_id':parent_user_id, 'user_id':customer_id, 'points':points},
   			async:true,
   			success: function(data) {
   			   $.LoadingOverlay("hide");
   			   var data=jQuery.parseJSON(data);
			   if(data.status==true){
				   	alert_notification('success', data.msg);
					window.location.reload();
			   }
			   else {
				   alert_notification('error', data.msg);
			   }
   			}
   		});
    }  

     function getallCustomerOfferList(offer_url) {
   	   $.LoadingOverlay("show");
   		$.ajax({
   			type: "POST",
   			url: offer_url,
   			datatype:"json",
   			data: {'customer_id':customer_id},
   			async:true,
   			success: function(data) {
   			   $.LoadingOverlay("hide");
   			   var data=jQuery.parseJSON(data);
   			   $('.js-response').html(data.main_content);
   			   $('.js-pagenation').html(data.pagination_link);
   			}
   		});
    }
	
	function reedemOffer(offer_id){
		
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: reedem_url,
			datatype:"json",
			data: {'offer_id':offer_id},
			async:true,
			success: function(data) {
			   $.LoadingOverlay("hide");
			   getallCustomerOfferList(offer_url);  
			}
		});
	}
      
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
   
   		getallCustomerOfferList(offer_url);   
      
   		$('.page-item a').livequery('click',function(){
   		   getallCustomerOfferList($(this).attr('href'));
   		   return false;
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
      
      var url="<?php echo base_url();?>"+"remainders/search_customers_remainders";
   	   $('#tokenize').tokenize({ 
   			datas: url,   
   			newElements:false
   	   }); 


		$(document).on("click",".offer-reedme", function(e) {
			
			 $('.redeemPoints').attr('rel',$(this).attr('rel'));
		});
		
		$(document).on("click",".redeemPoints", function(e) {
			reedemOffer($(this).attr('rel'));
		});		 

		$(document).on("click",".js-reddem-points", function(e) {	
            if($('#points').val()!=''){
				$('#confirm-reedem-points-modal').modal();
			}
		});
		
		$(document).on("click",".redeemPointsData", function(e) {
			reedemPoints(reedem_points_url);
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
		
			$('.bill_amount,.products_autocomplete,.quantity').livequery('change',function(){
		totalBillAmount();
	});
	
		
      });
</script>
<div class="modal fade" id="confirm-reedem-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
				<h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4> </div>
			<div class="modal-body">
				<p>Are you sure want to reedem this offer ? </p>
			</div>
			<div class="modal-footer"> <button rel="" data-status="" type="button" rel="" class="redeemPoints btn btn-primary change-button-confirm" data-dismiss="modal">Confirm</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="confirm-reedem-points-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
				<h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4> </div>
			<div class="modal-body">
				<p>Are you sure want to reedem  the points ? </p>
			</div>
			<div class="modal-footer"> <button rel="" data-status="" type="button" rel="" class="redeemPointsData btn btn-primary change-button-confirm" data-dismiss="modal">Confirm</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>