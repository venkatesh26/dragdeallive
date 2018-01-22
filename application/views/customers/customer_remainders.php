<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-time color-theme-1"></i> Customer Remainders</h2>
                <div class="box-icon">
                </div>
            </div>
			<form id="remainder_settings_form_url" class="js-customer-edit" action="<?php echo base_url().'customers/customers_remainders';?>">
			<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-cog color-theme-1"></i> Birthday Remainder Settings</h2>
				</div>
				<h2></h2>
                <div class="control-group">
                    <div class="controls">
						<div class="form-group col-md-12">
							<label class="control-label" for="birthday_message">Birthday Remainder Message *</label>
							<textarea class="form-control" id="birthday_message" rows="5" name="birthday_message"><?php if(isset($remainder_datas['birthday_remainder']['message'])){echo $remainder_datas['birthday_remainder']['message'];}?></textarea>
							<span class="feedbackError error"></span>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label" for="birthday_remainder_start_before_days">Remainder Before Days *</label>
							<input class="form-control" id="birthday_remainder_start_before_days" name="birthday_remainder_start_before_days" type="number" value="<?php if(isset($remainder_datas['birthday_remainder']['remainder_start_before_days'])){echo $remainder_datas['birthday_remainder']['remainder_start_before_days'];}?>">
							<span class="feedbackError error"></span>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label" for="birthday_remainder_end_after_days">Remainder After Days *</label>
							<input class="form-control" id="birthday_remainder_end_after_days" name="birthday_remainder_end_after_days" type="number" value="<?php if(isset($remainder_datas['birthday_remainder']['remainder_end_after_days'])){echo $remainder_datas['birthday_remainder']['remainder_end_after_days'];}?>">
							<span class="feedbackError error"></span>
							<input type="hidden" name="birthday_remainder_id" id="birthday_remainder_id" value="<?php if(isset($remainder_datas['birthday_remainder']['id'])){echo $remainder_datas['birthday_remainder']['id'];}?>">
						</div>
						<div class="form-group col-md-2">
							<label class="control-label" for="birthday_is_active"> Status </label>
							<br/>
								<input type="checkbox" name="birthday_is_active" id="birthday_is_active"  data-no-uniform="true" class="iphone-toggle" <?php if(isset($remainder_datas['birthday_remainder']['is_active']) && $remainder_datas['birthday_remainder']['is_active']==1){echo "checked=checked";};?>>
						</div>
					</div>
                </div>
            </div>
			<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-cog color-theme-1"></i> Aniversery Remainder Settings</h2>
				</div>
				<h2></h2>
                <div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-12">
						<label class="control-label" for="anversey_message">Aniversery Remainder Message *</label>
						<textarea class="form-control" id="anversey_message" rows="5" name="anversey_message" ><?php if(isset($remainder_datas['aninversery_remainder']['message'])){echo $remainder_datas['aninversery_remainder']['message'];}?></textarea>
						<span class="feedbackError error"></span>
                    </div>
					</div>
						<div class="form-group col-md-3">
							<label class="control-label" for="anversey_remainder_start_before_days">Remainder Before Days *</label>
							<input class="form-control" id="anversey_remainder_start_before_days" name="anversey_remainder_start_before_days" type="number" value="<?php if(isset($remainder_datas['aninversery_remainder']['remainder_start_before_days'])){echo $remainder_datas['aninversery_remainder']['remainder_start_before_days'];}?>">
							<span class="feedbackError error"></span>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label" for="anversey_remainder_end_after_days">Remainder After Days *</label>
							<input class="form-control" id="anversey_remainder_end_after_days" name="anversey_remainder_end_after_days" type="number" value="<?php if(isset($remainder_datas['aninversery_remainder']['remainder_end_after_days'])){echo $remainder_datas['aninversery_remainder']['remainder_end_after_days'];}?>">
							<span class="feedbackError error"></span>
							<input type="hidden" name="anversey_remainder_id" id="anversey_remainder_id" value="<?php if(isset($remainder_datas['aninversery_remainder']['id'])){echo $remainder_datas['aninversery_remainder']['id'];}?>">
						</div>
						<div class="form-group col-md-2">
							<label class="control-label" for="anversey_is_active"> Status </label>
							<br/>
								<input type="checkbox" name="anversey_is_active" id="anversey_is_active"  data-no-uniform="true" class="iphone-toggle" <?php if(isset($remainder_datas['aninversery_remainder']['is_active']) && $remainder_datas['aninversery_remainder']['is_active']==1){echo "checked=checked";};?>>
								
								
						</div>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
					<button class="btn btn-primary btn-lg pull-right">Save Remainder</button>
				<br>
				<br>
				<br><br>
            </div>
			</form>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->