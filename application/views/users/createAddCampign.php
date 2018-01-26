<script src="<?php echo base_url().'assets/themes/js/jquery-1.11.0.min.js';?>"></script>
<script src="<?php echo base_url().'assets/themes/js/bootstrap.min.js';?>"></script>
<link rel="stylesheet" href="<?php echo base_url().'assets/themes/js/bootstrap.min.css';?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/themes/css/font-awesome.min.css';?>">
<style>
   .clearfix{clear:both;}
   .js-plan-3-feature{width:175px;}
   .pull-right{margin-right: 10px;
   margin-bottom: 15px;}
   .plan-feature-list li{list-style:none;}
   .checkout-wrapper{padding-top: 40px; padding-bottom:40px; background-color: #fafbfa;}
   .checkout{    background-color: #fff;
   border:1px solid #eaefe9;
   font-size: 14px;}
   .plan-header .col-md-4{background-color:#eee !important;}
   .checkout-step {
   font-size: 14px;
   padding: 23px 17px 20px 50px;
   position: relative;
   border-radius: 4px;
   margin-bottom: 0px;
   }
   .checkout-step-number {
   border-radius: 50%;
   border: 1px solid #000;
   display: inline-block;
   font-size: 12px;
   height: 44px;
   margin-right: 26px;
   padding: 6px;
   text-align: center;
   width: 45px;
   }
   .checkout-step-title{ font-size: 18px;
   font-weight: 500;
   vertical-align: middle;display: inline-block; margin: 0px;
   margin-top:-26px;
   }
   .checout-address-step{}
   .checout-address-step .form-group{margin-bottom: 18px;display: inline-block;
   width: 100%;}
   .checkout-step-body{padding-left: 10px; padding-top: 30px;}
   .checkout-step-active{display: block;}
   .checkout-step-disabled{display: none;}
   .checkout-login{}
   .login-phone{display: inline-block;}
   .login-phone:after {
   content: '+91 - ';
   font-size: 14px;
   left: 36px;
   }
   .login-phone:before {
   content: "";
   font-style: normal;
   color: #333;
   font-size: 18px;
   left: 12px;
   display: inline-block;
   font: normal normal normal 14px/1 FontAwesome;
   font-size: inherit;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   -moz-osx-font-smoothing: grayscale;
   }
   .login-phone:after, .login-phone:before {
   position: absolute;
   top: 50%;
   -webkit-transform: translateY(-50%);
   transform: translateY(-50%);
   }
   .login-phone .form-control {
   padding-left: 68px;
   font-size: 14px;
   }
   .checkout-login .btn{height: 42px;     line-height: 1.8;}
   .otp-verifaction{margin-top: 30px;}
   .checkout-sidebar{background-color: #fff;
   border:1px solid #eaefe9; padding: 30px; margin-bottom: 30px;}
   .checkout-sidebar-merchant-box{background-color: #fff;
   border:1px solid #eaefe9; margin-bottom: 30px;}
   .checkout-total{border-bottom: 1px solid #eaefe9; padding-bottom: 10px;margin-bottom: 10px; }
   .checkout-invoice{display: inline-block;
   width: 100%;}
   .checout-invoice-title{    float: left; color: #30322f;}
   .checout-invoice-price{    float: right; color: #30322f;}
   .checkout-charges{display: inline-block;
   width: 100%;}
   .checout-charges-title{float: left; }
   .checout-charges-price{float: right;}
   .charges-free{color: #43b02a; font-weight: 600;}
   .checkout-payable{display: inline-block;
   width: 100%; color: #333;}
   .checkout-payable-title{float: left; }
   .checkout-payable-price{float: right;}
   .checkout-cart-merchant-box{ padding: 20px;display: inline-block;width: 100%; border-bottom: 1px solid #eaefe9;
   padding-bottom: 20px; }
   .checkout-cart-merchant-name{color: #30322f; float: left;}
   .checkout-cart-merchant-item{ float: right; color: #30322f; }
   .checkout-cart-products{}
   .checkout-cart-products .checkout-charges{ padding: 10px 20px;
   color: #333;}
   .checkout-cart-item{ border-bottom: 1px solid #eaefe9;
   box-sizing: border-box;
   display: table;
   font-size: 12px;
   padding: 22px 20px;
   width: 100%;}
   .checkout-item-list{}
   .checkout-item-count{ float: left; }
   .checkout-item-img{width: 60px; float: left;}
   .checkout-item-name-box{ float: left; }
   .checkout-item-title{ color: #30322f; font-size: 14px;  }
   .checkout-item-unit{  }
   .checkout-item-price{float: right;color: #30322f; font-size: 14px; font-weight: 600;}
   .checkout-viewmore-btn{padding: 10px; text-align: center;}
   .header-checkout-item{text-align: right; padding-top: 20px;}
   .checkout-promise-item {
   background-repeat: no-repeat;
   background-size: 14px;
   display: inline-block;
   margin-left: 20px;
   padding-left: 24px;
   color: #30322f;
   }
   .checkout-promise-item i{padding-right: 10px;color: #43b02a;}
   .bootstrap-tagsinput {
   width: 100%;
   }
   .notes{
   font-size:14px;
   color:#29c065;
   }
   .bootstrap-tagsinput {
   background-color: #fff;
   border: 1px solid #ccc;
   box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
   display: inline-block;
   padding: 4px 6px;
   color: #555;
   vertical-align: middle;
   border-radius: 4px;
   max-width: 100%;
   line-height: 22px;
   cursor: text;
   }
   .label-info {
   background-color: #5bc0de;
   }
   div.tag.label{
   display: inline;
   padding: .2em .6em .3em;
   font-size: 75%;
   font-weight: 700;
   line-height: 1;
   color: #fff;
   text-align: center;
   white-space: nowrap;
   vertical-align: baseline;
   border-radius: .25em;
   }
   .campaign-label{
   font-size:14px;
   }
   .campaign-label .required {
   color:red;
   font-size:10px;
   }
   .form-control-select{
   display: block;
   width: 100%;
   padding: .375rem .75rem;
   font-size: 1rem;
   line-height: 1.5;
   color: #55595c;
   background-color: #fff;
   background-image: none;
   border: 1px solid #ccc;
   border-radius: .25rem;
   }
   .login-error{
   color: red !important;
   font-size: 12px;
   position: absolute;
   width: 100%;
   clear: both;
   /* width: 148px; */
   /* margin-right: -77px; */
   margin-top: 30px;
   margin-left: -326px;
   padding-top: 8px;
   padding-bottom: 10px;
   }
   .plan_description{
   color: #29c065;
   font-weight:bold;
   }
   .btn.btn-default{
   margin-top: 25px;
   line-height: 18px;
   }
   .form-group{
   line-height: 32px;   
   }
   .color-red-icon{
   color:red;
   }
   .color-green-icon{
   color:#85CE36;
   }
   .plan-header .col-md-4.active{
   background-color: #85CE36 !important;
   padding:0px !important;
   margin-right:0px !important;
   }
   .checkout-step-number{
   background-color: grey;
   color: #fff;
   }
   .checkout-step-number.success{
   background-color: #85CE36;
   color: #fff;
   border: 1px solid #fff;
   }
   .col-md-4.active{
   background-color:#85CE36;
   color:#fff;
   }
   .col-md-4.active a{
   color:#fff;
   }
   a.js-plan{
   text-decoration: none;
   }
   .plan-header .checkout-step-number{
   background-color:#ff7500 !important;
   font-size:12px;
   font-weight:bold;
   border:1px;
   }
   .plan-feature{
   font-size:14px;
   font-style:italic;
   }
   .feature-add-list{
   margin-top:40px;
   }
   .js-campaign-submit{
   margin-right: 10px;
   margin-bottom: 31px;
   }
   .collapse-body{
   background-color: #eee;
   margin-right: 1px;
   margin-left: 0px;
   border: 2px solid #85CE36;
   }
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/bootstrap-tagsinput.css">
<div class="td-main-content-wrap td-main-page-wrap">
   <div class="td-container">
      <?php 
         /************ Bread Crumb *****************/ 
         echo $this->load->view('bread_crumb',array(),true); 
         ?>
      <div class="td-page-header">
         <h1 class="entry-title td-page-title"><span>List your business with India's leading local search engine</span></h1>
         <h1 class="entry-title td-page-title plan_description">Register Your business as premium listing for Life Time.<span> (Note : This offer is available for limited users only).</span></h1>
      </div>
      <div class="td-pb-row">
         <form action="<?php echo base_url().'home/createAddCampaign';?>" method="post" id="add_campign_form_url">
            <div id="accordion" class="checkout">
               <div class="row">
                  <div class="col-md-12 plan-header">
                     <div class="col-md-4 active">
                        <a role="button" class="js-plan js-plan-1" href="javascript:void(0);" rel="6">
                           <div class="checkout-step plan-1 active">
                              <div>
                                 <span class="checkout-step-number">Plan A</span>
                                 <h4 class="checkout-step-title"> Pro Lite Plan <i class="fa fa-chevron-down"></i> <br/> <span><b>Rs.499</b></span></h4>
                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="plan-1-form">
                     </div>
                     <div class="col-md-4">
                        <a role="button" class="js-plan js-plan-2" href="javascript:void(0);" rel="7">
                           <div class="checkout-step plan-1">
                              <div>
                                 <span class="checkout-step-number">Plan B</span>
                                 <h4 class="checkout-step-title"> Pro Plan <i class="fa fa-chevron-down"></i>
                                    <br/> <span><b>Rs.999</b></span>
                                 </h4>
                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="plan-2-form"></div>
                     <div class="col-md-4">
                        <a role="button" class="js-plan js-plan-3" href="javascript:void(0)" rel="8">
                           <div class="checkout-step plan-1">
                              <div>
                                 <span class="checkout-step-number">Plan C </span>
                                 <h4 class="checkout-step-title"> Advance Plan <i class="fa fa-chevron-down"></i>
                                    <br/> <span><b>Rs.1999</b></span>
                                 </h4>
                              </div>
                           </div>
                        </a>
                     </div>
                     <div class="plan-3-form"></div>
                  </div>
               </div>
               <div class="js-plan-response">
                  <div class="row collapse-body">
                     <div class="accordion-group">
                        <div id="plan-1" class="collapse in">
                           <h5 style="font-size:12px;" class="pull-right clearfix"><span style=""><span style="color:red">*</span> denotes mandatory fields</span></h5>
                           <div class="checkout-step-body">
                              <div class="col-lg-4 js-plan-1-feature plan-feature" style="min-height:180px !important;">
                                 <h4><i class="fa fa-gift color-green-icon"></i> Plan Features </h4>
                                 <ul class="plan-feature-list">
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Premium Listing</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Email Leads</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> One Time Actiation</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Multiple Keywords</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Free SEO</li>
                                 </ul>
                              </div>
                              <div class="col-lg-2 js-plan-2-feature plan-feature" style="display:none;min-height:180px !important;">
                                 <h4><i class="fa fa-gift color-green-icon"></i> Plan Features </h4>
                                 <ul class="plan-feature-list js-plan-2-feature">
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Premium Listing</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Email Leads</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> One Time Actiation</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Multiple Keywords</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Manage Customer</li>
                                 </ul>
                              </div>
                              <div class="col-lg-2 js-plan-2-feature plan-feature" style="display:none;min-height:180px !important;">
                                 <ul class="plan-feature-list js-plan-2-feature feature-add-list" style="display:none;">
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> 200 Sms</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Limited Coupons</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Free SEO</li>
                                 </ul>
                              </div>
                              <div class="col-lg-2 js-plan-3-feature plan-feature" style="display:none;min-height:180px !important;">
                                 <h4><i class="fa fa-gift color-green-icon"></i> Plan Features </h4>
                                 <ul class="plan-feature-list js-plan-3-feature">
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Premium Listing</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Email Leads</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> One Time Actiation</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Multiple Keywords</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Manage Customer</li>
                                 </ul>
                              </div>
                              <div class="col-lg-2 js-plan-3-feature plan-feature" style="display:none;min-height:180px !important;">
                                 <ul class="plan-feature-list js-plan-3-feature feature-add-list" style="marign-top:40px;">
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> 400 Sms</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> UnLimited Coupons</li>
                                    <li> <i class="fa fa-check-circle-o color-green-icon"></i> Free SEO</li>
                                 </ul>
                              </div>
                              <div class="col-lg-8">
                                 <div class="col-md-12">
                                    <span class="checkout-step-number js-step-1-circle">Step 1</span>
                                    <h4 class="checkout-step-title"> Email Verification <i class="email-verfiy-title fa fa-check-circle-o color-red-icon"></i></h4>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                       <div class="col-md-5">
                                          <label class="control-label campaign-label" for="email">Email <span class="required"> *</span></label>
                                          <input id="email" name="email" type="email" placeholder="Enter Your Email" class="form-control input-md" required="" autocomplete="off">
                                       </div>
                                       <div class="col-md-5">
                                          <label class="control-label  campaign-label" for="contact_number">Mobile Number <span class="required"> *</span></label>
                                          <input id="contact_number" name="contact_number" type="text" placeholder="Enter Your Mobile Number" class="form-control input-md" required="" autocomplete="off">
                                       </div>
                                    </div>
                                    <a class="btn btn-default js-step1-next-button pull-right" disabled="disabled" role="button" data-toggle="collapse" href="#plan1-step2" >Next</a>
                                 </div>
                              </div>
                              <div id="plan1-step2" class="collapse clearfix">
                                 <div class="col-md-12">
                                    <span class="checkout-step-number js-step-2-circle">Step 2</span>
                                    <h4 class="checkout-step-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#plan1-step2" > Business Details <i class="business-verfiy-title fa fa-check-circle-o color-red-icon"></i></a></h4>
                                    <div class="form-group">
                                       <div class="col-md-4">
                                          <label class="control-label campaign-label" for="name">Company Name <span class="required"> *</span></label>
                                          <input type="text" name="name" placeholder="Ener Your Company Name" id="company_name" value="" size="40">
                                       </div>
                                       <div class="col-md-4">
                                          <label class="control-label campaign-label" for="owner">Owner <span class="required"> *</span></label>
                                          <input id="owner" name="owner" type="text" placeholder="Enter Owner Name" class="form-control input-md" required="">
                                       </div>
                                       <div class="col-md-4">
                                          <label class="campaign-label" for="address_line"> Adress Line <span class="required">*</span></label>
                                          <input type="text" name="address_line" placeholder="Enter Your Address Line" id="address_line" value="" size="40">
                                       </div>
                                       <div class="col-md-4">
                                          <label class="campaign-label" for="campaign_city"> City <span class="required">*</span></label><span class="wpcf7-form-control-wrap your-email">
                                          <input type="text" name="city" placeholder="Enter City Name" value="" id="campaign_city" size="40"></span>
                                          <input type="hidden" name="city_id" id="campaign_city_id">
                                       </div>
                                       <div class="col-md-4">
                                          <label class="campaign-label" for="campign_area"> Area <span class="required">*</span></label>
                                          <input type="text" name="area" id="campign_area" placeholder="Enter Area Name" value="" size="40">
                                          <input type="hidden" name="area_id" id="campaign_area_id">
                                       </div>
                                       <div class="col-md-4">
                                          <label class="campaign-label" for="zip"> Zip Code<span class="required"> *</span></label>
                                          <input type="text" name="zip" placeholder="Enter Your zip Code" id="zip" value="" size="40">
                                       </div>
                                    </div>
                                    <a disabled="disabled" class="btn btn-default pull-right js-plan2-next" role="button" data-toggle="collapse" href="#plan1-step3" >Next</a>
                                 </div>
                              </div>
                              <div id="plan1-step3" class="collapse clearfix">
                                 <div class="col-md-12">
                                    <span class="checkout-step-number js-step-3-circle success">Step 3</span>
                                    <h4 class="checkout-step-title"> <a role="button" href="#plan1-step2" > Keywords / Description</a></h4>
                                    <div class="wpb_column vc_column_container td-pb-span12">
                                       <p><label class="campaign-label" for="keywords"> Keywords <span class="notes">(Note:use enter key to add multiple keywords)</span><span class="required"></span></label>
                                          <input type="text" name="keywords" class="keywords" id="keywords" value="" size="40">
                                       </p>
                                    </div>
                                    <div class="wpb_column vc_column_container td-pb-span12">
                                       <p><label class="campaign-label" for="description"> Description <span class="required"></span></label>
                                          <textarea type="text" name="description" placeholder="Enter Your Company Description" id="description" value="" size="40"></textarea>
                                       </p>
                                       <input id="plan_id" name="plan_id" type="hidden" value="6">
                                       <input id="user_id" name="user_id" type="hidden">
                                    </div>
                                    <p>
                                       <input type="submit" value="Sumbit" class="wpcf7-form-control wpcf7-submit register-submit-button js-campaign-submit" style="float:right;">
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script src="<?php echo base_url()?>assets/themes/js/bootstrap-tagsinput.min.js"></script>
<script>
   var is_mobile='<?php echo $this->detect->isMobile();?>';
       function saveCampignLeads(){
   		jQuery.ajax({
   		type: "POST",
   		url: '<?php echo base_url().'home/createUserCampaign';?>',
   		data:jQuery("#add_campign_form_url").serialize(),
   		datatype:"json",
   		success: function(data){
   			var data=jQuery.parseJSON(data);
   			$('#user_id').val(data.user_id);
   		}
   		});			
   	}
        
       jQuery(document).ready(function($){	
   	
   	    if(is_mobile==1){
   			$('.plan-1-form').html('');
   			$('.plan-2-form').html('');
   			$('.plan-3-form').html('');
   			$('.plan-1-form').html($('.js-plan-response').html());
   			$('.js-plan-response').html('');
   		}
   
           /*************** Step one Next Button *****/
           $('.js-plan').livequery('click',function(){
   		  $('.plan-header .col-md-4').removeClass('active');
   		  $('#plan_id').val($(this).attr('rel'));
        
       $.LoadingOverlay("show");
       $('.loadingoverlay').css('z-index',999999);
       if($(this).hasClass('js-plan-1')){
   		$('.js-plan-2-feature').hide();
   		$('.js-plan-3-feature').hide();
   		$('.js-plan-1-feature').show();
   		$(this).parent('div').addClass('active');
   		
   		if(is_mobile==1){
   			$('.plan-1-form').html('');
   			if($('.plan-2-form').html()!=''){
   				$('.plan-1-form').html($('.plan-2-form').html());
   			}
   			else if($('.plan-3-form').html()!=''){
   				$('.plan-1-form').html($('.plan-3-form').html());
   			}
   
   			$('.plan-2-form').html('');
   			$('.plan-3-form').html('');
   		}
       }
       else if($(this).hasClass('js-plan-2')){
       	$('.js-plan-1-feature').hide();
       	$('.js-plan-3-feature').hide();
       	$('.js-plan-2-feature').show();
       	$(this).parent('div').addClass('active');
   		
   		if(is_mobile==1){			
   			$('.plan-2-form').html('');
   			if($('.plan-1-form').html()!=''){
   				$('.plan-2-form').html($('.plan-1-form').html());
   			}
   			else if($('.plan-2-form').html()!=''){
   				$('.plan-2-form').html($('.plan-2-form').html());
   			}
   			$('.plan-1-form').html('');
   			$('.plan-3-form').html('');
   		}
       }
       else{
       	$('.js-plan-1-feature').hide();
       	$('.js-plan-2-feature').hide();
       	$('.js-plan-3-feature').show();
       	$(this).parent('div').addClass('active');
   		if(is_mobile==1){
   			$('.plan-3-form').html('');
   			if($('.plan-2-form').html()!=''){
   				$('.plan-3-form').html($('.plan-2-form').html());
   			}
   			else if($('.plan-1-form').html()!=''){
   				$('.plan-3-form').html($('.plan-1-form').html());
   			}
   			$('.plan-1-form').html('');
   			$('.plan-2-form').html('');
   		}
       }
       
       $.LoadingOverlay("hide");
       });
       
       
       $('#plan1-step2 input').livequery('change',function(){
   		var all_fields=false;   
   		$('.js-step-2-circle').removeClass('success');
   		$('.js-plan2-next').attr('disabled', true);
   		$('.business-verfiy-title').addClass('color-red-icon');
   		$('.business-verfiy-title').removeClass('color-green-icon');
   		if($('#name').val() =='' || $('#owner').val() =='' || $('#address_line').val() =='' || $('#campaign_city').val() =='' || $('#campign_area').val()=='' || $('#zip').val()==''){
   			$('.js-step-2-circle').removeClass('success');
   			$('.js-plan2-next').attr('disabled', true);
   			$('.business-verfiy-title').addClass('color-red-icon');
   			$('.business-verfiy-title').removeClass('color-green-icon');
   		}
   		else {
   			$('.js-step-2-circle').addClass('success');
   			$('.js-plan2-next').attr('disabled', false);
   			$('.business-verfiy-title').removeClass('color-red-icon');
   			$('.business-verfiy-title').addClass('color-green-icon');
   		
   		}  
       });
        
           /*************** Step one Next Button *****/
       $('.js-step1-next-button').livequery('click',function(){
   		if($('#email').val() =='' || $('#contact_number').val() ==''){
   		   $(this).attr('disabled', true);
   		}
   		else {
   			$(this).attr('disabled', false);
   			$('#company_name').focus();
   			saveCampignLeads();
   		}
       });
       
       $('#email,#contact_number').livequery('keyup',function(){	
       
   			$('.email-verfiy-title').addClass('color-red-icon');
   			$('.email-verfiy-title').removeClass('color-green-icon');
   			$('.js-step-1-circle').removeClass('success');
       		if($('#contact_number').val() =='') {
       		   $('.js-step1-next-button').attr('disabled', true);
       	    }
       		else if($('#email').val() =='') {
       		   $('.js-step1-next-button').attr('disabled', true);
       	    }
       		else if($('#email').val() !='' && !(/^\w+([\.-]?\ w+)*@\w+([\.-]?\ w+)*(\.\w{2,3})+$/.test($('#email').val()))) {
       			$('.js-step1-next-button').attr('disabled', true);
       		}
       		else if($('#contact_number').val() !='' && $('#contact_number').val().length <=9) {
       			$('.js-step1-next-button').attr('disabled', true);
       		}
       		else {
   				$('.js-step-1-circle').addClass('success');
   				$('.js-step1-next-button').attr('disabled', false);
   				$('.email-verfiy-title').removeClass('color-red-icon');
   				$('.email-verfiy-title').addClass('color-green-icon');
       		}
       	});
            
          $('.keywords').tagsinput('refresh');
          	$('#add_campign_form_url').livequery('submit',function(){
          		$.LoadingOverlay("show");
          		$('.loadingoverlay').css('z-index',999999);
          		$('.td-enquiry-button').attr('disabled',true);
          		var url=jQuery("#add_campign_form_url").attr('action');
          		var $this=jQuery(this);
          		jQuery.ajax({
          			type: "POST",
          			url: url,
          			data:jQuery("#add_campign_form_url").serialize(),
          			datatype:"json",
          			success: function(data){
          				$.LoadingOverlay("hide");
          				$('.loadingoverlay').css('z-index',0);
          				$('.td-enquiry-button').attr('disabled',true);
          				var data=jQuery.parseJSON(data);
          				if(data.status=="error") 
          				{
          					$('.td-enquiry-button').attr('disabled',false);
          					jQuery("#add_campign_form_url input,#add_campign_form_url textarea, #add_campign_form_url select").each(function() {
          						jQuery(this).next('span').remove();
          					});
          					jQuery("#custom_error").html('');
          					if(data.sts=="custom_err")
          					{
          						alert_notification('error',data.msg);
          					}
          					else
          					{				
          						jQuery("#add_campign_form_url input,#add_campign_form_url textarea, #add_campign_form_url select").each(function() {
          							jQuery(this).next('span').remove();
          					    	});
          						jQuery.each(data.errorfields,function(key, value){
          							var error="<span class='login-error'>"+value.error+"</span>";
          						  	$this.find("[name="+value.field+"]").after(error);
          						});
          						alert_notification('error','Please Complete the mandatory fields !');
          					}
          				}
          				else
          				{
          					$('.td-enquiry-button').attr('disabled',false);
          					jQuery("#add_campign_form_url input,#add_campign_form_url textarea, #add_campign_form_url select").each(function() {
          					   jQuery(this).next('span').remove();
          					});
          					$("#add_campign_form_url")[0].reset();
          					$('.mfp-close').trigger('click');
   
   						$('#myModal').modal('show');
   						setTimeout(function(){
   								window.location.href=data.url;
   						},4000);
          				}
          			}
          		});
          		return false;
          	});
          
          function custom_alert_notification(type,message) {
          	  var object1 = {
          		'message'   :message,
          		'position'  :'center center',
          		'inEffect'  :'slideTop',		
          'clearAll'  :true,
          'sticky'       :true,
          'closeOnClick'  :true,
          'closeButton'   :true
          	};
          	
          	if(type=="success"){
          		var object2 = {
          		'theme'   :'colorful',
          		'delay'   :'4000',
          		'content' :{
          					   bgcolor:"#337ab7",
          					   bg_colorcode:'#fff',
          					   message:message
          					},
          		};
          	} else if(type=="error"){
          		var object2 = {
          		'theme'   :'colorful',
          		'content' :{
          					   bgcolor:"#E3434B",
          					   bg_colorcode:'#fff',
          					   message:message
          					},
          		};
          	}else{
          		var object2 = {
          		'theme'   :'awesome ok',
          		'content' :{					   
                                  message:message,
                                  info:'',
                                  icon:'fa fa-check-square-o'
          					},
          		};
          	}
          	$.extend( object1, object2 );
          	$.amaran( object1 );
          }
          
          	$("#campaign_city").on("keyup",function(){
          		$(this).autocomplete({
          			source: __cfg('path_absolute')+'home/get_cities?',
          				select: function(event, ui) {
          					$('#campaign_city_id').val(ui.item.id);
          			}
          		}).data( "ui-autocomplete" )._renderItem = function( ul, item ){
          			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
          			return $("<li></li>")
          			.data( "item.autocomplete", item )
          			.append(inner_html)
          			.appendTo( ul );
          		}
          	});
          	
          	$("#campign_area").on("keyup",function() {
          		var city_id=$('#campaign_city_id').val();
          		$(this).autocomplete({
          			source: __cfg('path_absolute')+'home/get_areas?city_id='+city_id,
          				select: function(event, ui) {
          					$('#campaign_area_id').val(ui.item.id);
          			}
          		}).data( "ui-autocomplete" )._renderItem = function( ul, item ){
          			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
          			return $("<li></li>")
          			.data( "item.autocomplete", item )
          			.append(inner_html)
          			.appendTo( ul );
          		}
          	}); 	
          
          });
</script>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header" style="background-color:#85CE36;color:#fff;">
            <h4 class="modal-title">Wow ! Now Your Become Part Dragdeal Family.</h4>
         </div>
         <div class="modal-body">
            <p>Congratulation ! Almost Done. You Successfully Register Your Business Profile.
               Please be Patient now the page will be redirect to payment.
            </p>
         </div>
      </div>
   </div>
</div>