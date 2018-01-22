<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Export Data</h3>
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
							echo form_open_multipart(ADMIN.'/export_datas');
							?>
								<fieldset>
									<br/>
									<div class="control-group">											
										<label class="control-label" for="name">City Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'city','class'=> 'span3','id'=>'city','value'=>'chennai'),$this->input->post('city')); ?>
										<span class="text-danger"><?php echo form_error('city'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
										<div class="control-group">											
										<label class="control-label" for="name">Limit Start<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'limit_start','class'=> 'span3','id'=>'limit_start','value'=>0),$this->input->post('limit_start')); ?>
										<span class="text-danger"><?php echo form_error('limit_start'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									
										<div class="control-group">											
										<label class="control-label" for="name">Limit End<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'limit_end','class'=> 'span3','id'=>'limit_end','value'=>300000),$this->input->post('limit_end')); ?>
										<span class="text-danger"><?php echo form_error('limit_end'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
																		
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Excel Export','title'=>'Export')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/dashboard/','Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
									</div> <!-- /form-actions -->
								</fieldset>
							<?php echo form_close(); ?>
									  
								
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