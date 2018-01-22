<div class="home-banner">
				<div class="banner-bg"></div>
				<div class="wrapper">
				    <?php if($this->router->fetch_class()=="home" && $this->router->fetch_method()=='index'):?>
					<h2>Let start search... what you want to know?</h2>
					<p>We are happy to give a better result to you... </p>
					<?php endif;?>
					<form id="home-search" class="normal" method="GET" action="<?php echo base_url().'listings';?>">
						<div class="home-search">
							<div class="search-list">
							<?php 
							$my_cities=get_cites(); 
							$js ='id=home-city';
							$drop_cities=(isset($_GET['city']))?$_GET['city']:'';
							echo form_dropdown('city', $my_cities,$drop_cities,$js);
							?>
							</div>
							<div class="search-list search-list2">
						   <?php 
						    $js ='id=home-area';
						    $select_areas=(isset($_GET['city']))?$_GET['city']:'';
							$drop_area=(isset($_GET['area']))?$_GET['area']:'';
							$my_areas=get_areas($select_areas); 
							echo form_dropdown('area',$my_areas,$drop_area,$js);
							?>
							</div>
							<div class="search-box">
							<?php
							$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';
							?>
								<input type="text"  autocomplete="off" name="keyword" value="<?php echo $keyword;?>" id="home-list"/>
								<input type="hidden" name="category" value="" id="category_id"/>
								<input type="hidden" name="listing_name" value="" id="listing_name"/>
								<input type="submit" name="searchsubmit" value="Search" title="Search" />
							</div>
						</div>
					</form>
				</div>
			</div>