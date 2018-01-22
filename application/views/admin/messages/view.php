<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user-md"></i>
	      				<h3>Messages - View/Reply</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<?php //pr($messages);die; 
									if(count($messages)) {
											foreach($messages as $vals) {
									?>
									<div class="control-group views1">											
										<label class="control-label" for="username"><?php echo '@'.$vals['display_name']; ?> :</label>
										<div class="controls views">
										<?php echo nl2br($vals['message']); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<?php } } ?>
								</fieldset>
								<?php 
								$attributes = array('class' => 'form-horizontal', 'id' => 'add_amenties');
							echo form_open(ADMIN.'/messages/view_reply/'.$this->uri->segment(4).'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
								?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="username">To<span class="must">*</span></label>
										<div class="controls">
										<?php if($this->input->get('pagemode')=='sent'){ 
												echo '@'.$messages[0]['display_name'];
										echo '<input type="hidden" id="js-webuser-reply-id" name="reply_user_id" value="'.$messages[0]['to_user_id'].'">';
										} else {
											echo '@'.$messages[0]['display_name'];
										echo '<input type="hidden" id="js-webuser-reply-id" name="reply_user_id" value="'.$messages[0]['from_user_id'].'">';
										}
										?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username">Message<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'message','class'=> 'span5','id'=>'message','value'=>set_value('message', $this->input->post('message') ? $this->input->post('message') : ''),'rows'=>'4')); ?>
										<span class="text-danger"><?php echo form_error("message"); ?></span>	
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
								
									<?php echo '<input type="hidden" name="message_id" value="'.$this->uri->segment(4).'">'; ?>
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_high_important', '1',TRUE); ?> High Important
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Send','title'=>'Send')).'&nbsp;';
										
										if(isset($_GET['modestatus']))    
										{
										$c_url=base_url().ADMIN.'/messages/';
										echo anchor($c_url.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel'));
										}else
										{
										$c_url=base_url().ADMIN;
										echo anchor($c_url,'Cancel',array('class'=>'btn','title'=>'Cancel'));
										}
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
