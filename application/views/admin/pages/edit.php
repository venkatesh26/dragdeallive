<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-credit-card"></i>
	      				<h3>Pages - <?php echo $pages['title']; ?> - Edit</h3>
						<span class="create_new"><?php echo $this->breadcrumbs->show(); ?></span>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<div class="tabbable">
							<div class="tab-pane" id="formcontrols">
							<?php
							$attributes = array('class' => 'form-horizontal', 'id' => 'pages_edit');
							echo form_open(ADMIN.'/pages/edit/'.$this->uri->segment(4).'?pagemode='.$this->input->get('pagemode').'&modestatus='.$this->input->get('modestatus').'&sortingfied='.$this->input->get('sortingfied').'&sortype='.$this->input->get('sortype'), $attributes);
							?>
								<fieldset>
									<br/>
									<div class="widget-header" style="padding-left:10px;" >Page Information</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="username">Name<span class="must">*</span></label>
										<div class="controls">
										<?php echo form_input(array('name'=>'title','value'=>set_value('title', $this->input->post('title') ? $this->input->post('title') : $pages['title']),'class'=> 'span3','id'=>'title') ); ?>
										<span class="text-danger"><?php echo form_error('title'); ?></span>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="username">Content<span class="must">*</span></label>
										<div class="controls">
										<?php 
										$txtattribute = array('name'=>'content','id'=>'content','value'=>$pages['content']);
										echo form_textarea($txtattribute); 
										echo display_ckeditor($txtattribute);
										?>
										<span class="text-danger"><?php echo form_error('content'); ?></span>
										<?php echo display_ckeditor($ckeditor); ?>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="widget-header" style="padding-left:10px;" >SEO Settings	</div>
									<br />
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta keywords</label>
										<div class="controls">
											<textarea class="span3" name="meta_keywords"><?php echo $pages['meta_keywords']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									<div class="control-group">											
										<label class="control-label" for="lastname">Meta Description</label>
										<div class="controls">
											<textarea class="span3" name="meta_description"><?php echo $pages['meta_description']?></textarea>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
										
									<div class="form-actions">
										<?php echo form_submit(array('class'=>'btn btn-primary','value'=>'Save','title'=>'Save')).'&nbsp;';
										echo anchor(base_url().ADMIN.'/pages/'.$this->input->get('pagemode').'/'.$this->input->get('modestatus').'/'.$this->input->get('sortingfied').'/'.$this->input->get('sortype'),'Cancel',array('class'=>'btn','title'=>'Cancel')); ?>
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