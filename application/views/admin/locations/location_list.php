<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); 
$getcities= $this->config->item('base_url').ADMIN.'/getcities';
$getcountries= $this->config->item('base_url').ADMIN.'/getcountries';
$getstates= $this->config->item('base_url').ADMIN.'/getstates';
if(! isset($country_filter )){
$country_filter = $this->input->post('country_filter');
}else{

}
if(!isset($state_filter)){
$state_filter="";
}

if(!isset($city_filter)){
$city_filter="";
}
?>
<script type="text/javascript">
var availableCityTags = "<?php echo $getcities ;?>";
var availablecountryTags = "<?php echo $getcountries ;?>";
var availableStateTags = "<?php echo $getstates ;?>";
var search_state_id="<?php echo $state_filter;?>";	
var search_city_id="<?php echo $city_filter;?>";	
</script>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">      		
	      		<div class="widget ">
	      			<div class="widget-header">
	      				<i class="icon-flag"></i>
	      				<h3><?php echo $indextitle; ?></h3>
	      				<?php  $mode = $this->uri->segment(2);
						$pagestatus = $this->uri->segment(3) ? $this->uri->segment(3) : 'index';
						$pagingstatus = $this->uri->segment(4) ? $this->uri->segment(4) : '1';
						$fieldssort = $this->uri->segment(5) ? $this->uri->segment(5) : 'id';
						$ordersort = $this->uri->segment(6) ? $this->uri->segment(6) : 'desc';
						?>
						<span class="create_new"><?php echo anchor(base_url().ADMIN.'/'.$mode.'/add?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'Create',array('class'=>'btn btn-suc','title'=>'Create')); ?></span>
	  				</div> <!-- /widget-header -->
					<div class="widget-content">
						<ul class="nav nav-tabs">
							<li <?php if($this->uri->segment(3)=="" || $this->uri->segment(3)=="index") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/'.$mode,'All'); ?></li>
							<li <?php if($this->uri->segment(3)=="active") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/'.$mode.'/active','Active'); ?></li>	
							<li <?php if($this->uri->segment(3)=="inactive") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/'.$mode.'/inactive','Inactive'); ?></li>
							<?php if($mode=="cities") { ?>
							<li <?php if($this->uri->segment(3)=="featured") { ?>class="active" <?php } ?>><?php echo anchor(base_url().ADMIN.'/'.$mode.'/featured','Featured'); ?></li><?php } ?>
						</ul>
						<?php 
							if($this->session->flashdata('flash_message')){
								echo $this->session->flashdata('flash_message');
							  } //echo $advanced_search;
						 	if(isset($advanced_search) && $advanced_search==true) {
								$advanced_searchs="";
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
								$sort_img= img('assets/img/admin/sort_desc.png');
							else
								$sort_img = img('assets/img/admin/sort_asc.png');
								
							$sort_att = array('class'=>'sorting');
							$sort_def_img = img('assets/img/admin/sort_both.png');
							 echo form_open('/'.ADMIN.'/'.$mode.'/'.$type.'/1');
						?>
						<div  id="module-search" class="pull-right">
							<div class="quick-search-containers">
								<div class="input-group input-group-sm">
									<?php  //$keyword="";
										 if($mode=="states" ){ 
											echo form_dropdown('search_country',array(''=>'Select Country')+$countries,$this->input->post('search_country') ? $this->input->post('search_country') : $search_country,'id="search_country" class="span3"')." ";
										}
									 echo form_input(array('name'=>'keyword','class'=> 'span2 m-wrap','id'=>'name'),$keyword);
									 $submit_val = array('name' => 'submit-search', 'class' => 'btn btn-default', 'value' => 'Go!', 'title' => 'Go');
									?>
									<span class="input-group-btn go-search">	
									<?php echo form_submit($submit_val);
									echo ' '.anchor(ADMIN.'/'. $mode.'/'.$type.'/1/reset', 'Clear' ,array('title'=>'Clear', 'class'=>'btn btn-sm btn-default'));
									?>
									</span>
									
								</div>
							</div>
							<?php if($mode!="countries" && $mode!="states"){ ?>
							<small class="pull-right"><a href="#" class="advanced-search-toggle<?php echo $mode;?>">+ Advanced Search</a></small>
							<?php } ?>
						</div>

						<div class="clearfix"></div>
						<?php if($mode!="countries" && $mode!="states"){ ?>
						<div class="advenced_search_container row" id="advenced_search_container" <?php echo isset($advanced_searchs) ? '' : 'style="display:none"'; ?>>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="title">Name</label>
										<?php echo form_input(array('name'=>'name','class'=> 'span3 m-wrap','placeholder'=>'Name'),$name); ?>
									</div>	
								</div>
									
								<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="price">Select Country </label>
										<?php  echo form_dropdown('country_filter',array(''=>'Select Country')+$countries,$country_filter,"id='country_filter' class='span3'"); 
										?>
									</div>	
								</div>
								<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="price">Select State </label>
										<?php echo form_dropdown('state_filter',array(''=>'Select State'),$this->input->post('state_filter'),'id="state_filter" class="span3"'); ?>
									</div>	
								</div>
								<?php if($mode=="areas"){ ?>
								<div class="col-md-3 col-sm-4">
									<div class="form-group form-group-advenced-search">
										<label class="control-label" for="price">Select City</label>
										<?php echo form_dropdown('city_filter',array(''=>'Select City'),$this->input->post('city_filter'),'id="city_filter" class="span3"'); ?>
									</div>	
								</div>
							   <?php } ?>
								<div class="clearfix"></div>
								<div class="advance-btn">
								<?php 
								 $data_submit = array('name' => 'submit-advanced-search', 'class' => 'btn btn-sm btn-primary', 'value' => 'Submit', 'title' => 'Submit');
								echo form_submit($data_submit).' | ';
								echo anchor(ADMIN.'/'.$mode.'/'.$type.'/1/reset', 'Clear' ,array('title'=>'Clear', 'class'=>'btn btn-sm btn-default'));
								?>
								</div>
							</div>
						</div>
								<?php  }
								echo form_close();
								?>
								
						<!-- /widget -->
					<?php echo form_open(base_url().ADMIN.'/'.$mode.'/bulkautions/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort); ?>
					  <div class="widget widget-table action-table">
						<!-- /widget-header -->
						<div class="widget-content">
						  <table class="table table-striped table-bordered" id="rowclick1">
							<thead>
							  <tr>
								<th><?php echo form_checkbox(array('id'=>'selecctall','name'=>'selecctall')); ?></th>
								<?php if($mode == 'states') { ?>
								<th><?php $sort_url = base_url().ADMIN.'/states/'.$type.'/'.$page_num.'/name/'.$order;   if($sort_seg == 'name') {  echo anchor($sort_url ,'State/County Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'State/County Name'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/states/'.$type.'/'.$page_num.'/countries_name/'.$order;   if($sort_seg == 'countries_name') {  echo anchor($sort_url ,'Country'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Country'.$sort_def_img, $sort_att ); }?></th>
								<?php }elseif($mode == 'cities') { ?>
								<th><?php $sort_url = base_url().ADMIN.'/cities/'.$type.'/'.$page_num.'/name/'.$order;   if($sort_seg == 'name') {  echo anchor($sort_url ,'City Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'City Name'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/cities/'.$type.'/'.$page_num.'/states_name/'.$order;   if($sort_seg == 'states_name') {  echo anchor($sort_url ,'State'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'State'.$sort_def_img, $sort_att ); }?> </th>
								<th> <?php $sort_url = base_url().ADMIN.'/cities/'.$type.'/'.$page_num.'/countries_name/'.$order;   if($sort_seg == 'countries_name') {  echo anchor($sort_url ,'Country'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Country'.$sort_def_img, $sort_att ); }?></th>
								<?php }elseif($mode == 'areas') { ?>
								<th><?php $sort_url = base_url().ADMIN.'/areas/'.$type.'/'.$page_num.'/name/'.$order;   if($sort_seg == 'name') {  echo anchor($sort_url ,'Area Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Area Name'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/areas/'.$type.'/'.$page_num.'/cities_name/'.$order;   if($sort_seg == 'cities_name') {  echo anchor($sort_url ,'City'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'City'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/areas/'.$type.'/'.$page_num.'/states_name/'.$order;   if($sort_seg == 'states_name') {  echo anchor($sort_url ,'State'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'State'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/areas/'.$type.'/'.$page_num.'/countries_name/'.$order;   if($sort_seg == 'countries_name') {  echo anchor($sort_url ,'Country'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Country'.$sort_def_img, $sort_att ); }?></th>
								<?php }else { ?>
								<th><?php $sort_url = base_url().ADMIN.'/countries/'.$type.'/'.$page_num.'/name/'.$order;   if($sort_seg == 'name') {  echo anchor($sort_url ,'Country Name'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Country Name'.$sort_def_img, $sort_att ); }?></th>
								<th><?php $sort_url = base_url().ADMIN.'/countries/'.$type.'/'.$page_num.'/code/'.$order;   if($sort_seg == 'code') {  echo anchor($sort_url ,'Country Code'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Country Code'.$sort_def_img, $sort_att ); }?></th>
								<?php } ?>
								<!--<th class="create-wt"><?php //$sort_url = base_url().ADMIN.'/'.$mode.'/'.$type.'/'.$page_num.'/created/'.$order;   if($sort_seg == 'created') {  echo anchor($sort_url ,'Created'.$sort_img, $sort_att );  } else { echo anchor($sort_url,'Created'.$sort_def_img, $sort_att ); }?></th>-->
								<th class="td-actions">Status </th>
								<?php if($mode == 'cities') { ?>
								<th class="td-actions">Footer City </th>
								<?php } ?>
								<th class="td-actions new-items2">Actions </th>
							  </tr>
							</thead>
							<tbody>
							<?php 
							if(count($location_list)) {
								foreach($location_list as $vals) { $i++; 
							?>
							  <tr class="check-select">
								<td><?php echo form_checkbox(array('name'=>'checkall_box[]','class'=>'js-checkbox-all'),$vals['id']); ?></td>
								<?php if($mode == 'states') { ?>
									<td> <?php echo ucfirst($vals['s_name']); ?> </td>
									<td> <?php echo ucfirst($vals['c_name']); ?> </td>
								<?php }elseif($mode == 'cities') { ?>
									<td> <?php echo ucfirst($vals['cs_name']); ?> </td>
									<td> <?php echo ucfirst($vals['s_name']); ?> </td>
									<td> <?php echo ucfirst($vals['c_name']); ?> </td>
								<?php }elseif($mode == 'areas') { ?>
									<td> <?php echo ucfirst($vals['a_name']); ?> </td>
									<td> <?php echo ucfirst($vals['cs_name']); ?> </td>
									<td> <?php echo ucfirst($vals['s_name']); ?> </td>
									<td> <?php echo ucfirst($vals['c_name']); ?> </td>
								<?php }else{ ?>
									<td> <?php echo ucfirst($vals['name']); ?> </td>
									<td> <?php echo $vals['code']; ?> </td>
								<?php } ?>
								<!--<td> <?php //echo timespan(strtotime($vals['created']),time()); ?> </td>-->
								<td class="td-actions">
								<?php if($vals['is_active']==1) {
								echo anchor(base_url().ADMIN.'/'.$mode.'/disable/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-ok"> </i>',array('class'=>'btn btn-small btn-success','title'=>'Active'));
								} else { 
								echo anchor(base_url().ADMIN.'/'.$mode.'/enable/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-remove"> </i>',array('class'=>'btn btn-danger btn-small','title'=>'Inactive'));
								?>
								<?php } ?>
								<?php if($mode == 'cities') { ?>
								<td class="td-actions">
								<?php if($vals['featured_city']==1) {
								echo anchor(base_url().ADMIN.'/'.$mode.'/en_featured/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-ok"> </i>',array('class'=>'btn btn-small btn-success js-alertsuccess','title'=>'Featured'));
								} else { 
								echo anchor(base_url().ADMIN.'/'.$mode.'/en_unfeatured/'.$vals['id'].'/'.$pagestatus.'/'.$pagingstatus.'?sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-remove"> </i>',array('class'=>'btn btn-danger btn-small js-alertdanger','title'=>'UnFeatured'));
								?>
								<?php } ?>
								</td>
								<?php } ?>
								
								<td class="td-actions nw-td-actions">
								<?php 
								if($mode == 'cities') 
								{
								echo anchor(base_url().ADMIN.'/city_view/view/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-list-alt"> </i>',array('class'=>'btn btn-big','title'=>'View'));
								}
								echo anchor(base_url().ADMIN.'/'.$mode.'/edit/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-edit"> </i>',array('class'=>'btn btn-big','title'=>'Edit'));
								echo anchor(base_url().ADMIN.'/'.$mode.'/delete/'.$vals['id'].'?pagemode='.$pagestatus.'&modestatus='.$pagingstatus.'&sortingfied='.$fieldssort.'&sortype='.$ordersort,'<i class="btn-icon-only icon-trash"> </i>',array('class'=>'btn btn-big delete-con','title'=>'Delete'));
								?>
								</td>
							  </tr>
							<?php }
							} else { ?>
							<tr>
							<th colspan="8" class="norecordfound">No Record Found</th>
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
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
	      	</div> <!-- /span8 -->
	      </div> <!-- /row -->
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->
