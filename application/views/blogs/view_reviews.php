<?php 
if(!empty($user_comments)):?>
  <h3><strong class="review-overview-title">Reviews</strong></h3>
<?php
foreach($user_comments as $comments):
$image= base_url().'assets/themes/images/message_avatar2.png';
if(!empty($comments['profile_image']) && file_exists('./'.$comments['image_dir'].$comments['profile_image']))
{
   $img_src = thumb(FCPATH.$comments['image_dir'].$comments['profile_image'],'150','150','review_list_thumb');
   $image = base_url().$comments['image_dir'].'review_list_thumb/'.$img_src;
}
?>	  
<div class="author-box-wrap">
	<a href="#"><img width="96" height="96" class="avatar avatar-96 wp-user-avatar wp-user-avatar-96 alignnone photo td-animation-stack-type0-2" alt="<?php echo $comments['first_name'];?>>" src="<?php echo $image;?>">
	</a>
	<div class="desc">
	<div class="td-author-name vcard author"><span class="fn"><a href="#"><?php echo ucwords(htmlentities(nl2br($comments['first_name'])));?></a></span>
	</div>
	<div class="td-review-final-star">
												<?php 
												$totalScore=$comments['rating'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
												?>
                                                </div>
	<div class="td-author-url"><a href="javascript:void(0);"><?php echo ucwords(htmlentities(nl2br($comments['title'])));?></a>
	</div>
	<div class="td-author-description"><?php echo htmlentities(nl2br($comments['comments']));?></div>
	<div class="clearfix"></div>
	</div>
</div> 							
<?php 
endforeach;
endif;
?>