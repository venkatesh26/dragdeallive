
<?php
foreach($results['listings'] as $key=>$result)
{
$link=base_url().'business'.'/'.$result['id'].'/'.url_title(strtolower($result['add_name'])).'/'.url_title(strtolower($result['city_name']));
?>
<a href="<?php echo $link;?>" style="font-size:20px;"><?php echo $result['add_name'];?></a></br>
<?php
}
?>