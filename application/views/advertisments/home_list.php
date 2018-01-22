<div class="td-pb-span8 td-main-content">
<div class="td-ss-main-content"><div class="clearfix"></div>
  <h4 class=block-title><span>Latest Business List</span></h4>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- dragdeal View Page -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="3928158140"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
        <?php foreach($home_add_listing as $item): $link=base_url(). 'business'. '/'.$item[ 'id']. '/'.url_title(strtolower($item[ 'name'])). '/'.url_title(strtolower($item[ 'city_name'])); $title=ucwords($item[ 'name']); if($item[ 'city_name']!='' ){ $title=$title. " ,".$item[ 'city_name'];} $contact_number="Not Available" ; if(isset($item[ 'contact_number']) && $item[ 'contact_number']!='' ){ $contact_number=$item[ 'contact_number']; } $image=base_url().'assets/themes/images/281-218x150.png';
        $image=base_url().'assets/themes/images/list_logo.png';
		$no_image=true;
		if(!empty($item['profile_image']) && file_exists('./'.$item['image_dir'].$item['profile_image']))
		{
		   $img_src = thumb(FCPATH.$item['image_dir'].$item['profile_image'],'218','159','list_thumb');
		   $image = base_url().$item['image_dir'].'list_thumb/'.$img_src;
		   $no_image=false;
		}
		$my_adress=$item[ 'address_line']; if($item[ 'address_line']!='' ) { if($item[ 'area_name']!='' && $item[ 'city_name']!='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'address_line']). ','.ucwords($item[ 'area_name']). ','.ucwords($item[ 'city_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']=='' && $item[ 'city_name']!='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'address_line']). ','.ucwords($item[ 'city_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']!='' && $item[ 'city_name']=='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'address_line']). ','.ucwords($item[ 'area_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']!='' && $item[ 'city_name']=='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'address_line']). ','.ucwords($item[ 'area_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']=='' && $item[ 'city_name']=='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'address_line']). ','.ucwords($item[ 'area_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']!='' && $item[ 'city_name']!='' ) { $my_adress=ucwords($item[ 'address_line']). ','.ucwords($item[ 'area_name']). ','.ucwords($item[ 'city_name']); } } else { if($item[ 'area_name']!='' && $item[ 'city_name']!='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'area_name']). ','.ucwords($item[ 'city_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']=='' && $item[ 'city_name']!='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'city_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']!='' && $item[ 'city_name']=='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'area_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']!='' && $item[ 'city_name']=='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'area_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']=='' && $item[ 'city_name']=='' && ($item[ 'zip']!='' && $item[ 'zip']!=0)) { $my_adress=ucwords($item[ 'area_name']). '-'.$item[ 'zip']; } else if($item[ 'area_name']!='' && $item[ 'city_name']!='' ) { $my_adress=ucwords($item[ 'area_name']). ','.ucwords($item[ 'city_name']); } } ?>
		
<div class="td-visible-desktop td_module_10 td_module_wrap td-animation-stack home-page-list">
	<div class="td-module-thumb">
		<a title="<?php echo ucwords($item['name']);?>" rel="bookmark" href="<?php echo $link;?>">
		<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($item['name'][0]));?>"><?php echo strtoupper($item['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		<img width="218" height="150" title="<?php echo ucwords($item['name']);?>" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">	
		<?php } ?>
		
		</a>
	</div>
	<div class="item-details">
	<h3 class="entry-title td-module-title"><a title="<?php echo ucwords($item['name']);?>" rel="bookmark" href="<?php echo $link;?>"><?php echo ucwords($item['name']);?><?php echo " ,".ucwords($item['city_name']);?></a></h3>
	<div class="td-module-meta-info">
		<a class="td-post-category td-post-category-new-background" href="<?php echo $link;?>">  <i class="fa fa-map-marker"></i> <?php echo ucwords($item['city_name']);?></a> 
		<span class="td-post-author-name"><a href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($item['owner']);?></a> </span>
		<div class="td-module-comments td-post-category-new-background"><a href="<?php echo $link;?>"><?php echo $item['total_user_rated'];?></a></div> 
	</div>
	<div class="td-module-meta-info">
		<span class="td-post-author-name"><a href="<?php echo $link;?>"><i class="fa fa-phone"></i>  <?php echo $contact_number;?></a> <span></span> </span>
	</div>
	<div class="td-module-meta-info">
		<span class="td-post-author-name td-post-address"><a href="<?php echo $link;?>"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></a> <span></span> </span>
	</div>
<div class="td-review-final-star">
<?php $totalScore=($item['site_score'] + $item['overall_score'] + $item['rating']) / 3;?>
<?php 
					for($i=$totalScore;$i>=1;$i--):
					echo "<i class='fa fa-star'></i>";
					endfor;
					for($i=5-$totalScore;$i>=1;$i--):
					echo "<i class='fa fa-star-o'></i>";
					endfor;
				?>

					</div>
	</div>
