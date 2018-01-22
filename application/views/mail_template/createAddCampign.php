
<style>
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
		 
		 <h1 class="entry-title td-page-title plan_description">Register Your business as premium listing at Just Rs.500 for Life Time.<span> (Note : This offer is available for limited users only).</span></h1>
         <h5 style="font-size:14px;"><span style=""><span style="color:red">*</span> denotes mandatory fields</span></h5>
      </div>
      <div class="td-pb-row">
         <div class="wpb_raw_code wpb_content_element wpb_raw_html">
            <div class="wpb_wrapper td-main-content">
               <h4 class="block-title"><span>Post Your Business</span></h4>
            </div>
         </div>
         <form action="<?php echo base_url().'home/createAddCampaign';?>" method="post" id="add_campign_form_url">
            <div class="td-pb-span12 td-main-content" role="main">
               <div class="td-ss-main-content">
                  <div class="td-pb-padding-side td-page-content">
                     <div class="vc_row wpb_row td-pb-row">
                        <div class="wpb_column vc_column_container td-pb-span12">
                           <div class="wpb_wrapper">
                              <div class="vc_row wpb_row vc_inner td-pb-row">
                                 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="company_name"> Company Name <span class="required">*</span></label>
                                       <input type="text" name="name" placeholder="Ener Your Company Name" id="company_name" value="" size="40">

                                    </p>
                                 </div>
                                 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="user_email">Email -ID<span class="required"> *</span></label>
                                       <input type="text" id="user_email" name="email" placeholder="Enter Your email-ID" value="" size="40">
                                    </p>
                                 </div>
                                 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="owner"> Owner <span class="required">*</span></label>
                                       <input type="text" name="owner" id="owner" placeholder="Enter Owner Name" value="" size="40">
									   
									   
                                    </p>
                                 </div>
                                 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="contact_number"> Contact Number <span class="required">*</span></label>
                                       <input type="text" name="contact_number" placeholder="Enter Contact Number" id="contact_number" value="" size="40">
                                    </p>
                                 </div>
								  <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="address_line"> Adress Line <span class="required">*</span></label>
                                       <input type="text" name="address_line" placeholder="Enter Your Address Line" id="address_line" value="" size="40">
									   
                                    </p>
                                 </div>
								    <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="campaign_city"> City <span class="required">*</span></label><span class="wpcf7-form-control-wrap your-email">
                                       <input type="text" name="city" placeholder="Enter City Name" value="" id="campaign_city" size="40"></span>
                                       <input type="hidden" name="city_id" id="campaign_city_id">
                                    </p>
                                 </div>
                                 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="campaign_area"> Area <span class="required">*</span></label>
                                       <input type="text" name="area" id="campaign_area" placeholder="Enter Area Name" value="" size="40">
                                       <input type="hidden" name="area_id" id="campaign_area_id">
      
                                    </p>
                                 </div>
                                
                                 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="website"> Zip Code<span class="required"> *</span></label>
									
                                       <input type="text" name="zip" placeholder="Enter Your zip Code" id="zip" value="" size="40">
									   
                                    </p>
                                 </div>
								 
								 <div class="wpb_column vc_column_container td-pb-span4">
                                    <p><label class="campaign-label" for="website"> Website <span class="required"> *</span></label>
									
                                       <input type="text" name="webiste" placeholder="Enter Your webiste" id="zip" value="" size="40">
									   
                                    </p>
                                 </div>
								  <div class="wpb_column vc_column_container td-pb-span12">
                                    <p><label class="campaign-label" for="keywords"> Keywords <span class="notes">(Note:use enter key to add multiple keywords)</span><span class="required"></span></label>
									
                                     <input type="text" name="keywords" class="keywords" id="keywords" value="" size="40">
									  
                                    </p>
                                 </div>
								 <div class="wpb_column vc_column_container td-pb-span12">
                                    <p><label class="campaign-label" for="description"> Description <span class="required"></span></label>
									
                                       <textarea type="text" name="description" placeholder="Enter Your Company Description" id="description" value="" size="40"></textarea>
									   
                                    </p>
                                 </div>
								 
                              
                              </div>
                           </div>
                        </div>
                     
					      <p>
                                    <input type="submit" value="Post Advertisment" class="wpcf7-form-control wpcf7-submit register-submit-button" style="float:right;">
                                 </p>
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
   jQuery(document).ready(function($){	
   
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
   					$("#add_campign_form_url ")[0].reset();
   					$('.mfp-close').trigger('click');
   					cutom_alert_notification('success',data.msg);
   				}
   			}
   		});
   		return false;
   	});
   
   function cutom_alert_notification(type,message)
   {
   	 var object1 = {
   		'message'   :message,
   		'position'  :'center',
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
   		var city_id=$('#city_id').val();
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
  