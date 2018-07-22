<style>
   .container{
   margin-top:20px;
   }
   .image-preview-input {
   position: relative;
   overflow: hidden;
   margin: 0px;    
   color: #fff;
   background-color: #85CE36;
   border-color: #ccc;    
   }
   .image-preview-input input[type=file] {
   position: absolute;
   top: 0;
   right: 0;
   margin: 0;
   padding: 0;
   font-size: 20px;
   cursor: pointer;
   opacity: 0;
   filter: alpha(opacity=0);
   }
   .image-preview-input-title {
   margin-left:2px;
   }	
</style>
<article class="content item-editor-page">
   <div class="title-block">
   <div class="bread-crumb-data">
      <?php echo $this->load->view('elements/breadcrumb',array(),true);?>
   </div>
    <?php echo $this->load->view('elements/profile_complete_alert',array(),true);?>
   <form id="upload_logo_image" action="<?php echo base_url().'advertisments_images/gallery_add';?>" method="Post" class="overlay-section">
      <div class="card card-block">
         <div class="form-group row">
            <label class="col-sm-2 form-control-label text-xs-right">
            Upload Image:
            </label>
            <div class="col-sm-10">
               <div class="images-container">
                  <div class="input-group image-preview">
                     <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                     <span class="input-group-btn">
                        <!-- image-preview-clear button -->
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                        </button>
                        <!-- image-preview-input -->
                        <div class="btn btn-default image-preview-input">
                           <span class="fa fa-folder-open"></span>
                           <span class="image-preview-input-title">Browse</span>
                           <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
                        </div>
                     </span>
                  </div>
                  <!-- /input-group image-preview [TO HERE]-->    
                  <div class="js_gallery_image">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</article>
<div class="modal fade" id="confirm-delete-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
				<h4 class="modal-title"><i class="fa fa-warning"></i> Alert</h4> </div>
			<div class="modal-body">
				<p>Are you sure want to delete ? </p>
			</div>
			<div class="modal-footer"> <button rel="" data-status="" type="button" rel="" class="deleteGallery btn btn-primary change-button-confirm" data-dismiss="modal">Confirm</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script>
   $(document).ready(function(){
	   
	$(document).on("click",".deleteGallery", function(e) {
		deleteGallery($(this).attr('rel'));
	});
	
	$(document).on("click",".delete-gallery", function(e) {
		
		$('.deleteGallery').attr('rel',$(this).attr('rel'));
	});
	
	function deleteGallery(id) {
			var new_url="<?php echo base_url();?>"+'advertisments_images/deleteGallery';
			$.ajax({
			type: 'POST',
			async: false,
			url: new_url,
			dataType:'json',
			data:{'id':id},
			success: function (json)
			{
				alert_notification('success','Image Deleted Successfully');	
				getImage();
			},
			});
		}
	
   	$('#profile_image').livequery('change',function(){ 
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
   					getImage();				
   				}
   			}
   		});
   		return false;
   	});
   	
   getImage();
   	function getImage() {
   		var url="<?php echo base_url();?>"+'advertisments_images/galleryList';
   		$.ajax({
   				type: 'POST',
   				async: false,
   				url: url,
   				dataType:'json',
   				success: function (json)
   				{
   					$('.js_gallery_image').html('');
   					$('.js_gallery_image').html(json);
   				},
   		});	
   	}
   });
</script>