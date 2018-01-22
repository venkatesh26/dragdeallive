<style>
.view_page_section_height{
min-height:250px;
}
</style>
<div class="td-pb-span4 td-main-sidebar">
<div class="td-ss-main-sidebar" style="width: auto; position: static; top: auto; bottom: auto;">
<div class="clearfix"></div>

    <?php if($this->detect->isMobile() || $this->detect->isTablet()):?>	

<?php else:?>
<aside class="widget_categories view_page_section1 view_page_section_height">

<h3 class="entry-title td-page-title" style="display:block;background-color:#29c065;padding:3px;color:#fff;text-align:center;"> Advertisements</h3>
	<div class="td-a-rec td-a-rec-id-sidebar ">
	   <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- Link ads -->
								<ins class="adsbygoogle"
									 style="display:block"
									 data-ad-client="ca-pub-2739505616311307"
									 data-ad-slot="8317491279"
									 data-ad-format="link"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
								
								<br/>
	    
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- newtheme customsize -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="2323491279"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</aside>
<?php endif;?>       
<aside class="widget widget_recent_entries" style="margin-top:80px!important;">
<?php 
$social_media = @unserialize($result['other_info']);
$youtube_url=(isset($social_media['youtube_url']) && $social_media['youtube_url']!='') ? $social_media['youtube_url'] : '';
if($youtube_url!=''):
function youtube($string,$autoplay=0,$width=350,$height=250)
{
$matchData=preg_match('#(?:https://)?(?:www\.)?(?:youtube\.com/(?:v/|watch\?v=)|youtu\.be/)([\w-]+)(?:\S+)?#', $string, $match);
if(isset($match[1])):
$url='https://www.youtube.com/embed/'.$match[1].'?autoplay='.$autoplay;
$embed ='<div align="center">
		<iframe title="YouTube video player" width="'.$width.'" height="'.$height.'" src="'.$url.'" frameborder="0" allowfullscreen></iframe>
	</div>';
return str_replace($match[0], $embed, $string);
else:
return '';
endif;
}
?>
				<?php echo youtube($youtube_url,0,350,250);?>
<?php endif;?>




</aside>

<div class="clearfix"></div>
</div>
</div>