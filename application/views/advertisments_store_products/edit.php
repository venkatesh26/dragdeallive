<article class="content cards-page white-bg-art" style="background:#fff">
	<div class="bread-crumb-data">
	   <?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <section class="section">
      <div class="col-xl-12">
	  
         <div class="">
            <div class="card-block">
			 
               <!-- Nav tabs -->
               <div class="card-title-block">
                  <h3 class="title">
                    <i class="fa fa-briefcase"></i> Edit Produts
                  </h3>
               </div>
			   
			   <?php
			   $checked='';
			   if($data['is_active']==1){
				$checked='checked="checked"';   
			   }
			   
			   ?>

               <form id="product_form_url" action="<?php echo base_url().'advertisments_store_products/edit/'.$data['id'];?>" method="Post">
								<div id="range_section">
									<div class="col-md-12 range-section"  id="">							
										<div class="form-group col-md-4">
											<label class="control-label" for="name">Name<span style="color:red;">*</span></label>
											<input type="text" id="name" value="<?php echo $data['name'];?>" placeholder="Enter Product Name" class="form-control product_name" name="product_name"/>

										</div>
							<div class="form-group col-md-4">
											<label class="control-label" for="price">Price  <span style="color:red;">*</span></label>
											<input type="text" id="price" value="<?php echo $data['price'];?>" placeholder="Enter Price" class="service_date form-control" name="price"/>
										</div>
										<div class="form-group col-md-6">
									<label class="control-label" for="is_active">
									<input type="checkbox" value="1" id="is_active" name="is_active" id="is_active" <?php echo $checked;?> data-no-uniform="true" class="checkbox"><span>Active</span></label>
								</div>
										

			                              <div class="box-content clearfix">
                              <button class="btn btn-primary btn-md pull-right">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a class="btn btn-primary btn-md pull-right" href="<?php echo base_url().'products-list';?>" style="margin-right:10px;">Cancel</a>
                           </div>
			   
			   
			   </form>
			   
			 </div>
		</div>
		
		</div>
	</section>
<script>
$(document).ready(function()
{
	$('.clone-data').livequery('click',function(){
		$("#range_section div.range-section").clone().appendTo("div.range-section-clone");	
		$('div.range-section').parents('div#range_section div.range-section:last').find('input.service_date').val('');
		$('div.range-section:last').find('input.service_date').val('');
		$('div.range-section:last').find('input.service_name').val('');
		$('div.range-section:last').find('input.service_id').val('');
		$('div.range-section-clone').find('.clone-remove-data').show();
		return false;
	});

	$('.clone-remove-data').livequery('click',function(){
		$(this).parents('div.range-section').remove();
		$(this).parents('div.range-section').parents('div.range-section-clone').find('div.dummy-div').remove();
	});
	
	$('#product_form_url').livequery('submit',function(){
		var form_url=$("#product_form_url").attr('action');
		var $this=$(this);
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: form_url,
			data:$("#product_form_url").serialize(),
			datatype:"json",
			success: function(data)
			{
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				if(data.status=="error") 
				{
					$("#product_form_url input").each(function() {
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
						$("#product_form_url input").each(function() {
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
					$("#product_form_url textarea").each(function() {
							$(this).next('span').remove();
					});
					$('#message').val('');
					  $('#edit-modal').modal('toggle');
			
					alert_notification('success',data.msg);
					
					window.location.href=__cfg('path_absolute')+"products-list";
				}				
			}
		});
		return false;	
	});	
});
</script>