<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers_new.css"/>
<?php 
   $image=base_url().'assets/themes/images/281-218x150.png';
   if(!empty($result['profile_image']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
   {
    $img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'218','159','offer_detail_view_thumb');
    $image = base_url().$result['image_dir'].'offer_detail_view_thumb/'.$img_src;
   }
   ?>
<?php
   $link='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   $user_coupon_code=array();							
   if($this->session->userdata('user_id')){
   	$user_coupon_code=get_user_coupon_code($this->session->userdata('user_id'));
   }
   $user_campaign_interset=array();							
   if($this->session->userdata('user_id')){
   $user_campaign_interset=get_user_campaign_interset($this->session->userdata('user_id'));
   }
   ?>
<div class="td-main-content-wrap offer-main-page">
   <div class="td-container td-post-template-2">
      <article itemtype="" itemscope="" class="post-117 post type-post status-publish format-standard has-post-thumbnail hentry category-tagdiv-reviews" id="post-117">
         <div class="td-pb-row">
            <div class="td-pb-span12">
               <div class="td-post-header">
                  <?php /************ Bread Crumb *****************/ echo $this->load->view('bread_crumb',array(),true); ?>
               </div>
            </div>
         </div>
         <div class="td-pb-row" style="background-color:#ddd;padding-top:10px;padding-right:10px;">
            <div id="divOfferDetailsBlock" class="row">
               <div id="offerDetails" class="col-md-12">
                  <div id="divOfferDetails2" class="col-md-3.5">
                     <div class="boxes marginLRAuto">
                        <div class="offerBox offer-page-view">
                           <div class="offer">
                              <div class="panel-heading">
                                 <h3 class="panel-title">
                                    <?php echo ucwords($result['title']);?>
                                 </h3>
                              </div>
                              <br/>
                              <div class="offerPriceDiv">
                                 <div class="td-review-final-star">
                                    <i class="fa fa-calendar"></i> <?php echo date('d, M Y',strtotime($result['campaign_start_date']));?> - <i class="fa fa-calendar"></i> <?php echo date('d, M Y',strtotime($result['campaign_end_date']));?> 								
                                 </div>
                              </div>
                              <div class="offerImage zoom-gallery" style="height: 260px">
                                 <a href="<?php echo $link;?>" title="<?php echo ucwords($result['title']);?>">
                                 <img alt="<?php echo ucwords($result['title']);?>" class="img-responsive growZoom imgOfferImage" src="<?php echo $image;?>"></a>
								 <?php 
								 if($result['offer_type']==2 && $result['percentage'] > 0):?>
						<span class="off"><?php echo $result['percentage']; ?> %</span>
						<?php elseif($result['offer_type']==1 && $result['offer_price'] > 0):?>
						<span class="off"><strike>Rs. <?php echo $result['mrp_price']; ?></strike><br>Rs.<?php echo $result['offer_price']; ?> </span>
					<?php endif;?>
                              </div>
							  	
                              <div class="offerPriceDiv">
                             
                                 <div class="offerTime txtEllipsis"><i class="fa fa-clock-o"></i>&nbsp;<span class="snoToolTip" title="" data-original-title="offer&nbsp;expires&nbsp;in"><?php echo couponsDaysLeft($result['campaign_end_date']);?></span></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div id="divOfferStoreDetails2" class="col-md-5 boxWhite" style="display:inline-block;margin-top:10px;">
                     <div class="panel-heading">
                        <h3 class="panel-title">
                           <?php $link=base_url().'business'.'/'.$result['add_id'].'/'.url_title(strtolower($result['add_name'])).'/'.url_title(strtolower($result['city_name']));?>
                           <a href="<?php echo $link;?>"><?php echo ucwords($result['add_name']);?>, <?php echo ucwords($result['address_line']);?>, <?php echo ucwords($result['area_name']);?>, <?php echo ucwords($result['city_name']);?></a>
                        </h3>
                     </div>
                     <div class="map_canvas" id="map_canvas" style="height: 217px; width: 100%; margin-top: 20px; border: 1px solid rgb(204, 204, 204); padding: 5px; position: relative; overflow: hidden;" data-address="<?php echo ucwords($result['address_line']);?>, <?php echo ucwords($result['area_name']);?>, <?php echo ucwords($result['city_name']);?>" data-title="<?php echo ucwords($result['add_name']);?>">
                     </div>
                     <div id="storeLocationAddress">
                        <br/>
                        <div class="divBranches" id="branch-5680">
                           <div class="font16 colorGray marginT5 marginL15"><b><i class="fa fa-mobile">&nbsp;</i> <?php echo ucwords($result['contact_number']);?></b></div>
                        </div>
                     </div>
                     <div class="td-post-sharing td-post-sharing-top">
                        <div class="td-default-sharing">
                           <?php $share_link="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
                           <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $link;?>&title='<?php echo ucwords($result['title']);?>" class="td-social-sharing-buttons td-social-facebook">
                              <i class="fa fa-facebook"></i>
                              <div class="td-social-but-text">Share on Facebook</div>
                           </a>
                           <a href="http://twitter.com/intent/tweet?status=<?php echo ucwords($result['title']);?>+<?php echo $link;?>&via=Dialbe.com" class="td-social-sharing-buttons td-social-twitter">
                              <i class="fa fa-twitter"></i>
                              <div class="td-social-but-text">Tweet on Twitter</div>
                           </a>
                           <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://plus.google.com/share?url=<?php echo $share_link;?>" class="td-social-sharing-buttons td-social-google"><i class="fa fa-google-plus"></i></a>
                           <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link;?>&title=<?php echo ucwords($result['title']);?>&summary=&source=dialbe.com" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-linkedin"></i></a>
                        </div>
                     </div>
                  </div>
                  <div id="divGetOfferCode" class="col-md-3.5" style="display:inline-block;margin-left:20px;">
                     <div class="boxWhite boxShadow text-center col-md-3.5" style="    width: 300px;
                        margin-top: 10px;">
                        <div id="divMobNoOfferCode" class="">
                           <label>Hey Dude ! you would like to interset in this offer.please Click to below.</label>
                           <?php if(isset($user_campaign_interset[$result['id']])):?>
                           <button id="btnMobNoOfferCode" type="button" class="btn btn-orange btnMobNoOfferCode"  data-couponid="35" data-addid="21">I Already Liked</button>
                           <?php else:?>
                           <?php if(!$this->session->userdata('user_id')):?>
                           <a href="<?php echo base_url();?>register" class="btn btn-orange btnMobNoOfferCode"  data-href="<?php echo base_url().'offers/show_interset';?>" data-parent="<?php echo $result['user_id'];?>"  data-campaignid="<?php echo $result['id'];?>">I Am Interset on this Offer</a>
                           <?php else:?>
                           <a href="javascript:void(0)"  class="btn btn-orange btnMobNoOfferCode new_add_interset"  data-href="<?php echo base_url().'offers/show_interset';?>" data-parent="<?php echo $result['user_id'];?>"  data-campaignid="<?php echo $result['id'];?>">I Am Interset on this Offer</a>
                           <?php endif;?>
                           <?php endif;?>
                        </div>
                     </div>
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
                  </div>
               </div>
            </div>
            <br/>
            <div role="main" class="td-pb-span12 td-main-content coupon-main-content">
              <?php if($this->detect->isMobile() || $this->detect->isTablet()):?>		
            
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
			   
               <?php else:?>
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
               <?php endif;?>
               <div class="td-ss-main-content">
                  <div class="clearfix"></div>
                  <?php 
                     if($result['description']!=''):?>
                  <div class="td-post-content">
                     <div class="td-paragraph-padding-1 view-page-description view-page-coupon">
                        <h3><strong class="review-overview-title">Offer Summary</strong></h3>
                        <?php echo $result['description'];?>
                     </div>
                  </div>
                  <?php endif;?>
               </div>
            </div>
         </div>
      </article>
   </div>
</div>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDEzS87sF3Q5nxXcLqugUJAp0hGzQS2mTk"></script>
<script type="text/javascript">
   $(document).ready(function(){
   	map_initialize();
   });
</script>