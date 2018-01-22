<style>
.tab-panel {
    display: none;
}
.tab-panel.active{
    display: block;
}
</style>
<script type="text/javascript" src="http://localhost/new_dialbe/assets/customer/js/jquery.tokenize.js"></script>
<script src="http://localhost/new_dialbe/assets/customer/js/bootstrap-timepicker.min.js"></script>
<script src="http://localhost/indiabe/assets/customer/js/loadingoverlay.min.js"></script>
<?php
$contactId=(isset($user_business_data['id']) && $user_business_data['id']!='') ? $user_business_data['id']:'';
$businessName=(isset($user_business_data['name']) && $user_business_data['name']!='') ? $user_business_data['name']:'';
$ownerName=(isset($user_business_data['owner']) && $user_business_data['owner']!='') ? $user_business_data['owner']:'';
$email=(isset($user_business_data['email']) && $user_business_data['email']!='') ? $user_business_data['email']:'';
$addressLine=(isset($user_business_data['email']) && $user_business_data['address_line']!='') ? $user_business_data['address_line']:'';
$zip=(isset($user_business_data['zip']) && $user_business_data['zip']!='') ? $user_business_data['zip']:'';
$description=(isset($user_business_data['description']) && $user_business_data['description']!='') ? $user_business_data['description']:'';
$short_description=(isset($user_business_data['short_description']) && $user_business_data['short_description']!='') ? $user_business_data['short_description']:'';
$website=(isset($user_business_data['website']) && $user_business_data['website']!='') ? $user_business_data['website']:'';
$city_id=(isset($user_business_data['city_id']) && $user_business_data['city_id']!='') ? $user_business_data['city_id']:'';
$cityName=(isset($user_business_data['city_name']) && $user_business_data['city_name']!='') ? $user_business_data['city_name']:'';
$areaName=(isset($user_business_data['area_name']) && $user_business_data['area_name']!='') ? $user_business_data['area_name']:'';
$area_id=(isset($user_business_data['area_id']) && $user_business_data['area_id']!='') ? $user_business_data['area_id']:'';
$fax=(isset($user_business_data['fax']) && $user_business_data['fax']!=0) ? $user_business_data['fax']:'';
$working_start=(isset($user_business_data['working_start']) && $user_business_data['working_start']!='') ? $user_business_data['working_start']:'';
$working_end=(isset($user_business_data['working_end']) && $user_business_data['working_end']!='') ? $user_business_data['working_end']:'';
$contact_numbers=(isset($user_business_data['contact_number']) && $user_business_data['contact_number']!='') ? $user_business_data['contact_number']:'';
$main_category_id=(isset($user_business_data['main_category_id']) && $user_business_data['main_category_id']!='') ? $user_business_data['main_category_id']:'';
$since=(isset($user_business_data['since']) && $user_business_data['since']!='') ? $user_business_data['since']:'';
$no_of_employees=(isset($user_business_data['no_of_employees']) && $user_business_data['no_of_employees']!='') ? $user_business_data['no_of_employees']:'';
$contactnumbers=explode(',',$contact_numbers);
$contactnumbers1=(isset($contactnumbers[0])) ? $contactnumbers[0]:'';
$contactnumbers2=(isset($contactnumbers[1])) ? $contactnumbers[1]:'';
$contactnumbers3=(isset($contactnumbers[2])) ? $contactnumbers[2]:'';
if(!empty($user_business_data['image_dir']) && file_exists('../..'.$user_business_data['image_dir'].$user_business_data['profile_image']))
{
   $img_src = thumb(FCPATH.$user_business_data['image_dir'].$user_business_data['profile_image'],'50','50','dashboard_thumb');
   $image = array('alt'=>url_title(strtolower($result['name'])),'src'=>base_url().$user_business_data['image_dir'].$user_business_data['profile_image'].'dashboard_thumb/'.$img_src);
}
else
{
   //$image = array('src'=>base_url().'assets/img/list_logo.png','alt'=>url_title(strtolower($user_business_data['name'])));
}
$main_category_name='';
if($main_category_id!='' && $main_category_id!=0){
	$main_category_name=get_category_name($main_category_id);
}
$isActive=(isset($user_business_data['is_active']) && $user_business_data['is_active']==1) ? $user_business_data['is_active']:0;
$planId=(isset($user_business_data['plan_id']) && $user_business_data['plan_id']!='') ? $user_business_data['plan_id']:0;
$meta_keywords=(isset($user_business_data['meta_keywords']) && $user_business_data['meta_keywords']!='') ? $user_business_data['meta_keywords']:'';
$meta_description=(isset($user_business_data['meta_description']) && $user_business_data['meta_description']!='') ? $user_business_data['meta_description']:'';
$social_media = @unserialize($user_business_data['other_info']);
$facebook_url=(isset($social_media['facebook_url']) && $social_media['facebook_url']!='') ? $social_media['facebook_url'] : '';
$googleplus_url=(isset($social_media['googleplus_url']) && $social_media['googleplus_url']!='') ? $social_media['googleplus_url'] : '';
$twitter_url=(isset($social_media['twitter_url']) && $social_media['twitter_url']!='') ? $social_media['twitter_url'] : '';
$linkedin_url=(isset($social_media['linkedin_url']) && $social_media['linkedin_url']!='') ? $social_media['linkedin_url'] : '';
$youtube_url=(isset($social_media['youtube_url']) && $social_media['youtube_url']!='') ? $social_media['youtube_url'] : '';
$whatsup_contact_number=(isset($social_media['whatsup_contact_number']) && $social_media['whatsup_contact_number']!='') ? $social_media['whatsup_contact_number'] : '';
$notification_settings = @unserialize($user_business_data['notification_settings']);
$custom_meta=(isset($notification_settings['custom_meta']) && $notification_settings['custom_meta']==1) ? "checked=checked":'';
$social_media=(isset($notification_settings['social_media']) && $notification_settings['social_media']==1) ? "checked=checked":'';
$enquiry_via_mail=(isset($notification_settings['enquiry_via_mail']) && $notification_settings['enquiry_via_mail']==1) ? "checked=checked":'';
$monthly_analytics=(isset($notification_settings['monthly_analytics']) && $notification_settings['monthly_analytics']==1) ? "checked=checked":'';
$text="Save and Continue";
if($contactId!='' && $contactId!=0) $text="Update";
?>

