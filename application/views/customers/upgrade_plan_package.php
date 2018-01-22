<style>
/***
User Profile Sidebar by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
***/

/***
Content
***/
.content {
    padding: 30px 0;
}

/***
Pricing table
***/
.pricing {
  position: relative;
  margin-bottom: 15px;
  border: 3px solid #eee;
}

.pricing-active {
  border: 3px solid #85CE36;
  margin-top: -10px;
  box-shadow: 7px 7px rgba(54, 215, 172, 0.2);
}

.pricing:hover {
  border: 3px solid #36d7ac;
}

.pricing:hover h4 {
  color: #36d7ac;
}

.pricing-head {
  text-align: center;
}

.pricing-head h3,
.pricing-head h4 {
  margin: 0;
  line-height: normal;
}

.pricing-head h3 span,
.pricing-head h4 span {
  display: block;
  margin-top: 5px;
  font-size: 14px;
  font-style: italic;
}

.pricing-head h3 {
  font-weight: 300;
  color: #fafafa;
  padding: 12px 0;
  font-size: 27px;
  background: #85CE36;
  border-bottom: solid 1px #85CE36;
}

.pricing-head h4 {
  color: #bac39f;
  padding: 5px 0;
  font-size: 54px;
  font-weight: 300;
  background: #fbfef2;
  border-bottom: solid 1px #f5f9e7;
}

.pricing-head-active h4 {
  color: #36d7ac;
}

.pricing-head h4 i {
  top: -8px;
  font-size: 28px;
  font-style: normal;
  position: relative;
}

.pricing-head h4 span {
  top: -10px;
  font-size: 14px;
  font-style: normal;
  position: relative;
}

/*Pricing Content*/
.pricing-content li {
  color: #888;
  font-size: 12px;
  padding: 7px 15px;
  border-bottom: solid 1px #f5f9e7;
}

/*Pricing Footer*/
.pricing-footer {
  color: #777;
  font-size: 11px;
  line-height: 17px;
  text-align: center;
  padding: 0 20px 19px;
}

/*Priceing Active*/
.price-active,
.pricing:hover {
  z-index: 9;
}

.price-active h4 {
  color: #85CE36;
}

.no-space-pricing .pricing:hover {
  transition: box-shadow 0.2s ease-in-out;
}

.no-space-pricing .price-active .pricing-head h4,
.no-space-pricing .pricing:hover .pricing-head h4 {
  color: #85CE36;
  padding: 15px 0;
  font-size: 80px;
  transition: color 0.5s ease-in-out;
}

.yellow-crusta.btn {
  color: #FFFFFF;
  background-color: #f3c200;
}
.yellow-crusta.btn:hover,
.yellow-crusta.btn:focus,
.yellow-crusta.btn:active,
.yellow-crusta.btn.active {
    color: #FFFFFF;
    background-color: #85CE36;
}
.red-font-icon{
	color:red;
}
</style>
<?php 
   $addId=get_my_addId($this->session->userdata('user_id'));
   $dashboardData=get_customer_dashboard_data($addId);
$class="buy_plan";
?>
<article class="content dashboard-page white-bg-art">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
	  <section class="section dashboard-page-card-block">
   
<div class="container content">
	<div class="row1">
	<div class="col-md-12">
		<div class="col-md-9 card card-block" style="height:80px;padding-top:25px;margin-top:10px">
			<div>
				<label class="control-label"> <i class="fa fa-tag green-font-icon"></i> Current Plan :  <span><?php echo $dashboardData['plan_name'];?></label>
				<label class="control-label"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-calendar green-font-icon"></i> Expiry Date :

				<?php 
				if($dashboardData['expiry_date']!='0000-00-00' && $dashboardData['expiry_date']!='') { 
					$date=date('D F,Y',strtotime($dashboardData['expiry_date'])); 
				} else { 
					$date='<span class="sms_chart no_sms_data" style="color: red;font-size:14px;"> - Not Available <span></span></span>';
				}
				echo $date;
				?></label>
			</div>
		</div>
		<br/>
		<div class="col-md-3">
		<label class="control-label"> Choose Number Of Months <span style="color:red;">*</span> </label>
					<select class="form-control plan_pack" id="plan_months">
						<option value="1">1 Month</option>
						<option value="3">3 Months</option>
						<option value="6">6 Months</option>
						<option value="12">12 Months</option>
					</select>
		<br/>
		</div>
	</div>
	<br/>
	
		<!-- Pricing -->
		<?php foreach($plan_package_list  as $key=>$list):
		$active_class='';
		if($list['id']==$dashboardData['plan_id']){
		$active_class='pricing-active';	
		}
		?>
		<div class="col-md-3">
			<div class="pricing hover-effect <?php echo $active_class;?>">	
				<div class="pricing-head">
					<h3><?php
                    $text='';
					$per_month='Per Month';
					if($list['id']==1){
						 $text='<span><b>- (One Time Subscription)</b></span>';
						  $per_month='One Time Subscription';
					}
					echo ucwords($list['name']).$text;
					if($list['id']!=1){?>
					<span><?php echo "Enjoy Best ".$list['name']." Plan !!!";?> </span>
					<?php }?>
					</h3>
					<h4><i>Rs.</i><i class="plan_cost_<?php echo $key;?>" rel="<?php echo $list['price'];?>"><?php echo $list['price'];?></i>
					<span class="per_month_<?php echo $key;?>"><?php echo $per_month; ?> </span>
					</h4>
				</div>
				<ul class="pricing-content list-unstyled" rel="<?php echo $list['sms_counts'];?>">
					<?php echo $list['plan_info'];?>
				</ul>
				<ul class="pricing-content list-unstyled">
					<li>
						<i class="fa fa-comments-o"> </i> Total Sms Credit - <span class="number_of_sms_<?php echo $key;?>" rel="<?php echo $list['sms_counts'];?>"> <?php echo $list['sms_counts'];?> </span>
					</li>			
				</ul>
				<div class="pricing-footer">
					<a href="javascript:;" class="<?php echo $class;?> btn yellow-crusta" <?php if($key==0){ echo "disable=disable"; }?> rel="<?php echo $list['id']?>">
					Buy Now
					</a>
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>
</section>
</article>
<script>
   $(document).ready(function() {
			$('#plan_months').livequery('change',function(){
			var i;
			for(i=1;i<=3;i++){
				var plancost=$('.plan_cost_'+i).attr('rel');	
				$('.plan_cost_'+i).html($(this).val() * plancost);
				if($(this).val()==1){
					$('.per_month_'+i).html('Per Month');
				}
				else{
					$('.per_month_'+i).html('For '+$(this).val() + ' Months');
				}
				$('.number_of_sms_'+i).html($(this).val() * $('.number_of_sms_'+i).attr('rel'));
			}
			return false;
		});
		
		$('.buy_plan').livequery('click',function(){
			
			window.location.href=__cfg('path_absolute')+'customers/buyPlan?plan_id='+$(this).attr('rel')+'&no_of_months='+$('#plan_months').val();	
		});
   });
</script>