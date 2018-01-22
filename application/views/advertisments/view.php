<style>
    .td-pb-row [class*=td-pb-span]{
        padding-right:0px !important;
    }
</style>
<?php 
$my_adress=$result[ 'address_line']; if($result[ 'address_line']!='' ) { if($result[ 'area_name']!='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'areas']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']!='' ) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']); } } else { if($result[ 'area_name']!='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']!='' ) { $my_adress=ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']); } }
$link='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$contact_number="Not Available";
if(isset($result['contact_number']) && $result['contact_number']!='')
{
$contact_number=$result['contact_number'];   
}
$social_media = @unserialize($result['other_info']);
$whatsup_contact_number=(isset($social_media['whatsup_contact_number']) && $social_media['whatsup_contact_number']!='') ? $social_media['whatsup_contact_number'] : '';
$no_of_employees=(isset($result['no_of_employees']) && $result['no_of_employees']!='') ? $result['no_of_employees'] : '';
$fax=(isset($result['fax']) && $result['fax']!='') ? $result['fax'] : '';
$since=(isset($result['since']) && $result['since']!='') ? $result['since'] : '';
?>
<div class="td-main-content-wrap">
    <div class="td-container td-post-template-2">
        <article class="post-117 post type-post status-publish format-standard has-post-thumbnail hentry category-tagdiv-reviews" id="post-117">
            <div class="td-pb-row">
                <div class="td-pb-span12">
                    <div class="td-post-header">
                        <br/>
                        <?php /************ Bread Crumb *****************/ echo $this->load->view('bread_crumb',array(),true); ?>
                      
                    </div>
                </div>
            </div>
            <div class="td-pb-row">
				
                <div role="main" class="td-pb-span8 td-main-content">
				 <h3 class="entry-title td-page-title" style="display:block;background-color:#29c065;padding:5px;color:#fff;"><?php echo ucwords($result['name']).' ,'.ucwords($result['city_name']);?></h3>
     
                    <div class="td-ss-main-content">
                        <div class="clearfix"></div>
                                   						<?php 	
if($this->detect->isMobile()):?>
<div class="td-post-sharing td-post-sharing-bottom">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- mobile leaderboard -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="9529917690"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>


</div>
<?php 
else:?>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- dragdeal View Page -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="3928158140"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>


<br/>
<?php    
    
