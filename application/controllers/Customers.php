<?php

class Customers extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('home_model');
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->myUserId=$this->session->userdata('user_id');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	
    ######## After Login Claim My Business #########
	public function claim_bussiness(){
		$data=array();
		if(!$this->session->userdata('is_user_logged_in')){
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Claim My Business',base_url());
		$sms_info=admin_settings_initialize('sms_cost');
		$data['sms_cost']=$sms_info['sms_cost'];
		if($_POST) {
			$this->form_validation->set_rules('url',ucwords($this->lang->line('Url')),'trim|required|valid_url_format');
			$this->form_validation->set_rules('message',ucwords($this->lang->line('message')),'trim|required|min_length[3]');
			if($this->form_validation->run() == true) {
				if($this->home_model->add_claim('after_login', $this->session->userdata())) {
				  $json_array['status']="success";
				  $json_array['msg']="Your Request Accepted Successfully.We Shotly Contact You.";	
				  $this->session->set_flashdata('success','Your Request Accepted Successfully.We Shotly Contact You.'); 
				  echo json_encode($json_array);	
				  die; 
				}	
				else {
				  $json_array['status']="error";
				  $json_array['sts']="custom_err";
				  $json_array['msg']="Claim Could not be saved.Please Try Again..!";	
				  echo json_encode($json_array);	
				  die;	
				}						 
			}
			else {
				echo $this->form_validation->get_json();
				die;	
			}
		}
		else {
			#Set Meta Title And Keyword
			$data['title_of_layout']=$this->site_name." - ".'Business Claims';	
			$data['main_content']=$this->load->view('customers/claim_bussiness', $data,true);
			$this->load->view('layouts/customer', $data);
		}		
	}
	
	   
	######## SMS Credit #########
	public function sms_credit(){
		$data=array();
		if(!$this->session->userdata('is_user_logged_in')){
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Sms Credit',base_url());
		$sms_info=admin_settings_initialize('sms_cost');
		$data['sms_cost']=$sms_info['sms_cost'];
		if($_POST)  {	
				$this->form_validation->set_rules('sms_pack','Pack','trim|required');
				if($this->input->post('sms_pack')=='custom'){
					$this->form_validation->set_rules('total_sms','Amount','trim|required');
				}
				if($this->form_validation->run() == true) {
					$insta_settings=admin_settings_initialize('instamojo_settings');							
					################### Load Instamojo Class Files ###########
					
					$plan_packages=array(
						'bronze'=>1000,
						'sliver'=>2000,
						'gold'=>5000,
						'platinum'=>10000,
						'custom'=>$this->input->post('total_sms')
					);
					
					$plan_packages_list=array(
						'bronze'=>1,
						'sliver'=>2,
						'gold'=>3,
						'platinum'=>4,
						'custom'=>0
					);
					
					$price=$data['sms_cost'] * $plan_packages[$this->input->post('sms_pack')];
					if($this->input->post('sms_pack')=='custom'){
						$price=$this->input->post('total_sms');
					}
					$this->advertisment_model->saveSmsPaymentClicks($this->session->userdata('user_id'),$plan_packages_list[$this->input->post('sms_pack')]);
					$link=base_url().'customers/sms_credit_payu?sms_pack='.$this->input->post('sms_pack').'&sms_amount='.$price;
					$data['url']=$link;
					$extra_array = array('url'=>$data['url'],'status'=>'success','msg'=>'Sms Redirect');
					echo json_encode($extra_array);
					die;
					
					$this->load->library('instamojo',array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
					$api =new Instamojo(array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
					
					
					 $response = $api->linkCreate(array(
						'title'=>ucwords($this->input->post('sms_pack')),
						'description'=>ucwords($this->input->post('sms_pack')),
						'base_price'=>$price,
						'buyer_name'=>$this->session->userdata('user_name'),
						'send_email'=>$this->session->userdata('user_email'),
						'amount'=>$price,
						'custom_fields'=>array('customer_id'=>$this->session->userdata('user_id')),
						'email'=>$this->session->userdata('user_email'),
						'redirect_url'=>base_url().'home/sms_credit_response',
						'cover_image'=>base_url().'assets/img/list_logo.png'
					));
					if(isset($response) && !empty($response))
					{
						$this->advertisment_model->saveSmsPaymentClicks($this->session->userdata('user_id'),$plan_packages_list[$this->input->post('sms_pack')]);
						$data['status']=isset($response['url'])? 1 : 0;
						$data['url']=isset($response['url'])?$response['url']:'';
						$extra_array = array('url'=>$data['url'],'status'=>'success','msg'=>'Sms Redirect');
						echo json_encode($extra_array);
						die;	
					}
					else {
						$extra_array = array('url'=>$data['url'],'status'=>'error','msg'=>'Something Went Wrong');
						echo json_encode($extra_array);
						die;	
					}
			}
			else {
				echo $this->form_validation->get_json();
				die;
			}			
		}
		else{
			#Set Meta Title And Keyword
			$data['title_of_layout']=$this->site_name." - ".'SMS Credit';	
			$data['main_content']=$this->load->view('customers/sms_credit', $data,true);
			$this->load->view('layouts/customer', $data);
		}		
	}
	
	######## SMS Credit Payu #########
	public function sms_credit_payu(){

		$data=array();
		if(!$this->session->userdata('is_user_logged_in')){
			$url = 'login';
			redirect($url);
		}
		$sms_info=admin_settings_initialize('sms_cost');
		$data['sms_cost']=$sms_info['sms_cost'];
		
		$plan_packages_list=array(
			'bronze'=>1,
			'sliver'=>2,
			'gold'=>3,
			'platinum'=>4,
			'custom'=>0
		);
		if(isset($_GET['sms_pack']) && $_GET['sms_pack']!='' && in_array($_GET['sms_pack'],$plan_packages_list)){			
					$plan_packages=array(
						'bronze'=>1000,
						'sliver'=>2000,
						'gold'=>5000,
						'platinum'=>10000,
						'custom'=>100
					);	
					$price=$data['sms_cost'] * $plan_packages[$_GET['sms_pack']];
					if($this->input->post('sms_pack')=='custom'){
						$price=$_GET['sms_amount'];
					}
					$user_profile_info=user_profile_info($this->session->userdata('user_id'));
					if($user_profile_info['name']=='' || $user_profile_info['mobile_number']=='' || $this->session->userdata('user_email')=='') {	
						$this->session->set_flashdata('error','Please Complete Your Profile !'); 
						redirect('my-profile');
					}
					$this->advertisment_model->saveSmsPaymentClicks($this->session->userdata('user_id'),$plan_packages_list[$_GET['sms_pack']]);
					
					$plan_details=array('price'=>$price, 'description'=>$_GET['sms_pack']);
					
					#Set Meta Title And Keyword
					$data['title_of_layout']=$this->site_name." - ".'SMS Credit';	
					$data['user_profile_info']=$user_profile_info;
					$data['plan_details']=$plan_details;
						$data['my_add_id']='';
					$data['main_content']=$this->load->view('customers/sms_payment_form', $data,true);
					$this->load->view('layouts/customer', $data);
		}
		else {
			$this->session->set_flashdata('error','Invalid Plan'); 
			redirect('sms-credit');
		}		
	}
	
	######## SMS Order Histroy #########
	function sms_chart_histroy() {
	
		$result=sms_chart_histroy($this->myUserId);
		echo json_encode($result);
		die;
	}
	
	######## SMS Order Histroy #########
	function sms_remainder_histroy() {
	
		$result=sms_remainder_histroy($this->myUserId);
		echo json_encode($result);
		die;
	}
	
	######## Send FeedBack #########
	public function send_feedback(){
		
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Send FeedBack',base_url());
		#Set Meta Title And Keyword
		$data['title_of_layout']=$this->site_name." - ".'Send FeedBack';	
		if($_POST) 
		{
				$this->form_validation->set_rules('message','Message','trim|required');
				if($this->form_validation->run() == true) 
				{
					$success=$this->advertisment_model->save_feed_backs($this->session->userdata('user_id'));				
					if($success) 
					{
                        $extra_array = array('status'=>'success','msg'=>'Your Feedback send Successfully');
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
		$data['main_content']=$this->load->view('customers/send_feedback', $data,true);
		$this->load->view('layouts/customer', $data);	
	}
	
	##### Enquiry List #############
	public function enquiry_list() {	
	
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->MyaddId=get_my_addId($this->myUserId);
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Business Enquiry List',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Enquiry List';
		if ($this->input->is_ajax_request()) {
		$page_num=$this->uri->segment(3);
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->pagination->cur_page = $this->uri->segment(3);
		$order_list=array();
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'customers/enquiry_list';
		$config['first_url'] = base_url().'customers/enquiry_list';
		$config['per_page'] = $config['per_page'];
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
		$order_list=$this->advertisment_model->getMyEnquiryList($this->MyaddId,$limit_start,$limit_end);	
		$this->data['order_list']=$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('customers/bussiness_enquiry_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('customers/bussiness_enquiry_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}	
	}
	
	##### Sender Id Section #############
	public function my_senderid() {	
	
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Manage Sender ID',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Manage SenderID';
		if ($this->input->is_ajax_request()) {
		$page_num=$this->uri->segment(3);
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->pagination->cur_page = $this->uri->segment(3);
		$order_list=array();
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'customers/my_senderid';
		$config['first_url'] = base_url().'customers/my_senderid
		';
		$config['per_page'] = $config['per_page'];
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
		$order_list=$this->advertisment_model->getMySenderIdList($this->myUserId,$limit_start,$limit_end);	
		$this->data['order_list']=$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('customers/my_senderid_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('customers/my_senderid_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}	
	}
	
	public function change_enquiry_status() {
		$id=$this->input->post('id');
		$is_active=$this->input->post('is_active');
		$this->advertisment_model->changeEnquiryStatus($id,$is_active);
		echo json_encode($json_array);
		die;
	}
	
	##################### Search Category #################
	public function search_category(){
		$search_text=(isset($_GET['search'])) ? $_GET['search']:'';
		$data=$this->advertisment_model->get_search_categories_data($search_text);
		echo json_encode($data);
		die;
	}
	
	##################### Search Category #################
	public function search_services(){
		$search_text=(isset($_GET['search'])) ? $_GET['search']:'';
		$data=$this->advertisment_model->get_search_categories_data($search_text,2);
		echo json_encode($data);
		die;
	}
	
	#####################Get My Orders List #################
	public function myorderslist() {
		$customer_list=array();
		$limit_start=10;
		$limit_end=0;
		$config['base_url'] = base_url().'listings/index';
		$config['first_url'] = base_url().'listings/index';
		$config['per_page'] = '9';
		$config['num_links'] = '3';
		$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
		$config["full_tag_open"] = '<div class="page-nav td-pb-padding-side">';
		$config["full_tag_close"] = '</div>';
		$config["cur_tag_open"] = '<span class="current">';
		$config["cur_tag_close"] = '</span>';
		$customer_list=$this->advertisment_model->getMyOrdersList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$config['total_rows'] = $customer_list['iTotalRecords'];
		$this->pagination->initialize($config);
		$data["pagination_link"]= $this->pagination->create_links();
		$data["list_data"]=$customer_list['data'];
		echo json_encode($data);
		die;
	}
	
	#####################Get All Customer List #################
	public function myCouponlist() {
		$customer_list=array();
		$limit_start=10;
		$limit_end=0;
		if(isset($_GET['iDisplayStart']))
		{
			$limit_end=$_GET['iDisplayStart'];
		}
		if(isset($_GET['iDisplayLength']))
		{
			$limit_start=$_GET['iDisplayLength'];
		}
		$customer_list=$this->advertisment_model->getCustomerList($this->session->userdata('user_id'),$limit_start,$limit_end);
		$data=array('iTotalRecords'=>$customer_list['iTotalRecords'],'sEcho'=>$_GET['sEcho'],'iTotalDisplayRecords'=>$customer_list['iTotalDisplayRecords'],'aaData'=>$customer_list['data']);
		echo json_encode($data);
		die;
	}
	
	################### Add Gallery #################
	public function gallery_add() {
		
		$this->MyaddId=get_my_addId($this->myUserId);
		$profile_image=array();
		if($this->MyaddId=='' || $this->MyaddId==0){
			
				$json_array['status']="error";
				$json_array['sts']="custom_err";
				$json_array['msg']="Please Complete Your  Business Profile.!";	
				$json_array['error_msg']="Please Complete Your  Business Profile.!";
				echo json_encode($json_array);
				die;	
		}
		else {
			
			if(!empty($_FILES) && $_FILES['profile_image']['name']!='')
			{
			  
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
				  $json_array['msg']="Image Could Not Be Saved !";	
				  $json_array['error_msg']="Invalid File !";
				  echo json_encode($json_array);
				  die;	
			  }
			  else
			  {
				$ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
				$profile_image['profile_image']= $config['file_name'].'.'.$ext;
				$profile_image['image_dir']=$dir;	
				$success=$this->advertisment_model->add_advertisments_image($profile_image,$this->MyaddId);
				if($success) 
				{
					$extra_array = array('status'=>'success','msg'=>'Image Updated Successfully');
					echo json_encode($extra_array);
					die;					
				} 
			  }
			}
			else{
				  $json_array['status']="error";
				  $json_array['sts']="custom_err";
				  $json_array['msg']="No Data Posted";	
				  $json_array['error_msg']="Invalid File";
				  echo json_encode($json_array);
				  die;
			}	
		}		
	}
	
	#################### Get Gallery Images ####################
	public function galleryList(){
		
		$this->MyaddId=get_my_addId($this->myUserId);
		$datas=$this->advertisment_model->get_advertisments_image($this->MyaddId);
		$content='';
		if(!empty($datas)){
			foreach($datas as $image_list) {
							
				   if(!empty($image_list['image_dir']) && file_exists('./'.$image_list['image_dir'].$image_list['profile_image']))
				   {
					   $img_src = thumb(FCPATH.$image_list['image_dir'].$image_list['profile_image'],'300','170','new_list_thumb');
					   $image = base_url().$image_list['image_dir'].'new_list_thumb/'.$img_src;
				   }
				   else
				   {
					   $image = base_url().'assets/img/list_logo.png';
				   }				
				$content.= '<div class="image-container">
					<div class="controls">
					<a href="#" class="control-btn remove delete-gallery" data-toggle="modal" data-target="#confirm-delete-modal" rel="'.$image_list['id'].'"> <i class="fa fa-trash-o"></i> </a>
					</div>
					<div class="image" style="background-image:url('.$image.')"></div>
					</div> ';
			}
		}
		else {
			$content='<span class="sms_chart no_sms_data" style="color: red;"> - No Gallery Found <span></span></span>';
		}
		echo json_encode($content);
		die;					
	}
	
	#####################Delete Gallery#################
	public function deleteGallery(){
		$gallery_delete=array();
		if(isset($_POST['id']))
		{
			$this->MyaddId=get_my_addId($this->myUserId);
			$gallery_delete=$this->advertisment_model->deleteGallery($_POST['id'], $this->MyaddId);
		}
		echo json_encode($gallery_delete);
		die;
	}
	
	################### My Gallery #################
	public function my_gallery() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Business Gallery',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Gallery';
		$this->data['main_content']=$this->load->view('customers/gallery', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	####################### Buy Packages ##################
	public function buyPackage() {
		
		$this->myUserId=$this->session->userdata('user_id');
		$this->MyaddId=get_my_addId($this->myUserId);
		if($this->MyaddId=='' || $this->MyaddId==0){
			
			$this->session->set_flashdata('error','Please Complete Your Profile !'); 
			redirect('business-profile');
		}
		else {
			
			if(isset($_GET['plan_id']) && $_GET['plan_id']!='') {
				
				$planDetails=$this->advertisment_model->getPlanDetails($_GET['plan_id']);
				if(!empty($planDetails)) {
					
					$insta_settings=admin_settings_initialize('instamojo_settings');							
					################### Load Instamojo Class Files ###########
					$this->load->library('instamojo',array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
					$api =new Instamojo(array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));

					$response = $api->linkCreate(array(
						'title'=>$planDetails['name'],
						'description'=>"My Plan", 
						'base_price'=>$planDetails['price'] * $_GET['no_of_months'],
						'buyer_name'=>$this->session->userdata('user_name'),
						'send_email'=>$this->session->userdata('user_email'),
						'amount'=>$planDetails['price'],
						'custom_fields'=>array('customer_id'=>$this->session->userdata('user_id'),'plan_id'=>$_GET['plan_id'],'no_of_months'=>$_GET['no_of_months']),
						'email'=>$this->session->userdata('user_email'),
						'redirect_url'=>base_url().'home/plan_package_response',
						'cover_image'=>base_url().'assets/img/list_logo.png'
					));
					if(isset($response) && !empty($response))
					{
						$this->advertisment_model->savePaymentClicks($this->session->userdata('user_id'),$_GET['plan_id'],$this->MyaddId);
						$data['status']=isset($response['url'])? 1 : 0;
						$data['url']=isset($response['url'])?$response['url']:'';
						
						redirect($data['url']);
					}
					else{
						redirect('home');
					}				
				}
				else{
					$this->session->set_flashdata('error','Invalid Plan'); 
					redirect('dashboard');
				}
				
			} else {
				
				$this->session->set_flashdata('error','Invalid Request'); 
				redirect('dashboard');
			}
		}
	}
	
	####################### Buy Packages ##################
	public function buySmsPackage() {
		
			if(isset($_GET['plan_id']) && $_GET['plan_id']!='') {
				
				$planDetails=$this->advertisment_model->getPlanDetails($_GET['plan_id']);
				if(!empty($planDetails)) {
					
					$insta_settings=admin_settings_initialize('instamojo_settings');							
					################### Load Instamojo Class Files ###########
					$this->load->library('instamojo',array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
					$api =new Instamojo(array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));

					$response = $api->linkCreate(array(
						'title'=>$planDetails['name'],
						'description'=>"My Plan", 
						'base_price'=>$planDetails['price'],
						'buyer_name'=>$this->session->userdata('user_name'),
						'send_email'=>$this->session->userdata('user_email'),
						'amount'=>$planDetails['price'],
						'custom_fields'=>array('customer_id'=>$this->session->userdata('user_id')),
						'email'=>$this->session->userdata('user_email'),
						'redirect_url'=>base_url().'home/plan_package_response',
						'cover_image'=>base_url().'assets/img/list_logo.png'
					));
					if(isset($response) && !empty($response))
					{
						$this->advertisment_model->saveSmsPaymentClicks($this->session->userdata('user_id'),$_GET['plan_id'],$this->MyaddId);
						$data['status']=isset($response['url'])? 1 : 0;
						$data['url']=isset($response['url'])?$response['url']:'';
						
						redirect($data['url']);
					}
					else{
						redirect('home');
					}				
				}
				else{
					$this->session->set_flashdata('error','Invalid Plan'); 
					redirect('dashboard');
				}
				
			} else {
				
				$this->session->set_flashdata('error','Invalid Request'); 
				redirect('dashboard');
			}
	}
	
	####################### Buy Packages ##################
	public function buyPlan() {
		
		$this->myUserId=$this->session->userdata('user_id');
		$this->MyaddId=get_my_addId($this->myUserId);
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('My Plan',base_url());
		if($this->MyaddId=='' || $this->MyaddId==0){	
			$this->session->set_flashdata('error','Please Complete Your Profile !'); 
			redirect('business-profile');
		}
		else {
			
			$user_profile_info=user_profile_info($this->session->userdata('user_id'));
			if($user_profile_info['name']=='' || $user_profile_info['mobile_number']=='' || $this->session->userdata('user_email')=='') {	
			
				$this->session->set_flashdata('error','Please Complete Your Profile !'); 
				redirect('my-profile');
				
			}
			if(isset($_GET['plan_id']) && $_GET['plan_id']!='') {
				
				$planDetails=$this->advertisment_model->getPlanDetails($_GET['plan_id']);
				$this->data['plan_details']=$this->advertisment_model->getPlanDetails($_GET['plan_id']);
				if(!empty($planDetails)){
								
					$this->advertisment_model->savePaymentClicks($this->session->userdata('user_id'),$_GET['plan_id'],$this->MyaddId);			
				}
				else{
					$this->session->set_flashdata('error','Invalid Plan'); 
					redirect('plan-packages');
				}
			} else {
				
				$this->session->set_flashdata('error','Invalid Request'); 
				redirect('plan-packages');
			}
		}
		
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Plan';
		$this->data['my_add_id']=$this->MyaddId;
		$this->data['user_profile_info']=$user_profile_info;
		$this->data['no_of_months']=(isset($_GET['no_of_months'])) ? $_GET['no_of_months'] : 1 ;
		$this->data['main_content']=$this->load->view('customers/payment_form', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	################### My Orders #################
	public function my_orders() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('My Orders',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Orders';
		if ($this->input->is_ajax_request()) {
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'customers/my_orders';
		$config['first_url'] = base_url().'customers/my_orders';
		$config['per_page'] = $config['per_page'];
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
		$order_list=$this->advertisment_model->getMyOrdersList($this->session->userdata('user_id'),$limit_start,$limit_end);		
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('customers/my_orders_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('customers/my_orders', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
	
	#################### Customer Today Views Graph #################
	public function todayViews(){
		$userId=$this->session->userdata('user_id');
		$data=array();
		$this->MyaddId=get_my_addId($this->myUserId);
		$data=$this->advertisment_model->getCustomerTodayViews($this->MyaddId);	
		echo json_encode($data,true);
		die;
	}
	
	#################### Customer Total Views Graph #################
	public function totalViews()
	{
		$userId=$this->session->userdata('user_id');
		$data=array();
		$this->MyaddId=get_my_addId($this->myUserId);
		$data=$this->advertisment_model->getCustomerTotalViews($this->MyaddId);	
		echo json_encode($data,true);
		die;
	}
	
	#################### Customer Top Platform #################
	public function topPlatForms()
	{
		$userId=$this->session->userdata('user_id');
		$data=array();
		$this->MyaddId=get_my_addId($this->myUserId);
		$data=$this->advertisment_model->getCustomertopPlatForms($this->MyaddId);	
		echo json_encode($data,true);
		die;
	}
	
	################ Customer SMS Package List###############
	public function sms_package_list()
	{
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Sms Package',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Sms Package';
		$this->data['sms_package_list']=$this->advertisment_model->getSmsPackageList();	
		$this->data['main_content']=$this->load->view('customers/sms_package', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	################ Customer Plan Package List###############
	public function plan_packages_list()
	{
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Plan Package',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Plan';
		$this->data['plan_package_list']=$this->advertisment_model->getPlanPackes();	
		$this->data['main_content']=$this->load->view('customers/plan_package', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	################ Customer Plan Package List###############
	public function upgrade_plan_packages_list()
	{
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Plan Package',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Plan';
		$this->data['plan_package_list']=$this->advertisment_model->getPlanPackes();	
		$this->data['main_content']=$this->load->view('customers/upgrade_plan_package', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	###############Customer Dashboard#############
	public function dashboard()
	{
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Dashboard',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Customer Dashboard';
		$this->data['main_content']=$this->load->view('customers/dashboard', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}


    ########################### Customer List #################
    public function customer_list() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Customers List',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Customers List';
		if ($this->input->is_ajax_request()) {
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = 10;$config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'customers/customer_list';
		$config['first_url'] = base_url().'customers/customer_list';
		$config['per_page'] = $config['per_page'];
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
		$order_list=$this->advertisment_model->getCustomerList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('customers/customer_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('customers/customer_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	} 	
	
	public function customerDetails(){
		$data=array();
		if($this->input->post('customer_id'))
		{
		 $data=$this->advertisment_model->customersDetails($this->input->post('customer_id'),$this->session->userdata('user_id'));	
		}
		echo json_encode($data,true);
		die;
	}
	
	###################### Customer Add #####################
	public function customer_add() {
		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->data['title_of_layout']=$this->site_name." - Add Customer";
		$this->breadcrumbs->push('Dialbe',base_url());		
		$this->breadcrumbs->push('My Profile',base_url());
		if($_POST) 
		{
				$this->form_validation->set_rules('email','Email','trim|valid_email');
				$this->form_validation->set_rules('first_name','First Name','trim|required');
				$this->form_validation->set_rules('gender','Gender','trim|required');
				if($this->form_validation->run() == true) 
				{
					$success=$this->advertisment_model->add_customers($this->session->userdata('user_id'));
					if($this->input->post('send_notification')==1 || $this->input->post('send_notification')=='on'){
						
						$this->load->model('campaign_model');
						$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
						$this->data['total_sms']=$this->data['user_info']['total_sms'];
						if($this->data['total_sms'] >=0) {
							$this->load->model('settings_model');
							$postData=$_POST;
							$new_success=$this->settings_model->send_sms($this->session->userdata('user_id'), 'customer-thanks', $postData);
						}
					}
					if($success) 
					{						
                        $extra_array = array('status'=>'success','msg'=>'Customer Add Successfully.');
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
		$this->data['main_content']=$this->load->view('customers/customer_add', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
	
	
	###################### Customer Add #####################
	public function customer_edit() {

		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		if($_POST) 
		{
				$this->form_validation->set_rules('first_name','First Name','trim|required');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|required|valid_email');
				$this->form_validation->set_rules('contact_number','Contact Number','trim|required');
				$this->form_validation->set_rules('gender','Gender','trim|required');
				if($this->form_validation->run() == true) 
				{
					$success=$this->advertisment_model->add_customers($this->session->userdata('user_id'));				
					if($this->input->post('send_notification')==1 || $this->input->post('send_notification')=='on'){
						
						$this->load->model('campaign_model');
						$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
						$this->data['total_sms']=$this->data['user_info']['total_sms'];
						if($this->data['total_sms'] >=0) {
							$this->load->model('settings_model');
							$postData=$_POST;
							$new_success=$this->settings_model->send_sms($this->session->userdata('user_id'), 'customer-thanks', $postData);
						}
					}
					if($success) 
					{
                        $extra_array = array('status'=>'success','msg'=>'Customer Details Updated Successfully.');
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
	}

	###############Customer Bussiness Profile############
	public function business_profile() {
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Business Profile',base_url());
		
		#Set Meta Title And Keyword
		$data['title_of_layout']=$this->site_name." - ".'Business Profile';	
		$data['user_business_data']=$this->advertisment_model->get_user_businessdata($this->session->userdata('user_id'));
		$data['categories_data']=$this->advertisment_model->get_user_categories_data($this->session->userdata('user_id'));
		
		
		$advertimentsId=$data['user_business_data']['id'];
		$data['get_selected_data']=array();
		$data['get_selected_service_data']=array();
		if($advertimentsId!=''){
		  $data['get_selected_data']=$this->advertisment_model->get_add_or_edit_business_data($advertimentsId);	
		  $data['get_selected_service_data']=$this->advertisment_model->get_add_or_edit_business_service_data($advertimentsId);
		}
		$output = '';
		$output1='';
		foreach($data['categories_data'] as $key=>$item){
			
			if(in_array($key, $data['get_selected_data']))
			{
			  $output.= '<option value="' . $key . '"' . (in_array($key, $data['get_selected_data']) ? ' selected' : '') . '>' . $item . '</option>';
			}
			
			if(in_array($key, $data['get_selected_service_data']))
			{
			  $output1.= '<option value="' . $key . '"' . (in_array($key, $data['get_selected_service_data']) ? ' selected' : '') . '>' . $item . '</option>';
			}
		}
		$data['keywords_data']=$output;
		$data['service_data']=$output1;
		$data['plan_package_list']=$this->advertisment_model->getPlanPackes(5);	
		$data['main_content']=$this->load->view('customers/business_profile', $data,true);
		$this->load->view('layouts/customer', $data);	
	}
	
	###############Customer My Profile############
	public function my_profile() {
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->data=array();
		$this->data['title_of_layout']="My Profile";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('My Profile',base_url());
		#Set Meta Title And Keyword
		$this->data['user_data']=$this->home_model->get_userinfo($this->session->userdata('user_id'));
		if($_POST) 
		{
				$this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]');
				$this->form_validation->set_rules('last_name','Last Name','trim|required|min_length[3]');
				$this->form_validation->set_rules('contact_number',ucwords($this->lang->line('Contact Number')),'trim|required|min_length[10]|numeric');
				$this->form_validation->set_rules('address',ucwords($this->lang->line('address')),'trim|required');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required|callback_user_mail_check');
				$this->form_validation->set_rules('gender',ucwords($this->lang->line('Gender')),'trim|required');
				$this->form_validation->set_rules('city',ucwords($this->lang->line('City')),'trim|required');
				$this->form_validation->set_rules('area',ucwords($this->lang->line('Area')),'trim|required');
				
				if($this->form_validation->run() == true) 
				{
					  $profile_image=array();
					  if(!empty($_FILES) && $_FILES['profile_image']['name']!='')
					  {
						  $config['upload_path']   =   $this->config->item('profile_url');
						  $config['allowed_types'] =   "gif|jpg|jpeg|png";		 
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
							 $profile_image['profile_image']=$_FILES['profile_image']['name'];
                             $profile_image['image_dir']=$upload_path=$this->config->item('profile_url');							 
							  
						  }
					  }
				        $this->home_model->update_profile($this->session->userdata('user_id'),$profile_image);	
				        $extra_array = array('status'=>'success','msg'=>'Profile Updated Successfully...!','url'=>base_url());
						echo json_encode($extra_array);
						die;	
				}
				else
				{
					echo $this->form_validation->get_json();
					die;
					
				}

		}		
		$this->data['main_content']=$this->load->view('customers/my_profile', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	##########Cusomer Change Password################# 
	public function change_password()  {
		if(!$this->session->userdata('is_user_logged_in')) {
			$url = 'login';
			redirect($url);
		}	
		$this->data=array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[6]|max_length[32]');
			$this->form_validation->set_rules('confirm_password','Confirm Password','trim|required|min_length[6]|max_length[32]|matches[new_password]');
			if($this->form_validation->run()){
				$this->home_model->change_password($this->session->userdata('user_id'), md5($this->input->post('new_password')));	
				$extra_array = array('status'=>'success','msg'=>'Password Changed Successfully...!','url'=>base_url());
				echo json_encode($extra_array);
				die;
			}
			else {
			   echo $this->form_validation->get_json();
			   die;
			}
		}
		else{
			$this->data['main_content']=$this->load->view('customers/change_password', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
	
	###############Check User Email###############
	public function user_mail_check() {
	   $email=$this->input->post('email');	
	   $userId=$this->session->userdata('user_id');
	   $user_info=$this->home_model->get_email($email,$userId);
		if(!empty($user_info))
		{
		$this->form_validation->set_message('user_mail_check', 'Email Already Exists');
		return FALSE;		
		}
        else
		{
		 return true;		
		}			
	}
	
	#####################Delete Posted Customer#################
	public function deleteCustomer()
	{
		$customer_delete=array();
		if(isset($_POST['customer_id']))
		{
			$customer_delete=$this->advertisment_model->deleteCustomer($_POST['customer_id'],$this->session->userdata('user_id'));
		}
		echo json_encode($customer_delete);
		die;
	}
	
	
	#####################Delete Posted Customer#################
	public function reedem_offer()
	{
		$reedemOffer=array();
		if(isset($_POST['offer_id']))
		{
			$this->load->model('campaign_model');
			$reedemOffer=$this->campaign_model->reedemOffer($_POST['offer_id']);
		}
		echo json_encode($reedemOffer);
		die;
	}
	
	public function reedem_points()
	{
		$parent_user_id=$_POST['parent_user_id'];
		$user_id=$_POST['user_id'];
		$points=$_POST['points'];
		$this->load->model('campaign_model');
		$reedemOffer=$this->campaign_model->reedemPoints($parent_user_id, $user_id, $points);
		echo json_encode($reedemOffer);
		die;	
	}
	
	public function changeStatus()
	{
		$customer_delete=array();
		if(isset($_POST['customer_id']))
		{
			$customer_delete=$this->advertisment_model->deleteCustomer($_POST['customer_id'],$_POST['customer_status']);
		}
		echo json_encode($customer_delete);
		die;
	}
	
	#####################Blog Add###########################
	public function blog_add()
	{
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Blog Add',base_url());
		#Set Meta Title And Keyword
		$data['title_of_layout']=$this->site_name." - ".'Blog Add';	
		$data['user_business_data']=$this->advertisment_model->get_user_businessdata($this->session->userdata('user_id'));
		$advertimentsId=$data['user_business_data']['id'];
		if($_POST) 
		{
				$this->form_validation->set_rules('name','Business Name','trim|required');
				$this->form_validation->set_rules('owner','Contact Person','trim|required');
				$this->form_validation->set_rules('email','Email','trim|required|valid_email');
				$this->form_validation->set_rules('website','Website','trim|valid_url_format');
				$this->form_validation->set_rules('contact_number','Contact Number','trim|required');
				$this->form_validation->set_rules('address_line','Address','trim|required');
				$this->form_validation->set_rules('city','City','trim|required');
				$this->form_validation->set_rules('area','Area','trim|required');
				$this->form_validation->set_rules('working_start','Start Time','trim|required');
				$this->form_validation->set_rules('working_end','End Time','trim|required');
				if($this->form_validation->run() == true) 
				{
					if($advertimentsId!='')
					{
						$success=$this->advertisment_model->edit_business($advertimentsId,$this->session->userdata('user_id'));
					}
					else
					{
						$success=$this->advertisment_model->add_business($this->session->userdata('user_id'));
					}					
					if($success) 
					{
                        $extra_array = array('status'=>'success','msg'=>'Thanks For Register we shortly contact you.');
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
		$data['main_content']=$this->load->view('customers/blog_add', $data,true);
		$this->load->view('layouts/customer', $data);	
	}
	
	########################### Blog List #################
    public function blog_list()
	{
		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Blog List',base_url());
		$this->data['main_content']=$this->load->view('customers/blog_list', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	} 	
	
	#####################Get All Blog List #################
	public function bloglist() {
		$blog_list=array();
		$limit_start=10;
		$limit_end=0;
		if(isset($_GET['iDisplayStart']))
		{
			$limit_end=$_GET['iDisplayStart'];
		}
		if(isset($_GET['iDisplayLength']))
		{
			$limit_start=$_GET['iDisplayLength'];
		}
		$blog_list=$this->advertisment_model->getCustomerBlogList($this->session->userdata('user_id'),$limit_start,$limit_end);
		$data=array('iTotalRecords'=>$blog_list['iTotalRecords'],'sEcho'=>$_GET['sEcho'],'iTotalDisplayRecords'=>$blog_list['iTotalDisplayRecords'],'aaData'=>$blog_list['data']);
		echo json_encode($data);
		die;
	}
	
	##################### Add Sender ID ############
	public function add_senderid() {
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		if($_POST) 
		{
			$this->form_validation->set_rules('sender_id','Sender Id','trim|required');
			if($this->form_validation->run() == true) 
			{
				$success=$this->advertisment_model->saveSenderId($this->session->userdata('user_id'));				
				if($success) 
				{
					$extra_array = array('status'=>'success','msg'=>'Sender ID Submitted Successfully');
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
		die;
	}
	
	########## Check User Information ########
	public function check_user_info() {
		$this->form_validation->set_rules('contact_number','Mobile Number','trim|required|numeric|min_length[10]|max_length[10]');
		if($this->form_validation->run() == true){
			$datas=$this->advertisment_model->checkUserInfo($this->session->userdata('user_id'));			
			if($datas) 
			{
				$success=$this->advertisment_model->checkCustomerUsers($this->session->userdata('user_id'),$datas['id']);
				if($success){
					$extra_array = array('status'=>'EXISTING_USER','msg'=>'Success !!! Customer Information Already Existing','user_datas'=>$datas,'customer_info'=>$success);
					echo json_encode($extra_array);
					die;	
				}else{
					$extra_array = array('status'=>'EXISTING_NEW_USER_ADD','msg'=>'Success ! Customer Information Available.','user_datas'=>$datas,'customer_info'=>$success);
					echo json_encode($extra_array);
					die;	
				}				
			}
			else {
				$extra_array = array('status'=>'NEW_USER_ADD','msg'=>'Sorry Customer Information Not Available.');
				echo json_encode($extra_array);
				die;	
			}
		} 
		else {
			echo $this->form_validation->get_json();
			die;
		}
	}
	
	###################### Customer Edit #####################
	public function edit($id)
	{
		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		#Set Meta Title And Keyword
		$this->data['user_data']=$this->advertisment_model->get_customeruserinfo($this->session->userdata('user_id'),$id);
		if(empty($this->data['user_data']))
		{
			$url = 'customer-list';
			redirect($url);
		}
		$this->data['edit_id']=$id;
		$data['categories_data']=$this->advertisment_model->get_user_remainder_data($this->session->userdata('user_id'));
		$this->data['remainder_data']=$this->advertisment_model->get_user_remainderdata($this->session->userdata('user_id'),$id);
		
	
		if($_POST) 
		{
			$this->form_validation->set_rules('first_name','First Name','trim|required');
			$this->form_validation->set_rules('gender','Gender','trim|required');
			if($this->form_validation->run() == true) 
			{
				$success=$this->advertisment_model->update_customer_info($id,$this->session->userdata('user_id'),$this->data['user_data']);		
				if($this->input->post('send_notification')==1 || $this->input->post('send_notification')=='on'){
						$this->load->model('campaign_model');
						$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
						$this->data['total_sms']=$this->data['user_info']['total_sms'];
						if($this->data['total_sms'] >=0) {
							$this->load->model('settings_model');
							$postData=$_POST;
							$new_success=$this->settings_model->send_sms($this->session->userdata('user_id'), 'customer-thanks', $postData, $id);
						}
				}				
				if($success) 
				{
					$extra_array = array('status'=>'success','msg'=>'Customer Details Updated Successfully.');
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
		$this->data['main_content']=$this->load->view('customers/customer_edit', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
	
	public function user_offer_list(){
		
	    
		$post_id=$_POST['customer_id'];
		$this->load->model('campaign_model');
		
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = 10;$config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'customers/user_offer_list';
		$config['first_url'] = base_url().'customers/user_offer_list';
		$config['per_page'] = $config['per_page'];
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
		$order_list=$this->campaign_model->getUserCampaignOffersList($this->session->userdata('user_id'), $post_id, $limit_start,$limit_end);	
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('customers/customer_offer_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
	}
	
	
	########### Import Customers ###########
	public function import_customers() { 
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Import Customers',base_url());
		$data['title_of_layout']=$this->site_name." - ".'Import Customers';
		#Set Meta Title And Keyword
		if(isset($_FILES['file_data'])) {			
		 if($_FILES['file_data']['name'] && $_FILES['file_data']['tmp_name'] && ($_FILES['file_data']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['file_data']['type']=='application/zip' || $_FILES['file_data']['type']=='application/octet-stream' )) 
		 {
				$file_name= $_FILES['file_data']['tmp_name'];		 
				require_once APPPATH . 'third_party/PHPExcel.php';
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($file_name);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$total_rows=$objPHPExcel->setActiveSheetIndex(0)->getHighestDataRow();
				$count=0;
				if($total_rows > 2) {
					for($i=2; $i<=$total_rows; $i++)
					{
						if($objWorksheet->getCellByColumnAndRow(0,$i)->getValue()!='')
						{
							$count=$count+1;
							$data_user=array(
								'first_name' => ltrim($objWorksheet->getCellByColumnAndRow(0,$i)->getValue()),
								'last_name' => ltrim($objWorksheet->getCellByColumnAndRow(1,$i)->getValue()),
								'email' => ltrim($objWorksheet->getCellByColumnAndRow(2,$i)->getValue()),
								'contact_number' => ltrim($objWorksheet->getCellByColumnAndRow(3,$i)->getValue()),
								'address' => ltrim($objWorksheet->getCellByColumnAndRow(4,$i)->getValue()),
								'gender' => ltrim($objWorksheet->getCellByColumnAndRow(5,$i)->getValue()),
								'dob' => ltrim($objWorksheet->getCellByColumnAndRow(6,$i)->getValue()),
								'city' => ltrim($objWorksheet->getCellByColumnAndRow(7,$i)->getValue()),
								'area' => ltrim($objWorksheet->getCellByColumnAndRow(8,$i)->getValue()),
								'bill_amount' => ltrim($objWorksheet->getCellByColumnAndRow(9,$i)->getValue()),
								'doa' => ltrim($objWorksheet->getCellByColumnAndRow(10,$i)->getValue())
							);
							$this->advertisment_model->import_customer_data($data_user,$this->session->userdata('user_id'));
						}
					}
					
					$history_data=array(
						'created'=>date('Y-m-d H:i:s'),
						'user_id'=>$this->session->userdata('user_id'),
						'file_name'=>$_FILES['file_data']['name'],
						'total_rows'=>$count,
						'status'=>'Success',
					);
					$this->advertisment_model->import_customer_history_data($history_data);
					$data['status']="success";  
					$data['total_rows']=$total_rows;
					$data['inserted_datas']=$count;
					$data['msg']="<p>Customer Data Imported Successfully</p>"; 
					echo json_encode($data);
					die;	
				}
				else {
					$extra_array = array('status'=>'error','msg'=>'Please add valid data');
					echo json_encode($extra_array);
					die;	
				}
		    }
			else{
				$extra_array = array('status'=>'error','msg'=>'Please upload a valid File');
				echo json_encode($extra_array);
				die;					
			}
		}
		else {
			$data['main_content']=$this->load->view('customers/import_customer_data', $data,true);
			$this->load->view('layouts/customer', $data);	
		}
	}
	
	######## Import Histroy ############
	public function importHistroyList() {
		if ($this->input->is_ajax_request()) {
			$page_num=$this->uri->segment(3);
			$cofig =array();
			$config = admin_settings_initialize('settings');
			$this->pagination->cur_page = $this->uri->segment(3);
			$order_list=array();
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'customers/enquiry_list';
			$config['first_url'] = base_url().'customers/enquiry_list';
			$config['per_page'] = $config['per_page'];
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
			$order_list=$this->advertisment_model->getMyImportList($this->session->userdata('user_id'),$limit_start,$limit_end);	
			$this->data['order_list']=$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('customers/import_list_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
		exit;
	}
	
		
	##########Reward Settings################# 
	public function reward_settings()  {
		if(!$this->session->userdata('is_user_logged_in')) {
			$url = 'login';
			redirect($url);
		}	
		$this->data=array();
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			
			$this->form_validation->set_rules('amount','amount','trim|required');
			$this->form_validation->set_rules('minimum_amount','minimum amount','trim|required');
			if($this->form_validation->run()){
				$this->home_model->updateRewards($this->myUserId);	
				$extra_array = array('status'=>'success','msg'=>'Reward Update Successfully...!','url'=>base_url());
				echo json_encode($extra_array);
				die;
			}
			else {
			   echo $this->form_validation->get_json();
			   die;
			}
		}
		else {
			
			$this->data['reward_points_data']=$this->home_model->getRewardSettings($this->myUserId);
			$this->data['main_content']=$this->load->view('customers/reward_settings', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
}

?>