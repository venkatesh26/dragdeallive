                    <div class="td-pb-span4 td-main-sidebar" role=complementary>
                        <div class=td-ss-main-sidebar>
                            <aside class="widget widget_categories">
                                <div class=block-title><span>Latest Premium Business Listings</span>
                                </div>
								<div class="td_block_wrap td_block_15 td_uid_47_57f918e044cda_rand td_with_ajax_pagination td-pb-border-top" data-td-block-uid="td_uid_47_57f918e044cda">
									<div id="td_uid_47_57f918e044cda" class="td_block_inner td-column-1">
										<?php 
										$side_widget_adds=side_widget_adds(); 
										foreach($side_widget_adds as $item): 
										$link=base_url(). 'business'. '/'.$item[ 'id']. '/'.url_title(strtolower($item[ 'name'])). '/'.url_title(strtolower($item[ 'city_name']));
										$image=base_url().'assets/themes/images/281-218x150.png';
										 $title=ucwords($item[ 'name']); if($item[ 'city_name']!='' ){ $title=$title. " ,".$item[ 'city_name'];}
										if(file_exists( './'.$item[ 'image_dir'].$item[ 'profile_image']) && $item[ 'profile_image']!="" ) {
											$img_src = thumb(FCPATH.$item['image_dir'].$item['profile_image'],'218','150','list_side_thumb');
											$image = base_url().$item['image_dir'].'list_side_thumb/'.$img_src;
										} ?>
										<div class="td-block-span12">
										<div class="td_module_mx4 td_module_wrap td-animation-stack">
										<div class="td-module-image">
										<div class="td-module-thumb">
										<a href="<?php echo $link;?>" rel="bookmark" title="<?php echo $item['name'];?>"><img width="218" height="150" class="entry-thumb td-animation-stack-type0-2" src="<?php echo $image;?>" alt="" title="<?php echo $item['name'];?>"></a></div> <a style="color:#fff;" href="<?php echo $link;?>" class="td-post-category td-post-category-new-background"><?php echo $title;?></a> </div>
										<h3 class="entry-title td-module-title"><a href="<?php echo $link;?>" rel="bookmark" title="<?php echo $item['name'];?>"><?php echo ucwords(substr($item['short_description'],0,60)).'...';?></a></h3>
										</div>
										</div>
										<?php endforeach;?>
									</div>
								</div>
							</aside>
                            <aside class="widget widget_categories widget_recent_entries">
							
                           <div class="td-a-rec td-a-rec-id-sidebar "><span class=td-adspot-title>- Advertisement -</span>
                                <div>
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
                                </div>
								  <div class=block-title><span>MOSTLY USED CATEGORIES</span>
                                </div>
                                <ul> 
								    <?php
									$israndom=1;
									if($israndom):
									$footer_categories=home_side_categories();
									foreach($footer_categories as $category)
									{
										$urlSplit=explode('/',$category['link']);
										$categoryName=str_replace('-',' ',$urlSplit[4]);
									?>
									 <li class="cat-item cat-item-7"><i class="fa fa-arrow-right"></i> <a href="<?php echo $category['link'];?>"><?php echo ucwords($categoryName);?></a></li>
									 
									<?php
									}
									else:
								
									$footer_categories=footer_categories_with_count();
									foreach($footer_categories as $category)
									{?>
								  
									 <li class="cat-item cat-item-7"><i class="fa fa-arrow-right"></i> <a href="<?php echo base_url().'category-search/'.url_title(strtolower($category['name']));?>"><?php echo ucwords($category['name']);?></a></li>
									 
									<?php
									}
									endif;
									?>
                                 
                                </ul>
                            </aside>
                        </div>
                    </div>