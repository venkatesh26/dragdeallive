<?php
   $country_value="";
   $country_id="";
   $city_value="Select City";
   $city_id="";
   $state_value="Select State";
   $state_id="";	
   $area_value="Select Area";
   $area_id="";
   if(isset($advertisments['id']))
   {
   $area_id= $advertisments['area_id'];
   $city_id= $advertisments['city_id'];
   $state_id= $advertisments['state_id'];
   $country_id= $advertisments['country_id'];
   }
   $getcities= $this->config->item('base_url').ADMIN.'/getcities';
   $getcountries= $this->config->item('base_url').ADMIN.'/getcountries';
   $getstates= $this->config->item('base_url').ADMIN.'/getstates';
   $getareas= $this->config->item('base_url').ADMIN.'/getareas';
   $city_name=$advertisments['city_name'];
   $area_name=$advertisments['area_name'];
   $latitude=$advertisments['latitude'];
   $longitude=$advertisments['longitude'];
   $social_media = @unserialize($user_business_data['other_info']);
   $facebook_url=(isset($social_media['facebook_url']) && $social_media['facebook_url']!='') ? $social_media['facebook_url'] : '';
   $googleplus_url=(isset($social_media['googleplus_url']) && $social_media['googleplus_url']!='') ? $social_media['googleplus_url'] : '';
   $twitter_url=(isset($social_media['twitter_url']) && $social_media['twitter_url']!='') ? $social_media['twitter_url'] : '';
   $linkedin_url=(isset($social_media['linkedin_url']) && $social_media['linkedin_url']!='') ? $social_media['linkedin_url'] : '';
   $youtube_url=(isset($social_media['youtube_url']) && $social_media['youtube_url']!='') ? $social_media['youtube_url'] : '';
   $whatsup_contact_number=(isset($social_media['whatsup_contact_number']) && $social_media['whatsup_contact_number']!='') ? $social_media['whatsup_contact_number'] : '';
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
                     <i class="icon-fire"></i>
                     <h3>Advertisments - Edit</h3>
                     <span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
                  </div>
                  <!-- /widget-header -->
                  <div class="widget-content">
                     <div class="tabbable">
                        <div class="tab-pane" id="formcontrols">
                           <div class="widget-header" style="padding-left:10px;"><i class="fa fa-bull-horn"></i>Basic Information </div>
                           <?php
                              $attributes = array('class' => 'form-horizontal');
                              echo form_open_multipart(ADMIN.'/advertisments/edit/'.$this->uri->segment(4).'?step=1&pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
                              ?>
                           <fieldset>
                              <br/>
                              <input type="hidden" name="step" value="1">
                              <div class="col-md-12 row">
                                 <div class="column col-md-4 control-group">											
                                    <label class="control-label1" for="name">Name<span class="must">*</span></label>
                                    <?php echo form_input(array('name'=>'name','value'=>set_value('name', $this->input->post('name') ? $this->input->post('name') : $advertisments['name']),'class'=> 'span3','id'=>'name') ); ?>
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>			
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">											
                                    <label class="control-label1" for="name">Owner<span class="must">*</span></label>
                                    <?php echo form_input(array('name'=>'owner','value'=>set_value('owner', $this->input->post('owner') ? $this->input->post('owner') : $advertisments['owner']),'class'=> 'span3','id'=>'owner') ); ?>
                                    <span class="text-danger"><?php echo form_error('owner'); ?></span>			
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">											
                                    <label class="control-label1" for="name">Address Line<span class="must">*</span></label>
                                    <?php echo form_input(array('name'=>'address_line','value'=>set_value('address_line', $this->input->post('address_line') ? $this->input->post('address_line') : $advertisments['address_line']),'class'=> 'span3','id'=>'address_line') ); ?>
                                    <span class="text-danger"><?php echo form_error('address_line'); ?></span>			
                                 </div>
                                 <!-- /control-group -->
                              </div>
                              <div class="col-md-12 row">
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Email<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'email','value'=>set_value('email', $this->input->post('email') ? $this->input->post('email') : $advertisments['email']),'class'=> 'span3','id'=>'email') ); ?>
                                       <span class="text-danger"><?php echo form_error('email'); ?></span>	
                                    </div>
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Zip<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'zip','value'=>set_value('zip', $this->input->post('zip') ? $this->input->post('zip') : $advertisments['zip']),'class'=> 'span3','id'=>'zip') ); ?>
                                       <span class="text-danger"><?php echo form_error('zip'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Fax<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'fax','value'=>set_value('fax', $this->input->post('fax') ? $this->input->post('fax') : $advertisments['fax']),'class'=> 'span3','id'=>'fax') ); ?>
                                       <span class="text-danger"><?php echo form_error('fax'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <!-- /control-group -->
                              </div>
                              <div class="col-md-12 row">
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Website<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'website','value'=>set_value('website', $this->input->post('website') ? $this->input->post('website') : $advertisments['website']),'class'=> 'span3','id'=>'website') ); ?>
                                       <span class="text-danger"><?php echo form_error('website'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Contact Number<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'contact_number','value'=>set_value('contact_number', $this->input->post('contact_number') ? $this->input->post('contact_number') : $advertisments['contact_number']),'class'=> 'span3','id'=>'contact_number') ); ?>
                                       <span class="text-danger"><?php echo form_error('contact_number'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Working Start<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'working_start','value'=>set_value('working_start', $this->input->post('working_start') ? $this->input->post('working_start') : $advertisments['working_start']),'class'=> 'span3','id'=>'working_start') ); ?>
                                       <span class="text-danger"><?php echo form_error('contact_number'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Working End<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'working_end','value'=>set_value('working_end', $this->input->post('working_end') ? $this->input->post('working_end') : $advertisments['working_end']),'class'=> 'span3','id'=>'working_end') ); ?>
                                       <span class="text-danger"><?php echo form_error('working_end'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <!-- /control-group -->
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Since<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'since','value'=>set_value('since', $this->input->post('since') ? $this->input->post('since') : $advertisments['since']),'class'=> 'span3','id'=>'since') ); ?>
                                       <span class="text-danger"><?php echo form_error('since'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                                 <div class="col-md-4 control-group">
                                    <label class="control-label1" for="name">Number Of Employess<span class="must">*</span></label>
                                    <div class="controls1">
                                       <?php echo form_input(array('name'=>'no_of_employees','value'=>set_value('no_of_employees', $this->input->post('no_of_employees') ? $this->input->post('no_of_employees') : $advertisments['no_of_employees']),'class'=> 'span3','id'=>'no_of_employees') ); ?>
                                       <span class="text-danger"><?php echo form_error('no_of_employees'); ?></span>
                                    </div>
                                    <!-- /controls -->				
                                 </div>
                              </div>
                              <div class="form-actions1">
                                 <?php echo form_submit(array('class'=>'btn btn-primary','style'=>'float:right;margin-left:10px;','value'=>'Save','title'=>'Save')).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo anchor(base_url().ADMIN.'/advertisments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel', 'style'=>'float:right')); ?>
                              </div>
                              <br/>
                           </fieldset>
                           <?php echo form_close(); ?>
                           <fieldset>
                              <div class="widget-header" style="padding-left:10px;" >About</div>
                              <br/>	
                              <?php
                                 $attributes = array('class' => 'form-horizontal');
                                 echo form_open_multipart(ADMIN.'/advertisments/edit/'.$this->uri->segment(4).'?step=1&pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
                                 ?>
                              <input type="hidden" name="step" value="2">
                              <div class="col-md-12 row">
                                 <div class="column col-md-12 control-group">
                                    <label class="control-label1" for="description">Description</label>
                                    <textarea style="width:90%;" class="form-control" id="description" rows="5" name="description"><?php echo $advertisments['description'];?></textarea>
                                    <!-- /controls -->		
                                 </div>
                              </div>
                              <div class="form-actions1">
                                 <?php echo form_submit(array('class'=>'btn btn-primary','style'=>'float:right;margin-left:10px;','value'=>'Save','title'=>'Save')).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo anchor(base_url().ADMIN.'/advertisments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel', 'style'=>'float:right')); ?>
                              </div>
                              <br/>
                              <?php echo form_close(); ?>
                           </fieldset>
                           <fieldset>
                              <div class="widget-header" style="padding-left:10px;" >Social Media</div>
                           
                              <br/>	
                              <?php
                                 $attributes = array('class' => 'form-horizontal');
                                 echo form_open_multipart(ADMIN.'/advertisments/edit/'.$this->uri->segment(4).'?step=1&pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
                                 ?>
								    <input type="hidden" name="step" value="3">
                              <div class="col-md-12 row">
                                 <div class="column col-md-12 control-group">
                                    <div class="form-group col-md-4">
                                       <label class="control-label1" for="facebook_url">Facebook URL </label>
                                       <input type="text" class="form-control" id="facebook_url" name="facebook_url" name="facebook_url" value="<?php echo $facebook_url;?>" autocomplete="off" placeholder="Enter Facebook Url">
                                    </div>
                                    <div class="form-group col-md-4">
                                       <label class="control-label1" for="googleplus_url">Google + URL</label>
                                       <input type="text" class="form-control" id="googleplus_url" name="googleplus_url" value="<?php echo $googleplus_url;?>" autocomplete="off" placeholder="Enter Google+ Url">
                                    </div>
                                    <div class="form-group col-md-4">
                                       <label class="control-label1" for="twitter_url">Twitter URL</label>
                                       <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="<?php echo $twitter_url;?>" placeholder="Enter Twitter Url">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-12 row">
                                 <div class="column col-md-12 control-group">
                                    <div class="form-group col-md-4">
                                       <label class="control-label1" for="linkedin_url">LinkedIn URL</label>
                                       <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" value="<?php echo $linkedin_url;?>" placeholder="Enter LinkedIn Url">
                                    </div>
                                    <div class="form-group col-md-4">
                                       <label class="control-label1" for="youtube_url">YouTube URL</label>
                                       <input type="text" class="form-control" id="youtube_url" name="youtube_url" value="<?php echo $youtube_url;?>" placeholder="Enter Youtube Url">
                                    </div>
                                    <div class="form-group col-md-4">
                                       <label class="control-label1" for="whatsup_contact_number">WhatsUp Contact Number</label>
                                       <input type="text" class="form-control" id="whatsup_contact_number" name="whatsup_contact_number" value="<?php echo $whatsup_contact_number;?>" placeholder="Enter Your Whatsup Contact Number">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-actions1">
                                       <?php echo form_submit(array('class'=>'btn btn-primary','style'=>'float:right;margin-left:10px;','value'=>'Save','title'=>'Save')).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo anchor(base_url().ADMIN.'/advertisments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel', 'style'=>'float:right')); ?>
                              </div>
                              <?php echo form_close(); ?>
                              <!-- /form-actions -->
                           </fieldset>
						   
						    <fieldset>
                              <div class="widget-header" style="padding-left:10px;" >Contact Information</div>
                           
                              <br/>	
                              <?php
                                 $attributes = array('class' => 'form-horizontal');
                                 echo form_open_multipart(ADMIN.'/advertisments/edit/'.$this->uri->segment(4).'?step=1&pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
                                 ?>
								    <input type="hidden" name="step" value="4">
                              <div class="col-md-12 row">
                                 <div class="column col-md-12 control-group">
                                    <div class="form-group col-md-3">
                                       <label class="control-label1" for="city_name">City </label>
                                       <input type="text" class="form-control" id="city_name" name="city_name" name="city_name" value="<?php echo $city_name;?>" autocomplete="off" placeholder="Enter City">
                                    </div>
                                    <div class="form-group col-md-3">
                                       <label class="control-label1" for="area_name">Area</label>
                                       <input type="text" class="form-control" id="area_name" name="area_name" value="<?php echo $area_name;?>" autocomplete="off" placeholder="Enter Area">
                                    </div>
                                    <div class="form-group col-md-3">
                                       <label class="control-label1" for="latitude">Latitude</label>
                                       <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $latitude;?>" placeholder="Enter Latitude">
                                    </div>
									<div class="form-group col-md-3">
                                       <label class="control-label1" for="longitude">Longitude</label>
                                       <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $longitude;?>" placeholder="Enter Longitude">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-actions1">
                                       <?php echo form_submit(array('class'=>'btn btn-primary','style'=>'float:right;margin-left:10px;','value'=>'Save','title'=>'Save')).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo anchor(base_url().ADMIN.'/advertisments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel', 'style'=>'float:right')); ?>
                              </div>
                              <?php echo form_close(); ?>
                              <!-- /form-actions -->
                           </fieldset>
                        </div>
                     </div>
                  </div>
                  <!-- /widget-content -->
               </div>
               <!-- /widget -->
            </div>
            <!-- /span8 -->
         </div>
         <!-- /row -->	
      </div>
      <!-- /container -->
   </div>
   <!-- /main-inner -->
</div>
<!-- /main -->