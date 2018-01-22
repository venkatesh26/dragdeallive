<?php 
//print_r($web_users['profile']);exit;
$email				= "";
$name				= "";
$mobile_number		= "";
$telephone_number	= "";
$_edit_id			= "";
$last_name			= "";
$gender				= "";	
$gender_id			= "";
$display_name		= "";
$profile['is_active']="";
if(isset($web_users['profile'])){
	$profile			= $web_users['profile'];
	$email				= $profile['email'];
	$name				= $profile['first_name'];
	$mobile_number		= $profile['mobile_number'];
	$telephone_number	= $profile['telephone_number'];
	$_edit_id			= $profile['id'];
	$address			= $profile['address'];
	$gender_id			= $profile['gender_id'];
	$display_name		= $profile['display_name'];
}
?>
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
								echo form_open_multipart(ADMIN.'/subadmin/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').$this->uri->segment(4).'', $attributes);
							}else{
								$readOnly='readOnly';$disable="disabled";
								echo form_open_multipart(ADMIN.'/subadmin/edit/'.$_edit_id.'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							}		?>
								<fieldset>
									<div class="widget-header" style="padding-left:10px;" >Basic Informations	</div>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="first_name">Name<span class="must">*</span></label>
										<div class="controls">

										<?php echo form_input(array('name'=>'first_name','value'=>set_value('first_name', $this->input->post('first_name') ? $this->input->post('first_name') : $name),'class'=> 'span3','id'=>'first_name') ); ?>
										  <span class="text-danger"><?php echo form_error('first_name'); ?></span>
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
										<label class="control-label" for="is_active"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_active', '1', set_value('is_active', $this->input->post('is_active') ? $this->input->post('is_active') : $profile['is_active'])); ?> Active 
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="form-actions">
									<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
									echo anchor(base_url().ADMIN.'/subadmin/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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
