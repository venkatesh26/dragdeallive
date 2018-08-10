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
                    <i class="fa fa-briefcase"></i> Add Products
                  </h3>
               </div>

               <form id="product_form_url" action="<?php echo base_url().'advertisments_store_products/add';?>" method="Post">
								<div id="range_section">
									<div class="col-md-12 range-section"  id="">							
										<div class="form-group col-md-4">
											<label class="control-label" for="email">Name<span style="color:red;">*</span></label>
											<input required type="text" placeholder="Enter Product Name" class="form-control product_name products_autocomplete" name="product_name[]"/>
											<input type="hidden" class="form-control product_id" name="product_id[]"/>
										</div>
										<div class="form-group col-md-4">
											<label class="control-label" for="email">Price  <span style="color:red;">*</span></label>
											<input required type="number" placeholder="Enter Price" class="service_date form-control" name="product_price[]"/>
										</div>
										<div class="form-group col-md-4">
											<label class="control-label" for="email" style="margin-top:34px;">	<i class="fa fa-plus-circle clone-data cursor"></i></label>
											&nbsp;<label class="control-label" for="email" style="margin-top:34px;color:red;">	
											<i style="color:red;display:none;" class="fa fa-close clone-remove-data cursor"></i></label>
										</div>
									</div>
								</div>
							<div class="range-section-clone">

							</div>
			                              <div class="box-content clearfix">
                              <button class="btn btn-primary btn-md pull-right">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <a class="btn btn-primary btn-md pull-right" href="<?php echo base_url().'customer-list';?>" style="margin-right:10px;">Cancel</a>
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
				}				
			}
		});
		return false;	
	});	
	
	$('.products_autocomplete').livequery('keyup',function(){		
		$(this).autocomplete({
			source: __cfg('path_absolute')+'advertisments_store_products/get_products_autocomplete',
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
});
</script>