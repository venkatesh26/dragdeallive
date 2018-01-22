<footer>
	<div class="wrapper">
		<section class="footer-main">
			<article class="footer-bottom">
				<ul>
						<?php 
						$footer_cities=footer_cities();
						foreach($footer_cities as $cities):?>
						<li>
						<a href="<?php echo base_url().'search/'.url_title(strtolower($cities['name']));?>" title="<?php echo ucwords($cities['name']);?>"><?php echo ucwords($cities['name']);?></a>
						</li>
						<?php endforeach;?>					
				</ul>
			</article>
			<article class="copy-right">
				<ul>
					<li>
						<a href="<?php echo base_url(); ?>" title="Home">Home</a>
					</li>
					<li>
						<a href="<?php echo base_url().'privacy-policy'; ?>" title="Privacy Policy">Privacy Policy</a>
					</li>
						<li>
						<a href="<?php echo base_url().'about-us'; ?>" title="About Us">About Us</a>
					</li>
						<li>
						<a href="<?php echo base_url().'contact-us'; ?>" title="Terms of Service">Contact Us</a>
					</li>
				</ul>
			</article>
		</section>
	</div>
</footer>