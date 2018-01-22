        <div class="td-main-content-wrap td-main-page-wrap">
			<div class=td-container>
				<div class="vc_row wpb_row td-pb-row">
					<div class="wpb_column vc_column_container td-pb-span12">
						<div class=wpb_wrapper>
					

<?php
if(count($list) > 0):?>
<link rel=stylesheet  href='<?php echo base_url();?>assets/products/css/product.css' type='text/css' media=all />
<link rel='stylesheet' href='<?php echo base_url();?>assets/products/css/bootstrap.min.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo base_url();?>assets/products/css/style1.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo base_url();?>assets/products/css/chosen.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo base_url();?>assets/products/css/color.css' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo base_url();?>assets/products/css/front.css' type='text/css' media='all' />
<div class="row content">
<section class="main-content col-lg-9 col-md-9 col-sm-9">
   <div class="row">
      <!-- Heading -->
      <div class="col-lg-12 col-md-12 col-sm-12">
         <div class="carousel-heading">
            <h4>Deals Of the Day</h4>
         </div>
		<div class="categories-heading">
			<div class="term-description"><p>Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in ipsum id orci porta dapibus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Cras ultricies ligula sed magna dictum porta.</p>
			</div>					
		</div>					
      </div>
   </div>
   <!-- end row -->
   <div class="row">
      <ul class="products" id="container-product">
	    
		<?php 
		$store_image=$this->config->item('store_image');
		$store_affliate=$this->config->item('store_affliate');
		foreach($list['listings'] as $item):?>
		
         <li class=" first  col-lg-4 col-md-4 col-sm-4 col-xs-6 post-127 product type-product status-publish has-post-thumbnail product_cat-adapters product_cat-cameras product_cat-cell-phones product_cat-computers product_tag-prodtag2 product_shipping_class-box1 product_brand-manufacture2  outofstock sale featured shipping-taxable purchasable product-type-simple" style="margin-left:0px !important">
			<?php
			$link=$item['url'].$store_affliate[$item['vendor_id']];
			$image=base_url().'assets/themes/images/410-356x364.jpg';
			if(file_exists('./'.$item['image_dir'].'/'.$item['product_image']) && $item['product_image']!="") 	  
			{
				$img_src = thumb(FCPATH.$item['image_dir'].'/'.$item['product_image'],'270','270','home_deals_thumb');
				$image = base_url().$item['image_dir'].'/home_deals_thumb/'.$img_src;
			}?>
		 
            <div class="product-image">
               <span class="onsale" style="margin-left: 0;">Sale</span><span class="onsale labels_stock" style="margin-left: 0;">Stock</span>			
               <span class="onsale onfeatured"><?php echo ucwords($item['title']);?></span>
               <a href="http://velikorodnov.com/dev/homeshop_preview/product/cameras/" class="img-product-hover"><img width="270" height="270" src="<?php echo $image;?>" class="attachment-th-shop size-th-shop wp-post-image" alt="s1" sizes="(max-width: 270px) 100vw, 270px">			</a>			
               <a href="http://velikorodnov.com/dev/homeshop_preview/product/cameras/" class="product-hover">
               <i class="icons icon-eye-1"></i>Get Offers</a>
            </div>
			
            <div class="product-info">
               <h3><a href="http://velikorodnov.com/dev/homeshop_preview/product/cameras/">
                  <b><?php echo ucwords($item['title']);?></b></a>
               </h3>
           
               <div class="description">
			    <?php echo ucwords($item['description']);?>
               </div>
			     <span class="mg-brand-wrapper mg-brand-wrapper-category"><b>Deals Available On</b> <a href="http://velikorodnov.com/dev/homeshop_preview/brands/manufacture2/">
				  <img src="<?php echo base_url()."assets/products/shop-flipkart.gif";?>"></a></span>
            </div>
            <div class="product-actions">
               <span class="add-to-cart current"><a href="http://velikorodnov.com/dev/homeshop_preview/product/cameras/" rel="nofollow" data-quantity="1" data-product_id="127" data-product_sku="752258" class="add_to_cart_button product_type_simple"><span class="action-wrapper">
               <i class="icons icon-basket-2"></i>
               <span class="action-name">Read more</span>
               </span></a></span><span class="add-to-favorites yith-wcwl-add-button"><a href="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/admin/yith_wishlist/yith-wcwl-ajax.php?action=add_to_wishlist&amp;add-to-wishlist=127" data-product-id="127" data-product-type="simple" class="add_to_wishlist"><span class="action-wrapper">
               <i class="icons icon-heart-empty"></i><span class="action-name">Add to Wishlist</span></span></a><img src="http://velikorodnov.com/dev/homeshop_preview/wp-admin/images/wpspin_light.gif" class="ajax-loading" id="add-items-ajax-loading" alt="" style="visibility:hidden"></span><span class="add-to-favorites yith-wcwl-wishlistaddedbrowse" style="display:none;"><a href="http://velikorodnov.com/dev/homeshop_preview/wishlist-2/"><span class="action-wrapper">
               <i class="icons icon-heart-empty"></i>
               <span class="action-name">View Wishlist</span></span></a></span><span class="add-to-favorites yith-wcwl-wishlistexistsbrowse" style="display:none"><a href="http://velikorodnov.com/dev/homeshop_preview/wishlist-2/"><span class="action-wrapper">
               <i class="icons icon-heart-empty"></i>
               <span class="action-name">View Wishlist</span></span></a></span>		   
               <span class="add-to-compare">
                  <span class="action-wrapper">
                     <i class="icons icon-docs"></i>
                     <span class="action-name">
                        <div class="woo_compare_button_container">
                           <a class="woo_bt_compare_this woo_bt_compare_this_link " id="woo_bt_compare_this_127">Add To Compare</a>
                           <div style="clear:both;"></div>
                           <a class="woo_bt_view_compare  woo_bt_view_compare_link " href="http://velikorodnov.com/dev/homeshop_preview/product-comparison-2/" target="_blank" alt="" title="" style="display:none;">View Compare →</a><input type="hidden" id="input_woo_bt_compare_this_127" name="product_compare_127" value="127">
                        </div>
                     </span>
                  </span>
               </span>
            </div>
            <div class="woo_grid_compare_button_container"><a class="woo_bt_compare_this woo_bt_compare_this_button " id="woo_bt_compare_this_127">Compare This</a><input type="hidden" id="input_woo_bt_compare_this_127" name="product_compare_127" value="127"></div>
         </li>
		 <?php endforeach;?>
		  <?php echo $this->load->view('pagenation_links');?>
      </ul>
   </div>
