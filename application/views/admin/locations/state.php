<?php
$_is_edit=false;
$value="";
$c_value="";	
$edit_id="";
$long_value="";
$lat_value="";
$c_id="Select Country";	
$is_active=1;
if(isset($result) ){
	$_is_edit=true;
	if($result!=null){		
		$value=$result[0]['value'];
		$c_value=$result[0]['c_value'];	
		$c_id=$result[0]['c_id'];	
		$edit_id=$result[0]['id'];
		$long_value=$result[0]['longitude'];
		$lat_value=$result[0]['latitude'];
		$is_active=$result[0]['is_active'];
	}
}
$getcountries= $this->config->item('base_url').ADMIN.'/getcountries';
?> 
<script type="text/javascript">
var is_edit="<?php echo $_is_edit; ?>";
var selected_country="<?php echo $c_id; ?>";
var availablecountryTags = "<?php echo $getcountries ;?>";
var select_state_id='';
</script>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
					<div class="widget-header">
							<i class="icon-flag"></i>
							<h3>States - <?php echo $indextitle; ?></h3>
					</div> <!-- /widget-header -->					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
								<?php
								$attributes = array('class' => 'form-horizontal', 'id' => 'state-form');
								//echo validation_errors();
								//echo form_open('admin/createstates', $attributes);

								if(! $_is_edit){
									echo form_open(ADMIN.'/states/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
								}else{
									echo form_open(ADMIN.'/states/edit/'.$edit_id.'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
								}
								?>
								<fieldset>
										<?php echo form_input(array('name'=>'id','id'=>'id','class'=>'span3','placeholder'=>'','value'=>$edit_id,'style'=>'display:none;')); ?>
										<br/>
										<div class="control-group eq-align">											
											<label class="control-label" for="username">Choose Country<span class="must">*</span></label>
											<div class="controls" id="select_country_div">
											<?php echo form_dropdown("select_country",array(""=>"Select Country")+$countries,$this->input->post('select_country') ? $this->input->post('select_country') : $c_id,'id="select_country"'); ?>
											<span class="text-danger"><?php echo form_error('select_country'); ?></span>
											</div> <!-- /controls -->		
										</div> <!-- /control-group -->
											
										<div class="widget-content">
											<div class="control-group">											
												<label class="control-label" for="state_type" id="state_type">State/County<span class="must">*</span></label>
												<div class="controls">
												<?php echo form_input(array('name'=>'add_state','id'=>'add_state','class'=> 'span3','maxlength'=>'35','placeholder'=>'','value'=>set_value('add_state', $this->input->post('add_state') ? $this->input->post('add_state') : $value))); ?>
												 <span class="text-danger"><?php echo form_error('add_state'); ?></span>
												</div> <!-- /controls -->														
											</div> <!-- /control-group -->										
												
											<div class="control-group">											
												<label class="control-label" for="username">Latitude<span class="must">*</span></label>
												<div class="controls">
												<?php echo form_input(array('name'=>'add_lat','readonly'=>'readonly','id'=>'add_lat','class'=> 'span3','placeholder'=>'','maxlength'=>'20','value'=>set_value('add_lat', $this->input->post('add_lat') ? $this->input->post('add_lat') : $lat_value))); ?>
												<span class="text-danger"><?php echo form_error('add_lat'); ?></span>
												</div> <!-- /controls -->				
											</div> <!-- /control-group -->
											<div class="control-group">											
												<label class="control-label" for="username">Longitude<span class="must">*</span></label>
												<div class="controls">
												<?php echo form_input(array('name'=>'add_long','readonly'=>'readonly','id'=>'add_long','class'=> 'span3','placeholder'=>'','maxlength'=>'20','value'=>set_value('add_long', $this->input->post('add_long') ? $this->input->post('add_long') : $long_value))); 
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
									
									</div> <!-- /controls -->									
											
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/states/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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
