<?php if(!empty($gallery)):?>
<div class="td_block_wrap td_block_related_posts">
                            <h4 class="td-related-title">
							<a href="#" data-td_block_id="td_uid_11_57626b8662c1a" data-td_filter_value="" class="td-related-left td-cur-simple-item" id="td_uid_12_57626b86635c1">Profile Gallery</a>
							</h4>
                            <div class="td_block_inner">
                                <div class="td-related-row">
								<article itemtype="" itemscope="" class="post-117 post type-post status-publish format-standard has-post-thumbnail hentry category-tagdiv-reviews">
								   <?php 
								   foreach($gallery as $result):
								   $image=base_url().'assets/themes/images/281-218x150.png';
								   $or_image='#';
									if(!empty($result['profile_image']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
									{
									   $img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'218','150','gallery_thumb');
									   $or_image="#";
									   $image = base_url().$result['image_dir'].'gallery_thumb/'.$img_src;
									}
								   ?>
								   
										<div class="td-related-span4">
											<div class="td_module_related_posts td-animation-stack td_mod_related_posts">
												<div class="td-module-image">
													<div class="td-module-thumb td-post-featured-image>">
														<a title=""  href="<?php echo $or_image;?>">
														<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-modal-image td-animation-stack-type0-2">
														</a>
													</div> 
												</div>
											</div>
										</div>	
											
									<?php endforeach;?>	
</article>									
                                </div>
								
                            </div>
                        </div>
<?php endif;?>
<div class="clearfix"></div>
<br/>