<div class="wpb_column vc_column_container td-pb-span4">
	<div class=wpb_wrapper>
		<div class="td_block_wrap td_block_15 td_uid_47_57f918e044cda_rand td_with_ajax_pagination td-pb-border-top" data-td-block-uid="td_uid_47_57f918e044cda">
		<div class="td-block-title-wrap"><h4 class="block-title"><span>Popular Blogs</span></h4></div>
		<div id="td_uid_47_57f918e044cda" class="td_block_inner td-column-1">

			<?php $side_widget_blogs=side_widget_blogs(); foreach($side_widget_blogs as $blogs): $link=base_url(). 'blogs'. '/'.$blogs[ 'id']. '/'.url_title(strtolower($blogs[ 'name'])); $image='' ; if(file_exists( './'.$blogs[ 'image_dir'].$blogs[ 'image_name']) && $blogs[ 'image_name']!="" ) { 
						$img_src = thumb(FCPATH.$blogs['image_dir'].$blogs['image_name'],'218','150','blog_side_thumb');
						$image = base_url().$blogs['image_dir'].'blog_side_thumb/'.$img_src;
			} ?>
			<div class="td-block-span12">
			<div class="td_module_mx4 td_module_wrap td-animation-stack">
			<div class="td-module-image">
			<div class="td-module-thumb">

			<a href="<?php echo $link;?>" rel="bookmark" title="<?php echo $blogs['name'];?>"><img width="218" height="150" class="entry-thumb td-animation-stack-type0-2" src="<?php echo $image;?>" alt="" title="<?php echo $blogs['name'];?>"></a></div> <a href="<?php echo $link;?>" class="td-post-category td-post-category-new-background"><?php echo $blogs['name'];?></a> </div>
			<h3 class="entry-title td-module-title"><a href="<?php echo $link;?>" rel="bookmark" title="<?php echo $blogs['name'];?>"><?php echo ucwords(substr($blogs['short_description'],0,60)).'...';?></a></h3>
			</div>
			</div>
			<?php endforeach;?>
		</div>	
		</div>
		     <!-- <div class="td_block_wrap td_block_social_counter td_uid_27_57495b20c442f_rand td-pb-border-top">
                                <h4 class=block-title><span>Social Statistics</span></h4>
                                <div class=td-social-list>
                                    <div class="td_social_type td-pb-margin-side td_social_facebook">
                                        <div class=td-social-box>
                                            <div class="td-sp td-sp-facebook"></div><span class=td_social_info>1,670</span><span class="td_social_info td_social_info_name">Total Users</span><span class=td_social_button><a href="javascript:void(0)" target=_blank>Total Users</a></span>
                                        </div>
                                    </div>
                                    <div class="td_social_type td-pb-margin-side td_social_twitter">
                                        <div class=td-social-box>
                                            <div class="td-sp td-sp-twitter"></div><span class=td_social_info>1,290</span><span class="td_social_info td_social_info_name">Followers</span><span class=td_social_button><a href="javascript:void(0)" target=_blank>Follow</a></span>
                                        </div>
                                    </div>
                                    <div class="td_social_type td-pb-margin-side td_social_youtube">
                                        <div class=td-social-box>
                                            <div class="td-sp td-sp-youtube"></div><span class=td_social_info>1,253</span><span class="td_social_info td_social_info_name">Subscribers</span><span class=td_social_button><a href="javascript:void(0)" target=_blank>Subscribe</a></span>
                                        </div>
                                    </div>
                                    <div class=clearfix></div>
                                </div>
                            </div>-->
	</div>
</div>