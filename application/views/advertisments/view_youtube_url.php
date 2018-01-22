<?php 
$social_media = @unserialize($result['other_info']);
$youtube_url=(isset($social_media['youtube_url']) && $social_media['youtube_url']!='') ? $social_media['youtube_url'] : '';
if($youtube_url!=''):
function youtube($string,$autoplay=0,$width=480,$height=390)
{
    preg_match('#(?:http://)?(?:www\.)?(?:youtube\.com/(?:v/|watch\?v=)|youtu\.be/)([\w-]+)(?:\S+)?#', $string, $match);
	if(isset($match[1])):
	$match_data=$match[1];
    $embed = <<<YOUTUBE
	<div class="td-post-sharing td-post-sharing-bottom td-with-like">
		<div class="td-post-source-tags">
			<div class="td-post-source-via td-no-tags">
				<div class="td-post-small-box">
		<h3><strong class="review-overview-title">Video</strong></h3>
        <div align="center">
            <iframe title="YouTube video player" width="$width" height="$height" src="http://www.youtube.com/embed/$match_data?autoplay=$autoplay" frameborder="0" allowfullscreen></iframe>
        </div>
		</div>
			</div>
		</div>
	</div>
	</div>
YOUTUBE;
    return str_replace($match[0], $embed, $string);
	else:
	return '';
	endif;
}
?>

			
			
				<?php echo youtube($youtube_url,0,650,315);?>
		

<?php endif;?>


