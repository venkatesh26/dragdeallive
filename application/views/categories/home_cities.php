<div class="vc_row wpb_row td-pb-row">
                    <div class="wpb_column vc_column_container td-pb-span12">
                        <div class=wpb_wrapper>							
							<h4 class=block-title><span>MOST POPULAR CITIES</span></h4>
                            <div class="td_block_wrap td_block_big_grid_8 td-grid-style-3 td-hover-1 td-pb-border-top" data-td-block-uid=td_uid_13_57495b20b5af3>
                                <div id=td_uid_13_57495b20b5af3 class=td_block_inner>
                                    <div class=td-big-grid-wrapper>
									<?php 
									$count=0;
									$group1=array_slice($home_cities,0,2);
									$group2=array_slice($home_cities,2,3);
									$group3=array_slice($home_cities,5,2);
									?>
                                    <div class="td-grid-columns td-grid-group-1">
									 <?php
									      foreach($group1 as $key=>$item):
										  $link=base_url().'search/'.url_title(strtolower($item['name']));

										  $image=base_url().'assets/themes/images/410-356x364.jpg';
											if(file_exists('./'.$item['image_dir'].$item['city_image']) && $item['city_image']!="") 	  
										  {
											$img_src = thumb(FCPATH.$item['image_dir'].$item['city_image'],'356','410','city_thumb');
											$image = base_url().$item['image_dir'].'city_thumb/'.$img_src;
										   }
									      if($key==0){ ?>
										<div class="td_module_mx14 td-animation-stack td-big-grid-post-0 td-big-grid-post td-big-thumb">
											<div class=td-module-thumb>
													<a href="<?php echo $link;?>" rel=bookmark><img width=356 height=364 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>"/>
													</a>
											</div>
                                                <div class=td-meta-info-container>
                                                    <div class=td-meta-align>
                                                        <div class=td-big-grid-meta>
                                                            <a href="<?php echo $link;?>" class="td-post-category td-post-category-background"><?php echo ucwords($item['name']);?></a>
                                                        </div>
                                                        <div class=td-module-meta-info>
                                                            <span class="td-post-author-name td-post-category td-post-category-background"><a href="<?php echo $link;?>">Total Business</a> <span>-</span> </span> <span class="td-post-date td-post-category td-post-category-background"><time class="entry-date updated td-module-date"><?php echo number_format($item['add_count']);?></time></span> </div>
                                                    </div>
                                                </div>
                                        </div>
									 <?php } else { ?>
                                            <div class="td_module_mx12 td-animation-stack td-big-grid-post-1 td-big-grid-post td-small-thumb">
                                                <div class=td-module-thumb>
                                                    <a href="<?php echo $link;?>" rel=bookmark title="<?php echo ucwords($item['name']);?>"><img width=356 height=364 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>"/>
													</a>
                                                </div>
                                                <div class=td-meta-info-container>
                                                    <div class=td-meta-align>
                                                        <div class=td-big-grid-meta>
                                                            <a href="<?php echo $link;?>" class="td-post-category td-post-category-background"><?php echo ucwords($item['name']);?></a>
                                                        </div>
                                                        <div class=td-module-meta-info>
                                                            <span class="td-post-author-name td-post-category td-post-category-background"><a href="<?php echo $link;?>">Total Business</a> <span>-</span> </span> <span class="td-post-date td-post-category td-post-category-background"><time class="entry-date updated td-module-date"><?php echo number_format($item['add_count']);?></time></span> </div>
                                                    </div>
                                                </div>
                                            </div>
									 <?php }
									 endforeach;?>
                                        </div>
                                        
										<div class=td-big-grid-scroll>
                                            <div class="td-grid-columns td-grid-group-2">
											   <?php 
											   foreach($group2 as $key=>$item):
											    $link=base_url().'search/'.url_title(strtolower($item['name']));
											$image=base_url().'assets/themes/images/410-356x364.jpg';
											if(file_exists('./'.$item['image_dir'].$item['city_image']) && $item['city_image']!="") 	  
										  {
											$img_src = thumb(FCPATH.$item['image_dir'].$item['city_image'],'356','410','city_thumb');
											$image = base_url().$item['image_dir'].'city_thumb/'.$img_src;
										   }
										   
											   if($key==0) { ?>
                                                <div class="td_module_mx12 td-animation-stack td-big-grid-post-2 td-big-grid-post td-small-thumb">
                                                    <div class=td-module-thumb>
                                                        <a href="<?php echo $link;?>" rel=bookmark title="<?php echo ucwords($item['name']);?>"><img width=356 height=220 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>" />
                                                        </a>
                                                    </div>
                                                    <div class=td-meta-info-container>
                                                        <div class=td-meta-align>
                                                            <div class=td-big-grid-meta>
                                                                <a href="<?php echo $link;?>" class="td-post-category td-post-category-background"><?php echo ucwords($item['name']);?></a>
                                                            </div>
                                                            <div class=td-module-meta-info>
                                                                <div class=entry-review-stars><i class=td-icon-star></i><i class=td-icon-star></i><i class=td-icon-star></i><i class=td-icon-star></i><i class=td-icon-star-half></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												<?php
											   } 
											   else if($key==1) { ?>
                                                <div class="td_module_mx12 td-animation-stack td-big-grid-post-3 td-big-grid-post td-small-thumb">
                                                    <div class=td-module-thumb>
                                                        <a href="<?php echo $link;?>" rel=bookmark title="<?php echo ucwords($item['name']);?>"><img width=356 height=220 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>" />
                                                        </a>
                                                    </div>
                                                    <div class=td-meta-info-container>
                                                        <div class=td-meta-align>
                                                            <div class=td-big-grid-meta>
                                                                <a href="<?php echo $link;?>" class="td-post-category td-post-category td-post-category-background"><?php echo ucwords($item['name']);?></a>
                                                            </div>
                                                            <div class=td-module-meta-info>
                                                                <span class="td-post-author-name td-post-category-background"><a href="<?php echo $link;?>">Total Bussiness</a> <span>-</span> </span> <span class="td-post-date td-post-category td-post-category-background"><time class="entry-date updated td-module-date"><?php echo number_format($item['add_count']);?></time></span> </div>
                                                        </div>
                                                    </div>
                                                </div>
											   <?php } else { ?>
                                                <div class="td_module_mx12 td-animation-stack td-big-grid-post-4 td-big-grid-post td-small-thumb">
                                                    <div class=td-module-thumb>
                                                        <a href="<?php echo $link;?>" rel=bookmark title="<?php echo ucwords($item['name']);?>"><img width=356 height=220 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>"/>
                                                        </a>
                                                    </div>
                                                    <div class=td-meta-info-container>
                                                        <div class=td-meta-align>
                                                            <div class=td-big-grid-meta>
                                                                <a href="<?php echo $link;?>" class="td-post-category td-post-category td-post-category-background"><?php echo ucwords($item['name']);?></a>
                                                            </div>
                                                            <div class=td-module-meta-info>
                                                                <span class="td-post-author-name td-post-category td-post-category-background"><a href="<?php echo $link;?>"><?php echo ucwords($item['name']);?></a> <span>-</span> </span> <span class=td-post-date><time class="entry-date updated td-module-date"><?php echo number_format($item['add_count']);?></time></span> </div>
                                                        </div>
                                                    </div>
                                                </div>
											   <?php }
											    endforeach;
											   ?>
                                            </div>
                                            <div class="td-grid-columns td-grid-group-3">
											   <?php 
											   foreach($group3 as $key=>$item):
											    $link=base_url().'search/'.url_title(strtolower($item['name']));
												  $image=base_url().'assets/themes/images/410-356x364.jpg';
												 if(file_exists('./'.$item['image_dir'].$item['city_image']) && $item['city_image']!="") 	  
										  {
											$img_src = thumb(FCPATH.$item['image_dir'].$item['city_image'],'356','410','city_thumb');
											$image = base_url().$item['image_dir'].'city_thumb/'.$img_src;
										   }
											   if($key==0) { ?>
                                                <div class="td_module_mx12 td-animation-stack td-big-grid-post-5 td-big-grid-post td-small-thumb">
                                                    <div class=td-module-thumb>
                                                        <a href="<?php echo $link;?>" rel=bookmark title="<?php echo ucwords($item['name']);?>"><img width=356 height=220 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>" />
                                                        </a>
                                                    </div>
                                                    <div class=td-meta-info-container>
                                                        <div class=td-meta-align>
                                                            <div class=td-big-grid-meta>
                                                                <a href="<?php echo $link;?>" class="td-post-category td-post-category td-post-category-background"><?php echo ucwords($item['name']);?></a>
                                                            </div>
                                                            <div class=td-module-meta-info>
                                                                <span class="td-post-author-name td-post-category td-post-category-background"><a href="<?php echo $link;?>">Total Buissness</a> <span>-</span> </span> <span class=td-post-date><time class="entry-date updated td-module-date"><?php echo number_format($item['add_count'],4);?></time></span> </div>
                                                        </div>
                                                    </div>
                                                </div>
											   <?php } else { ?>
                                                <div class="td_module_mx14 td-animation-stack td-big-grid-post-6 td-big-grid-post td-big-thumb">
                                                    <div class=td-module-thumb>
                                                        <a href="<?php echo $link;?>" rel=bookmark title="<?php echo ucwords($item['name']);?>"><img width=356 height=364 class=entry-thumb src="<?php echo $image;?>" alt="" title="<?php echo ucwords($item['name']);?>" />
                                                        </a>
                                                    </div>
                                                    <div class=td-meta-info-container>
                                                        <div class=td-meta-align>
                                                            <div class=td-big-grid-meta>
                                                                <a href="<?php echo $link;?>" class="td-post-category td-post-category td-post-category-background"><?php echo ucwords($item['name']);?>	</a>
															</div>
                                                            <div class=td-module-meta-info>
                                                                <span class="td-post-author-name td-post-category td-post-category-background"><a href="<?php echo $link;?>">Total Bussiness</a> <span>-</span> </span> <span class="td-post-date td-post-category td-post-category-background"><time class="entry-date updated td-module-date"><?php echo number_format($item['add_count']);?></time></span> 
															</div>
                                                        </div>
                                                    </div>
                                                </div>
											   <?php }
											   endforeach;?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=clearfix></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>