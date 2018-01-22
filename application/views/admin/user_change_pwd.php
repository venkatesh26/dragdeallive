<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?> 
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-key"></i>
	      				<h3>Change Password</h3><span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/'.$this->uri->segment(2).'/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'), ucfirst($this->uri->segment(2)));echo "/view"; 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
								$attributes = array('class' => 'form-horizontal', 'id' => 'change-password');
								echo validation_errors();
								if(!$this->uri->segment(4)){
									echo form_open('user/change_password/', $attributes);
								}else{
									echo form_open(ADMIN.'/'.$this->uri->segment(2).'/change_password/'.$this->uri->segment(4).'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
								}
								if($this->session->flashdata('flash_message')){
									echo $this->session->flashdata('flash_message');
							  	}
							?>
        						<fieldset>
          							<div class="control-group">
            							<label for="inputError" class="control-label">Password <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'password','id'=>'password'),'',$this->input->post('password')); ?>
										<span><abbr title="Combinations of one digit [0-9], one alphabet [A-Z] [a-z] and one special character such as [@#&*!]"> &nbsp;Tips !!</abbr></span>
										 <span class="text-danger"></span>
            							</div>
          							</div>  
          							<div class="control-group">
            							<label for="inputError" class="control-label">Confirm Password <span class="must">*</span></label>
            							<div class="controls">
            							<?php echo form_password(array('name'=>'password2','id'=>'password2'),'',$this->input->post('password2')); ?>
										<span class="text-danger"></span>
            							</div>
          							</div>           
          							<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/'.$this->uri->segment(2).'/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn')); ?>
          							</div>
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
