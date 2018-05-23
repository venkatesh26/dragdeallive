<?php
class Listings extends CI_Controller {

    #Magic Method - Construct the object
    public function __construct() {
        parent::__construct();
		$this->load->model('advertisment_model');
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
		$this->site_name=admin_settings_initialize('sitename');
    }
	
	#Advertisment Index 
	public function index() {
	    $data=array();
		$config=array();
	
		$this->load->library('pagination');
		$this->load->helper('thumb');
		
		#Query String
		$city=(isset($_GET['city']) && $_GET['city']!='0')?$_GET['city']:'';
		$area=(isset($_GET['area']) && $_GET['area']!='0')?$_GET['area']:'';
		$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';
		$category=(isset($_GET['category']))?$_GET['category']:'';
		$home_category=(isset($_GET['home_category']))?$_GET['home_category']:'';
		$category_name=(isset($_GET['category_name']))?$_GET['category_name']:'';
		
		
		if($this->uri->segment('1')=='home-search' && $this->uri->segment('2')!=''){
			$home_category=ucwords(str_replace('-',' ',$this->uri->segment('2')));	
		}
		
		if($this->uri->segment('1')=='home-search' && $this->uri->segment('3')!=''){
			$city=ucwords(str_replace('-',' ',$this->uri->segment('3')));	
		}
		
		if($this->uri->segment('1')=='home-search' && $this->uri->segment('4')!=''){
			$area=ucwords(str_replace('-',' ',$this->uri->segment('4')));	
		}
		
		if($this->uri->segment('1')=='search' && $this->uri->segment('2')!=''){
			$city=ucwords(str_replace('-',' ',$this->uri->segment('2')));	
		}
		if($this->uri->segment('1')=='search' && $this->uri->segment('3')!=''){
			$area=ucwords(str_replace('-',' ',$this->uri->segment('3')));	
		}
		
		$r_category_name=(isset($_GET['r_category']))?ucwords(str_replace('-',' ',$_GET['r_category'])):'';
		############# Category Search ###################
		if(($this->uri->segment('1')=='category-search' || $this->uri->segment('1')=='service-search') && $this->uri->segment('3')!=''){
			$city=ucwords(str_replace('-',' ',$this->uri->segment('3')));	
		}
		if(($this->uri->segment('1')=='category-search' || $this->uri->segment('1')=='service-search') && $this->uri->segment('4')!=''){
			$area=ucwords(str_replace('-',' ',$this->uri->segment('4')));	
		}
		if(($this->uri->segment('1')=='category-search' || $this->uri->segment('1')=='service-search') && $this->uri->segment('2')!=''){
			$r_category_name=$this->uri->segment('2');	
			$r_category_name=ucwords(str_replace('-',' ',$r_category_name));
		}
		
		$query_string='?city='.$city.'&area='.$area.'&keyword='.$keyword.'&category='.$category.'&home_category='.$home_category.'&r_category='.$r_category_name;
				
	     	$meta_keywords='';
		 if(!empty($category_name)){
			 $meta_keywords=$category_name; 
		 }
		 if(!empty($home_category)){ 
			 $meta_keywords=$home_category; 
		 }
		 if(!empty($keyword)) { 
			 $meta_keywords=$keyword; 
		 }
		 		
		#Pagination Settings
		
		$config['suffix'] = $query_string;
		$config['base_url'] = base_url().'listings/index';
		$config['first_url'] = base_url().'listings/index'.$query_string;
		$config['per_page'] = '9';
		$config['num_links'] = '3';
		$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
		$config["full_tag_open"] = '<div class="page-nav td-pb-padding-side">';
		$config["full_tag_close"] = '</div>';
		$config["cur_tag_open"] = '<span class="current">';
		$config["cur_tag_close"] = '</span>';
		
		$s=0;
		if($this->uri->segment(3)!='' && $this->uri->segment(1)!='search' && $this->uri->segment(1)!='category-search')
		{
			$s=$this->uri->segment(3);
		}
		$page = ($this->uri->segment(3) && $this->uri->segment(1)!='search') ? $s : 0;

	
		#Get Advertisment List
		$data["list"] = $this->advertisment_model->get_add_list('all',$config['per_page'], $page,$city,$area,$keyword,$category,$home_category,$r_category_name);
	
		$config['total_rows'] = $data["list"]['all_total_rows'];
		
		$this->pagination->initialize($config);
		$data["pagination_link"]= $this->pagination->create_links();
		
		#Get Related Category
		$new_category='';
		if(!empty($data["list"])) {
			foreach($data["list"]['listings'] as $key=>$cat) {
				if($cat['category_id']!='') {
				  $new_category.=$cat['category_id'];
				}
			}
		}
		
		####### Realted CATEGORY ##########
		$data['category_list']=$this->advertisment_model->get_new_list_category($new_category);
		
		######## Realted List ############
		$data['related_list']=0;
		if(empty($data['list']['listings'])) {
			$data['list']['listings']=$this->advertisment_model->get_related_list('related',$config['per_page'], $page,$city,$area,$keyword,$category_name,$home_category,$r_category_name);
			$data['related_list']=1;
		}
		if($r_category_name!=''){
			$meta_keywords=$r_category_name;
		}
	
		#### BreadCrumbs ########## 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
				
		######### Meta Title Combination One - City,Area,Categoy ##############
		$individalMeta=1;
		if($individalMeta==1) {
			$data['cityDetails']=$this->advertisment_model->city_details($city);
			$data['categoryDetails']=$this->advertisment_model->category_details($category);

			if($city!='' && $city!='0' && $area!='' &&  $area!='0' && $meta_keywords!='' && $data['categoryDetails']!='') {
				$listing_data=array($city,$area,$meta_keywords);
				$meta_datas=array('##CITY##','##AREA##','##CATEGORY##');
				$description = str_replace($meta_datas, $listing_data, $data['categoryDetails']['meta_city_area_description']);
				$title_of_layout = str_replace($meta_datas, $listing_data, $data['categoryDetails']['meta_city_area_title']);
			}
			else if($city!='' && $city!='0' && $meta_keywords!='' && $area=='' && $data['categoryDetails']!=''){
			    $listing_data=array($city,$meta_keywords);
				$meta_datas=array('##CITY##','##CATEGORY##');
				$description = str_replace($meta_datas, $listing_data, $data['categoryDetails']['meta_city_description']);
				$title_of_layout = str_replace($meta_datas, $listing_data, $data['categoryDetails']['meta_city_title']);
			}
			else if($meta_keywords!='' && $data['categoryDetails']!=''){
				$listing_data=array($meta_keywords);
				$meta_datas=array('##CATEGORY##');
				$description = str_replace($meta_datas, $listing_data, $data['categoryDetails']['meta_description']);
				$title_of_layout = str_replace($meta_datas, $listing_data, $data['categoryDetails']['meta_title']);
			}
			else if($city!='' && $area!=''&& $data['cityDetails']!=''){
				$listing_data=array($city,$area,$meta_keywords);
				$meta_datas=array('##CITY##','##AREA##');
				$description = str_replace($meta_datas, $listing_data, $data['cityDetails']['meta_city_area_description']);
				$title_of_layout = str_replace($meta_datas, $listing_data, $data['cityDetails']['meta_city_area_title']);
			}
			else if($city!='' && $data['cityDetails']!='') {	
				$listing_data=array($city,$area,$meta_keywords);
				$meta_datas=array('##CITY##');
				$description = str_replace($meta_datas, $listing_data, $data['cityDetails']['meta_description']);
				$title_of_layout = str_replace($meta_datas, $listing_data, $data['cityDetails']['meta_title']);
			}
		}
		else {
				
			$meta_desciptions=admin_settings_initialize('list_meta');		
		    if($meta_keywords!='') {	
				if($city!='' || $area!='') {
					$listing_data=array($city,$area,$meta_keywords);
					$meta_datas=array('##CITY##','##AREA##','##CATEGORY##');
					$description = str_replace($meta_datas, $listing_data, $meta_desciptions['description']);
				}
				else {
					$description='Get  location, contact  phone numbers, email, user  reviews & ratings and more details of '.$meta_keywords;	
				}						
		    }
			else {
			   if(isset($meta_desciptions['description1']) && $meta_desciptions['description1']!=''){
					$listing_data=array($city,$area,$meta_keywords);
					$meta_datas=array('##CITY##','##AREA##','##CATEGORY##');
					$description = 	str_replace($meta_datas, $listing_data, $meta_desciptions['description1']);
				}
		   }
			if($meta_keywords!='') {
				if($city!='' || $area!='') {
					$listing_data=array($city,$area,$meta_keywords);
					$meta_datas=array('##CITY##','##AREA##','##CATEGORY##');
					$title_of_layout = str_replace($meta_datas, $listing_data, $meta_desciptions['keywords1']);
				}
				else {
					$title_of_layout="Business Listings of ".$meta_keywords;
				}				
			}
			else {
				$listing_data=array($city,$area,$meta_keywords);
				$meta_datas=array('##CITY##','##AREA##','##CATEGORY##');
				$title_of_layout = str_replace($meta_datas, $listing_data, $meta_desciptions['keywords']);	
			}
		}		
		
		$header_tilte="";
		if(!empty($city) && $city!='0'){
		   $this->breadcrumbs->push(ucfirst($city),base_url().'search/'.url_title(strtolower($city)));
		   $header_tilte="Business Listings Directory in ".ucwords(str_replace('-',' ',$city));
		}
		if(!empty($area) && $area!='0' && !empty($city) && $city!='0'){
		   $this->breadcrumbs->push(ucfirst($area),base_url().'search/'.url_title(strtolower($city)).'/'.url_title(strtolower($area)));	
		   $header_tilte="Business Listings Directory in ".ucwords(str_replace('-',' ',$city))." , ".ucwords(str_replace('-',' ',$area));
		}
		
		if($city!='' && $r_category_name!=''){
		   $this->breadcrumbs->push(ucfirst($r_category_name),base_url().'search/'.url_title(strtolower($r_category_name)).'/'.url_title(strtolower($r_category_name)));
		   $header_tilte=ucwords(str_replace('-',' ',$r_category_name))." in ".$city;
		}
		
		if($city=='' && $area=='' && $r_category_name!='') {
		  $this->breadcrumbs->push(ucfirst($r_category_name),base_url().'search/'.url_title(strtolower($r_category_name)).'/'.url_title(strtolower($r_category_name)));
		   $header_tilte=ucwords(str_replace('-',' ',$r_category_name))." in ".$city;
		}
		
	  	######## List Data And Meta Title And Description Set ########
	   	$data['title_of_layout']=$title_of_layout;
	    $data['title_of_description']=$description;
		$data['total_count']=$config['total_rows'];
		$data['search_header_title']=$header_tilte;
		$data['main_content']=$this->load->view('advertisments/list', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
	
	#Advertisment View 
	public function preview() {
		$this->myUserId=$this->session->userdata('user_id');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}	
		#Query String
		$city=(isset($_GET['city']) && $_GET['city']!='0')?$_GET['city']:'';
		$area=(isset($_GET['area']) && $_GET['area']!='0')?$_GET['area']:'';
		$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';
		$category=(isset($_GET['category']))?$_GET['category']:'';
		$home_category=(isset($_GET['home_category']))?$_GET['home_category']:'';
		$category_name=(isset($_GET['category_name']))?$_GET['category_name']:'';
		if(!empty($category_name))
		{
			$category_name=ucwords(str_replace('-',' ',$category_name));
		}
		$add_id=get_my_addId($this->myUserId);
		if($add_id==0)
		{
			$url = 'login';
			redirect($url);
		}	
		$data=array();
	
		#Get Add Detail
		$data['result']=$this->advertisment_model->get_add_preview_detail($add_id);
		
		if(empty($data['result']))
		{
			redirect(base_url());	
		}
		if($this->uri->segment('1')=='mysearch' && $this->uri->segment('5')!='')
		{
			$city=strtolower($this->uri->segment('5'));
		}
		$data['category_list']=$this->advertisment_model->get_category_list($data['result']['list_cat_id'],$keyword,$city,$area,$data['result']['name']);
		

		#Get Business Data
		
		$data['business_data']=$this->advertisment_model->get_business_data($add_id);
		
		
		#Get Service Data
		$data['service_data']=$this->advertisment_model->get_service_data($add_id);
				
		#Set Meta Title And Keyword
		
		$category_name=(isset($data['business_data'][0]['category_name'])) ? $data['business_data'][0]['category_name'] : '';
		$shop_name=(isset($data['result']['name'])) ? $data['result']['name'] : '';
		$category_name_list=($category_name!='') ? ' | '.$category_name:'';
		$meta_desciptions=admin_settings_initialize('detail_meta');
		if(isset($meta_desciptions['description']) && $meta_desciptions['description']!='') {
			
			    $listing_data=array($shop_name,$data['result']['city_name'],$data['result']['area_name'],$category_name);
				$meta_datas=array('##NAME##','##CITY##','##AREA##','##CATEGORY##');
				$description = str_replace($meta_datas, $listing_data, $meta_desciptions['description']);
		}
		else {
			$description='Get  location, contact  phone numbers, email, user  reviews & ratings and more details of '.$shop_name.' listed under '.$category_name. ' in '.$data['result']['area_name'].' ,'.$data['result']['city_name']; 
		}
		if(isset($meta_desciptions['keywords']) && $meta_desciptions['keywords']!='') {
			
				$listing_data=array($shop_name,$data['result']['city_name'],$data['result']['area_name'],$category_name);
				$meta_datas=array('##NAME##','##CITY##','##AREA##','##CATEGORY##');
				$title = str_replace($meta_datas, $listing_data, $meta_desciptions['keywords']);
		}
		else {
			
			$title=$data['result']['name'].' in '.$data['result']['area_name'].' '.$data['result']['city_name'].$category_name_list;
		}
		
		$notification_settings = @unserialize($data['result']['notification_settings']);
		if(isset($notification_settings['custom_meta']) && $notification_settings['custom_meta']==1){
			if($data['result']['meta_keywords']!=''){
				
				$data['title_of_meta_keywords']=$data['result']['meta_keywords'];
			}
			if($data['result']['meta_description']!=''){
				$description=$data['result']['meta_description'];
			}
		}
		$data['title_of_layout']=$title;
		$data['title_of_description']=$description;
		$data['meta_rating']='General';
			$data['dynamic_content']="";
			$data['or_image']="";
		
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		
		if(!empty($data['result']['city_name']))
		{
		   $this->breadcrumbs->push(ucfirst($data['result']['city_name']),base_url().'search/'.url_title(strtolower($data['result']['city_name'])));
		}
		if(!empty($data['result']['city_name']) && !empty($data['result']['area_name']))
		{
		   $this->breadcrumbs->push(ucfirst($data['result']['area_name']),base_url().'search/'.url_title(strtolower($data['result']['city_name'])).'/'.url_title(strtolower($data['result']['area_name'])));
		}
		
		$this->breadcrumbs->push(ucfirst($data['result']['name']),base_url());	
		$this->load->model('comment_model');
	    $data['advertisment_id']=$add_id;
		$data['gallery'] = $this->advertisment_model->get_advertisments_image($add_id);
		$data['user_comments']=$this->comment_model->get_comment_list($add_id);
		
		$common_summary=admin_settings_initialize('common_summary');
		$replace_datas=array('##NAME##','##CITY##','##AREA##','##CATEGORY##');
		$bread_cat=$category_name;
		if($category_name==''){$category_name="yellow pages";}
		$linkreplace_datas=array('##LINKNAME##','##LINKCITY##','##LINKAREA##','##LINKCATEGORY##');
		$listing_data=array($shop_name,$data['result']['city_name'],$data['result']['area_name'],$category_name);
		$common_summary_data=str_replace($replace_datas, $listing_data, $common_summary['common_summary']);
		$listing_link_data=array(url_title(strtolower($shop_name)),url_title(strtolower($data['result']['city_name'])),url_title(strtolower($data['result']['area_name'])),url_title(strtolower($category_name)));
		$data['common_summary']=str_replace($linkreplace_datas, $listing_link_data, $common_summary_data);
		$dynamic_content=str_replace($replace_datas, $listing_data, $common_summary['dynamic_content']);
		$data['dynamic_content']=str_replace($linkreplace_datas, $listing_link_data, $dynamic_content);
		$data['main_content']=$this->load->view('advertisments/view', $data,true);
		
		$this->load->view('layouts/default',$data);
	}
	
	
	#Advertisment View 
	public function view() {	
	
		#Query String
		$city=(isset($_GET['city']) && $_GET['city']!='0')?$_GET['city']:'';
		$area=(isset($_GET['area']) && $_GET['area']!='0')?$_GET['area']:'';
		$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';
		$category=(isset($_GET['category']))?$_GET['category']:'';
		$home_category=(isset($_GET['home_category']))?$_GET['home_category']:'';
		$category_name=(isset($_GET['category_name']))?$_GET['category_name']:'';
		if(!empty($category_name))
		{
			$category_name=ucwords(str_replace('-',' ',$category_name));
		}
		$add_id=$this->uri->segment('2');
		$data=array();
	
		#Get Add Detail
		$data['result']=$this->advertisment_model->get_add_detail($add_id);
				
		if(empty($data['result']))
		{
			redirect(base_url());	
		}
		if($this->uri->segment('1')=='mysearch' && $this->uri->segment('5')!='')	
		{
			$city=strtolower($this->uri->segment('5'));
		}
		$data['category_list']=$this->advertisment_model->get_category_list($data['result']['list_cat_id'],$keyword,$city,$area,$data['result']['name']);
		

		#Get Business Data
		
		$data['business_data']=$this->advertisment_model->get_business_data($add_id);
		
		$random_cat_data=array();
		$new_data['random_cat_datas'][0]='';
		foreach($data['business_data'] as $key=>$business_datas){
		
             $random_cat_data[]=$business_datas['category_name'];
			 $new_data['random_cat_datas']=array_rand($random_cat_data,1);			 
		}
		
		#Get Service Data
		$data['service_data']=$this->advertisment_model->get_service_data($add_id);
		
		#Set Meta Title And Keyword
		$category_name=(isset($random_cat_data[$new_data['random_cat_datas'][0]])) ? $random_cat_data[$new_data['random_cat_datas'][0]] : '';
		$shop_name=(isset($data['result']['name'])) ? $data['result']['name'] : '';
		
		$result=$data['result'];
		$my_adress=$result[ 'address_line']; 
		if($result[ 'address_line']!='' ) { if($result[ 'area_name']!='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'areas']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']!='' ) { $my_adress=ucwords($result[ 'address_line']). ','.ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']); } } else { if($result[ 'area_name']!='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']!='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'city_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']=='' && $result[ 'city_name']=='' && ($result[ 'zip']!='' && $result[ 'zip']!=0)) { $my_adress=ucwords($result[ 'area_name']). '-'.$result[ 'zip']; } else if($result[ 'area_name']!='' && $result[ 'city_name']!='' ) { $my_adress=ucwords($result[ 'area_name']). ','.ucwords($result[ 'city_name']); } }
		
