<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

# Admin Common Settings
function admin_settings_initialize($getId=null) {
	$ci=& get_instance();
    $ci->load->database(); 
	// $ci->db->cache_on(); 

	$ci->db->select('id,setting_fields,sitename');
	$ci->db->where('id', 1);
	$query = $ci->db->get('settings');
//		 $ci->db->cache_off(); 
    $row = $query->row();
	
	$settingFields = unserialize($row->setting_fields);

	$adminDatas=array();
	if($getId=='settings') {
		$adminDatas = array(
					'per_page' => $settingFields['back_pagination'],
					'use_page_numbers' => 'TRUE',
					'num_links' => 5,
					'full_tag_open' => '<ul>',
					'full_tag_close' => '</ul>',
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>',
					'cur_tag_open' => '<li class="active"><a>',
					'cur_tag_close' => '</a></li>'
			);
	} else if($getId=='email') {
		$adminDatas = $settingFields['email_address'];
	} else if($getId=='sitename') {
		$adminDatas= $row->sitename;
	} else if($getId=='front_paging_count') {
		$adminDatas = $settingFields['front_pagination'];
	} else if($getId=='meta_words'){
		$adminDatas = $settingFields;
	}
	else if($getId=='meta')
	{
			$adminDatas['keywords'] = $settingFields['keywords'];
			$adminDatas['description'] = $settingFields['description'];
	}
	else if($getId=='detail_meta')
	{
			$adminDatas['keywords'] = $settingFields['detail_keywords'];
			$adminDatas['description'] = $settingFields['detail_description'];
	}
	else if($getId=='list_meta')
	{
			$adminDatas['keywords'] = $settingFields['list_keywords'];
			$adminDatas['description'] = $settingFields['list_description'];
			$adminDatas['description1'] = $settingFields['list_description1'];
			$adminDatas['keywords1'] = $settingFields['list_keywords1'];
	}
	else if($getId=='payu_settings')
	{
			$adminDatas['merchant_key'] = $settingFields['merchant_key'];
			$adminDatas['merchant_salt'] = $settingFields['merchant_salt'];
			$adminDatas['pay_url'] = $settingFields['pay_url'];
	}
	else if($getId=='instamojo_settings')
	{
			$adminDatas['insta_api_key'] = $settingFields['insta_api_key'];
			$adminDatas['insta_auth_key'] = $settingFields['insta_auth_key'];
	}
	else if($getId=='common_summary')
	{
			$adminDatas['common_summary'] = $settingFields['common_summary'];
			$adminDatas['dynamic_content'] = $settingFields['dynamic_content'];
	}
	else if($getId=='sms_settings')
	{
			$adminDatas['total_sms'] = $settingFields['total_sms'];
			$adminDatas['sender_id1'] = $settingFields['sender_id1'];
			$adminDatas['sender_id2'] = $settingFields['sender_id2'];
			$adminDatas['api_key'] = $settingFields['api_key'];
	}
	else if($getId=='sms_cost')
	{
			$adminDatas['sms_cost'] = $settingFields['sms_cost'];
	}
	else if($getId=='coupon_messaage')
	{
			$adminDatas['coupon_messaage'] = $settingFields['coupon_message'];
	}
	else if($getId=='footer_email')
	{
			$adminDatas['footer_email'] = $settingFields['footer_email'];
	}
	else if($getId=='short_url_domain')
	{
			$adminDatas['short_url_domain'] = $settingFields['short_url_domain'];
	}
	return $adminDatas;
}

#Sub Admission 
function sub_admin_permission_check(){
	$ci=& get_instance();
	if($ci->session->userdata('is_sub_admin')){
		$sets = $ci->config->item('sub_admin_roles');
		if(!in_array($ci->router->fetch_method(),$sets[$ci->router->fetch_class()])){
			$ci->session->set_flashdata('flash_message', $ci->lang->line('not_authenticate'));
			redirect(ADMIN.'/dashboard');
		}
	}
}

#sub Admission permission check
function sub_admin_menu_check($menu){
	$ci=& get_instance();
	if($ci->session->userdata('is_sub_admin')){
		$sets = $ci->config->item('sub_admin_roles');
		if(!in_array($menu,array_keys($sets))){
			return false;
		} else {
			return true;
		}
	}else {
		return true;
	}
}

#Format To Array
function pr($arr_values) {
	if($arr_values!="") {
		echo '<pre>';
		print_r($arr_values);
	}
}


#User Profile Info
function user_profile_info($user_id=null,$user_type_id=null) {
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('users.email,users.id,user_profiles.first_name as name,users.profile_image,users.image_dir,user_profiles.mobile_number,user_profiles.last_name,user_profiles.address');
	$ci->db->where('users.id',$user_id);
	$ci->db->join('user_profiles', 'user_profiles.user_id = users.id', 'left');
	$query = $ci->db->get('users');
	$info=$query->row_array();
	return $info;
}

