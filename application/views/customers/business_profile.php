<style>
.box-label{
margin-left:30px;	
}
.red-box{
position:absolute;
background:red;
width:12px;
height:12px;
padding:10px;
margin:2px;	
}
.green-box{
position:absolute;
background:#85CE36;
width:12px;
height:12px;
padding:10px;
margin:2px;	
}
.clean {
    clear: both;
}

.dayContainer {
    float: left;
    line-height: 20px;
    margin-right: 8px;
    width: 65px;
    font-size: 11px;
    font-weight: bold;
}

.colorBox {
    cursor: pointer;
    height: 45px;
    border: 2px solid #888;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}

.colorBox.WorkingDayState {
    border: 2px solid #eee;
    background-color: #85CE36;
}

.colorBox.RestDayState {
    border: 2px solid #eee;
    background-color: #de5962;
}

.operationTime .mini-time {
    width: 40px;
    padding: 3px;
    font-size: 12px;
    font-weight: normal;
}

.dayContainer .add-on {
    padding: 4px 2px;
}

.colorBoxLabel {
    clear: both;
    font-size: 12px;
    font-weight: bold;
}

.invisible {
    visibility: hidden;
}

.operationTime {
    margin-top: 5px;
}
</style>
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
   $latitude=(isset($user_business_data['latitude']) && $user_business_data['latitude']!='') ? $user_business_data['latitude']:'';
   $longitude=(isset($user_business_data['longitude']) && $user_business_data['longitude']!='') ? $user_business_data['longitude']:'';
   if(!empty($user_business_data['image_dir']) && file_exists('../..'.$user_business_data['image_dir'].$user_business_data['profile_image']))
   {
      $img_src = thumb(FCPATH.$user_business_data['image_dir'].$user_business_data['profile_image'],'50','50','dashboard_thumb');
      $image = array('alt'=>url_title(strtolower($result['name'])),'src'=>base_url().$user_business_data['image_dir'].$user_business_data['profile_image'].'dashboard_thumb/'.$img_src);
   }
   else
   {
      $image = array('src'=>base_url().'assets/img/list_logo.png','alt'=>url_title(strtolower($user_business_data['name'])));
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
    
<article class="content cards-page white-bg-art" style="background:#fff">
	<div class="bread-crumb-data">
	   <?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <section class="section">
      <div class="col-xl-12">
	  
         <div class="card sameheight-item border-card-section">
            <div class="card-block">
			 
               <!-- Nav tabs -->
               <div class="card-title-block">
                  <h3 class="title">
                    <i class="fa fa-briefcase"></i> Bussiness Profile
                  </h3>
               </div>

               <!-- Tab panes -->
               <div class="tab-content tabs-bordered" data-addid="<?php echo $contactId;?>">
               <form id="business_form_url" action="<?php echo base_url().'listings/add';?>" method="Post">
			      <!------- Basic Informations --------->
				<div id="step1" class="tab-pane in fade active clearfix">
					<div class="box-content clearfix">
						<div class="controls col-md-12">
							<span class="mand_field_title">  * Fields are mandatory </span> </span>
						</div>
						<div class="control-group">
							<div class="controls">
						<div class="form-group col-md-3">
							<label class="control-label" for="name">Your Business Name <span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="name" name="name" value="<?php echo $businessName;?>" placeholder="Enter Your Business Name" autocomplete="off">
						</div>
						<div class="form-group col-md-3">
						<label class="control-label" for="owner">Contact Person/Owner <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="owner" name="owner" value="<?php echo $ownerName;?>" placeholder="Enter Contact Person" autocomplete="off">
						</div>

						<div class="form-group col-md-3">
						<label class="control-label" for="email">Email <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="email" name="email" value="<?php echo $email;?>" placeholder="Enter Business Email" autocomplete="off">
						</div>

						<div class="form-group col-md-3">
						<label class="control-label" for="contact_number">Conatct Number <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $contactnumbers1;?>" placeholder="Enter Contact Number" autocomplete="off">
						</div>
						 <div class="form-group col-md-3">
                           <label class="control-label" for="address_line">Address Line <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="address_line" name="address_line" value="<?php echo $addressLine;?>" placeholder="Enter Your Address">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="city_autocomplete">City <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="city_autocomplete" name="city" name="city_autocomplete" value="<?php echo $cityName;?>" autocomplete="off" placeholder="Select City">
                           <input type="hidden" class="form-control" id="add_city_id" name="add_city_id" name="add_city_id" value="<?php echo $city_id;?>">
                        </div>
						 <div class="form-group col-md-3">
                           <label class="control-label" for="area_autocomplete">Area <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="area_autocomplete" name="area" value="<?php echo $areaName;?>" autocomplete="off" placeholder="Select Area">
                           <input type="hidden" class="form-control" id="add_area_id" name="add_area_id" name="add_area_id" value="<?php echo $area_id;?>">
                        </div>
						 <div class="form-group col-md-3">
                           <label class="control-label" for="zip">Zip <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="zip" name="zip" value="<?php echo $zip;?>" placeholder="Enter Zip">
                        </div>
						<div class="form-group col-md-3">
						  <label class="control-label" for="maincategory_autocomplete">Category <span style="color:red;">*</span></label>
						  <input type="text" class="form-control" name="main_category" id="maincategory_autocomplete" value="<?php echo $main_category_name;?>" placeholder="Select Category">
						  <input type="hidden" class="form-control" name="main_category_id" id="main_category_id" value="<?php echo $main_category_id;?>">
						</div>

						<div class="form-group col-md-3">
						<label class="control-label" for="since">Since <span style="color:red;">* </span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">On which year did you start your business ?</span> </i></label>
						<input type="text" class="form-control" id="since"  name="since" value="<?php echo $since;?>" placeholder="Company Started Year" autocomplete="off">
						</div>
						<div class="form-group col-md-3">
						<label class="control-label" for="website">Website </label>
						<input type="text" class="form-control" id="website" name="website" value="<?php echo $website;?>" placeholder="Ex:http://www.google.com" autocomplete="off">
						</div>
						<div class="form-group col-md-3">
						<label class="control-label" for="contact_number1">Alt Contact No 1</label>
						<input type="text" class="form-control" id="contact_number1" name="contact_number1" value="<?php echo $contactnumbers1;?>" placeholder="Enter Alt. Contact Number" autocomplete="off">
						</div>
						<div class="form-group col-md-3">
						<label class="control-label" for="contact_number2">Alt Contact No 2</label>
						<input type="text" class="form-control" id="contact_number2"  name="contact_number2" value="<?php echo $contactnumbers2;?>" placeholder="Enter Alt. Contact Number" autocomplete="off">
						</div>
						<div class="form-group col-md-3">
						<label class="control-label" for="no_of_employees">Number Of Employees</label>
						<input type="text" class="form-control" id="no_of_employees"  name="no_of_employees" value="<?php echo $no_of_employees;?>" placeholder="Enter No Of Employees" autocomplete="off">
						</div>
						  <div class="form-group col-md-3">
                           <label class="control-label" for="zip">Latitude <span style="color:red;"></span></label>
                           <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $latitude;?>" placeholder="Enter Latitude">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="zip">Longitude <span style="color:red;"></span></label>
                           <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $longitude;?>" placeholder="Enter Longitude">
                        </div>
						
						<div class="form-group col-md-3">
						  <label class="control-label" for="profile_image">Profile Image <span style="color:red;">*</span></label>
						  <input type="file" class="form-control"  name="profile_image">
						</div>
						     <div class="form-group col-md-3">
                           <label class="control-label" for="fax">Fax </label>
                           <input type="text" class="form-control" id="fax" name="fax" value="<?php echo $fax;?>" placeholder="Enter Fax Number">
                        </div>
						    <div class="form-group col-md-3">
                           <label class="control-label" for="working_start">Work Start Time <span style="color:red;">*</span></label>
                           <input type="text" class="form-control mini-time form-control operationTimeFrom ui-timepicker-input" id="working_start" name="working_start" value="<?php echo $working_start;?>">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="working_end">Work End Time <span style="color:red;">*</span></label>
                           <input type="text" class="form-control mini-time form-control operationTimeFrom ui-timepicker-input" id="working_end" name="working_end" value="<?php echo $working_end;?>">
                        </div>
			
						</div>
						</div>
					</div>
			   <div class="box-content clearfix">   
					<div class="form-group col-md-12">
						<label class="control-label" for="tokenize">Keywords <span style="color:red;">*</span> <span style="font-size:10px;">(Note: Use Enter key to add mutltiple keywords)</span></label>
						<select class="tokenize-sample" multiple="multiple" name='keywords[]' id="tokenize">
						<?php echo $keywords_data; ?>
						</select>
                    </div>
					 <div class="control-group">
						 <div class="controls">
							<div class="form-group col-md-12">
								<label class="control-label" for="description">Description <span style="color:red;">*</span></label>
								<textarea class="form-control" id="description" rows="5" name="description"><?php echo $description;?></textarea>
							</div>
						 </div>
					 </div>
			
				</div>
		
	
			   <div class="box-content clearfix">   
           
					 <div class="control-group">
					 <div class="controls">
								<div class="form-group col-md-4">
									<label class="control-label" for="facebook_url">Facebook URL </label>
									<input type="text" class="form-control" id="facebook_url" name="facebook_url" name="facebook_url" value="<?php echo $facebook_url;?>" autocomplete="off" placeholder="Enter Facebook Url">
								</div>
								<div class="form-group col-md-4">
								<label class="control-label" for="googleplus_url">Google + URL</label>
								<input type="text" class="form-control" id="googleplus_url" name="googleplus_url" value="<?php echo $googleplus_url;?>" autocomplete="off" placeholder="Enter Google+ Url">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label" for="twitter_url">Twitter URL</label>
								<input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php echo $twitter_url;?>" placeholder="Enter Twitter Url">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label" for="linkedin_url">LinkedIn URL</label>
								<input type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="<?php echo $linkedin_url;?>" placeholder="Enter LinkedIn Url">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label" for="youtube_url">YouTube URL</label>
								<input type="text" class="form-control" id="youtube_url" name="youtube_url" value="<?php echo $youtube_url;?>" placeholder="Enter Youtube Url">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label" for="whatsup_contact_number">WhatsUp Contact Number</label>
								<input type="text" class="form-control" id="whatsup_contact_number" name="whatsup_contact_number" value="<?php echo $whatsup_contact_number;?>" placeholder="Enter Your Whatsup Contact Number">
							</div>
						 </div>
					
					 </div>
			    </div>
				   <!--<div class="box-content clearfix">   
						<div class="form-group col-md-12">
				
							<label class="control-label" for="service">Bussiness Hours</label>
							( <span class="red-box"></span><span class="box-label">- Closed </span>, <span class="green-box"></span> <span class="box-label"> - Opened)</span></span>
						</div>
			
						<div class="form-group col-md-12">
							<div id="businessHoursContainer">
							</div>
						</div>
					</div>-->

					   <div class="box-content clearfix">   
			
								 <div class="control-group">
								 
								 
							 <div class="controls">
							 <div class="form-group col-md-12">
										<label class="control-label" for="service">What type of services your company provided ? <span style="color:red;">* </span> <span style="font-size:10px;">(Note: Use Enter key to add mutltiple keywords)</span></label>
										<select class="tokenize-sample" multiple="multiple" name='service[]' id="service">
											<?php echo $service_data; ?>
										</select>
							
									</div>
							 </div>
							 </div>
							 <div class="sbmit_buttons cleafix">
								<button class="btn btn-primary btn-md pull-right profile-submit"> <?php echo $text;?></button>
					
							</div>
						</div>
				
				</div>
				
			   </form>
               </div>
            <!-- /.card-block -->
         </div>
		 </div>
         <!-- /.card -->
      </div>
	
   </section>
</article>
<?php echo $this->load->view('customers/bussiness_plan',array(),true);?>    
<script>
$(document).ready(function(){
	$('#service').tokenize({ datas: "customers/search_services"});
	$('#tokenize').tokenize({ datas: "customers/search_category"});	
	$('.operationTimeFrom, .operationTimeTill').timepicker({
	'timeFormat': 'H:i',
	'step': 15
	});
});
</script>

