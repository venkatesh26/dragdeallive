<?php if( ! defined('BASEPATH')) exit('Direct Access not Allowed'); ?>
<div class="main">
	<div class="main-inner">
	    <div class="container">
	      <div class="row">
	      	<div class="span12">
	      		<div class="widget">
					<div class="widget-header">
						<i class="icon-book"></i>
						<h3>Plan Types</h3>
					</div> <!-- /widget-header -->
					<div class="widget-content">
						<div class="pricing-plans plans-3">
						<div style="float:left;margin-bottom:20px;width:100%;"><?php 
					if($this->session->flashdata('flash_message')){
						echo $this->session->flashdata('flash_message');
					  }
					?></div>
						<?php 
						if(count($plans)) {
							$i=1;
							foreach($plans as $vals) {
							$color = ($i%2) ? '' : 'green';
							$color = ($i%3) ? $color : 'yellow';
						?>
						<div class="plan-container">
					        <div class="plan <?php echo $color; ?>">
						        <div class="plan-header">
						        	<div class="plan-title">
						        		<?php echo $vals['name']; ?>        		
					        		</div> <!-- /plan-title -->
						            <div class="plan-price">
					                	&#8364;<?php echo round($vals['price'],2); ?><span class="term">For <?php echo $vals['plan_valid_days'].' Days'; ?></span>
									</div> <!-- /plan-price -->
						        </div> <!-- /plan-header -->	        
						        <div class="plan-features">
									<ul>
										<li>Percentage from each hotel Booking <strong> <?php echo $vals['commision'].'%'; ?></strong> </li>
										<li>Number of Auctions <strong><br> <?php echo $vals['auction_limit']; ?></strong></li>
										<li>Featured Home Page Hotel Listing <br><?php if($vals['featured_home_page']==1) { echo "<strong>Yes</strong>"; } else { echo "<strong>No</strong>"; } ?></li>
									</ul>
								</div> <!-- /plan-features -->
								
								<div class="plan-actions">				
									<?php echo anchor(base_url().ADMIN.'/plans/edit/'.$vals['id'],'Edit',array('class'=>'btn','title'=>'Edit')); ?>		
								</div> <!-- /plan-actions -->
					
							</div> <!-- /plan -->
					    </div> <!-- /plan-container -->
						<?php $i++; } } else { ?>
						<div>No Record Found</div>
						<?php } ?>
						
					</div> <!-- /pricing-plans -->
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
		    </div> <!-- /span12 -->
	      </div> <!-- /row -->
	    </div> <!-- /container -->
	</div> <!-- /main-inner -->
</div> <!-- /main -->
