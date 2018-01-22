<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Send Email</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
	
									<div class="widget-header listpadd" >Send Mail</div>
														<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal','id'=>'reply_message');
							echo form_open_multipart(ADMIN.'/advertisment_send_mail/'.$id,$attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Subject<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'subject','class'=> 'span3','id'=>'subject','style'=>'width:606px;'),$this->input->post('subject')); ?>
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Message<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'message','class'=> 'span3','id'=>'message','style'=>'width:606px;'),$this->input->post('message')); ?>
										<span class="text-danger"><?php echo form_error('message'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Send','title'=>'Send')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/advertisments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
								</fieldset>
							<?php echo form_close(); ?>
							</div>
						</div>
					</div> <!-- /widget-content -->
								</fieldset>
							</div>
						</div>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
		    </div> <!-- /span8 -->
	      </div> <!-- /row -->	
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->