<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Contact Us - View</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/contact_us/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
									<div class="control-group views1">											
										<label class="control-label" for="username">Name :</label>
										<div class="controls views">
										<?php echo ucwords($contactus['name']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Email :</label>
										<div class="controls views">
										<?php echo $contactus['email']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php  echo date('d-M-Y',strtotime($contactus['created'])); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
	                       
						   	<div class="control-group views1">											
										<label class="control-label" for="username">Title :</label>
										<div class="controls views">
												<?php echo $contactus['title']; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
	                       
						   
						   	<div class="control-group views1">											
										<label class="control-label" for="username">Posted Date :</label>
										<div class="controls views">
											<?php echo nl2br($contactus['message']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
	                       
						   
									<div class="widget-header listpadd" >Contact Informations	</div>
									
									<div class="control-group views1">											
										<label class="control-label" for="username">Mobile Number :</label>
										<div class="controls views">
										<?php echo $contactus['contact_number'];?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="widget-header listpadd" >Last Replied Message</div>
									
									<?php
									if(!empty($replyMessage))
									{
									foreach($replyMessage as $message)
									{?>
										<div class="control-group views1">											
											<label class="control-label" for="username">Date:</label>
											<div class="controls views">
											<?php echo date("Y-m-d H:i:s",$message['created']);?>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group views1">											
											<label class="control-label" for="username">Subject:</label>
											<div class="controls views">
											<?php echo $message['subject'];?>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group views1">											
											<label class="control-label" for="username">Message:</label>
											<div class="controls views">
											<?php echo $message['reply_message'];?>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
									<?php
									}
									}
									else
									{?>
											<div class="control-group views1">											
											<label class="control-label" for="username">Message:</label>
											<div class="controls views">
											<?php echo "No Reply Available";?>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
									<?php }?>
									<div class="widget-header listpadd" >Leave Your Reply Messasge Here...</div>
														<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal','id'=>'reply_message');
							echo form_open_multipart(ADMIN.'/contact_us/send_message',$attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Subject<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'contact_id','type'=>'hidden'),$contactus['id']); ?>
										<?php echo form_input(array('name'=>'name','type'=>'hidden'),$contactus['name']); ?>
										<?php echo form_input(array('name'=>'email','type'=>'hidden'),$contactus['email']); ?>
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
										echo anchor(base_url().ADMIN.'/contact_us/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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