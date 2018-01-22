<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="fa fa-group color-theme-1"></i> Add group</h2>
                <div class="box-icon">
                </div>
            </div>
			<form id="group_form_url" class="js-customer-edit" action="<?php echo base_url().'groups/add_group';?>">
			<div class="box-content clearfix">
                 <div class="control-group">
                    <div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="name">Name *</label>
							<input type="text" name="name" class="form-control" id="name">
						</div>
						<div class="form-group col-md-8">
						</div>
					</div>
                </div>
				<div class="control-group">
					<div class="controls">
						<div class="form-group col-md-12">
						<label class="control-label" for="is_active">Status</label>
							<input type="checkbox" name="is_active" id="is_active"  data-no-uniform="true" class="iphone-toggle" checked="checked">
						</div>
					</div>
				</div>
				 <div class="controls">
					<div class="form-group col-md-4 form-actions">
						<button class="btn btn-primary btn-md pull-left">Submit</button>
						<a class="btn btn-primary btn-md pull-left" href="my-groups">Cancel</a>
					</div>
				 </div> 
            </div>
			</form>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->