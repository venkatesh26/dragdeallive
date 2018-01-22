<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['is_live_site']    = true;
$config['admin_resetpassword_url']	= $this->config['base_url'].ADMIN.'/reset/';
$config['resetpassword_url']	= $this->config['base_url'].'reset_password/';
$config['profile_url']				= 'app_data/profile/';

$config['user_role_type'] = array('admin'=>1,'hoteluser'=>2,'siteuser'=>3);
$config['user_login_type'] = array('site' => 1,'facebook' => 2  );
$config['user_login_type_names'] = array('2'=>'Facebook User', '1' => 'Site User' );
$config['user_roles'] = array('2' => 'Hotel','3' => 'User'  );


$config['gender'] = array('1'=>'Male','2'=>'Female');
$config['user_register_types']=array('1'=>'Site','2'=>'FaceBook','3'=>'GooglePlus','4'=>'Admin');
$config['offer_image_limit']	= '10';
$config['cities_icon_url']			= 'app_data/cities/';
$config['cities_image_icon_url']    = 'app_data/cities_images/';
$config['blog_icon_url']    = 'app_data/blogs/';
$config['coupon_icon_url']    = 'app_data/coupons/';
$config['campaign_url']    = 'app_data/campaign/';

$cis=& get_instance();
$config['bulkactions'] = array(''=>'Select action','1'=>'Active','2'=>'Inactive');
if($cis->uri->segment(3)=="active") {
	unset($config['bulkactions'][1]);
} else if ($cis->uri->segment(3)=="inactive") {
	unset($config['bulkactions'][2]);
}