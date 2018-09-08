<?php
class Api extends CI_Controller {

    ######### Construct Model ##########
    public function __construct() {
        parent::__construct();
		$this->load->model('users_model');
		$this->load->model('advertisment_store_products_model');
		$this->load->model('countries_model');
		$this->load->model('advertisment_model');
		$this->load->model('countries_model');
		$this->load->model('home_model');
    }
	
	########### Dashboard List #############
	public function getRevenueInfomation($user_id=null){
		
		$response['code']=500;
		$response['message']="Invalid Request";	
		$response['status']=FALSE;
		if($user_id!=''){		
			$response['data']=getCustomerBillInformation($user_id);
			$response['code']=200;
			$response['status']=TRUE;
			$response['message']="Success";	
		}
		echo json_encode($response);
		die;
	}
	
	########### Forgot Password #############
	public function forgotpassword(){
		$response['code']=500;
		$response['message']="Invalid Request";		
		$response['status']=false;
		if($_POST) {

			$this->form_validation->set_rules('email', 'Email','trim|required|valid_email');
			if($this->form_validation->run() == true) {
				if(!$this->users_model->valid_user_type($this->input->post('email'))) {
					$response['status']=FALSE;
                    $response['message']="Invalid User... Please Try Again..!";	
					$response['code']=200;
				 }
				else { 
					$uid=rand();
					if($this->users_model->check_user_available($this->input->post('email'),$uid)) {
						$this->load->library('template');
						$userInfo=$this->users_model->getUsername($this->input->post('email'));
						$user_name=$userInfo['first_name'];
						$data = array(
							'user_email' => $this->input->post('email'),
							'resetpassword_url'  => $this->config->item('resetpassword_url').$uid,'username'=>$user_name
						);
						$this->common_model->SendEmail($this->input->post('email'), 'Forgot Password', $data, 'forgot_password');	
						$response['status']=TRUE;
						$response['message']="Please check your mail to reset your password";
						$response['code']=200;						
					}
					else {	
					  $response['status']=FALSE;
                      $response['message']="Invalid User...Please Try Again..!";	
					  $response['code']=200;
					}		
				}
			}
			else {
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
				$response['code']=200;
			}
		}
		echo json_encode($response);
        die;
	}
	
	################ Login Api Service ############
	public function login(){
		$response['code']=500;
		$response['message']="Invalid Request";	
		$response['status']=FALSE;		
		if($_POST) {
			$response['code']=200;
			$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if($this->form_validation->run() == true) {
					$user_name = $this->input->post('email');
					$password = md5($this->input->post('password'));
					$is_valid = $this->users_model->validate_users($user_name, $password, 2);
					if(empty($is_valid)){
					  $response['status']=FALSE;
                      $response['message']="Invalid Credential Please Try Again..!";						  
					}
					else if($is_valid->is_email_confirmed == 0)  {
					  $response['status']=FALSE;
                      $response['message']="Your Email Is Not Confirm Please Try Again..!";	
					}
					else if($is_valid->is_active == 0)  {
					  $response['status']=FALSE;
                      $response['message']="Your Account InActivated By Admin Due To Some Security Reason.. Please Try Again..!";	
					}
					else{
					   
					    $data = array (
							'customer_id'       => $is_valid->customer_id,
							'email'		        => $is_valid->email,
							'user_id'			=> $is_valid->id,
							'contact_number'    => $is_valid->contact_number,
							'is_user_logged_in'	=> true,
							'user_name'			=> $user_name,
							'is_logged' 		=> true,
							'user_type'			=> $is_valid->user_type,
							'register_type'     => $is_valid->register_type
					    );
						$response['users'] = $data;
						$this->users_model->last_login_time($is_valid->email);
						$response['status']=TRUE;
						$response['message']="Welcome ! You Successfully Logged In.";						
					}
				} 
			else {
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
			}
	    }
		echo json_encode($response);
        die;			
	}

