<?php
$_is_edit=false;
$value="";
$country_value="";
$country_id="";
$city_value="Select City";
$city_id="";
$area_value="";
$state_value="Select State";
$state_id="";	
$edit_id="";		
$long_value="";
$lat_value="";
$is_active=1;
if(isset($result)){
	$_is_edit=true;
	if($result!=null){		
		$value=$result[0]['value'];
		$country_value=$result[0]['c_value'];
		$country_id=$result[0]['c_id'];
		$city_value=$result[0]['city_value'];
		$city_id=$result[0]['city_id'];
		$area_value=$result[0]['area_value'];
		$state_value=$result[0]['value'];
		$state_id=$result[0]['id'];	
		$edit_id=$result[0]['area_id'];		
		$long_value=$result[0]['longitude'];
		$lat_value=$result[0]['latitude'];
		$is_active=$result[0]['is_active'];
	}
}

if($this->input->post('select_state')!=""){
$state_id=$this->input->post('select_state');
}


if($this->input->post('select_city')!=""){
$city_id=$this->input->post('select_city');
}
$getcities= $this->config->item('base_url').ADMIN.'/getcities';
$getcountries= $this->config->item('base_url').ADMIN.'/getcountries';
$getstates= $this->config->item('base_url').ADMIN.'/getstates';
?> 
<script type="text/javascript">
var selected_city="<?php echo $city_id; ?>";
var selected_country="<?php echo $country_id; ?>";
var selected_state="<?php echo $state_id; ?>";
var is_edit="<?php echo $_is_edit; ?>";
var availableCityTags = "<?php echo $getcities ;?>";
var availablecountryTags = "<?php echo $getcountries ;?>";
var availableStateTags = "<?php echo $getstates ;?>";
var select_state_id="<?php echo $state_id ; ?>";	
var select_city_id="<?php echo $city_id ; ?>";	
</script>

<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-flag"></i>
	      				<h3>Areas - <?php echo $indextitle; ?></h3>
  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'area-form');
							//echo validation_errors();
							if(!$_is_edit){
								echo form_open(ADMIN.'/areas/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							}else{
								echo form_open(ADMIN.'/areas/edit/'.$edit_id.'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							}
							?>
							<fieldset>
								<?php echo form_input(array('name'=>'id','id'=>'id','class'=>'span3','placeholder'=>'','value'=>$edit_id,'style'=>'display:none;')); ?>
								<div class="control-group eq-align">											
									<label class="control-label" for="username">Choose Country<span class="must">*</span></label>
									<div class="controls" id="select_country_div">
									<?php echo form_dropdown("select_country",array(""=>"Select Country")+$countries,$this->input->post('select_country') ? $this->input->post('select_country') : $country_id,'id="select_country"'); ?>
									<span class="text-danger"><?php echo form_error('select_country'); ?></span>
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
								
								<div class="control-group eq-align">											
									<label class="control-label" for="username">Choose State<span class="must">*</span></label>
									<div class="controls" id="select_country_div">
									<?php echo form_dropdown("select_state",array($state_id=>$state_value),$state_id,'id="select_state"'); ?>
									<span class="text-danger"><?php echo form_error('select_state'); ?></span>
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
								
								<div class="control-group eq-align">											
									<label class="control-label" for="username">Choose City<span class="must">*</span></label>
									<div class="controls" id="select_country_div">
									<?php echo form_dropdown("select_city",array($city_id=>$city_value),$city_id,'id="select_city"'); ?>
									<span class="text-danger"><?php echo form_error('select_city'); ?></span>
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
									
								<div class="widget-content">
									<div class="control-group">											
										<label class="control-label" for="username">Area<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'add_area','id'=>'add_area','class'=> 'span3','placeholder'=>'','value'=>set_value('add_area', $this->input->post('add_area') ? $this->input->post('add_area') : $area_value))); ?>
										<span class="text-danger"><?php echo form_error('add_area'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->			
									
									<div class="control-group">											
										<label class="control-label" for="username">Latitude<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'add_lat','id'=>'add_lat','class'=> 'span3','placeholder'=>'','value'=>set_value('add_lat', $this->input->post('add_lat') ? $this->input->post('add_lat') : $lat_value))); ?>
										<span class="text-danger"><?php echo form_error('add_lat'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="username">Longitude<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'add_long','id'=>'add_long','class'=> 'span3','placeholder'=>'','value'=>set_value('add_lat', $this->input->post('add_lat') ? $this->input->post('add_lat') : $long_value))); 
										?>
										<span class="text-danger"><?php echo form_error('add_long'); ?></span>
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
								</div> <!-- /control-group -->	
								
									<div class="form-actions">
									<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save')).'&nbsp;';
									echo anchor(base_url().ADMIN.'/areas/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn')); 
									?>
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
