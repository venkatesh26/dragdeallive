function __cfg(c) {
	 return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function reset($_this){
	
	$_this.closest('form').find("input[type=text], textarea, select").val("");
    $_this.closest('form').find("input,textarea,select").each(function() 
	{
	  $_this.next('span').remove();
	});	 	
}
function alert_notification(type,message)
{
		swal(type, message,type);
}

function copy() {
  /* Get the text field */
  var copyText = document.getElementById("short_url");

  
  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");
  alert(1);
}

$(document).ready(function() {
	
	$('.js-copy').livequery('click',function(){
		copy();
	});
	
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
	
		
	$('#create_after_login_url').livequery('submit',function(){
		
		var url=$("#create_after_login_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#create_after_login_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#create_after_login_url input").each(function() {
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
			
						$("#create_after_login_url input").each(function() {
							$(this).next('span.login-error').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error clearfix'>"+value.error+"</span>";
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
					//alert_notification('success',data.msg);
					if(!$this.hasClass('js-customer-edit'))
					{	
						reset($this);
					}
					
					$('#short_url').html(data.data.short_url);
					$('#iframe-src').attr('src',data.data.long_url);
					$('#copyModal').modal({
						show: 'false'
					}); 
					
				}				
			}
		});
		return false;
	});
	
	
	$('#login_form_url').livequery('submit',function(){
		
		var url=$("#login_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			data:$("#login_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#login_form_url input").each(function() {
						$(this).next('span.login-error').remove();
					});
					$("#custom_error").html('');
					if(data.sts=="custom_err")
					{
							alert_notification('error',data.msg);
					}
					else
					{
						$("#login_form_url input").each(function() {
							$(this).next('span.login-error').remove();
					    	});
						$.each(data.errorfields,function(key, value){
							var error="<span class='login-error clearfix'>"+value.error+"</span>";
						  	$this.find("[name="+value.field+"]").after(error);
						});
						alert_notification('error','Please complete the required fields.');
					}
				}
				else
				{
					$("#login_form_url input").each(function() {
							$(this).next('span.login-error').remove();
					});
					alert_notification('success',data.msg);
					if(!$this.hasClass('js-customer-edit'))
					{	
						reset($this);
					}
					window.location.href=data.url;
				}				
			}
		});
		return false;
	});
});