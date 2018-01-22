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
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal');
							echo form_open_multipart(ADMIN.'/advertisments/add/'.$this->uri->segment(4).'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','value'=>set_value('name', $this->input->post('name') ? $this->input->post('name') : $advertisments['name']),'class'=> 'span3','id'=>'name') ); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
								   <div class="control-group">											
										<label class="control-label" for="name">Owner<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'owner','value'=>set_value('owner', $this->input->post('owner') ? $this->input->post('owner') : $advertisments['owner']),'class'=> 'span3','id'=>'owner') ); ?>
										<span class="text-danger"><?php echo form_error('owner'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									   <div class="control-group">											
										<label class="control-label" for="name">Address Line<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'address_line','value'=>set_value('address_line', $this->input->post('address_line') ? $this->input->post('address_line') : $advertisments['address_line']),'class'=> 'span3','id'=>'address_line') ); ?>
										<span class="text-danger"><?php echo form_error('address_line'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									 <div class="control-group">											
										<label class="control-label" for="name">Email<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'email','value'=>set_value('email', $this->input->post('email') ? $this->input->post('email') : $advertisments['email']),'class'=> 'span3','id'=>'email') ); ?>
										<span class="text-danger"><?php echo form_error('email'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="name">Zip<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'zip','value'=>set_value('zip', $this->input->post('zip') ? $this->input->post('zip') : $advertisments['zip']),'class'=> 'span3','id'=>'zip') ); ?>
										<span class="text-danger"><?php echo form_error('zip'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="name">Fax<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'fax','value'=>set_value('fax', $this->input->post('fax') ? $this->input->post('fax') : $advertisments['fax']),'class'=> 'span3','id'=>'fax') ); ?>
										<span class="text-danger"><?php echo form_error('fax'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="name">Website<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'website','value'=>set_value('website', $this->input->post('website') ? $this->input->post('website') : $advertisments['website']),'class'=> 'span3','id'=>'website') ); ?>
										<span class="text-danger"><?php echo form_error('website'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="name">Description<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'description','value'=>set_value('description', $this->input->post('description') ? $this->input->post('description') : $advertisments['description']),'class'=> 'span3','id'=>'description') ); ?>
										<span class="text-danger"><?php echo form_error('description'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="name">Contact Number<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'contact_number','value'=>set_value('contact_number', $this->input->post('contact_number') ? $this->input->post('contact_number') : $advertisments['contact_number']),'class'=> 'span3','id'=>'contact_number') ); ?>
										<span class="text-danger"><?php echo form_error('contact_number'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
										<div class="control-group">											
										<label class="control-label" for="name">Working Start<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'working_start','value'=>set_value('working_start', $this->input->post('working_start') ? $this->input->post('working_start') : $advertisments['working_start']),'class'=> 'span3','id'=>'working_start') ); ?>
										<span class="text-danger"><?php echo form_error('contact_number'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
									<div class="control-group">											
										<label class="control-label" for="name">Working End<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'working_end','value'=>set_value('working_end', $this->input->post('working_end') ? $this->input->post('working_end') : $advertisments['working_end']),'class'=> 'span3','id'=>'working_end') ); ?>
										<span class="text-danger"><?php echo form_error('working_end'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										<div class="widget-header" style="padding-left:10px;" >Location</div>
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
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1', set_value('is_active', $this->input->post('is_active') ? $this->input->post('is_active') : $is_active)); ?> Active
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/categories/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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
