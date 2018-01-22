<div class="td-pb-span4 td-main-sidebar">
<div class="td-ss-main-sidebar" style="width: auto; position: static; top: auto; bottom: auto;">
<div class="clearfix"></div>
<aside class="widget_categories view_page_section">
<div>
<h3 class="entry-title td-page-title" style="display:block;background-color:#29c065;padding:3px;color:#fff;text-align:center;"> Advertisements</h3>
</div>
<div style="height:600px !important;">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- new_theme_large -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="7910852076"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
</aside>
<aside class="widget widget_recent_entries" style="margin-top:80px!important;"> <div class="block-title"><span>Related Categories</span></div> <ul>
<?php 
foreach($category_list as $my_list):
?>
<li><a href="<?php echo base_url().'blog-category-search/'.url_title(strtolower($my_list['name']));?>" title="<?php echo ucwords($my_list['name']);?>"><i class="fa fa-arrow-right"></i> <?php echo ucwords($my_list['name']);?></a></li>
<?php endforeach;?>
</ul>
</aside> 
<div class="clearfix"></div>
</div>
</div>