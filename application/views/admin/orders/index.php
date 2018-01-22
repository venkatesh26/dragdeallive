<?php 
if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">      		
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-shopping-cart"></i>
	      				<h3><?php echo $indextitle; ?></h3>
						<?php 
						$pagestatus = $this->uri->segment(3) ? $this->uri->segment(3) : 'orders';
						$pagingstatus = $this->uri->segment(4) ? $this->uri->segment(4) : '1';
						$fieldssort = $this->uri->segment(5) ? $this->uri->segment(5) : 'id';
						$ordersort = $this->uri->segment(6) ? $this->uri->segment(6) : 'desc';
						?>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<ul class="nav nav-tabs">
							<li <?php if($this->uri->segment(3)=="" || $this->uri->segment(3)=="index") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/orders','All'); ?></li>
							<li <?php if($this->uri->segment(3)=="success") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/orders/success','Success'); ?></li>	
							<li <?php if($this->uri->segment(3)=="cancel") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/orders/cancel','Canceled'); ?></li>
							<li <?php if($this->uri->segment(3)=="fail") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/orders/fail','Aborted'); ?></li>
						</ul>
							<?php if( count($users)) {
							/*Excel export*/
							$excel_att = array('id' => 'top_user_report_excel', 'target'=>'_blank');
							echo form_open(ADMIN.'/orders', $excel_att);
							$excel_submit = array('name' => 'excel_export', 'class' => 'btn btn-primary report_excel', 'value' => 'Export', 'title' => 'Export');?>
									<input type="hidden" name="tab-type" value="<?php echo $type;?>">
							<?php
							echo form_submit($excel_submit);		
							echo form_close();	
							/*Excel End*/
							}
							if($this->session->flashdata('flash_message')){
								echo $this->session->flashdata('flash_message');
							}
						/******** Pagination count ***********/ 
							$page_num = (int)$this->uri->segment(4);
						 if($page_num==0) { $page_num=1; }
							$i = ($page_num -1 ) * $per_page; 
							$order_seg = $this->uri->segment(6,"asc"); 
						 if($order_seg == "asc") $order = "desc"; else $order = "asc";
							$sort_seg = $this->uri->segment(5);
							if($order == 'asc')
								$sort_img= img(base_url().'assets/img/admin/sort_desc.png');
							else
								$sort_img = img(base_url().'assets/img/admin/sort_asc.png');
								
							$sort_att = array('class'=>'sorting');
							$sort_def_img = img(base_url().'assets/img/admin/sort_both.png');
							
							 echo form_open(ADMIN.'/orders/'.$type.'/1');
							?>
							
							<div  id="module-search" class="pull-right">
							<div class="quick-search-containers">
								<div class="input-group input-group-sm">
									<?php 
									 echo form_input(array('name'=>'keyword','class'=> 'span2 m-wrap','id'=>'name'),$keyword);
									 $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default', 'value' => 'Go!', 'title' => 'Go');
									?>
									<span class="input-group-btn go-search">	
									<?php echo form_submit($submit_val);
									echo ' '.anchor(ADMIN.'/orders/'.$type.'/1/reset', 'Clear' ,array('title'=>'Clear', 'class'=>'btn btn-sm btn-default'));
									?>
									</span>
									
								</div>
							</div>
							<small class="pull-right"><a href="#" class="advanced-search-toggle<?php echo $this->uri->segment(2) ;?>">+ Advanced Search</a></small>
						</div>

						<div class="clearfix"></div>

						<div class="advenced_search_container row" id="advenced_search_container" <?php echo isset($advanced_searchs) ? '' : 'style="display:none"'; ?>>
							<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="phone">From Date</label>
										<?php echo form_input(array('placeholder'=>'YYYY-MM-DD','name'=>'from_date','class'=> 'span3','id'=>'checkin'),$this->input->post('from_date')); ?>
									</div>	
								</div> 
								<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="phone">To Date</label>
										<?php echo form_input(array('placeholder'=>'YYYY-MM-DD','name'=>'to_date','class'=> 'span3','id'=>'checkout'),$this->input->post('to_date')); ?>
									</div>	
								</div> 
							   <div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="title">Customer Name</label>
										<?php echo form_input(array('name'=>'first_name','class'=> 'span3','placeholder'=>'Customer Name'),$this->input->post('first_name')); ?>
									</div>	
								</div>
								<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="title">Offer Name</label>
										<?php echo form_input(array('name'=>'offer_name','class'=> 'span3 m-wrap','placeholder'=>'Offer Name'),$this->input->post('offer_name')); ?>
									</div>	
								</div>
									<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="title">Hotel Name</label>
										<?php echo form_input(array('name'=>'hotel_name','class'=> 'span3 m-wrap','placeholder'=>'Hotel Name'),$this->input->post('hotel_name')); ?>
									</div>	
								</div>
							<div class="clearfix"></div>
								<div class="advance-btn">
								<?php 
								 $data_submit = array('name' => 'submit-advanced-search', 'class' => 'btn btn-sm btn-primary', 'value' => 'Submit', 'title' => 'Submit');
								echo form_submit($data_submit).' | ';
								echo anchor(ADMIN.'/orders/'.$type.'/1/reset', 'Clear' ,array('title'=>'Clear', 'class'=>'btn btn-sm btn-default'));
								?>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
						<!-- /widget -->
						<!-- /widget -->
					<?php echo form_open(base_url().ADMIN.'/users/bulkautions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
					  <div class="widget widget-table action-table">
						<!-- /widget-header -->
						<div class="widget-content">
						  <table class="table table-striped table-bordered" id="rowclick1">
							<thead>
							  <tr>

							  	<th class="create-wt">  <?php $sort_url = base_url().ADMIN.'/orders/'.$type.'/'.$page_num.'/created/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Created'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Created'.$sort_def_img, $sort_att ); }?> </th>
								<th class="create-wt"><?php $sort_url = base_url().ADMIN.'/orders/'.$type.'/'.$page_num.'/first_name/'.$order;   if($sort_seg == 'first_name') {  echo anchor($sort_url ,'Customer Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Customer Name'.$sort_def_img, $sort_att ); }?></th>	
								<th class="create-wt"><?php $sort_url = base_url().ADMIN.'/orders/'.$type.'/'.$page_num.'/offer_name/'.$order;   if($sort_seg == 'offer_name') {  echo anchor($sort_url ,'Offer Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Offer Name'.$sort_def_img, $sort_att ); }?></th>	
							     <th class="create-wt"><?php $sort_url = base_url().ADMIN.'/orders/'.$type.'/'.$page_num.'/amount/'.$order;   if($sort_seg == 'amount') {  echo anchor($sort_url ,'Amount'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Amount'.$sort_def_img, $sort_att ); }?></th>
								<th class="td-actions">Status</th>
								<th class="td-actions">Action</th>
							  </tr>
							</thead>
							<tbody>
							<?php //print_r($users);
							if(count($users)) {
								foreach($users as $vals) { $i++; 
							?>
							  <tr class="check-select">
							  <td> <?php echo timespan(strtotime($vals['created']),time()); ?> </td>
								<td> <?php echo ucfirst($vals['first_name']); ?> </td>
								<td> <?php echo ucfirst($vals['offer_name']); ?> </td>
								<td> <?php echo $vals['amount']; ?> </td>
								<td> <?php 
								if($vals['order_status']==1)
								{
								echo "Success";
								}
								else if($vals['order_status']==2)
								{
								echo "Canceled";
								}
								else{
								  echo "Aborted";
								} ?> </td>
								<td class="td-actions">
								<?php 
								echo anchor(base_url().ADMIN.'/orders/view/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-list-alt"> </i>',array('class'=>'btn btn-big','title'=>'View'));
								?>
								</td>
							  </tr>
							<?php }
							} else { ?>
							<tr>
							<th colspan="7" class="norecordfound">No Record Found</th>
							</tr>
							<?php } ?>
							</tbody>
						  </table>
						</div>
						<!-- /widget-content --> 
					  </div>
						<!-- /Multi Actions --> 
						<div class="actions">
						<div class="hob-paging"><?php echo '<div class="pagination" style="float:right;">'.$this->pagination->create_links().'</div>'; ?></div>
						</div>
						<!-- /Multi Actions --> 
						<?php echo form_close(); ?>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
	      	</div> <!-- /span8 -->
	      </div> <!-- /row -->
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->
<script src="assets/js/admin/jquery.datetimepicker.js"></script>
<script>
$("#checkin").datepicker({
	  dateFormat: "yy-mm-dd",
	  yearRange: '-3:+3',
      defaultDate: "+1w",
      numberOfMonths: 1,
	  maxDate: new Date(),
	  changeMonth: true,
	  changeYear: true,
      onClose: function(selectedDate) {
        $("#checkout").focus();
      }
    });
 $("#checkout").datepicker({
	  beforeShow : function(){ 
			$( this ).datepicker('option','minDate', $('#checkin').val() );
	  },
	  dateFormat: "yy-mm-dd",
	  yearRange: '-3:+3',
     maxDate: new Date(),
      defaultDate: "+1w",
      numberOfMonths: 1,
	  changeMonth: true,
	  changeYear: true,
    });
</script>
