<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">      		
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-comment"></i>
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
							<li <?php if($this->uri->segment(3)=="" || $this->uri->segment(3)=="index") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/comments','All'); ?></li>
							<li <?php if($this->uri->segment(3)=="active") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/comments/active','Active'); ?></li>	
							<li <?php if($this->uri->segment(3)=="inactive") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/comments/inactive','InActive'); ?></li>
						</ul>
						<?php 
							if($this->session->flashdata('flash_message')){
								echo $this->session->flashdata('flash_message');
							  }
						?>
						<?php
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
								 echo form_open(ADMIN.'/comments/'.$type.'/1');
								 echo form_input(array('name'=>'keyword','class'=> 'span2 m-wrap','id'=>'name'),$keyword);
								 $submit_val = array('name' => 'search_submit', 'class' => 'btn btn-default', 'value' => 'Go!', 'title' => 'Go');
								?>
								<span class="input-group-btn go-search">	
								<?php echo form_submit($submit_val);
								echo ' '.anchor(ADMIN.'/comments/'.$type.'/1/reset', 'Clear' ,array('title'=>'Reset', 'class'=>'btn btn-sm btn-default'));
								?>
								</span>
								<?php echo form_close(); ?>
								</div>
							</div>
						</div>
						<!-- /widget -->
					<?php echo form_open(base_url().ADMIN.'/comments/bulkautions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
					  <div class="widget widget-table action-table">
						<!-- /widget-header -->
						<div class="widget-content">
						  <table class="table table-striped table-bordered" id="rowclick1">
							<thead>
							  <tr>
							  <th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
							  <th><?php $sort_url = base_url().ADMIN.'/comments/'.$type.'/'.$page_num.'/created/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Created'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Created'.$sort_def_img, $sort_att ); }?> </th>
							   <th class="td-actions new-items2"><?php $sort_url = base_url().ADMIN.'/comments/'.$type.'/'.$page_num.'/title/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Title'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Title'.$sort_def_img, $sort_att ); }?> </th>
							  	<th class="td-actions"><?php $sort_url = base_url().ADMIN.'/comments/'.$type.'/'.$page_num.'/name/'.$order;   if($sort_seg == 'name') {  echo anchor($sort_url ,'Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Name'.$sort_def_img, $sort_att ); }?></th>
							    <th><?php $sort_url = base_url().ADMIN.'/comments/'.$type.'/'.$page_num.'/hotel_name/'.$order;   if($sort_seg == 'hotel_name') {  echo anchor($sort_url ,'Advertisment Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Advertisment Name'.$sort_def_img, $sort_att ); }?></th>
								 <th><?php $sort_url = base_url().ADMIN.'/comments/'.$type.'/'.$page_num.'/rating/'.$order;   if($sort_seg == 'rating') {  echo anchor($sort_url ,'Rating'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Rating'.$sort_def_img, $sort_att ); }?></th>
								<th class="td-actions new-items2">Status</th>
								<th class="td-actions new-items2">Actions</th>
							  </tr>
							</thead>
							<tbody>
							<?php 
							if(count($comments)) {
								foreach($comments as $vals) { $i++; 
							?>
							  <tr class="check-select">
							  	<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$vals['id']); ?></td>
							  	<td> <?php echo timespan(strtotime($vals['created']),time()); ?> </td>
								<td> <?php echo $vals['title']; ?> </td>
								<td> <?php echo ucfirst($vals['first_name']); ?> </td>
								<td> <?php echo ucfirst($vals['hotel_name']); ?> </td>
								<td> <?php echo ucfirst($vals['rating']); ?> </td>
							   <td class="td-actions">
								<?php
								if($vals['is_active']==1) {
								echo anchor(base_url().ADMIN.'/comments_enable/disable/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-ok"> </i>',array('class'=>'btn btn-small btn-success','title'=>'Active'));
								} 
								else { 
								echo anchor(base_url().ADMIN.'/comments_enable/enable/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-remove"> </i>',array('class'=>'btn btn-danger btn-small','title'=>'Inactive'));
								?>
								<?php } ?></td>
								<td class="td-actions">
								<?php 
								echo anchor(base_url().ADMIN.'/comment_view/view/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-list-alt"> </i>',array('class'=>'btn btn-big','title'=>'View'));
								echo anchor(base_url().ADMIN.'/comment_delete/delete/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-trash"> </i>',array('class'=>'btn btn-big delete-con','title'=>'Delete'));
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
					 	<div class="multi-actions">
								<?php
								echo form_dropdown('more_action_id',$this->config->item('bulkactions'),$this->input->post('offer_type'),'id="MoreActionId" class="span2 js-more-action"'); 
								?>
							</div>
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