<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
	    <?php echo $this->load->view('elements/profile_complete_alert',array(),true);?>
   <div class="white-bg">
      <div class="title-search-block">
         <div class="title-block1">
            <div class="row">
               <div class="col-md-12">
                  <h3 class="title">
                     <i class="fa fa-user"></i> Products List
                  </h3>
                  <div class="row">
                     <form name="search-stat" id="search-users">
                        <div class="col-md-12">
                           <div class="col-md-2">
                              <label> Name &nbsp;</label>
                              <input type="text" name="s_name" class="date form-control" id="s_name">
                           </div>
                           <div class="col-md-4 search-buttons">
						       <button type="button" value="Reset" class="btn btn-primary btn-md pull-right search-stat-reset"  ><i class="fa fa-history"></i> Reset	</button>
                              <button type="submit" value="Search" class="btn btn-primary btn-md pull-right search-stat-submit" style="margin-right:10px;"><i class="fa fa-search"></i> Search	</button>
                          
                           </div>
							<div class="col-md-2 search-buttons">
								<a href="<?php echo base_url().'product-add';?>" class="btn btn-primary btn-sm rounded-s pull-right clearfix">
									<i class="fa fa-plus-circle"> </i> Add Product
								</a>
							</div>
                        </div>
                     </form>
                   
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card items">
         <ul class="item-list striped">
            <li class="item item-list-header hidden-sm-down td-header-bar">
               <div class="item-row">
                  <div class="item-col item-col-header item-col-title">
                     <div> <span><i class="fa fa-list-alt"> </i> Name</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-category">
                     <div> <span><i class="fa fa-money"> </i> Price</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-author">
                     <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"> </i> Status</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-title1">
                     <div> <span> <i class="fa fa-calendar"> </i>  Created Date</span> </div>
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
   var url="<?php echo base_url();?>"+'advertisments_store_products/index';
   function getallCustomerList(url) {
	   $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: url,
			datatype:"json",
			data: $( "#search-users" ).serialize(),
			async:true,
			success: function(data) {
			   $.LoadingOverlay("hide");
			   var data=jQuery.parseJSON(data);
			   $('.js-response').html(data.main_content);
			   $('.js-pagenation').html(data.pagination_link);
			}
		});
   }
   $(document).ready(function() {
	   getallCustomerList(url);
	   $('.page-item a').livequery('click',function(){
		   getallCustomerList($(this).attr('href'));
		   return false;
	   });

		$(document).on("click",".search-stat-submit", function(e) {
			getallCustomerList(url);
			return false;
		});
		
		$(document).on("click",".search-stat-reset", function(e) {
			$('#s_name').val('');
			$('#s_email').val('');
			$('#s_mno').val('');
			getallCustomerList(url);	
			return false;
		});
		
		function deleteProduct(product_id) {
			var new_url="<?php echo base_url();?>"+'advertisments_store_products/deleteProducts';
			$.ajax({
			type: 'POST',
			async: false,
			url: new_url,
			dataType:'json',
			data:{'product_id':product_id},
			success: function (json)
			{
				alert_notification('success','Product Deleted Successfully');	
				getallCustomerList(url);
			},
			});
		}
		  	
		$(document).on("click",".product_detail_delete", function(e) {
			$('.deleteProduct').attr('rel',$(this).attr('rel'));
		});
		
		$(document).on("click",".deleteProduct", function(e) {
			deleteProduct($(this).attr('rel'));
		});
	});
</script>

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
			<div class="modal-footer"> <button rel="" data-status="" type="button" rel="" class="deleteProduct btn btn-primary change-button-confirm" data-dismiss="modal">Confirm</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>