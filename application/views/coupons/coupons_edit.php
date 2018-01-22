<article class="content dashboard-page general-campaigns">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title custom-font-size">
                  <i class="fa fa-tag"></i> Edit Coupons
               </h3>
            </div>
         </div>
      </div>
   </div>
   <section class="section">
		<div class="row sameheight-container">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
				<div class="card custom_card_block">
					<div class="form-group col-md-12"> 
						<span class="mand_field_title mand_field_section">  * Fields are mandatory </span>
					</div>
				   <div class="card-block">
				   
			
				   <form id="coupon_form_url" action="<?php echo base_url().'coupons_edit/'.$coupon_data['id'];?>" method="post">
						<div class="form-group col-md-4"> 
							<label class="control-label1" for="title">Title <span style="color:red;">*</span> <i data-placement="right" data-toggle="tooltip" title="Enter Your Coupon Title" class="fa fa-question-circle cursor" style="font-size:12px;"></i> </label>
							<input type="text" name="name" class="form-control" id="name" value="<?php echo $coupon_data['name'];?>">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label" for="total_coupon">Total Coupons  <span style="color:red;">*</span></label>
							<input type="number" min='1' name="total_coupon" class="form-control" id="total_coupon" value="<?php echo $coupon_data['total_count'];?>">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label" for="expiry_date">Expiry Date  <span style="color:red;">*</span></label>
							<input type="text" name="expiry_date" class="form-control" id="expiry_date" value="<?php echo date('Y-m-d',strtotime($coupon_data['exipry_date']));?>">
						</div>
						<div class="form-group col-md-12">
							<label class="control-label" for="description">Description  <span style="color:red;">*</span></label>
							<br/>
							<?php
								$txtattribute = array('name'=>'description','class'=>'form-control','rows'=>'5','id'=>'description','value'=>set_value('description',$coupon_data['description']));
								echo form_textarea($txtattribute); 
							?>
						</div>
						<div class="form-group col-md-12">
							<label class="control-label" for="tokenize">Keywords <span style="color:red;">* <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter keywords</span> </i> </span></label>
								<select class="tokenize-sample" multiple="multiple" name='keywords[]' id="tokenize">
						<?php echo $keywords_data;?>
							</select>	
							<span style="font-size: 12px;color: #85CE36;;">Note : Use Enter button to add multiple keywords.</span>
							<br/>
							<span style="position: absolute;font-size: 12px;color: red;" class="cutom-error keyword-error"></span>							
						</div>
							<div class="controls">
							<div class="form-group col-md-12 filter_types">
								<label for="offer_type_1" class="cursor"><input <?php if($coupon_data['offer_type']==1){ echo 'checked="checked"';}?>  type="radio" value="1"  name="offer_type" rel="0" id="offer_type_1" class="radio clearfix cursor offer_type"> <span>&nbsp;Offer Based on Price&nbsp;&nbsp;</span></label>
								<label for="offer_type_2" class="cursor"><input <?php if($coupon_data['offer_type']==2){ echo 'checked="checked"';}?> type="radio" name="offer_type" value="2" rel="1" id="offer_type_2" class="radio clearfix cursor offer_type"> <span>&nbsp;Offer Based on Percentage&nbsp;&nbsp;</span></label>
							</div>
						</div>
				
						
							<div class="form-group col-md-4 price_type_section" style="display:none;">
							<label class="control-label" for="original_price">Original Price <span style="color:red;">*</span></label>
							<input type="number" name="original_price" id="original_price" value="<?php echo ( $coupon_data['original_price'] > 0 ) ? $coupon_data['original_price'] : ''; ?>" placeholder="Price " class="form-control"/>
						</div>
						<div class="form-group col-md-4 price_type_section" style="display:none;">
							<label class="control-label" for="offer_price">Offer Price <span style="color:red;">*</span></label>
							<input type="number" name="offer_price" id="offer_price" value="<?php echo ( $coupon_data['offer_price'] > 0 ) ? $coupon_data['offer_price'] : ''; ?>" placeholder="Offer Price" class="form-control"/>
						</div>
						
						<div id="range_section">
							<div class="form-group col-md-12 range-section" style="display:none;" id="">		
                                <?php 
								$data=array('from_price'=>'','to_price'=>'','percentage'=>'');
								$price_dataone=(isset($price_data[0])) ? $price_data[0] : $data;?>							
								<div class="form-group col-md-3">
									<label class="control-label" for="email">From Price  <span style="color:red;">*</span></label>
									<input type="text" placeholder="From Price" class="form-control" name="from_price[]" value="<?php echo $price_dataone['from_price'];?>"/>
								</div>
								<div class="form-group col-md-2">
									<label class="control-label" for="email">To Price  <span style="color:red;">*</span></label>
									<input type="text" placeholder="To Price" class="form-control" name="to_price[]" value="<?php echo $price_dataone['to_price'];?>"/>
								</div>
								<div class="form-group col-md-3">
									<label class="control-label" for="email">Percentage  <span style="color:red;">*</span></label>
									<input type="number" max="100" placeholder="How many % ?"  name="range_per[]" class="form-control" value="<?php echo $price_dataone['percentage'];?>"/>
								</div>
								<div class="form-group col-md-1">
										<label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle clone-data cursor"></i></label>
										&nbsp;<label class="control-label" for="email" style="margin-top:34px;color:red;">	
										<i style="color:red;display:none;" class="fa fa-close clone-remove-data cursor"></i></label>
								</div>
							</div>
						</div>
					
						<div class="range-section-clone">
						<?php foreach($price_data as $key=>$data): if($key==0){ continue;}?>
						<div class="form-group col-md-3 dummy-div"><label class="control-label" for="email"></label></div>
						<div class="form-group col-md-12 range-section" style="display:none;" id="">	
								<div class="form-group col-md-3">
									<label class="control-label" for="email">From Price  <span style="color:red;">*</span></label>
									<input type="text" placeholder="From Price" class="form-control" name="from_price[]" value="<?php echo $data['from_price'];?>"/>
								</div>
								<div class="form-group col-md-2">
									<label class="control-label" for="email">To Price  <span style="color:red;">*</span></label>
									<input type="text" placeholder="To Price" class="form-control" name="to_price[]" value="<?php echo $data['to_price'];?>"/>
								</div>
								<div class="form-group col-md-3">
									<label class="control-label" for="email">Percentage  <span style="color:red;">*</span></label>
									<input type="number" max="100" placeholder="How many % ?"  name="range_per[]" class="form-control" value="<?php echo $data['percentage'];?>"/>
								</div>
								<div class="form-group col-md-1">
										<label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle clone-data cursor"></i></label>
										&nbsp;<label class="control-label" for="email" style="margin-top:34px;color:red;">	
										<i style="color:red;" class="fa fa-close clone-remove-data cursor"></i></label>
								</div>
						</div>
						<?php endforeach;?>
						</div>
						<div class="control-group">
						 <div class="controls">
		

							<div class="form-group col-md-3">
						  <label class="control-label" for="profile_image">Profile Image <span style="color:red;">*</span></label>
						  <input type="file" class="form-control"  name="profile_image">
						</div>
					
						<div class="form-group col-md-4">
						<br/>
							<label class="checkbox-inline">
								<input type="checkbox" class="checkbox" name="is_active" id="is_active" checked="checked"> <span>Make As Active</span>
							</label>
						</div>
						
						<div class="form-group col-md-12">
							<button class="btn btn-primary btn-md pull-right">Submit</button> &nbsp;
						
							<a class="btn btn-primary btn-md pull-right" style="margin-right:10px;">Cancel</a>
						</div>
				   </form>
				   </div>
				</div>
			</div>
		</div>
	</section>
