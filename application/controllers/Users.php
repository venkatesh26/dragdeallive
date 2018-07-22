<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    #Construct Function
	public function __construct() {
        parent::__construct();
		$this->load->model('users_model');
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
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
		$this->data['user_data']=$this->users_model->get_userinfo($this->session->userdata('user_id'));
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
				        $this->users_model->update_user_profile($this->session->userdata('user_id'),$profile_image);	
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
		$this->load->view('layouts/customer', $this->data);	
	}
	
	###############Check User Email###############
	public function user_mail_check() {
	   $email=$this->input->post('email');	
	   $userId=$this->session->userdata('user_id');
	   $user_info=$this->users_model->get_email_info($email,$userId);
	   if(!empty($user_info)) {
		 $this->form_validation->set_message('user_mail_check', 'Email Already Exists');
		 return FALSE;		
		}
     	return true;		
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
			$this->data['main_content']=$this->load->view('users/change_password', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
	
	#Users - Logout Page
	public function logout(){
		$url = 'login';
		$this->session->sess_destroy();
		$this->session->set_flashdata('success','You Successfully logout..!');
		redirect($url);
	}

	######## User Register ###########
	public function register() {
		
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push(ucfirst('Register'),base_url());	
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
			if($_POST) {
				$this->form_validation->set_rules('first_name','First name','trim|required|min_length[3]');
				$this->form_validation->set_rules('contact_number','Mobile Number','trim|required|min_length[10]|numeric|is_unique[users.contact_number]');
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required|is_unique[users.email]');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
				if($this->form_validation->run() == true) {
					$email_activation_id = random_string('alnum', 10);
					$roles=$this->config->item('user_role_type');
					$user_type_id=$roles['siteuser'];
					if($this->input->post('is_vendor')==1){
						$user_type_id=$roles['vendor'];
					}
					$success = $this->users_model->create_account($email_activation_id, $user_type_id);
					if($success)  {
						$data = array(
							'user_name'  => $this->input->post('name'),
							'user_email' => $this->input->post('email'),
							'password'	 => $this->input->post('password'),
							'verifylink' => $email_activation_id
						);
						$this->load->model('notification_model');
						$new_data=array('username'=>$this->input->post('name'),'user_id'=>$success);
						$this->notification_model->common_save_notification('WELCOME',$new_data);						
						$this->common_model->SendEmail($this->input->post('email'), "Thanks For Register -".$this->site_name, $data, 'register_site_user');
						$extra_array = array('status'=>'success','msg'=>'You Successfully Register.. Pls check your mail to verify your account.','url'=>base_url());
						echo json_encode($extra_array);
						die;
					}
				} 
				else {
					echo $this->form_validation->get_json();
					die;
				}
			}
			$this->data['title_of_layout']=$this->site_name." - Login - Sign Up";
			$this->data['meta_keywords']=$this->site_name." - Login - Sign Up";
			$this->data['title']="Sign Up";
			$this->data['redirect_url']=(isset($_GET['redirect_url']))?$_GET['redirect_url']:'';
			if(!$this->input->is_ajax_request()){
				$this->data['reg_login']='1';
				$this->data['main_content']=$this->load->view('users/register', $this->data,true);
				$this->load->view('layouts/default', $this->data);
			}
			else {
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
		if($this->session->userdata('is_user_logged_in')){
			redirect(base_url());
            $extra_array = array('status'=>'already register','redirect_url'=>base_url().'dashboard');
			echo json_encode($extra_array);	
            die;			
		}
		else {
			if($_POST) {
				$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				if($this->form_validation->run() == true) {
					$user_name = $this->input->post('email');
					$password = md5($this->input->post('password'));
					$is_valid = $this->users_model->validate_users($user_name, $password);
					if(empty($is_valid)){
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Invalid Credential Please Try Again..!";						  
					}
					else if($is_valid->is_email_confirmed == 0)  {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Your Email Is Not Confirm Please Try Again..!";	
					}
					else if($is_valid->is_active == 0)  {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Your Account InActivated By Admin Due To Some Security Reason.. Please Try Again..!";	
					}
					else{
					   
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
					  $this->users_model->last_login_time($is_valid->email);
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
				else {
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
		if($this->session->userdata('is_user_logged_in')) {
			redirect(base_url());
            $extra_array = array('status'=>'Sorry you already Log in','redirect_url'=>base_url());
			echo json_encode($extra_array);	
            die;			
		}
		else {
			if($_POST) {
				$this->form_validation->set_rules('email_address', 'Email','trim|required|valid_email');
				if($this->form_validation->run() == true) {
			     
				  if(!$this->users_model->valid_user_type($this->input->post('email_address'))) {
					   $json_array['status']="error";
					   $json_array['sts']="custom_err";
                       $json_array['msg']="Invalid User... Please Try Again..!";	
					   echo json_encode($json_array);	
                       die;	
				   }
				  $uid=rand();
				  if($this->users_model->check_user_available($this->input->post('email_address'),$uid)) {
					$this->load->library('template');
					$userInfo=$this->users_model->getUsername($this->input->post('email_address'));
                    $user_name=$userInfo['first_name'];
					$data = array(
						'user_email' => $this->input->post('email_address'),
						'resetpassword_url'  => $this->config->item('resetpassword_url').$uid,'username'=>$user_name
					);
					if ($this->common_model->SendEmail($this->input->post('email_address'), 'Forgot Password', $data, 'forgot_password')) {	
					  $json_array['status']="success";
					  $json_array['url']=base_url();
					  $this->session->set_flashdata('success','Please check your mail to reset your password'); 
					} 
					else {
					  $json_array['status']="success";
					  $json_array['url']=base_url();
                      $this->session->set_flashdata('error','Mail Could not be send'); 
					}
					
					########## Notifications Create ##############
					$this->load->model('notification_model');
					$new_data=array('username'=>$user_name,'user_id'=>$userInfo['id']);
					$this->notification_model->common_save_notification('FORGOT',$new_data);	
					echo json_encode($json_array);die; 
				}
				else {	
					$this->session->set_flashdata('flash_message', $this->lang->line('email_not_exist'));
					if(!$this->input->is_ajax_request()) {
						$this->session->set_flashdata('error','Invalid User...Please Try Again..!');
						redirect('users/forgot_password');
					}
					else {
					  $json_array['status']="error";
					  $json_array['sts']="custom_err";
                      $json_array['msg']="Invalid User...Please Try Again..!";	
					  echo json_encode($json_array);	
                      die;	
					}
				}		
				}
				else{
					echo $this->form_validation->get_json();
					die;
				}
			}
		}
		$this->data['title_of_layout']=$this->site_name." - Forgot Password";
		$this->data['meta_keywords']=$this->site_name." - Forgot Password";
		$this->data['title']="Forgot Password";		
		if(!$this->input->is_ajax_request()){
			$this->data['reg_login']='1';
			$this->data['main_content']=$this->load->view('users/forgot_password_normal', $this->data,true);
			$this->load->view('layouts/default', $this->data);
		}
		else {
			$this->load->view('users/forgot_password', $this->data);
		}
	}	

    #Users - Reset Password
	public function reset_password() {
		$slug=$this->uri->segment('2');
		$user_info=$this->users_model->get_user_info($slug);
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		if($this->session->userdata('is_user_logged_in')) {
			$this->session->set_flashdata('success','You already loged in');
			redirect(base_url());	
		}
		else {
			
		   if($_POST) {
				if($this->users_model->check_user_uid($slug)){
				  $this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]|max_length[32]');
		          $this->form_validation->set_rules('confirm_password', 'Confirm Password','trim|required|matches[password]');
					if($this->form_validation->run() == true) {
						$email=$user_info['email'];
						if($this->users_model->update_password($email)) {
							$json_array['status']="success";
							$json_array['url']=base_url().'login';
							$this->session->set_flashdata('success','Password Reset Successfully.Please login below'); 
							echo json_encode($json_array);	
							die;	
						}
						else {
							$json_array['status']="error";
							$json_array['sts']="custom_err";
							$json_array['msg']="Invalid User...Please Try Again..!";	
							echo json_encode($json_array);	
							die;	
						}
					}
				   else{
			  	    echo $this->form_validation->get_json();
					die;	
				  }
				}
				else {
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

	########## Check User Information ########
	public function check_customer_availability() {
		$this->form_validation->set_rules('contact_number','Mobile Number','trim|required|numeric|min_length[10]|max_length[10]');
		if($this->form_validation->run() == true){
			$datas=$this->users_model->checkUserInfo($this->session->userdata('user_id'));			
			if($datas) 
			{
				$success=$this->users_model->checkCustomerUsers($this->session->userdata('user_id'),$datas['id']);
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

}