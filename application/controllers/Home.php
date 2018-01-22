<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    #Construct Function
	public function __construct() {
		
        parent::__construct();
		$this->load->model('home_model');
		
		$this->load->library('twitteroauth');
		
		# Loading twitter configuration.
		$this->config->load('twitter');
		
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			# If user already logged in
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('access_token'),  $this->session->userdata('access_token_secret'));
		}
		elseif($this->session->userdata('request_token') && $this->session->userdata('request_token_secret'))
		{
			# If user in process of authentication
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
		}
		else
		{
			# Unknown user
			$this->connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'));
		}
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();

	}
	
	#Home - Create Add Campaign
	public function createAddCampaign(){
		
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push(ucfirst('Post Adertisment'),base_url());	
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->data['customer'] = "";
		if($this->session->userdata('is_user_logged_in')) {
			redirect(base_url());
            $extra_array = array('status'=>'already register','redirect_url'=>base_url().'dashboard');
			echo json_encode($extra_array);	
            die;			
		}
		else {
			if($_POST){
				$this->form_validation->set_rules('name','Company Name','trim|required|min_length[3]');
				$this->form_validation->set_rules('owner','Owner','trim|required');
				$this->form_validation->set_rules('zip','Zip','trim|required|numeric');
				$this->form_validation->set_rules('address_line','Address Line','trim|required');
				$this->form_validation->set_rules('city','City','trim|required');
				$this->form_validation->set_rules('area','Area','trim|required');
				if($this->form_validation->run() == true) {
						$plan_id=$this->input->post('plan_id');
						$user_id=$this->input->post('user_id');
						$success = $this->home_model->createAddCampaign();
						$token=$success['add_id'];
						$this->load->library('template');
						
						$data=array('user_name'=>$this->input->post('owner'));
						$this->load->model('notification_model');					
						$email_body = $this->template->load('mail_template/template', 'mail_template/register_via_campaign', $data,TRUE);
						$this->load->model('cron_model');
						$this->cron_model->sendElasticEmail($this->input->post('email'), "Thanks For Register -".$this->site_name, "",$email_body, $this->input->post('email'), "Dragdeal");
						$extra_array = array('status'=>'success','msg'=>'You Profile Register Successfully.','url'=>base_url().'home/one_time_subscription?token='.$token.'&plan_id='.$plan_id);
						echo json_encode($extra_array);
						die;
				} 
				else {
					echo $this->form_validation->get_json();
					die;
				}
			}
			$this->data['title_of_layout']=$this->site_name." - Create Add Campaign";
			$this->data['meta_keywords']=$this->site_name." - Create Add Campaign";
			$this->data['title']="Sign Up";
			$this->data['is_header_hide']=true;
			$this->data['redirect_url']=(isset($_GET['redirect_url']))?$_GET['redirect_url']:'';
			if(!$this->input->is_ajax_request()){
				$this->data['main_content']=$this->load->view('users/createAddCampign', $this->data,true);
				$this->load->view('layouts/default', $this->data);
			}
			else {
				$this->load->view('users/register', $this->data);
			}
		}
	}
	
	########### Create User Campign ############
	function createUserCampaign(){
		
		$email_activation_id = random_string('alnum', 10);
		$x = 3;
		$min = pow(10,$x);
		$max = (pow(10,$x+1)-1);
		$value = rand($min, $max);
		$password='dragdeal-'.$value;
		$success = $this->home_model->saveCampignUser($email_activation_id, $password);
		if($success['is_already_register']==false){
			$this->load->library('template');
			$data = array(
				'user_name'  => $this->input->post('name'),
				'user_email' => $this->input->post('email'),
				'password'	 => $password,
				'verifylink' => $email_activation_id
			);
			$email_body = $this->template->load('mail_template/template', 'mail_template/register_site_user', $data,TRUE);
			$this->load->model('cron_model');
			$this->cron_model->sendElasticEmail($this->input->post('email'), "Thanks For Register -".$this->site_name, "",$email_body, $this->input->post('email'), "Dragdeal");
		}
		echo json_encode($success);
		die;
	}
	
	
	public function one_time_subscription(){
		
		$token=$_GET['token'];
		if(empty($token)){
			$this->session->set_flashdata('error','Invalid Request'); 
			redirect('/');
		}
		$this->load->model('advertisment_model');
		$getValues = $this->advertisment_model->get_advertisment_detail($token); 
		$userId=$getValues['user_id'];
		$MyaddId=$getValues['id'];
		$plan_id=(isset($_GET['plan_id'])) ? $_GET['plan_id'] : 1;
		$this->data=array();
		$this->data['plan_details']=$this->advertisment_model->getPlanDetails($plan_id);
		$this->advertisment_model->savePaymentClicks($userId, $plan_id, $MyaddId);
		$user_profile_info = user_profile_info($userId);

		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Plan';
		$this->data['my_add_id']=$MyaddId;
		$this->data['user_id']=$userId;
		$this->data['user_profile_info']=$user_profile_info;
		$this->data['no_of_months']=(isset($_GET['no_of_months'])) ? $_GET['no_of_months'] : 1 ;
		$this->data['main_content']=$this->load->view('customers/email_payment_form', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}

	
	### Sms Package Response ###
	public function sms_credit_response(){
		
		################### Load Instamojo Class Files ###########
		if(isset($_GET['payment_id'])) {
			$insta_settings=admin_settings_initialize('instamojo_settings');	
			$this->load->model('campaign_model');
			################### Load Instamojo Class Files ###########
			$this->load->library('instamojo',array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
			$api =new Instamojo(array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
			$response = $api->paymentDetail($_GET['payment_id']);
			$this->myUserId=$this->session->userdata('user_id');
			$this->MyaddId=get_my_addId($this->myUserId);
			$this->campaign_model->savePlanDetails($response, $_GET['status'],$_GET['payment_id']);
			if($_GET['status']=='success' && $this->session->userdata('user_id')!=''){
				$this->session->set_flashdata('success','Your Payment Completed Successfully'); 
				redirect('dashboard');
			}
			else {
				$this->session->set_flashdata('error','Your Payment is Failed.'); 
				redirect('dashboard');
			}
		} else {
			redirect('dashboard');		
		}	
	}
	
	############# Send Enquiry Details ###############
	public function enquiry(){
		
		if($_POST) 
		{
			$this->form_validation->set_rules('name',ucwords($this->lang->line('Name')),'trim|name|required');
			$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
			$this->form_validation->set_rules('contact_no',ucwords($this->lang->line('Contact Number')),'trim|required');
			$this->form_validation->set_rules('title',ucwords($this->lang->line('Title')),'trim|required');
			$this->form_validation->set_rules('message',ucwords($this->lang->line('message')),'trim|required|min_length[3]');
			if($this->form_validation->run() == true) 
			{
				 if($this->home_model->add_enquiry())
				 {
					$this->load->library('template');
					$enquiry_via_mail=true;
					if($enquiry_via_mail){
						$data=array('user_name'=>'Customer','customer_name'=>$this->input->post('name'), 'email'=>$this->input->post('email'), 'contact_no'=>$this->input->post('contact_no'), 'title'=>$this->input->post('title'), 'message'=>$this->input->post('message'));
						$notificatiosTemplate="mail_template/customer_enquiry_notification";
						$email_body = $this->template->load('mail_template/template', $notificatiosTemplate, $data, TRUE);
						$this->email->from(admin_settings_initialize('email'), admin_settings_initialize('sitename'));
						$this->email->to($this->input->post('advertisment_email'));
						$this->email->subject($this->site_name.' - Enquiry Notifications For Your Bussiness');
						$this->email->message($email_body);
						if ($this->email->send()) {
						}
					} 
					else {
						$data=array('user_name'=>'Customer','customer_name'=>$this->input->post('name'));
						$notificatiosTemplate="mail_template/enquiry_notification";
						$email_body = $this->template->load('mail_template/template', $notificatiosTemplate, $data, TRUE);
						$this->email->from(admin_settings_initialize('email'), admin_settings_initialize('sitename'));
						$this->email->to($this->input->post('advertisment_email'));
						$this->email->subject($this->site_name.' - Enquiry Notifications For Your Bussiness');
						$this->email->message($email_body);
						if ($this->email->send()) {
						}
					}
					
					#### Sms Settings #####
					if($this->input->post('advertisment_user_id') > 1){
						$this->load->model('campaign_model');
						$this->data['user_info']=$this->campaign_model->sms_availabilty($this->input->post('advertisment_user_id'));
						$this->data['total_sms']=$this->data['user_info']['total_sms'];
						if($this->data['total_sms'] >=0) {
							$this->load->model('settings_model');
							$postData=array('mobile_number'=>$this->input->post('contact_no'),'first_name'=>$this->input->post('name'));
							$id=0;
							$new_success=$this->settings_model->send_sms($this->input->post('advertisment_user_id'), 'enquiry-thanks', $postData, $id);
						}
					}
					$json_array['status']="success";
					$json_array['msg']="Enquiry Send Successfully.";	
					echo json_encode($json_array);	
					die; 
				 }	
				 else
				 {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
					  $json_array['msg']="Enquiry Could not be saved.Please Try Again..!";	
					  echo json_encode($json_array);	
					  die;	
				 }						 
			}
			else
			{
				echo $this->form_validation->get_json();
				die;		
			}
		}
		else{		
			if(isset($_GET['token']) && $_GET['token']!=''){
				
				#Get Add Detail
				$this->load->model('advertisment_model');
				$data['result']=$this->advertisment_model->get_add_detail($_GET['token']);
				if(count($data['result'])==0){
					redirect(base_url());
				}
				$this->breadcrumbs->push($this->site_name,base_url());
				$this->breadcrumbs->push(ucfirst('Send Enquiry'),base_url());	
				$this->data['title_of_layout']="Send Enquiry";
				$this->data['title_of_description']=$this->site_name." - Send Enquiry";
				$this->data['title']=$data['result']['name'];
				$this->data['advertisment_id']=$data['result']['id'];
				$this->data['advertisment_email']=$data['result']['email'];
				$this->data['advertisment_user_id']=$data['result']['user_id'];
				$this->data['main_content']=$this->load->view('business_enquiry', $this->data,true);
				$this->load->view('layouts/default', $this->data);
			}
		}
	}
	
	
	###################### Payment Error ###############
	public function payu_failure(){
		
		$status=$_POST["status"];
		$firstname=$_POST["firstname"];
		$amount=$_POST["amount"];
		$txnid=$_POST["txnid"];
		$posted_hash=$_POST["hash"];
		$key=$_POST["key"];
		$productinfo=$_POST["productinfo"];
		$email=$_POST["email"];
		$user_id=$_POST["udf1"];
		$plan_id=$_POST["udf2"];
		$add_id=$_POST["udf3"];
		$this->load->model('advertisment_model');
		$response=$_POST;
		$this->advertisment_model->savePaymentResponse($response,'error');
		$this->session->set_flashdata('error','Invalid Transaction. Please try again'); 
		redirect('dashboard');
	}
	
	###################### Payment Successfully ###############
   public function payu_success(){
		$status=$_POST["status"];
		if($status=='success' || $status=='Success'){
			$this->load->model('advertisment_model');
			$response=$_POST;
			$this->advertisment_model->savePaymentResponse($response,'success');
			$this->session->set_flashdata('success','Thank You. Your order is Successfully Completed.'); 
			redirect('dashboard');
		}
		else{
			$this->session->set_flashdata('error','Invalid Transaction. Please try again'); 
		    redirect('dashboard');
		}
	}

	
    public function plan_package_response(){
		
		################### Load Instamojo Class Files ###########
		if(isset($_GET['payment_id'])){
			
			$this->load->model('advertisment_model');
			$insta_settings=admin_settings_initialize('instamojo_settings');							
			################### Load Instamojo Class Files ###########
			$this->load->library('instamojo',array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
			$api =new Instamojo(array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
			$response = $api->paymentDetail($_GET['payment_id']);
			$this->myUserId=$this->session->userdata('user_id');
			$this->MyaddId=get_my_addId($this->myUserId);
			$this->advertisment_model->savePlanDetails($response, $_GET['status'],$_GET['payment_id'],$this->MyaddId,$this->myUserId);
			if($_GET['status']=='success' && $this->session->userdata('user_id')!=''){
				$this->session->set_flashdata('success','Your Payment Completed Successfully'); 
				redirect('dashboard');
			}
			else {
				$this->session->set_flashdata('error','Your Payment is  Not Completed Successfully.'); 
				redirect('dashboard');
			}
		} else {
			redirect('dashboard');		
		}	
	}
	
	#Home - Get Cities
	public function get_cities(){
		$this->load->model('cities_model');
		$keyword=(isset($_GET['term']))?$_GET['term']:'';
		$all_list=$this->cities_model->get_add_cities($keyword);
		echo json_encode($all_list);
		die;
	}
	
	#Home - Get Areas
	public function get_areas(){
		$this->load->model('areas_model');
		$keyword=(isset($_GET['term']))?$_GET['term']:'';
		$city_id=(isset($_GET['city_id']))?$_GET['city_id']:'';
		$all_list=$this->areas_model->get_add_area($keyword,$city_id);
		echo json_encode($all_list);
		die;
	}

	#Home - Get Main Category
	public function get_main_category(){
		$this->load->model('category_model');
		$keyword=(isset($_GET['term']))?$_GET['term']:'';
		$all_list=$this->category_model->get_main_category_new($keyword);
		echo json_encode($all_list);
		die;
	}	
	
	#Home - Index Page
	public function index() {
		

		if(isset($_GET['r_url'])) {
		    if(!$this->_bot_detected()){
    			$this->load->model('campaign_model');
    			$all_list=$this->campaign_model->track_campagin();
    			header('Location:'.$_GET['r_url']);
		    }
		}
		$this->data['meta_rating']='General';
		$this->data['home_cities']=$this->home_model->get_home_cities('7');
		$this->data['home_add_listing']=$this->home_model->get_home_listings();
		$this->data['home_premium_listing']=$this->home_model->get_home_premium_listings();
		$this->load->view('layouts/home', $this->data);
    }
    
    function _bot_detected() {

	  return (
		isset($_SERVER['HTTP_USER_AGENT'])
		&& preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
	  );
	}
	
	############### Keyword Enquiry ############
	public function keyword_enquiry(){
		
		if($_POST) 
		{
			$this->form_validation->set_rules('name',ucwords($this->lang->line('Name')),'trim|name|required');
			$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
			$this->form_validation->set_rules('contact_no','Contact Number','trim|required');
			$this->form_validation->set_rules('contact_no','Contact Number','trim|required|min_length[10]|numeric');
			if($this->form_validation->run() == true) 
			{
				 if($this->home_model->add_keyword_enquiry())
				 {
					$json_array['status']="success";
					$json_array['msg']="Enquiry Send Successfully.";	
					echo json_encode($json_array);	
					die; 
				 }	
				 else
				 {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
					  $json_array['msg']="Enquiry Could not be saved.Please Try Again..!";	
					  echo json_encode($json_array);	
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
	
	
	#Home - User Auth Check
	public function user_auth_check(){
		$json_array=array();
		$json_array['status']='0';
	    if($this->session->userdata('is_user_logged_in')) 
		{	
	      $this->session->set_flashdata('success','Sorry...You already loged in...!');
		  $json_array['status']='1';
		}
		echo json_encode($json_array);
		die;
	}
	
	#Home - Logout Page
	public function logout(){
		$url = 'login';
		$this->session->sess_destroy();
		$this->session->set_flashdata('success','You Successfully logout..!');
		redirect($url);
	}
	
	#Home - My Profile
	public function my_profile(){
		
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->data=array();
		$this->data['title_of_layout']="My Profile";
		$this->data['user_data']=$this->home_model->get_userinfo($this->session->userdata('user_id'));
		if($_POST) 
		{
				$this->form_validation->set_rules('name',ucwords($this->lang->line('name')),'trim|required|min_length[3]');
				$this->form_validation->set_rules('contact_number',ucwords($this->lang->line('Contact Number')),'trim|required|min_length[10]|numeric');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required|callback_user_mail_check');
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
		$this->data['main_content']=$this->load->view('users/my_profile', $this->data,true);
		$this->load->view('layouts/default', $this->data);
	}
	
	public function user_mail_check(){
		
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
		
	#Home - User Register
	public function register() {
		
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push(ucfirst('Register / Login'),base_url());	
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->data['customer'] = "";
		if($this->session->userdata('is_user_logged_in')) 
		{
			redirect(base_url());
            $extra_array = array('status'=>'already register','redirect_url'=>base_url().'dashboard');
			echo json_encode($extra_array);	
            die;			
		}
		else 
		{
			if($_POST) 
			{
				$this->form_validation->set_rules('name',ucwords($this->lang->line('name')),'trim|required|min_length[3]');
				$this->form_validation->set_rules('contact_number','Mobile Number','trim|required|min_length[10]|numeric');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required|is_unique[users.email]');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
				if($this->form_validation->run() == true) 
				{
					$email_activation_id = random_string('alnum', 10);
					$success = $this->home_model->create_account($email_activation_id);
					if($success) 
					{
						$this->load->library('template');
						
						$data = array(
							'user_name'  => $this->input->post('name'),
							'user_email' => $this->input->post('email'),
							'password'	 => $this->input->post('password'),
							'verifylink' => $email_activation_id
						);
						$this->load->model('notification_model');
						$new_data=array('username'=>$this->input->post('name'),'user_id'=>$success);
						$this->notification_model->common_save_notification('WELCOME',$new_data);
						
						$email_body = $this->template->load('mail_template/template', 'mail_template/register_site_user', $data,TRUE);
						$this->load->model('cron_model');
						$this->cron_model->sendElasticEmail($this->input->post('email'), "Thanks For Register -".$this->site_name, "",$email_body, $this->input->post('email'), "Dragdeal");
						$extra_array = array('status'=>'success','msg'=>'You Successfully Register.. Pls check your mail to verify your account.','url'=>base_url());
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
			$this->data['title_of_layout']=$this->site_name." - Login - Sign Up";
			$this->data['meta_keywords']=$this->site_name." - Login - Sign Up";
			$this->data['title']="Sign Up";
			$this->data['redirect_url']=(isset($_GET['redirect_url']))?$_GET['redirect_url']:'';
			if(!$this->input->is_ajax_request())
			{
			$this->data['reg_login']='1';
			$this->data['main_content']=$this->load->view('users/register_login', $this->data,true);
			$this->load->view('layouts/default', $this->data);
			}
			else
			{
				$this->load->view('users/register', $this->data);
			}
			
		}
	}
	
	#Users - login Page
	public function login() {
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
	    $json_array=array();
		if($this->session->userdata('is_user_logged_in')) 
		{
			redirect(base_url());
            $extra_array = array('status'=>'already register','redirect_url'=>base_url().'dashboard');
			echo json_encode($extra_array);	
            die;			
		}
		else 
		{
			if($_POST) 
			{
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				if($this->form_validation->run() == true) 
				{
					$user_name = $this->input->post('email');
					$password = $this->__encrip_password($this->input->post('password'));
		
					$type_user = '3';
					$is_valid = $this->home_model->validate_users($user_name, $password ,$type_user);
					if(empty($is_valid))
					{
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Invalid Credential Please Try Again..!";						  
					}
					else if($is_valid->is_email_confirmed == 0)  
					{
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Your Email Is Not Confirm Please Try Again..!";	
					}
					else if($is_valid->is_active == 0)  
					{
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Your Account InActivated By Admin Due To Some Security Reason.. Please Try Again..!";	
					}
					else
					{
					  $maindata = array (
								'user_email'		=> $is_valid->email,
								'user_id'			=> $is_valid->id,
								'contact_number'        => $is_valid->contact_number,
								'is_user_logged_in'	=> true
					   );
					   $common_data = array(
							'user_name'				=> $user_name,
							'is_logged' 			=> true,
							'user_type'				=> $is_valid->user_type,
							'register_type'         => $is_valid->register_type,
						);
					  $data = array_merge($maindata,$common_data);
					  $this->home_model->last_login_time($is_valid->email);
					  $this->session->set_userdata($data);	
					  $this->session->set_flashdata('success','Welcome ! You Successfully Logged In.');
					  
						$json_array['status']="success";

						parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY), $queries);
						$json_array['url']=base_url().'dashboard';
						if(isset($queries['redirect_url']) && $queries['redirect_url']!=''){
							$json_array['url']=$queries['redirect_url'];
						}					  
					}
					echo json_encode($json_array);
					die;	
				} 
				else 
				{
					echo $this->form_validation->get_json();
					die;
				}
			}
		}
		
			$this->data['title_of_layout']="Sign Up";
			$this->data['meta_keywords']="Sign Up";
			$this->data['title']="Sign Up";
			$this->data['redirect_url']=(isset($_GET['redirect_url']))?$_GET['redirect_url']:'';
			if(!$this->input->is_ajax_request())
			{
				$this->data['reg_login']='1';
				$this->data['main_content']=$this->load->view('users/register_login', $this->data,true);
				$this->load->view('layouts/default', $this->data);
			}
			else
			{
				$this->load->view('users/login', $this->data);
			}
	}
	
	#Forgot Password
	public function forgot_password(){
		
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->data['customer'] = "";
		if($this->session->userdata('is_user_logged_in')) 
		{
			redirect(base_url());
            $extra_array = array('status'=>'Sorry you already Log in','redirect_url'=>base_url());
			echo json_encode($extra_array);	
            die;			
		}
		else 
		{
			if($_POST) 
			{
				$this->form_validation->set_rules('email_address', 'Email','trim|required|valid_email');
				if($this->form_validation->run() == true) 
				{
			     
				  if(!$this->home_model->valid_user_type($this->input->post('email_address')))
					{
					   $json_array['status']="error";
					   $json_array['sts']="custom_err";
                       $json_array['msg']="Invalid User... Please Try Again..!";	
					   echo json_encode($json_array);	
                       die;	
				   }
				  $uid=rand();
				  if($this->home_model->check_user_available($this->input->post('email_address'),$uid))
				  {
					$this->load->library('template');
					$username=$this->home_model->getUsername($this->input->post('email_address'));
                    $user_name=$username['first_name'];
					$data = array(
						'user_email' => $this->input->post('email_address'),
						'resetpassword_url'  => $this->config->item('resetpassword_url').$uid,'username'=>$user_name
					);
					$email_body=$this->template->load('mail_template/template', 'mail_template/forgot_password', $data,TRUE);
					$this->email->from(admin_settings_initialize('email'), admin_settings_initialize('sitename'));
					$this->email->to($this->input->post('email_address'));
					$this->email->subject('Forgot Password');
					$this->email->message($email_body);
					if ($this->email->send()) 
					{	
					  $json_array['status']="success";
					  $json_array['url']=base_url();
					  $this->session->set_flashdata('success','Please check your mail to reset your password'); 
					} 
					else 
					{
					  $json_array['status']="success";
					  $json_array['url']=base_url();
                      $this->session->set_flashdata('error','Mail Could not be send'); 
					}
					
					########## Notifications Create ##############
					$this->load->model('notification_model');
					$new_data=array('username'=>$user_name, array('user_id'=>$username['id']));
					$this->notification_model->common_save_notification('FORGOT',$new_data);	
					
					echo json_encode($json_array);die; 
				}
				else
				{	
					$this->session->set_flashdata('flash_message', $this->lang->line('email_not_exist'));
					if(!$this->input->is_ajax_request())
					{
						$this->session->set_flashdata('error','Invalid User...Please Try Again..!');
						redirect('home/forgot_password');
					}
					else
					{
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Invalid User...Please Try Again..!";	
					  echo json_encode($json_array);	
                      die;	
					}
				}		
					
				}
				else
				{
					echo $this->form_validation->get_json();
					die;	
					
				}
			}
			
		}
	        $this->data['title_of_layout']=$this->site_name." - Forgot Password";
			$this->data['meta_keywords']=$this->site_name." - Forgot Password";
			$this->data['title']="Forgot Password";		
			if(!$this->input->is_ajax_request())
			{
			$this->data['reg_login']='1';
			$this->data['main_content']=$this->load->view('users/forgot_password_normal', $this->data,true);
			$this->load->view('layouts/default', $this->data);
			}
			else
			{
				$this->load->view('users/forgot_password', $this->data);
			}
	}
	
	#Home - Reset Password
	public function reset_password() {
		$slug=$this->uri->segment('2');
		$user_info=$this->home_model->get_user_info($slug);
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		if($this->session->userdata('is_user_logged_in')) 
		{
			$this->session->set_flashdata('success','You already loged in');
			redirect(base_url());	
		}
		else 
		{
			if($_POST) 
		   {
			if($this->home_model->check_user_uid($slug))
			{
				
				  $this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]|max_length[32]');
		          $this->form_validation->set_rules('confirm_password', 'Confirm Password','trim|required|matches[password]');
				  if($this->form_validation->run() == true) 
				  {
					 $email=$user_info['email'];
					 if($this->home_model->update_password($email))
				     {
                      $json_array['status']="success";
					  $json_array['url']=base_url().'user_login';
					  $this->session->set_flashdata('success','Password Reset Successfully.Please login below'); 
					  echo json_encode($json_array);	
                      die;	
					 }
					 else
					 {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Invalid User...Please Try Again..!";	
					  echo json_encode($json_array);	
                      die;	
					 }
				}
				  else
				  {
			  	     echo $this->form_validation->get_json();
					 die;	
				  }
		    }
			else
			{
				      $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Invalid Token..Please Try Again..!";	
					  echo json_encode($json_array);	
                      die;	
			}
		  }
		    $this->data['slug']=$slug;
			$this->data['main_content']=$this->load->view('users/reset_password', $this->data,true);
			$this->load->view('layouts/default', $this->data);
		}
	}
	
	
	#Twitter  Account
	public function twitter(){
		
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		if($this->session->userdata('is_user_logged_in')) 
		{
			$this->session->set_flashdata('success','You already loged in');
			redirect(base_url());	
		}
		
		if($this->session->userdata('access_token') && $this->session->userdata('access_token_secret'))
		{
			redirect(base_url('/'));
		}
		else
		{
			$request_token = $this->connection->getRequestToken(base_url().'home/twitter_callback');

			$this->session->set_userdata('request_token', $request_token['oauth_token']);
			$this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);
			
			if($this->connection->http_code == 200)
			{
				$url = $this->connection->getAuthorizeURL($request_token);
				redirect($url);
			}
			else
			{
				redirect(base_url('/'));
			}
		}
	
	}
	
	
	#Twitter Callback
	public function twitter_callback(){
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		if($this->session->userdata('is_user_logged_in')) 
		{
			$this->session->set_flashdata('success','You already loged in');
			redirect(base_url());	
		}
		if($this->input->get('oauth_token') && $this->session->userdata('request_token') !== $this->input->get('oauth_token'))
		{
			$this->reset_session();
			redirect(base_url().'twitter');
		}
		else
		{
			$access_token = $this->connection->getAccessToken($this->input->get('oauth_verifier'));
			if($this->connection->http_code == 200)
			{
				$user_info = $this->connection->get('account/verify_credentials'); 
				if(!empty($user_info))
		        {
					$user_info=(array)$user_info;
		            $user_status=$this->home_model->user_type_check($user_info['id'],'','5','verify');
					if($user_status > 0)
					{
						$this->session->set_flashdata('error',$this->lang->line('email_exists'));
						redirect(base_url().'login');
					}
					else
		            {
						   $user_account=$this->home_model->user_type_check($user_info['id'],'','5','authorize');
						   if($user_account)
						   {
							  if($user_account['is_active']==0)
							  {
								$this->session->set_flashdata('error', $this->lang->line('account_deactivated'));
								redirect(base_url().'login');
							  }
			                  else
			                  {
									$maindata = array (
													'user_email'	=> $user_account['email'],
													'user_id'		=> $user_account['id'],
													'is_user_logged_in'	=> true
									);
									$common_data = array(
												'user_name'		=> $user_account['email'],
												'is_logged' 	=> true,
												'user_type'		=> $user_account['user_type'],
										        'register_type'  => $user_account['register_type'],
											);
											$data = array_merge($maindata,$common_data);
											$this->home_model->last_login_time($user_name,$user_account['id']);
											$this->session->set_userdata($data);
											$this->session->set_flashdata('success','You Successfully login');
											redirect(base_url());
			                   }
		                    }
		                    else
		                    {
									$fb_user_profile_image_id=$user_info['id'];
									$base_url = $user_info['profile_image_url'];
									$filename=$user_info['id'].'.jpeg';
									$upload_path=$this->config->item('profile_url');
									$upload = file_put_contents($upload_path.$filename,file_get_contents($base_url));
									$profile_image_data=array();
									$profile_image_data['img_dir']=$upload_path;
									$profile_image_data['filename']=$filename;
									$user_account=$this->home_model->social_create_account($user_info,'4',$profile_image_data);
									$maindata = array (
											'user_email'=> $user_account['email'],
											'user_id'=> $user_account['id'],
											'is_user_logged_in'=> true
									);
									$common_data = array(
													'user_name'=> $user_account['email'],
													'is_logged'=> true,
													'user_type'=> $user_account['user_type'],
													'register_type'  => $user_account['register_type'],
										);
								  $data = array_merge($maindata,$common_data);
								  $this->home_model->last_login_time($user_name,$user_account['id']);
								  $this->session->set_userdata($data);
								  $this->session->set_flashdata('success','You Successfully login');
								  redirect(base_url()); 
		                   }
		            }
					
				}
			}
			else
			{
				$this->session->set_flashdata('error','Something Went Wrong');
				redirect(base_url().'login');
			}
		}
		
	}
	
	#Facbook Config
	public function facebook(){
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->data['customer'] = "";
		$this->data['hotel'] = "";
		if($this->session->userdata('is_user_logged_in')) 
		{
			redirect(base_url());
		}
		
		$this->load->library('facebook');
		$params=array('redirect_uri'=>site_url().'home/facebook_login');
		$facebook_url = $this->facebook->getLoginUrl($params);
		redirect($facebook_url);
	}
	
	#Facebook Login -CallBack Url
	public function facebook_login(){
	
		$this->data['customer'] = "";
		$this->data['hotel'] = "";
		if($this->session->userdata('is_user_logged_in')) 
		{
			redirect(base_url());
		}
		else 
		{
        $this->load->library('facebook');
		$user = $this->facebook->getUser();
		 if(empty($user)) 
		 {
		 $this->session->set_flashdata('facebook_access_token',true);
		 redirect(base_url().'login');
		 }
		$fb_user= $this->facebook->api('/me');
		if(!empty($fb_user))
		{
		 $fb_user['email']=(isset($fb_user['email']))?$fb_user['email']:'';
		 $user_status=$this->home_model->user_type_check($fb_user['id'],$fb_user['email'],'2','verify');
		if($user_status > 0)
		{
			$this->session->set_flashdata('email_exists',$this->lang->line('email_exists'));
			redirect(base_url().'login');
		}
		else
		{
		   $user_account=$this->home_model->user_type_check($fb_user['id'],$fb_user['email'],'2','authorize');
		   if($user_account)
           {
		      if($user_account['is_active']==0)
			  {
			    $this->session->set_flashdata('error', $this->lang->line('account_deactivated'));
			    redirect(base_url().'login');
			  }
			  else
			  {
			    $maindata = array (
								'user_email'	=> $user_account['email'],
								'user_id'		=> $user_account['id'],
								'is_user_logged_in'	=> true
			    );
		        $common_data = array(
							'user_name'		=> $user_account['email'],
							'is_logged' 	=> true,
							'user_type'		=> $user_account['user_type'],
							'register_type'  => $user_account['register_type'],
						);
						$data = array_merge($maindata,$common_data);
						$this->home_model->last_login_time($user_name,$user_account['id']);
						$this->session->set_userdata($data);
						$this->session->set_flashdata('success','You Successfully login');
						redirect(base_url());
			  }
		   }
		   else
		   {
		    $fb_user_profile_image_id=$fb_user['id'];
		    $base_url = "http://graph.facebook.com/".$fb_user_profile_image_id."/picture?type=large";
		    $filename=$fb_user_profile_image_id.'.jpeg';
			$upload_path=$this->config->item('profile_url');
		    $upload = file_put_contents($upload_path.$filename,file_get_contents($base_url));
			$profile_image_data=array();
			$profile_image_data['img_dir']=$upload_path;
			$profile_image_data['filename']=$filename;
		    $user_account=$this->home_model->social_create_account($fb_user,'2',$profile_image_data);
			$maindata = array (
					'user_email'=> $user_account['email'],
					'user_id'=> $user_account['id'],
					'is_user_logged_in'=> true
			);
		    $common_data = array(
							'user_name'=> $user_account['email'],
							'is_logged'=> true,
							'user_type'=> $user_account['user_type'],
							'register_type'  => $user_account['register_type'],
				);
		  $data = array_merge($maindata,$common_data);
		  $this->home_model->last_login_time($user_name,$user_account['id']);
		  $this->session->set_userdata($data);
		  $this->session->set_flashdata('success','You Successfully login');
		  redirect(base_url()); 
		   }
		}
       }
	   }
	}
	
	#Home - Verify Account
    public function verify($vid = NULL){
    	if($this->session->userdata('is_user_logged_in')) {
			redirect(base_url());
		} 
		else {
			if($vid!="") {
				if($this->home_model->check_verify_code($vid)){
					$this->session->set_flashdata('success',"Your Acount activated successfully.");
					redirect(base_url().'login');
	
				}else{
					$this->session->set_flashdata('error', $this->lang->line('hotel_session_expires'));
					redirect(base_url().'login');
				}
			}
		}
    }
	
	#Home Google Plus Login
	public function googleplus(){
		
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		$this->data['customer'] = "";
		$this->data['hotel'] = "";
		if($this->session->userdata('is_user_logged_in')) 
		{
			redirect(base_url());
		}
		$provider_name="google";
        $this->load->library('oauth2/OAuth2');
		$this->load->config('googleplus', TRUE);
        $provider = $this->oauth2->provider($provider_name, array(
            'id' => $this->config->item($provider_name.'_id', 'googleplus'),
            'secret' => $this->config->item($provider_name.'_secret', 'googleplus'),
			'redirect_uri'=>$this->config->item($provider_name.'_redirecturi', 'googleplus'),
			'scope'=>array('profile email','profile'),
        ));
		if( ! $this->input->get('code'))
        {
            $provider->authorize();	
        }
		die;
	}
	
	#Home _google Plus Callback
	public function googleplus_login(){
			$provider_name="google";
			$this->load->library('oauth2/OAuth2');
			$this->load->config('googleplus', TRUE);
			$provider = $this->oauth2->provider($provider_name, array(
				'id' => $this->config->item($provider_name.'_id', 'googleplus'),
				'secret' => $this->config->item($provider_name.'_secret', 'googleplus'),
				'redirect_uri'=>$this->config->item($provider_name.'_redirecturi', 'googleplus'),
				'scope'=>array('profile email','profile'),
			));
		     $token = $provider->access($this->input->get('code'));
             $user = $provider->get_user_info($token);
			 if(!empty($user))
			 {
				 $user['email']=(isset($user['email']))?$user['email']:'';
				 $user_status=$this->home_model->user_type_check($user['uid'],$user['email'],'3','verify');			 
				 if($user_status > 0)
				 {
		           $this->session->set_flashdata('error','Email Already Exists'); 
				   redirect(base_url().'login');
				 }
			    else
			    {
					$user_account=$this->home_model->user_type_check($user['uid'],$user['email'],'3','authorize');
					if($user_account)
					{
						if($user_account['is_active']==0)
						{
						   $this->session->set_flashdata('error', $this->lang->line('account_deactivated'));
						}
					    else
					    {
						   $this->load->library('session');
						   $maindata = array (
										'user_email'	=> $user_account['email'],
										'user_id'		=> $user_account['id'],
										'is_user_logged_in'	=> true
						   );
						   $common_data = array(
									'user_name'		=> $user_account['email'],
									'is_logged' 	=> true,
									'user_type'		=> $user_account['user_type'],
									'register_type'  => $user_account['register_type'],
								);
															
								$data = array_merge($maindata,$common_data);
								$this->home_model->last_login_time($user_account['email'],$user_account['id']);
								$this->session->set_userdata($data);
								$this->session->set_flashdata('success', $this->lang->line('you are successfully logged in'));
								redirect(base_url());
					  }
					}
			       else
			       {
							$base_url = $user['image'];
							$filename=$user['uid'].'.jpeg';
							$upload_path=$this->config->item('profile_url');
							$upload = file_put_contents($upload_path.$filename,file_get_contents($base_url));
							$profile_image_data=array();
							$profile_image_data['img_dir']=$upload_path;
							$profile_image_data['filename']=$filename;
							$user_account=$this->home_model->social_create_account($user,'3',$profile_image_data);
							$maindata = array (
									'user_email'=> $user_account['email'],
									'user_id'=> $user_account['id'],
									'is_user_logged_in'=> true
							);
							$common_data = array(
											'user_name'=> $user_account['email'],
											'is_logged'=> true,
											'user_type'=> $user_account['user_type'],
											'register_type'  => $user_account['register_type'],
								);
						  $data = array_merge($maindata,$common_data);
						  $this->session->set_userdata($data);
						  $this->session->set_flashdata('success', $this->lang->line('you are successfully logged in'));
						  redirect(base_url()); 
			        }
		       }
		    }
	}
	
    #Home Password Encryption	
	function __encrip_password($password) {
		return md5($password);
    }
	
	#Home - Get Pages
    public function get_pages(){
		
        $slug=$this->uri->segment('1');
		$this->data['my_content']=$this->home_model->get_pages($slug);
		if(empty($this->data['my_content']))
		{
			redirect(base_url());
		}
		$this->data['title_of_layout']=$this->data['my_content']['meta_keywords'];
		$this->data['title_of_description']=$this->data['my_content']['meta_description'];
		$this->data['main_content']=$this->load->view('pages/index', $this->data,true);
		$this->load->view('layouts/default', $this->data);
	}	
    
	#Contact Us
	public function contact_us(){
		    
			if($_POST) 
			{
				$this->form_validation->set_rules('name',ucwords($this->lang->line('name')),'trim|required|min_length[3]');
				$this->form_validation->set_rules('contact_number',ucwords($this->lang->line('Contact Number')),'trim|required|min_length[10]|numeric');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
				$this->form_validation->set_rules('title',ucwords($this->lang->line('title')),'trim|required|min_length[3]');
				$this->form_validation->set_rules('message',ucwords($this->lang->line('message')),'trim|required|min_length[3]');
				if($this->form_validation->run() == true) 
				{
				     if($this->home_model->add_contactus())
					 {
					  $json_array['status']="success";
                      $json_array['msg']="Thanks For Contact Us.We Shotly Contact You.";	
					  echo json_encode($json_array);	
                      die; 
					 }	
                     else
                     {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Contact Us Could not be saved.Please Try Again..!";	
					  echo json_encode($json_array);	
                      die;	
					 }						 
				}
				else
				{
					echo $this->form_validation->get_json();
					die;	
					
				}
				
			}
			$this->breadcrumbs->push($this->site_name,base_url());
			$this->breadcrumbs->push(ucfirst('Contact'),base_url());	
			$this->data['title_of_layout']="Contact Us";
			$this->data['title_of_description']=$this->site_name." - Contact Us";
			$this->data['main_content']=$this->load->view('contact-us', $this->data,true);
			$this->load->view('layouts/default', $this->data);
	}
	
	# Claim My Bussiness
	public function claim_my_bussiness(){
			if($_POST) 
			{
				$this->form_validation->set_rules('name',ucwords($this->lang->line('Name')),'trim|name|required');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
				$this->form_validation->set_rules('contact_number',ucwords($this->lang->line('Contact Number')),'trim|required');
				$this->form_validation->set_rules('url',ucwords($this->lang->line('Url')),'trim|required|valid_url_format');
				$this->form_validation->set_rules('message',ucwords($this->lang->line('message')),'trim|required|min_length[3]');
				if($this->form_validation->run() == true) 
				{
				     if($this->home_model->add_claim())
					 {
					  $json_array['status']="success";
                      $json_array['msg']="Your Request Accepted Successfully.We Shotly Contact You.";	
					  echo json_encode($json_array);	
                      die; 
					 }	
                     else
                     {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Claim Could not be saved.Please Try Again..!";	
					  echo json_encode($json_array);	
                      die;	
					 }						 
				}
				else
				{
					echo $this->form_validation->get_json();
					die;	
					
				}
				
			}
			$this->breadcrumbs->push($this->site_name,base_url());
			$this->breadcrumbs->push(ucfirst('Claim My Bussiness'),base_url());	
			$this->data['title_of_layout']="Claim My Bussiness";
			$this->data['title_of_description']=$this->site_name." - Claim My Bussiness";
			$this->data['main_content']=$this->load->view('claim-my-business', $this->data,true);
			$this->load->view('layouts/default', $this->data);
	}
	
	# About Us
	public function about_us(){
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push(ucfirst('About Us'),base_url());	
		$this->data['title_of_layout']="About Us";
		$this->data['title_of_description']=$this->site_name." - About Us";
		$this->data['main_content']=$this->load->view('about-us', $this->data,true);
		$this->load->view('layouts/default', $this->data);
	}
	
	# Privacy Ploicy
	public function privacy_policy(){
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push(ucfirst('Privacy Policy'),base_url());		
		$this->data['title_of_layout']="Privacy Policy";
		$this->data['title_of_description']=$this->site_name." - Privacy Policy";
		$this->data['main_content']=$this->load->view('privacy-policy', $this->data,true);
		$this->load->view('layouts/default', $this->data);
	}

	#Home City Based Area
	public function get_city_based_area(){
	  $areas_info=array();
	  $areas_info['0']="Select Location";
	  $city_name=(isset($_GET['city']))?$_GET['city']:'';
      $my_areas=$this->home_model->get_areas($city_name);
	  if(!empty($my_areas))
	  {  
		foreach($my_areas as $area)
		{
			$areas_info[$area['name']]=ucwords($area['name']);	
		}		
	  }
	  echo  json_encode($areas_info);die;
	}
	
	#Home Get Home Autocomplete
	public function get_litings(){
	  $list_info=array();
      $city=(isset($_GET['city']))?$_GET['city']:'';
      $area=(isset($_GET['area']))?$_GET['area']:'';
      $keyword=(isset($_GET['term']))?$_GET['term']:'';
	  $all_list=$this->home_model->get_my_list($keyword,$city,$area);
	  if(!empty($city) && !empty($area))
	  {
		  $type='2';
		  $all_category=$this->home_model->get_category($keyword,$city,$area);
	  }
	  else
	  {
		  $type="3";
	      $all_category=$this->home_model->get_category($keyword);
      }
	  $all_my_list=array();
      if(!empty($all_list))
      {
		$i=0;
		foreach($all_list as $list)
		{
		         $all_my_list[$i]['id']=$list['id'];
                 $city_name=(isset($list['city_name']) && $list['city_name']!='')?',in <span class="city_highlight">'.$list['city_name'].'</span>':'';
				 $all_my_list[$i]['label']=$list['add_name'].' '.$city_name;
                 $all_my_list[$i]['value']=$list['add_name'];
				 $link=base_url().'business'.'/'.$list['id'].'/'.url_title(strtolower($list['add_name']));
                 $all_my_list[$i]['url']=$link;			 
                 $all_my_list[$i]['type']='list_detail';				 
		  	     $i++;
		}   
	  }
	  $my_all_cat=array();	  
      if(!empty($all_category))
	  {
		$i=0;
		foreach($all_category as $category)
		{
		         $my_all_cat[$i]['id']=$category['id'];
                 $city_name=(isset($category['city_name']) && $category['city_name']!='')?',in <span class="city_highlight">'.$category['city_name'].'</span>':'';
				 $area_name=(isset($category['area_name']))?','.'<span class="city_highlight">'.$category['area_name'].'</span>':'';
				 $my_all_cat[$i]['label']=$category['name'].' '.$city_name.$area_name;	
                 $my_all_cat[$i]['value']=$category['name'];	
                 $my_all_cat[$i]['city_name']=(isset($category['city_name']))?$category['city_name']:'';					 
				 $my_all_cat[$i]['area_name']=(isset($category['area_name']))?$category['area_name']:'';
                 $my_all_cat[$i]['type']='cat';				 
		  	     $i++;
		}	  
	  }
	  
      $list_info=array_merge($my_all_cat,$all_my_list);
	  echo json_encode($list_info);
	  die;	  
	}
	
	#Home - Get Cities
	public function get_groups(){
		$this->load->model('groups_model');
		$keyword=(isset($_GET['term']))?$_GET['term']:'';
		$all_list=$this->groups_model->get_add_groups($keyword,$this->session->userdata('user_id'));
		echo json_encode($all_list);
		die;
	}
}
?>