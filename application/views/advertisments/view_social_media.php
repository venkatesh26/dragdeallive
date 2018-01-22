<?php 
$notification_settings = @unserialize($result['notification_settings']);
$social_media = @unserialize($result['other_info']);
$facebook_url=(isset($social_media['facebook_url']) && $social_media['facebook_url']!='') ? $social_media['facebook_url'] : '';
$googleplus_url=(isset($social_media['googleplus_url']) && $social_media['googleplus_url']!='') ? $social_media['googleplus_url'] : '';
$twitter_url=(isset($social_media['twitter_url']) && $social_media['twitter_url']!='') ? $social_media['twitter_url'] : '';
$linkedin_url=(isset($social_media['linkedin_url']) && $social_media['linkedin_url']!='') ? $social_media['linkedin_url'] : '';
$youtube_url=(isset($social_media['youtube_url']) && $social_media['youtube_url']!='') ? $social_media['youtube_url'] : '';
$whatsup_contact_number=(isset($social_media['whatsup_contact_number']) && $social_media['whatsup_contact_number']!='') ? $social_media['whatsup_contact_number'] : '';
$enable_social_media=(isset($notification_settings['social_media']) && $notification_settings['social_media']==1) ? $notification_settings['social_media'] : 0;
if(($facebook_url!='' || $googleplus_url!='' || $twitter_url!='' || $linkedin_url!='')):?>
<div class="td-post-sharing td-post-sharing-bottom td-with-like"><span class="td-post-share-title1">Follow Us in Social Media:</span>
<?php if($facebook_url):?>
<a href="<?php echo $facebook_url;?>" class="td-social-sharing-buttons td-social-facebook" target="_blank"><i class="fa fa-facebook"></i><div class="td-social-but-text">Facebook</div></a>
<?php endif;?>
<?php if($twitter_url):?>
<a href="<?php echo $twitter_url;?>" class="td-social-sharing-buttons td-social-twitter"  target="_blank"><i class="fa fa-twitter"></i><div class="td-social-but-text">Twitter</div></a>
<?php endif;?>
<?php if($linkedin_url):?>
 <a href="<?php echo $linkedin_url;?>" class="td-social-sharing-buttons td-social-pinterest" target="_blank"><i class="fa fa-linkedin"></i><div class="td-social-but-text">Linkedin</div></a>
<?php endif;?>
<?php if($googleplus_url):?>
 <a href="<?php echo $googleplus_url;?>" class="td-social-sharing-buttons td-social-google" target="_blank"><i class="fa fa-google-plus"></i><div class="td-social-but-text">Google</div></a>	
<?php endif;?>
<?php if($youtube_url):?>
 <a href="<?php echo $youtube_url;?>" class="td-social-sharing-buttons td-social-google" target="_blank"><i class="fa fa-youtube"></i><div class="td-social-but-text">Youtube</div></a>	
<?php endif;?>
</div>
<?php endif;?>