endif;?> 
                        
                         <div class="td-post-sharing td-post-sharing-bottom">
                            <div class="td-default-sharing">
							<?php $share_link="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
                                <b>SHARE USING - </b> <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.facebook.com/share.php?u=<?php echo $link;?>&title='<?php echo ucwords($result['name']);?>" class="td-social-sharing-buttons td-social-facebook"><i class="fa fa-facebook"></i><div class="td-social-but-text">Share on Facebook</div></a>
                                <a href="http://twitter.com/intent/tweet?status=<?php echo ucwords($result['name']);?>+<?php echo $link;?>&via=Dialbe.com" class="td-social-sharing-buttons td-social-twitter"><i class="fa fa-twitter"></i><div class="td-social-but-text">Tweet on Twitter</div></a>
                                <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://plus.google.com/share?url=<?php echo $share_link;?>" class="td-social-sharing-buttons td-social-google"><i class="fa fa-google-plus"></i></a>
                                <a onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_link;?>&title=<?php echo ucwords($result['name']);?>&summary=<?php echo ucwords($result['description']);?>&source=dialbe.com" class="td-social-sharing-buttons td-social-pinterest"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                        
        
						
							<?php 
							$image=base_url().'assets/themes/images/281-218x150.png';
							$image=base_url().'assets/themes/images/list_logo.png';
							$no_image=true;
							if(!empty($result['profile_image']) && file_exists('./'.$result['image_dir'].$result['profile_image']))
							{
							   $img_src = thumb(FCPATH.$result['image_dir'].$result['profile_image'],'218','159','list_thumb');
							   $image = base_url().$result['image_dir'].'list_thumb/'.$img_src;
							   $no_image=false;
							}?>
						<br/>
						<br/>
						<div class="td-visible-desktop td_module_10 td_module_wrap td-animation-stack detail-page-sect">
							<div class="td-module-thumb"><a title="<?php echo ucwords($result['name']);?>" rel="bookmark" href="#">
						<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper($result['name'][0]);?>"><?php echo strtoupper($result['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
							
							
							</a></div>
							<div class="item-details">
							<h3 class="entry-title td-module-title">
							
							<?php echo ucwords($result['name']);?>,<?php echo ucwords($result['city_name']);?></h3>
							
							<div class="td-module-meta-info"> <p style="font-size: 12px;font-weight:700;color:#000"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></p> 
							<div class="td-module-comments"><a href="#"><?php echo $result['total_user_rated'];?></a></div> </div>
							
							
							<div class="td-module-meta-info"><p style="font-size: 12px;font-weight:700;color:#000"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></p></div>
							
					
							
							<div class="td-module-meta-info"><p style="font-size: 12px;font-weight:700;color:#000"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?>  <?php if($result['email']!=''):?><a style="font-size:12px;font-weight:700;color:#000" data-email="<?php echo $result['email'];?>" class="td-login-modal-js js-enquiry" href="#enquiry-form" data-effect="mpf-td-login-effect" data-advertisment="<?php echo $result['id'];?>" data-advertismenttitle="<?php echo ucwords($result['name']);?>"  data-advertismentemail="<?php echo ucwords($result['email']);?>" data-advertismentuserid="<?php echo ucwords($result['user_id']);?>"><i class="fa fa-envelope-o"></i> Send Enquiry By Email. </a> </p><?php endif;?> </div>
							</div>
						</div>
						<div class="td_module_10 td_module_wrap td-animation-stack detail-page-sect td-visible-tablet-landscape">
							<div class="td-module-thumb"><a title="<?php echo ucwords($result['name']);?>" rel="bookmark" href="#">
						<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper($result['name'][0]);?>"><?php echo strtoupper($result['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
							
							</a></div><div class="item-details"><h3 class="entry-title td-module-title">
							
							<a title="<?php echo ucwords($result['name']);?>" rel="bookmark" href=""><?php echo ucwords($result['name']);?>,<?php echo ucwords($result['city_name']);?></a></h3><div class="td-module-meta-info"><a class="td-post-category  td-post-category-background" href="#"> <?php echo ucwords($result['city_name']);?></a> <span class="td-post-author-name"><a href="#"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a> </span><div class="td-module-comments"><a href="#"><?php echo $result['total_user_rated'];?></a></div> </div><div class="td-module-meta-info"><span class="td-post-author-name"><a href="#"><i class="fa fa-phone"></i> <?php echo $contact_number;?></a> <span></span> </span></div><div class="td-module-meta-info"><span class="td-post-author-name"><a href="#"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></a> <span></span> </span></div>
							<div class="td-module-meta-info"><span class="td-post-author-name"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?> </a> <span></span> </span>
							</div>
							
								<div class="td-module-meta-info">
								<?php if($result['email']!=''):?>
								<span class="td-post-author-name"><i class="fa fa-envelope-o"></i><a href="<?php echo base_url();?>home/enquiry?token=<?php echo $result['id'];?>"> Send Enquiry By Email</a><span></span> </span>
								<?php endif;?>
								</div>							
							</div>
						</div>
						<div class="td_module_10 td_module_wrap td-animation-stack detail-page-sect td-visible-tablet-portrait">
							<div class="td-module-thumb"><a title="<?php echo ucwords($result['name']);?>" rel="bookmark" href="#">
							<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper($result['name'][0]);?>"><?php echo strtoupper($result['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
							</a></div><div class="item-details"><h3 class="entry-title td-module-title">
							
							<a title="<?php echo ucwords($result['name']);?>" rel="bookmark" href=""><?php echo ucwords($result['name']);?>,<?php echo ucwords($result['city_name']);?></a></h3>
							
							<div class="td-module-meta-info"><a class="td-post-category  td-post-category-background" href="#"> <?php echo ucwords($result['city_name']);?></a> <span class="td-post-author-name"><a href="#"><i class="fa fa-user"></i> Owner : <?php echo ucwords($result['owner']);?></a> </span><div class="td-module-comments"><a href="#"><?php echo $result['total_user_rated'];?></a></div> </div>
							
							
							
							<div class="td-module-meta-info"><span class="td-post-author-name1"><a href="#"><i class="fa fa-phone"></i> <?php echo $contact_number;?></a> <span></span> </span></div><div class="td-module-meta-info"><span class="td-post-author-name1"><a href="#"><i class="fa fa-map-marker"></i> <?php echo $my_adress;?></a> <span></span> </span></div>
							<div class="td-module-meta-info"><span class="td-post-author-name1"><a href="#"><i class="fa fa-clock-o"></i> <?php echo $result['working_start'];?> to <?php echo $result['working_end'];?> </a> <span></span> </span>
							</div>
							
								<div class="td-module-meta-info">
									<?php if($result['email']!=''):?>
									<span class="td-post-author-name1"><i class="fa fa-envelope-o"></i><a href="<?php echo base_url();?>home/enquiry?token=<?php echo $result['id'];?>"> Send Enquiry By Email</a><span></span> </span>
									<?php endif;?>
								</div>
							</div>
						</div>
						              
                        
						<div class="td-visible-phone view-detail-phone">
					
								<div class="author-box-wrap">
									<div class="td-module-thumb"><a title="<?php echo ucwords($result['name']);?>" rel="bookmark" href="#">
										<?php 
		if($no_image){?>
			<div class="custom_image">
  <p class="image_class_<?php echo strtoupper($result['name'][0]);?>"><?php echo strtoupper($result['name'][0]);?></p>
  
</div>
		<?php }else{?>
			
		
<img width="218" height="150" title="" alt="" src="<?php echo $image;?>" class="entry-thumb td-animation-stack-type0-2">
		<?php } ?>
										</a>
									</div>
								<div class="desc">
								<div class="td-author-name vcard author"><span class="fn"><a href="#"><?php echo ucwords(htmlentities(nl2br($result['name'])));?></a></span>
								</div>
								<div class="clearfix"></div>
								</div>
								</div>
									<div class="td-post-sharing td-post-sharing-bottom td-with-like">
						   
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-map-marker fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;<?php echo ucwords(htmlentities(nl2br($my_adress)));?></span>
							</div>
							
							<?php if(strtolower($result['owner'])!='not available' && $result['owner']!=''):?>
							
								<div class="td-post-sharing td-post-sharing-bottom td-with-like">
						   
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-user fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;Owner : <?php echo $result['owner'];?></span>
							</div>
							<?php endif;?>
								
									<div class="td-post-sharing td-post-sharing-bottom td-with-like">
						   
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-clock-o fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;<?php echo $result['working_start'];?> to <?php echo $result['working_end'];?></span>
							</div>
								<?php if($result['email']!=''):?>
					
                                    <div class="td-post-sharing td-post-sharing-bottom td-with-like">
                                         <span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-envelope fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;<a href="<?php echo base_url();?>home/enquiry?token=<?php echo $result['id'];?>" style="color:#000;"> Send Enquiry </a></span>
                                    </div>
								<?php endif;?>
						</div>
						<?php 	
