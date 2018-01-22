<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers_new.css"/>
<style>
div.td-head-form-search-wrap input{
 margin-bottom: 0px !important;
}
</style>	
<div class="td-category-header">
<div class="td-container">
<div class="td-pb-row">
<div class="td-pb-span12">
<?php  
	/************ Bread Crumb *****************/
	echo $this->load->view('bread_crumb',array(),true);
?>
<div>
<style>
div.coupon-form-fields input
{
	width:170px;
}
</style>

<?php
$keyword=(isset($_GET['keyword']) && $_GET['keyword']!='') ? $_GET['keyword'] : '';
$city=(isset($_GET['coupon_city']) && $_GET['coupon_city']!='') ? $_GET['coupon_city'] : '';
$area=(isset($_GET['coupon_area']) && $_GET['coupon_area']!='') ? $_GET['coupon_area'] : '';
$coupon_percentage=(isset($_GET['coupon_percentage']) && $_GET['coupon_percentage']!='') ? $_GET['coupon_percentage'] : '';
?>
<div class="td-drop-down-search td-drop-down-search-open" aria-labelledby="td-header-search-button">
<form method="GET" class="td-coupon-search-form" action="<?php  echo base_url().'coupons/index/';?>">
	<div role="search" class="td-head-form-search-wrap">
	<div class="coupon-form-fields">
		<input id="coupon_keyword" class="td-login-input" placeholder="Enter Keyword" type="text" value="<?php echo $keyword;?>" name="keyword" autocomplete="off">
		<input id="coupon_city" placeholder="Enter City"  type="text" value="<?php echo $city;?>" name="coupon_city" autocomplete="off">
		<input id="coupon_city_id" type="hidden">
		<input id="coupon_area" placeholder="Enter Area"  type="text" value="<?php echo $area;?>" name="coupon_area" autocomplete="off">
		<input class="wpb_button wpb_btn-inverse btn btn-md" type="submit" id="td-header-search-top" value="Search">
	</div>
</form>
<div id="td-aj-search"></div>
</div>
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


<div class="td-pb-span12 td-main-content home-coupon-list">

<div class="td-ss-main-content"><div class="clearfix"></div>
<div id="popular" class="itsOffersTab loaded">
            <div class="divBoxes row">
                <div class="boxes marginLRAuto" style="height:450px;">
				
				<?php foreach($list['listings'] as $result):
				$link=base_url().'coupons'.'/'.$result['id'].'/'.url_title(strtolower($result['name']));
				$image=base_url().'assets/themes/images/281-218x150.png';
				if(isset($result['profile_image']) && !empty($result['image_dir']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
				{
					$img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'240','160','coupon_list_thumb');
					$image = base_url().$result['image_dir'].'coupon_list_thumb/'.$img_src;
				}
				$address = $result['address_line']." ,".$result['city_name']." ,".$result['area_name']; 
				?>
				<div class="offerBox" style="position: relative; width: 240px !important; top: 0px; box-shadow: rgba(0, 0, 0, 0.33) 0px 1px 3px 0px;">
					<div class="offer">
					<a class="divStoreNameLink" target="_blank" 
					href="#" title="<?php echo ucwords($result['add_name']);?>">
						<div>
							<div class="storeThumnail"><img alt="<?php echo ucwords($result['add_name']);?>" style="height: 35px;" src="<?php echo $image;?>" class="img-circle"></div><div><span class="storeNameLink txtEllipsis"><?php echo ucwords($result['add_name']);?></span><span class="storeStreetName txtEllipsis"><i class="fa fa-map-marker"></i> <?php echo $address;?>							
							</span></div>
						</div>
					</a>
					
					<hr class="marginTB5">
					
						<a href="<?php echo $link;?>" target="_blank" class="offerName" title="<?php echo ucwords($result['name']);?>">
					
					<h3 class="offerTitleSpan">
					<?php echo ucwords($result['name']);?></h3>
					<?php if($result['offer_type']==2 && $result['percentage'] > 0):?>
						<span class="off"><?php echo $result['percentage']; ?> %</span>
						<?php elseif($result['offer_type']==1 && $result['offer_price'] > 0):?>
						<span class="off"><strike>Rs. <?php echo $result['original_price']; ?></strike><br>Rs.<?php echo $result['offer_price']; ?> </span>
					<?php endif;?>
					
						<div class="offerImage zoom-gallery" style="height: 187px">
						
						<img alt="<?php echo ucwords($result['name']);?>" class="img-responsive growZoom imgOfferImage" src="<?php echo $image;?>">
						
						</div>
					</a>
									
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
						<?php if($result['offer_type']==2 && $result['percentage'] > 0):?>
						<span class="offerPrice txtEllipsis"><?php echo $result['percentage']; ?>% Off</span>
						<?php elseif($result['offer_type']==1 && $result['offer_price'] > 0):?>
						
						<span class="offerPrice txtEllipsis">Rs. <?php echo $result['offer_price']; ?></span>
						<?php endif;?>
						
						<div class="offerTime txtEllipsis"><i class="fa fa-clock-o"></i>&nbsp;<span class="snoToolTip" title="" data-original-title="offer&nbsp;expires&nbsp;in"><?php echo couponsDaysLeft($result['exipry_date']);?></span></div>
					</div>
					
					<div class="offerDescDiv"><hr class="marginTB5"><div class="offerText"><?php echo $result['short_description']; ?></div></div>
					
					</div>
					
					<div class="socialToolbar"><a href="<?php echo $link;?>" target="_blank" class="buyOnlineLink btn btn-orange" title="Get this Offer for Free!"><i class="fa fa-shopping-bag"></i> Get this Offer</a></div>
					
					</div>
					
		<?php endforeach;?>
	
            </div>
        </div>
</div>
	<?php echo $this->load->view('pagenation_links',array(),true);?>
</div>
</div>
</div>
</div>
</div>