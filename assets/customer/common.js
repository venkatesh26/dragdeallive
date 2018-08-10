function __cfg(c) {
	 return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function reset($_this)
{
	
	$_this.closest('form').find("input[type=text], textarea, select").val("");
    $_this.closest('form').find("input,textarea,select").each(function() 
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
					   bgcolor:"#29c065",
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

$(document).ready(function()
{	

	var $itemActions = $(".item-actions-dropdown");

	$(document).on('click',function(e) {
		if (!$(e.target).closest('.item-actions-dropdown').length) {
			$itemActions.removeClass('active');
		}
	});
	
	$('.item-actions-toggle-btn').livequery('click',function(e) {
		e.preventDefault();

		var $thisActionList = $(this).closest('.item-actions-dropdown');

		$itemActions.not($thisActionList).removeClass('active');

		$thisActionList.toggleClass('active');	
	});


	var show=$('.profile_preview').attr('rel');
	$('.profile_preview').hide();
    if(show==1){
		$('.profile_preview').show();
	}
	var show=$('.make_payment').attr('rel');
	$('.make_payment').hide();
    if(show==1){
		$('.make_payment').show();
	}
	
	$('#common_form_url').livequery('submit',function(){
		$.LoadingOverlay("show");
		
		var url=$("#common_form_url").attr('action');
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:$("#common_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#common_form_url input").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						var error="<span class='login-error'>"+data.error_msg+"</span>";
						$this.find("[name='old_password']").after(error);
						alert_notification('error',data.msg);
						return false;
					}
					else
					{
						
						$("#common_form_url input").each(function() {
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
					$("#common_form_url input,textarea").each(function() {
							$(this).next('span').remove();
							if(!$(this).hasClass('no-change'))
							{
							$(this).val('');
							}
							
					});
					alert_notification('success',data.msg);
					
				}				
			}
		});
		return false;
	});
	
	
		
	$('#new_profile_form_url').livequery('submit',function(){
		
		$.LoadingOverlay("show");
		var url=$("#new_profile_form_url").attr('action');
		var $this=$(this);
		var form = $('#new_profile_form_url')[0]; 
        var formData = new FormData(form);
        formData.append('first_name', $('#first_name').val());
		formData.append('last_name', $('#last_name').val());
		formData.append('contact_number',$('#contact_number').val());
		formData.append('address',$('#address').val());
		formData.append('email', $('#email').val());
		formData.append('city', $('#city_autocomplete').val());
		formData.append('area', $('#area_autocomplete').val());
		formData.append('dob', $('#dob').val());
		formData.append('image', $('input[type=file]')[0].files[0]); 

		$.ajax({
			type: "POST",
			url: url,
			data:formData,
			datatype:"json",
			contentType: false,
            processData: false,
			success: function(data){
				
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#new_profile_form_url input,select").each(function() {
						$(this).next('span').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						var error="<span class='login-error'>"+data.error_msg+"</span>";
						$this.find("[name='profile_image']").after(error);
						alert_notification('error',data.msg);
						return false;
					}
					else
					{
						
						$("#new_profile_form_url input").each(function() {
							$(this).next('span').remove();
					    	});
						$("#new_profile_form_url select").each(function() {
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
					$("#new_profile_form_url input,textarea,select").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
					
				}				
			}
		});
		return false;
	});
	
			
	$('#business_form_url').livequery('submit',function(){
		
		$('.profile-submit').attr('disabled',true);
		$.LoadingOverlay("show");
		var url=$("#business_form_url").attr('action');
		var $this=$(this);	 
		var form = $('#business_form_url')[0]; 
        var formData = new FormData(form);
		formData.append('image', $('input[type=file]')[0].files[0]);
		var step=$('#tabs li').find('a.active').attr('rel');		
		formData.append('step',step);
		$.ajax({
			type: "POST",
			url: url,
			data:formData,
			datatype:"json",
			contentType: false,
            processData: false,
			success: function(data)
			{
				$.LoadingOverlay("hide");
				$('.profile-submit').attr('disabled',false);
				var data=jQuery.parseJSON(data);
				if(data.status=="error" || data.all_stepcomplete==0 || data.all_stepcomplete==false) 
				{
					if(typeof data.step!='undefined'){
						
						$('#tabs li').find('a.step'+data.step).attr('data-step-complete','1');
						var el=$('#tabs a.step'+data.step);  
						$(el).trigger('click');
					}
					$("#business_form_url input").each(function() {
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
						
						$("#business_form_url input").each(function() {
							$(this).next('span').remove();
					    });
						$("#business_form_url select").each(function() {
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
					$("#business_form_url input,select,textarea").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
					$('.profile_preview').show();
					if(step==6){
						$('#tabs li').find('a').attr('data-step-complete','1');
						var el=$('#tabs a.step7');  
						$(el).trigger('click');
					}
				}				
			}
		});
		return false;
	});
	
	
				
	$('#customer_form_url').livequery('submit',function(){
		var url=$("#customer_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#customer_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#customer_form_url input").each(function() {
						$(this).next('span.login-error').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else
					{
						
						$("#customer_form_url input").each(function() {
							$(this).next('span.login-error').remove();
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
					$("#customer_form_url input").each(function() {
							$(this).next('span.login-error').remove();
					});
					alert_notification('success',data.msg);
					if(!$this.hasClass('js-customer-edit'))
					{	
						reset($this);
					}
				}				
			}
		});
		return false;
	});
	
		
	$("#group_autocomplete").on("keyup",function()
	{	
		$(this).autocomplete({
			source: __cfg('path_absolute')+'home/get_groups',
			select: function(event, ui) 
			{
					$('#group_id').val(ui.item.id);
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item )
		{
			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
			return $("<li></li>")
			.data( "item.autocomplete", item )
			.append(inner_html)
			.appendTo( ul );
		}
	});
	
	$('#coupon_form_url').livequery('submit',function(){
		var url=$("#coupon_form_url").attr('action');
		var $this=$(this);
		var form = $('#coupon_form_url')[0]; 
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
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#coupon_form_url input").each(function() {
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
						
						$("#coupon_form_url input").each(function() {
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
					$('#total_coupon').val('');
					$("#coupon_form_url input").each(function() {
							$(this).next('span').remove();
					});
					alert_notification('success',data.msg);
					if(!$this.hasClass('js-customer-edit'))
					{	
						reset($this);
					}
				}				
			}
		});
		return false;
	});
	
	
	$("#city_autocomplete").on("keyup",function()
	{	
		$(this).autocomplete({
			source: __cfg('path_absolute')+'home/get_cities',
			select: function(event, ui) 
			{
					$('#add_city_id').val(ui.item.id);
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item )
		{
			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
			return $("<li></li>")
			.data( "item.autocomplete", item )
			.append(inner_html)
			.appendTo( ul );
		}
	});
	
	$("#area_autocomplete").on("keyup",function()
	{	
	    var city_id=$('#add_city_id').val();
		$(this).autocomplete({
			source: __cfg('path_absolute')+'home/get_areas?city_id='+city_id,
			select: function(event, ui) 
			{
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item )
		{
			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
			return $("<li></li>")
			.data( "item.autocomplete", item )
			.append(inner_html)
			.appendTo( ul );
		}
	});
	
	$("#maincategory_autocomplete").on("keyup",function()
	{	
		$(this).autocomplete({
			source: __cfg('path_absolute')+'home/get_main_category',
			select: function(event, ui) 
			{
				$('#main_category_id').val(ui.item.id);
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item )
		{
			var inner_html = '<a id="'+ item.id +'"  href="javascript:void(0)">' + item.label + '</a>';
			return $("<li></li>")
			.data( "item.autocomplete", item )
			.append(inner_html)
			.appendTo( ul );
		}
	});

	/************* Tab Section **********/
    $('#tabs a:first').tab('show');
    $('#tabs a').click(function (e) {
        e.preventDefault();
		var step_compelete=$(this).attr('data-step-complete');
		if(step_compelete==1){
			$(this).tab('show');
		}else {
		
			alert_notification('error','<i class="fa fa-info-circle"></i> Please Complete the Fields');
				return false;
		}
    });
	
	$('a.previous-button').click(function (e) {
        e.preventDefault();
		$(this).attr('data-step-complete');
		var el=$('#tabs a.step'+$(this).attr('data-step-complete'));  
		$(el).trigger('click');
    });
	
	$('#feedback_form_url').livequery('submit',function(){
		var url=$("#feedback_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#feedback_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#feedback_form_url input").each(function() {
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
						$("#feedback_form_url input").each(function() {
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
					$("#feedback_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$('#message').val('');
					alert_notification('success',data.msg);
				}				
			}
		});
		return false;
	});
	
	$('#customer_check_info_url').livequery('submit',function(){
		var url=$("#customer_check_info_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#customer_check_info_url").serialize(),
			datatype:"json",
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#customer_check_info_url input").each(function() {
						$(this).next('span.login-error').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
						$("#custom_error").addClass('login-error');
						$("#custom_error").html(data.msg+"<br/>");
					}
					else
					{	
						$("#customer_check_info_url input").each(function() {
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
					$("#customer_check_info_url textarea,input").each(function() {
							$(this).next('span.login-error').remove();
					});
					$('#message').val('');
					$('.existingUserAdd').hide();
					$('.newUserAdd').hide();	
					$('.edit_user_link').hide();
				
					if(data.status=="EXISTING_USER"){
						$('.existingUserAdd').show();
						$('.edit_user_link').show()
						$('.edit_user_link').attr('rel',data.user_datas.id);
						alert_notification('success',data.msg);
					}
					else if(data.status=="NEW_USER_ADD"){
						$('.newUserAdd').show();	
						$('#user_email').val($('#email').val());
						$('#mobile_number').val($('#contact_number').val());
						alert_notification('success',data.msg);
					}
					else if(data.status=="EXISTING_NEW_USER_ADD") {
						$('.newUserAdd').show();	
						$('#user_email').val(data.user_datas.email);
						$('#user_id').val(data.user_datas.id);
						$('#mobile_number').val(data.user_datas.contact_number);
						
						$('#address').val(data.user_datas.address);
						if(data.user_datas.dob!='0000-00-00'){
						 $('#dob').val(data.user_datas.dob);
						}
						if(data.user_datas.doa!='0000-00-00'){
						 $('#doa').val(data.user_datas.doa);
						}
						$('#area_autocomplete').val(data.user_datas.area_name);
						$('#city_autocomplete').val(data.user_datas.city_name);
						$('#last_name').val(data.user_datas.last_name);
						$('#first_name').val(data.user_datas.first_name);
					}
					else {
						$('#user_email').val($('#email').val());
						$('#mobile_number').val($('#contact_number').val());
						
					}
				}				
			}
		});
		return false;
	});
	
	$('.edit_user_link').livequery('click',function(){
		window.location.href=__cfg('path_absolute')+"customers/edit/"+$(this).attr('rel');
	});
	
	
	
});