</div>

	<div class="td-visible-phone home-list-section">
			<div class="author-box-wrap">
			<div class="td-module-thumb"><a title="<?php echo ucwords($item['name']);?>" rel="bookmark" href="<?php echo $link;?>">
			<?php 
		if($no_image){?>
				<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($item['name'][0]));?>"><?php echo strtoupper($item['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		<img width="218" height="150" title="<?php echo ucwords($item['name']);?>" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">	
		<?php } ?>
		
			</a>
			</div>
			<div class="desc">
			<div class="td-author-name vcard author homelist-phone-title"><span class="fn"><a href="<?php echo $link;?>"><?php echo ucwords(htmlentities(nl2br($item['name'])));?></a></span>
			</div>
			<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo $link;?>"><i class="fa fa-map-marker"></i> <?php echo ucwords(htmlentities(nl2br($item['city_name'])));?></a></span>
			</div>
			<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($item['owner']);?></a></span>
			</div>
			<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo $link;?>"><i class="fa fa-phone"></i> <?php echo $contact_number;?></a></span>
			</div>
			<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo $link;?>"><i class="fa fa-clock-o"></i> <?php echo $item['working_start'];?> to <?php echo $item['working_end'];?></a></span>
			</div>
			<?php if(trim($item['email'])!='' && $item['email']!='Null'):?>
			<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo base_url();?>home/enquiry?token=<?php echo $item['id'];?>"><i class="fa fa-envelope-o"></i>  Send Enquiry By Email</a></span>
			</div>
			<?php endif;?>
			<?php if($item['website']!=''):?>
			<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo $item['website'];?>" target="_blank"><i class="fa fa-globe"></i>  <?php echo $item['website'];?></a></span>
			</div>
			<?php endif;?>	
			<div class="clearfix"></div>
			</div>
			</div> 							
	</div>
	
	<div class="td_module_10 td_module_wrap td-animation-stack detail-page-sect td-visible-tablet-landscape">
		<div class="td-module-thumb"><a title="<?php echo ucwords($item['name']);?>" rel="bookmark"  href="<?php echo $link;?>">
		<?php 
		if($no_image){?>
					<div class="custom_image">
    <p class="image_class_<?php echo strtoupper(trim($item['name'][0]));?>"><?php echo strtoupper($item['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		<img width="218" height="150" title="<?php echo ucwords($item['name']);?>" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">	
		<?php } ?>
		
		
		
		</a></div><div class="item-details"><h3 class="entry-title td-module-title">
		
		<a title="<?php echo ucwords($item['name']);?>" rel="bookmark"  href="<?php echo $link;?>"><?php echo ucwords($item['name']);?>,<?php echo ucwords($item['city_name']);?></a></h3><div class="td-module-meta-info"><a class="td-post-category  td-post-category-background"  href="<?php echo $link;?>"> <?php echo ucwords($item['city_name']);?></a> <span class="td-post-author-name"><a  href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($item['owner']);?></a> </span><div class="td-module-comments"><a  href="<?php echo $link;?>"><?php echo $item['total_user_rated'];?></a></div> </div><div class="td-module-meta-info"><span class="td-post-author-name"><a href="#"><i class="fa fa-phone"></i> <?php echo $contact_number;?></a> <span></span> </span></div><div class="td-module-meta-info"><span class="td-post-author-name"><a  href="<?php echo $link;?>"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></a> <span></span> </span></div>
		<div class="td-module-meta-info"><span class="td-post-author-name"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $item['working_start'];?> to <?php echo $item['working_end'];?> </a> <span></span> </span>
		</div>
		</div>
	</div>
	
	<div class="td_module_10 td_module_wrap td-animation-stack td-visible-tablet-portrait">
			<div class="td-module-thumb"><a title="<?php echo ucwords($item['name']);?>" rel="bookmark"  href="<?php echo $link;?>">
			<?php 
		if($no_image){?>
				<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($item['name'][0]));?>"><?php echo strtoupper($item['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		<img width="218" height="150" title="<?php echo ucwords($item['name']);?>" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">	
		<?php } ?>
		
			
			
			</a></div>
			<div class="item-details">
				<h3 class="entry-title td-module-title">
				<a title="<?php echo ucwords($item['name']);?>" rel="bookmark"  href="<?php echo $link;?>"><?php echo ucwords($item['name']);?>,<?php echo ucwords($item['city_name']);?></a></h3>
				
				<div class="td-module-meta-info">
				<a class="td-post-category  td-post-category-background"  href="<?php echo $link;?>"> <?php echo ucwords($item['city_name']);?></a> 
				
					<div class="td-module-comments"><a  href="<?php echo $link;?>"><?php echo $item['total_user_rated'];?></a></div> 
				</div>
				<div class="td-module-meta-info">
				<span class="td-post-author-name1"><a  href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($item['owner']);?></a> </span>
				</div>
				<div class="td-module-meta-info">
				<span class="td-post-author-name1"><i class="fa fa-phone"></i> <?php echo $contact_number;?><span></span> </span>
				</div>
				<div class="td-module-meta-info">
				<span class="td-post-author-name1"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></span>
				</div>
				<div class="td-module-meta-info">
				<span class="td-post-author-name1"><i class="fa fa-clock-o"></i> <?php echo $item['working_start'];?> to <?php echo $item['working_end'];?> <span></span></span>
				</div>
			</div>
	</div>
<?php endforeach;?>
</div>
</div>