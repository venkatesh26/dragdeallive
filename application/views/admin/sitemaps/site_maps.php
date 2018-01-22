<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; 
foreach($results['listings'] as $key=>$result)
{
echo '<url>';
$link=base_url().'business'.'/'.$result['id'].'/'.url_title(strtolower($result['add_name'])).'/'.url_title(strtolower($result['city_name']));
echo'<loc>'.$link.'</loc>'; 
echo'</url>';		
}
echo'</urlset>';