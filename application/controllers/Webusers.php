<?php
class Webusers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('web_user_model');
		$this->load->model('countries_model');
		
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
    }
	
	public function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->web_user_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}

    public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		$this->load->helper('date_helper');
		$conditions = array();
		$search_session = array();
		//pagination settings
		$cofig =array();
		$config = admin_settings_initialize('settings');
		//sortings
		$this->sorting = array('name' =>'user_profiles.first_name','created' =>'users.created','email' =>'users.email');
		if($type == 'active') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/users/active';
			$data['indextitle']  = 'Users - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/users/inactive';
			$data['indextitle']  = 'Users - Inactive List';
			$data['type'] = 'inactive';
		} else {	
			$config['base_url'] = base_url().ADMIN.'/users/index';
			$data['indextitle']  = 'Users List';
			$data['type'] = 'index';
		}
		/*****pagination ********/ 

		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;

		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$config['first_url'] = $config['base_url'].'/1/'.$sortfield.'/'.$order;
		 //search 
		 $data['keyword'] = '';//for Normal search
		 $data['email'] = '';
		 $data['name_hotel'] = '';
		 $data['filter'] = '';
		 $data['checkin'] = '';
		 $data['checkout'] = '';
		 
		 $data['user_reg_type'] = '';

		 
		 $data['keyword'] = $this->input->post('keyword');//for Normal search
		 $data['email'] = $this->input->post('email');
		 $data['name'] = $this->input->post('name');
		 $data['filter'] = $this->input->post('filter');//plan type
		 $data['checkin'] = $this->input->post('checkin');//register from
		 $data['checkout'] = $this->input->post('checkout');//register upto
		 $data['user_reg_type'] = $this->input->post('user_reg_type');
		 $data['submit-search'] =$this->input->post('submit-search');//Normal Search submit button
		 $data['submit-search-advance'] =$this->input->post('submit-advanced-search');//Advanced Search submit button
		 $data['excel_export'] =$this->input->post('excel_export');
		 //echo $data['submit-search'].'.No.'.$data['submit-search-advance'];die;
		 $data['advanced_search']=false;
		 //Search Start
		if((isset($_POST['submit-search']) || isset($_GET['keyword'])) &&
			($this->input->post('keyword') != '' || $this->input->get('keyword')))
		{
			$data['email']='';
			$data['name']='';
			$data['filter']='';
			$data['user_reg_type']='';
			$data['checkin']='';
			$data['checkout']='';
			$data['advanced_search'] = false;
		}
		if((isset($_POST['submit-search-advance'])) || $data['submit-search-advance'])
		{
			$data['keyword']='';
			$data['advanced_search'] = true;
		}
		if($data['excel_export'])
		 {
		        if(isset($this->session->userdata['search']['keyword']))
				$data['keyword'] = $this->session->userdata['search']['keyword'];
				if(isset($this->session->userdata['search']['name']))
				$data['name'] = $this->session->userdata['search']['name'];
				if(isset($this->session->userdata['search']['email']))
				$data['email'] = $this->session->userdata['search']['email'];
				if(isset($this->session->userdata['search']['filter']))
				$data['filter'] = $this->session->userdata['search']['filter'];
				if(isset($this->session->userdata['search']['user_reg_type']))
				$data['filter'] = $this->session->userdata['search']['user_reg_type'];
				if(isset($this->session->userdata['search']['checkin']))
				$data['checkin'] = $this->session->userdata['search']['checkin'];
				if(isset($this->session->userdata['search']['checkout']))
				$data['checkout'] = $this->session->userdata['search']['checkout'];
				$tab_type=$this->input->post('tab-type');
				if($tab_type == 'active') 
				{
					$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.is_active', 'value' => 1 );	
				}
				else if($tab_type == 'inactive') 
				{
					$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.is_active', 'value' => 0 );	
				}
				else
				{
				
				}
		 }
		//search Ending
		
		/*********** pagination search ********************/
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword'], 'email'=>$data['email'] , 'filter'=>$data['filter'],'user_reg_type'=>$data['user_reg_type'], 'name'=>$data['name'], 'checkin'=>$data['checkin'], 'checkout'=>$data['checkout']));
		if($data['keyword'] || $data['filter'] || $data['email'] || $data['name'] || $data['checkin'] || $data['checkout']  ){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'email'=>$data['email'], 'name'=>$data['name'],'user_reg_type'=>$data['user_reg_type'],'filter'=>$data['filter'],  'checkin'=>$data['checkin'], 'checkout'=>$data['checkout']));
		}
		else
		{ 
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['submit-search'] && $sortfield != 'reset'){ 
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
				}
			else if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['submit-search-advance'] && $sortfield != 'reset') {
					$data['name'] = $this->session->userdata['search']['name'];
					$data['email'] = $this->session->userdata['search']['email'];
					$data['filter'] = $this->session->userdata['search']['filter'];
					$data['user_reg_type']= $this->session->userdata['user_reg_type'];
					$data['checkin'] = $this->session->userdata['search']['checkin'];
					$data['checkout'] = $this->session->userdata['search']['checkout'];
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'email'=>$data['email'], 'name'=>$data['name'], 'filter'=>$data['filter'],'user_reg_type'=>$data['user_reg_type'],'checkin'=>$data['checkin'], 'checkout'=>$data['checkout']));
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/
		$data_filters=array();
		$data_datas=array();
		 if($data['keyword']  )
		 {
			$value = '( users.email Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value);	
			 $data_filters=array_merge($data_filters,array('Keyword'));
			 $data_datas=array_merge($data_datas,array($data['keyword']));
		 }	
		 if($data['filter'])
		 {
				$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field'=>'user_profiles.gender_id', 'value'=> $data['filter']  );	
				$data_filters=array_merge($data_filters,array('Gender'));
				$gen="Female";
				if($data['filter']==1)
				{
				$gen="Male";
				}
			    $data_datas=array_merge($data_datas,array($gen));
		 }
		 if($data['user_reg_type'])
		 {
				$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field'=>'users.register_type', 'value'=> $data['user_reg_type']  );	
				$data_filters=array_merge($data_filters,array('Gender'));
				$ty="Site";
				if($data['filter']==1)
				{
				$ty="Site";
				}
				if($data['filter']==2)
				{
				$ty="FaceBook";
				}
				if($data['filter']==3)
				{
				$ty="GooglePlus";
				}if($data['filter']==4)
				{
				$ty="Admin";
				}
			    $data_datas=array_merge($data_datas,array($ty));
		 }
		 if($data['name']  )
		 {
			$value = '( user_profiles.first_name Like "%'.$data['name'].'%" )'; //OR  user_profiles.last_name  Like "%'.$data['name'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );
             $data_filters=array_merge($data_filters,array('Customer Name'));
			 $data_datas=array_merge($data_datas,array($data['name']));			 
		 }
		 if($data['email']  )
		 {
			$value = '( users.email Like "%'.$data['email'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
			  $data_filters=array_merge($data_filters,array('Email'));
			 $data_datas=array_merge($data_datas,array($data['email']));
		 }
				 
		 if($data['checkin'] && $data['checkout'] )
		 {
			$value = '( users.created >= "'.$data['checkin'].'" AND users.created <= "'.$data['checkout'].'" )'; 
			$conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value);
			$data_filters=array_merge($data_filters,array('Check In'));
			$data_datas=array_merge($data_datas,array($data['checkin']));	
		    $data_filters=array_merge($data_filters,array('Check Out'));
			$data_datas=array_merge($data_datas,array($data['checkout']));	
		 }else if($data['checkin'])
		 {
			$value = '(date(users.created)  = "'.$data['checkin'].'" )'; 
			$conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );
		    $data_filters=array_merge($data_filters,array('Check In'));
			$data_datas=array_merge($data_datas,array($data['checkin']));			
		 }
		 else if($data['checkout']  )
		 {
			$value = '( users.created = "'.$data['checkout'].' ")';
			$conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
			$data_filters=array_merge($data_filters,array('Check Out'));
			$data_datas=array_merge($data_datas,array($data['checkout']));	
		 }
		 
		//fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
				if($data['excel_export'])
				{
					$headers= array('Created','Email','Gender','Mobile Number','Telephone Number',
					'Address','City','Status');
					$data['excel'] = $this->web_user_model->get_user_users(1 , $conditions, $sort_f, $order,'100000',0,'1');    
					$this->load->library('Excel');
					$report = array();
					if(!empty($data['excel'])){
							foreach ($data['excel'] as $key=>$excel)
							{
								$report[$key]['Created'] = $excel['created'];
								$report[$key]['Email'] = $excel['email'];
								if($excel['gender_id']==1)
								{
								$g="Male";
								}
								else if($excel['gender_id']==2)
								{
								$g="Female";
								}
								else
								{
								$g="";
								}
								$report[$key]['Gender'] = $g;
								$report[$key]['Mobile Number'] = $excel['mobile_number'];
								$report[$key]['Telephone Number'] = $excel['telephone_number'];
								$report[$key]['Address'] = $excel['telephone_number'];
								$report[$key]['City'] = $excel['city_name'];
								$s="In Active";
								if($excel['is_active']==1)
								{
								$s="Active";
								}
								$report[$key]['Status'] = $s;
								
							} 					
							$this->excel->export( $report,$headers,'user_list__'.date('Y-m-d h:i:s').'.xls', true,$data_filters,$data_datas);
					}
					
				}
				else
				{
						$data['excel_export'] = '';	
				}
		$data['users'] = $this->web_user_model->get_user_users(1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->web_user_model->get_user_users( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/users/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		
		$data['main_content'] = 'admin/web_users/index';
		$data['title']="Users";
		$this->load->view('includes/template', $data);
    }
	
	public function formValidate($edit_flag= false){
		$this->form_validation->set_rules('first_name', 'First Name','trim|required');
		if(!$edit_flag){
			$this->form_validation->set_rules('password', 'Password', 'trim|required|password_check');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[users.email]');
			$this->form_validation->set_rules('display_name', 'Display Name', 'required|min_length[5]|is_unique[users.display_name]');
			//$this->form_validation->set_rules('mob_no', 'Mobile number','trim|required|integer');
		}
		if ($this->form_validation->run() == true) {
			return "true";
		} else {
			return "false";
		}
	}
    
	public function add() {
		// add breadcrumbs
		$this->breadcrumbs->push('Users', base_url().ADMIN.'/users');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/users/add');
		if ($this->formValidate()=="true"){
		        $config['upload_path']   =   $this->config->item('profile_url');
			$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
			$this->load->library( 'upload' ,  $config);
			if(!$image_up = $this->upload->do_upload('image'))
                          {
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
				exit();
		          }
			$image_data =  array('upload_data' => $this->upload->data());
			$this->load->helper('string');
			$email_activation_id = random_string('alnum', 10);
			$success = $this->web_user_model->add( $image_data,$email_activation_id );
		if($success) {
			$this->load->library('template');
			$data = array(
				'user_name'  => $this->input->post('first_name'),
				'user_email' => $this->input->post('email'),
				'password'	 => $this->input->post('password'),
				'verifylink' => $email_activation_id
			);
			if ($this->common_model->SendEmail($this->input->post('email'), $this->site_name.' - User Registration', $data, 'admin_register_site_user')) {
					$this->session->set_flashdata('flash_message', $this->lang->line('user_add'));
				} else {
					$this->session->set_flashdata('flash_message', $this->lang->line('user_error'));
				}
			redirect(base_url().ADMIN.'/users');
			
		} else {
			$this->session->set_flashdata('flash_message', "user_error");
		}
			redirect(base_url().ADMIN.'/users'); 
		} else {
			$this->data['countries']= $this->countries_model->get_countries();
			$this->data['main_content'] = 'admin/web_users/add';
			$this->data['title']="Add Users";
			$this->data['indextitle']="New";
			$this->load->view('includes/template', $this->data);
		}
    } 
	
	public function view($id) {
			$getValues = $this->web_user_model->get_values($id);
			$pageredirect=$this->input->get('pagemode');
			$pageno=$this->input->get('modestatus');
			$fieldsorts = $this->input->get('sortingfied');
			$typesorts = $this->input->get('sortype');
			if(count($getValues)) {
				$this->load->helper('thumb_helper');
				// add breadcrumbs
				$this->breadcrumbs->push('Users', base_url().ADMIN.'/users');
				$this->breadcrumbs->push('View', base_url().ADMIN.'/users/view');
				$this->data['users'] = $getValues;
				//print_r($this->data['auction_images']);die;
				//End auctions forgien key datas			
				$this->data['main_content'] = 'admin/web_users/view';
				$this->data['title']="View User Details";
				$this->load->view('includes/template', $this->data);
			} else {
				$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
			}

    }
	
    public function edit($id) {	
		$getValues = $this->web_user_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
	
		if(count($getValues)) {
		$this->load->helper('thumb_helper');
			// add breadcrumbs
		$this->breadcrumbs->push('Users', base_url().ADMIN.'/users');
		$this->breadcrumbs->push('Edit', base_url().ADMIN.'/users/edit');
			
			if (isset($_POST) && !empty($_POST))
			{		
				if($this->formValidate(true)=="true")
				{
				 //echo $this->input->post('is_active');die;
				$config['upload_path']   =   $this->config->item('profile_url');
				$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
				$this->load->library( 'upload' ,  $config);
				$image_up = $this->upload->do_upload('image');
				$image_data =  array('upload_data' => $this->upload->data());
				
				$this->web_user_model->update($id,$image_data);
				$this->session->set_flashdata('flash_message', 
				$this->lang->line('record_update'));
							
				redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}			
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['web_users'] = $getValues;
			$this->data['countries']= $this->countries_model->get_countries();
			$this->data['main_content'] = 'admin/web_users/add';
			$this->data['title']="Edit users";
			$this->data['indextitle']="Edit";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));					
			redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}

    }

	public function update_status($id, $status, $pageredirect=null,$pageno){ 
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($status == 'enable'){
			$data = array('is_active' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		}
		else if($status == 'disable') {
			$data = array('is_active' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->web_user_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	public function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->web_user_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->web_user_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}

	public function update_approve_status($id, $status, $pageredirect=null,$pageno){ 
		if($status == 'approve'){
			$data = array('is_approved' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		}
		else{
			$data = array('is_approved' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		}
		$this->web_user_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno);
	}
	
	########## Resend Activation Mail #############
	public function resend_activation_mail($id) {
		$email_activation_id = random_string('alnum', 10);
		$getValues = $this->web_user_model->get_values($id);
		$data=array('uid'=>$email_activation_id);
		$this->web_user_model->update_status($id, $data);
		$this->load->library('template');
		$data = array(
			'user_name'  => $getValues['profile']['first_name'],
			'user_email' => $getValues['profile']['email'],
			'verifylink' => $email_activation_id
		);
		$this->common_model->SendEmail($getValues['profile']['email'], $this->site_name.' - Activation Link', $data, 'admin/resend_activation_link');
		$this->session->set_flashdata('flash_message', "Mail Send Successfully");
		redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno);
    }
   
    ################ Send Email ######################
	public function send_email($id) {
		$getValues = $this->web_user_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) 
		{
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Users', base_url().ADMIN.'/users');
			$this->breadcrumbs->push('Send Mail', base_url().ADMIN.'/Users/send_email');
			if (isset($_POST) && !empty($_POST) && !empty($_POST['subject'])  && !empty($_POST['message']))
			{
				$email=$getValues['profile']['email'];
				$username=$getValues['profile']['first_name'];
				$subject=$_POST['subject'];
				$message=$_POST['message'];
				$data=array('user_name'=>$username,'email'=>$email,'message'=>$message);
				if ($this->common_model->SendEmail($this->input->post('email'), $this->site_name.$subject, $data, 'admin/user_mail')) {
					$this->session->set_flashdata('flash_message','<span class="alert alert-success" style="float:left"><button class="close" data-dismiss="alert">×</button>Mail Send Successfully</span>');
				} else {
				 $this->session->set_flashdata('flash_message','<span class="alert alert-error" style="float:left"><button class="close" data-dismiss="alert">×</button>Mail send Error!</span>');
				}
						redirect(base_url().ADMIN.'/users/');
			}
			$this->data['main_content'] = 'admin/web_users/send_email';
			$this->data['title']="Send Mail";
			$this->data['id']=$id;
			$this->load->view('includes/template', $this->data);
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/users/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
   
}
?>