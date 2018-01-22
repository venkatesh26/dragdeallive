<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-envelope-alt"></i>
	      				<h3>Messages - New</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'add_amenties','autocomplete'=>'off');
							echo form_open_multipart(ADMIN.'/messages/add?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="username">User Type<span class="must"></span></label>
										<div class="controls">
										<?php foreach($this->config->item('user_roles') as $rolkey=>$rolval){
												echo form_radio('user_type',$rolkey,'').' '.'<span style="margin-top:5px;">'.$rolval.'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
											  } ?>
											<input type="hidden" name='user_type_val' id="user_type_val" value="" >
										<span class="text-danger"><?php echo form_error('name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="auto_username">Display Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'auto_username'),$this->input->post('name')); ?> (To add multiple users by auto filling)
										<span class="text-danger"><?php echo form_error('users_id'); ?></span>
										</div> <!-- /controls -->
										<div id="users_div">
											<?php 
												if(count($re_users)) {
													foreach($re_users as $usersshidden) { ?>
												<input id="users_<?php echo $usersshidden->id; ?>" class="txtoption" type="hidden" value="<?php echo $usersshidden->id; ?>" name="users_id[]">
												<?php } } 
											?>
										</div>
										<div class="suitables-outer">
											<div class="">
												<ul id="carousel2">
												<?php 
												if(count($re_users)) {
													foreach($re_users as $usersVals) { ?>
													<li><span class="auctionadd"><?php echo $usersVals->display_name; ?><a title="close" rel="<?php echo $usersVals->id; ?>" class="users_close" id="close_<?php echo $usersVals->id; ?>" href="javascript:void(0);">close</a></span></li>
												<?php } } ?>
												</ul>
											</div>
										</div>
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="message">Message<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_textarea(array('name'=>'message','class'=> 'span5','id'=>'message','value'=>set_value('message', $this->input->post('message') ? $this->input->post('message') : ''),'rows'=>'4')); ?>
										<span class="text-danger"><?php echo form_error("message"); ?></span>	
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="username"></label>
										<div class="controls">
										<label class="checkbox inline">
											<?php echo form_checkbox('is_high_important', '1',''); ?> High Important
                                        </label>
                                        </div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/messages/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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
