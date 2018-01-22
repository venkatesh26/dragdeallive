    <div class=td-search-background></div>
    <div class="td-search-wrap-mob" id="td-header-enquiry">
        <div class=td-drop-down-search>
            <form method=get class=td-search-form action="<?php echo base_url().'listings';?>">
                <div class=td-search-close>
                    <a href="#"><i class=td-icon-close-mobile></i></a>
                </div>
                <div role=search class=td-search-input>
                    <label>Search</label>
                    <input id=td-header-enquiry type=text value="" name=keyword autocomplete=off  required=true placeholder="Enter Name"/>
					<label>City</label>
					<input id=td-heaer-city type=text value="" name=city  autocomplete=off placeholder="Enter City"/>
					<label>Location</label>
                    <input id=td-heaer-area type=text value="" name=area autocomplete=off placeholder="Enter Location"/>
                </div>
            </form>
            <div id=td-aj-search-mob></div>
        </div>
    </div>