<div class="td-main-content-wrap">
<div class="td-container td-post-template-2">
    <div class="td-pb-row">
		<div class="td-pb-span12">
			<div class="td-post-header">
			    <br/>
				<?php /************ Bread Crumb *****************/ echo $this->load->view('bread_crumb',array(), TRUE); ?>			  
			</div>
		</div>
    </div>
</div>
<div class="td-container">
<div class="td-pb-row">

<div class="td-pb-span8 td-main-content">
<h3 class="entry-title td-page-title" style="display:block;background-color:#29c065;padding:5px;color:#fff;"><?php echo $search_header_title;?><span class="total-count"><?php 
if($total_count > 0):
echo ' ('.number_format($total_count).')';
endif;
?></h3>
<div class="clearfix"></div>
<div class="clearfix"></div>
						<?php 	
if($this->detect->isMobile()):
?>				
<div class="td-post-sharing">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- newtheme customsize -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="2323491279"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<?php else:?>	
<p class="view_page_section_detail">				
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- new_theme_view_responsive2 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="7132122879"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</p>
<?php endif;?>	
<div class="td-ss-main-content"><div class="clearfix"></div>
<?php
						   if(!empty($list['listings'])){
						   if($related_list==1):?>
						  <div class="clearfix"></div>
							  <div class="entry-title td-page-title" style="color:red;"> Sorry !!! No Results Found for your search term.You may also interested in the following List.. </div>	
						  
						  <?php 
						  endif;
						  foreach($list['listings'] as $result){
						   $contact_number="Not Available";
						   if(isset($result['contact_number']) && $result['contact_number']!='')
						   {
							$contact_number=$result['contact_number'];   
						   }
						   $link=base_url().'business'.'/'.$result['id'].'/'.url_title(strtolower($result['add_name'])).'/'.url_title(strtolower($result['city_name']));
							$no_image=true;
							$image=base_url().'assets/themes/images/281-218x150.png';
							$image=base_url().'assets/themes/images/list_logo.png';
							if(!empty($result['profile_image']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
							{
							   $img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'218','159','list_thumb');
							   $image = base_url().$result['image_dir'].'list_thumb/'.$img_src;$no_image=false;
							}
						   $my_adress=$result['address_line'];
						   if($result['address_line']!='')
						   {
							 if($result['area_name']!='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
							 {
						         $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).','.ucwords($result['city_name']).'-'.$result['zip'];
							 }
							 else if($result['area_name']=='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
							 {
						         $my_adress =ucwords($result['address_line']).','.ucwords($result['city_name']).'-'.$result['zip'];
							 }
							 else if($result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
							 {
						         $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
							 }
							 else if($result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
							 {
						         $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
							 }
							  else if($result['area_name']=='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
							 {
						         $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
							 }
							 else if($result['area_name']!='' && $result['city_name']!='')
							 {
						         $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).','.ucwords($result['city_name']);
							 }
						   }
						   else
						   {
									if($result['area_name']!='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
									 {
										 $my_adress =ucwords($result['area_name']).','.ucwords($result['city_name']).'-'.$result['zip'];
									 }
									 else if($result['area_name']=='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
									 {
										 $my_adress =ucwords($result['city_name']).'-'.$result['zip'];
									 }
									 else if($result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
									 {
										 $my_adress =ucwords($result['area_name']).'-'.$result['zip'];
									 }
									 else if($result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
									 {
										 $my_adress =ucwords($result['area_name']).'-'.$result['zip'];
									 }
									  else if($result['area_name']=='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
									 {
										 $my_adress =ucwords($result['area_name']).'-'.$result['zip'];
									 }
									 else if($result['area_name']!='' && $result['city_name']!='')
							        {
						              $my_adress =ucwords($result['area_name']).','.ucwords($result['city_name']);
							        }  
						   }
						   ?>
<div class="td-visible-desktop td_module_10 td_module_wrap td-animation-stack home-page-list">
<div class="td-module-thumb">
<a title="" rel="bookmark" href="<?php echo $link;?>">

<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($result['add_name'][0]));?>"><?php echo strtoupper($result['add_name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>


</a>
</div>
<div class="item-details">
<h3 class="entry-title td-module-title"><a title="" rel="bookmark" href="<?php echo $link;?>"><?php echo $result['add_name'];?><?php echo " ,".ucwords($result['city_name']);?></a></h3>
<div class="td-module-meta-info">
<a class="td-post-category td-post-category-new-background" href="<?php echo $link;?>">  <i class="fa fa-map-marker"></i> <?php echo ucwords($result['city_name']);?></a> 
<span class="td-post-author-name"><a href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a> </span>
<!--<div class="td-module-comments"><a href="<?php echo $link;?>"><?php echo $result['total_user_rated'];?></a></div> -->
</div>
<!--<div class="td-module-meta-info">
<span class="td-post-author-name"><a href="<?php echo $link;?>"><i class="fa fa-phone"></i>  <?php echo $contact_number;?></a> <span></span> </span>
</div>-->
<div class="td-module-meta-info">
<span class="td-post-author-name td-post-address"><a href="<?php echo $link;?>"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></a> <span></span> </span>
</div>
<div class="td-module-meta-info">
	<span class="td-post-author-name"><a href="<?php echo $link;?>"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?></a> <span></span> </span>
	
	</div>
				<?php 
					$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;?>
					<div class="td-review-final-star">
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
									<div class="td-module-thumb"><a title="<?php echo ucwords($result['add_name']);?>" rel="bookmark" href="<?php echo $link;?>">
										<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($result['add_name'][0]));?>"><?php echo strtoupper($result['add_name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
										</a>
									</div>
								<div class="desc">
								<div class="td-author-name vcard author homelist-phone-title"><span class="fn"><a  href="<?php echo $link;?>"><?php echo ucwords(htmlentities(nl2br($result['add_name'])));?></a></span>
								</div>
								<div class="td-author-name vcard author"><span class="fn"><a  href="<?php echo $link;?>"><i class="fa fa-map-marker"></i> <?php echo ucwords(htmlentities(nl2br($result['city_name'])));?></a></span>
								</div>
								<div class="td-author-name vcard author"><span class="fn"><a  href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a></span>
								</div>
								<!-- <div class="td-author-name vcard author"><span class="fn"><a  href="<?php echo $link;?>"><i class="fa fa-phone"></i> <?php echo $contact_number;?></a></span>
								</div> -->
								<div class="td-author-name vcard author"><span class="fn"><a  href="<?php echo $link;?>"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?></a></span>
								</div>
							<?php 
							$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;?>
							<div class="td-review-final-star">
							<?php 
							for($i=$totalScore;$i>=1;$i--):
							echo "<i class='fa fa-star'></i>";
							endfor;
							for($i=5-$totalScore;$i>=1;$i--):
							echo "<i class='fa fa-star-o'></i>";
							endfor;
							?>
							</div>
								<?php if($result['email']!=''):?>
								<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo base_url();?>home/enquiry?token=<?php echo $result['id'];?>"><i class="fa fa-envelope-o"></i>  Send Enquiry By Email</a></span>
								</div>
								<?php endif;?>
								<?php if($result['website']!=''):?>
								<div class="td-author-name vcard author"><span class="fn"><a href="<?php echo $result['website'];?>" target="_blank"><i class="fa fa-globe"></i>  <?php echo $result['website'];?></a></span>
									</div>
								<?php endif;?>	
								<div class="clearfix"></div>
								</div>
								</div> 							
						</div>
						<div class="td_module_10 td_module_wrap td-animation-stack detail-page-sect td-visible-tablet-landscape home-list-section">
							<div class="td-module-thumb"><a title="<?php echo ucwords($result['add_name']);?>" rel="bookmark"  href="<?php echo $link;?>">
						<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($result['add_name'][0]));?>"><?php echo strtoupper($result['add_name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
							
							</a></div><div class="item-details"><h3 class="entry-title td-module-title">
							
							<a title="<?php echo ucwords($result['add_name']);?>" rel="bookmark"  href="<?php echo $link;?>"><?php echo ucwords($result['add_name']);?>,<?php echo ucwords($result['city_name']);?></a></h3>
							<div class="td-module-meta-info"><a class="td-post-category  td-post-category-background"  href="<?php echo $link;?>"> <?php echo ucwords($result['city_name']);?></a> <span class="td-post-author-name"><a href="#"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a> </span><div class="td-module-comments"><a href="#"><?php echo $result['total_user_rated'];?></a></div> </div>
							
							<!--<div class="td-module-meta-info"><span class="td-post-author-name"><a  href="<?php echo $link;?>"><i class="fa fa-phone"></i> <?php echo $contact_number;?></a> <span></span> </span></div>-->
									<?php 
					$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;?>
					<div class="td-review-final-star">
					<?php 
					for($i=$totalScore;$i>=1;$i--):
					echo "<i class='fa fa-star'></i>";
					endfor;
					for($i=5-$totalScore;$i>=1;$i--):
					echo "<i class='fa fa-star-o'></i>";
					endfor;
				?>
				</div>
							<div class="td-module-meta-info"><span class="td-post-author-name"><a  href="<?php echo $link;?>"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></a> <span></span> </span></div>
							
							<div class="td-module-meta-info"><span class="td-post-author-name"><a  href="<?php echo $link;?>"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?> </a> <span></span> </span>
							</div>
							</div>
						</div>
						<div class="td_module_10 td_module_wrap td-animation-stack detail-page-sect td-visible-tablet-portrait home-list-section">
							<div class="td-module-thumb"><a title="<?php echo ucwords($result['add_name']);?>" rel="bookmark"  href="<?php echo $link;?>">
							<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper(trim($result['add_name'][0]));?>"><?php echo strtoupper($result['add_name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
							
							
							</a></div><div class="item-details"><h3 class="entry-title td-module-title">
							
							<a title="<?php echo ucwords($result['add_name']);?>" rel="bookmark"  href="<?php echo $link;?>"><?php echo ucwords($result['add_name']);?>,<?php echo ucwords($result['city_name']);?></a></h3><div class="td-module-meta-info"><a class="td-post-category  td-post-category-background"  href="<?php echo $link;?>"> <?php echo ucwords($result['city_name']);?></a> <span class="td-post-author-name"><a  href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a> </span><div class="td-module-comments"><a  href="<?php echo $link;?>"><?php echo $result['total_user_rated'];?></a></div> </div>
									<div class="td-module-meta-info">
									<span class="td-post-author-name1"><a  href="<?php echo $link;?>"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a> </span>
									</div>
									<!--<div class="td-module-meta-info">
									<span class="td-post-author-name1"><i class="fa fa-phone"></i> <?php echo $contact_number;?><span></span> </span>
									</div>-->
									<div class="td-module-meta-info">
									<span class="td-post-author-name1"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></span>
									</div>
									<?php 
					$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;?>
					<div class="td-review-final-star">
					<?php 
					for($i=$totalScore;$i>=1;$i--):
					echo "<i class='fa fa-star'></i>";
					endfor;
					for($i=5-$totalScore;$i>=1;$i--):
					echo "<i class='fa fa-star-o'></i>";
					endfor;
				?>
				</div>
									<div class="td-module-meta-info">
									<span class="td-post-author-name1"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?> <span></span></span>
									</div>							
							</div>
					</div>
						   <?php } 
				   
						   echo $this->load->view('pagenation_links',array(),true);
						   }else{
						   echo "No List Found";
						   
						   echo $this->load->view('advertisments/related_list.php',array(),true);
						   }
						   ?>
<div class="clearfix"></div></div>
</div>
 	<?php

		echo $this->load->view('categories/related_list_category',array(),true);
	?>
</div>
</div>
</div>
<script>
jQuery(document).ready(function($){
var is_category_page="<?php echo $this->uri->segment('1')?>";
var city ="<?php echo $this->uri->segment('3');?>";
if(is_category_page=='category-search' && city!=''){
	var keyword="<?php echo str_replace('-',' ',ucwords($this->uri->segment('2')))?>";
    $('#keyword_enquiry_keyword').val(keyword);
	$('.keyword_enquiry_keyword').html(keyword);
	var city="<?php echo str_replace('-',' ',ucwords($this->uri->segment('3')))?>";
	var area="<?php echo str_replace('-',' ',ucwords($this->uri->segment('4')))?>";
	$('.keyword_enquiry_city').html(city);
	$('#keyword_enquiry_city').val(city);
	if(area!='' && area !='undefined'){
		$('.keyword_enquiry_area').html(","+area);
		$('#keyword_enquiry_area').val(area);
	}
	var title="<b>"+keyword+"</b> to get best Service/Offers in your city.";
	$('.keyword_enquiry_form_title').html(title);
	setTimeout(function(){
		$('.td-keyword-modal-js').trigger('click');
	},1000)
}
});
</script>