		$contact_number=$result['contact_number']; 

		$category_name_list=($category_name!='') ? ' | '.$category_name:'';
		$meta_desciptions=admin_settings_initialize('detail_meta');
		if(isset($meta_desciptions['description']) && $meta_desciptions['description']!='') {
			    $listing_data=array($shop_name,$data['result']['city_name'],$data['result']['area_name'],$category_name, $my_adress, $contact_number);
				$meta_datas=array('##NAME##','##CITY##','##AREA##','##CATEGORY##', '##ADDRESS##','##CONTACTNUMBER##');
				$description = str_replace($meta_datas, $listing_data, $meta_desciptions['description']);
		}
		else {
			$description='Get  location, contact  phone numbers, email, user  reviews & ratings and more details of '.$shop_name.' listed under '.$category_name. ' in '.$data['result']['area_name'].' ,'.$data['result']['city_name']; 
		}
		if(isset($meta_desciptions['keywords']) && $meta_desciptions['keywords']!='') {
			
			$listing_data=array($shop_name,$data['result']['city_name'],$data['result']['area_name'],$category_name,$my_adress, $contact_number);
			$meta_datas=array('##NAME##','##CITY##','##AREA##','##CATEGORY##', '##ADDRESS##', '##CONTACTNUMBER##');
			$title = str_replace($meta_datas, $listing_data, $meta_desciptions['keywords']);
		}
		else {
			$title=$data['result']['name'].' in '.$data['result']['area_name'].' '.$data['result']['city_name'].$category_name_list;
		}
		$notification_settings = @unserialize($data['result']['notification_settings']);
		if($notification_settings['custom_meta'] && $notification_settings['custom_meta']==1){
			if($data['result']['meta_keywords']!=''){
				
				$data['title_of_meta_keywords']=$data['result']['meta_keywords'];
			}
			if($data['result']['meta_description']!=''){
				$description=$data['result']['meta_description'];
			}
		}
		