#Home Cities List
function get_cites($type=null) {
	$cities_info=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('cities.id,cities.name');
	$ci->db->where('cities.is_active','1');
	$ci->db->order_by('cities.name','asc');
	$query = $ci->db->get('cities');
	$cities=$query->result_array();
	$cities_info['0']="Select City";
	if($type)
	{
	foreach($cities as $city)
	{
		$cities_info[$city['id']]=ucwords($city['name']);	
	}	
	}
	else
	{
	foreach($cities as $city)
	{
		$cities_info[$city['name']]=ucwords($city['name']);	
	}
	}
	return $cities_info;
}

#Home Countries List function get_countries

function get_countries()
{
	$country_info=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('countries.id,countries.name');
	$ci->db->where('countries.is_active','1');
	$ci->db->order_by('countries.name','asc');
	$query = $ci->db->get('countries');
	$countries=$query->result_array();
	$country_info['0']="Select Country";
	foreach($countries as $c)
	{
		$country_info[$c['id']]=ucwords($c['name']);	
	}
	return $country_info;
}


function get_areas($select_city=null)
{
	$areas_info=array();
	$areas_info['0']="Select Location";
	if($select_city!='')
	{
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('areas.id,areas.name');
	$ci->db->where('areas.is_active','1');
	$ci->db->where('cities.name',$select_city);
	$ci->db->join('cities','cities.id=areas.city_id','left');
	$ci->db->order_by('areas.name','asc');
	$query = $ci->db->get('areas');
	$areas=$query->result_array();
	if(!empty($areas))
	{
		foreach($areas as $area)
		{
			$areas_info[$area['name']]=ucwords($area['name']);	
		}
	}
	}
	return $areas_info;	
}

function highlight_text($string,$keyword)
{
	if(!empty($keyword))
	{
	 $words =explode(' ',$keyword);
		foreach($words as $word)
		{
			$string = str_ireplace($word, '<span class="highlight_word">'.$word.'</span>', $string);
		}
	}
    return ucwords($string);
}

function footer_cities()
{
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('cities.id,cities.name');
	$ci->db->where('cities.is_active','1');
	$ci->db->where('cities.featured_city','1');
	$ci->db->order_by('cities.name','asc');
	$query = $ci->db->get('cities');
	$cities=$query->result_array();
	return $cities;
}

function header_cities(){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('cities.id,cities.name');
	$ci->db->where('cities.is_active','1');
	$ci->db->where('cities.featured_city','1');
	$ci->db->order_by('cities.name','asc');
	$query = $ci->db->get('cities');
	$cities=$query->result_array();
	return $cities;
}

function get_menus()
{	
        $ci=& get_instance();
	    $ci->load->database();
        $response=array();
	    $ci->db->select('main_category.name,main_category.id');
		$ci->db->where('main_category.is_active','1');
		$ci->db->order_by('main_category.list_count');
		$ci->db->limit('8');
		$query = $ci->db->get('main_category');
	    $results=$query->result_array();
        return $results; 	
}


function get_user_rating($list_id=null)
{
	
	    $ci=& get_instance();
	    $ci->load->database();
        $response=array();
	    $ci->db->select('count(advertisment_comments.id) as total_user_rated');
		$ci->db->where('advertisment_comments.advertisment_id',$list_id);
		$query = $ci->db->get('advertisment_comments');
	    $results=$query->row_array();
        return $results;
}


function get_list_phone($list_id=null)
{
	        $ci=& get_instance();
	        $ci->load->database();
		    $ci->db->select('advertisment_phones.number as contact_number');
		    $ci->db->from('advertisment_phones');
			$ci->db->where('advertisment_phones.advertisment_id',$list_id);
			$ci->db->limit('1');
			$query = $ci->db->get();
		    return $query->row_array();
}


function get_list_images($list_id=null)
{
	        $ci=& get_instance();
	        $ci->load->database();
	        $ci->db->select('advertisment_images.url as image_url');
		    $ci->db->from('advertisment_images');
			$ci->db->where('advertisment_images.advertisment_id',$list_id);
			$ci->db->where('advertisment_images.type','1');
			$ci->db->limit('1');
			$query = $ci->db->get();
            return $query->row_array();
}

function get_list_count($cat_id=null)
{
	        $ci=& get_instance();
	        $ci->load->database();
	        $ci->db->select('count(category_listing.id) as list_count');
		    $ci->db->from('category_listing');
			$ci->db->where('category_listing.category_id',$cat_id);
			$query = $ci->db->get();
            return $query->row_array();
}

