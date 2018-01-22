function __cfg(c) {
	 return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}

function reset($_this)
{
	
	$_this.closest('form').find("input[type=text], textarea").val("");
    $_this.closest('form').find("input,textarea").each(function() 
	{
	  $_this.next('span').remove();
	});	 	
}

function alert_notification(type,message)
{
	 var object1 = {
		'message'   :message,
		'position'  :'top right',
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
					   bgcolor:"#afd136",
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
function map_initialize() { 
  var geocoder;
  var map;
  var address = $('#map_canvas').data('address');
  var title = $('#map_canvas').data('title');
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
		zoom: 15,
		center: latlng,
		mapTypeControl: true,
		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
		navigationControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

            var infowindow = new google.maps.InfoWindow(
                { 
				  content: '<p class="map_content">'+title+'</p>'+'<b>'+address+'</b>',
                  size: new google.maps.Size(100,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 
			google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
           });
           infowindow.open(map,marker);
          } else {
          }
        } else {
        }
      });
    }
}

jQuery(document).ready(function($){
	
	
	$('#td-header-enquiry').hide();
	jQuery(".td-header-enquiry-button-mob").click(function(a){
		jQuery("body").addClass("td-search-opened");0<jQuery("#td-header-enquiry").val().trim().length&&tdAjaxSearch.do_ajax_call_mob()
		$('#td-header-enquiry').show();	
	});

	$('#td-header-search-keyword').on("keyup",function(e){
		if(e.keyCode==13){
			$('.td-search-form').submit();
		}
	});
	
	$('#td-heaer-city').on("keyup",function(e){
		if(e.keyCode==13){
			$('.td-search-form').submit();
		}
	});
	
	$('#td-heaer-area').on("keyup",function(e){
		if(e.keyCode==13){
			$('.td-search-form').submit();
		}
	});
	
	/******** Enquiry Form click **/
	$('.js-enquiry').livequery('click',function(){
		$('.enquiry_advertisment_id').val($(this).attr('data-advertisment'));
		$('.enquiry_form_title').html($(this).attr('data-advertismenttitle'));
		$('.advertisment_email').val($(this).attr('data-advertismentemail'));
		$('.td-enquiry-button').attr('disbled',false);
	});
	
	$('#new_enquiry_form_url_popup1').livequery('submit',function(){
		$.LoadingOverlay("show");
		$('.loadingoverlay').css('z-index',999999);
		$('.td-enquiry-button').attr('disabled',true);
		var url=jQuery("#new_enquiry_form_url_popup1").attr('action');
		var $this=jQuery(this);
		jQuery.ajax({
			type: "POST",
			url: url,
			data:jQuery("#new_enquiry_form_url_popup1").serialize(),
			datatype:"json",
			success: function(data){
				$.LoadingOverlay("hide");
				$('.loadingoverlay').css('z-index',0);
				$('.td-enquiry-button').attr('disabled',true);
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$('.td-enquiry-button').attr('disabled',false);
					jQuery("#new_enquiry_form_url_popup1 input,#new_enquiry_form_url_popup1 textarea").each(function() {
						jQuery(this).next('span').remove();
					});
					jQuery("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						jQuery("#new_enquiry_form_url_popup1 input,#new_enquiry_form_url_popup1 textarea").each(function() {
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
					jQuery("#new_enquiry_form_url_popup1 input,#new_enquiry_form_url_popup1 textarea").each(function() {
							jQuery(this).next('span').remove();
					});
					$("#new_enquiry_form_url_popup1 ")[0].reset();
					$('.mfp-close').trigger('click');
					alert_notification('success',data.msg);
				
				}				

			}
		});
		return false;
	});
	
	
	$('#new_enquiry_form_url_popup').livequery('submit',function(){
		$.LoadingOverlay("show");
		$('.loadingoverlay').css('z-index',999999);
		$('.td-enquiry-button').attr('disabled',true);
		var url=jQuery("#new_enquiry_form_url_popup").attr('action');
		var $this=jQuery(this);
		jQuery.ajax({
			type: "POST",
			url: url,
			data:jQuery("#new_enquiry_form_url_popup").serialize(),
			datatype:"json",
			success: function(data){
				$.LoadingOverlay("hide");
				$('.loadingoverlay').css('z-index',0);
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$('.td-enquiry-button').attr('disabled',false);
					jQuery("#new_enquiry_form_url_popup input,#new_enquiry_form_url_popup textarea").each(function() {
						jQuery(this).next('span').remove();
					});
					jQuery("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						jQuery("#new_enquiry_form_url_popup input,#new_enquiry_form_url_popup textarea").each(function() {
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
					jQuery("#new_enquiry_form_url_popup input,#new_enquiry_form_url_popup textarea").each(function() {
							jQuery(this).next('span').remove();
					});
					$("#new_enquiry_form_url_popup")[0].reset();
					$('.mfp-close').trigger('click');
					alert_notification('success',data.msg);
				}				

			}
		});
		return false;
	});
	
	
	$('#new_login_form_url_popup').livequery('submit',function(){
		var url=jQuery("#new_login_form_url_popup").attr('action');
		var $this=jQuery(this);
		jQuery.ajax({
			type: "POST",
			url: url,
			data:jQuery("#new_login_form_url_popup").serialize(),
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					jQuery("#new_login_form_url_popup input").each(function() {
						jQuery(this).next('span').remove();
					});
					jQuery("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						jQuery("#new_login_form_url_popup input").each(function() {
							jQuery(this).next('span').remove();
					    	});
						jQuery.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Invalid Credentails.Please Try Again..!');
					}
				}
				else
				{
					jQuery("#new_login_form_url_popup input").each(function() {
							jQuery(this).next('span').remove();
					});
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
	
	$('#new_login_form_url').livequery('submit',function(){
		var url=jQuery("#new_login_form_url").attr('action');
		var $this=jQuery(this);
		jQuery.ajax({
			type: "POST",
			url: url,
			data:jQuery("#new_login_form_url").serialize(),
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					jQuery("#new_login_form_url input").each(function() {
						jQuery(this).next('span').remove();
					});
					jQuery("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						jQuery("#new_login_form_url input").each(function() {
							jQuery(this).next('span').remove();
					    	});
						jQuery.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Invalid Credentails.Please Try Again..!');
					}
				}
				else
				{
					jQuery("#new_login_form_url input").each(function() {
							jQuery(this).next('span').remove();
					});
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
	
	$('#login_form_url').livequery('submit',function(){
		
		$('.register-submit-button').attr('disabled',true);
		var url=$("#login_form_url").attr('action');
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#login_form_url").serialize(),
			datatype:"json",
			success: function(data){
				$('.register-submit-button').attr('disabled',false);
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#login_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else
					{
						
						$("#login_form_url input").each(function() {
							$(this).next('span').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please complete the required fields.');
					}
				}
				else
				{
					$("#login_form_url input").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
				}				
			}
		});
		return false;
	});
	
	
	
	$('#forgotpassword_url_popup').livequery('submit',function(){
		var url=$("#forgotpassword_url_popup").attr('action');
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#forgotpassword_url_popup").serialize(),
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#forgotpassword_url_popup input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						$("#forgotpassword_url_popup input").each(function() {
							$(this).next('span').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please complete the mandatory fields..!');
					}
				}
				else
				{
					$("#forgotpassword_url_popup input").each(function() {
							$(this).next('span').remove();
					});
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
	
		$('#forgotpassword_url').livequery('submit',function(){
		var url=$("#forgotpassword_url").attr('action');
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#forgotpassword_url").serialize(),
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#forgotpassword_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						$("#forgotpassword_url input").each(function() {
							$(this).next('span').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please complete the mandatory fields..!');
					}
				}
				else
				{
					$("#forgotpassword_url input").each(function() {
							$(this).next('span').remove();
					});
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
	
	$('#reset_form_url').livequery('submit',function(){
		var url=$("#reset_form_url").attr('action');
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#reset_form_url").serialize(),
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#reset_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						$("#reset_form_url input").each(function() {
							$(this).next('span').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Invalid Credentails.Please Try Again');
					}
				}
				else
				{
					$("#reset_form_url input").each(function() {
							$(this).next('span').remove();
					});	
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
	
	$('#home-search').livequery('submit',function(){
		
	var city_id=$('#home-city').val();
    var area_id=$('#home-area').val();
	if(city_id=='' || city_id==0)
	{
	    alert_notification('error','Please Select City..!');
        return false;		
	}
	});
	
	
	$('#home-city').livequery('change',function(){
	var city_id=$('#home-city option:selected').text();
	if(city_id!='')
	{
		var url=__cfg('path_absolute')+"home/get_city_based_area?city="+city_id;
	   $.ajax({
			type: "POST",
			url: url,
			data:city_id,
			datatype:"json",
			success: function(data){
				var res="";
				var data=jQuery.parseJSON(data);
				$.each(data,function(key, value){
					res+="<option value='"+key+"'>"+value+"</option>"
				});
				$('#home-area').html(res);
			}
		});	
     return false;
	}
    else
	{
		
		 return false;
	}		
	});
	
	$('.stars input').livequery('click',function(){
		$('#new_score').val($(this).data('score'));
	});
	
	$('#user-add-comment').livequery('submit',function(){
		var url=$("#user-add-comment").attr('action');
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#user-add-comment").serialize(),
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#user-add-comment input").each(function() {
						$(this).next('span').remove();
					});
					$('.rate_it_error').html('');
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						$("#user-add-comment input").each(function() {
							$(this).next('span').remove();
					    	});
							$("#user-add-comment textarea").each(function() {
							$(this).next('span').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
							if(value.field=='score'){
								$('.rate_it_error').html(error);
							} else {
								$this.find("[name="+value.field+"]").after(error);
							}
						  	
						});
						alert_notification('error','Please complete the mandatory fields..!');
					}
				}
				else
				{
					$("#user-add-comment input").each(function() {
							$(this).next('span').remove();
					});
					location.reload(true);
				}				
			}
		});
		return false;
	});
	
	$('#contact_form_url').livequery('submit',function(){
		var url=$("#contact_form_url").attr('action');
		$('.contactus_form_submit').attr('disabled',true);
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#contact_form_url").serialize(),
			datatype:"json",
			success: function(data){
				
				$('.contactus_form_submit').attr('disabled',false);
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#contact_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#contact_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						$("#contact_form_url textarea").each(function() {
							$(this).next('span').remove();
					    });
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please Complete the mandatory fields..');
					}
				}
				else
				{
					$("#contact_form_url input,textarea").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
					$("#contact_form_url")[0].reset();
					
				}				
			}
		});
		return false;
	});
	
	$('#claim_form_url').livequery('submit',function(){
		var url=$("#claim_form_url").attr('action');
		$('.contactus_form_submit').attr('disabled',true);
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#claim_form_url").serialize(),
			datatype:"json",
			success: function(data){
				
				$('.contactus_form_submit').attr('disabled',false);
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#claim_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#claim_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						alert_notification('error',data.msg);
					}
					else
					{
						
						$("#claim_form_url textarea").each(function() {
							$(this).next('span').remove();
					    });
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please Complete the mandatory fields..');
					}
				}
				else
				{
					$("#claim_form_url input,textarea").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
					$("#claim_form_url")[0].reset();
					
				}				
			}
		});
		return false;
	});
	
	$('.new_download_coupon_code').livequery('click',function(){
		
		var url=$(this).data('href');
		var $this=$(this);
		var addid=$(this).data('addid');
		var couponid=$(this).data('couponid');
		var $_this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:{'coupon_id':couponid,'add_id':addid},
			datatype:"json",
			success: function(data){
				var data=jQuery.parseJSON(data);
				if(data.status=='success') {
					$_this.html('Code: '+data.coupon_code);
					$_this.removeClass('new_download_coupon_code')
				}
			}
		});
	});
	
	function update_views_counts(id,count,user_id) { 
		var $_this=$(this);
		$.ajax({
			type: "POST",
			url:__cfg('path_absolute')+"listings/udateViewCount";
			data:{'add_id':id,'user_id':user_id,'visit_count':count},
			datatype:"json",
			success: function(data){
			}
		});
	}
});