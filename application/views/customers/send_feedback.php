<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-briefcase color-theme-1"></i> Send Feedback</h2>
                <div class="box-icon">
                </div>
            </div>
			<form id="feedback_form_url" class="js-customer-edit" action="<?php echo base_url().'customers/send_feedback';?>">
			<div class="box-content clearfix">
				<div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-bullhorn color-theme-1"></i> Enter Your Message</h2>
				</div>
				<h2></h2>
                <div class="control-group">
                    <div class="controls">
					<div class="form-group col-md-12">
						<label class="control-label" for="description">Message *</label>
						<textarea class="form-control" id="message" rows="10" name="message"></textarea>
						<span class="feedbackError error"></span>
                    </div>
					</div>
					<br>
                </div>
                <div class="">
                    <label>
                    </label>
                </div>
					<button class="btn btn-primary btn-lg pull-right">Send</button>
				<br>
				<br>
				<br><br>
            </div>
			</form>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->