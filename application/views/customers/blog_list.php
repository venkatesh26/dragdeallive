<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-list"></i> Blog List</h2>
    </div>
    <div class="box-content">
		<br>
		<table class="table table-striped table-bordered bootstrap-datatable js-blog-list responsive">
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
var url="<?php echo base_url();?>"+'customers/bloglist';
var responsiveHelper = undefined;
var breakpointDefinition = {
	tablet: 1024,
	phone : 480
};
function getallCustomerList()
{	
	    var tableElement = $('.js-blog-list');
		tableElement.dataTable( {
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
							{ "sTitle": "Posted Date", "mData": "created"},
							{ "sTitle": "Blog Name", "mData": "first_name","sClass": "list-username","orderable": false},
							{ "sTitle": "Short Description", "mData": "contact_number","sClass": "pendinglist-username","orderable": false},
							{ "sTitle": "Status", "mData": "is_active"},
							{ "sTitle": "Action", "mData": "is_active"},
			],
			"oLanguage": {
				"sLengthMenu": "_MENU_ ",
				"sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
				"sEmptyTable": "No Blog List"
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ) 
			{
				var user_status='<span class="label-success label label-danger">In Active</span>';
				if(aData[4]==1)
				{
				  user_status='<span class="label-success label label-default">Active</span>';
				}
				$('td:eq(4)', nRow).empty();
				$('td:eq(4)', nRow).append(user_status);
				
				$('td:eq(5)', nRow).empty();
				$('td:eq(5)', nRow).append('<a href="javascript:void(0)" rel="'+aData[6]+'"><i class="glyphicon glyphicon-zoom-in icon-white"></i></a>&nbsp;<a href="javascript:void(0)" rel="'+aData[6]+'"><i class="glyphicon glyphicon-edit icon-white"></i></a>&nbsp;<a href="javascript:void(0)" rel="'+aData[6]+'" class="js-delete-customer-list"><i class="glyphicon glyphicon-trash icon-white"></i></a>');
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
	getallCustomerList();
});
</script>
