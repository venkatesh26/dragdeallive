<script type="text/javascript" src="<?php echo base_url();?>assets/js/tabcordion.js"></script>
<div class="tabcordion">
  <ul class="nav nav-tabs">
    <li class="active"><a data-target=".home">Home</a></li>
    <li><a data-target=".profile">Profile</a></li>
    <li><a data-target=".messages">Messages</a></li>
    <li><a data-target=".settings">Settings</a></li>
  </ul>
  <div class="tab-content">
    <div class="home active in">
      <h3>Home</h3>
      <p>Rhoncus magna nec enim, et proin aliquet mid, porta magnis.</p>
    </div>
    <div class="profile">
      <h3>Profile</h3>
      <p>Odio mattis, non ut! Porttitor nunc phasellus cras elementum.</p>
    </div>
    <div class="messages">
      <h3>Messages</h3>
      <p>Enim hac tristique elementum, nec rhoncus porttitor sagittis cum.</p>
    </div>
    <div class="settings">
      <h4>Settings</h4>
      <p>Arcu auctor, porttitor tincidunt, aliquam ut ut, placerat porta pulvinar dictumst?</p>
    </div>
  </div>
</div>

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
<div class="business-add">
<h3 class="title-reg-business">Add Your Customers</h3>
<h4 class="title-reg-req"> * fields are mandatory</h4>
<div class="register-business">
<form id="business_form_url" action="<?php echo base_url().'listings/add_customer';?>" method="post">
	<div class="business-add-inner">
		<h3>Basic Information</h3>
		<div class="border-class">
				<div class="input">
					<input type="text" autocomplete="off"  name="name" placeholder="Customer Name *" value="<?php echo $businessName;?>"/>
				</div>
				<div class="input">
					<input type="text" autocomplete="off"  name="email" placeholder="Email *" value="<?php echo $email;?>"/>
				</div>
				<div class="input">
				<input type="text" autocomplete="off"  name="contact_number" placeholder="Contact Number *" value="<?php echo $contactnumbers1;?>" />
				</div>
				<div class="input">
				<input type="text" autocomplete="off"  name="dob" placeholder="Date Of Birth " value="<?php echo $contactnumbers1;?>" />
				</div>
				<div class="input">
					<input type="text" autocomplete="off"  name="website" placeholder="Website" value="<?php echo $website;?>"/>
				</div>
		</div>
	</div>
	<div class="business-add-inner">
		<h3>Contact Information</h3>
	<div class="border-class">
			<div class="input">
				<input type="text" placeholder="Door No and Street Name " name="address" value="<?php echo $addressLine;?>"/>
			</div>
			<div class="input">
				<input type="text" id="city_autocomplete"  name="city" placeholder="City " value="<?php echo $cityName;?>"/>
				<input type="hidden" id="add_city_id"  name="add_city_id" value="<?php echo $city_id;?>"/>
				
			</div>
			<div class="input">
				<input type="text" id="area_autocomplete"  name="area" placeholder="Area "  value="<?php echo $areaName;?>"/>
				<input type="hidden" id="add_area_id"  name="add_area_id" value="<?php echo $area_id;?>"/>
			</div>
<div class="submit">
				<input type="submit" name="submit" value="Submit" title="Submit" />
			</div>						
	</div>
	</div>
</form>
</div>
</div>
<script>
$(document).ready(function()
{
	$('.tabcordion').tabcordion();
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