<div class="modal fade groupmodel-popup"  id="bussiness-profile-plan">
    <div class="modal-dialog" role="document">
		<div class="modal-content" style="background:#ddd;">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-tag"></i> Almost Done !</h4> 
			</div>

				<div class="modal-body" style="height:180px;">
				<div class="col-md-12">
					<h4 style="font-size:18px;color:#85CE36;"><b>Your Profile added Successfully.Inorder Activate Your Profile Choose Your Plan.</b></h4>
				</div>
					<div class="col-md-8">
						<label class="control-label"> Choose Your Plan <span style="color:red;">*</span> </label>
							<select class="form-control plan_pack" id="my_plan">
								<option value="">Choose Plan</option>
								<option <?php if(isset($_GET['plan_id']) && $_GET['plan_id']==1){ echo "selected=selected";}?> value="1" data-price="199">Basic Plan - Rs.199 - (one time subscription) </option>
								<option <?php if(isset($_GET['plan_id']) && $_GET['plan_id']==2){ echo "selected=selected";}?> value="2" data-price="499">Brozne Plan -  Rs.499 / Month </option>
								<option <?php if(isset($_GET['plan_id']) && $_GET['plan_id']==3){ echo "selected=selected";}?> value="3" data-price="999">Sliver Plan - Rs.999 / Month</option>
								<option <?php if(isset($_GET['plan_id']) && $_GET['plan_id']==4){ echo "selected=selected";}?> value="4" data-price="1999">Gold Plan - Rs.1999 / Month </option>
							</select>
						<br/>
					</div>
					<div class="col-md-4 js_number_of_months" style="display:none;">
						<label class="control-label">Number Of Months <span style="color:red;">*</span> </label>
							<select class="form-control plan_pack" id="plan_months">
								<option <?php if(isset($_GET['no_of_months']) && $_GET['no_of_months']==1){ echo "selected=selected";}?> value="1">1 Month</option>
								<option <?php if(isset($_GET['no_of_months']) && $_GET['no_of_months']==3){ echo "selected=selected";}?> value="3">3 Months</option>
								<option <?php if(isset($_GET['no_of_months']) && $_GET['no_of_months']==6){ echo "selected=selected";}?> value="6">6 Months</option>
								<option <?php if(isset($_GET['no_of_months']) && $_GET['no_of_months']==12){ echo "selected=selected";}?> value="12">12 Months</option>
							</select>
						<br/>
					</div>
					<div class="col-md-12 price_details" style="display:none;">
						<b><span class="plan-cost"></span> <b> / <span class="plan_months_det"> </span><span><a target="_blank" href="<?php echo base_url().'/my-plans';?>" style="color:#85CE36"> View Plan Details</a></span>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary plan_data_submit" >Pay Now</button>
				</div>
	
		</div>
    </div>		
</div>
<script>
function planCost(){
	if($('#my_plan').val() > 0 && $('#plan_months').val() > 0){
		if($('#my_plan').find('option:selected').val()!=1){
			$('.price_details').show();
			$('.plan-cost').html('Rs .'+$('#my_plan').find('option:selected').attr('data-price') * $('#plan_months').val());
			
			if($('#plan_months').val()==1){
				$('.plan_months_det').html('Per Month');
			}
			else{
				$('.plan_months_det').html('Per '+ $('#plan_months').val() +' Months');
			}
			$('.plan_data_submit').attr('disabled',false);
			$('.js_number_of_months').show();
		}
		else{
			if($('#my_plan').find('option:selected').val()==1){
				$('.js_number_of_months').hide();
				$('.plan_data_submit').attr('disabled',false);
			}
			else {
				$('.plan_data_submit').attr('disabled',true);
				$('.js_number_of_months').show();
			}
			$('.price_details').hide();
		}
	}
	else{
		$('.price_details').hide();
		$('.plan_data_submit').attr('disabled',true);
	}
}
$(document).ready(function(){

	$('.plan_data_submit').attr('disabled',true);
		$('#my_plan').livequery('change',function(){
			planCost();
			return false;
		});
		$('#plan_months').livequery('change',function(){
			planCost();
			return false;
		});
		
	$('#my_plan').trigger('change');	
	$('.plan_data_submit').livequery('click',function(){
		window.location.href = __cfg('path_absolute')+'customers/buyPlan?plan_id='+$('#my_plan').val()+'&no_of_months='+$('#plan_months').val();
		return false;
	});
});
</script>