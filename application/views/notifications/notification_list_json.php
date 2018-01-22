	<div class="message-wrap col-md-12">
		<div class="msg-wrap">
		 <?php foreach($order_list as $list):?>
			<div class="media msg ">
				<a class="pull-left" href="#">
					<img class="media-object    img-circle" style="width: 32px; height: 32px;" src="https://bootdey.com/img/Content/user_2.jpg">
				</a>
				<div class="media-body">
					<small class="pull-right time"><i class="fa fa-clock-o"></i> <?php echo date('d-F-Y',strtotime($list['created']));?></small>
					<h5 class="media-heading"> <?php echo $list['title'];?> </h5>
					<small class="col-md-10 text-muted"><?php echo $list['message'];?></small>
				</div>
			</div>
		<?php endforeach;?>
		</div>
	</div>    
      
  <?php if(count($order_list) <=0){?>
	<li class="item"> 	   
	   <div class="item-row">
		   <div class="item-col item-col-category">
			  <div class="no-overflow no_list_found">   No List Found</div>
		   </div>
	   </div>
	</li>
  <?php }?> 