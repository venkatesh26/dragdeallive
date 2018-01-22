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
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.timepicker.css" media="screen"/>
<div class="business-add">
<h3 class="title-reg-business">Update Your Business</h3>
<h4 class="title-reg-req"> * fields are mandatory</h4>
<div class="register-business">
<form id="business_form_url" action="<?php echo base_url().'listings/add';?>" method="post">
	<div class="business-add-inner">
		<h3>Basic Information</h3>
	<div class="border-class">
			<div class="input">
				<input type="text" autocomplete="off"  name="name" placeholder="Busines Name *" value="<?php echo $businessName;?>"/>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="owner" placeholder="Contact Person *" value="<?php echo $ownerName;?>"/>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="email" placeholder="Email " value="<?php echo $email;?>"/>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="website" placeholder="Website" value="<?php echo $website;?>"/>
			</div>
			<div class="input">
			<input type="text" autocomplete="off"  name="contact_number" placeholder="Contact Number *" value="<?php echo $contactnumbers1;?>" />
			</div>
	</div>
	</div>
	<div class="business-add-inner">
		<h3>Contact Information</h3>
	<div class="border-class">
			<div class="input">
				<input type="text" placeholder="Door No and Street Name *" name="address_line" value="<?php echo $addressLine;?>"/>
			</div>
			<div class="input">
				<input type="text" id="city_autocomplete"  name="city" placeholder="City *" value="<?php echo $cityName;?>"/>
				<input type="hidden" id="add_city_id"  name="add_city_id" value="<?php echo $city_id;?>"/>
				
			</div>
			<div class="input">
				<input type="text" id="area_autocomplete"  name="area" placeholder="Area *"  value="<?php echo $areaName;?>"/>
				<input type="hidden" id="add_area_id"  name="add_area_id" value="<?php echo $area_id;?>"/>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="contact_number1" placeholder="Mobile Number1" value="<?php echo $contactnumbers2;?>"/>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="contact_number2" placeholder="Mobile Number2" value="<?php echo $contactnumbers3;?>"/>
			</div>	
	</div>
	</div>
	<div class="business-add-inner">
		<h3>About Your Business</h3>
	<div class="border-class">
	        <div class="input error-textarea">
				<textarea placeholder="Description" name="description"><?php echo $description;?></textarea>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="fax" placeholder="Fax Number"  value="<?php echo $fax;?>"/>
			</div>
			<div class="input">
				<input type="text" autocomplete="off"  name="zip" placeholder="Zip"  value="<?php echo $zip;?>"/>
			</div>
			<div class="two-input">
			<div class="input">
				<input type="text" name="working_start" id="start_time" placeholder="Working Start Time *"  value="<?php echo $working_start;?>"/>
			</div>	
			<div class="input">
				<input type="text" name="working_end" id="end_time" placeholder="Working End Time *"   value="<?php echo $working_end;?>"/>
			</div>	
			</div>
			<div class="submit">
				<input type="submit" name="submit" value="Submit" title="Submit" />
			</div>			
	</div>
	</div>
</form>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timepicker.js"></script>
<script>
$(document).ready(function()
{
    $('#start_time').timepicker();
	$('#end_time').timepicker();
	
	$("#city_autocomplete").on("keyup",function()
	{	
		$(this).autocomplete({
			source: __cfg('path_absolute')+'home/get_cities',
			select: function(event, ui) 
			{
					$('#add_city_id').val(ui.item.id);
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
	
	$("#area_autocomplete").on("keyup",function()
	{	
	    var city_id=$('#add_city_id').val();
		$(this).autocomplete({
			source: __cfg('path_absolute')+'home/get_areas?city_id='+city_id,
			select: function(event, ui) 
			{
					$('#add_city_id').val(ui.item.id);
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
});
</script>