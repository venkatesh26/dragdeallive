<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="fa fa-group color-theme-1"></i> Edit group</h2>
                <div class="box-icon">
                </div>
            </div>
			<form id="group_form_url" class="js-customer-edit" action="<?php echo base_url().'groups/edit_group/'.$groups_info['id'];?>">
			<div class="box-content clearfix">
                 <div class="control-group">
                    <div class="controls">
						<div class="form-group col-md-4">
							<label class="control-label" for="name">Name *</label>
							<input type="text" name="name" class="form-control" id="name" value="<?php echo $groups_info['name'];?>">
						</div>
						<div class="form-group col-md-8">
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<div class="form-group col-md-12">
						<label class="control-label" for="is_active">Status</label>
						<br/>
							<input type="checkbox" name="is_active" id="is_active"  data-no-uniform="true" class="iphone-toggle" checked="<?php if($groups_info['is_active']==1){echo "checked";};?>">
						</div>
					</div>
                </div>
				<div class="form-group col-md-4 form-actions">
					<button class="btn btn-primary btn-md pull-left">Submit</button>
					<a class="btn btn-primary btn-md pull-left" href="<?php echo base_url().'my-groups';?>">Cancel</a>
				</div>
            </div>
			</form>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->