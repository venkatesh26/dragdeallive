<div class="row">
    <div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2><i class="glyphicon glyphicon-list"></i> My Offers</h2>
			</div>
			<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable js-customer-list dt-responsive"  width="100%">
				<tbody>
				</tbody>
				</table>	
				<br>
				<br>
			</div>
		</div>
    </div>
    <!--/span-->
    </div><!--/row-->
<script>
var url="<?php echo base_url();?>"+'customers/my_offers_data';
var responsiveHelper = undefined;
var breakpointDefinition = {
	tablet: 1024,
	phone : 480
};
function getAllOffersList() {	
	    var tableElement = $('.js-customer-list');
		tableElement.DataTable( {
			"bFilter": false,
			"bSort" : false,
			"responsive": true,
			"sAjaxSource":url,
			"bLengthChange": false,
			"bServerSide" : true,
			"bRetrieve": true,  
			"bdestroy": true,
			"bProcessing":false,
			"bUseRendered":false,
			"aoColumns": [
							{ "sTitle": "Date", "mData": "created"},
							{ "sTitle": "Offer Name", "mData": "name","sClass": "coupon-name","orderable": false},
							{ "sTitle": "Customer Name", "mData": "description","sClass": "pendinglist-username","orderable": false},
							{ "sTitle": "Message", "mData": "description","sClass": "pendinglist-username","orderable": false},
							{ "sTitle": "Start Date", "mData": "exipry_date"},
							{ "sTitle": "End Date", "mData": "exipry_date"},
			],
			"oLanguage": {
				"sLengthMenu": "_MENU_ ",
				"sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
				"sEmptyTable": "No Coupons List"
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ) 
			{
				$('.js-download-coupons').show();
				var user_status='<span class="label-success label label-danger">In Active</span>';

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
$(document).ready(function() {
	getAllOffersList();
});
</script>