function getBusinessInforamtion($addId, $userId)
{
	 $today=date('Y-m-d');
	 $ci=& get_instance();
	 $ci->load->database();
	 $ci->db->select('count(advertisment_views.id) as today_view_count');
	 $ci->db->where('advertisment_views.advertisment_id',$addId);
	 $ci->db->where('advertisment_views.created >=',$today);
	 $ci->db->from('advertisment_views');
	 $query = $ci->db->get();
     $result['today_view_count']=$query->row_array();
	 
	
	 $ci->db->select('count(advertisment_views.id) as total_view_count');
	 $ci->db->where('advertisment_views.advertisment_id',$addId);
	 $ci->db->from('advertisment_views');
	 $query = $ci->db->get();
     $result['total_view_count']=$query->row_array();
 	

	/*  $ci->db->select('count(advertisment_customer_list.id) as total_user_count');
	 $ci->db->where('advertisment_customer_list.user_id',$userId);
	 $ci->db->from('advertisment_customer_list');
	 $query = $ci->db->get();
     $result['total_user_count']=$query->row_array(); */
     return $result;		 
}


function get_my_addId($userId)
{
	$new_result=0;
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('id');
	$ci->db->where('advertisements.user_id',$userId);
	$ci->db->limit('1');
	$ci->db->from('advertisements');
	$query = $ci->db->get();
	$result=$query->row_array();
	if(!empty($result))
	{
		$new_result=$result['id'];
	}
	return $new_result;
}

/********************* Fotter Cities *******************/
 
function footer_cities_with_count(){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('cities.id,cities.name,cities.add_count');
	$ci->db->where('cities.is_active','1');
	$ci->db->where('cities.featured_city','1');
	$ci->db->order_by('cities.name','asc');
	$ci->db->limit('9');
	$query = $ci->db->get('cities');
	$cities=$query->result_array();
	return $cities;
}
/********************* Fotter Categories *******************/

function footer_categories_with_count(){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('categories.id,categories.name,categories.add_count');
	$ci->db->where('categories.is_active','1');
	$ci->db->where('categories.is_popular','1');
	$ci->db->order_by('categories.name','asc');
	$ci->db->limit('9');
	$query = $ci->db->get('categories');
	$categories=$query->result_array();
	return $categories;
}

function home_side_categories(){
	$randomNumber=rand(0,10486706);
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('category_listing.link');
	$ci->db->where('link !=',null);
	if($randomNumber >=10000000){
		$ci->db->where('id >=',$randomNumber);
	}
	else if($randomNumber >=100000 && $randomNumber <=10000000){
		$ci->db->where('id >=',$randomNumber);
	}
	else if($randomNumber >=0 && $randomNumber <=100000){
		$ci->db->where('id >=',$randomNumber);
	}
	else if($randomNumber >=100000){
		$ci->db->where('id <=',$randomNumber);
	}
	$ci->db->limit(9);
	$query = $ci->db->get('category_listing');
	$categories=$query->result_array();
	return $categories;
}

function home_categories(){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('categories.id,categories.name,category_listing.link');
	//$ci->db->order_by('categories.name','rand()');
	$ci->db->join('category_listing','categories.id=category_listing.category_id');
	$ci->db->limit('9');
	$query = $ci->db->get('categories');
	$categories=$query->result_array();
	return $categories;
}


/***************************** Footer Blogs ***************************/
function footer_blogs(){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('blogs.*');
	$ci->db->limit('3');
	$ci->db->where('type',1);
	$ci->db->order_by('id','DESC');
	$query = $ci->db->get('blogs');
	$blogs=$query->result_array();
	return $blogs;
}

/***************** side_widget_blogs ************/
function side_widget_blogs(){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('blogs.id,blogs.name,blogs.image_dir,blogs.image_name,blogs.short_description');
	$ci->db->limit('4');
	$ci->db->where('is_active',1);
	$ci->db->where('type',1);
	$ci->db->order_by('id','DESC');
	$query = $ci->db->get('blogs');
	$blogs=$query->result_array();
	return $blogs;
}

function side_widget_adds(){
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('advertisements.id,advertisements.name,advertisements.image_dir,advertisements.profile_image,advertisements.city_name,advertisements.short_description');
	$ci->db->limit('6');
	$ci->db->where('is_active',1);
	$ci->db->order_by('plan_id','DESC');
	$query = $ci->db->get('advertisements');
	$adds=$query->result_array();
	return $adds;
}

function get_category_name($cat_id){
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('main_category.id,main_category.name');
	$ci->db->where('main_category.is_active','1');
	$query = $ci->db->get('main_category');
	$categories=$query->row_array();
	return $categories['name'];
}

