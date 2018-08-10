<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
		    <?php echo $this->load->view('elements/profile_complete_alert',array(),true);?>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  <i class="fa fa-cloud-upload"></i> Import Product Data
               </h3>
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
   </div>
	<section class="section">
		<div class="row sameheight-container">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
				<div class="card">
					<div class="card-block">
					 <div class="control-group clearfix"> 
							<form id="upload_product_data" action="<?php echo base_url().'advertisments_store_products/import_products';?>" method="Post">
								<div class="controls">
									 <div class="form-group col-md-4">
										 <label class="control-label" for="website">Upload File <span class="required">*</span> </label>
										 <input type="file" class="form-control" id="profile_image" name="file_data"> 
									 </div>
									 <div class="form-group col-md-4" style="margin-top:30px;width:150px;">
										 <button class="btn btn-primary btn-md form-control" style="width:120px;">Submit</button>
									 </div>
									 <div class="form-group col-md-4" style="margin-top:30px;">
										 <button class="btn btn-primary btn-md form-control" style="width:150px;"> <a class="" href="<?php echo base_url().'assets/product.xlsx';?>" download="product.xlsx" style="color:#fff;text-decoration:none;"><i class="fa fa-cloud-download"></i> Sample Excel </a></button>
									 </div>
								</div>						
							</form>
						 </div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>
</article>
<script>
$(document).ready(function() {
	$('#upload_product_data').livequery('submit',function(){
		$.LoadingOverlay("show");
		var url=$("#upload_product_data").attr('action');
		var $this=$(this);
		var form = $('#upload_product_data')[0]; 
        var formData = new FormData(form);
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
				if(data.status=='error'){
					alert_notification('error',data.msg);
				}
				else{
					$('#profile_image').val('');
					alert_notification('success',data.msg);			
				}
				getAllImportList(url);	
			}
		});
		return false;
	});
});
</script>