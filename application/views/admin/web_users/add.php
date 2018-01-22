<?php 
//print_r($web_users['profile']);exit;
$email				= "";
$name				= "";
$mobile_number		= "";
$telephone_number	= "";
$_edit_id			= "";
$address			= "";
$last_name			= "";
$gender				= "";	
$image_name 		= "";
$dob				= "";
$image_dir			= "";
$gender_id			= "";
$display_name		= "";

$country_value="";
$country_id="";
$city_value="Select City";
$city_id="";
$state_value="Select State";
$state_id="";	
$area_value="Select Area";
$area_id="";
$profile['is_active']='1';

if(isset($web_users['profile'])){
$profile			= $web_users['profile'];
$email				= $profile['email'];
$name				= $profile['first_name'];
$mobile_number		= $profile['mobile_number'];
$telephone_number	= $profile['telephone_number'];
$_edit_id			= $profile['id'];
$address			= $profile['address'];
$last_name			= $profile['last_name'];
$image_name			= $profile['profile_image'];
$image_dir			= $profile['image_dir'];
$gender_id			= $profile['gender_id'];
$area_id= $profile['preferred_area_id'];
$city_id= $profile['preferred_city_id'];
$state_id= $profile['preferred_state_id'];
$country_id= $profile['preferred_country_id'];
$display_name		= $profile['display_name'];


}
$getcities= $this->config->item('base_url').ADMIN.'/getcities';
$getcountries= $this->config->item('base_url').ADMIN.'/getcountries';
$getstates= $this->config->item('base_url').ADMIN.'/getstates';
$getareas= $this->config->item('base_url').ADMIN.'/getareas';

?>
<script type="text/javascript">
var availableCityTags = "<?php echo $getcities ;?>";
var availablecountryTags = "<?php echo $getcountries ;?>";
var availableStateTags = "<?php echo $getstates ;?>";
var availableAreaTags = "<?php echo $getareas ;?>";
var select_state_id="<?php echo $state_id ; ?>";	
var select_city_id="<?php echo $city_id ; ?>";	
var select_area_id="<?php echo $area_id ; ?>";	

</script>

