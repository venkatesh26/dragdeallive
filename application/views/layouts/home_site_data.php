<div class="vc_row wpb_row td-pb-row">
						<?php $get_statistics_data=get_statistics_data();?>
                    <div class="wpb_column vc_column_container td-pb-span8">
                        <div class=wpb_wrapper>
                            <div class="td_block_wrap td_block_1  td-pb-border-top" data-td-block-uid=td_uid_14_57495b20bac2a>
                                <h4 class=block-title><span>Site Statistics</span></h4>
                                <div id=td_uid_14_57495b20bac2a class=td_block_inner>
								<table class="td-review"> <tbody> 
								<tr class="td-review-row-bars"> <td colspan="2"> <div class="td-review-details"> <div class="td-review-desc">Overall Review</div> <div class="td-review-percent"><?php echo $totalScore=$get_statistics_data['overall_score'] * 2;?></div> </div> <div class="td-rating-bar-wrap"> <div style="width:<?php echo $get_statistics_data['overall_score']* 20;?>%" class="theme1"></div> </div> </td> </tr><tr class="td-review-row-bars"> <td colspan="2"> <div class="td-review-details"> <div class="td-review-desc">Site Review</div> <div class="td-review-percent"><?php echo $totalScore=$get_statistics_data['site_score'] * 2;?></div> </div> <div class="td-rating-bar-wrap"> <div style="width:<?php echo $get_statistics_data['site_score']* 20;?>%" class="theme2"></div> </div> </td> </tr>
								<tr class="td-review-row-bars"> <td colspan="2"> <div class="td-review-details"> <div class="td-review-desc">User Review</div> <div class="td-review-percent"><?php echo $totalScore=$get_statistics_data['user_score'] * 2;?></div> </div> <div class="td-rating-bar-wrap"> <div style="width:<?php echo $get_statistics_data['user_score']*20;?>%" class="theme3"></div> </div> </td> </tr> 
							</tbody> 
							</table>
							<table class="td-review td-visible-desktop"> <tbody> 
								<tr class="td-review-footer rate_point">
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['overall_score'],1);?></div> 
										<div class="td-review-final-star">
											    <?php
												$totalScore=$get_statistics_data['overall_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;?>
										</div>
										<span class="new_review_title">Overall Score</span> </div>
										  <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_cities']);?></div><span class="new_review_title">Total Cities</span> 
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['user_score'],1);?></div> 
										<div class="td-review-final-star">
										<?php
												$totalScore=$get_statistics_data['user_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
										?>
										</div>
										<span class="new_review_title">User Score</span> </div>
										
										 <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_areas']);?></div><span class="new_review_title">Total Areas</span>
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_keywords']);?></div> 
										<div class="td-review-final-star"> </div>
										<span class="new_review_title">Total Keywords</span> </div>
										
										<div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_yellowpages']);?></div><span class="new_review_title">Total YellowPages</span>
									</div> 
								</td>									
								<td class="td-review-summary">
								<span class="block-title td-post-category-new-background">SUMMARY</span> 
								<div class="td-review-summary-content">We provides a excellent information services between local business and users in various cities across India. We Provide the most accurate data to users and businesses.</div> 
								</td> 
								</tr> 
							</tbody>
							</table>
							
							<table class="td-review td-visible-phone"> <tbody> 
								<tr class="td-review-footer rate_point">
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['overall_score'],1);?></div> 
										<div class="td-review-final-star">
											    <?php
												$totalScore=$get_statistics_data['overall_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;?>
										</div>
										<span class="new_review_title">Overall Score</span> </div>
										  <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_cities']);?></div><span class="new_review_title">Total Cities</span> 
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['user_score'],1);?></div> 
										<div class="td-review-final-star">
										<?php
												$totalScore=$get_statistics_data['user_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
										?>
										</div>
										<span class="new_review_title">User Score</span> </div>
										
										 <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_areas']);?></div><span class="new_review_title">Total Areas</span>
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_keywords']);?></div> 
										<div class="td-review-final-star"> </div>
										<span class="new_review_title">Total Keywords</span> </div>
										
										<div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_yellowpages']);?></div><span class="new_review_title">Total YellowPages</span>
									</div> 
								</td>									
								<td class="td-review-summary">
								<span class="block-title td-post-category-new-background">SUMMARY</span> 
								<div class="td-review-summary-content">We provides a excellent information services between local business and users in various cities across India. We Provide the most accurate data to users and businesses.</div> 
								</td> 
								</tr> 
							</tbody>
							</table>
							
										<table class="td-review td-visible-tablet-landscape"> <tbody> 
								<tr class="td-review-footer rate_point">
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['overall_score'],1);?></div> 
										<div class="td-review-final-star">
											    <?php
												$totalScore=$get_statistics_data['overall_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;?>
										</div>
										<span class="new_review_title">Overall Score</span> </div>
										  <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_cities']);?></div><span class="new_review_title">Total Cities</span> 
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['user_score'],1);?></div> 
										<div class="td-review-final-star">
										<?php
												$totalScore=$get_statistics_data['user_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
										?>
										</div>
										<span class="new_review_title">User Score</span> </div>
										
										 <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_areas']);?></div><span class="new_review_title">Total Areas</span>
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_keywords']);?></div> 
										<div class="td-review-final-star"> </div>
										<span class="new_review_title">Total Keywords</span> </div>
										
										<div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_yellowpages']);?></div><span class="new_review_title">Total YellowPages</span>
									</div> 
								</td>									
								<td class="td-review-summary">
								<span class="block-title td-post-category-new-background">SUMMARY</span> 
								<div class="td-review-summary-content">We provides a excellent information services between local business and users in various cities across India.</div> 
								</td> 
								</tr> 
							</tbody>
							</table>
							<table class="td-review td-visible-tablet-portrait"> <tbody> 
								<tr class="td-review-footer rate_point">
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['overall_score'],1);?></div> 
										<div class="td-review-final-star">
											    <?php
												$totalScore=$get_statistics_data['overall_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;?>
										</div>
										<span class="new_review_title">Overall Score</span> </div>
										  <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_cities']);?></div><span class="new_review_title">Total Cities</span> 
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['user_score'],1);?></div> 
										<div class="td-review-final-star">
										<?php
												$totalScore=$get_statistics_data['user_score'];
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
										?>
										</div>
										<span class="new_review_title">User Score</span> </div>
										
										 <div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_areas']);?></div><span class="new_review_title">Total Areas</span>
									</div> 
								</td>	
								<td class="td-review-score"> 
									<div class="td-review-overall">
										<div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_keywords']);?></div> 
										<div class="td-review-final-star"> </div>
										<span class="new_review_title">Total Keywords</span> </div>
										
										<div class="td-review-overall"> <div class="td-review-final-score total-score-statstics"><?php echo number_format($get_statistics_data['total_yellowpages']);?></div><span class="new_review_title">Total YellowPages</span>
									</div> 
								</td>									
								<td class="td-review-summary">
								<span class="block-title td-post-category-new-background">SUMMARY</span> 
								<div class="td-review-summary-content">We provides a excellent information services between local business and users in various cities across India.</div> 
								</td> 
								</tr> 
							</tbody>
							</table>
                       
                                </div>
                            </div>
                        </div>
                    </div>
					<?php   
					/******************Home List***************/ 
					$this->load->view('advertisments/home_statistics'); 
				    ?>
                </div>
                </div>