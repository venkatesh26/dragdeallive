<?php
$data = $data[0];
$result = @unserialize($data['setting_fields']);
?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-wrench"></i>
	      				<h3>General Settings</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'edit-profile');
							echo form_open(ADMIN.'/settings/'.$this->uri->segment(4).'', $attributes);
							?>
							<?php 
							if($this->session->flashdata('flash_message')){
								if($this->session->flashdata('flash_message') == 'updated')
								{
								  echo '<div class="alert alert-success">';
									echo '<button data-dismiss="alert" class="close" type="button">×</button>';
									echo '<strong>Well done!</strong> Settings updated with success.';
								  echo '</div>';       
								}else{
								  echo '<div class="alert alert-error">';
									echo '<a class="close" data-dismiss="alert">×</a>';
									echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
								  echo '</div>';          
								}
							  }
							?>
								<fieldset>
									<div class="widget-header" style="padding-left:10px;" >Basic Informations	</div>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="username">Website Name</label>
										<div class="controls">
										<?php echo form_input(array('name'=>'site_name','value'=>set_value('site_name', $this->input->post('site_name') ? $this->input->post('site_name') : $data['sitename']),'class'=> 'span3','id'=>'site_name') ); ?>
										<span class="text-danger"><?php echo form_error('site_name'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="firstname">Support Email ID</label>
										<div class="controls">
											<?php echo form_input(array('name'=>'fields[email_address]','value'=>set_value('fields[email_address]', $this->input->post('fields[email_address]') ? $this->input->post('fields[email_address]') : $result['email_address']),'class'=> 'span3','id'=>'email_address') );?>
											<span class="text-danger"><?php echo form_error('fields[email_address]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Contact No</label>
										<div class="controls">
											<?php echo form_input(array('name'=>'fields[contact]','value'=>set_value('fields[contact]', $this->input->post('fields[contact]') ? $this->input->post('fields[contact]') : $result['contact']),'class'=> 'span2','id'=>'contact','maxlength'=>12) ); ?>
											<span class="text-danger"><?php echo form_error('fields[contact]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="email">Back end Paging</label>
										<div class="controls">
											<?php echo form_input(array('name'=>'fields[back_pagination]','value'=>set_value('fields[back_pagination]', $this->input->post('fields[back_pagination]') ? $this->input->post('fields[contact]') : $result['back_pagination']),'class'=> 'span1','id'=>'back_pagination','maxlength'=>2) ); ?>
											<span class="text-danger"><?php echo form_error('fields[back_pagination]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="password1">Front end Paging</label>
										<div class="controls">
											<?php echo form_input(array('name'=>'fields[front_pagination]','value'=>set_value('fields[front_pagination]', $this->input->post('fields[front_pagination]') ? $this->input->post('fields[contact]') : $result['front_pagination']),'class'=> 'span1','id'=>'front_pagination','maxlength'=>2) ); ?>
											<span class="text-danger"><?php echo form_error('fields[front_pagination]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
																		
									<br />
									<div class="widget-header" style="padding-left:10px;" >Payu Money Settings	</div>
									<br />
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Merchent Key</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[merchant_key]','value'=>set_value('fields[merchant_key]', $this->input->post('fields[merchant_key]') ? $this->input->post('fields[merchant_key]') : $result['merchant_key']),'class'=> 'span3','id'=>'merchant_key') ); ?>
											<span class="text-danger"><?php echo form_error('fields[merchant_key]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Merchent Salt</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[merchant_salt]','value'=>set_value('fields[merchant_salt]', $this->input->post('fields[merchant_salt]') ? $this->input->post('fields[merchant_salt]') : $result['merchant_salt']),'class'=> 'span3','id'=>'merchant_salt') ); ?>
											<span class="text-danger"><?php echo form_error('fields[merchant_salt]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">PayUrl</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[pay_url]','value'=>set_value('fields[pay_url]', $this->input->post('fields[pay_url]') ? $this->input->post('fields[pay_url]') : $result['pay_url']),'class'=> 'span3','id'=>'pay_url') ); ?>
											<span class="text-danger"><?php echo form_error('fields[pay_url]'); ?></span>
											<br />
										    Test Mode - https://test.payu.in <br>
                                            Live Mode : - https://secure.payu.in									
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										<br />
									<div class="widget-header" style="padding-left:10px;" >Instamojo Settings	</div>
									<br />
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Api Key</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[insta_api_key]','value'=>set_value('fields[insta_api_key]', $this->input->post('fields[insta_api_key]') ? $this->input->post('fields[insta_api_key]') : $result['insta_api_key']),'class'=> 'span3','id'=>'insta_api_key') ); ?>
											<span class="text-danger"><?php echo form_error('fields[insta_api_key]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Auth Key</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[insta_auth_key]','value'=>set_value('fields[insta_auth_key]', $this->input->post('fields[insta_auth_key]') ? $this->input->post('fields[insta_auth_key]') : $result['insta_auth_key']),'class'=> 'span3','id'=>'insta_auth_key') ); ?>
											<span class="text-danger"><?php echo form_error('fields[insta_auth_key]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<br />
										<div class="widget-header" style="padding-left:10px;" >Sms Settings</div>
									<br />
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Total Sms</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[total_sms]','value'=>set_value('fields[total_sms]', $this->input->post('fields[total_sms]') ? $this->input->post('fields[total_sms]') : $result['total_sms']),'class'=> 'span3','id'=>'total_sms') ); ?>
											<span class="text-danger"><?php echo form_error('fields[total_sms]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Api Key</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[api_key]','value'=>set_value('fields[api_key]', $this->input->post('fields[api_key]') ? $this->input->post('fields[api_key]') : $result['api_key']),'class'=> 'span3','id'=>'api_key') ); ?>
											<span class="text-danger"><?php echo form_error('fields[api_key]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">SenderID 1</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[sender_id1]','value'=>set_value('fields[sender_id1]', $this->input->post('fields[sender_id1]') ? $this->input->post('fields[sender_id1]') : $result['sender_id1']),'class'=> 'span3','id'=>'sender_id1') ); ?>
											<span class="text-danger"><?php echo form_error('fields[sender_id1]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">SenderID 2</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[sender_id2]','value'=>set_value('fields[sender_id2]', $this->input->post('fields[sender_id2]') ? $this->input->post('fields[sender_id2]') : $result['sender_id2']),'class'=> 'span3','id'=>'sender_id2') ); ?>
											<span class="text-danger"><?php echo form_error('fields[sender_id2]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Sms Cost - Per sms</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[sms_cost]','value'=>set_value('fields[sms_cost]', $this->input->post('fields[sms_cost]') ? $this->input->post('fields[sms_cost]') : $result['sms_cost']),'class'=> 'span3','id'=>'sms_cost') ); ?>
											<span class="text-danger"><?php echo form_error('fields[sms_cost]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									
									<div class="widget-header" style="padding-left:10px;" >Payment Information	</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Paypal Email</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[paypal_email]','value'=>set_value('fields[paypal_email]', $this->input->post('fields[paypal_email]') ? $this->input->post('fields[paypal_email]') : $result['paypal_email']),'class'=> 'span3','id'=>'paypal_email') ); ?>
											<span class="text-danger"><?php echo form_error('fields[paypal_email]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="widget-header" style="padding-left:10px;" >Footer Email	</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Footer Email</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[footer_email]','value'=>set_value('fields[footer_email]', $this->input->post('fields[footer_email]') ? $this->input->post('fields[footer_email]') : $result['footer_email']),'class'=> 'span3','id'=>'footer_email') ); ?>
											<span class="text-danger"><?php echo form_error('fields[footer_email]'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										<div class="widget-header" style="padding-left:10px;" >Social Media Links	</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Facebook</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[facebook_link]','value'=>set_value('fields[facebook_link]', $this->input->post('fields[facebook_link]') ? $this->input->post('fields[facebook_link]') : $result['facebook_link']),'class'=> 'span3','id'=>'facebook_link') ); ?>
											<span class="text-danger"><?php echo form_error('fields[facebook_link]'); ?></span>
										</div> <!-- /controls -->	

										<label class="control-label" for="lastname">Twitter</label>
										<div class="controls">
											<?php  echo form_input(array('name'=>'fields[twitter_link]','value'=>set_value('fields[twitter_link]', $this->input->post('fields[twitter_link]') ? $this->input->post('fields[twitter_link]') : $result['twitter_link']),'class'=> 'span3','id'=>'twitter_link') ); ?>
											<span class="text-danger"><?php echo form_error('fields[twitter_link]'); ?></span>
										</div> <!-- /controls -->	

										<label class="control-label" for="lastname">Google Plus</label>
											<div class="controls">
												<?php  echo form_input(array('name'=>'fields[googleplus_link]','value'=>set_value('fields[googleplus_link]', $this->input->post('fields[googleplus_link]') ? $this->input->post('fields[googleplus_link]') : $result['googleplus_link']),'class'=> 'span3','id'=>'googleplus_link') ); ?>
												<span class="text-danger"><?php echo form_error('fields[googleplus_link]'); ?></span>
											</div> <!-- /controls -->		


										<label class="control-label" for="lastname">Youtube</label>
											<div class="controls">
												<?php  echo form_input(array('name'=>'fields[youtube_link]','value'=>set_value('fields[youtube_link]', $this->input->post('fields[youtube_link]') ? $this->input->post('fields[youtube_link]') : $result['youtube_link']),'class'=> 'span3','id'=>'youtube_link') ); ?>
												<span class="text-danger"><?php echo form_error('fields[youtube_link]'); ?></span>
											</div> <!-- /controls -->													
									</div> <!-- /control-group -->
									
								
									<div class="widget-header" style="padding-left:10px;" >SEO Settings	</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Home Page Summary</label>
										<div class="controls">
											<textarea class="span3" name="fields[home_page_summary]"><?php echo $result['home_page_summary']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta keywords</label>
										<div class="controls">
											<textarea class="span3" name="fields[Keywords]"><?php echo $result['Keywords']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
											<textarea class="span5" name="fields[description]" rows="5"><?php echo $result['description']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="widget-header" style="padding-left:10px;" >List Page SEO Settings</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Title</label>
										<div class="controls">
											<textarea class="span3" name="fields[list_keywords]"><?php echo $result['list_keywords']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
											<textarea class="span5" name="fields[list_description]" rows="5"><?php echo $result['list_description']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										<div class="control-group">											
										<label class="control-label" for="lastname">Meta Title1</label>
										<div class="controls">
											<textarea class="span3" name="fields[list_keywords1]"><?php echo $result['list_keywords1']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description1</label>
										<div class="controls">
											<textarea class="span5" name="fields[list_description1]" rows="5"><?php echo $result['list_description1']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="widget-header" style="padding-left:10px;" >Detail Page SEO Settings</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Title</label>
										<div class="controls">
											<textarea class="span3" name="fields[detail_keywords]"><?php echo $result['detail_keywords']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
											<textarea class="span5" name="fields[detail_description]" rows="5"><?php echo $result['detail_description']?></textarea>
											 <br/>
											 ##NAME##
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Common Summary</label>
										<div class="controls">
											<textarea class="span5" name="fields[common_summary]" rows="5"><?php echo $result['common_summary']?></textarea>
											 <br/>
											 ##NAME##
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Dynamic Content Link on Detail Page</label>
										<div class="controls">
											<textarea class="span5" name="fields[dynamic_content]" rows="5"><?php echo $result['dynamic_content']?></textarea>
											 <br/>
											 ##NAME##
											 ##CATEGORY##
											 ##AREA##
											 ##CITY##
											 ##LINKCATEGORY##
											 ##LINKCITY##
											 ##LINKAREA##											 
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname">Coupon Message</label>
										<div class="controls">
											<textarea class="span5" name="fields[coupon_message]" rows="5"><?php echo $result['coupon_message']?></textarea>
											 <br/>	
											 ##CODE##
											 ##NAME##											 
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
										
									<div class="form-actions">
										<button type="submit" class="btn btn-primary">Save</button> 
										<?php echo anchor(base_url().ADMIN.'/dashboard','Cancel',array('class'=>'btn')); ?>
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