function get_statistics_data(){
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('site_statistics.*');
	$query = $ci->db->get('site_statistics');
	$data=$query->result_array();
	$datas=array();
	foreach($data as $data_new) {
		$datas[$data_new['meta_key']]=$data_new['meta_value'];
	}
	return $datas;
}

function get_customer_dashboard_data($addId){
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('advertisements.id,advertisements.expiry_date,advertisements.is_active,plans.name as plan_name,advertisements.plan_id,advertisements.is_active,advertisements.is_onetime_subscription');
	$ci->db->join('plans', 'plans.id = advertisements.plan_id', 'left');
	$ci->db->where('advertisements.id',$addId);
	$ci->db->limit('1');
	$ci->db->from('advertisements');
	$query = $ci->db->get();
	$result=$query->row_array();
	$new_result['expiry_date']=(isset($result['expiry_date']) && $result['expiry_date']!='') ? $result['expiry_date'] : '';
	$new_result['status']=(isset($result['is_active']) && $result['is_active']!='') ? $result['is_active'] : 0;
	$new_result['id']=(isset($result['id']) && $result['id']!='') ? $result['id'] : '';
	$new_result['plan_id']=(isset($result['plan_id']) && $result['plan_id']!='') ? $result['plan_id'] : 0;
	$new_result['plan_name']=(isset($result['plan_name']) && $result['plan_name']!='') ? $result['plan_name'] : 'Free';
	$new_result['is_one_time']=(isset($result['is_onetime_subscription']) && $result['is_onetime_subscription']==1) ? true : false;
	return $new_result;
}


function get_user_coupon_code($user_id){
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$today=date('Y-m-d');
	$response=array();
	$ci->db->select('coupons_codes.*');
	$ci->db->from('coupons_codes');
	$ci->db->where('coupons_codes.user_id',$user_id);
	$ci->db->join('coupons', 'coupons.id = coupons_codes.coupon_id');
	$ci->db->where('coupons_codes.is_download',1);
	$ci->db->where('coupons.is_active',1);
	$ci->db->where('coupons.exipry_date >=',$today);
	$query = $ci->db->get();
	$result=$query->result_array();
	if(!empty($result)){
		foreach($result as $results){		
			$response[$results['coupon_id']]=$results['code'];
		}
	}
	return $response;
}

function get_user_campaign_interset($user_id){
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$today=date('Y-m-d');
	$response=array();
	$ci->db->select('campaign_interset.*');
	$ci->db->from('campaign_interset');
	$ci->db->where('campaign_interset.user_id',$user_id);
	$query = $ci->db->get();
	$result=$query->result_array();
	if(!empty($result)){
		foreach($result as $results){		
			$response[$results['campaign_id']]=$results['id'];
		}
	}
	return $response;
}


function my_total_coupons($userId){
	$today=date('Y-m-d');
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(coupons.id) as total_active_coupons');
	$ci->db->where('coupons.user_id',$userId);
	$ci->db->from('coupons');
	$ci->db->where('coupons.is_active',1);
	$ci->db->where('coupons.exipry_date >=',$today);	
	$query = $ci->db->get();
	$result['total_active_coupons']=$query->row_array();
	return $result;	
}

function get_home_deals_data(){
$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('deals.*');
	$ci->db->limit('3');
	$ci->db->from('deals');
	$query = $ci->db->get();
	$result=$query->result_array();		
	return $result;
}

function get_home_offers_data(){
$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('offers.*');
	$ci->db->limit('3');
	$ci->db->from('offers');
	$ci->db->order_by('offers.id','DESC');
	$query = $ci->db->get();
	$result=$query->result_array();		
	return $result;
}

function notifications_count($user_id){
$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(notifications.id) as notifications_count');
	$ci->db->where('notifications.to_user_id',$user_id);
	$ci->db->where('notifications.is_read',0);
	$ci->db->from('notifications');
	$query = $ci->db->get();
	$result['notifications_count']=$query->row_array();
	return $result['notifications_count']['notifications_count'];	
}

function notifications_list($user_id){
$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('notifications.*');
	$ci->db->where('notifications.to_user_id',$user_id);
	$ci->db->where('notifications.is_read',0);
	$ci->db->from('notifications');
		$ci->db->order_by('notifications.id','DESC');
	$ci->db->limit(3);
	$query = $ci->db->get();
	$result['notifications_list']=$query->result_array();
	return $result['notifications_list'];	
}

function enquiry_count($add_id){
    $new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(advertisment_enquiry_list.id) as enquiry_count');
	$ci->db->where('advertisment_enquiry_list.advertisment_id',$add_id);
	$ci->db->from('advertisment_enquiry_list');
	$query = $ci->db->get();
	$result['enquiry_count']=$query->row_array();
	return $result['enquiry_count']['enquiry_count'];	
}

