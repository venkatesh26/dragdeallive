<?php
$contactId=(isset($user_business_data['id']) && $user_business_data['id']!='') ? $user_business_data['id']:'';
$businessName=(isset($user_business_data['name']) && $user_business_data['name']!='') ? $user_business_data['name']:'';
$ownerName=(isset($user_business_data['owner']) && $user_business_data['owner']!='') ? $user_business_data['owner']:'';
$email=(isset($user_business_data['email']) && $user_business_data['email']!='') ? $user_business_data['email']:'';
$addressLine=(isset($user_business_data['email']) && $user_business_data['address_line']!='') ? $user_business_data['address_line']:'';
$zip=(isset($user_business_data['zip']) && $user_business_data['zip']!='') ? $user_business_data['zip']:'';
$description=(isset($user_business_data['description']) && $user_business_data['description']!='') ? $user_business_data['description']:'';
$website=(isset($user_business_data['website']) && $user_business_data['website']!='') ? $user_business_data['website']:'';
$city_id=(isset($user_business_data['city_id']) && $user_business_data['city_id']!='') ? $user_business_data['city_id']:'';
$cityName=(isset($user_business_data['city_name']) && $user_business_data['city_name']!='') ? $user_business_data['city_name']:'';
$areaName=(isset($user_business_data['area_name']) && $user_business_data['area_name']!='') ? $user_business_data['area_name']:'';
$area_id=(isset($user_business_data['area_id']) && $user_business_data['area_id']!='') ? $user_business_data['area_id']:'';
$fax=(isset($user_business_data['fax']) && $user_business_data['fax']!=0) ? $user_business_data['fax']:'';
$working_start=(isset($user_business_data['working_start']) && $user_business_data['working_start']!='') ? $user_business_data['working_start']:'';
$working_end=(isset($user_business_data['working_end']) && $user_business_data['working_end']!='') ? $user_business_data['working_end']:'';
$contact_numbers=(isset($user_business_data['contact_number']) && $user_business_data['contact_number']!='') ? $user_business_data['contact_number']:'';
$contactnumbers=explode(',',$contact_numbers);
$contactnumbers1=(isset($contactnumbers[0])) ? $contactnumbers[0]:'';
$contactnumbers2=(isset($contactnumbers[1])) ? $contactnumbers[1]:'';
$contactnumbers3=(isset($contactnumbers[2])) ? $contactnumbers[2]:'';
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-briefcase color-theme-1"></i> Blog Add</h2>
                <div class="box-icon">
                </div>
            </div>
			<form id="business_form_url" action="<?php echo base_url().'listings/add';?>">
            <div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-film color-theme-1"></i> Basic Information</h2>
				</div>
				<h2></h2>
                <div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="name">Blog Name *</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $businessName;?>">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="owner">Author *</label>
						<input type="text" class="form-control" id="owner" name="owner" value="<?php echo $ownerName;?>">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="email">Blog Category*</label>
						<input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>">
                    </div>
					</div>
                </div>
				<div class="control-group clearfix">
				  <div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-12">
						<label class="control-label" for="description">Short Description *</label>
						<textarea class="form-control" id="description" rows="10" name="description"><?php echo $description;?></textarea>
                    </div>
					</div>
					<br>
                </div>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
            </div>
			<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-phone color-theme-1"></i> Seo Information</h2>
				</div>
				<h2></h2>
                <div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="city_autocomplete">Meta Keywords *</label>
						<input type="text" class="form-control" id="city_autocomplete" name="city" name="city_autocomplete" value="<?php echo $cityName;?>">
						<input type="hidden" class="form-control" id="add_city_id" name="add_city_id" name="add_city_id" value="<?php echo $city_id;?>">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-8">
						<label class="control-label" for="area_autocomplete">Meta Description *</label>
						<input type="text" class="form-control" id="area_autocomplete" name="area" value="<?php echo $areaName;?>">
						<input type="hidden" class="form-control" id="add_area_id" name="add_area_id" name="add_area_id" value="<?php echo $area_id;?>">
                    </div>
					</div>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
            </div>
			<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-bullhorn color-theme-1"></i> Write Blog Description</h2>
				</div>
				<h2></h2>
                <div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-12">
						<label class="control-label" for="description">Description *</label>
						<textarea class="form-control" id="description" rows="10" name="description"><?php echo $description;?></textarea>
                    </div>
					</div>
					<br>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
					<button class="btn btn-primary btn-lg pull-right">Submit</button>
				<br>
				<br>
				<br><br>
            </div>
			</form>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->
<script>
$(document).ready(function(){
	$('#working_start').timepicker();
	$('#working_end').timepicker();
});
</script>