	##########Cusomer Change Password################# 
	public function change_password()  {
		$response['code']=500;
		$response['message']="Invalid Request";	
		$response['status']=FALSE;		
		if($_POST) {
			$response['code']=200;
			$this->form_validation->set_rules('new_password','New Password','trim|required|min_length[6]|max_length[32]');
			$this->form_validation->set_rules('confirm_password','Confirm Password','trim|required|min_length[6]|max_length[32]|matches[new_password]');
			$this->form_validation->set_rules('user_id',"User Id",'trim|required');
			if($this->form_validation->run()){
				$this->home_model->change_password($_POST['user_id'], md5($_POST['new_password']));	
				$response['status']=TRUE;
				$response['message']="Password Changed Successfully.";			
			}
			else {
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
			}
		}
		echo json_encode($response);
        die;	
	}
	
	############# Get Vendor Product List ###############
	public function allproductlist($user_id=null){
		
		$response['code']=500;
		$response['message']="Invalid Request";	
		$response['status']=FALSE;
    if($user_id!=''){		
			$response['data']=$this->advertisment_store_products_model->get_all_products_list($user_id);
			$response['code']=200;
			$response['status']=TRUE;
			$response['message']="Success";	
		}
		echo json_encode($response);
        die;
		
	}

	################### Product List ######################
	public function productList(){
        $response['code']=500;
		$response['message']="Invalid Request";		
		$response['status']=false;
		if($_POST) { 
			$response['code']=200;
			$this->form_validation->set_rules('user_id',"User Id",'trim|required');
			if($this->form_validation->run() == true) {
				$user_id=$this->input->post('user_id');
				$limit_start=10;
				if(isset($_GET['per_page']) && $_GET['per_page']!=''){
					$limit_start=$_GET['per_page'];
				}
				$page_num = 1;
				if(isset($_GET['page']) && $_GET['page']!=''){
					$page_num=$_GET['page'];
				}
				$limit_end = ($page_num-1) * $limit_start;
				$response['page']=$page_num;
				$response['per_page']=$limit_start;
				$response['data']=$this->advertisment_store_products_model->getProductList($user_id, $limit_start, $limit_end);
				$response['status']=TRUE;
				$response['message']="Success";
			}
			else {
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
			}
		}
       	echo json_encode($response);
        die;		
	}

	####################### Product Add Api Service ################
	public function addbulkProduct(){
        $response['code']=500;
		$response['message']="Invalid Request";		
		$response['status']=false;
		if($_POST) {
			$response['code']=200;			
			$this->form_validation->set_rules('name[]',"Name",'trim|required');
			$this->form_validation->set_rules('amount[]',"amount",'trim|required');
			$this->form_validation->set_rules('user_id',"User ID",'trim|required');
			if($this->form_validation->run() == true) {
				$user_id=$this->input->post('user_id');
				foreach($_POST['name'] as $key=>$product){	
					$price=$_POST['amount'][$key];
					$product_id=$this->advertisment_products_model->productFindOrSave($product, $price);
					if(!$this->advertisment_store_products_model->check_product_exists($user_id, $product_id)){
						$advertisment_store_products=array(
							'created'=>date('Y-m-d h:i:s'),
							'user_id'=>$user_id,
							'product_id'=>$product_id,
							'price'=>$price,
							'is_active'=>1,
						);
						$this->db->insert('advertisment_store_products', $advertisment_store_products);	
					}			
				}
				$response['message']="Product Saved Successfully";	
				$response['status']=TRUE;				
			}
			else{
				
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
				
			}
		}
		echo json_encode($response);
        die;	
	}