function getSmsInforamtion($user_id){
	
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('customer_sms_order.id,sms_packages.name as plan_name');
	$ci->db->join('sms_packages', 'sms_packages.id = customer_sms_order.sms_plan_id', 'left');
	$ci->db->where('customer_sms_order.user_id',$user_id);
	$ci->db->limit('1');
	$ci->db->order_by('id','desc');
	$ci->db->from('customer_sms_order');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['sms_plan_name']=(isset($new_result['plan_name']) && $new_result['plan_name']!='') ? ucwords($new_result['plan_name']) :' Free ';
	
	
	####### Today Sms Counts ##############
	$today=date('Y-m-d');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('sum(advertisments_customers_campaign.number_of_user_send * (ceil(message_length/160)) ) as today_send_sms_count');
	$ci->db->where('advertisments_customers_campaign.user_id',$user_id);
	$ci->db->where('advertisments_customers_campaign.created >=',$today);
	$ci->db->from('advertisments_customers_campaign');
	$query = $ci->db->get();
	$new_result=$query->row_array();
    $result['today_send_sms_count'] = ($new_result['today_send_sms_count']!='') ? $new_result['today_send_sms_count']:0;	
	
	####### yesterday Sms Counts ##############
	$today=date('Y-m-d 00:00:00',strtotime('- 1 days'));
	$today1=date('Y-m-d 24:00:00',strtotime('- 1 days'));
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('sum(advertisments_customers_campaign.number_of_user_send  * (ceil(message_length/160)) ) as yesterday_send_sms_count');
	$ci->db->where('advertisments_customers_campaign.user_id',$user_id);
	$ci->db->where('advertisments_customers_campaign.created >=',$today);
	$ci->db->where('advertisments_customers_campaign.created <=',$today1);
	$ci->db->from('advertisments_customers_campaign');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['yesterday_send_sms_count'] = ($new_result['yesterday_send_sms_count']!='') ? $new_result['yesterday_send_sms_count']:0;
	
	####### Current Month Sms Counts ##############
	$today=date('Y-m-01');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('sum(advertisments_customers_campaign.number_of_user_send  * (ceil(message_length/160)) ) as month_send_sms_count');
	$ci->db->where('advertisments_customers_campaign.user_id',$user_id);
	$ci->db->where('advertisments_customers_campaign.created >=',$today);
	$ci->db->from('advertisments_customers_campaign');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['month_send_sms_count'] = ($new_result['month_send_sms_count']!='') ? $new_result['month_send_sms_count']:0;
	
	
	####### Users Sms ##############
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('users.total_sms,users.total_number_of_sms_send');
	$ci->db->where('users.id',$user_id);
	$query = $ci->db->get('users');
	$new_result=$query->row_array();
	$result['total_sms_left'] = ($new_result['total_sms']!='') ? $new_result['total_sms']:0;
	$result['total_number_of_sms_send'] = ($new_result['total_number_of_sms_send']!='') ? $new_result['total_number_of_sms_send']:0;
	
	####### Remainder Current Month Sms Counts ##############
	$today=date('Y-m-01');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('sum(remainder_histroy.number_of_user_send  * (ceil(message_length/160)) ) as month_send_sms_count');
	$ci->db->where('remainder_histroy.user_id',$user_id);
	$ci->db->where('remainder_histroy.created >=',$today);
	$ci->db->from('remainder_histroy');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['remainder_month_send_sms_count'] = ($new_result['month_send_sms_count']!='') ? $new_result['month_send_sms_count']:0;
	
	
	######### Last Month Customers Count #############
	$ci=& get_instance();
	$ci->load->database();
	$today1=date('Y-m-01',strtotime('-1 month'));
	$today2=date('Y-m-31',strtotime('-1 month'));
	$ci->db->select('sum(remainder_histroy.number_of_user_send  * (ceil(message_length/160)) ) as rem_last_month_sms_count');
	$ci->db->where('remainder_histroy.user_id',$user_id);
	$ci->db->where('remainder_histroy.created >= ',$today1);
	$ci->db->where('remainder_histroy.created <= ',$today2);
	$query = $ci->db->get('remainder_histroy');	
	$new_result=$query->row_array();
	$result['rem_last_month_sms_count'] = (isset($new_result['rem_last_month_sms_count']) && $new_result['rem_last_month_sms_count']!='') ? $new_result['rem_last_month_sms_count']:0;
	
    return $result;
}

