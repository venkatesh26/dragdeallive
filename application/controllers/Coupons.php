<?php

class Coupons extends CI_Controller {

    public function __construct() {
		
        parent::__construct();
		$this->load->model('coupon_model');
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }

	#################### Search Categories ############
	public function get_search_categories_data($keyword=null) {
	
		if($keyword) 
		{
			$this->db->like('name', $keyword,'after'); 
		}
		$this->db->where('is_active','1');
		$this->db->select('id,name');
		$query = $this->db->get('coupons_category');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'text'=>$g->name);
		}
		return $arr;
	}
	
	##################### Search Category #################
	public function search_category(){
		$search_text=(isset($_GET['search'])) ? $_GET['search']:'';
		$data=$this	->get_search_categories_data($search_text);
		echo json_encode($data);
		die;
	}
	
	############## Front End index ##############
	public function index() { 
	

	    $data=array();
		$config=array();
	
		$this->load->library('pagination');
		$this->load->helper('thumb');
		
		#Query String
		$category_name=(isset($_GET['category']))?ucwords(str_replace('-',' ',$_GET['category'])):'';
		
		
		
		#Query String
		$city=(isset($_GET['coupon_city']) && $_GET['coupon_city']!='0')?$_GET['coupon_city']:'';
		$area=(isset($_GET['coupon_area']) && $_GET['coupon_area']!='0')?$_GET['coupon_area']:'';
		$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';		
		$add_id=(isset($_GET['add_id']))?$_GET['add_id']:'';		
		
		############# Category Search ###################
	
		if(($this->uri->segment('1')=='coupon-category-search') && $this->uri->segment('2')!=''){
			$city=ucwords(str_replace('-',' ',$this->uri->segment('2')));	
		}
		if(($this->uri->segment('1')=='coupon-category-search') && $this->uri->segment('3')!=''){
			$area=ucwords(str_replace('-',' ',$this->uri->segment('3')));	
		}
		if($this->uri->segment('1')=='coupon-category-search' && $this->uri->segment('4')!='')
		{
			$category_name=$this->uri->segment('4');	
		}
		
		$query_string='?city='.$city.'&area='.$area.'&keyword='.$keyword.'&category='.$category_name.'&add_id='.$add_id;;
		
		#Pagination Settings
		$config['suffix'] = $query_string;
		$config['base_url'] = base_url().'coupon/index';
		$config['first_url'] = base_url().'coupon/index'.$query_string;
		$config['per_page'] = '8';
		$config['num_links'] = '3';
		$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
		$config["full_tag_open"] = '<div class="page-nav td-pb-padding-side">';
		$config["full_tag_close"] = '</div>';
		$config["cur_tag_open"] = '<span class="current">';
		$config["cur_tag_close"] = '</span>';
		$s=0;
		if($this->uri->segment(3)!='' && $this->uri->segment(1)!='search' && $this->uri->segment(1)!='coupon-category-search')
		{
			$s=$this->uri->segment(3);
		}
		if($this->uri->segment('1')=='coupon-category-search' && $this->uri->segment('2')!='')
		{
			$category_name=ucwords(str_replace('-',' ',$category_name));
		}
		$page = ($this->uri->segment(3) && $this->uri->segment(1)!='search') ? $s : 0;
		
		#Get Coupons List
		$data["list"] = $this->coupon_model->get_coupon_list('all',$config['per_page'], $page,$city,$area,$keyword,$category_name, $add_id);
		$config['total_rows'] = $data["list"]['all_total_rows'];
		$this->pagination->initialize($config);
		$data["pagination_link"]= $this->pagination->create_links();
		$data['category_list']=array();
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push("Coupons",base_url().'coupons');	
		
		if(!empty($city) && $city!='0'){
		   $this->breadcrumbs->push(ucfirst($city),base_url().'coupon-category-search/'.url_title(strtolower($city)));
		}
		if(!empty($area) && $area!='0' && !empty($city) && $city!='0'){
		   $this->breadcrumbs->push(ucfirst($area),base_url().'coupon-category-search/'.url_title(strtolower($city)).'/'.url_title(strtolower($area)));	
		}
		
		$data['total_count']=$config['total_rows'];
		$data['search_header_title']="Coupons";
		$data['main_content']=$this->load->view('coupons/list', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
	
	################### Coupon View ###################
	public function view($id) {
	    $getValues = $this->coupon_model->get_coupon_detail($id);
		$related_coupons = $this->coupon_model->get_related_coupons($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)==0) {
			redirect(base_url());
		}
		$this->load->helper('thumb_helper');
		$this->breadcrumbs->push('Coupons', base_url().'coupons');
		$this->breadcrumbs->push(ucwords($getValues['city_name']), base_url().'coupons/index?coupon_city='.$getValues['city_name']);
		$this->breadcrumbs->push(ucwords($getValues['area_name']), base_url().'coupons/index?coupon_city='.$getValues['city_name'].'&coupon_area='.$getValues['area_name']);
		$this->breadcrumbs->push(ucwords($getValues['name']), base_url().'coupons/view');
		$data['result'] = $getValues;
		$data['related_coupons'] = $related_coupons;	
		$data['price_range']=array();
		if($getValues['offer_type']==2){
			$data['price_range']=$this->coupon_model->priceRangeList($getValues['id']);
		}
		$data['keyword_data']=$this->coupon_model->keyword_data($getValues['id']);
		$data['main_content']=$this->load->view('coupons/view', $data,true);
		$data['title_of_layout']=$getValues['name'].' in '.$getValues['city_name'].','.$getValues['area_name'] .' at '.$getValues['add_name'].' | '.$this->site_name;
		$data['title_of_description']=$getValues['description'];
		$this->load->view('layouts/default',$data);
	}
	
	
	############## Download Coupon Code ###############
	public function download_coupons(){
		
		if($_POST && $_POST['coupon_id']!=''){
			
			$response=array();
			$coupon_id=(isset($_POST['coupon_id'])) ? $_POST['coupon_id'] :'';
			$user_id=($this->session->userdata('user_id')) ? $this->session->userdata('user_id') :'';
			$add_id=(isset($_POST['add_id'])) ? $_POST['add_id'] :'';
			if($user_id!='')
			{
				$coupon_response=$this->coupon_model->checkAlreadyDownload($coupon_id,$add_id,$user_id);
				if($coupon_response['is_download']==0){
					
					$coupon_code_response=$this->coupon_model->download_coupon_code($coupon_id,$add_id,$user_id);
					if($coupon_code_response['is_available']==1){
			
						$coupon_data=$this->coupon_model->couponDetails($coupon_id);
					    $this->load->model('campaign_model');
						$this->data['user_info']=$this->campaign_model->sms_availabilty($coupon_data['user_id']);
						$total_sms=$this->data['user_info']['total_sms'];
						$json_array['msg']="Coupons Downloaded Successfully!";	
						$json_array['error_msg']="Coupons  Downloaded Successfully";
						if($total_sms > 0){
							$this->sendMobileNotification($coupon_data, $coupon_code_response['coupon_code'] , $_POST['mobile_number']);
							$is_sms_send=true;
						}
						else{
						  $json_array['msg']="Coupons Downloaded Successfully! Currently Sms Not Available";	
						  $json_array['error_msg']="Coupons  Downloaded Successfully";
						  $is_sms_send=false;
						}
						$json_array['sent_sms']=$is_sms_send;
						$json_array['status']="success";
						$json_array['coupon_code']=$coupon_code_response['coupon_code'];
						echo json_encode($json_array);
						die;
					}
					else{
						$json_array['status']="error";
						$json_array['coupon_code']='';
						$json_array['msg']="Sorry Download Limit Exceeds..!";	
						$json_array['error_msg']="Sorry Download Limit Exceeds!";
						echo json_encode($json_array);
						die;
					}
				}
				else {
					$json_array['status']="error";
					$json_array['sts']="custom_err";
					$json_array['msg']="Coupons Already Downloaded!";	
					$json_array['error_msg']="Coupons Already Downloaded!";
					echo json_encode($json_array);
					die;	
				}
			}
		}
		die;
	}
	
	
	######## Send Coupon Notification To Mobile Number ######
	public function sendMobileNotification($coupon_data, $coupon_code , $mobile_number){
		$user_profile_info=user_profile_info($coupon_data['user_id']);
		$this->load->model('campaign_model');
		$this->load->model('cron_model');
		$datas=array('##CODE##', '##TITLE##', '##NAME##', '##SHOPNAME##', '##ADD##', '##URL##');
		$url=base_url().'coupons/'.$coupon_data['id'].'/'.url_title(strtolower($coupon_data['name']));
		$url=$this->googleShortUrl($url);
		$senderInfo=$this->cron_model->getSendId($coupon_data['user_id']);
		$address=$coupon_data['address_line']." ".$coupon_data['city_name'];
		$replace_data=array($coupon_code, $coupon_data['name'], $user_profile_info['name'], ucwords($coupon_data['add_name']), $address, $url);
		$coupon_messaage=admin_settings_initialize('coupon_messaage');
		$message = str_replace($datas, $replace_data, $coupon_messaage['coupon_messaage']);
		$sender_info=array();
		$sender_info['user_id']=$this->session->userdata('user_id');
		$sender_info['sender_id']=$senderInfo['sender_id'];
		$status=$this->cron_model->send_message($mobile_number, $message, $sender_info);
		$sms_send_count = 1;
		$noOfMessage=1;
		$total_sms_send= 1 * $noOfMessage;
		$this->campaign_model->debitSms($coupon_data['user_id'], $total_sms_send);	
	}
	
	########### Get Shorten Url ########
	public function googleShortUrl($url){
		$apiKey = 'AIzaSyDIKdXDrC-mJC0KfSlu1PwdVqTFum6I-Tw';
		$post_data = json_encode( array( 'longUrl'=>$url ) );
		$ch= curl_init();
		$arr = array();
		array_push($arr, 'Content-Type: application/json; charset=utf-8');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
		curl_setopt($ch, CURLOPT_URL,"https://www.googleapis.com/urlshortener/v1/url?key=".$apiKey);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER,base_url());
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		$short_url = json_decode($output);
		$msg = $short_url->id;
		curl_close($ch);
		return $msg;
	}
	
	############### Admin Panel ##################### 
	public function admin_index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'blogs.title','created' =>'blogs.created','name' =>'blogs.name','owner_name' =>'blogs.owner','address'=>'address_line','city_name'=>'cities.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'blogs.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/blogs/active';
			$data['indextitle']  = 'Blogs - Active List';
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'blogs.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/blogs/inactive';
			$data['indextitle']  = 'Blogs - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/blogs/index';
			$data['indextitle']  = 'Blogs List';
			$data['type'] = 'index';
		}
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$this->pagination->cur_page = $page_num;
		$config['first_url'] = $config['base_url'].'/1/'.$sortfield.'/'.$order;

		 //search 
		 $data['keyword'] = '';
		 $data['keyword'] = $this->input->post('keyword');
		 $data['search_submit'] =$this->input->post('search_submit');
		
		/*********** pagination search ********************/
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword'] ));
		if($data['keyword']){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
		}
		else
		{ 
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['search_submit'] && $sortfield != 'reset'){
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/

		 if($data['keyword']  )
		 {
		$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(blogs.name LIKE '%" . $data['keyword'] . "%'", 'value'=> null);
		$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "blogs.owner LIKE '%" . $data['keyword'] . "%'", 'value' => null);
        $conditions[] = array( 'direct'=>0,  'rule' => 'or_where', 'field' => "blogs.email like '%" . $data['keyword'] . "%')", 'value'=> null); 	
		 }
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['blogs'] = $this->blog_model->get_blogs( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->blog_model->get_blogs( 0 , $conditions, '', '', '', ''); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/blogs/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/blogs/index';
		$data['title']="Blogs";
		$this->load->view('includes/template', $data);
	}

	
	function update_status($id, $status, $pageredirect=null,$pageno) { 
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($status == 'enable')
		{
			$data = array('is_active' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		} 
		else if($status == 'disable')
		{
			$data = array('is_active' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		} 
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->blog_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function bulkautions($pageredirect=null,$pageno) {
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->blog_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled'));
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->blog_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
		
	public function admin_view($id) {
	    $getValues = $this->blog_model->get_blog_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Blogs', base_url().ADMIN.'/blogs');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/blogs_view/view');
			$this->data['blogs'] = $getValues;	
			$this->data['main_content'] = 'admin/blogs/view';
			$this->data['title']="View Blog Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	function delete($id) {
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->blog_model->delete($id)) 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	###################### Coupons Add #####################
	public function coupons_edit($id) {
		$this->load->helper('ckeditor_helper');
		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			
			$url = 'login';
			redirect($url);
		}
        $this->MyaddId=get_my_addId($this->session->userdata('user_id'));
		if($this->MyaddId=='' || $this->MyaddId==0){
			
			$this->session->set_flashdata('error', $this->lang->line('Please Complete Your Business Profile..!'));
			$url="business-profile";
			redirect($url);
		}
		$getValues = $this->coupon_model->get_values($id, $this->session->userdata('user_id'));
		if(empty($getValues)){
			
			$this->session->set_flashdata('error', $this->lang->line('Invalid Coupon!'));
			$url="coupons-list";
			redirect($url);
		}
		$price_data=array();
		if($getValues['offer_type']==2){
			$price_data = $this->coupon_model->get_price_values($id);
		}
		$data['categories_data']=$this->coupon_model->get_user_categories_data();
		
		$data['get_selected_data']=array();
		if($id!=''){
		  $data['get_selected_data']=$this->coupon_model->get_add_or_edit_business_data($id);	
		}
		$output = '';
		foreach($data['categories_data'] as $key=>$item){
			
			if(in_array($key, $data['get_selected_data']))
			{
			  $output.= '<option value="' . $key . '"' . (in_array($key, $data['get_selected_data']) ? ' selected' : '') . '>' . $item . '</option>';
			}
		}
		$this->data['keywords_data']=$output;
		
		$this->data['title_of_layout']=$this->site_name." - Edit Coupons";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Edit Coupons',base_url());
		if($_POST) {
	
			$this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('description','Description','trim|required');
			$this->form_validation->set_rules('total_coupon','Total Coupons','trim|required');
			$this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
			if($this->input->post('offer_type')==1){

			$this->form_validation->set_rules('original_price','MRP','trim|required|number');
			$this->form_validation->set_rules('offer_price','Offer Price','trim|required|number|callback_offer_price_validate');
			}
			if(!isset($_POST['keywords'])){
			$this->form_validation->set_rules('keywords','keywords','trim|required');
			}
			if($this->form_validation->run() == true) 
			{
				$image_data=array();
				if(!empty($_FILES['profile_image']['name']))
				{
					$config['upload_path']   =  $this->config->item('coupon_icon_url');
					$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
					$this->load->library( 'upload' ,  $config);
					$this->upload->initialize($config);
					$image_up = $this->upload->do_upload('profile_image');
					$image_data =  array('upload_data' => $this->upload->data());
				}
				$success=$this->coupon_model->update_coupons($this->session->userdata('user_id'),$this->MyaddId, $id, $image_data);				
				if($success) 
				{
					$extra_array = array('status'=>'success','msg'=>'Coupons Updated Successfully.');
					echo json_encode($extra_array);
					die;					
				}				
			} 
			else {
				echo $this->form_validation->get_json();
				die;
			}
		}
		$this->data['coupon_data']=$getValues;
		$this->data['price_data']=$price_data;
		$this->data['main_content']=$this->load->view('coupons/coupons_edit', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
	
	########################### Customer List #################
    public function coupons_list() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Coupons List',base_url());
		#Set Meta Title And Keyword
		if ($this->input->is_ajax_request()) {
			$page_num=$this->uri->segment(3);
			$cofig =array();
			$config = admin_settings_initialize('settings');
			$order_list=array();
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'mycoupons/coupon-list';
			$config['first_url'] = base_url().'mycoupons/coupon-list';
			$config['per_page'] = 5;
			$config['num_links'] = 3;
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$order_list=$this->coupon_model->getCouponsList($this->session->userdata('user_id'),$limit_start,$limit_end);
			$this->data['order_list']=$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('coupons/coupons_list_json', $this->data,true);
			echo json_encode($this->data);
			die;
		} else {
			$this->data['title_of_layout']=$this->site_name." - ".'Coupons List';
			$this->data['main_content']=$this->load->view('coupons/coupons_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);
		}
	} 	
	
	###################### Coupons Add #####################
	public function coupons_add(){
		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			
			$url = 'login';
			redirect($url);
		}
        $this->MyaddId=get_my_addId($this->session->userdata('user_id'));
		if($this->MyaddId=='' || $this->MyaddId==0){
			
			$this->session->set_flashdata('error', $this->lang->line('Please Complete Your Business Profile..!'));
			$url="business-profile";
			redirect($url);
		}
		$this->data['title_of_layout']=$this->site_name." - Add Coupons";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Add Coupons',base_url());
		$this->load->model('campaign_model');
		$this->data['filter_count']=$this->campaign_model->filterDatas($this->session->userdata('user_id'),1);
		$this->data['my_groups']=$this->campaign_model->my_groups($this->session->userdata('user_id'));	
		if($_POST) {
			
				$this->form_validation->set_rules('name','Name','trim|required');
				$this->form_validation->set_rules('description','Description','trim|required');
				$this->form_validation->set_rules('total_coupon','Total Coupons','trim|required');
				$this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
				if($this->input->post('offer_type')==1){
					
					$this->form_validation->set_rules('original_price','MRP','trim|required|number');
					$this->form_validation->set_rules('offer_price','Offer Price','trim|required|number|callback_offer_price_validate');
				}
				if(!isset($_POST['keywords'])){
					$this->form_validation->set_rules('keywords','keywords','trim|required');
				}
				if($this->input->post('send_notification')=='on' || $this->input->post('send_notification')==1){
					$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
					$this->data['total_sms']=$this->data['user_info']['total_sms'];
				    $this->form_validation->set_rules('message','Message','trim|required');
					$noOfMessage=ceil(strlen($this->input->post('message'))/160);
					if($this->data['total_sms'] <= 0 ) {
						$extra_array = array('status'=>'error','sts'=>'custom_mess_err','msg'=>'<i class="fa fa-info-circle"></i> Please Choose Your Sms Plan');
						echo json_encode($extra_array);
						die;	
					}
					else if($this->input->post('filter_count') <= 0 ) {
						$extra_array = array('status'=>'error','sts'=>'custom_mess_err','msg'=>'<i class="fa fa-info-circle"></i> Please Choose Atleast One Customers');
						echo json_encode($extra_array);
						die;	
					}
				}
				
				if($this->form_validation->run() == true)  {
					$image_data=array();
					if(!empty($_FILES['profile_image']['name'])) {
						$config['upload_path']   =  $this->config->item('coupon_icon_url');
						$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
						$this->load->library( 'upload' ,  $config);
						$this->upload->initialize($config);
						$image_up = $this->upload->do_upload('profile_image');
						$image_data =  array('upload_data' => $this->upload->data());
					}
					$success=$this->coupon_model->add_coupons($this->session->userdata('user_id'), $this->MyaddId , $image_data);				
					if($success['status']==1) 
					{
						
						
						if($this->input->post('send_notification')=='on' || $this->input->post('send_notification')==1){
						
						$url=base_url().'coupons'.'/'.$success['last_insert_id'].'/'.url_title(strtolower($this->input->post('name')));
						$sendIdInfo=$this->cron_model->getSendId($this->session->userdata('user_id'));
						$senderid=(isset($sendIdInfo['id'])) ? $sendIdInfo['id']  : 0;  
						$datas=$this->coupon_model->saveCouponCampaigns($this->session->userdata('user_id'),3,$senderid);				
						if($datas['status']==1)  {
							
							$noOfMessage=ceil(strlen($this->input->post('message'))/160);
							$filter_datas=array();
							$customer_list=$this->campaign_model->filterDatas($this->session->userdata('user_id'),0);
							$totalSmsSend=$noOfMessage * count($customer_list);
							$total_sms=($this->data['total_sms'] - $totalSmsSend);	
							if($total_sms <=0) {
								$total_sms=0;
								$customer_list_count=floor(count($customer_list)/$noOfMessage);
								$customer_list=array_slice($customer_list,$customer_list_count);
							}	
							$sender_id=(isset($sendIdInfo['sender_id']) && $sendIdInfo['sender_id']) ? $sendIdInfo['sender_id'] : 0;						
							$number_of_user_received=$this->coupon_model->saveCouponCampaignList($datas['id'],$customer_list,count($customer_list),3,$this->session->userdata('user_id'),$sender_id,$url);	
							$total_sms_send=$number_of_user_received['number_of_user_received'] * $noOfMessage;
							$this->campaign_model->debitSms($this->session->userdata('user_id'),$total_sms_send);
					   }
					}
                        $extra_array = array('status'=>'success','msg'=>'Coupons Add Successfully.');
						echo json_encode($extra_array);
						die;					
					}				
				} 
				else 
				{
					echo $this->form_validation->get_json();
					die;
				}
		}
		$this->data['main_content']=$this->load->view('coupons/coupons_add', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
	
	 public function offer_price_validate()
    {
        if ($this->input->post('original_price') > $this->input->post('offer_price')) //Use your logic to check here
        {
			return TRUE;
        }	
       $this->form_validation->set_message('user_mail_check', 'The %s price not greathan MRP');
       return FALSE;
    }

	
	##################### Downlaod Coupons List #################
	public function downloaded_coupon_list() {
		
		
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Downloaded Coupons List',base_url());
		#Set Meta Title And Keyword
		if ($this->input->is_ajax_request()) {
			$page_num=$this->uri->segment(3);
			$cofig =array();
			$config = admin_settings_initialize('settings');
			$order_list=array();
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'coupons/downloaded_coupon_list';
			$config['first_url'] = base_url().'coupons/downloaded_coupon_list';
			$config['per_page'] = 5;
			$config['num_links'] = 3;
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$order_list=$this->coupon_model->getDownloadedCouponsList($this->session->userdata('user_id'),$limit_start,$limit_end);
			$this->data['order_list']=$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('coupons/download_list_json', $this->data,true);
			echo json_encode($this->data);
			die;
		} else {
			$this->data['title_of_layout']=$this->site_name." - ".'Coupons List';
			$this->data['main_content']=$this->load->view('coupons/downloaded_coupons_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);
		}
	}
	
	################### Update Coupons Status ################
	public function updateCoupon() {
		
		$json_array=array();
		$json_array['status']=0;
		if(isset($_POST)){
			
			$coupon_id=$_POST['coupon_id'];
			$user_id=$this->session->userdata('user_id');
			$this->coupon_model->updateCoupon($coupon_id,$user_id);
			$json_array['status']=1;
		}
		echo json_encode($json_array);
		die;	
	} 

	######################### Export All Coupons ######################
	public function ExportDownloadedCouponsCode() {
	    
		$headers= array('Downloaded Date','Coupon Name','User Name','Code','Expiry Date');
		$conditions=array();
		$order=array();
		$data['excel'] = $this->coupon_model->export_download_coupons_code($this->session->userdata('user_id')); 	
		$this->load->library('Excel');
		$report = array();
		$data_filters=array();
		$data_datas=array();
		
		if(!empty($data['excel'])){
			
			foreach ($data['excel'] as $key=>$excel) {
				
				$report[$key]['Downloaded Date'] = $excel['modified'];
				$report[$key]['Coupon Name'] = $excel['coupon_name'];
				$report[$key]['User Name'] = $excel['user_name'];
				$report[$key]['Code'] = $excel['code'];
				$report[$key]['Expiry Date'] = $excel['exipry_date'];
			}
			$this->excel->export( $report,$headers,'coupons_list__'.date('Y-m-d h:i:s').'.xls', true,$data_filters,$data_datas);	
		}
	}

	######################### Export All Coupons ######################
	public function ExportCouponsCode() {
	    
		$coupon_id=(isset($_GET['coupon_id']))?$_GET['coupon_id']:'';
		if($coupon_id==''){
			$url = 'dashboard';
			redirect($url);
		}
		$headers= array('Created','Coupon Name','Description','Expiry Date','Status','Code');
		$conditions=array();
		$order=array();
		$data['excel'] = $this->coupon_model->export_all_coupons($coupon_id, $this->session->userdata('user_id')); 	
		$this->load->library('Excel');
		$report = array();
		$data_filters=array();
		$data_datas=array();
		
		if(!empty($data['excel'])){
			
			foreach ($data['excel'] as $key=>$excel) {
				
				$report[$key]['Created'] = $excel['created'];
				$report[$key]['Coupon Name'] = $excel['name'];
				$report[$key]['Description'] = $excel['description'];
				$report[$key]['Expiry Date'] = $excel['exipry_date'];
				$s="In Active";
				if($excel['is_active']==1)
				{
					$s="Active";
				}
				$report[$key]['Status'] = $s;
				$report[$key]['Code'] = $excel['code'];
			}
			$this->excel->export( $report,$headers,'coupons_list__'.date('Y-m-d h:i:s').'.xls', true,$data_filters,$data_datas);	
		}
	}
	
	################ Export My Coupons ###################
	public function ExportMyCouponsCode(){
	   
		$headers= array('Created','Coupon Name','Description','Expiry Date','Status','Code');
		$conditions=array();
		$order=array();
		$data['excel'] = $this->coupon_model->export_my_coupons($this->session->userdata('user_id')); 	
		$this->load->library('Excel');
		$report = array();
		$data_filters=array();
		$data_datas=array();
		
		if(!empty($data['excel'])){
			
			foreach ($data['excel'] as $key=>$excel) {
				
				$report[$key]['Created'] = $excel['created'];
				$report[$key]['Coupon Name'] = $excel['name'];
				$report[$key]['Description'] = $excel['description'];
				$report[$key]['Expiry Date'] = $excel['exipry_date'];
				$s="In Active";
				if($excel['is_active']==1)
				{
					$s="Active";
				}
				$report[$key]['Status'] = $s;
				$report[$key]['Code'] = $excel['code'];
			}
			$this->excel->export( $report,$headers,'my_coupons_list__'.date('Y-m-d h:i:s').'.xls', true,$data_filters,$data_datas);	
		}
	}
	
	################### My Coupons #################
	public function my_coupons(){
		
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('My Coupons List',base_url());
		#Set Meta Title And Keyword
		if ($this->input->is_ajax_request()) {
			$page_num=$this->uri->segment(2);
			if(!is_numeric($page_num)){
				$page_num=1;
			}
			$cofig =array();
			$config = admin_settings_initialize('settings');
			$order_list=array();
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'my-coupons';
			$config['first_url'] = base_url().'my-coupons';
			$config['per_page'] = 5;
			$config['num_links'] = 3;
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$order_list=$this->coupon_model->getMyCouponsList($this->session->userdata('user_id'),$limit_start,$limit_end);
			$this->data['order_list']=$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('coupons/my_coupons_list_json', $this->data,true);
			echo json_encode($this->data);
			die;
		} else {
			$this->data['title_of_layout']=$this->site_name." - ".'Coupons List';
			$this->data['main_content']=$this->load->view('coupons/my_coupons', $this->data,true);
			$this->load->view('layouts/customer', $this->data);
		}
	}
}


?>