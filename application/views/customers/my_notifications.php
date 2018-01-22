<div class="row">
    <div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2><i class="glyphicon glyphicon-comment"></i> Notifications</h2>
			</div>
			<div class="box-content">
				<br/>
				<table class="table table-striped table-bordered bootstrap-datatable js-notification-list dt-responsive"  width="100%">
				<tbody>
				</tbody>
				</table>	
				<br/>
				<br/>
			 </div>
		</div>
    </div>
</div>
<script>
var url="<?php echo base_url();?>"+'customers/get_notification_list';
var responsiveHelper = undefined;
var breakpointDefinition = {
	tablet: 1024,
	phone : 480
};
function getallNotificationList()
{	
	    var tableElement = $('.js-notification-list');
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
							{ "sTitle": "Date", "mData": "created"},
							{ "sTitle": "Title", "mData": "plan_name","orderable": false},
							{ "sTitle": "Message", "mData": "payment_id","orderable": false},
							{ "sTitle": "Action", "mData": "payment_id","orderable": false},
			],
			"oLanguage": {
				"sLengthMenu": "_MENU_ ",
				"sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries",
				"sEmptyTable": "No Notifications"
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ) 
			{
			    var my_class='view-btn-setting label-danger';
				my_class='view-btn-setting label-success';
				var status='<a href="javascript:void(0)"><span rel="'+aData[4]+'" class="'+my_class+' label">view</span></a>';
				$('td:eq(3)', nRow).empty();
				$('td:eq(3)', nRow).append(status);
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
	
		getallNotificationList();
		$(document).on("click",".view-btn-setting", function(e) {
		  var new_url="<?php echo base_url();?>"+'customers/notificationDetails';
		  var notification_id=$(this).attr('rel');
		  $.ajax({
				type: 'POST',
				async: false,
				url: new_url,
				dataType:'json',
				data:{'notification_id':notification_id},
				success: function (json){
					$('.posted_date').html(json.created);
					$('.title').html(json.title);
					$('.message').html(json.message);
				}
		  });
        e.preventDefault();
        $('#myModal').modal('show');
    });
	
	
});
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4>Notification Details</h4>
                </div>
                <div class="modal-body">
					<div class="box-content clearfix" >
						<div class="box-header well" data-original-title="">
						<h2><i class="glyphicon glyphicon-phone color-theme-1"></i> Basic Information</h2>
						</div>
						<h2></h2>
						<div class="controls">
							<div class="form-group col-md-6">
							<label class="control-label" for="last_bill_amount">Created Date : <b class="posted_date"></b></label>
							</div>
							<div class="form-group col-md-6">
							<label class="control-label" for="first_name">Title : <b class="title"></b></label>
							</div>
							<div class="form-group col-md-6">
							<label class="control-label" for="first_name">Message : <b class="message"></b></label>
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>	