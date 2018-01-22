<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
		<?php echo $this->load->view('elements/plan_upgrade_alert',array(),true);?>
<div class="white-bg">
   <div class="title-search-block">
      <div class="title-block1">
         <div class="row">
            <div class="col-md-6">
               <h3 class="title">
                  <i class="fa fa-legal"></i> Remainder Histroy
               </h3>
               <p class="title-description">&nbsp;</p>
            </div>
         </div>
      </div>
   </div>
   <div class="card items">
      <ul class="item-list striped">
         <li class="item item-list-header hidden-sm-down td-header-bar">
            <div class="item-row">
               <div class="item-col item-col-header item-col-title">
                  <div> <span><i class="fa fa-list-alt"> </i> Remainder Name</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category">
                  <div> <span><i class="fa fa-info-circle"> </i> Sms Info</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category" style="padding-left:130px;">
                  <div> <span><i class="fa fa-clock-o"> </i> Type</span> </div>
               </div>
               <div class="item-col item-col-header item-col-category">
                  <div> <span><i class="fa fa-calendar"> </i> Sent Date</span> </div>
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
   var url="<?php echo base_url();?>"+'remainders/history';
   function getallOrdersList(url){
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
		getallOrdersList(url);
		$('.page-item a').livequery('click',function(){
			getallOrdersList($(this).attr('href'));
			return false;
		});
		
		$('.order_detail').livequery('click',function(){
			$('.view_date').html($(this).data('date'));
			$('.view_payment_id').html($(this).data('paymentid'));
			$('.view_plan_name').html($(this).data('plan-name'));
			$('.view_user_info').html($(this).data('info'));
			$('.view_price').html($(this).data('price'));
			$('.view_status').html($(this).data('status'));
		});
   });
</script>