</div>
</article>
<script src="<?php echo base_url();?>assets/customer/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/customer/js/jquery.tokenize.js"></script>
<script>
$(document).ready(function(){

	$('#expiry_date').livequery('focus',function() {
			$('#expiry_date').datepicker({
				format: "yyyy-mm-dd",
				startDate: new Date()
			});  
	});
	
	$('#expiry_date').livequery('click',function(){
		$(this).trigger('focus');
	});
	
	
	$('.clone-data').livequery('click',function(){
		$("div.range-section-clone").append('<div class="form-group col-md-3 dummy-div"><label class="control-label" for="email"></label></div>');
		$("#range_section div.range-section").clone().appendTo("div.range-section-clone");	
		$('div.range-section-clone').find('.clone-remove-data').show();
	});

	$('.clone-remove-data').livequery('click',function(){
		$(this).parents('div.range-section').remove();
		$(this).parents('div.range-section').parents('div.range-section-clone').find('div.dummy-div').remove();
	});

	$('.offer_type').change(function(){
			if($(this).attr('rel')==0){
					$('.price_type_section').show();
					$('.range-section').hide();
			}
			else{
				$('.price_type_section').hide();
				$('.range-section').show();
			}
	});	
	
	$('#offer_type_1').livequery('change',function(){
			if($(this).is(':checked')==true){
					$('.price_type_section').show();
					$('.range-section').hide();
			}
			else{
				$('.price_type_section').hide();
				$('.range-section').show();
			}
	});	
		
		$('#offer_type_1').trigger('change');	
	});

	$('#tokenize').tokenize({ datas: "<?php echo base_url();?>coupons/search_category"});	
</script>