<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-fire"></i>
	      				<h3>Advertisments - Edit</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div>
							<ul class="nav nav-tabs profile-tab" id="tabs">
								<li><a href="#tabs-1" data-step-complete="1" class='step1' rel="1"><i class="glyphicon glyphicon-film"></i> Basic Information</a></li>
								<li><a href="#tabs-2" data-step-complete="<?php echo ($contactId!='' && $contactId!=0) ? 1:0;?>" class='step2' rel="2"><i class="glyphicon glyphicon-phone"></i> Contact Information</a></li>
								<li><a href="#tabs-3" data-step-complete="<?php echo ($contactId!='' && $contactId!=0) ? 1:0;?>" class='step3' rel="3"><i class="glyphicon glyphicon-bullhorn"></i> About</a></li>
								<li><a href="#tabs-4" data-step-complete="<?php echo ($contactId!='' && $contactId!=0) ? 1:0;?>" class='step4' rel="4"><i class="fa fa-link"></i> Socialmedia Settings</a></li>
								<li><a href="#tabs-5" data-step-complete="<?php echo ($contactId!='' && $contactId!=0) ? 1:0;?>" class='step5' rel="5"><i class="glyphicon glyphicon-tags"></i> SEO Settings</a></li>
								<li><a href="#tabs-7" data-step-complete="<?php echo ($contactId!='' && $contactId!=0) ? 1:0;?>" class='step7' rel="7"><i class="fa fa-cog"></i> Settings</a></li>
							</ul>
						</div>
					
						<div class="tabbable">
						<!------- Basic Informations --------->
						<div class="tab-pane" id="formcontrols">
						
				<form id="business_form_url" action="<?php echo base_url().ADMIN.'/advertisements/admin_add_or_update/'.$advertimentsId;?>" method="Post">
						
			<div id="tabs-1" class="tab-pane tab-panel active clearfix">
			    <div class="box-content clearfix">
				  <div class="widget-header" style="padding-left:10px;" >Set Your Bussiness Profile</div>
				<div class="control-group">
					<div class="controls">
					<span style="color:red;float:right;">  * Fields are mandatory </span> </span>
					</div>
				</div>
				
                <div class="control-group">
					
                    <div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="name">Your Business Name <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo $businessName;?>" placeholder="Enter Your Business Name" autocomplete="off">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="owner">Contact Person/Owner <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="owner" name="owner" value="<?php echo $ownerName;?>" placeholder="Enter Contact Person" autocomplete="off">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="email">Email <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" placeholder="Enter Business Email" autocomplete="off">
                    </div>
					</div>
                </div>
				<div class="control-group clearfix">
                   
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="contact_number">Conatct Number <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $contactnumbers1;?>" placeholder="Enter Your Contact Number" autocomplete="off">
                    </div>
					</div>
					<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="since">Since <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="since"  name="since" value="<?php echo $since;?>" placeholder="Company Started Year" autocomplete="off">
						</div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="website">Website </label>
						<input type="text" class="form-control" id="website" name="website" value="<?php echo $website;?>" placeholder="Ex:http://www.google.com" autocomplete="off">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="contact_number1">Alt Contact No 1</label>
						<input type="text" class="form-control" id="contact_number1" name="contact_number1" value="<?php echo $contactnumbers1;?>" placeholder="Enter Alt. Contact Number" autocomplete="off">
                    </div>
					</div>
					<div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="contact_number2">Alt Contact No 2</label>
						<input type="text" class="form-control" id="contact_number2"  name="contact_number2" value="<?php echo $contactnumbers2;?>" placeholder="Enter Alt. Contact Number" autocomplete="off">
                    </div>
					</div>
					
					<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="no_of_employees">Number Of Employees</label>
							<input type="text" class="form-control" id="no_of_employees"  name="no_of_employees" value="<?php echo $no_of_employees;?>" placeholder="Enter No Of Emmployees" autocomplete="off">
						</div>
					</div>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
				<div class="sbmit_buttons">
					<button class="btn btn-primary btn-lg pull-right profile-submit"> <?php echo $text;?></button>
				</div>
            </div>
			</div>
			<div id="tabs-2" class="tab-pane tab-panel">
				  <div class="box-content clearfix">
					<div class="widget-header" style="padding-left:10px;" >Set Businnes Contact Information</div>
					<div class="control-group">
						<div class="controls">
						<span style="color:red;float:right;">  * Fields are mandatory </span> </span>
						</div>
					</div>
					<h2></h2>
					<div class="control-group">
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="address_line">Address Line <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="address_line" name="address_line" value="<?php echo $addressLine;?>" placeholder="Enter Your Address">
						</div>
						</div>
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="city_autocomplete">City <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="city_autocomplete" name="city" name="city_autocomplete" value="<?php echo $cityName;?>" autocomplete="off" placeholder="Select City">
							<input type="hidden" class="form-control" id="add_city_id" name="add_city_id" name="add_city_id" value="<?php echo $city_id;?>">
						</div>
						</div>
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="area_autocomplete">Area <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="area_autocomplete" name="area" value="<?php echo $areaName;?>" autocomplete="off" placeholder="Select Area">
							<input type="hidden" class="form-control" id="add_area_id" name="add_area_id" name="add_area_id" value="<?php echo $area_id;?>">
						</div>
						</div>
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="zip">Zip <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="zip" name="zip" value="<?php echo $zip;?>" placeholder="Enter Zip">
						</div>
						</div>
					</div>
					<div class="control-group">
						
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="fax">Fax </label>
							<input type="text" class="form-control" id="fax" name="fax" value="<?php echo $fax;?>" placeholder="Enter Fax Number">
						</div>
						</div>
						
						<div class="controls">
						<div class="form-group col-md-2">
							<label class="control-label" for="working_start">Work Start Time <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="working_start" name="working_start" value="<?php echo $working_start;?>"  readonly="readonly">
						</div>
							<div class="form-group col-md-2">
							<label class="control-label" for="working_end">Work End Time <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="working_end" name="working_end" value="<?php echo $working_end;?>" readonly="readonly">
						</div>
						</div>
					</div>
					 <div class="">
                    <label>
                    </label>
                </div>
					<div class="sbmit_buttons">
					
						<button class="btn btn-primary btn-lg pull-right profile-submit"> <?php echo $text;?></button>
						<a class="btn btn-primary btn-lg pull-right profile-submit previous-button" data-step-complete="1">Previous</a>
					</div>
				</div>
			</div>
			
				<!--------- Contact Infortmations ----->
			
			
			
            <!----- About Your Bussiness----------->
			<div id="tabs-3" class="tab-pane tab-panel">	
				<div class="box-content clearfix">
					<div class="widget-header" style="padding-left:10px;" >About Your Bussiness</div>
					<h2></h2>
										<div class="controls">
					<span style="color:red;float:right;">  * Fields are mandatory </span> </span>
					</div>
					
					<div class="control-group">
						<div class="controls">
						<div class="form-group col-md-12">
							<label class="control-label" for="description">Short Description <span style="color:red;">*</span></label>
							<textarea class="form-control" id="description"  rows="10" name="short_description" maxlength="500" style="width:900px;"><?php echo $short_description;?></textarea>
						</div>
						</div>
						<br>
					</div>
					 <div class="control-group">
						<div class="controls">
						<div class="form-group col-md-12">
							<label class="control-label" for="description">Description <span style="color:red;">*</span></label>
							<textarea class="form-control" id="description" rows="10" name="description" style="width:900px;"><?php echo $description;?></textarea>
						</div>
						</div>
						<br>
					</div>
						<div class="">
					<label>
					</label>
				</div>
				<div class="sbmit_buttons">
					<button class="btn btn-primary btn-lg pull-right profile-submit"> <?php echo $text;?></button>
					<a class="btn btn-primary btn-lg pull-right profile-submit previous-button" data-step-complete="2">Previous</a>
				</div>
				</div>
			</div>
			
			
				<!--------- Social Media Settings ----->
			<div id="tabs-4" class="tab-pane tab-panel">
				  <div class="box-content clearfix">
					<div class="box-header well" data-original-title="">
						<h2><i class="glyphicon glyphicon-phone color-theme-1"></i> Social Media Settings</h2>
					</div>
					<div class="control-group">
						<div class="controls">
						<span style="color:red;float:right;">  * Fields are mandatory </span> </span>
						</div>
					</div>
					<h2></h2>
					<div class="control-group">
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="facebook_url">Facebook URL </label>
							<input type="text" class="form-control" id="facebook_url" name="facebook_url" name="facebook_url" value="<?php echo $facebook_url;?>" autocomplete="off" placeholder="Enter Facebook Url">
						</div>
						</div>
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="googleplus_url">Google + URL</label>
							<input type="text" class="form-control" id="googleplus_url" name="googleplus_url" value="<?php echo $googleplus_url;?>" autocomplete="off" placeholder="Enter Google+ Url">
						</div>
						</div>
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="twitter_url">Twitter URL</label>
							<input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php echo $twitter_url;?>" placeholder="Enter Twitter Url">
						</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="linkedin_url">LinkedIn URL</label>
							<input type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="<?php echo $linkedin_url;?>" placeholder="Enter LinkedIn Url">
						</div>
						</div>
						<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="youtube_url">YouTube URL</label>
							<input type="text" class="form-control" id="youtube_url" name="youtube_url" value="<?php echo $youtube_url;?>" placeholder="Enter Youtube Url">
						</div>
						</div>
							<div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="whatsup_contact_number">WhatsUp Contact Number</label>
							<input type="text" class="form-control" id="whatsup_contact_number" name="whatsup_contact_number" value="<?php echo $whatsup_contact_number;?>" placeholder="Enter Your Whatsup Contact Number">
						</div>
						</div>
					</div>
					 <div class="">
                    <label>
                    </label>
                </div>
					<div class="sbmit_buttons">
						<button class="btn btn-primary btn-lg pull-right profile-submit"> <?php echo $text;?></button>
						<a class="btn btn-primary btn-lg pull-right profile-submit previous-button" data-step-complete="3">Previous</a>	
					</div>
				</div>
			</div>
			
			<!------- SEO Settings ------>
			<div id="tabs-5" class="tab-pane tab-panel">
			  	<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-list"></i> SEO Settings</h2>
				</div>
				
				<div class="control-group">
					<div class="controls">
					<span style="color:red;float:right;">  * Fields are mandatory </span> </span>
					</div>
				</div>
				<h2></h2>
                <div class="control-group"> 
                    <div class="controls">
					<div class="form-group col-md-12">
						<label class="control-label" for="tokenize">Keywords <span style="color:red;">*</span></label>
						<select class="tokenize-sample" multiple="multiple" name='keywords[]' id="tokenize">
						<?php echo $keywords_data; ?>
						</select>
			
                    </div>
					</div>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
				<div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="maincategory_autocomplete">Main Category <span style="color:red;">*</span></label>
						<input type="text" class="form-control" name="main_category" id="maincategory_autocomplete" value="<?php echo $main_category_name;?>" placeholder="Select Main Category">
						<input type="hidden" class="form-control" name="main_category_id" id="main_category_id" value="<?php echo $main_category_id;?>">
                    </div>
					</div>
                </div>
				<div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="profile_image">Profile Image <span style="color:red;">*</span></label>
						<input type="file" class="form-control"  name="profile_image">
                    </div>
					</div>
                </div>
				<div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-4">
						<label class="control-label" for="profile_image">Preview Image</label>
						<div class="cleafix">
						   <?php 
						   if(!empty($user_business_data['profile_image']) && file_exists('./'.$user_business_data['image_dir'].$user_business_data['profile_image']))
							{
							   $img_src = thumb(FCPATH.$user_business_data['image_dir'].$user_business_data['profile_image'],'218','159','list_thumb');
							   $image = base_url().$user_business_data['image_dir'].'list_thumb/'.$img_src;
							   echo '<img width="218" height="150" src="'.$image.'" class="entry-thumb td-animation-stack-type0-2">';
							}
							?>
						</div>
                    </div>
					</div>
                </div>
						 <div class="control-group">
						<div class="controls">
						<div class="form-group col-md-6">
							<label class="control-label" for="meta_keywords">Meta Keywords</label>
							<textarea class="form-control" id="meta_keywords" rows="6" name="meta_keywords"><?php echo $meta_keywords;?></textarea>
						</div>
							<div class="form-group col-md-6">
							<label class="control-label" for="meta_description">Meta Description</label>
							<textarea class="form-control" id="meta_description" rows="6" name="meta_description"><?php echo $meta_description;?></textarea>
						</div>
						</div>
						<br>
					</div>
				<div class="">
					<label>
					</label>
				</div>
				<div class="sbmit_buttons">
						<button class="btn btn-primary btn-lg pull-right profile-submit"> <?php echo $text;?></button>
						<a class="btn btn-primary btn-lg pull-right profile-submit previous-button" data-step-complete="4">Previous</a>	
				</div>
            </div>
			</div>
			
			
					
			<!------- SEO Settings ------>
			<div id="tabs-7" class="tab-pane tab-panel">
			  	<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="fa fa-cog"></i> Settings</h2>
				</div>
				
				<div class="control-group">
					<div class="controls">
					<span style="color:red;float:right;">  * Fields are mandatory </span> </span>
					</div>
				</div>
				<h2></h2>
                <div class="control-group"> 
                    <div class="controls">
					<div class="form-group col-md-12">
						<div class="checkbox">
								<label>
									<input type="checkbox" name="custom_meta" <?php echo $custom_meta;?>>
									Enable Custom Meta And Descriptions.
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="social_media" <?php echo $social_media;?>>
									Enable Social Media Contacts.
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="enquiry_via_mail" <?php echo $enquiry_via_mail;?>>
									Enable Enquiry Notification Via Email.
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="monthly_analytics" <?php echo $monthly_analytics;?>>
									Enable Monthly Analytics Notification Via Email.
								</label>
							</div>
                    </div>
					</div>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
				<div class="">
					<label>
					</label>
				</div>
				<div class="sbmit_buttons">
					<button class="btn btn-primary btn-lg pull-right profile-submit">Update</button>
					<a class="btn btn-primary btn-lg pull-right profile-submit previous-button" data-step-complete="6">Previous</a>
				</div>
            </div>
			</div>	
						
						</form>
							
					
							</div>
						</div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
		    </div> <!-- /span8 -->
	      </div> <!-- /row -->	
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->

