
<article class="content cards-page white-bg-art" style="background:#fff">
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
                    <i class="fa fa-lock"></i> Change Password
                  </h3>
               </div>

               <!-- Tab panes -->
               <div class="tab-content tabs-bordered">
				   <form id="changepassword_form_form_url" action="<?php echo base_url().'Customers/change_password';?>" method="Post">
						<div class="box-content clearfix">
								<span class="mand_field_title">  * Fields are mandatory </span> </span>
								<div class="control-group">
									<div class="controls">
									<div class="row">
										<div class="form-group col-md-6">
											<label class="control-label" for="name">New Password<span style="color:red;"> *</span></label>
											<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter New Password" autocomplete="off">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6">
											<label class="control-label" for="owner">Confirm Password<span style="color:red;"> *</span></label>
											<input type="password" class="form-control" id="confirm_password" name="confirm_password"  placeholder="Enter Confirm Password" autocomplete="off">
										</div>
									</div>
									<div class="row">
									
									<div class="form-group col-md-6"> 
									<label class="control-label" for="email"></label>
									<button class="btn btn-primary btn-md clearfix pull-right"><i class="fa fa-lock color-theme-1" style="color:#fff"></i> Change Password</button>
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
	$('#changepassword_form_form_url').livequery('submit',function(){
		var url=$("#changepassword_form_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#changepassword_form_form_url").serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				
				if(data.status=="error") {
					$("#changepassword_form_form_url input").each(function() {
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
				
						$("#changepassword_form_form_url input").each(function() {
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
					$("#changepassword_form_form_url input").each(function() {
						$(this).next('span.login-error').remove();
						$(this).val('');
					});
					alert_notification('success','Password Changed Successfully');
				}	
			}
		});
		return false;
	});
});
</script>
