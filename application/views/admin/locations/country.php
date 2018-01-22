<?php
$value="";
$code="";
$_is_edit=false;
$edit_id="";
$is_active=1;
$state_type=1;
if(isset($result)){
	$_is_edit=true;
	if($result!=null){		
		$value=$result[0]['value'];
		$code=$result[0]['code'];
		$edit_id=$result[0]['id'];
		$is_active=$result[0]['is_active'];
		$state_type=$result[0]['state_type'];
	}
}
?>
<script type="text/javascript">
var is_edit="<?php echo $_is_edit ?>";
</script>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-flag"></i>
	      				<h3>Countries - <?php echo $head_title; ?></h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
									<?php								
									//echo validation_errors();
									if(! $_is_edit){
											$attributes = array('class' => 'form-horizontal', 'id' => 'country-form','autocomplete'=>'off');
										echo form_open(ADMIN.'/countries/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
									}else{
										$attributes = array('class' => 'form-horizontal', 'id' => 'country-edit-form','autocomplete'=>'off');
										echo form_open(ADMIN.'/countries/edit/'. $edit_id.'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
									}
									?>
								<fieldset>
									<div class="control-group">											
										<label class="control-label" for="username">Country<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'add_country','id'=>'add_country','class'=> 'span3','placeholder'=>'','maxlength'=>'30','value'=>set_value('add_country', $this->input->post('add_country') ? $this->input->post('add_country') : $value))); ?>
										<span class="text-danger"><?php echo form_error('add_country'); ?></span>		
										<?php echo form_input(array('name'=>'id','id'=>'id','class'=>'span3','placeholder'=>'','value'=>$edit_id,'style'=>'display:none;')); ?>
									
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->			
										
									<div class="control-group">											
										<label class="control-label" for="username">Code<span class="must">*</span></label>
										<div class="controls">
													<?php echo form_input(array('name'=>'add_code','id'=>'add_code','class'=> 'span3','placeholder'=>'','maxlength'=>'10','value'=>set_value('add_code', $this->input->post('add_code') ? $this->input->post('add_code') : $code))); ?>
													<span class="text-danger"><?php echo form_error('add_code'); ?></span>		
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->	
									<div class="control-group">											
										<label class="control-label" for="username">State / County</label>
										<div class="controls">
											<?php
											//$state_type=1;
													//echo $state_type = $this->input->post('state_type');
													$state_checked=false;
													$county_checked=false;
													if($state_type==1 || empty($state_type)) $state_checked=true;
													else if($state_type==2) $county_checked=true;
												?>  
											<label class="radio inline">												
												<?php echo form_radio('state_type', '1', $state_checked); ?> State
											</label>
				
											<label class="radio inline">
												<?php echo form_radio('state_type', '2', $county_checked); ?>
													County
											</label>
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
										echo anchor(base_url().ADMIN.'/countries/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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