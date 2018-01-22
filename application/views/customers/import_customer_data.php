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
                  <i class="fa fa-cloud-upload"></i> Import Customer Data
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
							<form id="upload_logo_image" action="<?php echo base_url().'customers/import_customers';?>" method="Post">
								<div class="controls">
									 <div class="form-group col-md-4">
										 <label class="control-label" for="website">Upload File <span class="required">*</span> </label>
										 <input type="file" class="form-control" id="profile_image" name="file_data"> 
									 </div>
									 <div class="form-group col-md-4" style="margin-top:30px;width:150px;">
										 <button class="btn btn-primary btn-md form-control" style="width:120px;">Submit</button>
									 </div>
									 <div class="form-group col-md-4" style="margin-top:30px;">
										 <button class="btn btn-primary btn-md form-control" style="width:150px;"> <a class="" href="<?php echo base_url().'assets/sample.xlsx';?>" download="sample.xlsx" style="color:#fff;text-decoration:none;"><i class="fa fa-cloud-download"></i> Sample Excel </a></button>
									 </div>
								</div>						
							</form>
						 </div>
					</div>
				</div>
			</div>
		</div>
	</section>
		<div class="card items">
		    <ul class="item-list striped">
				<li class="item item-list-header hidden-sm-down td-header-bar">
					<div class="item-row">
				
					   <div class="item-col item-col-header item-col-title">
						  <div> <span><i class="fa fa-list-alt"></i> File Name</span> </div>
					   </div>
					   <div class="item-col item-col-header item-col-title" style="padding-left:90px;">
						  <div class=""> <span><i class="fa fa-list-alt"></i> Total Customers</span> </div>
					   </div>
					   <div class="item-col item-col-header item-col-author">
						  <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"></i> Status</span> </div>
					   </div>
					   	 <div class="item-col item-col-header item-col-date">
						  <div> <span><i class="fa fa-calendar"></i> Date</span> </div>
					   </div>
					   <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
					</div>
				</li>
		    </ul>
		  <ul class="item-list striped js-response">
		  
		  </ul>
		</div>
	   <nav class="text-xs-right js-pagenation">
	   </nav>
</div>
</article>
<script>
$(document).ready(function() {
   var url="<?php echo base_url();?>"+'customers/importHistroyList';
   function getAllImportList(url){
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			datatype:"json",
			async:false,
			success: function(data) {
				$.LoadingOverlay("hide");
				var data=jQuery.parseJSON(data);
				$('.js-response').html(data.main_content);
				$('.js-pagenation').html(data.pagination_link);
			}
		});
   }
   $(document).ready(function() {
		getAllImportList(url);
		$('.page-item a').livequery('click',function(){
			getAllImportList($(this).attr('href'));
			return false;
		});
   });
			
	$('#upload_logo_image').livequery('submit',function(){
		$.LoadingOverlay("show");
		var url=$("#upload_logo_image").attr('action');
		var $this=$(this);
		var form = $('#upload_logo_image')[0]; 
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