<div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-plus"></i>
						<h3>Create Short URL</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
					<form id="create_after_login_url" action="<?php echo base_url();?>/ShortUrls/add" class="form-horizontal">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="name">Name<span class="required">*</span></label>
											<div class="controls">
												<input autocomplete="off" type="text" class="span4" id="name" name="name">
												<p class="help-block">Your name is for searching in and cannot be changed.</p>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="firstname">Long URL<span class="required">*</span></label>
											<div class="controls">
												<input autocomplete="off" type="text" class="span6" name="long_url" id="long_url" value="">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
					<br/><br/>
					<br/>
										
											
										<div class="form-actions">
											<button type="submit" class="btn btn-primary">Create Short URL</button> 
											<a class="btn" href="<?php echo base_url();?>shorturls">Cancel</a>
										</div> <!-- /form-actions -->
									</fieldset>
								
								</form>

						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->	
				
		    </div> <!-- /spa12 -->
			<br/>
	      </div>
		  
		  
		  <!-- Modal -->
<div id="copyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Short URL</h4>
      </div>
      <div class="modal-body">
			<div class="controls">
				<input autocomplete="off" disabled type="text" class="span4" id="short_url" name="short_url">&nbsp;<a href="javascript:void(0);"  class="js-copy"><i class="icon-copy"></i></a>
			</div>
	       <p>Preview </p>
			<iframe src="" id="iframe-src">
				alternative content for browsers which do not support iframe.
			</iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>