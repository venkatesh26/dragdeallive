<article class="content dashboard-page customer-add-page">
<div class="white-bg">
	<div class="title-search-block">
		<div class="title-block1">
			<div class="row">
				<div class="col-md-6">
				   <h3 class="title">
					  <i class="fa fa-briefcase"></i> Claim My Bussiness 
				   </h3>
				  <br>
				</div>
			</div>
		</div>
	</div>
	<section class="section">
		<div class="row sameheight-container">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
				<div class="card">
				   <div class="card-block">
						<form action="<?php echo base_url().'customers/claim_bussiness';?>" method="post" id="claim_bussiness">
							<div class="row">
								<div class="form-group col-md-8"> 
								<label><i class="fa fa-envelope"></i>  Message <span style="color:red;">*</span> </label>
									<textarea type="text" name="message" placeholder="Enter Your Concerns" class="form-control"></textarea>
								</div>
								<div class="form-group col-md-8"> 
									<label><i class="fa fa-globe"></i>  URl <span style="color:red;">*</span>	<span style="font-size:12px;">( Ex:https://www.dragdeal.com/business/1948074/google-india/chennai )</span> </label>
									<input type="text" name="url" class="form-control">
								
								</div>
								<div class="form-group col-md-8"> 
									<label class="control-label" for="email"></label>
									<button class="btn btn-primary btn-md clearfix pull-right"><i class="fa fa-briefcase color-theme-1" style="color:#fff"></i> Claim My Bussiness</button>
								</div>
								<div class="box-content clearfix">
					<p class="pull-right"><i class="fa fa-info-circle"></i> Enter Your Bussiness
					Url You want Calim It.Once Our team verfied then your account will be link to your bussiness account.</p>
				</div>
							</div>
						</form>
				   </div>
				</div>
		</div>
	</section>
	</div>
</article>
<script>
$(document).ready(function() {
	$('#claim_bussiness').livequery('submit',function(){
		var url=$("#claim_bussiness").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#claim_bussiness").serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				
				if(data.status=="error") {
					$("#claim_bussiness input").each(function() {
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
				
						$("#claim_bussiness input").each(function() {
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
					$("#claim_bussiness textarea").each(function() {
							$(this).next('span.login-error').remove();
					});
					$('#message').val('');
					location.reload();
				}	
			}
		});
		return false;
	});
});
</script>