

<div class="td-category-header">
<div class="td-container">
<div class="td-pb-row">
<div class="td-pb-span12">
<?php  
	/************ Bread Crumb *****************/
	echo $this->load->view('bread_crumb',array(),true);
?>
<div class="clearfix"></div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="td-main-content-wrap">
<div class="td-container">
<div class="td-pb-row">
<div class="td-pb-span8 td-main-content">
<div class="td-ss-main-content"><div class="clearfix"></div>
  <?php if(!$this->detect->isMobile()):?>	
                  <p style="text-align:center">
                     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                     <!-- newtheme detailpage -->
                     <ins class="adsbygoogle"
                        style="display:inline-block;width:728px;height:90px"
                        data-ad-client="ca-pub-2739505616311307"
                        data-ad-slot="8370024870"></ins>
                     <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                     </script>
                  </p>
                  <?php 
                     else:?>
                  <div class="td-a-rec td-a-rec-id-sidebar ">
                     <span class=td-adspot-title>- Advertisement -</span>
                     <div>
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
                  </div>
                  <?php endif;?>
  <table class="td-review job-list-table">
  <thead>
  <th class="title">Job Title</th>
   <th>Sector</th>
   <th>Eligibility</th>
   <th>Last Date</th>
  </thead>
                                <tbody>
								<?php if(!empty($list)):?>
								<?php foreach($list['listings'] as $key=>$result):
								$link=base_url().'jobs/'.$result['id'].'/'.url_title($result['name']).'/'.url_title($result['city']).'/';
								?>
                                    <tr class="td-review-summary">
                                        <td><span class="td-review-summary-content"><a href="<?php echo $link;?>"><?php echo ucwords($result['name']);?>- <?php echo ucwords($result['no_of_vacancy']);?></a></span>
                                        </td>
										  <td><span class="td-review-summary-content"><?php echo ucwords($result['company_name']);?></span>
                                        </td>
										  <td><span class="td-review-summary-content"><?php echo ucwords($result['qualification']);?></span>
                                        </td>
										  <td><span class="td-review-summary-content"><?php echo ucwords($result['last_date_apply']);?></span>
                                        </td>
                                    </tr>
								<?php endforeach;?>
								
								<?php endif;?>
								</tbody>

                            </table>
										 <?php  echo $this->load->view('pagenation_links',array(),true);?>
<div class="clearfix"></div>
  <?php if(!$this->detect->isMobile()):?>	
                  <p style="text-align:center">
                     <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                     <!-- newtheme detailpage -->
                     <ins class="adsbygoogle"
                        style="display:inline-block;width:728px;height:90px"
                        data-ad-client="ca-pub-2739505616311307"
                        data-ad-slot="8370024870"></ins>
                     <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                     </script>
                  </p>
                  <?php 
                     else:?>
                  <div class="td-a-rec td-a-rec-id-sidebar ">
                     <span class=td-adspot-title>- Advertisement -</span>
                     <div>
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
                  </div>
                  <?php endif;?>
</div>
</div>
<?php echo $this->load->view('categories/related_job_list_category',array(),true);	?>
</div>
</div>
</div>