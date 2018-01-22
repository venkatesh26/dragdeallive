<div class="td-pb-span4 td-main-sidebar">
<div class="td-ss-main-sidebar" style="width: auto; position: static; top: auto; bottom: auto;">
<div class="clearfix"></div>
<div class="td-a-rec td-a-rec-id-sidebar ">
<span class="td-adspot-title">- Advertisement -</span>
<div class="td-visible-desktop">
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
<div class="td-visible-tablet-landscape">
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
<div class="td-visible-tablet-portrait">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- newtheme customsize1 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:200px;height:200px"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="3800224475"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<div class="td-visible-phone">
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
<aside class="widget widget_recent_entries"> <div class="block-title"><span>Find Us in Map</span></div>
<div>
<?php
$my_adress="Chennai";
$title="Dialbe";
if(isset($result['name'])){
	$title=$result['name'];
}
if(isset($result['address_line'])){
$my_adress=$result['address_line'];
	if($result['address_line']!='')
	{
		if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).','.ucwords($result['city_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['area_name']=='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['city_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['areas']=='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['areas']).'-'.$result['zip'];
		}
	}
}
?>
<div class="map_canvas" id="map_canvas" style="height: 250px;width: 100%;margin-top: 20px;border: 1px solid #ccc;padding: 5px;"  data-address="<?php echo $my_adress;?>"   data-title="<?php echo 'Chennai';?>"></div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDEzS87sF3Q5nxXcLqugUJAp0hGzQS2mTk"></script>
</aside>

<aside class="widget widget_recent_entries"> <div class="block-title"><span>Related Coupons</span></div> <ul>

							<?php 
							foreach($category_list as $my_list):
							if(empty($cookie_city))
							{
								if(!empty($_GET['city']))
								{
									$cookie_city=strtolower($_GET['city']);
								}
								else if($this->uri->segment('1')=='search' && $this->uri->segment('2')!='')
								{
									$cookie_city=strtolower($this->uri->segment('2'));
								}
								else if($this->uri->segment('1')=='category-search' && $this->uri->segment('3')!='')
								{
									$cookie_city=strtolower($this->uri->segment('3'));
								}
								else if($this->uri->segment('1')=='mysearch' && $this->uri->segment('5')!='')
								{
									$cookie_city=strtolower($this->uri->segment('5'));
								}
								else
								{
								   $cookie_city="";
								}
							}
							?>
								<li><a href="<?php echo base_url().'category-search/'.url_title(strtolower($my_list['name'])).'/'.$cookie_city;?>" title="<?php echo ucwords($my_list['name']);?>"><i class="fa fa-arrow-right"></i> <?php echo ucwords($my_list['name']);?></a></li>
							<?php endforeach;?>
</ul>
</aside> 

<div class="clearfix"></div>
</div>
</div>