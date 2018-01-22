<?php
$_is_edit=false;
$value="";
$country_value="";
$city_value="";
$state_value="Select State";	
$edit_id="";
$country_id="Select Country";
$is_active=1;
$state_id="";
$language='';
$currency='';
$img_count = 1;
$meta_title='';
$meta_description='';
$meta_city_area_title='';
$population='';
$meta_city_area_description='';
if(isset($result)){
	$_is_edit=true;
	if($result!=null){		
		$value=$result[0]['value'];
		$country_value=$result[0]['c_value'];
		$country_id=$result[0]['c_id'];
		$city_value=$result[0]['city_value'];
		$state_value=$result[0]['value'];
		$state_id=$result[0]['id'];	
		$edit_id=$result[0]['city_id'];
		$meta_title=$result[0]['meta_title'];
		$meta_description=$result[0]['meta_description'];
		$meta_city_area_title=$result[0]['meta_city_area_title'];
		$meta_city_area_description=$result[0]['meta_city_area_description'];
		$is_active=$result[0]['is_active'];
	}
}
if($this->input->post('select_state')!=""){
	$state_id=$this->input->post('select_state');
}
$getstates= $this->config->item('base_url').ADMIN.'/getstates';
$getcountries= $this->config->item('base_url').ADMIN.'/getcountries';
?> 
<script type="text/javascript">
var is_edit="<?php echo $_is_edit ?>";
var availableStateTags = "<?php echo $getstates ;?>";
var availablecountryTags = "<?php echo $getcountries ;?>";
var select_state_id="<?php echo $state_id ; ?>";	
var select_city_id="";
$(document).ready(function() {
	$('#is_home').livequery('click',function(e,param){
		if(param=="Yes"){
			$('.home-city-hide-show').css('display','block');
		}
		else if($(this).is(':checked')) {
			$('.home-city-hide-show').css('display','block');
		} else {
			$('.home-city-hide-show').css('display','none');
		}
	});	
	<?php if($_is_edit && $result[0]['home_city']==1){ ?>
		$("#is_home").trigger('click','Yes');
	<?php } ?>
});
</script>

<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-flag"></i>
	      				<h3>City - <?php echo $indextitle; ?></h3>
	  				</div> <!-- /widget-header -->					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'city-form2');
							//echo validation_errors();
							//echo form_open('admin/createcities', $attributes);
							if(!$_is_edit){
								echo form_open_multipart(ADMIN.'/cities/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							}else{
								echo form_open_multipart(ADMIN.'/cities/edit/'.$edit_id.'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							}
							?>
							<fieldset>
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
									<?php echo form_dropdown("select_state",array($state_id=>$state_value),$this->input->post('select_state') ? $this->input->post('select_state') : $state_id,'id="select_state"'); ?>
									<span class="text-danger"><?php echo form_error('select_state'); ?></span>
									</div> <!-- /controls -->		
								</div> <!-- /control-group -->
								
								<div class="widget-content">
									<div class="control-group">											
										<label class="control-label" for="username">City<span class="must">*</span></label>
										<div class="controls">
											<?php echo form_input(array('name'=>'add_city','id'=>'add_city','class'=> 'span3','placeholder'=>'','maxlength'=>'30','value'=>set_value('add_city', $this->input->post('add_city') ? $this->input->post('add_city') : $city_value))); ?>
											<?php echo form_input(array('name'=>'id','id'=>'id','class'=>'span3','placeholder'=>'','value'=>$edit_id,'style'=>'display:none;')); ?>	
										<span class="text-danger"><?php echo form_error('add_city'); ?></span>										
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->		
					<div class="control-group">
										<label for="inputError" class="control-label">City Image <span class="must">*</span><br /></label>
										<div class="controls">
										  <?php echo form_upload(array('name'=>'image','id'=>'images')); ?></br>
										  <span>( jpg, jpeg, png, gif only ) Size : 420X420</span>
										  <span class="text-danger"><?php echo form_error('image'); ?></span>
										  <!--<span class="help-inline">Woohoo!</span>-->
										  <?php 
										  $value=0;
										  if(isset($result[0]['city_image']))
										  {
										  $value=1;
										  
										  }?>
										  <input type="hidden" value="<?php echo $value; ?>" id="js-image-id">
									 <?php 

									 if($_is_edit)
									 {
									  if(file_exists('./'.$result[0]['image_dir'].$result[0]['city_image']) && $result[0]['city_image']!="") {
									  ?>
									  <div>
									  <?php
									   $img_src = thumb(FCPATH.$result[0]['image_dir'].$result[0]['city_image'],'65','40','city_image');
									   $img_prp = array('src'=>base_url().$result[0]['image_dir'].'city_image/'.$img_src,'alt'=>$result[0]['city_image'],'title'=>$result[0]['c_value']);
									   echo img($img_prp);
									   ?>
									  </div>
									  <?php } 
									  }?>
										</div>
									</div>	

	<div class="control-group">											
										<label class="control-label" for="lastname">Meta Title</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_title','id'=>'meta_title','class'=> 'span3','placeholder'=>'','maxlength'=>'30','value'=>set_value('meta_title', $this->input->post('meta_title') ? $this->input->post('meta_title') : $meta_title))); ?>
											<br/>
										</div> <!-- /controls -->				
										 
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_description','rows'=>'5','id'=>'meta_description','class'=> 'span5','placeholder'=>'','maxlength'=>'30','value'=>set_value('meta_description', $this->input->post('meta_description') ? $this->input->post('meta_description') : $meta_description))); ?>
											
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->	


	<div class="control-group">											
										<label class="control-label" for="lastname">Meta City  Area Title</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'meta_city_area_title','id'=>'meta_city_area_title','class'=> 'span3','placeholder'=>'','maxlength'=>'30','value'=>set_value('meta_city_area_title', $this->input->post('meta_city_area_title') ? $this->input->post('meta_city_area_title') : $meta_city_area_title))); ?>
											<br/>
										</div> <!-- /controls -->				
										 
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta City Area Description</label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'meta_city_area_description','rows'=>'5','id'=>'meta_city_area_description','class'=> 'span5','placeholder'=>'','maxlength'=>'30','value'=>set_value('meta_city_area_description', $this->input->post('meta_city_area_description') ? $this->input->post('meta_city_area_description') : $meta_city_area_description))); ?>

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
										
								</div> 		
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/cities/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn')); ?>
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