</section>
<?php endif;?>
<!-- Sidebar -->
<aside class="sidebar right-sidebar col-lg-3 col-md-3 col-sm-3">
   <div class="row products-row sidebar-box  purple">
      <div class="col-lg-12 col-md-12 col-sm-12">
         <!-- Carousel Heading -->
         <div class="carousel-heading no-margin">
            <h4><i class="icons  icon-star"></i>Advertisments</h4>
         </div>
         <!-- /Carousel Heading -->
      </div>
      <!-- Carousel -->
      <div class="carousel owl-carousel-wrap col-lg-12 col-md-12 col-sm-12">
         <div class="owl-carousel owl-theme owl-carousel43 " data-max-items="1" style="opacity: 1; display: block;">
            <!-- Slide -->
            <div class="owl-wrapper-outer">
               <div class="owl-wrapper" style="width: 600px; left: 0px; display: block;">
                  <div class="owl-item" style="width: 300px;">
                     <div>
                        <!-- Carousel Item -->
                        <div class="product">
                           <div class="product-image">
                              <img width="270" height="270" src="http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-270x270.jpg" class="attachment-th-shop size-th-shop wp-post-image" alt="q1" srcset="http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-270x270.jpg 270w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-150x150.jpg 150w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-300x300.jpg 300w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-158x158.jpg 158w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-90x90.jpg 90w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12.jpg 800w" sizes="(max-width: 270px) 100vw, 270px">				
                              <a href="http://velikorodnov.com/dev/homeshop_preview/product/covers/" class="product-hover">
                              <i class="icons icon-eye-1"></i> Quick View				</a>
                           </div>
                           <div class="product-info">
                              <h5><a href="http://velikorodnov.com/dev/homeshop_preview/product/covers/">Smart Tab</a></h5>
                              <span class="price"><del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>87.00</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>80.00</span></ins></span>
                              <div class="rating readonly-rating" data-score="3" title="regular" style="width: 100px;"><img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-on.png" alt="1" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-on.png" alt="2" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-on.png" alt="3" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-off.png" alt="4" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-off.png" alt="5" title="regular"><input type="hidden" name="score" value="3" readonly="readonly"></div>
                           </div>
                           <div class="product-actions">
                              <span class="add-to-cart current"><a href="/dev/homeshop_preview/product-category/cameras/discs/cell-phones/?add-to-cart=140" rel="nofollow" data-quantity="1" data-product_id="140" data-product_sku="7355465" class="add_to_cart_button product_type_simple"><span class="action-wrapper">
                              <i class="icons icon-basket-2"></i>
                              <span class="action-name">Add to cart</span>
                              </span></a></span><span class="add-to-favorites yith-wcwl-add-button"><a href="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/admin/yith_wishlist/yith-wcwl-ajax.php?action=add_to_wishlist&amp;add-to-wishlist=140" data-product-id="140" data-product-type="simple" class="add_to_wishlist"><span class="action-wrapper">
                              <i class="icons icon-heart-empty"></i><span class="action-name">Add to Wishlist</span></span></a><img src="http://velikorodnov.com/dev/homeshop_preview/wp-admin/images/wpspin_light.gif" class="ajax-loading" id="add-items-ajax-loading" alt="" style="visibility:hidden"></span><span class="add-to-favorites yith-wcwl-wishlistaddedbrowse" style="display:none;"><a href="http://velikorodnov.com/dev/homeshop_preview/wishlist-2/"><span class="action-wrapper">
                              <i class="icons icon-heart-empty"></i>
                              <span class="action-name">View Wishlist</span></span></a></span><span class="add-to-favorites yith-wcwl-wishlistexistsbrowse" style="display:none"><a href="http://velikorodnov.com/dev/homeshop_preview/wishlist-2/"><span class="action-wrapper">
                              <i class="icons icon-heart-empty"></i>
                              <span class="action-name">View Wishlist</span></span></a></span>		   
                              <script type="text/javascript">
                                 // if( !jQuery( '#yith-wcwl-popup-message' ).length ) {
                                     // jQuery( 'body' ).prepend('<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>');
                                 // }
                              </script>
                              <span class="add-to-compare">
                                 <span class="action-wrapper">
                                    <i class="icons icon-docs"></i>
                                    <span class="action-name">
                                       <div class="woo_compare_button_container">
                                          <a class="woo_bt_compare_this woo_bt_compare_this_link " id="woo_bt_compare_this_140">Add To Compare</a>
                                          <div style="clear:both;"></div>
                                          <a class="woo_bt_view_compare  woo_bt_view_compare_link " href="http://velikorodnov.com/dev/homeshop_preview/product-comparison-2/" target="_blank" alt="" title="" style="display:none;">View Compare →</a><input type="hidden" id="input_woo_bt_compare_this_140" name="product_compare_140" value="140">
                                       </div>
                                    </span>
                                 </span>
                              </span>
                           </div>
                        </div>
                        <!-- /Carousel Item -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Slide -->
         </div>
      </div>
   </div>
