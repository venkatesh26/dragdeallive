<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Import Data</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> 
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane form-horizontal" id="formcontrols">
								<fieldset>
									<br/>
									<div class="widget-header listpadd" >Basic Informations	<span class="create_new"><?php 
									if(isset($_GET['pagemode'])) {
										echo anchor(base_url().ADMIN.'/comments/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back'); 
										} else {
												echo anchor(base_url().ADMIN.'/dashboard','<i class="icon-step-backward "></i> &nbsp;&nbsp; Go Back');
										} ?></span></div>
									<br/>
									<?php
							$attributes = array('class' => 'form-horizontal');
							echo form_open_multipart(ADMIN.'/import_datas');
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">Choose File<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_upload(array('name'=>'file_data','class'=> 'span3','id'=>'file_data')); ?>
										<?php echo form_input(array('name'=>'name','class'=> 'span3','id'=>'file_name','type'=>'hidden')); ?>
										<span class="text-danger"><?php echo form_error('file_data'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/dashboard/','Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
								</fieldset>
							<?php echo form_close(); ?>
									  <div class="control-group views1">											
										<label class="control-label" for="username">Total Rows Added:</label>
										<div class="controls views">
											<?php  echo $total_rows; ?>
										</div> <!-- /controls -->				
									  </div> <!-- /control-group -->
									  
									   <div class="control-group views1">											
										<label class="control-label" for="username">Total Rows Inserted:</label>
										<div class="controls views">
											<?php  echo $inserted_datas; ?>
										</div> <!-- /controls -->				
									  </div> <!-- /control-group -->
									  
									    <div class="control-group views1">											
										<label class="control-label" for="username">Message:</label>
										<div class="controls views">
											<?php  echo $message; ?>
										</div> <!-- /controls -->				
									  </div> <!-- /control-group -->
									  
									  <div class="control-group views1">											
										<label class="control-label" for="username">Status:</label>
										<div class="controls views">
											<?php  echo $status; ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
								
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