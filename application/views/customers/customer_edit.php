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
						   <div><i class="fa fa-question-circle tooltipdiv cursor"></i> If you do not have any service remainders ? Please <a target="_blank" href="<?php echo base_url().'remainders/add';?>">Click Here </a> to add reaminders.</div>
                           <?php if($total_bill_amount > 0):?>
                           <div class="box-content clearfix" >
                              <div class="box-header well" data-original-title="">
								 <div class="title-block">
                        <h3 class="title">
                           <i class="fa fa-list-alt"></i> Last Billing Information
                        </h3>
                     </div>
					    <div class="controls">
                                 <div class="form-group col-md-6">
                                    <label class="control-label" for="first_name">Last Bill Amount : <b style="color:green;"><?php echo number_format($last_bill_amount);?></b></label>
                                 </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label" for="first_name">Total Bill Amount : <b style="color:green;"><?php echo number_format($total_bill_amount);?></b></label>
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
   $(document).ready(function(){	
   
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
   });	
</script>