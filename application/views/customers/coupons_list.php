<div class="row">
    <div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2><i class="glyphicon glyphicon-list"></i> Coupons List</h2>
			</div>
			<div class="box-content">
				<br>
				<table class="table table-striped table-bordered bootstrap-datatable js-customer-list display dt-responsive" width="100%">
					<tbody>
					</tbody>
				</table>	
				<br>
				<br>
			</div>
		</div>
    </div>
</div>
<script>
var url="<?php echo base_url();?>"+'customers/couponslist';
var responsiveHelper = undefined;
var breakpointDefinition = {
	tablet: 1024,
	phone : 480
};
function getallCouponsList()
{	
	    var tableElement = $('.js-customer-list');
		tableElement.dataTable( {
			"bFilter": false,
			"bSort" : false,
			"responsive": false,
			"sAjaxSource":url,
			"bLengthChange": false,
			"bServerSide" : true,
			"bRetrieve": true,  
			"bdestroy": true,
			"bProcessing":false,
			"bUseRendered":false,
			"aoColumns": [
							{ "sTitle": "Posted Date", "mData": "created"},
							{ "sTitle": "Name", "mData": "name","sClass": "coupon-name","orderable": false},
							{ "sTitle": "Total Coupons", "mData": "total_count"},
							{ "sTitle": "Total Coupons Download", "mData": "total_coupons_download"},
							{ "sTitle": "Expiry Date", "mData": "exipry_date"},
							{ "sTitle": "Action", "mData": "is_active"},
			],
			"oLanguage": {
				"sLengthMenu": "_MENU_ ",
				"sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
				"sEmptyTable": "No Coupons List"
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ) 
			{
				var user_status='<a href="javascript:void(0);" title="Click to Activate" class="success js-activate label label-danger" rel="'+aData[5]+'">In Active</a>&nbsp;';
				if(aData[6]==1)
				{
				  user_status='<a href="javascript:void(0);" title="click to In Activate" class="error js-activate label-success label" rel="'+aData[5]+'">Active</a>&nbsp;';
				}
				var user_download='<a class="export_excel" data-href="<?php echo base_url().'customers/ExportCouponsCode?coupon_id=';?>'+aData[5]+'"  href="#" target="_blank"><span class="label-success label label-default">Download</span></a>';
				$('td:eq(5)', nRow).empty();
				$('td:eq(5)', nRow).append(user_status);
				$('td:eq(5)', nRow).append(user_download);
			},
			bAutoWidth     : false,
			fnPreDrawCallback: function () 
			{
				if (!responsiveHelper) {
					responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
				}
			},
			fnRowCallback  : function (nRow) {
				responsiveHelper.createExpandIcon(nRow);
			},
			fnDrawCallback : function (oSettings) {
				responsiveHelper.respond();
			}
			
		});		
}
$(document).ready(function()
{
	getallCouponsList();
	
	$(document).on("click",".export_excel", function(e) {
		
		window.location.href=$(this).data('href');
	});
	
	$(document).on("click",".js-activate", function(e) {
		
		
		var url="<?php echo base_url().'customers/updateCoupon';?>";
		var coupon_id=$(this).attr('rel');
		if($(this).hasClass('error')){
			var status=0;
		}
		else{
			var status=1;
		}
		var $this=$(this);
		$.ajax({
			type: "POST",
			url: url,
			data:{'coupon_id':coupon_id,'status':status},
			datatype:"json",
			success: function(data)
			{
				var data=jQuery.parseJSON(data);
				if(data.status==1) 
				{
					if(status==1){
						$this.removeClass('error');
						$this.addClass('success');
						console.log($this.find().next('label'));
						$this.removeClass('label-danger');
						$this.addClass('label-success');
						$this.html('');
						$this.html('Active');
					}
					else{
						$this.addClass('error');
						$this.removeClass('success');
						$this.addClass('label-danger');
						$this.removeClass('label-success');
						$this.html('');
						$this.html('In Active');

					}
				}			
			}
		});
	});
});
</script>