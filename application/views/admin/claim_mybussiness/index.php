<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">      		
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-credit-card"></i>
	      				<h3><?php echo $indextitle; ?></h3>
						<?php 
						$pagestatus = $this->uri->segment(3) ? $this->uri->segment(3) : 'index';
						$pagingstatus = $this->uri->segment(4) ? $this->uri->segment(4) : '1';
						$fieldssort = $this->uri->segment(5) ? $this->uri->segment(5) : 'id';
						$ordersort = $this->uri->segment(6) ? $this->uri->segment(6) : 'desc';
						?>
	  				</div>
					<div class="widget-content">
						<?php 
							if($this->session->flashdata('flash_message')){
								echo $this->session->flashdata('flash_message');
							  }
						?>
						<?php
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
						?>
						<div id="module-search" class="pull-right col-md-4">
							<div class="quick-search-container">
								<div class="input-group input-group-sm">
								<?php 
								 echo form_open(ADMIN.'/claim_my_bussiness/1');
								 echo form_input(array('name'=>'keyword','class'=> 'span2 m-wrap','id'=>'name'),$keyword);
								 $submit_val = array('name' => 'search_submit', 'class' => 'btn btn-default', 'value' => 'Go!', 'title' => 'Go');
								?>
								<span class="input-group-btn go-search">	
								<?php echo form_submit($submit_val);
								echo ' '.anchor(ADMIN.'/claim_my_bussiness/reset', 'Clear' ,array('title'=>'Clear', 'class'=>'btn btn-sm btn-default'));
								?>
								</span>
								<?php
								echo form_close();
								?>
								</div>
							</div>
						</div>
						<!-- /widget -->
					  <div class="widget widget-table action-table">
						
						<!-- /widget-header -->
						<div class="widget-content">
						  <table class="table table-striped table-bordered">
							<thead>
							  <tr>
								<th>S.no</th>
							
								<th class="create-wt"><?php $sort_url = base_url().ADMIN.'/claim_my_bussiness/'.$page_num.'/created/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Created'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Created'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/claim_my_bussiness/'.$page_num.'/name/'.$order;   if($sort_seg == 'name') {  echo anchor($sort_url ,'Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Name'.$sort_def_img, $sort_att ); }?></th>
								<th class="create-wt"><?php $sort_url = base_url().ADMIN.'/claim_my_bussiness/'.$page_num.'/email/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Email'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Email'.$sort_def_img, $sort_att ); }?></th>
								<th class="create-wt"><?php $sort_url = base_url().ADMIN.'/claim_my_bussiness/'.$page_num.'/contact_number/'.$order;   if($sort_seg == 'contact_number') {  echo anchor($sort_url ,'Contact Number'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Contact Number'.$sort_def_img, $sort_att ); }?></th>
								<th class="create-wt"><?php $sort_url = base_url().ADMIN.'/claim_my_bussiness/'.$page_num.'/contact_number/'.$order;   if($sort_seg == 'contact_number') {  echo anchor($sort_url ,'Contact Number'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'IS Resolved'.$sort_def_img, $sort_att ); }?></th>
								<th class="td-actions">Actions </th>
							  </tr>
							</thead>
							<tbody>
							<?php 
							if(count($contactus)) {
								foreach($contactus as $vals) { $i++; 
							?>
							  <tr>
								<td> <?php echo $i; ?> </td>
								<td> <?php echo timespan(strtotime($vals['created']),time()); ?> </td>
								<td> <?php echo ucfirst($vals['name']); ?> </td>
								<td> <?php echo ucfirst($vals['email']); ?> </td>
								<td> <?php echo ucfirst($vals['contact_number']); ?> </td>
								<td>
								<?php
								if($vals['is_resolved']==1) {
								echo '<a href="javasscript:void(0)" class="btn btn-success btn-small"><i class="btn-icon-only icon-ok"> </i></a>';
								} 	
								else { 
									echo '<a href="javasscript:void(0)" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>';
								}
								?>
								</td>
								<td class="td-actions">
								<?php 
								echo anchor(base_url().ADMIN.'/claim_my_bussiness/view/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-delete"> </i>',array('class'=>'btn-icon-only icon-list-alt','title'=>'View'));
								echo anchor(base_url().ADMIN.'/claim_my_bussiness/delete/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-delete"> </i>',array('class'=>'btn-icon-only icon-trash','title'=>'Delete'));
								?>
								</td>
							  </tr>
							<?php }
							} else { ?>
							<tr>
							<th colspan="9" class="norecordfound">No Record Found</th>
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
							</div>
						<div class="hob-paging"><?php echo '<div class="pagination" style="float:right;">'.$this->pagination->create_links().'</div>'; ?></div>
						</div>
						<!-- /Multi Actions --> 
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
	      	</div> <!-- /span8 -->
	      </div> <!-- /row -->
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->