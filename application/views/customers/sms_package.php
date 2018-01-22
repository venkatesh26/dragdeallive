<article class="content items-list-page">
	<div class="bread-crumb-data">
		<?php echo $this->load->view('elements/breadcrumb',array(),true);?>
	</div>
   <div class="white-bg">
      <div class="title-search-block">
         <div class="title-block1">
            <div class="row">
               <div class="col-md-6">
                  <h3 class="title">
                     <i class="fa fa-legal"></i> My Orders
                  </h3>
                  <p class="title-description">&nbsp;</p>
               </div>
            </div>
         </div>
      </div>
      <section class="section">
         <!-- /.row -->
         <div class="row">
            <?php 	foreach($sms_package_list  as $list):?>
            <div class="col-xl-4">
               <div class="card card-primary">
                  <div class="card-header">
                     <div class="header-block">
                        <p class="title" style="color:#fff;"> <i class="fa fa-tag"></i> <?php echo ucwords($list['name']);?> Plan </p>
                     </div>
                  </div>
                  <div class="card-block">
                     <p>Plan Validity Days: <strong><?php echo $list['plan_valid_days'];?> Days </strong></p>
                     <p>Plan Cost: <strong>Rs.<?php echo $list['price'];?></strong> </p>
                     <p>Description: <strong>   <?php echo $list['description'];?></strong> </p>
                  </div>
                  <div class="card-footer" style="height:60px;"> <a href="<?php echo base_url().'customers/buySmsPackage?plan_id='.$list['id'];?>" class="btn btn-primary btn-md pull-right "><i class="glyphicon glyphicon-shopping-cart"></i> BUY NOW !</a>	 </div>
               </div>
            </div>
            <?php endforeach;?>
         </div>
         <!-- /.row -->
      </section>
   </div>
</article>