function remHistory($user_id){
	####### yesterday Sms Counts ##############
	$today=date('Y-m-d 00:00:00',strtotime('- 1 days'));
	$today1=date('Y-m-d 24:00:00',strtotime('- 1 days'));
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('sum(remainder_histroy.number_of_user_send  * (ceil(message_length/160)) ) as yesterday_send_sms_count');
	$ci->db->where('remainder_histroy.user_id',$user_id);
	$ci->db->where('remainder_histroy.created >=',$today);
	$ci->db->where('remainder_histroy.created <=',$today1);
	$ci->db->from('remainder_histroy');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['yesterday_send_sms_count'] = ($new_result['yesterday_send_sms_count']!='') ? $new_result['yesterday_send_sms_count']:0;
	
	$today=date('Y-m-d');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('sum(remainder_histroy.number_of_user_send * (ceil(message_length/160)) ) as today_send_sms_count');
	$ci->db->where('remainder_histroy.user_id',$user_id);
	$ci->db->where('remainder_histroy.created >=',$today);
	$ci->db->from('remainder_histroy');
	$query = $ci->db->get();
	$new_result=$query->row_array();
    $result['today_send_sms_count'] = ($new_result['today_send_sms_count']!='') ? $new_result['today_send_sms_count']:0;	
	
	
	return $result;
}

function getCustomersInforamtion($user_id) {
	
	######### Total Customers Count #############
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(advertisment_customer_lists.id) as users_count');
	$ci->db->where('advertisment_customer_lists.parent_user_id',$user_id);
	$query = $ci->db->get('advertisment_customer_lists');	
	$new_result=$query->row_array();
	$result['users_count'] = (isset($new_result['users_count']) &&  $new_result['users_count']!='') ? $new_result['users_count']:0;
	
	######### Current Month Customers Count #############
	$today=date('Y-m-01');
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(advertisment_customer_lists.id) as current_month_users_count');
	$ci->db->where('advertisment_customer_lists.parent_user_id',$user_id);
	$ci->db->where('advertisment_customer_lists.created >= ',$today);
	$query = $ci->db->get('advertisment_customer_lists');	
	$new_result=$query->row_array();
	$result['current_month_users_count'] = (isset($new_result['current_month_users_count']) &&  $new_result['current_month_users_count']!='') ? $new_result['current_month_users_count']:0;
	
	######### Last Month Customers Count #############
	$ci=& get_instance();
	$ci->load->database();
	$today1=date('Y-m-01',strtotime('-1 month'));
	$today2=date('Y-m-31',strtotime('-1 month'));
	$ci->db->select('count(advertisment_customer_lists.id) as last_month_users_count');
	$ci->db->where('advertisment_customer_lists.parent_user_id',$user_id);
	$ci->db->where('advertisment_customer_lists.created >= ',$today1);
	$ci->db->where('advertisment_customer_lists.created <= ',$today2);
	$query = $ci->db->get('advertisment_customer_lists');	
	$new_result=$query->row_array();
	$result['last_month_users_count'] = (isset($new_result['last_month_users_count']) && $new_result['last_month_users_count']!='') ? $new_result['last_month_users_count']:0;
	
	
	######### Total Customers Count #############
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(advertisment_customer_lists.id) as users_count');
	$ci->db->where('advertisment_customer_lists.parent_user_id',$user_id);
	$query = $ci->db->get('advertisment_customer_lists');	
	$new_result=$query->row_array();
	$result['users_count'] = (isset($new_result['users_count']) && $new_result['users_count']!='') ? $new_result['users_count']:0;
	
	######### Groups Count #############
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('count(groups.id) as group_count');
	$ci->db->where('groups.user_id',$user_id);
	$query = $ci->db->get('groups');
	$new_result=$query->row_array();
	$result['group_count'] = ($new_result['group_count']!='') ? $new_result['group_count']:0;
    return $result;	
}

######### Sms Chart Histroy #######
function sms_chart_histroy($user_id){

	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select("DATE_FORMAT(created, '%m/%d/%Y') as date,SUM(number_of_user_send * (ceil(message_length/160))) as send_sms",true);
	$ci->db->where('advertisments_customers_campaign.user_id',$user_id);
	$ci->db->where('created BETWEEN NOW() - INTERVAL 10 DAY AND NOW()');
	$ci->db->group_by('date');
	$query = $ci->db->get('advertisments_customers_campaign');
	$info=$query->result_array();
	$result=array();
	foreach($info as $key=>$new_result){
		$result[$key]['day']=date('F, d',strtotime($new_result['date']));
		$result[$key]['sms_counts']=$new_result['send_sms'];
	}
	return $result;
}

