<?php
class Subadmin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('web_user_model');
		$this->load->model('countries_model');
		
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
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
			$config['base_url'] = base_url().ADMIN.'/subadmin/active';
			$data['indextitle']  = 'Subadmin - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/subadmin/inactive';
			$data['indextitle']  = 'Subadmin - Inactive List';
			$data['type'] = 'inactive';
		} else {	
			$config['base_url'] = base_url().ADMIN.'/subadmin/index';
			$data['indextitle']  = 'Subadmin List';
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
		 
		 $data['keyword'] = $this->input->post('keyword');//for Normal search
		 $data['email'] = $this->input->post('email');
		 $data['name'] = $this->input->post('name');
		 $data['filter'] = $this->input->post('filter');//plan type
		 $data['checkin'] = $this->input->post('checkin');//register from
		 $data['checkout'] = $this->input->post('checkout');//register upto
		 
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
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword'], 'email'=>$data['email'] , 'filter'=>$data['filter'], 'name'=>$data['name'], 'checkin'=>$data['checkin'], 'checkout'=>$data['checkout']));
		if($data['keyword'] || $data['filter'] || $data['email'] || $data['name'] || $data['checkin'] || $data['checkout']  ){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'email'=>$data['email'], 'name'=>$data['name'], 'filter'=>$data['filter'],  'checkin'=>$data['checkin'], 'checkout'=>$data['checkout']));
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
					$data['checkin'] = $this->session->userdata['search']['checkin'];
					$data['checkout'] = $this->session->userdata['search']['checkout'];
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'email'=>$data['email'], 'name'=>$data['name'], 'filter'=>$data['filter'],  'checkin'=>$data['checkin'], 'checkout'=>$data['checkout']));
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/
		$data_filters=array();
		$data_datas=array();
		 if($data['keyword']  )
		 {
			$value = '( users.email Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
			 $data_filters=array_merge($data_filters,aray('Keyword'));
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
					$data['excel'] = $this->web_user_model->get_sub_admin_users(1 , $conditions, $sort_f, $order,'100000',0,'1');    
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
		$data['users'] = $this->web_user_model->get_sub_admin_users(1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->web_user_model->get_sub_admin_users( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/subadmin/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		
		$data['main_content'] = 'admin/subadmin/index';
		$data['title']="Subadmin";
		$this->load->view('includes/template', $data);
    }
	public function formValidate($edit_flag= false){
		$this->form_validation->set_rules('first_name', 'Name','trim|required');
		if(!$edit_flag){
			$this->form_validation->set_rules('password', 'Password', 'trim|required|password_check');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');
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
		$this->breadcrumbs->push('Subadmin', base_url().ADMIN.'/subadmin');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/subadmin/add');
		if ($this->formValidate()=="true"){
			//$config['upload_path']   =   $this->config->item('profile_url');
			//$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
			//$this->load->library( 'upload' ,  $config);
			//$image_up = $this->upload->do_upload('image');
			//$image_data =  array('upload_data' => $this->upload->data());
		
			//$this->load->helper('string');
			//$email_activation_id = random_string('alnum', 10);
			
			$success = $this->web_user_model->subadmin_add();
		if($success) {
			$this->load->library('template');
			$data = array(
				'user_name'  => $this->input->post('first_name'),
				'user_email' => $this->input->post('email'),
				'password'	 => $this->input->post('password'),
				//'verifylink' => $email_activation_id
			);
			$email_body = $this->template->load('mail_template/template', 'mail_template/admin_register_subadmin', $data,TRUE);
			$this->email->from(admin_settings_initialize('email'), admin_settings_initialize('sitename'));
			$this->email->to($this->input->post('email'));
			$this->email->subject('Sub Administrator Registration');
			$this->email->message($email_body);
			if ($this->email->send()) {
					$this->session->set_flashdata('flash_message', $this->lang->line('user_add'));
				} else {
					$this->session->set_flashdata('flash_message', $this->lang->line('user_error'));
				}
			redirect(base_url().ADMIN.'/subadmin');
			
		} else {
			$this->session->set_flashdata('flash_message', "user_error");
		}
			redirect(base_url().ADMIN.'/subadmin'); 
		} else {
		$this->data['countries']= $this->countries_model->get_countries();
		$this->data['main_content'] = 'admin/subadmin/add';
		$this->data['title']="Add Subadmin";
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
				$this->breadcrumbs->push('Subadmin', base_url().ADMIN.'/subadmin');
				$this->breadcrumbs->push('View', base_url().ADMIN.'/subadmin/view');
				$this->data['users'] = $getValues;
				//print_r($this->data['auction_images']);die;
				//End auctions forgien key datas			
				$this->data['main_content'] = 'admin/subadmin/view';
				$this->data['title']="View User Details";
				$this->load->view('includes/template', $this->data);
			} else {
				$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
		$this->breadcrumbs->push('Subadmin', base_url().ADMIN.'/subadmin');
		$this->breadcrumbs->push('Edit', base_url().ADMIN.'/subadmin/edit');
			
			if (isset($_POST) && !empty($_POST)) {
				if($this->formValidate(true)=="true") {
				
				$this->web_user_model->update_subadmin($id);
                                $this->web_user_model->update_subadmin_status($id,$this->input->post('is_active'));
				$this->session->set_flashdata('flash_message',$this->lang->line('record_update'));
				redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}			
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['web_users'] = $getValues;
			$this->data['countries']= $this->countries_model->get_countries();
			$this->data['main_content'] = 'admin/subadmin/add';
			$this->data['title']="Edit users";
			$this->data['indextitle']="Edit";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));					
			redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}

    }

	function update_status($id, $status, $pageredirect=null,$pageno){ 
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
			redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->web_user_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkautions($pageredirect=null,$pageno){
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
			redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}

	function update_approve_status($id, $status, $pageredirect=null,$pageno){ 
		if($status == 'approve'){
			$data = array('is_approved' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		}
		else{
			$data = array('is_approved' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		}
		$this->web_user_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/subadmin/'.$pageredirect.'/'.$pageno);
	}
   
}
?>