if($this->detect->isMobile()):
?>				
<div class="td-post-sharing">
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
<?php 
else:?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- dragdeal View Page -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="3928158140"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<?php endif;?>
						<br/>
						<?php echo $this->load->view('advertisments/view_social_media',array(),true);?>
						
						<?php if($result['website']!=''):?>
						<div class="td-post-sharing td-post-sharing-bottom td-with-like">
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-globe fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;<a target="_blank" href="<?php echo $result['website'];?>" style="color:#000;">  <?php echo $result['website'];?></a></span>
						</div>
						<?php endif;?>
						<?php if(strtolower($contact_number) !='not available'):?>
						<div class="td-post-sharing td-post-sharing-bottom td-with-like">
						   
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-phone fa-3x" style="font-size:20px;color:#29c065"></i>&nbsp;<?php echo $contact_number;?></span>
							
							<?php if($whatsup_contact_number!=''):?>
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-whatsapp fa-3x" style="font-size:20px;color:#29c065"></i> <?php echo $whatsup_contact_number;?></span>
							<?php endif;?>
							<?php if($fax!='' && $fax!=0 && $fax!=91):?>
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-fax fa-3x" style="font-size:20px;color:#29c065"></i> <?php echo $fax;?></span>
							<?php endif;?>
						</div>
						<?php endif;?>
						<?php if($no_of_employees!='' || $since!=''):?>
						<div class="td-post-sharing td-post-sharing-bottom td-with-like">
							<?php if($whatsup_contact_number!=''):?>
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-users fa-3x" style="font-size:20px;color:#29c065"></i> <?php echo "Number Of Employess - ".$no_of_employees;?></span>
							<?php endif;?>
							<?php if($since!=''):?>
							<span class="td-post-share-title1" style="font-size:16px;"><i class="fa fa-building fa-3x" style="font-size:20px;color:#29c065"></i> Company Starts Since - <?php echo $since;?></span>
							<?php endif;?>
						</div>
						<?php endif;?>
					
						
							<div class="td-post-sharing">
	
