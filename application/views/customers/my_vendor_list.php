<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-12">
               <h3 class="title">
                  <i class="fa fa-user-md"></i> My Vendors

               </h3>
			   
               <p class="title-description">&nbsp;</p>
			    
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-list-alt"></i> Shop Info</span> </div>
               </div>
               <div class="item-col item-col-header item-col-title1">
                  <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"></i>Total Bill Amount</span> </div>
               </div>
               <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Total Reward Points</span> </div>
               </div>
			    <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Total Redeem Points</span> </div>
               </div>
			     <div class="item-col item-col-header item-col-date">
                  <div> <span><i class="fa fa-calendar"></i> Created</span> </div>
               </div>
               <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
         </li>
        <ul class="item-list striped js-response">
	  
		</ul>
      </ul>
   </div>
   <nav class="text-xs-right js-pagenation">

   </nav>
</div>
</article>
<script>
   var url="<?php echo base_url();?>"+'customers/my_vendors';
   function getallSenderIdList(url){
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			datatype:"json",
			async:true,
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				$('.js-response').html('');
				$('.js-response').html(data.main_content);
				$('.js-pagenation').html(data.pagination_link);
			}
		});
   }
   
   $(document).ready(function(){
		getallSenderIdList(url);
		$('.page-item a').livequery('click',function(){
			getallSenderIdList($(this).attr('href'));
			return false;
		});
		$('#group_form_url').livequery('submit',function(){
		var posturl=$("#group_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: posturl,
			data:$("#group_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#group_form_url input").each(function() {
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
					$('#confirm-modal').hide();
					getallSenderIdList(url);
				}				
			}
		});
		return false;
	});
   });
</script>