######## Sms ReMiander Histroy ############
function sms_remainder_histroy($user_id){
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select("DATE_FORMAT(created, '%m/%d/%Y') as date,SUM(number_of_user_send * (ceil(message_length/160))) as send_sms",true);
	$ci->db->where('remainder_histroy.user_id',$user_id);
	$ci->db->where('created BETWEEN CURDATE() - INTERVAL 10 DAY AND CURDATE()');
	$ci->db->group_by('date');
	$query = $ci->db->get('remainder_histroy');
	$info=$query->result_array();
	$result=array();
	foreach($info as $key=>$new_result){
		$result[$key]['day']=date('F, d',strtotime($new_result['date']));
		$result[$key]['sms_counts']=$new_result['send_sms'];	
	}
	return $result;
}

function getCampaignTrackList($user_id){
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('distinct advertisments_customers_campaign_tracking.id, advertisments_customers_campaign_tracking.created,advertisments_customers_campaign.title,
	advertisment_customer_lists.first_name as name,advertisment_customer_lists.mobile_number',false);
	$ci->db->where('advertisments_customers_campaign_tracking.parent_user_id',$user_id);
    $ci->db->join('advertisment_customer_lists', 'advertisment_customer_lists.customer_id = advertisments_customers_campaign_tracking.customer_id');
	$ci->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = advertisments_customers_campaign_tracking.advertisments_customers_camping_id');
	$ci->db->limit(3);
	$ci->db->order_by('advertisments_customers_campaign_tracking.id','DESC');	
	$query = $ci->db->get('advertisments_customers_campaign_tracking');
	$info=$query->result_array();
	return $info;
}

########## My Senderids #######
function my_sendIds($user_id) {
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('user_sender_ids.id,user_sender_ids.sender_id',false);
	$ci->db->where('user_sender_ids.user_id',$user_id);
	$ci->db->where('user_sender_ids.is_active',1);
	$ci->db->from('user_sender_ids');
	$ci->db->order_by('user_sender_ids.id','DESC');
	$query = $ci->db->get();
	$result=$query->result_array();
	return $result;	
}

function getCampaignLeadList($user_id){
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('campaign_interset.created,advertisments_customers_campaign.title,user_profiles.first_name as name,users.profile_image,users.image_dir,user_profiles.mobile_number');
	$ci->db->where('campaign_interset.parent_user_id',$user_id);
    $ci->db->join('users', 'users.id = campaign_interset.user_id');
	$ci->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = campaign_interset.campaign_id');
	$ci->db->join('user_profiles', 'user_profiles.user_id = users.id');
	$ci->db->limit(3);
	$ci->db->order_by('campaign_interset.id','DESC');
	$query = $ci->db->get('campaign_interset');
	$info=$query->result_array();
	return $info;
}

function couponsDaysLeft($date){
	$now = strtotime(date('y-m-d'));
	$date = strtotime($date);
	$datediff = $date - $now;
	echo floor($datediff / (60 * 60 * 24)).' Days Left';
}

function  checkUserPlan($user_id){
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('advertisements.plan_id');
	$ci->db->where('advertisements.user_id',$user_id);
	$ci->db->where('advertisements.is_active',1);
	$ci->db->from('advertisements');	
	$ci->db->limit('1');
	$query = $ci->db->get();
	$info=$query->row_array();
	return $info;
}

function footer_email(){
	
}

#### Paymnets Save #####
function paymentsSave($txind, $user_id, $type_id){
	$ci=& get_instance();
	$ci->load->database();	
	$data = array(
		'transaction_id'=> $txind,
		'user_id'=> $user_id,			
		'created'=> date('Y-m-d h:i:s')	,
		'type_id'=>$type_id
	);
	$ci->db->insert('payments', $data);		
}

function getHomeCouponlist($user_id=null){
	$today=date('Y-m-d');
	$ci=& get_instance();
	$ci->load->database();
	if($user_id!=null){
		$ci->db->where('coupons.user_id',$user_id);
	}
	$ci->db->select('SQL_CALC_FOUND_ROWS coupons.id,coupons.*,advertisements.name as add_name,advertisements.city_name,advertisements.area_name,advertisements.address_line',false);
	$ci->db->from('coupons');
	$ci->db->join('advertisements','coupons.advertisement_id=advertisements.id');
	$ci->db->order_by('coupons.id','DESC');
	$ci->db->where('coupons.is_active',1);
	$ci->db->where('coupons.exipry_date >=',$today);	
	$ci->db->limit(4);
	$query = $ci->db->get();			
	$result=$query->result_array();
	return $result;
}

/******** Offer Campign List ****/
function getOfferCampaignlist($user_id=null){
	$today=date('Y-m-d');
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('advertisments_customers_campaign.*');
	$ci->db->where('advertisments_customers_campaign.user_id',$user_id);
	$ci->db->where('advertisments_customers_campaign.campaign_type_id',2);
	$ci->db->where('DATE(advertisments_customers_campaign.campaign_start_date) <=',$today);
	$ci->db->where('DATE(advertisments_customers_campaign.campaign_end_date) >=',$today);
	$ci->db->where('advertisments_customers_campaign.display_as_offer',1);
	$ci->db->limit(8);
	$ci->db->order_by('advertisments_customers_campaign.id','DESC');
	$query = $ci->db->get('advertisments_customers_campaign');
	$info=$query->result_array();
	return $info;	
}

function getAddName($userId){

	$new_result='';
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('name');
	$ci->db->where('advertisements.user_id',$userId);
	$ci->db->limit('1');
	$ci->db->from('advertisements');
	$query = $ci->db->get();
	$result=$query->row_array();
	if(!empty($result))
	{
		$new_result=$result['name'];
	}
	return $new_result;	
}

## incremental hash #########
function offerCode($len = 5){
	  $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $base = strlen($charset);
	  $result = '';
	  $now = explode(' ', microtime())[1];
	  while ($now >= $base){
		$i = $now % $base;
		$result = $charset[$i] . $result;
		$now /= $base;
	  }
	  return substr($result, -5);
}

	
## incremental hash #########
function incrementalHash($len = 5){
	  $charset=random_string('alnum',100);	
	  $base = strlen($charset);
	  $result = '';
	  $now = explode(' ', microtime())[1];
	  while ($now >= $base){
		$i = $now % $base;
		$result = $charset[$i] . $result;
		$now /= $base;
	  }
	  return substr($result, -5);
}

function getCustomerBillInformation($user_id){
	
	################## Total Revenue #########################
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('SUM(advertisment_customer_bills.amount) AS total_amount, COUNT(advertisment_customer_bills.id) AS total_orders');
	$ci->db->where('advertisment_customer_bills.parent_user_id',$user_id);
	$ci->db->from('advertisment_customer_bills');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['total_revenue']=(isset($new_result['total_amount']) && $new_result['total_amount']!='') ? $new_result['total_amount'] :'0';
	$result['total_orders']=(isset($new_result['total_orders']) && $new_result['total_orders']!='') ? $new_result['total_orders'] :'0';
	
	####### Today Revenue ##############
	$today=date('Y-m-d');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('SUM(advertisment_customer_bills.amount) AS total_amount');
	$ci->db->where('advertisment_customer_bills.parent_user_id',$user_id);
	$ci->db->where('advertisment_customer_bills.created >=',$today);
	$ci->db->from('advertisment_customer_bills');
	$query = $ci->db->get();
	$new_result=$query->row_array();
    $result['today_revenue'] = ($new_result['total_amount']!='') ? $new_result['total_amount']:0;	
	
	####### Current Month Revenue ##############
	$today=date('Y-m-01');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('SUM(advertisment_customer_bills.amount) AS total_amount');
	$ci->db->where('advertisment_customer_bills.parent_user_id',$user_id);
	$ci->db->where('advertisment_customer_bills.created >=',$today);
	$ci->db->from('advertisment_customer_bills');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['current_month_revenue'] = ($new_result['total_amount']!='') ? $new_result['total_amount']:0;
	

    return $result;
}


function getMyBillInformation($customer_id){
	
	################## Total Revenue #########################
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('SUM(advertisment_customer_bills.amount) AS total_amount, COUNT(advertisment_customer_bills.id) AS total_orders');
	$ci->db->where('advertisment_customer_bills.customer_id',$customer_id);
	$ci->db->from('advertisment_customer_bills');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['total_revenue']=(isset($new_result['total_amount']) && $new_result['total_amount']!='') ? $new_result['total_amount'] :'0';
	$result['total_orders']=(isset($new_result['total_orders']) && $new_result['total_orders']!='') ? $new_result['total_orders'] :'0';
	
	####### Today Revenue ##############
	$today=date('Y-m-d');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('SUM(advertisment_customer_bills.amount) AS total_amount');
	$ci->db->where('advertisment_customer_bills.customer_id',$customer_id);
	$ci->db->where('advertisment_customer_bills.created >=',$today);
	$ci->db->from('advertisment_customer_bills');
	$query = $ci->db->get();
	$new_result=$query->row_array();
    $result['today_revenue'] = ($new_result['total_amount']!='') ? $new_result['total_amount']:0;	
	
	####### Current Month Revenue ##############
	$today=date('Y-m-01');
	$new_result=array();
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->select('SUM(advertisment_customer_bills.amount) AS total_amount');
	$ci->db->where('advertisment_customer_bills.customer_id',$customer_id);
	$ci->db->where('advertisment_customer_bills.created >=',$today);
	$ci->db->from('advertisment_customer_bills');
	$query = $ci->db->get();
	$new_result=$query->row_array();
	$result['current_month_revenue'] = ($new_result['total_amount']!='') ? $new_result['total_amount']:0;
	
    return $result;
}
