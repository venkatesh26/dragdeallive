<article class="content dashboard-page general-campaigns">
   <div class="bread-crumb-data">
      <?php echo $this->load->view('elements/breadcrumb',array(),true);?>
   </div>
      <?php echo $this->load->view('elements/plan_upgrade_alert',array(),true);?>
   <div class="white-bg">
      <div class="title-search-block">
         <div class="title-block1">
            <div class="row">
               <div class="col-md-6">
                  <h3 class="title">
                     <i class="fa fa-tag"></i> Offer Campaign
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
                     <?php if($total_sms <= 0){?>
                     <label><i class="fa fa-info-circle" style="font-size:18px;color:red;"></i> Currently No Sms Available. Please <a href="<?php echo base_url()."sms_package_list";?>">click here</a> to choose your plan.</label>
                     <?php }?>
                     <form id="offer_campaings_form_url" action="<?php echo base_url().'campaigns/offer_campaigns';?>" method="post">
                        <div class="form-group col-md-3"> 
                           <label class="control-label1" for="title">Campaign Title <span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter Campaign Title</span> </i></label>
                           <input type="text" name="title" class="form-control" id="title" autocomplete="off">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label1" for="title">Sender ID<span style="color:red;"> *</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Select Your Sender ID</span> </i> </label>
                           <select id="sender_id" name="sender_id" class="form-control common-select-box">
                              <option value="">Select SenderID</option>
                              <?php 
                                 if(!empty($my_sendeids)):
                                 	foreach($my_sendeids as $groups):?>
                              <option value="<?php echo ucfirst($groups['id']);?>"><?php echo ucfirst($groups['sender_id']);?></option>
                              <?php 
                                 endforeach;
                                 else :
                                 ?>
                              <option value="0">Default</option>
                              <?php endif;?>
                           </select>
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="campaign_start_date">Campaign Start Date <span style="color:red;">*</span></label>
                           <input type="text" name="campaign_start_date" class="form-control" id="campaign_start_date">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="campaign_end_date">Campaign End Date <span style="color:red;">*</span></label>
                           <input type="text" name="campaign_end_date" class="form-control" id="campaign_end_date">
                        </div>
                        <div class="form-group col-md-12">
                           <label class="control-label1" for="message">Message <span style="color:red;">*</span>
                           <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext">Enter Campaign Message</span> </i>  </label>
                           <label class="pull-right" style=""> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-custom-width">Sms Count will be varied based on filtred customers and sms character</span> </i> 
                           <b>Number of sms will be Debit : <span id="number_of_sms" class="square-box"><?php echo $filter_count;?></span></b></label>
                           <textarea name="message" cols="10" rows="5"  id="message" class="form-control"></textarea>
                           <div class="icon-section pull-right" style="margin-top:5px">
                              <a class="show-preview"  href="javascript:void(0)" data-toggle="modal" data-target="#confirm-modal"> <i class="fa fa-eye"></i> <b>Preview</b> </a>&nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0);" class="hastags cursor" rel="##URL##"><i class="fa fa-globe"></i>&nbsp;<b>##URL##</b></a>&nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0);"  class="hastags cursor" rel="##USERNAME##"><i class="fa fa-user-md"></i>&nbsp;<b>##USERNAME##</b></a> &nbsp;&nbsp;&nbsp;
                              <a href="javascript:void(0);"  class="hastags cursor" rel="##CODE##"><i class="fa fa-tag"></i>&nbsp;<b>##CODE##</b></a> &nbsp;&nbsp;&nbsp;
                              <label class="pull-right clearfix square-box-label" style="text-decoration:none;" href="javascript:void(0);"><b>Number Of Characters</b> : <b><span id="sms_character_count" class="square-box"> 0 </span></b></label>
                           </div>
                        </div>
                        <div class="form-group col-md-6"> 
                           <label class="control-label1" for="url">Campaign Url <span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter Campaign Url</span> </i></label>
                           <input type="text" name="url" class="form-control" id="url">
                        </div>
                        <div class="form-group col-md-3">
                           <label class="control-label" for="profile_image">Campaign Image <span style="color:red;">*</span></label>
                           <input type="file" class="form-control"  name="profile_image" accept="image/*">
                        </div>
                     
                        <div class="filter_type_code">
                              <div class="form-group col-md-12"> 
                                 <label class="control-label" style="margin-tOP: 4px;font-size: 15px;"><i class="fa fa-tag"></i> Select Option&nbsp;&nbsp;</label>
                                 <label class="cursor"><input type="radio" name="coupon_type" rel="1" id="filter_type_code1" class="radio clearfix cursor" checked="checked" value="1"><span>Autogenerated Code  &nbsp;&nbsp;&nbsp;&nbsp;</span></label>
                                 <label class="cursor"><input type="radio" name="coupon_type" rel="2" id="filter_type_code2" class="radio clearfix cursor" value="2">  <span>Custom Code &nbsp;&nbsp;&nbsp;&nbsp;</span></label>
								 <input type="text" maxlength="6" name="coupon_code" id="coupon_code" class="form-control" placeholder="Enter Coupon Code" style="display:none;width:170px;">
                              </div>
                           </div>
						   
						   
						<?php echo $this->load->view('elements/campaign_filter',array('type'=>'offer_campaings_form_url'),true);?>
						<div class="form-group col-md-12">
				          <div class="col-md-12 control-group">
						    <label for="display_as_offer" class="cursor control-label"><input type="checkbox" name="display_as_offer" rel="0" id="display_as_offer" class="clearfix checkbox cursor"><span>&nbsp;Yes ! I Want to display as offer &nbsp;&nbsp;</span></label>
						  </div>
						  <br/>
						  <div id="offer_section" style="display:none;">
						    <div class="col-md-12 control-group">
								  <label class="control-label" for="description">Description <span style="color:red;">*</span></label>
							   <textarea name="description" cols="10" rows="5"  id="description" class="form-control"></textarea>
							   <span class="login-error description_error"></span>							   
						   </div>
						
						    <div class="control-group col-md-12" style="margin-top:20px"> 
								<div class="filter_offer_type_code">
									 <label class="control-label" style="margin-tOP: 4px;font-size: 15px;"><i class="fa fa-tag"></i> Select Option&nbsp;&nbsp;</label>
									 <label class="cursor"><input type="radio" name="offer_type" rel="1" id="offer_type_code1" class="radio clearfix cursor" checked="checked" value="1"><span>Offer Based On Price</span></label>
									 <label class="cursor"><input type="radio" name="offer_type" rel="2" id="offer_type_code2" class="radio clearfix cursor" value="2">  <span>Offer Based On Percentage</span></label>
								</div>
							</div>
							<br/>
							<div class="offer_type_code1">
								<div class="form-group col-md-4"> 
								   <label class="control-label1" for="mrp_price"> MRP Price <span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter MRP Orice</span> </i></label>
								   <input type="number" name="mrp_price" class="form-control" id="mrp_price">
								     <span class="login-error"></span>	
								</div>
								<div class="form-group col-md-4"> 
								   <label class="control-label1" for="offer_price"> Offer Price <span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter Offer Orice</span> </i></label>
								   <input type="number" name="offer_price" class="form-control" id="offer_price">
								     <span class="login-error"></span>	
								</div>
							</div>
							<div class="offer_type_code2" style="display:none;">
								<div class="form-group col-md-6"> 
								   <label class="control-label1" for="percentage"> Percentage<span style="color:red;">*</span> <i class="fa fa-question-circle tooltipdiv cursor" style="font-size:12px;">   <span class="tooltiptext tooltip-right">Enter Offer Percentage</span> </i></label>
								   <input type="number" max="100" min="0.1" step="any" name="percentage" class="form-control" id="percentage">
								   <span class="login-error"></span>	
								</div>
							</div>
						</div>
						</div>
				 
						<div class="box-content clearfix">
							<button class="btn btn-primary btn-md pull-right">Send</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a class="btn btn-primary btn-md pull-right" href="" style="margin-right:10px;"> Cancel</a>
						</div>
					    <div class="box-content clearfix">
						  <p class="pull-right"><i class="fa fa-info-circle"></i> Don't close the browser or refresh the page after send button clicked.</p>
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
<script>   
   $(document).ready(function(){	
		$('#campaign_start_date').livequery('focus',function(){
			   $('#campaign_start_date').datepicker({
				   format: "yyyy-mm-dd", 	
				   changeMonth: true,
				   changeYear: true
				}); 
		});
		$('#campaign_start_date').livequery('click',function(){
            $(this).trigger('focus');
		});
		
		$('#campaign_end_date').livequery('focus',function(){
			   $('#campaign_end_date').datepicker({
				format: "yyyy-mm-dd", 	
				changeMonth: true,
				changeYear: true
			}); 
		});
		$('#campaign_end_date').livequery('click',function(){
            $(this).trigger('focus');
		});
		
		$('#from_date').livequery('focus',function(){
			   $('#from_date').datepicker({format: "yyyy-mm-dd"}); 
		});
		$('#from_date').livequery('click',function(){
            $(this).trigger('focus');
		});
		
		$('#to_date').livequery('focus',function(){
			   $('#to_date').datepicker({format: "yyyy-mm-dd"}); 
		});
		$('#to_date').livequery('click',function(){
            $(this).trigger('focus');
		});
	
	$('.show-preview').hide();
	$('#senderid').livequery('change',function(){
		if($('#title').val()!='' && $('#senderid').val()!='' && $('#message').val()!=''){
			$('.show-preview').show();
		}
		else{
			$('.show-preview').hide();
		}
	});
	
	$('.show-preview,#title,#senderid,#message').livequery('keyup',function(){
		if($('#title').val()!='' && $('#senderid').val()!='' && $('#message').val()!=''){
			$('.show-preview').show();
		}
		else{
			$('.show-preview').hide();
		}
	});
	
	$('#title').keyup(function (){
		$('.preview-title').html('');
		$('.preview-title').html($('#title').val());
	});
	$('#senderid').change(function (){
		$('.preview-sender').html('');
		$('.preview-sender').html($('#senderid option:selected').text());
	});
	
	$('#display_as_offer').change(function (){
		if($(this).prop('checked')){
		$('#offer_section').show();
		}
		else{
			$('#offer_section').hide();
		}
	});
	
	$('.filter_offer_type_code').change(function (){
		 if($('#offer_type_code1').prop('checked')==true){
		 $('.offer_type_code1').show();
			 $('.offer_type_code2').hide();
		 }
		 else {
			$('.offer_type_code1').hide();
			$('.offer_type_code2').show();
		 }
	});
	
	$('.preview-sms').change(function (){
	   	$('.preview-sms').html('');		
		$('.preview-sms').html($("#message").val());
	});

   	
   	$('#offer_campaings_form_url').livequery('submit',function(){
   		var url=$("#offer_campaings_form_url").attr('action');
   		var $this=$(this);
		var form = $('#offer_campaings_form_url')[0]; 
        var formData = new FormData(form);
		formData.append('image', $('input[type=file]')[0].files[0]); 
   		$.LoadingOverlay("show");
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
   					$("#offer_campaings_form_url input").each(function() {
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
   				
   						$("#offer_campaings_form_url input").each(function() {
   							$(this).next('span.login-error').remove();
   					    });
						$('.description_error').html('');
   						if(typeof data.errorfields!='undefined' && data.errorfields.length > 0)
   						$.each(data.errorfields,function(key, value){
   							var error="<span class='login-error'>"+value.error+"</span>";
   							if(value.field=='description'){
   									$('.description_error').html(value.error);
   							} else {
								console.log(value.field);
   									$this.find("[name="+value.field+"]").after(error);
   							}
   						});
   						
   						alert_notification('error','Please complete the required fields.');
   					}
   					
   				}
   				else
   				{
   					$("#offer_campaings_form_url textarea").each(function() {
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
<div class="modal fade" id="confirm-modal">
    <div class="modal-dialog" role="document" style="width: 350px;">
		<div class="modal-content">
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title"><i class="fa fa-comments-o"></i> Preview Sms</h4> 
			</div>
			<form id="group_form_url" class="js-group-edit" action="">
				<div class="modal-body" style="height:auto;"> 
				<h5 style="font-size:16px;"><i class="fa fa-list-alt"></i> <b class="preview-title"> </b></h5>
				<h5 style="font-size:16px;"><i class="fa fa-history"></i> From : <b class="preview-sender"> </b></h5>
					<div class="control-group"> 
						<div class="form-group col-md-12">
							<div class="preview-sms" style="height:130px;overflow:scroll;">
							</div>
						</div>
					</div>					
				</div>
				<div class="modal-footer" style="clear:both;"> 
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
				</div>
			</form>
		</div>
    </div>
</div>