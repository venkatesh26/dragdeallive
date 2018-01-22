<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; 
foreach($results as $keys=>$datas)
{
	$link=$datas['link'];
	echo '<url>';
	echo'<loc>'.$link.'</loc>';
	echo'</url>';  	
}
echo'</urlset>';