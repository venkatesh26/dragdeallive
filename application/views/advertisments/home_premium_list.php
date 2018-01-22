<?php if(count($home_premium_listing)  > 0):
$plans=array('1'=>'Basic','2'=>'Bronze','3'=>'Sliver','4'=>'Gold','5'=>'Platinum')
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers.css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/themes/css/offers_new.css"/>
<div class="td-pb-row">
<div class="td-pb-span12 td-main-content home-coupon-list">
 <h4 class=block-title><span>DragDeal Premium Bussiness</span></h4>
<div id="popular" class="itsOffersTab loaded">
            <div class="divBoxes row">
                <div class="boxes marginLRAuto" style="height:450px;">
				<?php foreach($home_premium_listing as $result):
				 $link=base_url(). 'business'. '/'.$result[ 'id']. '/'.url_title(strtolower($result[ 'name'])). '/'.url_title(strtolower($result[ 'city_name']));
				$image='';
				if(isset($result['profile_image']) && !empty($result['image_dir']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
				{
					$img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'240','160','coupon_list_thumb');
					$image = base_url().$result['image_dir'].'coupon_list_thumb/'.$img_src;
				}
				?>
				<div class="offerBox" style="position: relative; width: 230px !important; top: 0px; box-shadow: rgba(0, 0, 0, 0.33) 0px 1px 3px 0px;">
					<div class="offer">				
					<a href="<?php echo $link;?>" target="_blank" class="offerName" title="<?php echo ucwords($result['name']);?>">
					
					<h3 class="offerTitleSpan premimum-title">
					<?php echo ucwords(substr($result['name'],0,20))."..., ";?><br/><?php echo ucwords(htmlentities(nl2br($result['area_name'])))." , ".ucwords(htmlentities(nl2br($result['city_name'])));?></h3>
					<hr class="marginTB5">
					
						<span class="off"><?php echo $plans[$result['plan_id']];?></span>
					
						<div class="offerImage zoom-gallery" style="height: 140px">
						<?php if($image!=''):?>
						<img alt="<?php echo ucwords($result['name']);?>" class="img-responsive growZoom imgOfferImage" src="<?php echo $image;?>">
						<?php else:?>
						<div class="custom_image custom_image_home">
  <p class="image_class_A"><?php echo substr(trim(ucwords($result['name'])),0,1);?></p>
</div>
						<?php endif;?>
						</div>
					</a>					
					
					</div>
					<hr class="marginTB5">
					<div class="offerPriceDiv">
						<div class="td-review-final-star">
							<?php 
							$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;?>
							<?php 
							   echo number_format($totalScore,1)." / ";
								for($i=$totalScore;$i>=1;$i--):
									echo "<i class='fa fa-star'></i>";
								endfor;
								for($i=5-$totalScore;$i>=1;$i--):
									echo "<i class='fa fa-star-o'></i>";
								endfor;
							?>
						</div>
					</div>
					<div class="socialToolbar"><a href="<?php echo $link;?>" target="_blank" class="buyOnlineLink btn btn-orange"><i class="fa fa-shopping-bag"></i>View More</a></div>
					</div>
		<?php endforeach;?>
            </div>
        </div>
</div>
</div>
</div>
<?php endif;?>