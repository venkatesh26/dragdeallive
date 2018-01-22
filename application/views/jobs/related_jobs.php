<div class="td-pb-span4 td-main-sidebar">
<div class="td-ss-main-sidebar" style="width: auto; position: static; top: auto; bottom: auto;">
<div class="clearfix"></div>
<aside class="widget_categories view_page_section1">
<div>
<h3 class="entry-title td-page-title" style="display:block;background-color:#29c065;padding:3px;color:#fff;text-align:center;"> Advertisements</h3>
</div>

<div style="height:250px !important;">
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
</aside>

<aside style="margin-top:10px;" class="widget widget_recent_entries"> <div class="block-title"><span>Related Jobs</span></div> <ul>
<?php 
foreach($related_jobs as $my_list):
?>
<li><a href="<?php echo base_url().'jobs/'.$my_list['id'].'/'.url_title(strtolower($my_list['name'])).'/'.url_title(strtolower($my_list['city']));?>" title="<?php echo ucwords($my_list['name']);?>"><i class="fa fa-arrow-right"></i> <?php echo ucwords($my_list['name']);?></a></li>
<?php endforeach;?>
</ul>
</aside> 
</div>
</div>