<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Users - <?php echo $indextitle; ?></h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'add_users');
						
							if($_edit_id==""){
								$readOnly="";$disable="";
								echo form_open_multipart(ADMIN.'/users/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').$this->uri->segment(4).'', $attributes);
							}else{
								$readOnly='readOnly';$disable="disabled";
								echo form_open_multipart(ADMIN.'/users/edit/'.$_edit_id.'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							}		?>
								<fieldset>
									<div class="widget-header" style="padding-left:10px;" >Basic Informations	</div>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="first_name">First Name<span class="must">*</span></label>
										<div class="controls">

										<?php echo form_input(array('name'=>'first_name','value'=>set_value('first_name', $this->input->post('first_name') ? $this->input->post('first_name') : $name),'class'=> 'span3','id'=>'first_name') ); ?>
										  <span class="text-danger"><?php echo form_error('first_name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="first_name">Last Name<span class="must"></span></label>
										<div class="controls">

										<?php echo form_input(array('name'=>'last_name','value'=>set_value('last_name', $this->input->post('last_name') ? $this->input->post('last_name') : $last_name),'class'=> 'span3','id'=>'last_name') ); ?>
									<span class="text-danger"><?php echo form_error('last_name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="email">Email<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'email','class'=> 'span3',$readOnly=>$readOnly,'id'=>'email','value'=>set_value('email', $this->input->post('email') ? $this->input->post('email') : $email),'class'=> 'span3','id'=>'email') ); ?>


										 <span class="text-danger"><?php echo form_error('email'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="display_name">Display Name <span class="must">*</span></label>
										<div class="controls">
										@ <?php echo form_input(array('name'=>'display_name','class'=> 'span3',$readOnly=>$readOnly,'id'=>'display_name','value'=>set_value('display_name', $this->input->post('display_name') ? $this->input->post('display_name') : $display_name),'class'=> 'span2','id'=>'display_name') ); ?> ( Ex: @jessy )
										 <span class="text-danger"><?php echo form_error('display_name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<?php if($_edit_id==""){?>
									

									<div class="control-group">											
										<label class="control-label" for="password">Password<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_password(array('name'=>'password','class'=> 'span3','id'=>'password'),$this->input->post('password')); ?><span><abbr title="Combinations of one digit [0-9], one alphabet [A-Z] [a-z] and one special character such as [@#&*!]"> &nbsp;Tips !!</abbr></span>
										 <span class="text-danger"><?php echo form_error('password'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group">											
										<label class="control-label" for="confirm_password">Confirm Password<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_password(array('name'=>'confirm_password','class'=> 'span3','id'=>'confirm_password'),$this->input->post('confirm_password')); ?>
										 <span class="text-danger"><?php echo form_error("confirm_password"); ?></span>	
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
								<?php } ?>
									
									<div class="control-group">											
										<label class="control-label" for="gender">Gender</label>
										<div class="controls">
										<?php
										$selected = ($this->input->post('gender')) ? $this->input->post('gender') : $gender_id		;  
										
										echo form_dropdown('gender',array(''=>'Select Type')+$this->config->item('gender'),$selected,'id="gender"');?>
										<span class="text-danger"><?php echo form_error("gender"); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<!--<div class="control-group">											
										<label class="control-label" for="username">Date of Birth</label>
										<div class="controls">
										<?php echo form_input(array('placeholder'=>'yy-mm-dd','name'=>'dob','class'=> 'span2','id'=>'dob','value'=>set_value('dob', $this->input->post('dob') ? $this->input->post('dob') : $dob))); ?>
										</div> 			
									</div> -->
			
									
								<div class="widget-header" style="padding-left:10px;" >Contact Informations	</div>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="tele_no">Telephone Number</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'tele_no','class'=> 'span3','id'=>'tele_no',$this->input->post('tele_no'),'value'=>set_value('tele_no', $this->input->post('tele_no') ? $this->input->post('tele_no') : $telephone_number),'class'=> 'span3','id'=>'tele_no')); ?>
										<span class="text-danger"><?php echo form_error("tele_no"); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->

									<div class="control-group">											
										<label class="control-label" for="mob_no">Mobile Number</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'mob_no','value'=>set_value('mob_no', $this->input->post('mob_no') ? $this->input->post('mob_no') : $mobile_number),'class'=> 'span3','id'=>'mob_no') ); ?>
										<span class="text-danger"><?php echo form_error("mob_no"); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
	
								<div class="control-group">											
										<label class="control-label" for="address">Address</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'address','class'=> 'span3','id'=>'address','value'=>set_value('address', $this->input->post('address') ? $this->input->post('address') : $address))); ?>
										<span class="text-danger"><?php echo form_error("address"); ?></span>	
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
								
									<div class="widget-header" style="padding-left:10px;" >Profile Image</div>
									<br/>
									
									<div class="control-group">											
										<label class="control-label" for="image">Image</label>
										<div class="controls">
										<?php echo form_upload(array('name'=>'image','class'=> 'span3','id'=>'image'),$this->input->post('image')); ?>
										</br> <span>( jpg, jpeg, png, gif only ) Size : 1024X300</span>
										<span class="text-danger"><?php echo form_error('image'); ?></span>
																	
									<?php 
									  if( $image_name!="" && file_exists('./'.$image_dir.$image_name) ) {
									  ?>
									  <div><br/>
									   <?php
									   $img_src = thumb(FCPATH.$image_dir.$image_name,'100','100','thumb_profile');
									   $img_prp = array('src'=>base_url().$image_dir.'thumb_profile/'.$img_src,'alt'=>$image_name,'title'=>$profile['display_name']);
									   echo img($img_prp);
									   ?>
									  </div>
									<?php } ?>
									  
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
								<div class="widget-header" style="padding-left:10px;" >Preferred Location</div>
									<br/>	
								<div class="control-group">											
									<label class="control-label" for="select_country">Choose Country</label>
									<div class="controls" id="select_country_div">
									<?php echo form_dropdown("select_country",array(""=>"Select Country")+$countries,$this->input->post('select_country') ? $this->input->post('select_country') : $country_id,'id="select_country"'); ?>								
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
								
								<div class="control-group">											
									<label class="control-label" for="select_state">Choose State</label>
									<div class="controls" id="select_country_div">
									<?php echo form_dropdown("select_state",array($state_id=>$state_value),$state_id,'id="select_state"'); ?>
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
								
								<div class="control-group">											
									<label class="control-label" for="select_city">Choose City</label>
									<div class="controls" id="select_country_div">
									<?php echo form_dropdown("select_city",array($city_id=>$city_value),$city_id,'id="select_city"'); ?>
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
								
								<div class="control-group">											
										<label class="control-label" for="select_area">Choose Area</label>
										<div class="controls" id="select_country_div">
										<?php echo form_dropdown("select_area",array($area_id=>$area_value),$area_id,'id="select_area"'); ?>
										</div> <!-- /controls -->		
									</div> <!-- /control-group -->
									
								
									<div class="control-group">											
										<label class="control-label" for="is_active"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1', set_value('is_active', $this->input->post('is_active') ? $this->input->post('is_active') : $profile['is_active'])); ?> Active
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="form-actions">
									<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
									echo anchor(base_url().ADMIN.'/users/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
								</fieldset>
							<?php echo form_close(); ?>
							</div>
						</div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
		    </div> <!-- /span8 -->
	      </div> <!-- /row -->	
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->

<script src="assets/js/admin/jquery.datetimepicker.js"></script>
<script>
$("#dob").datepicker({
	  dateFormat: "yy-mm-dd",
	  yearRange: '-60:+0',
	  maxDate: new Date(),
      numberOfMonths: 1,
	  changeMonth: true,
	  changeYear: true,
    });
</script>