</aside>
<!-- Sidebar -->
<aside class="sidebar right-sidebar col-lg-3 col-md-3 col-sm-3">
   <div class="row products-row sidebar-box  purple">
      <div class="col-lg-12 col-md-12 col-sm-12">
         <!-- Carousel Heading -->
         <div class="carousel-heading no-margin">
            <h4><i class="icons  icon-star"></i>Advertisments</h4>
         </div>
         <!-- /Carousel Heading -->
      </div>
      <!-- Carousel -->
      <div class="carousel owl-carousel-wrap col-lg-12 col-md-12 col-sm-12">
         <div class="owl-carousel owl-theme owl-carousel43 " data-max-items="1" style="opacity: 1; display: block;">
            <!-- Slide -->
            <div class="owl-wrapper-outer">
               <div class="owl-wrapper" style="width: 600px; left: 0px; display: block;">
                  <div class="owl-item" style="width: 300px;">
                     <div>
                        <!-- Carousel Item -->
                        <div class="product">
                           <div class="product-image">
                              <img width="270" height="270" src="http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-270x270.jpg" class="attachment-th-shop size-th-shop wp-post-image" alt="q1" srcset="http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-270x270.jpg 270w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-150x150.jpg 150w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-300x300.jpg 300w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-158x158.jpg 158w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12-90x90.jpg 90w, http://velikorodnov.com/dev/homeshop_preview/wp-content/uploads/2014/06/q12.jpg 800w" sizes="(max-width: 270px) 100vw, 270px">				
                              <a href="http://velikorodnov.com/dev/homeshop_preview/product/covers/" class="product-hover">
                              <i class="icons icon-eye-1"></i> Quick View				</a>
                           </div>
                           <div class="product-info">
                              <h5><a href="http://velikorodnov.com/dev/homeshop_preview/product/covers/">Smart Tab</a></h5>
                              <span class="price"><del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>87.00</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>80.00</span></ins></span>
                              <div class="rating readonly-rating" data-score="3" title="regular" style="width: 100px;"><img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-on.png" alt="1" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-on.png" alt="2" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-on.png" alt="3" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-off.png" alt="4" title="regular">&nbsp;<img src="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/js/img/star-off.png" alt="5" title="regular"><input type="hidden" name="score" value="3" readonly="readonly"></div>
                           </div>
                           <div class="product-actions">
                              <span class="add-to-cart current"><a href="/dev/homeshop_preview/product-category/cameras/discs/cell-phones/?add-to-cart=140" rel="nofollow" data-quantity="1" data-product_id="140" data-product_sku="7355465" class="add_to_cart_button product_type_simple"><span class="action-wrapper">
                              <i class="icons icon-basket-2"></i>
                              <span class="action-name">Add to cart</span>
                              </span></a></span><span class="add-to-favorites yith-wcwl-add-button"><a href="http://velikorodnov.com/dev/homeshop_preview/wp-content/themes/homeshop/admin/yith_wishlist/yith-wcwl-ajax.php?action=add_to_wishlist&amp;add-to-wishlist=140" data-product-id="140" data-product-type="simple" class="add_to_wishlist"><span class="action-wrapper">
                              <i class="icons icon-heart-empty"></i><span class="action-name">Add to Wishlist</span></span></a><img src="http://velikorodnov.com/dev/homeshop_preview/wp-admin/images/wpspin_light.gif" class="ajax-loading" id="add-items-ajax-loading" alt="" style="visibility:hidden"></span><span class="add-to-favorites yith-wcwl-wishlistaddedbrowse" style="display:none;"><a href="http://velikorodnov.com/dev/homeshop_preview/wishlist-2/"><span class="action-wrapper">
                              <i class="icons icon-heart-empty"></i>
                              <span class="action-name">View Wishlist</span></span></a></span><span class="add-to-favorites yith-wcwl-wishlistexistsbrowse" style="display:none"><a href="http://velikorodnov.com/dev/homeshop_preview/wishlist-2/"><span class="action-wrapper">
                              <i class="icons icon-heart-empty"></i>
                              <span class="action-name">View Wishlist</span></span></a></span>		   
                              <script type="text/javascript">
                                 // if( !jQuery( '#yith-wcwl-popup-message' ).length ) {
                                     // jQuery( 'body' ).prepend('<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>');
                                 // }
                              </script>
                              <span class="add-to-compare">
                                 <span class="action-wrapper">
                                    <i class="icons icon-docs"></i>
                                    <span class="action-name">
                                       <div class="woo_compare_button_container">
                                          <a class="woo_bt_compare_this woo_bt_compare_this_link " id="woo_bt_compare_this_140">Add To Compare</a>
                                          <div style="clear:both;"></div>
                                          <a class="woo_bt_view_compare  woo_bt_view_compare_link " href="http://velikorodnov.com/dev/homeshop_preview/product-comparison-2/" target="_blank" alt="" title="" style="display:none;">View Compare →</a><input type="hidden" id="input_woo_bt_compare_this_140" name="product_compare_140" value="140">
                                       </div>
                                    </span>
                                 </span>
                              </span>
                           </div>
                        </div>
                        <!-- /Carousel Item -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Slide -->
         </div>
      </div>
   </div>
</aside>
						</div>
					</div>
				</div>
			</div>