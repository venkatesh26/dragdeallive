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
                     <i class="fa fa-user"></i> Customer List
                  </h3>
                  <div class="row">
                     <form name="search-stat" id="search-users">
                        <div class="col-md-12">
                           <div class="col-md-2">
                              <label> Name &nbsp;</label>
                              <input type="text" name="s_name" class="date form-control" id="s_name">
                           </div>
                           <div class="col-md-2">
                              <label> &nbsp;Email &nbsp; &nbsp;</label>
                              <input type="text" name="s_email" class="date form-control" id="s_email">
                           </div>
						    <div class="col-md-2">
                              <label> &nbsp;Mobile Number &nbsp; &nbsp;</label>
                              <input type="text" name="s_mno" class="date form-control" id="s_mno">
                           </div>
                           <div class="col-md-4 search-buttons">
						       <button type="button" value="Reset" class="btn btn-primary btn-md pull-right search-stat-reset"  ><i class="fa fa-history"></i> Reset	</button>
                              <button type="submit" value="Search" class="btn btn-primary btn-md pull-right search-stat-submit" style="margin-right:10px;"><i class="fa fa-search"></i> Search	</button>
                          
                           </div>
							<div class="col-md-2 search-buttons">
								<a href="<?php echo base_url().'customer-add';?>" class="btn btn-primary btn-sm rounded-s pull-right clearfix">
									<i class="fa fa-plus-circle"> </i> Add Customer
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
                  <div class="item-col item-col-header item-col-title">
                     <div> <span><i class="fa fa-money"> </i> Total Bill Amount</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-title" style="padding-left:50px;">
                     <div class=""> <span><i class="fa fa-group"> </i> Contact Info</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-title" style="padding-left:90px;">
                     <div> <span><i class="fa fa-bank"> </i> Visit Count</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-author">
                     <div class="no-overflow"> <span><i class="fa fa-thumbs-o-up"> </i> Status</span> </div>
                  </div>
                  <div class="item-col item-col-header item-col-title">
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
   var url="<?php echo base_url();?>"+'customers/customer_list';
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
		
		function deleteUser(customerId) {
			var new_url="<?php echo base_url();?>"+'customers/deleteCustomer';
			$.ajax({
			type: 'POST',
			async: false,
			url: new_url,
			dataType:'json',
			data:{'customer_id':customerId},
			success: function (json)
			{
				alert_notification('success','Customer Deleted Successfully');	
				getallCustomerList(url);
			},
			});
		}
		
		  	
		$(document).on("click",".cutomer_detail_delete", function(e) {
			
			 $('.deleteUser').attr('rel',$(this).attr('rel'));
		});
		
		$(document).on("click",".deleteUser", function(e) {
			deleteUser($(this).attr('rel'));
		});
		
			$(document).on("click",".view-btn-setting", function(e) {
   		  var new_url="<?php echo base_url();?>"+'customers/customerDetails';
   		  var customerId=$(this).attr('rel');
   		  $.ajax({
   				type: 'POST',
   				async: true,
   				url: new_url,
   				dataType:'json',
   				data:{'customer_id':customerId},
   				success: function (json)
   				{
   					$('.posted_date').html(json.created);
   					$('.first_name').html(json.first_name);
   					$('.last_name').html(json.last_name);
						if($.trim(json.last_name)!=''){
						$('.last_name').html(json.last_name);
					}
					else{
						
						$('.last_name').html('-');
					}
   					$('.email').html(json.email);
   					$('.contact_number').html(json.contact_number);
   					$('.address').html(json.address);
					if($.trim(json.address)!=''){
						$('.address').html(json.address);
					}
					else{
						
						$('.address').html('-');
					}
   					
					if($.trim(json.city_name)!=''){
						$('.city_name').html(json.city_name);
					}
					else{
						
						$('.city_name').html('-');
					}
					
					if($.trim(json.area_name)!=''){
						$('.area_name').html(json.area_name);
					}
					else{
						
						$('.area_name').html('-');
					}
   					
   					$('.gender_name').html(json.gender_name);
   					var status_text="In Active";
   					if(json.is_active==1)
   					{
   						status_text="Active";
   					}
   					$('.view_status').html(status_text);
   					var status_text="In Active";
   					if(json.is_aniversy_reminder==1)
   					{
   						status_text="Active";
   					}
   					$('.is_aniversy_reminder').html(status_text);
   					var status_text="In Active";
   					if(json.is_birthday_remainder==1)
   					{
   						status_text="Active";
   					}
   					$('.is_birthday_remainder').html(status_text);
					
   					$('#last_bill_info').html(json.last_bill_amount_paid);
   					$('#last_total_bill_info').html(json.total_amount);
   					$('.group_name').html(json.group_name);
   					$('.visit_count').html(json.visit_count);
   				}
   		  });
           e.preventDefault();
           $('#order-detail-modal').modal('show');
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
			<div class="modal-footer"> <button rel="" data-status="" type="button" rel="" class="deleteUser btn btn-primary change-button-confirm" data-dismiss="modal">Confirm</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="order-detail-modal">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title"><i class="fa fa-user"></i> Customer Detail</h3>
         </div>
         <div class="modal-body">
            <div class="row">
               <fieldset>
                  <div class="control-group views1">
                     <label class="control-label" for="username">Created Date :</label>
                     <div class="controls views posted_date">
                     </div>
                  </div>
                  <div class="control-group views1">
                     <label class="control-label" for="username">First Name :</label>
                     <div class="controls views first_name">										
                     </div>
					 
                  </div>
				   <div class="control-group views1">
				    <label class="control-label" for="username">Last Name :</label>
                     <div class="controls views last_name">	</div>
				   </div>
                  <div class="control-group views1">
                     <label class="control-label" for="username">Email :</label>
                     <div class="controls views email">
                     </div>
                  </div>
				  <div class="control-group views1">
                     <label class="control-label" for="username">Contact Number :</label>
                     <div class="controls views contact_number">
                     </div>
                  </div>
				   <div class="control-group views1">
                     <label class="control-label" for="username">City :</label>
                     <div class="controls views city_name">
                     </div>
                  </div>
				   <div class="control-group views1">
                     <label class="control-label" for="username">Area :</label>
                     <div class="controls views area_name">
                     </div>
                  </div>
				   <div class="control-group views1">
                     <label class="control-label" for="username">Address :</label>
                     <div class="controls views address">
                     </div>
                  </div>
                  <div class="control-group views1">
                     <label class="control-label" for="username">Status:</label>
                     <div class="controls views view_status">
                     </div>
                  </div>
               </fieldset>
            </div>
         </div>
         <div class="modal-footer"> 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
         </div>
      </div>
   </div>
</div>