		$data['title_of_layout']=$title;
		$data['title_of_description']=$description;
		$data['meta_rating']='General';
		if(!empty($data['result']['profile_image']) && file_exists('./'.$data['result']['image_dir'].$data['result']['profile_image']))
		{
		   $img_src = thumb(FCPATH.$data['result']['image_dir'].$data['result']['profile_image'],'218','159','list_thumb');
		   $image = base_url().$data['result']['image_dir'].'list_thumb/'.$img_src;
		   $data['meta_og_image']=$image;
		}
		$common_summary=admin_settings_initialize('common_summary');
		$replace_datas=array('##NAME##','##CITY##','##AREA##','##CATEGORY##');
		$bread_cat=$category_name;
		if($category_name==''){$category_name="yellow pages";}
		$linkreplace_datas=array('##LINKNAME##','##LINKCITY##','##LINKAREA##','##LINKCATEGORY##');
		$listing_data=array($shop_name,$data['result']['city_name'],$data['result']['area_name'],$category_name);
		$common_summary_data=str_replace($replace_datas, $listing_data, $common_summary['common_summary']);
		$listing_link_data=array(url_title(strtolower($shop_name)),url_title(strtolower($data['result']['city_name'])),url_title(strtolower($data['result']['area_name'])),url_title(strtolower($category_name)));
		$data['common_summary']=str_replace($linkreplace_datas, $listing_link_data, $common_summary_data);
		$dynamic_content=str_replace($replace_datas, $listing_data, $common_summary['dynamic_content']);
		$data['dynamic_content']=str_replace($linkreplace_datas, $listing_link_data, $dynamic_content);
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		
		if(!empty($data['result']['city_name']))
		{
		   $this->breadcrumbs->push(ucfirst($data['result']['city_name']),base_url().'search/'.url_title(strtolower($data['result']['city_name'])));
		}
		if(!empty($data['result']['city_name']) && !empty($data['result']['area_name']))
		{
		   $this->breadcrumbs->push(ucfirst($data['result']['area_name']),base_url().'search/'.url_title(strtolower($data['result']['city_name'])).'/'.url_title(strtolower($data['result']['area_name'])));
		}
		if(!empty($bread_cat) && !empty($bread_cat))
		{
		   $cat_link=base_url().'category-search/'.url_title(strtolower($bread_cat)).'/'.url_title(strtolower($data['result']['city_name'])).'/'.url_title(strtolower($data['result']['area_name']));
		   $this->breadcrumbs->push(ucfirst($bread_cat),$cat_link);
		}
		