<script>

$(document).ready(function(){
	$('#tokenize').tokenize({ datas: "customers/search_category"});
	$('#working_start').timepicker();
	$('#working_end').timepicker();
});
</script>

<script>
  $('#tabs a:first').tab('show');
    $('#tabs a').click(function (e) {
        e.preventDefault();
		var step_compelete=$(this).attr('data-step-complete');
		if(step_compelete==1){
			$(this).tab('show');
		}else{
			alert_notification('error','<i class="fa fa-info-circle"></i> Please Complete the Fields');
		}
    });
	
</script>
<script>
$(document).ready(function(){
	$('#service').tokenize({ datas: "customers/search_services"});
	$('#tokenize').tokenize({ datas: "customers/search_category"});
	$('#working_start').timepicker();
	$('#working_end').timepicker();
	$('.js_plan_change input').change(function(){
		var plan_description=$(this).parent('div').find('p.plan_details').attr('data-description');
		var plan_name=$(this).parent('div').find('p.plan_details').attr('data-title');
		var plan_validatity=$(this).parent('div').find('p.plan_details').attr('data-plan_validity_days');
		var plan_price=$(this).parent('div').find('p.plan_details').attr('data-price');
		$('.plan_name').html(plan_name);
		$('.plan_descritption').html(plan_description);
		$('.plan_validatity').html(plan_validatity);
		$('.plan_price').html(plan_price);
	});
	
    $(document).on("click",".js-package-purchase", function(e) {
		  var new_url="<?php echo base_url();?>"+'customers/buyPackage';
		  $.ajax({
				type: 'POST',
				async: false,
				url: new_url,
				dataType:'json',
				data:{'title':$(this).data('title'),'package_id':$(this).attr('rel'),'package_desc':$(this).data('description'),'package_amount':$(this).data('amount')},
				success: function (json) {
					if(json.status==1) {
						window.location.href = json.url;	
					}
				}
		  });
    });
	
				
	$('#business_form_url').livequery('submit',function() {
		
		$('.profile-submit').attr('disabled',true);
		$.LoadingOverlay("show");
		var url=$("#business_form_url").attr('action');
		alert(url);
		var $this=$(this);	 
		var form = $('#business_form_url')[0]; 
        var formData = new FormData(form);
		formData.append('image', $('input[type=file]')[0].files[0]);
		var step=$('#tabs li.active').find('a').attr('rel');		
		formData.append('step',step);
		$.ajax({
			type: "POST",
			url: url,
			data:formData,
			datatype:"json",
			contentType: false,
            processData: false,
			success: function(data)
			{
				$.LoadingOverlay("hide");
				$('.profile-submit').attr('disabled',false);
				var data=jQuery.parseJSON(data);
				if(data.status=="error" || data.all_stepcomplete==0 || data.all_stepcomplete==false) 
				{
					if(typeof data.step!='undefined'){
						
						$('#tabs li').find('a.step'+data.step).attr('data-step-complete','1');
						var el=$('#tabs a.step'+data.step);  
						$(el).trigger('click');
					}
					$("#business_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else
					{
						
						$("#business_form_url input").each(function() {
							$(this).next('span').remove();
					    });
						$("#business_form_url select").each(function() {
							$(this).next('span').remove();
					    });
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','<i class="fa fa-info-circle"></i> Please Complete the required fields.');
					}
				}
				else
				{
					$("#business_form_url input,select,textarea").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
					$('.profile_preview').show();
					if(step==6){
						$('#tabs li').find('a').attr('data-step-complete','1');
						var el=$('#tabs a.step7');  
						$(el).trigger('click');	
					}
				}				
			}
		});
		return false;
	});
	
});
</script>