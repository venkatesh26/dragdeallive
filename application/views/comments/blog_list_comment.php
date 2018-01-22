<div class="detail-review-list">
	<ul>
		<?php if(!empty($user_comments)):
	          foreach($user_comments as $comments):
		?>	
				<li>
	                <div class="rev-img">
						<img src="<?php echo base_url().'assets/images/user1.jpg';?>" alt="friend1">
					</div>
					<div class="rev-text">
					<h3><?php echo ucwords(htmlentities(nl2br($comments['first_name'])));?></h3>
					<div class="review-detail-prof-share">
					<div class="user-ratings">
																	<ul>
																	<?php
																	$rating=$comments['rating'];
																	for($i=1;$i<=$rating;$i++):
																	 echo "<li class='rated'>Star</li>";
																	endfor;
																	for($i=abs($rating-5);$i>=1;$i--):
																	 echo "<li>Star</li>";
																	endfor;
																	?>
																	</ul>
																</div>
						<ul>
						<li class="rev-post-date"><?php echo date('d M Y',strtotime($comments['created']));?></li>
						</ul>
					</div>
					<div class="comment-title">
					<h3><?php echo ucwords(htmlentities(nl2br($comments['title'])));?></h3>
					</div>
					<p><?php echo htmlentities(nl2br($comments['comments']));?></p>
				</div>
				</li>
		<?php 
		endforeach;
		else:
		echo "<li>"."Be the First user to comment"."</li>";
		endif;?>
				</ul>
											</div>