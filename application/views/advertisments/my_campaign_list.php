<?php 
$user_id=$result['user_id'];
$offer_list=getOfferCampaignlist($user_id);
?>
<?php if(count($offer_list)  > 0):?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers_new.css"/>
<div class="td-main-content-wrap">
<div class="td-container">
<div class="td-pb-row">
<div class="td-pb-span12 td-main-content home-coupon-list">
 <h4 class=block-title><span>Offers of the day</span></h4>
<div class="td-ss-main-content"><div class="clearfix"></div>
<div id="popular" class="itsOffersTab loaded">
            <div class="divBoxes row">
                <div class="boxes marginLRAuto" style="height:450px;">
				
				<?php foreach($offer_list as $result):
				$link=base_url().'offers'.'/'.$result['id'].'/'.url_title(strtolower($result['title']));
				$image=base_url().'assets/themes/images/281-218x150.png';
				if(isset($result['profile_image']) && !empty($result['image_dir']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
				{
					$img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'240','160','offer_list_thumb');
					$image = base_url().$result['image_dir'].'offer_list_thumb/'.$img_src;
				}
				?>
				<div class="offerBox" style="position: relative; width: 240px !important; top: 0px; box-shadow: rgba(0, 0, 0, 0.33) 0px 1px 3px 0px;">
					<div class="offer">					
					<a href="<?php echo $link;?>" target="_blank" class="offerName" title="<?php echo ucwords($result['title']);?>">
					
					<h3 class="offerTitleSpan premimum-title"><i class="fa fa-tag"></i>
					<?php echo ucwords($result['title']);?><br/></h3>
					<hr class="marginTB5">					
				
					<?php if($result['offer_type']==2 && $result['percentage'] > 0):?>
						<span class="off"><?php echo $result['percentage']; ?> %</span>
						<?php elseif($result['offer_type']==1 && $result['offer_price'] > 0):?>
						<span class="off"><strike>Rs. <?php echo $result['mrp_price']; ?></strike><br>Rs.<?php echo $result['offer_price']; ?> </span>
					<?php endif;?>
						<div class="offerImage zoom-gallery" style="height: 187px">
						
						<img alt="<?php echo ucwords($result['title']);?>" class="img-responsive growZoom imgOfferImage" src="<?php echo $image;?>">		
						</div>
					</a>					
					</div>
					<hr class="marginTB5">
					<div class="offerPriceDiv">
						<div class="td-review-final-star">
						<i class="fa fa-calendar"></i> <?php echo date('d, M Y',strtotime($result['campaign_start_date']));?> - <i class="fa fa-calendar"></i> <?php echo date('d, M Y',strtotime($result['campaign_end_date']));?> 								
						</div>
					</div>
					<div class="socialToolbar">
					<a href="<?php echo $link;?>" target="_blank" class="buyOnlineLink btn btn-orange" title="Get this Offer for Free!"><i style="color:#fff" class="fa fa-thumbs-up"></i> I Like this Offer</a></div>
					</div>
					
		<?php endforeach;?>
	
            </div>
        </div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php endif;?>