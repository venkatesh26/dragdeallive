<?php if(!empty($home_categories)):?>
<section id="moremenus" class="quick-menus">
				<div class="wrapper">
				    <h3 class="home-categories-title"><i class="fa fa-search"></i><i class="fa fa-quote-left"></i>Find By Categories<i class="fa fa-quote-right"></i></h3>
					<ul class="quick-menus-list">
					 <?php foreach($home_categories as $categories):?>
						<li>
							<a href="<?php echo base_url().'home-search/'.url_title(strtolower($categories['name']));?>" title="<?php echo ucwords($categories['name']);?>">
								<span class="icons"><i class="fa <?php echo $categories['font_name'];?>"></i></span>
								<label><?php echo ucwords($categories['name']);?></label>
							</a>
						</li>
					<?php endforeach;?>						
					</ul>
				</div>
			</section>
<?php endif;?>