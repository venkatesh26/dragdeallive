    <div class=td-search-background></div>
    <div class=td-search-wrap-mob>
        <div class=td-drop-down-search aria-labelledby=td-header-search-button>
            <form method=get class=td-search-form action="<?php echo base_url().'listings';?>">
                <div class=td-search-close>
                    <a href="#"><i class=td-icon-close-mobile></i></a>
                </div>
                <div role=search class=td-search-input>
					<?php
					$select_city=(isset($_GET['city']))?$_GET['city']:'';
					$select_city_id=(isset($_GET['city_id']))?$_GET['city_id']:'';
					$select_area=(isset($_GET['area']))?$_GET['area']:'';
					$select_area_id=(isset($_GET['area_id']))?$_GET['area_id']:'';
					$category=(isset($_GET['category']))?$_GET['category']:'';
					$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';
					?>
					<label>City</label>
					<input id="mobile-home-city" type=text  name=city  autocomplete=off placeholder="Enter City" value="<?php echo $select_city;?>"/>
					<input type="hidden" name="city_id" value="<?php echo $select_city_id?>" id="mobile_city_id"/>
					<label>Location</label>
                    <input id="mobile-home-area" type=text  name=area autocomplete=off placeholder="Enter Location" value="<?php echo $select_area;?>"/>
					<input type="hidden" name="area_id" value="<?php echo $select_area_id;?>" id="mobile_area_id"/>
                    <label>Keyword</label>
                    <input id=td-header-search-keyword-mobile type=text value="<?php echo $keyword;?>" name=keyword autocomplete=off  required=true placeholder="Enter Keyword"/>
					<input type="hidden" name="category" value="<?php echo $category;?>" id="mobile_category_id"/>
					<input type="hidden" name="listing_name" value="" id="listing_name"/>	
					<input class="wpb_button wpb_btn-inverse btn" type=submit id=td-header-search-top value=Search />
                </div>
            </form>
            <div id=td-aj-search-mob></div>
        </div>
    </div>