<article class="content dashboard-page customer-add-page">
<div class="white-bg">
	<div class="title-search-block">
		<div class="title-block1">
			<div class="row">
				<div class="col-md-6">
				   <h3 class="title">
					  <i class="fa fa-money"></i> Sms Credit
				   </h3>
				   <p class="title-description">&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->load->view('campaigns/sms_info',array(),true);?>
	<section class="section">
		<div class="row sameheight-container">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
				<div class="card">
				   <div class="card-block">
						<div class="title-block">
							<h3 class="title" style="font-size:16px;"> <b> <i class="fa fa-tag"></i>  Choose Sms Plan</b> </h3>
						</div>
						<form action="<?php echo base_url().'customers/sms_credit';?>" method="post" id="sms_pack">
							<div class="row">
								<div class="form-group col-md-4"> 
									<select class="form-control" name="sms_pack" id="sms_pack_list">
									    <option value=''>Choose Plan</option>
										<option value="bronze" rel="1000">Bronze Pack - <b>1,000 sms</b></option>
										<option value="sliver" rel="2000">Sliver Pack - <b>2,000 sms</b></option>
										<option value="gold" rel="5000">Gold Pack - <b>5,000 sms</b></option>
										<option value="platinum" rel="10000">Platinum Pack - <b>10,000 sms </b></option>
										<option value="custom" rel="0">Custom Pack </option>
									</select>
								</div>
								<div class="form-group col-md-2" style="display:none;" id="cost_section" rel="<?php echo $sms_cost; ?>"> 
									<label class="control-label" for="sms_cost"></label>
									<input type="number" min="10" class="form-control" max="10000" id="total_sms" name="total_sms" placeholder="Amount">
								</div>
								<div class="form-group col-md-4"> 
									<label class="control-label" for="email"></label>
									<button class="btn btn-primary btn-md clearfix"><i class="fa fa-shopping-cart color-theme-1" style="color:#fff"></i> Purchase Plan</button>
								</div>
								<div class="form-group col-md-12" id="sms_info_section" style="display:none;"> 
									<div class="form-group col-md-4"> 
										<i class="fa fa-comment-o"></i> Per sms Cost - <span><b><?php echo $sms_cost; ?></b></span> 
									</div> 
									<div class="form-group col-md-4"> 
										<i class="fa fa-list-alt"></i> No of.Sms Credit - <span><b id="no_of_sms"> </b></span>
									</div>
									<div class="form-group col-md-4"> 
										<i class="fa fa-money"></i> Total Sms Cost - <span><b id="total_cost">  </b></span>
									</div>
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
$(document).ready(function(){
	$('#sms_pack').livequery('submit',function(){
		$.LoadingOverlay("show");
		var url=$("#sms_pack").attr('action');
		var $this=$(this);	 
		var form = $('#sms_pack')[0]; 
        var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: url,
			data:formData,
			datatype:"json",
			contentType: false,
            processData: false,
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") {
					$("#sms_pack input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err") {
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else {
						
						$("#sms_pack input").each(function() {
							$(this).next('span').remove();
					    });
						$("#sms_pack select").each(function() {
							$(this).next('span').remove();
					    });
						if(typeof data.errorfields!='undefined'){
							$.each(data.errorfields,function(key, value){
								var error="<span class='login-error'>"+value.error+"</span>";
								$this.find("[name="+value.field+"]").after(error);
							});
							alert_notification('error','<i class="fa fa-info-circle"></i> Please Complete the required fields.');
						}
					}
				}
				else
				{
					$("#sms_pack input,select,textarea").each(function() {
							$(this).next('span').remove();
					});
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
	
	
	$('#sms_info_section').hide();
   var sms_cost=$('#cost_section').attr('rel');
   $('#total_sms').on('keyup',function(){
	   if($(this).val() > 0){
	    var noOfSms=Math.round($(this).val() / sms_cost);
		$('#no_of_sms').html(noOfSms);
		$('#total_cost').html($(this).val());
	    $('#sms_info_section').show();
	   }
	   else {
		   $('#sms_info_section').hide();
	   }
    });
	
	$('#sms_pack_list').on('change',function(){
		if($(this).val()=='custom'){
			$('#cost_section').show();
			$('#sms_info_section').hide();
		}
		else {
		  $('#cost_section').hide();	  
		  $('#total_cost').html('');
		  var total_sms=$('option:selected', this).attr('rel');
	      $('#no_of_sms').html(total_sms);
		  var cost=total_sms * sms_cost;
		  $('#total_cost').html(cost);	
		  $('#sms_info_section').show();
		}
	});	
});
</script>