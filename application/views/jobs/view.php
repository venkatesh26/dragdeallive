<?php
   $link='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   ?>
<div class="td-main-content-wrap job-detail-page">
   <div class="td-container td-post-template-2">
      <article itemtype="" itemscope="" class="post-117 post type-post status-publish format-standard has-post-thumbnail hentry category-tagdiv-reviews" id="post-117">
         <div class="td-pb-row">
            <div class="td-pb-span12">
               <div class="td-post-header">
                  <?php /************ Bread Crumb *****************/ echo $this->load->view('bread_crumb',array(),true); ?>
                  <header class="td-post-title">
                     <h1 class="entry-title view-page-title"><?php echo ucwords($result['name']);?></h1>
                     <div class="td-module-meta-info">
                        <div class="td-post-author-name">By <a href="javascript:void(0)"><?php echo ucwords('Admin');?></a> - </div>
                        <span class="td-post-date"><time class="entry-date updated td-module-date"><?php echo date('M d, Y',strtotime($result['created']));?></time></span> 
                        <div class="td-post-views"><i class="td-icon-views"></i><span class="td-nr-views-63"><?php echo $result['view_count'];?></span></div>
                     </div>
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
                        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $link;?>&title='<?php echo ucwords($result['name']);?>" class="td-social-sharing-buttons td-social-facebook">
                           <i class="fa fa-facebook"></i>
                           <div class="td-social-but-text">Share on Facebook</div>
                        </a>
                        <a href="http://twitter.com/intent/tweet?status=<?php echo ucwords($result['name']);?>+<?php echo $link;?>&via=Dragdeal.com" class="td-social-sharing-buttons td-social-twitter">
                           <i class="fa fa-twitter"></i>
                           <div class="td-social-but-text">Tweet on Twitter</div>
                        </a>
                        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://plus.google.com/share?url=<?php echo $share_link;?>" class="td-social-sharing-buttons td-social-google"><i class="fa fa-google-plus"></i></a>
                        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link;?>&title=<?php echo ucwords($result['name']);?>&summary=&source=dragdeal.com" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-linkedin"></i></a>
                     </div>
                  </div>
                  <div class="td-post-content">
                     <div class="td-paragraph-padding-1 view-page-description">
                        <p><?php echo ucwords($result['short_description']);?></p>
                     </div>
                  </div>
                  <?php if(!$this->detect->isMobile()):?>	
                  <p style="text-align:center">
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
                  <?php 
                     else:?>
                  <div class="td-a-rec td-a-rec-id-sidebar ">
                     <span class=td-adspot-title>- Advertisement -</span>
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
                  <?php endif;?>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                     <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-building fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;  <?php echo ucwords($result['company_name']);?></span>
                  </div>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                     <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-graduation-cap fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp; <?php echo ucwords($result['qualification']);?></span>
                  </div>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                     <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-book fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp; <?php echo ucwords($result['skills']);?></span>
                  </div>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                     <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-calendar fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp; Age Limit - <?php echo ucwords($result['age_limit']);?></span>
                  </div>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                     <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-graduation-cap fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp; Pay Scale - <?php echo ucwords($result['pay_scale']);?></span>
                  </div>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                     <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-map-marker fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp; <?php echo ucwords($result['city']);?></span>
                  </div>
                  <?php if($this->detect->isMobile()):?>		
                  <div class="td-a-rec td-a-rec-id-sidebar ">
                     <span class=td-adspot-title>- Advertisement -</span>
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
                  <?php endif;?>
                  <?php if(!$this->detect->isMobile()):?>	
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
                  <?php endif;?>
                  <?php  if($result['description']!=''):?>
                  <div class="td-post-content">
                     <div class="td-paragraph-padding-1 view-page-description">
                        <h3><strong>Summary</strong></h3>
                        <p><?php echo ucwords($result['description']);?></p>
                     </div>
                  </div>
                  <?php endif;?>
               </div>
            </div>
            <?php echo $this->load->view('jobs/related_jobs',array(),true);?>
         </div>
      </article>
   </div>
</div>