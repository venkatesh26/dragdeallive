<meta charset=UTF-8 />
<meta name=viewport content="width=device-width, initial-scale=1.0">
<?php
if(isset($meta_keywords) && isset($meta_des) ):
$meta_keywords=$meta_keywords;
$meta_des=$meta_des;
else:
$meta_datas=admin_settings_initialize('meta_words');
$meta_keywords=$meta_datas['Keywords'];
$meta_desr=$meta_datas['description'];
endif;
$meta_title=(isset($title_of_layout) && $title_of_layout!='')?$title_of_layout:$meta_keywords;	
$meta_des=(isset($title_of_description) && $title_of_description!='')?$title_of_description:$meta_desr;	
$meta_keywords=(isset($title_of_meta_keywords) && $title_of_meta_keywords!='')?$title_of_meta_keywords:$meta_keywords;	
$meta_og_image=(isset($meta_og_image) && $meta_og_image!='') ? $meta_og_image: base_url().'assets/themes/images/new_logo.png';	
?>
<title><?php echo $meta_title;?></title> 
<meta name="description" content="<?php echo $meta_des;?>"/>
<meta property="og:title" content="<?php echo $meta_title;?>" />
<meta property="og:url" content="<?php  echo 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];?>"/>
<meta property="og:image" content="<?php echo $meta_og_image;?>"/>