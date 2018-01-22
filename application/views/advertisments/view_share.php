<div class="td-post-sharing td-post-sharing-bottom td-with-like">
<span class="td-post-share-title">SHARE:</span>
<div class="td-default-sharing">
<?php $link='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];?>
	<a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo $link;?>&title='<?php echo ucwords($result['name']);?>" class="td-social-sharing-buttons td-social-facebook"><i class="fa fa-facebook"></i><div class="td-social-but-text">Facebook</div></a>
	<a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="https://twitter.com/intent/tweet?text=<?php echo substr($result['short_description'],0,50);?>&url=<?php echo $link;?>&;via=dialbe" class="td-social-sharing-buttons td-social-twitter"><i class="fa fa-twitter"></i><div class="td-social-but-text">Twitter</div></a>
	 <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $link;?>&title=<?php echo ucwords($result['name']);?>&summary=<?php echo ucwords($result['description']);?>&source=dialbe.com" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-linkedin"></i></a>
</div>
</div>