		$this->breadcrumbs->push(ucfirst($data['result']['name']),base_url());	
		$this->load->model('comment_model');
	    $data['advertisment_id']=$add_id;
		$data['gallery'] = $this->advertisment_model->get_advertisments_image($add_id);
		$data['user_comments']=$this->comment_model->get_comment_list($add_id);
		$data['main_content']=$this->load->view('advertisments/view', $data,true);
		
		$this->load->view('layouts/default',$data);
	}
	
	public function udateViewCount(){
		$id=$this->input->post('add_id');
		$view_count=$this->input->post('add_id');
		$user_id=$this->input->post('user_id');
		$this->advertisment_model->update_views_counts($id,$view_count,$user_id);	
	}
	
	#Add Advertismnets
	public function add(){
		
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$data=array();
		$data['user_business_data']=$this->advertisment_model->get_user_businessdata($this->session->userdata('user_id'));
		$advertimentsId=$data['user_business_data']['id'];	
		
		$isActive=(isset($data['user_business_data']['is_active']) && $data['user_business_data']['is_active']==1) ? $data['user_business_data']['is_active'] : 0 ;	
		$plan_id=(isset($_POST['plan_id'])) ? $_POST['plan_id'] : $data['user_business_data']['plan_id'];	
		$plan_redirect_url=base_url().'customers/buyPlan?plan_id='.$plan_id;
		if($_POST) {
			
			
			$step_complete=false;			
			$profile_image=array();
			if(!empty($_FILES) && $_FILES['profile_image']['name']!='') {
			
                $dir=$this->config->item('profile_url').$this->session->userdata('user_id').'/';    
                if (!is_dir($$dir))
                {
                  mkdir($dir, 0777, true);
                }
			  $config['upload_path']   =  $dir;
			  $config['allowed_types'] =   "gif|jpg|jpeg|png";	
			  $config['file_name'] =   md5(date('Ymdhis'));
			  $this->load->library( 'upload' ,  $config);
			  if(!$image_up = $this->upload->do_upload('profile_image'))
			  {
				  $json_array['status']="error";
				  $json_array['sts']="custom_err";
				  $json_array['msg']="Profile Could Not Be Saved";	
				  $json_array['error_msg']="Invalid File";
				  echo json_encode($json_array);
				  die;	
			  }
			  else
			  {
			      
                $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $profile_image['profile_image']= $config['file_name'].'.'.$ext;
                $profile_image['image_dir']=$dir;							 
				  
			  }
			}
			
			$validationField=false;
	
			$this->form_validation->set_rules('name','Business Name','trim|required');
			$this->form_validation->set_rules('owner','Contact Person','trim|required');
			$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|required|valid_email');
			$this->form_validation->set_rules('website','Website','trim|valid_url_format');
			$this->form_validation->set_rules('contact_number','Contact Number','trim|required');
			$this->form_validation->set_rules('since','Since','trim|required|numeric');
			$this->form_validation->set_rules('main_category','Category','trim|required');
	
			$this->form_validation->set_rules('address_line','Address','trim|required');
			$this->form_validation->set_rules('city','City','trim|required');
			$this->form_validation->set_rules('area','Area','trim|required');
			$this->form_validation->set_rules('zip','Zip','trim|required');
			$this->form_validation->set_rules('working_start','Start Time','trim|required');
			$this->form_validation->set_rules('working_end','End Time','trim|required');

			$this->form_validation->set_rules('description','Specify Your Business','trim|required');
				

			$this->form_validation->set_rules('facebook_url','Facebook Url','trim|valid_url_format');
			$this->form_validation->set_rules('googleplus_url','Google+ Url','trim|valid_url_format');
			$this->form_validation->set_rules('twitter_url','Twiiter Url','trim|valid_url_format');
			$this->form_validation->set_rules('linkedin_url','Linkedin Url','trim|valid_url_format');
			$this->form_validation->set_rules('youtube_url','Youtube Url','trim|valid_url_format');
			if($this->form_validation->run() == false){ 				
				echo $this->form_validation->get_json();
				die;
			}	
            else {
				
				if($advertimentsId!=0){
					$success=$this->advertisment_model->edit_business($advertimentsId,$this->session->userdata('user_id'),$profile_image);
					$extra_array = array('status'=>'success','msg'=>'Your Business Profile Updated Successfully');	
					echo json_encode($extra_array);
					die;					
				}
				else{
					$success=$this->advertisment_model->add_business($this->session->userdata('user_id'), $profile_image);					
					$json_array['status']="success";	
					$json_array['error_msg']="";
					echo json_encode($json_array);
					die;
				}
			}
			die;			
		}
		
		#Set Meta Title And Keyword
		$data['title_of_layout']=$this->site_name." - ".'Register Your Business';
		
		$data['main_content']=$this->load->view('advertisments/add', $data,true);
		$this->load->view('layouts/default',$data);
	} 
}  