<?php 	
if($this->detect->isMobile() || $this->detect->isTablet()):
?>				
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- mobile add responsivve -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="9543523853"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php 
else:?>
<?php endif;?>
						</div>
						<br/>
						
						<?php if($result['description']!=''):?>
                        <div class="td-post-content">
                            <div class="td-paragraph-padding-1 view-page-description">
                                <h3><strong>Summary</strong></h3>
                                <p><?php echo ucwords(nl2br($result['description']));?></p>
                            </div>
                        </div>
						<?php endif;?>						
                        <footer>
                            <table class="td-review">
                                <tbody>
                                    <tr class="td-review-header">
                                        <td colspan="2"><span class="block-title  td-post-category-background">REVIEW OVERVIEW</span>
                                        </td>
                                    </tr>

                                    <tr class="td-review-row-bars">
                                        <td colspan="2">
                                            <div class="td-review-details">
                                                <div class="td-review-desc">Overall Review</div>
                                                <div class="td-review-percent"><?php echo $result['overall_score'];?></div>
                                            </div>
                                            <div class="td-rating-bar-wrap">
                                                <div style="width:<?php echo $result['overall_score'] * 10;?>%" class="theme1"></div>
                                            </div>
                                        </td>
                                    </tr>
									<tr class="td-review-row-bars">
                                        <td colspan="2">
                                            <div class="td-review-details">
                                                <div class="td-review-desc">Site Review</div>
                                                <div class="td-review-percent"><?php echo $result['site_score'];?></div>
                                            </div>
                                            <div class="td-rating-bar-wrap">
                                                <div style="width:<?php echo $result['site_score'] * 10;?>%" class="theme2"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="td-review-row-bars">
                                        <td colspan="2">
                                            <div class="td-review-details">
                                                <div class="td-review-desc">User Review</div>
                                                <div class="td-review-percent">
												<?php 
												$rating=($result['rating']!='')?$result['rating']:0;
                                                echo $rating;
												?>
												</div>
                                            </div>
                                            <div class="td-rating-bar-wrap">
                                                <div style="width:<?php echo $rating * 10;?>%" class="theme3"></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="td-review-footer rate_point">
                                        <td class="td-review-summary"><span class="block-title  td-post-category-background">SUMMARY</span>
                                            <div class="td-review-summary-content"><?php
                                            if($result['short_description']!=''){
												echo $result['short_description'];
											}
											else {
												echo $common_summary;
											}
											?></div>
                                        </td>
                                        <td class="td-review-score">
                                            <div class="td-review-overall">
                                                <div class="td-review-final-score total-score-statstics">
												<?php 
												$totalScore=($result['site_score'] + $result['overall_score'] + $result['rating']) / 3;
												echo number_format($totalScore,1);
												?>
												</div>
                                                <div class="td-review-final-star">
												<?php 
												for($i=$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star'></i>";
												endfor;
												for($i=5-$totalScore;$i>=1;$i--):
												echo "<i class='fa fa-star-o'></i>";
												endfor;
												?>
                                                </div>
												
												<span>OVERALL Rating</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
						<?php 
						echo $this->load->view('advertisments/view_service',array(),true);
						echo $this->load->view('advertisments/view_keywords',array(),true);
						echo $this->load->view('advertisments/view_reviews',array(),true);
							if($dynamic_content!=''):
						?>
						<div class="td-post-sharing td-post-sharing-bottom">
						<h3><strong class="review-overview-title">Get More Search of <?php echo $result['name'];?></strong></h3>
						  <?php  echo $dynamic_content;?>
						</div>
						<?php endif;?>
					</footer>	
								<div>
					<?php
$my_adress="Chennai";
$title="Dragdeal";
if(isset($result['name'])){
	$title=$result['name'];
}
if(isset($result['address_line'])){
$my_adress=$result['address_line'];
	if($result['address_line']!='')
	{
		if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).','.ucwords($result['city_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['area_name']=='' && $result['city_name']!='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['city_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['area_name']!='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['area_name']).'-'.$result['zip'];
		}
		else if(isset($result['area_name']) && $result['areas']=='' && $result['city_name']=='' && ($result['zip']!='' && $result['zip']!=0))
		{
		 $my_adress =ucwords($result['address_line']).','.ucwords($result['areas']).'-'.$result['zip'];
		}
		$title=(isset($result['name'])) ? $result['name'] : '';
	}
}
?>
<div class="map_canvas" id="map_canvas" data-lat="<?php echo $result['latitude'];?>" data-long="<?php echo $result['longitude'];?>" style="height: 300px;width: 100%;margin-top: 20px;border: 1px solid #ccc;padding: 5px;"  data-address="<?php echo $my_adress;?>"   data-title="<?php echo $title;?>"></div>
</div>
					<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDEzS87sF3Q5nxXcLqugUJAp0hGzQS2mTk"></script>
					<br/>
					
					   <?php echo $this->load->view('advertisments/view_products',array(),true);?>					
					   <?php echo $this->load->view('advertisments/view_add_comments',array(),true);?>
					   		        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-2739505616311307"
     data-ad-slot="8959427279"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
                    </div>
                </div>
               	<?php echo $this->load->view('categories/related_category',array(),true);?>
			    <div class="td-post-content">
	
			      <?php 
					   echo $this->load->view('advertisments/my_campaign_list',array(),true);?>		   
				</div>
            </div>
			
        </article>
    </div>
</div>
  <?php $this->load->view('advertisments/my_coupon_list'); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDEzS87sF3Q5nxXcLqugUJAp0hGzQS2mTk"></script>
<script type="text/javascript">
$(document).ready(function(){
	map_initialize();
	
	function update_views_counts(id,count,user_id) { 
		var $_this=$(this);
		$.ajax({
			type: "POST",
			url:__cfg('path_absolute')+"listings/udateViewCount",
			data:{'add_id':id,'user_id':user_id,'visit_count':count},
			datatype:"json",
			success: function(data){
			}
		});
	}
	update_views_counts(<?php echo $result['id'];?>,<?php echo $result['view_count']?>,<?php echo $result['user_id']?>);
});
</script>