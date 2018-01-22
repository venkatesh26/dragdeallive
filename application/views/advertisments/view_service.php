<?php if(count($service_data) > 0):?>
<div class="td-post-sharing td-post-sharing-bottom td-with-like">
	<div class="td-post-source-tags">
		<div class="td-post-source-via td-no-tags">
			<div class="td-post-small-box">
				<h3><strong class="review-overview-title">Service Offered</strong></h3>
				<?php foreach($service_data as $datas){ $city_name=strtolower($datas[ 'city_name']); $area_name=strtolower($datas[ 'area_name']); $cat_name=strtolower($datas[ 'category_name']); $link_cat=base_url(). 'service-search/'.url_title(strtolower($cat_name)). '/'.strtolower(url_title($city_name)). '/'.strtolower(url_title($area_name));?>
				<a href="<?php echo $link_cat;?>" rel="nofollow">
					<?php echo ucwords($cat_name);?>
				</a>
				<?php }?>
			</div>
		</div>
	</div>
</div>
<?php endif;?>