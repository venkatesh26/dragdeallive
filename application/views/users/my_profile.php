<?php
   $first_name=(isset($user_data['first_name']))?$user_data['first_name']:'';
   $last_name=(isset($user_data['last_name']))?$user_data['last_name']:'';
   $email=(isset($user_data['email']))?$user_data['email']:'';
   $mobile_number=(isset($user_data['mobile_number']))?$user_data['mobile_number']:'';
   $address=(isset($user_data['address']))?$user_data['address']:'';
   $dob=(isset($user_data['dob']))?$user_data['dob']:'';
   if($dob=='0000-00-00'){
	 $dob='';
   }
   $city_name=(isset($user_data['city_name']))?$user_data['city_name']:'';
   $area_name=(isset($user_data['area_name']))?$user_data['area_name']:'';
   $gender=(isset($user_data['gender_id']))?$user_data['gender_id']:'';
   $senderid1=(isset($user_data['sender_id1']))?$user_data['sender_id1']:'';
   $senderid2=(isset($user_data['sender_id2']))?$user_data['sender_id2']:'';
   ?>
<article class="content profile-page">
<div class="white-bg">
   <div class="title-block">
      <h3 class="title">
         <i class="fa fa-user"></i> My Profile <span class="sparkline bar" data-type="bar"></span>
      </h3>
   </div>
   <div class="col-md-12">
      <div class="card card-block">
         <div class="title-block">
            <h3 class="title">
               <i class="fa fa-bullhorn"></i> Basic Information
            </h3>
         </div>
         <form id="new_profile_form_url" action="<?php echo base_url().'users/my_profile';?>" method="post">
            <div class="control-group">
               <div class="controls">
                  <div class="form-group col-md-3">
                     <div class="form-group has-success">
                        <label class="control-label" for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo $first_name;?>"> 
                     </div>
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="last_name">Last Name <span class="required">*</span></label>
                     <input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo $last_name;?>">
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="email">Email <span class="required">*</span></label>
					 <?php if($email!=''):?>
                     <input type="text" name="email" readonly class="form-control" id="email" value="<?php echo $email;?>">
					 <?php else:?>
					  <input type="text" name="email" class="form-control" id="email" value=""> 
					 <?php endif;?>
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="dob"> Date Of Birth <span class="required">*</span></label>
                     <input type="text" name="dob" class="form-control" id="dob" readonly value="<?php echo $dob;?>">
                  </div>
               </div>
               <div class="title-block">
                  <h3 class="title">
                     <i class="fa fa-mobile"></i> Contact Information
                  </h3>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="contact_number">Contact Number <span class="required">*</span></label>
                     <input type="text" name="contact_number" class="form-control" id="contact_number" value="<?php echo $mobile_number;?>">
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="address"> Address <span class="required">*</span></label>
                     <input type="text" name="address" class="form-control" id="address" value="<?php echo $address;?>">
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="city_autocomplete">City <span class="required">*</span></label>
                     <input type="text" name="city" class="form-control" id="city_autocomplete" value="<?php echo $city_name;?>" autocomplete=off>
                     <input type="hidden" name="add_city_id" class="form-control" id="add_city_id">
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="area_autocomplete">Area <span class="required">*</span></label>
                     <input type="text" name="area" class="form-control" id="area_autocomplete" value="<?php echo $area_name;?>" autocomplete=off>
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label class="control-label" for="area_autocomplete">Select Gender <span class="required">*</span></label>
                     <select id="selectError" name="gender" class="form-control common-select-box">
                        <option value="">Select Gender</option>
                        <option value="1" <?php if($gender==1){ echo "Selected";}?>>Male</option>
                        <option value="2" <?php if($gender==2){ echo "Selected";}?>>Female</option>
                     </select>
                  </div>
               </div>
               <div class="form-group col-md-3">
                  <div class="form-group has-success">
                     <label for="profile_image">Profile Image <span class="required">*</span></label>
                     <input type="file" id="profile_image" name="profile_image" accept="image/*">
                     <p class="help-block">only gif,png,jpeg and jpg file allowed.</p>
                  </div>
               </div>
               <div class="form-group col-md-3">
               </div>
               <div class="form-group col-md-3">
               </div>
               <button class="btn btn-primary btn-lg pull-right clearfix">Submit</button>
            </div>
         </form>
      </div>
   </div>
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
			maxDate:0,
			startDate: new Date()
		});  
	});
	
	$('#dob').livequery('click',function(){
		$(this).trigger('focus');
	});
});
</script>