<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-plus color-theme-1"></i> Add Customer</h2>
                <div class="box-icon">
                </div>
            </div>
			
			
			<div class="box-content clearfix">
					<div class="box-header well" data-original-title="">
						<h2><i class="glyphicon glyphicon-search color-theme-1"></i> Check User Avaibility</h2>
					</div>
					
									<div class="control-group">
					<div class="controls">
					<span style="color:red;float:left;">  * Fields are mandatory </span> </span>
					</div>
				</div>
				<div class="control-group">
				</div>
					<h2></h2>
					<form id="customer_check_info_url" action="<?php echo base_url().'customers/check_user_info';?>" method="post">
						<div class="control-group">
							<div class="controls">
								<div class="controls">
									<div class="form-group col-md-4">
										<label class="control-label" for="email">Email *</label>
										<input type="text" name="email" class="form-control" id="email">
									</div>
								</div>
							
								<div class="form-group col-md-4" style="margin-top:22px;">
									<button class="btn btn-primary btn-md clearfix"><i class="glyphicon glyphicon-search color-theme-1"></i> Check Avaibility</button>
									<a class="btn btn-primary btn-md" href="customer-list" style="margin-left:22px;">Cancel</a>
								</div>
							</div>
						</div>
					</form>
			</div>
			<div class="existingUserAdd" style="display:none;">
				 <form id="customer_update_form_url" action="<?php echo base_url().'customers/customer_update';?>" method="post">
				 
				 </form>
			</div>
		
		   <div class="newUserAdd">
			<form id="customer_form_url" action="<?php echo base_url().'customers/customer_add';?>" method="post">
            <div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-film color-theme-1"></i> Basic Information</h2>
				</div>
				<h2></h2>
				<input type="hidden" name="user_email" class="form-control" id="user_email">
                <div class="control-group">
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="mobile_number">Mobile Number *</label>
							<input type="text" name="mobile_number" class="form-control" id="mobile_number">
						</div>
					</div>
                    <div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="first_name">First Name *</label>
							<input type="text" name="first_name" class="form-control" id="first_name">
						</div>
					</div>
					<div class="controls">
					<div class="form-group col-md-3">
						<label class="control-label" for="last_name">Last Name </label>
						<input type="text" name="last_name" class="form-control" id="last_name">
                    </div>
					</div>
					 <div class="controls">
					<div class="form-group col-md-3">
						<label class="control-label" for="contact_numbers">Contact Number *</label>
						<input type="text" name="contact_number" class="form-control" id="contact_numbers">
                    </div>
					</div>
					<div class="controls">
						<div class="form-group col-md-3">
						      <label class="control-label" for="selectError">Select Gender *</label>
                        <select id="selectError" name="gender" class="common-select-box" style="width:100%;">
                            <option value="">Select Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
						</div>
                    </div>
                </div>
				<div class="control-group">
                   
					<div class="controls">
					<div class="form-group col-md-3">
						<label class="control-label" for="address"> Address </label>
						<input type="text" name="address" class="form-control" id="address">
                    </div>
					</div>
				
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="city_autocomplete">City </label>
							<input type="text" name="city" class="form-control" id="city_autocomplete" autocomplete="off">
							<input type="hidden" name="add_city_id" class="form-control" id="add_city_id">
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="area_autocomplete">Area </label>
							<input type="text" name="area" class="form-control" id="area_autocomplete" autocomplete="off">
								<input type="hidden" name="add_area_id" class="form-control" id="add_city_id">
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="zip">Zip</label>
							<input type="text" name="zip" class="form-control" id="zip" autocomplete="off">
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="group_autocomplete">Group </label>
							<input type="text" name="group_name" class="form-control" id="group_autocomplete" autocomplete="off">
								<input type="hidden" name="group_id" class="form-control" id="group_id">
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="last_bill_amount_paid">Bill Amount </label>
							<input type="number" name="last_bill_amount_paid" class="form-control" id="last_bill_amount_paid">
						</div>
					</div>
						<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="dob"> Date Of Birth </label>
							<input type="text" name="dob" class="form-control" id="dob" readonly>
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="doa"> Date Of Anversery </label>
							<input type="text" name="doa" class="form-control" id="doa" readonly>
						</div>
					</div>

					<div class="controls">
						<div class="form-group col-md-2">
						<label class="control-label" for="dob">Status </label>
						<br/>
							<input type="checkbox" name="is_active" id="is_active"  checked="checked" data-no-uniform="true" class="iphone-toggle">
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-2">
						<label class="control-label" for="is_birthday_remainder">Birthday Remainder</label>
						<br/>
							<input type="checkbox" name="is_birthday_remainder" id="is_birthday_remainder"  checked="checked" data-no-uniform="true" class="iphone-toggle">
						</div>
					</div>
					<div class="controls">
						<div class="form-group col-md-2">
						<label class="control-label" for="is_aniversy_reminder">Aniversy Remainder</label>
						<br/>
							<input type="checkbox" name="is_aniversy_reminder" id="is_aniversy_reminder"  checked="checked" data-no-uniform="true" class="iphone-toggle">
						</div>
					</div>
				</div>
            </div>
			<div class="box-content clearfix">
				<button class="btn btn-primary btn-lg pull-right">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-primary btn-lg pull-right" href="">Cancel</a>
				<br>
				<br>
            </div>	
			</form>
        
		   </div>
		</div>
    </div>
    <!--/span-->
</div><!--/row-->
<script src="<?php echo base_url();?>assets/customer/js/bootstrap-datepicker.min.js"></script>
<script>
$('#dob').datepicker({format: "yyyy-mm-dd"}); 
$('#doa').datepicker({format: "yyyy-mm-dd"});   
</script>