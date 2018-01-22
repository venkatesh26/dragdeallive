     <div id="comments" class="comments">
                            <div class="comment-respond" id="respond">
                                <h3 class="comment-reply-title" id="reply-title">LEAVE A COMMENT</h3>
                                <form class="comment-form" id="user-add-comment" method="post" action="<?php echo base_url().'comments/add_blog_comment';?>">
                                    <div class="clearfix"></div>
									<p class="comment-form-input-wrap">
                                        <span class="comment-req-wrap">
										<input type="text" size="30" value="" placeholder="Title:" name="title" id="title" class=""></span>
                                    </p>
                                    <p class="comment-form-input-wrap">
                                        <textarea aria-required="true" rows="8" cols="45" name="comments" id="comments" placeholder="Comment:"></textarea>
                                    </p>
									<input type="hidden" name="new_score" value="0" id="new_score">
									<p class="comment-form-input-wrap">
									<label>Rate Us</label>
								<div class="stars">
									<input type="radio" name="score" class="star-1" id="star-1" data-score="1"/>
									<label class="star-1" for="star-1">1</label>
									<input type="radio" name="score" class="star-2" id="star-2"  data-score="2"/>
									<label class="star-2" for="star-2">2</label>
									<input type="radio" name="score" class="star-3" id="star-3"  data-score="3"/>
									<label class="star-3" for="star-3">3</label>
									<input type="radio" name="score" class="star-4" id="star-4"  data-score="4"/>
									<label class="star-4" for="star-4">4</label>
									<input type="radio" name="score" class="star-5" id="star-5" data-score="5"/>
									<label class="star-5" for="star-5">5</label>
									<span></span>
								
								</div>
									<span class="rate_it_error"></span>
									</p>
                                    <p class="form-submit">
									    <input type="hidden" name="blog_id" value="<?php echo $blog_id;?>">
										<?php if(!$this->session->userdata('is_user_logged_in')):?>
									   <a class="postcomment-button" href="<?php echo base_url().'register';?>">Post Comment</a>
										<?php else:?>
										<input type="submit" value="Post Comment" class="submit comment-submit-button" id="submit" name="submit">
										<?php endif;?>
                                    </p>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>