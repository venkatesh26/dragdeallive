<div class="td-category-header">
<div class="td-container">
<div class="td-pb-row">
<div class="td-pb-span12">
<?php  
	/************ Bread Crumb *****************/
	echo $this->load->view('bread_crumb',array(),true);
?>
<h3 class="entry-title td-page-title"><?php echo $search_header_title;?><span class="total-count"><?php echo ' ('.number_format($total_count).')';?></h3>
<div class="clearfix"></div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="td-main-content-wrap">
<div class="td-container">
<div class="td-pb-row">
<div class="td-pb-span8 td-main-content">
<div class="td-ss-main-content"><div class="clearfix"></div>
<?php
						   if(!empty($list['listings'])){
						   foreach($list['listings'] as $result){
							   
							   
							$link=base_url().'blogs'.'/'.$result['id'].'/'.url_title(strtolower($result['name']));
							$image=base_url().'assets/themes/images/281-218x150.jpg';
							if(!empty($result['image_dir']) && file_exists('./'.$result['image_dir'].$result['image_name']))
							{
							   $img_src = thumb(FCPATH.$result['image_dir'].$result['image_name'],'218','159','blog_list_thumb');
							   $image = base_url().$result['image_dir'].'blog_list_thumb/'.$img_src;
							}
?>
<div class="td_module_10 td_module_wrap td-animation-stack">
<div class="td-module-thumb">
<a title="" rel="bookmark" href="<?php echo $link;?>"><img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2"></a>
</div>
<div class="item-details">
<h3 class="entry-title td-module-title"><a title="" rel="bookmark" href="<?php echo $link;?>"><?php echo $result['name'];?><?php echo " ,".ucwords($result['author']);?></a></h3>
<div class="td-module-meta-info">
<a class="td-post-category td-post-category-new-background" href="<?php echo $link;?>">  <i class="fa fa-map-marker"></i> <?php echo ucwords($result['author']);?></a> 
<span class="td-post-date"><time class="entry-date updated td-module-date"><?php echo date('F d, Y',strtotime($result['created']));?></time></span>
<div class="td-module-comments"><a href="<?php echo $link;?>"><?php echo $result['total_user_rated'];?></a></div> 
</div>
<div class="td-excerpt">
<?php echo ucwords(substr($result['short_description'],0,170)).'...';?>
</div>
</div>
</div>
						   <?php } 
						   echo $this->load->view('pagenation_links',array(),true);
						   }?>
<div class="clearfix"></div></div>
</div>
<?php echo $this->load->view('categories/related_blog_list_category',array(),true);	?>
</div>
</div>
</div>