<?Php
$amount='';
$minimum_amount='';
if(!empty($reward_points_data)){
	
	foreach($reward_points_data as $point_data){
		if($point_data['code']=='reward-point-amount'){
			$amount=$point_data['value'];
		}
		
		if($point_data['code']=='reward-point-minimum-amount'){
			$minimum_amount=$point_data['value'];
		}
	}
}
?>
<article class="rewardsettings content cards-page white-bg-art" style="background:#fff">
	<div class="bread-crumb-data">
	   <?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <section class="section">
      <div class="col-xl-12">
	  
         <div class="card sameheight-item border-card-section">
            <div class="card-block">
			 
               <!-- Nav tabs -->
               <div class="card-title-block">
                  <h3 class="title">
                    <i class="fa fa-gift"></i> Reward Settings
                  </h3>
               </div>

               <!-- Tab panes -->
               <div class="tab-content tabs-bordered">
				   <form id="rewardpoint_form_form_url" action="<?php echo base_url().'Customers/reward_settings';?>" method="Post">
						<div class="box-content clearfix">
								<span class="mand_field_title">  * Fields are mandatory </span> </span>
								<div class="control-group">
									<div class="controls">
									<div class="row">
										<div class="form-group col-md-6">
											<label class="control-label" for="name">How much purchase amount to earn one reward point?<span style="color:red;"> *</span></label>
											<div class="clearfix col-md-5" style="margin-top:10px;">
												One Reward Point  = 
											</div>
											<div class="col-md-3">
												<input width="40%" min="0" value="<?php echo $amount;?>" type="number" class="form-control" id="amount" name="amount" autocomplete="off">
											</div>
										
										</div>
									</div>
									<div class="row">
									<div class="form-group col-md-12">
											<span class="info-text"><i class="fa fa-info-circle"></i> Customer Purchased Bill Amount = 1000<br>
											<i class="fa fa-info-circle"></i> One reward point = 2 <br>
											<i class="fa fa-info-circle"></i> Total Reward Points 1000 / 2 = 500 points </span>	
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6">
											<label class="control-label" for="name">What is the minimum purchase amount required to earn reward points ?<span style="color:red;"> *</span></label>
											<div class="clearfix col-md-5" style="margin-top:10px;">
												Min. purchase amount  = 
											</div>
											<div class="col-md-3">
											
											<input value="<?php echo $minimum_amount;?>"  type="number" class="form-control" id="minimum_amount" name="minimum_amount" placeholder="Enter minimum amount" autocomplete="off">
											</div>
										</div>
									</div>

									<div class="row">
									
									<div class="form-group col-md-6"> 
									<label class="control-label" for="email"></label>
									<button class="btn btn-primary btn-md clearfix pull-right"><i class="fa fa-gift color-theme-1" style="color:#fff"></i> Update</button>
									</div>
									</div>
								</div>
						</div>
					</form>
               </div>
            <!-- /.card-block -->
         </div>
		 </div>
         <!-- /.card -->
      </div>
	
   </section>
</article>
<script>
$(document).ready(function() {
	$('#rewardpoint_form_form_url').livequery('submit',function(){
		var url=$("#rewardpoint_form_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#rewardpoint_form_form_url").serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				
				if(data.status=="error") {
					$("#rewardpoint_form_form_url input").each(function() {
						$(this).next('span.login-error').remove();
					});
					$('.rate_it_error').html('');
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else if(data.sts=="custom_mess_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{	
				
						$("#rewardpoint_form_form_url input").each(function() {
							$(this).next('span.login-error').remove();
					    });
						
						if(typeof data.errorfields!='undefined' && data.errorfields.length > 0)
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
							if(value.field=='score'){
									$('.rate_it_error').html(error);
							} else {
									$this.find("[name="+value.field+"]").after(error);
							}
						});
						
						alert_notification('error','Please complete the required fields.');
					}
				}
				else {
					$("#rewardpoint_form_form_url input").each(function() {
						$(this).next('span.login-error').remove();
					});
					alert_notification('success','Rewards Updated Successfully');
				}	
			}
		});
		return false;
	});
});
</script>
