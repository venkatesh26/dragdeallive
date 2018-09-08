<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
#Format To Array
function pr($arr_values) {
	if($arr_values!="") {
		echo '<pre>';
		print_r($arr_values);
	}
}

function getShortUrl($url,$compact=true){
		    //use urls last part as is for short code
    if(!$compact) {
        $url_parts = parse_url($url);
		pr($url_parts);
        $short_url = str_replace('www.', '', $url_parts['host']).'-';
        $parts = array_reverse(explode('/', $url_parts['path']));
        $short_url .= preg_replace('/[^a-z0-9_-\.]/i', '', str_replace('-', '_', $parts[0]));
    } else {
        $short_url = substr(hash('sha512', time()), 0, 5);
    }
    $i = 0;
    $original_short_url = $short_url;
    while(isAlreadyExist($short_url)) {
        if($i > 0) {
            if($compact) {
                $short_url = substr(hash('sha512', time()), 0, 5);
            } else {
                $short_url = $original_short_url.'_'.$i;
            }
        }
        $i++;
    }
	return $short_url;
}

function isAlreadyExist($str) {
	
	$ci=& get_instance();
    $ci->load->database(); 
	$ci->db->select('COUNT(id) AS total_urls');
	$ci->db->where('code', $str);
	$query = $ci->db->get('shorten_url');
    $row = $query->row_array();
	
	if((isset($row['total_urls']) && $row['total_urls']!='' && $row['total_urls'] > 0)){
		return true;
	}
	return false;
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

# Admin Common Settings
function admin_settings_initialize($getId=null) {
	$ci=& get_instance();
    $ci->load->database(); 
	$ci->db->select('id,setting_fields,sitename');
	$ci->db->where('id', 1);
	$query = $ci->db->get('settings');
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
	return $adminDatas;
}