<?php
$link='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<div class="td-main-content-wrap">
    <div class="td-container td-post-template-2">
        <article itemtype="" itemscope="" class="post-117 post type-post status-publish format-standard has-post-thumbnail hentry category-tagdiv-reviews" id="post-117">
            <div class="td-pb-row">
                <div class="td-pb-span12">
                    <div class="td-post-header">
                        <?php /************ Bread Crumb *****************/ echo $this->load->view('bread_crumb',array(),true); ?>
                        <header class="td-post-title">
                            <h1 class="entry-title view-page-title"><?php echo ucwords($result['name']);?></h1>
  
							<div class="td-module-meta-info">
<div class="td-post-author-name">By <a href="javascript:void(0)"><?php echo ucwords($result['author']);?></a> - </div> <span class="td-post-date"><time class="entry-date updated td-module-date"><?php echo date('M d, Y',strtotime($result['created']));?></time></span> <div class="td-post-views"><i class="td-icon-views"></i><span class="td-nr-views-63"><?php echo $result['view_count'];?></span></div> <div class="td-post-comments"><a href="javscript:void(0)"><i class="td-icon-comments"></i><?php echo $result['total_user_rated'];?></a></div> </div>
                        </header>
                    </div>
                </div>
            </div>
            <div class="td-pb-row">
                <div role="main" class="td-pb-span8 td-main-content">
                    <div class="td-ss-main-content">
                        <div class="clearfix"></div>
                        <div class="td-post-sharing td-post-sharing-top">
                            <div class="td-default-sharing">
							<?php $share_link="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
                                <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $link;?>&title='<?php echo ucwords($result['name']);?>" class="td-social-sharing-buttons td-social-facebook"><i class="fa fa-facebook"></i><div class="td-social-but-text">Share on Facebook</div></a>
								
								
                                <a href="http://twitter.com/intent/tweet?status=<?php echo ucwords($result['name']);?>+<?php echo $link;?>&via=Dialbe.com" class="td-social-sharing-buttons td-social-twitter"><i class="fa fa-twitter"></i><div class="td-social-but-text">Tweet on Twitter</div></a>
								
                                <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://plus.google.com/share?url=<?php echo $share_link;?>" class="td-social-sharing-buttons td-social-google"><i class="fa fa-google-plus"></i></a>
								
                                <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link;?>&title=<?php echo ucwords($result['name']);?>&summary=&source=dialbe.com" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
							<?php 
							if(!empty($result['image_name']) && file_exists('./'.$result['image_dir'].$result['image_name']))
							{
							   $img_src = thumb(FCPATH.$result['image_dir'].$result['image_name'],'696','255','blog_view_thumb');
							   $image = base_url().$result['image_dir'].'blog_view_thumb/'.$img_src;?>
								<div class="td-post-content">
								<div class=td-post-featured-image><a href="<?php echo $image;?>" data-caption=""><img width=696 height=507 class="entry-thumb td-modal-image" src="<?php echo $image;?>" alt="" title=281 /></a></div>
								</div>
							<?php 
							}
						   if($result['description']!=''):?>
                        <div class="td-post-content">
						
                            <div class="td-paragraph-padding-1 view-page-description">
                                <h3><strong>Summary</strong></h3>
                                <p><?php echo ucwords($result['description']);?></p>
                            </div>
                        </div>
						<?php endif;?>
						<p>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- newtheme detailpage -->
						<ins class="adsbygoogle"
							 style="display:inline-block;width:728px;height:90px"
							 data-ad-client="ca-pub-2739505616311307"
							 data-ad-slot="8370024870"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
						</p>
                        <footer>
						    <table class="td-review">
                                <tbody>
                                <!--    <tr class="td-review-header">
                                        <td colspan="2"><span class="block-title  td-post-category-background">REVIEW OVERVIEW</span>
                                        </td>
                                    </tr>

                                    <tr class="td-review-row-bars">
                                        <td colspan="2">
                                            <div class="td-review-details">
                                                <div class="td-review-desc">Overall Review</div>
                                                <div class="td-review-percent"><?php echo $result['overall_score'];?></div>
                                            </div>
                                            <div class="td-rating-bar-wrap">
                                                <div style="width:<?php echo $result['overall_score'] * 10;?>%" class="theme1"></div>
                                            </div>
                                        </td>
                                    </tr>
									<tr class="td-review-row-bars">
                                        <td colspan="2">
                                            <div class="td-review-details">
                                                <div class="td-review-desc">Site Review</div>
                                                <div class="td-review-percent"><?php echo $result['site_score'];?></div>
                                            </div>
                                            <div class="td-rating-bar-wrap">
                                                <div style="width:<?php echo $result['site_score'] * 10;?>%" class="theme2"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="td-review-row-bars">
                                        <td colspan="2">
                                            <div class="td-review-details">
                                                <div class="td-review-desc">User Review</div>
                                                <div class="td-review-percent">
												<?php 
												$rating=($result['rating']!='')?$result['rating']:0;
                                                echo $rating;
												?>
												</div>
                                            </div>
                                            <div class="td-rating-bar-wrap">
                                                <div style="width:<?php echo $rating * 10;?>%" class="theme3"></div>
                                            </div>
                                        </td>
                                    </tr> -->

                                  <!--  <tr class="td-review-footer rate_point">
                                        <td class="td-review-summary"><span class="block-title  td-post-category-background">SUMMARY</span>
                                            <div class="td-review-summary-content"><?php echo $result['short_description'];?></div>
                                        </td>
                                        <td class="td-review-score">
                                            <div class="td-review-overall">
                                                <div class="td-review-final-score total-score-statstics">
												<?php 
												$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;
												echo number_format($totalScore,1);
												?>
												</div>
                                                <div class="td-review-final-star">
												<?php 
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
												?>
                                                </div><span>OVERALL SCORE</span>
                                            </div>
                                        </td>
                                    </tr>-->
                                </tbody>

                            </table>
                        <?php
							echo $this->load->view('blogs/view_share',array(),true);
							echo $this->load->view('blogs/view_reviews',array(),true);
						?>
					</footer>
					   <?php 
						echo $this->load->view('blogs/view_add_blog_comments',array(),true);
					   ?>
                    </div>
                </div>
                <?php echo $this->load->view('categories/related_blog_category',array(),true);?>
            </div>
        </article>
    </div>
</div>