<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">      		
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-time"></i>
	      				<h3><?php echo $indextitle; ?></h3>
						<?php 
						$pagestatus = $this->uri->segment(3) ? $this->uri->segment(3) : 'index';
						$pagingstatus = $this->uri->segment(4) ? $this->uri->segment(4) : '1';
						$fieldssort = $this->uri->segment(5) ? $this->uri->segment(5) : 'id';
						$ordersort = $this->uri->segment(6) ? $this->uri->segment(6) : 'desc';
						?>
	  				</div>
					<div class="widget-content">
						<ul class="nav nav-tabs">
							<li <?php 
							if($type=="index") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/customer_remainders/'.$remainder_type,'All'); ?></li>
							<li <?php if($type=="active") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/customer_remainders/'.$remainder_type.'/active','Active'); ?></li>	
							<li <?php if($type=="inactive") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/customer_remainders/'.$remainder_type.'/inactive','InActive'); ?></li>
						</ul>
						<?php 
						 if($this->session->flashdata('flash_message')){
								echo $this->session->flashdata('flash_message');
					     }
						 $page_num = (int)$this->uri->segment(4);
						 if($page_num==0) { $page_num=1; }
							$i = ($page_num -1 ) * $per_page; 
							$order_seg = $this->uri->segment(6,"asc"); 
						 if($order_seg == "asc") $order = "desc"; else $order = "asc";
							$sort_seg = $this->uri->segment(5);
							if($order == 'asc')
								$sort_img= img('assets/img/admin/sort_desc.png');
							else
								$sort_img = img('assets/img/admin/sort_asc.png');
								
							$sort_att = array('class'=>'sorting');
							$sort_def_img = img('assets/img/admin/sort_both.png');
						?>
						<div id="module-search" class="pull-right col-md-4">
							<div class="quick-search-container">
								<div class="input-group input-group-sm">
								<?php 
								 echo form_open(ADMIN.'/customer_remainders/'.$remainder_type.'/'.$type.'/1');
								 echo form_input(array('name'=>'keyword','class'=> 'span2 m-wrap','id'=>'name'),$keyword);
								 $submit_val = array('name' => 'search_submit', 'class' => 'btn btn-default', 'value' => 'Go!', 'title' => 'Go');
								?>
								<span class="input-group-btn go-search">	
								<?php echo form_submit($submit_val);
								echo ' '.anchor(ADMIN.'/customer_remainders/'.$remainder_type.'/'.$type.'/1/reset', 'Clear' ,array('title'=>'Reset', 'class'=>'btn btn-sm btn-default'));
								?>
								</span>
								<?php echo form_close(); ?>
								</div>
							</div>
						</div>
						<!-- /widget -->
					<?php echo form_open(base_url().ADMIN.'/customer_remainders/bulkautions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
					  <div class="widget widget-table action-table">
						<!-- /widget-header -->
						<div class="widget-content">
						  <table class="table table-striped table-bordered" id="rowclick1">
							<thead>
							  <tr>
							  <th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
							  <th><?php $sort_url = base_url().ADMIN.'/customer_remainders/'.$type.'/'.$page_num.'/created/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Created'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Created'.$sort_def_img, $sort_att ); }?> </th>
							   <th class="td-actions new-items2"><?php $sort_url = base_url().ADMIN.'/customer_remainders/'.$type.'/'.$page_num.'/title/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Title'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Title'.$sort_def_img, $sort_att ); }?> </th>
								<th class="td-actions new-items2">Contact Number</th>
								<th class="td-actions new-items2">Email</th>
								<th class="td-actions new-items2">Status</th>
								<th class="td-actions new-items2">Actions</th>
							  </tr>
							</thead>
							<tbody>
							<?php 
							if(count($remainders)) {
								foreach($remainders as $vals) { $i++; 
							?>
							  <tr class="check-select">
							  	<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$vals['id']); ?></td>
							  	<td> <?php echo timespan(strtotime($vals['created']),time()); ?> </td>
								<td> <?php echo $vals['name']; ?> </td>
								<td> <?php echo ucfirst($vals['contact_number']); ?> </td>
								<td> <?php echo ucfirst($vals['email']); ?> </td>
					
								<td class="td-actions">
								<?php
								if($vals['is_active']==1) {
								echo anchor(base_url().ADMIN.'/customer_remainders_enable/disable/'.$remainder_type.'/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-ok"> </i>',array('class'=>'btn btn-small btn-success','title'=>'Active'));
								} 
								else { 
								echo anchor(base_url().ADMIN.'/customer_remainders_enable/enable/'.$remainder_type.'/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-remove"> </i>',array('class'=>'btn btn-danger btn-small','title'=>'Inactive'));
								?>
								<?php } ?></td>
								<td class="td-actions">
								<?php 
								echo anchor(base_url().ADMIN.'/customer_remainder/view/'.$this->uri->segment(3).'/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-list-alt"> </i>',array('class'=>'btn btn-big','title'=>'View'));
								echo anchor(base_url().ADMIN.'/customer_remainders/delete/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-trash"> </i>',array('class'=>'btn btn-big delete-con','title'=>'Delete'));
								?>
								</td>
							  </tr>
							<?php }
							} else { ?>
							<tr>
							<th colspan="8" class="norecordfound">No Records found.</th>
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
					<?php echo form_close(); ?>
					</div>
				</div>
	      	</div>
	      </div>
	    </div>
	</div>
</div>