	####################### Product Add Api Service ################
	public function addProduct(){
		$response['code']=500;
		$response['message']="Invalid Request";		
		$response['status']=false;
		if($_POST) {
			$response['code']=200;			
			$this->form_validation->set_rules('name',"Name",'trim|required');
			$this->form_validation->set_rules('price',"price",'trim|required');
			$this->form_validation->set_rules('user_id',"User ID",'trim|required');
			if($this->form_validation->run() == true) {
				$user_id=$this->input->post('user_id');
				$product=$_POST['name'];
				$price=$_POST['price'];
				$product_id=$this->advertisment_products_model->productFindOrSave($product, $price);
				if(!$this->advertisment_store_products_model->check_product_exists($user_id, $product_id)){
						$advertisment_store_products=array(
							'created'=>date('Y-m-d h:i:s'),
							'user_id'=>$user_id,
							'product_id'=>$product_id,
							'price'=>$price,
							'is_active'=>1,
						);
						$this->db->insert('advertisment_store_products', $advertisment_store_products);		
				}
				$response['message']="Product Saved Successfully";	
				$response['status']=TRUE;				
			}
			else{
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
				
			}
		}
		echo json_encode($response);
    die;	
	}
   
  ############## Update Product #############################
	public function updateProduct(){
		$response['code']=500;
		$response['message']="Invalid Request";		
		$response['status']=false;
		if($_POST) {
			$response['code']=200;
			$this->form_validation->set_rules('name',"Name",'trim|required');
			$this->form_validation->set_rules('price',"price",'trim|required');
			$this->form_validation->set_rules('user_id',"User ID",'trim|required');
			$this->form_validation->set_rules('product_id',"Product ID",'trim|required');
			if($this->form_validation->run() == true) {
				$user_id=$_POST['user_id'];	
				$product_id=$_POST['product_id'];	
				$success=$this->advertisment_store_products_model->update_products($user_id, $product_id);
				$response['message']="Product Updated Successfully";	
				$response['status']=TRUE;	
			}
			else{
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
			}				
		}
		echo json_encode($response);
        die;	
	}	
	
   public function getProductDetails($product_id=null, $user_id=null){
		$response['code']=500;
		$response['message']="Invalid Request";	
		$response['status']=FALSE;
		if($product_id && $user_id){
			$response['code']=200;
			$response['message']="Success";
			$response['data']=$this->advertisment_store_products_model->get_product($user_id, $product_id);
		}		
		echo json_encode($response);
        die;
	}
	
    ######## Check Customer Avaibilty Checking ############
	public function checkCustomerAvailibity(){
		$response['code']=500;
		$response['message']="Invalid Request";	
		$response['status']=FALSE;
		if($_POST) {
			$response['code']=200;
			$this->form_validation->set_rules('contact_number','Mobile Number','trim|required|numeric|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_id','User ID','trim|required');
			if($this->form_validation->run() == true){
				$user_id=$_POST['user_id'];
				$datas=$this->users_model->checkUserInfo($user_id);			
				if($datas) {
					$success=$this->users_model->checkCustomerUsers($user_id, $datas['customer_id']);
					if($success){
						$response['status']=TRUE;
						$response['CUSTOMER_STATUS']="EXISTING_USER";
						$response['message']="Error !!! Customer Information Already Existing";
						$response['data']=$datas;
					}else{
						$response['status']=TRUE;
						$response['CUSTOMER_STATUS']="EXISTING_USER";
						$response['message']="Error !!! Customer Information Available";
						$response['data']=$datas;
					}				
				}
				else {
					$extra_array = array('status'=>'NEW_USER_ADD','msg'=>'Sorry Customer Information Not Available.');
					echo json_encode($extra_array);
					die;	
				}
			} 
			else{
				$errors=$this->form_validation->get_json();
				$errors=json_decode($errors, true);
				$response['errors']=$errors['errorfields'];
			}
		}
		echo json_encode($response);
    die;
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
					$success=$this->advertisment_customers_model->add_customers($this->session->userdata('user_id'));				
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
	 
	###################### Customer Add #####################
	public function CustomerAdd() {
		$this->data=array();
		if($_POST) 
		{
				$this->form_validation->set_rules('email','Email','trim|valid_email');
				$this->form_validation->set_rules('first_name','First Name','trim|required');
				$this->form_validation->set_rules('gender','Gender','trim|required');
				if($this->form_validation->run() == true) 
				{
					$success=$this->advertisment_customers_model->add_customers($this->session->userdata('user_id'));
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
}
