<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers_new.css"/>
<?php 
   $image=base_url().'assets/themes/images/281-218x150.png';
   if(!empty($result['profile_image']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
   {
   $img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'218','159','coupon_detail_view_thumb');
   $image = base_url().$result['image_dir'].'coupon_detail_view_thumb/'.$img_src;
   }
   $add_image=base_url().'assets/themes/images/281-218x150.png';
   if(!empty($result['add_profile_image']) && file_exists('./'.$result['add_image_dir'].$result['add_profile_image']))
   {
   $img_src = thumb(FCPATH.$result['add_image_dir'].$result['add_profile_image'],'32','32','coupon_detail_add_view_thumb');
   $add_image = base_url().$result['add_image_dir'].'coupon_detail_add_view_thumb/'.$img_src;
   }
   ?>
<?php
   $link='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   $user_coupon_code=array();							
   if($this->session->userdata('user_id')){
   	$user_coupon_code=get_user_coupon_code($this->session->userdata('user_id'));
   }
   
   
   ?>
<div class="td-main-content-wrap">
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
               <div id="offerDetails" class="col-md-9">
                  <div id="divOfferStoreBlock" class="row">
                     <div id="divOfferDetails2" class="col-md-5">
                        <div class="boxes marginLRAuto">
                           <div class="offerBox">
                              <div class="offer">
							    <div class="panel-heading">
                           <h3 class="panel-title">
						  <?php echo ucwords($result['name']);?>
						   </h3>
                        </div>
                   <br/>
                                 <div class="offerImage zoom-gallery" style="height: 220px">
                                    <a href="<?php echo $add_image;?>" title="<?php echo ucwords($result['name']);?>">
                                    <img alt="<?php echo ucwords($result['name']);?>" class="img-responsive growZoom imgOfferImage" src="<?php echo $image;?>"></a>
                                 </div>
                                 <div class="productTags">
									<?php $keywords=explode(',',$result['keywords']);?>
						<span class="fa fa-tags cyan"></span>
							<?php 
							foreach($keywords as $keyword):
							$new_link=base_url(). 'coupon-category-search/'.url_title($result['city_name'])."/".url_title($result['area_name']).'/'.url_title(strtolower($keyword));
							?>
							<a href="<?php echo $new_link;?>" title="<?php echo ucwords($keyword);?>"><?php echo ucwords($keyword);?></a>
							<?php endforeach;?>
								
                                 </div>
                                 <div class="offerPriceDiv">
					
					
					 <?php if($result['price_type']==0 && $result['percentage'] > 0):?>
						  <span class="offerPrice txtEllipsis"><?php echo $result['percentage']; ?> %</span>
						<?php elseif($result['price_type']==1 && $result['offer_price'] > 0):?>
						
						<span class="offerPrice txtEllipsis"><strike>Rs. <?php echo $result['original_price']; ?></strike> Rs. <?php echo $result['offer_price']; ?></span>
					<?php endif;?>
                                  
                                  
                                    <div class="offerTime txtEllipsis"><i class="fa fa-clock-o"></i>&nbsp;<span class="snoToolTip" title="" data-original-title="offer&nbsp;expires&nbsp;in"><?php echo couponsDaysLeft($result['exipry_date']);?></span></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                   
					 <div id="divOfferStoreDetails2" class="col-md-7 boxWhite">
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
                              <div class="branchDetails width100Per">
                                 <i class="fa fa-map-marker"></i> <span class="spanLocalityCityName cyan"><?php echo ucwords($result['add_name']);?>, <?php echo ucwords($result['city_name']);?></span>
                              </div>
                     
                              <div class="font16 colorGray marginT5 marginL15"><b><i class="fa fa-mobile">&nbsp;</i> <?php echo ucwords($result['contact_number']);?></b></div>
                           </div>
                        </div>
						     <div class="td-post-sharing td-post-sharing-top">
                     <div class="td-default-sharing">
                        <?php $share_link="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
                        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $link;?>&title='<?php echo ucwords($result['name']);?>" class="td-social-sharing-buttons td-social-facebook">
                           <i class="fa fa-facebook"></i>
                           <div class="td-social-but-text">Share on Facebook</div>
                        </a>
                        <a href="http://twitter.com/intent/tweet?status=<?php echo ucwords($result['name']);?>+<?php echo $link;?>&via=Dialbe.com" class="td-social-sharing-buttons td-social-twitter">
                           <i class="fa fa-twitter"></i>
                           <div class="td-social-but-text">Tweet on Twitter</div>
                        </a>
                        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://plus.google.com/share?url=<?php echo $share_link;?>" class="td-social-sharing-buttons td-social-google"><i class="fa fa-google-plus"></i></a>
                        <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link;?>&title=<?php echo ucwords($result['name']);?>&summary=&source=dialbe.com" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-linkedin"></i></a>
                     </div>
                  </div>
                     </div>
                  </div>
               </div>
               <div id="divGetOfferCode" class="col-md-3">
                  <div class="boxWhite boxShadow text-center">
                     <div id="divMobNoOfferCode" class="">
                        <label>Please Enter your Mobile Number to Get Offer Code via SMS for Free!</label>
                        <div><span id="spanMobile91">+91</span><input id="txtMobNoOfferCode" type="text" class="form-control" maxlength="10" placeholder="Enter Mobile Number" value="<?php echo $this->session->userdata('contact_number');?>"></div>
						<?php if($this->session->userdata('user_id')!=''):?>
							<button id="btnMobNoOfferCode" type="button" class="btn btn-orange btnMobNoOfferCode new_download_coupon_code" data-href="<?php echo base_url().'coupons/download_coupons';?>" data-couponid="<?php echo $result['id'];?>" data-addid="<?php echo $result['add_id'];?>">Get Offer Code</button>
						<?php 
						else:?>
						<button id="btnMobNoOfferCode" type="button" class="btn btn-orange btnMobNoOfferCode" onclick="window.open('<?php echo base_url().'login?redirect_url='.$share_link;?>','_self'); return false;">Login And Get Offer Code</button>
						<?php endif;?>
                        <label id="lblSendOTP" class="offerText">By clicking Get Offer Code you agree to the <a href="javascript:void(0)" target="_blank">terms and conditions</a></label>
                     </div>   
                  </div>
                  <div class="boxWhite boxShadow marginT10">
                     <div class="panel panel-info">
                        <div class="panel-heading">
                           <h3 class="panel-title">How to Redeem this Offer?</h3>
                        </div>
                        <div class="panel-body">
                           <ul id="ulRedeemOffer">
                              <li>Get Offer details via SMS for Free</li>
                              <li>Show the SMS at Store</li>
                              <li>Avail the Offers</li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			
			<br/>
            <div role="main" class="td-pb-span12 td-main-content coupon-main-content">
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
				<?php elseif($this->agent->is_mobile()):?>
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
                  <?php if(count($keyword_data) > 0):?>
                  <div class="td-post-sharing td-post-sharing-bottom td-with-like view-page-coupon">
                     <div class="td-post-source-tags">
                        <div class="td-post-source-via td-no-tags">
                           <div class="td-post-small-box">
                              <h3><strong class="review-overview-title">Keywords</strong></h3>
                              <?php foreach($keyword_data as $datas){ 
                                 $cat_name=$datas['category_name'];
								 $link_cat=base_url(). 'coupon-category-search/'.url_title($result['city_name'])."/".url_title($result['area_name']).'/'.url_title(strtolower($cat_name));
							   ?>
                              <a href="<?php echo $link_cat;?>" rel="nofollow">
                              <?php echo ucwords($cat_name);?>
                              </a>
                              <?php }?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php endif;?>
                  <?php if(count($price_range) > 0):?>
				  <div class="view-page-coupon">
						  <h3><strong class="review-overview-title">Price Range Offer</strong></h3>
					  <table class="view-page-coupon">
						 <th>Price Range </th>
						 <th>Percentage</th>
						 <?php 
							foreach($price_range as $price_list):?>
						 <tr>
							<td><?php echo $price_list['from_price'];?>-<?php echo $price_list['to_price'];?></td>
							<td><?php echo $price_list['percentage'];?> % </td>
						 </tr>
						 <?php endforeach;?>
					  </table>
				  </div>
                  <?php endif;?>
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