	<div class="addcomments">
													
													<form id="user-add-comment" class="user-add-comment" action="<?php echo base_url().'comments/add_comment';?>" method="post">
													<div class="user-ratings">
													<label>Rate Now:</label>
														<ul id="jquery_rating" class="comment-rating" style="width:auto">
														</ul>
													</div>
													<span class="login-error cust-error"></span>
													<input type="text" class="input" placeholder="Enter Your Title" name="title">
														<textarea name="comments" placeholder="Enter Your Comments"></textarea>
													<input type="hidden" name="advertisment_id" value="<?php echo $advertisment_id;?>">
														<input type="submit" value="Post Comment">
													</form>
	</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.raty.js"></script>
<script script="text/javascript">
rating_script();
function rating_script()
{
   $.fn.raty.defaults.path = __cfg('path_absolute') + 'assets/images';
   $('#jquery_rating').raty();	
}
</script>