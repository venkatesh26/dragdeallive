<?php
class User extends CI_Controller {
	
	public function __construct()
   	 {
		parent::__construct();
		$this->load->model('webuser_model');
		$this->load->model('Users_model');
		$this->load->library('form_validation');
				$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	function index() 
	{
		//Session redirection
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		//Session redirection
		if($this->session->userdata('is_logged_in')){
			redirect(ADMIN.'/dashboard');
		}else{
			$this->form_validation->set_rules('user_name', 'Email','trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password','trim|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">
					<a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			if($this->form_validation->run() == FALSE) {
				$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				//redirect('admin/login');
				//$this->load->view('admin/login', $this->data);
			} else {
				$user_name = $this->input->post('user_name');
				$password = $this->__encrip_password($this->input->post('password'));
				$is_valid = $this->Users_model->validate($user_name, $password);
				if($is_valid) {
					if($is_valid['user_type']=='4'){
						$subAdmin= true;
					} else {
						$subAdmin= false;
					}
					$data = array(
						'user_names' 	=> $is_valid['first_name'],
						'is_logged_in'	=> true,
						'admin_user_type'=> $is_valid['user_type'],
						'is_sub_admin'	=> $subAdmin,
						'admin_id'		=> $is_valid['id']
					);
					$this->Users_model->last_login_time($user_name);
					$this->session->set_userdata($data);
					redirect(ADMIN.'/dashboard');
				}
				else {
					$this->data['message_error'] = TRUE;
				}
			}
			$this->data['main_content'] = 'admin/login';
			$this->data['title']="Admin Login";
			$this->data['hide_menu'] = true;
			$this->load->view('includes/template', $this->data);
		}
	}
	function dashboard() 
	{
		header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');
		if($this->session->userdata('is_logged_in'))
		{
			sub_admin_permission_check();
			$this->load->helper('thumb_helper');
			$data['title'] = "Dashboard";
			$data['main_content'] = 'admin/dashboard';
			$data['advertisment_comments'] = $this->Users_model->today_statistics('advertisment_comments');
			
			############ Total Advertisments ############
			$data['total_advertisements'] = $this->Users_model->yellowpages_statistics();
			$data['total_advertisements_active'] = $this->Users_model->yellowpages_statistics('active');
			$data['total_advertisements_inactive'] = $data['total_advertisements'] - $data['total_advertisements_active'];
			
			$data['today_advertisements'] = $this->Users_model->yellowpages_statistics('today');
			$data['today_advertisements_active'] = $this->Users_model->yellowpages_statistics('today_active');
			$data['today_advertisements_inactive'] = $data['today_advertisements'] - $data['today_advertisements_active'];
			
			############### Users  Statics ################
			$data['total_users']=$this->Users_model->user_statistics('all');
			$data['total_active_users']=$this->Users_model->user_statistics('active');
			$data['total_inactive_users']=$data['total_users'] - $data['total_active_users'];
			$data['today_logins'] = $this->Users_model->user_statistics('signin','user_logins');
			$data['today_signups'] = $this->Users_model->user_statistics('signup');
			$data['today_google_signups'] = $this->Users_model->user_statistics('google');
			$data['today_twitter_signups'] = $this->Users_model->user_statistics('twitter');
			$data['today_facebook_signups'] = $this->Users_model->user_statistics('facebook');
			
			$data['today_total_contacts'] = $this->Users_model->today_statistics('contact_us');
			$data['today_total_enquiry'] = $this->Users_model->today_statistics('advertisment_enquiry_list');
			$data['today_total_claims'] = $this->Users_model->today_statistics('claim_my_bussiness');
			$data['today_total_keyword_enquiry'] = $this->Users_model->today_statistics('keyword_enquiry');
			$this->load->view('includes/template', $data);  
		} else {
			redirect(ADMIN.'/login');
		}
	}
	
	public function calendar_events(){
		if($this->session->userdata('is_logged_in')){
			$start = date('Y-m-d',strtotime(date('d-m-Y',$_GET['start'])."+1 days"));
			$end = date('Y-m-d',strtotime(date('d-m-Y',$_GET['end'])));
			$data['calender_events'] = $this->Users_model->get_calander_events($start,$end);
			echo json_encode($data['calender_events']);
			die;
		} else {
			redirect(ADMIN.'/login');
		}
	}
	public function add_events(){
		if($this->session->userdata('is_logged_in')){
			//$start = date('Y-m-d',strtotime($_POST['start_date']."+1 days"));
			//$end = date('Y-m-d',strtotime($_POST['end_date']."+1 days"));
			$add = $this->Users_model->add_events();
			if($add){
				echo json_encode(array('msg'=>'success','id'=>$add));
			} else {
				echo json_encode(array('msg'=>'failure'));
			}
		} else {
			redirect(ADMIN.'/login');
		}
	}
	public function edit_events($id){
		$edit = $this->Users_model->edit_events($id);
		if($edit){
			echo json_encode($edit);
		} else {
			echo json_encode(array('msg'=>'failure'));
		}
	}
	function other_change_password() {
		if($this->session->userdata('is_logged_in')){
			$pageredirect=$this->input->get('pagemode');
			$pageno=$this->input->get('modestatus');
			$fieldsorts = $this->input->get('sortingfied');
			$typesorts = $this->input->get('sortype');
			$user_id=$this->uri->segment(4);//echo $user_id;exit;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->load->library('template');
				$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[32]|password_check');
				$this->form_validation->set_rules('password2','Confirm Password','trim|required|min_length[6]|max_length[32]|matches[password]');
				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>'); 
				if ($this->form_validation->run()) {
					if($this->Users_model->change_password($user_id, md5($this->input->post('password2')))==true){
						$getValues = $this->Users_model->get_users_profile($this->uri->segment(2),$user_id);
						$data = array(
							'user_name'  => $getValues->name,
							'user_email' => $getValues->email,
							'password'	 => $this->input->post('password')	
						);			
						if ($this->common_model->SendEmail($this->input->post('email'), $this->site_name.' - Password Changed', $data, 'admin_change_users_password')) {
							$this->session->set_flashdata('flash_message', $this->lang->line('user-suc-pwd'));
						} else {
							$this->session->set_flashdata('flash_message', $this->lang->line('user_error'));
						}
						redirect(ADMIN.'/'.$this->uri->segment(2).'/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
					} else {
						$this->session->set_flashdata('flash_message', $this->lang->line('unsuc-pwd'));
						if(!$this->uri->segment(4)){
							redirect(ADMIN.'/change_password');
						}else{
							
							redirect(ADMIN.'/'.$this->uri->segment(2).'/change_password/'.$this->uri->segment(4));
						}
						
					}
				}
			}
			$this->data['main_content'] = 'admin/user_change_pwd';
			$this->data['title']="Change Password";
			$this->load->view('includes/template', $this->data); 
		} else {
			redirect(ADMIN.'/login');
		}
	}
	
	function change_password() {
		if($this->session->userdata('is_logged_in')){
			$user_id=$this->uri->segment(4);//echo $user_id;exit;
			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				$this->form_validation->set_rules('old_password', 'Old password', 'trim|required|min_length[6]|max_length[32]');
				$this->form_validation->set_rules('password','New Password','trim|required|min_length[6]|max_length[32]|password_check');
				$this->form_validation->set_rules('password2','Confirm Password','trim|required|min_length[6]|max_length[32]|matches[password]');
				$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>'); 
				if ($this->form_validation->run()) {//echo "---	".$this->uri->segment(4).$user_id;exit;
					if($this->Users_model->check_password($user_id) == true){
						if($this->Users_model->change_password($user_id, md5($this->input->post('password2')))==true){
							$this->session->set_flashdata('flash_message', $this->lang->line('suc-pwd'));
						if(!$this->uri->segment(4)){
							redirect(ADMIN.'/change_password');
						}else{						
							redirect(ADMIN.'/'.$this->uri->segment(2));
						}
						}else{
							$this->session->set_flashdata('flash_message', $this->lang->line('unsuc-pwd'));
							if(!$this->uri->segment(4)){
								redirect(ADMIN.'/change_password');
							}else{
								
								redirect(ADMIN.'/'.$this->uri->segment(2).'/change_password/'.$this->uri->segment(4));
							}
							
						}
					}else{
						$this->session->set_flashdata('flash_message', $this->lang->line('unsuc-oldpwd'));
							if(!$this->uri->segment(4)){
								redirect(ADMIN.'/change_password');
							}else{
								
								redirect(ADMIN.'/'.$this->uri->segment(2).'/change_password/'.$this->uri->segment(4));
							}
					}
						
				}
			}
		$this->data['main_content'] = 'admin/changepwd';
		$this->data['title']="Change Password";
		$this->load->view('includes/template', $this->data); 
		} else {
			redirect(ADMIN.'/login');
		}
	}
	public function oldpassword_check(){
		$checkPass= $this->Users_model->check_password();
		if (!$checkPass ){
		  $this->form_validation->set_message('oldpassword_check','Incorrect Old Password');
		  return FALSE;
		}
		return TRUE;
		 
	}
	
	public function edit_profile() {
		if($this->session->userdata('is_logged_in')){
			sub_admin_permission_check();
			$this->data['user'] = $this->Users_model->get_profile();
			$this->data['users'] = $this->Users_model->get_email();
			if ($this->input->server('REQUEST_METHOD') === 'POST') {
				$user_id=$this->uri->segment(4);
					if(trim($this->input->post('email')) != $this->data['users']['email']) {
						$is_unique =  '|is_unique[users.email]' ;
					} else {
						$is_unique =  '' ;
					}
				$this->form_validation->set_rules('first_name', 'First Name', 'required');
				$this->form_validation->set_rules('email', 'Email ID', 'required|max_length[250]|valid_email'.$is_unique);
				//$this->form_validation->set_message('is_unique', $this->lang->line('unique')); 
				$old_password = $_POST['old_password'];
				$new_password = $_POST['password'];
				$confirm_password = $_POST['password2'];
				if($old_password !='' || $new_password !='' || $confirm_password!='') {
					$this->form_validation->set_rules('old_password', 'Old password', 'trim|required|min_length[6]|max_length[32]|callback_oldpassword_check');
					$this->form_validation->set_rules('password','New Password','trim|required|min_length[6]|max_length[32]|password_check');
					$this->form_validation->set_rules('password2','Confirm Password','trim|required|min_length[6]|max_length[32]|matches[password]');
				}
				if ($this->form_validation->run()) { 
					$date = date('Y-m-d h:i:s');
					 $data_to_store = array(
						'modified' => $date,
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'display_name' => $this->input->post('display_name'),
					);
					$data_to_update = array(
						'modified' => $date,
						'email' => $this->input->post('email')
					);
					if($new_password){
						$change_new_password = array('password'=> $this->__encrip_password($new_password));
						$data_to_update = array_merge($data_to_update ,$change_new_password);
					}
					if($this->Users_model->update_profile($data_to_store) == TRUE && $this->Users_model->update_email($data_to_update) == TRUE ){
						$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));			
					}else{
						$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));			
					}
					redirect(ADMIN.'/edit_profile');
				} 
			}
			$this->data['main_content'] = 'admin/edit-profile';
			$this->data['title']="Edit Profile";
			$this->load->view('includes/template', $this->data);  
		}  else {
			redirect(ADMIN.'/login');
		}
	}
	
    function __encrip_password($password) {
		return md5($password);
    }	
	//forgot_password,reset_password
	function forgotpassword_form() {
		if($this->session->userdata('is_logged_in')){
			redirect(ADMIN.'/dashboard');
		} else {
			$this->form_validation->set_rules('email_address', 'Email','trim|required|valid_email');
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">
					<a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			if($this->form_validation->run() == FALSE) {
				$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));	
			} else {
				$uid=rand();
				if($this->Users_model->check_user_available($this->input->post('email_address'),$uid)){
					$this->load->library('template');
					$username=$this->hotel_user_model->getUsername($this->input->post('email_address'));
                                                $user_name=$username['display_name'];
					$data = array(
						'user_email' => $this->input->post('email_address'),
						'admin_resetpassword_url'  => $this->config->item('admin_resetpassword_url').$uid,
						'username'=>$user_name
					);
					if ($this->common_model->SendEmail($this->input->post('email'), $this->site_name.' - Forgot Password', $data, 'admin_forgot_password')) {
						$this->session->set_flashdata('flash_message', $this->lang->line('mail_suc'));
						redirect(ADMIN.'/forgotpassword');
					} else {
						$this->session->set_flashdata('flash_message', $this->lang->line('mail_failure'));
						redirect(ADMIN.'/forgotpassword');
					}
				}else{	
					$this->session->set_flashdata('flash_message', $this->lang->line('email_not_exist'));
					redirect(ADMIN.'/forgotpassword');
				}
			}
			$this->data['main_content'] = 'admin/forgot_password';
			$this->data['title']="Admin Forgot Password";
			$this->data['hide_menu'] = true;
			$this->load->view('includes/template', $this->data);
		}
	}
	function resetpassword($slug) {
		if($this->session->userdata('is_logged_in')){
			redirect(ADMIN.'/dashboard');
		} else {
			if($this->Users_model->check_user_uid($slug)){
				$data['form_type']=2;
				$data['UID']=$slug;
				$data['title']="Admin Reset Password";
				$data['main_content'] = 'admin/reset_password';
				$data['hide_menu'] = true;
				$this->load->view('includes/template',$data);	
		
			}else{
				$this->session->set_flashdata('flash_message', $this->lang->line('session_expires'));
				redirect(ADMIN.'/forgotpassword');
				//$this->forgotpassword_form();
			}
		}
	}
	//End forgot_password,reset_password
	
	
	function signup() {
		$this->load->view('admin/signup_form');	
	}
	function settings() {
		if($this->session->userdata('is_logged_in')){
			sub_admin_permission_check();
			$this->breadcrumbs->push('Dashboard', base_url().ADMIN.'/dashboard');
			$this->breadcrumbs->push('Admin Settings', base_url().ADMIN.'/settings');
			
			$this->form_validation->set_rules('site_name', 'Site Name','trim|required');
			$this->form_validation->set_rules('fields[email_address]', 'Email','trim|required|valid_email');
			$this->form_validation->set_rules('fields[contact]', 'Contact No','trim|required|numeric|max_length[14]|greater');
			$this->form_validation->set_rules('fields[back_pagination]', 'Backend Paging','trim|required|numeric|greater_than[0]|max_length[2]');
			$this->form_validation->set_rules('fields[front_pagination]', 'Frontend Paging','trim|required|numeric|greater_than[0]|max_length[2]');
			$this->form_validation->set_rules('fields[paypal_email]', 'Paypal Email','trim|required|valid_email');
			
			if (isset($_POST) && !empty($_POST))
			{
				if ($this->form_validation->run() === true)
				{
					$data['setting_fields'] = serialize($this->input->post('fields'));	
					$data['sitename']=	$this->input->post('site_name');
					if($this->Users_model->update_settings($data)){			
						$this->session->set_flashdata('flash_message', 'updated');
						$this->session->set_flashdata('settings_data', $data);
						redirect(ADMIN.'/settings');
					} else 
					{
						$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
						redirect(ADMIN.'/settings');
					}
				} else 
				{
					$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			
			$data['title'] = "General Settings";
			$data['main_content'] = 'admin/settings';
			$data['hide_footer'] = true;
			$data['data']=$this->Users_model->get_settings();
			$this->load->view('includes/template', $data);  
		} else {
			redirect(ADMIN.'/login');
		}
	}
	function settings_update() {
		$data['setting_fields'] = serialize($this->input->post('fields'));	
		$data['sitename']=	$this->input->post('site_name');
		if($this->Users_model->update_settings($data)){			
			$this->session->set_flashdata('flash_message', 'updated');
			$this->session->set_flashdata('settings_data', $data);
		}else{

		}	
		redirect(ADMIN.'/settings');
	}
	function updatepassword() { 
		$this->form_validation->set_rules('password', 'Password','trim|required|min_length[6]|max_length[32]|password_check');
		$this->form_validation->set_rules('password2', 'Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
		if($this->form_validation->run() == FALSE) {
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['password'] = array(
				'name'  	=> 'password',
				'id'    	=> 'password',
				'type'  	=> 'text',
				'style'		=> 'width:300px;',
				'value' 	=> $this->form_validation->set_value('password'),
			);	
			//redirect('admin/login');
			
			$this->data['form_type']=2;
			$this->data['title']="Admin Reset Password";
			$this->data['main_content'] = 'admin/reset_password';
			$this->data['UID'] = $this->input->post('uid');
			$this->data['hide_menu'] = true;
			$this->load->view('includes/template',$this->data);	
		}		
		else {	
			if($query = $this->Users_model->update_pwrd())
			{
				//$this->load->view('admin/login');	
				$data['main_content'] = 'admin/login';
				$data['title']="Admin Login";
				$data['hide_menu'] = true;
				$this->session->set_flashdata('flash_message', 'pwrd_updated');
				//$this->load->view('includes/template', $data);			
				redirect(ADMIN.'/login');
			}
			else
			{
				/*echo '<div class="alert alert-error"><a class="close" 
				data-dismiss="alert">×</a><strong>';
	  			echo "Your session has been expired ! Enter email to 
					reset your password !";	
				echo '</strong></div>';	*/
				$this->session->set_flashdata('flash_message', $this->lang->line('session_expires'));
				$this->load->view('admin/login');			
			}
		}
	}
	function create_member() {
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 
				'trim|required|	valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 
				'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Confirm Password', 
				'trim|required|matches[password]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('admin/signup_form');
		}		
		else
		{			
			$this->load->model('Users_model');
	
			if($query = $this->Users_model->create_member())
			{
				$this->load->view('admin/signup_successful');			
			}
			else
			{
				$this->load->view('admin/signup_form');			
			}
		}
		
	}
	
	function logout() {
		$this->session->sess_destroy();
		redirect(ADMIN);
	}
}
