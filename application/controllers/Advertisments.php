<?php
class Advertisments extends CI_Controller {

    ######### Advertisments Model ##########
    public function __construct() {
        parent::__construct();
		$this->load->model('advertisment_model');
		$this->load->model('countries_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
    }
	
	################ Send Email ######################
	
	public function send_add_email($id){
		
		$getValues = $this->advertisment_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) 
		{
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Advertisments', base_url().ADMIN.'/advertisments');
			$this->breadcrumbs->push('Send Mail', base_url().ADMIN.'/advertisments/sen_mail');
			if (isset($_POST) && !empty($_POST) && !empty($_POST['subject'])  && !empty($_POST['message']))
			{
				$email=$getValues['email'];
				$username=$getValues['owner'];
				$subject=$_POST['subject'];
				$message=$_POST['message'];
				$data=array('user_name'=>$username,'email'=>$email,'message'=>$message);
				$this->load->library('template');
				$email_body = $this->template->load('mail_template/template', 'mail_template/admin_add_email', $data,TRUE);
				$this->email->from(admin_settings_initialize('email'), admin_settings_initialize('sitename'));
				$this->email->to($email);
				$this->email->subject('Dragdeal -'.$subject);
				$this->email->message($email_body);
				if ($this->email->send()) {
					$this->session->set_flashdata('flash_message','<span class="alert alert-success" style="float:left"><button class="close" data-dismiss="alert">×</button>Mail Send Successfully</span>');
				} else {
				 $this->session->set_flashdata('flash_message','<span class="alert alert-error" style="float:left"><button class="close" data-dismiss="alert">×</button>Mail send Error!</span>');
				}
						redirect(base_url().ADMIN.'/advertisments/');
			}
			$this->data['main_content'] = 'admin/advertisments/send_email';
			$this->data['title']="Send Mail";
			$this->data['id']=$getValues['id'];
			$this->load->view('includes/template', $this->data);
		}
		else {
			
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	########### Send Profile Mail #########
	public function send_profile_complete_mail($id) {
		$getValues = $this->advertisment_model->get_advertisment_detail($id);
		$user_profile_info = user_profile_info($getValues['user_id']);
		$email=$user_profile_info['email'];
		$username=$user_profile_info['name'];
		$bussiness_name=$getValues['name'].", ".$getValues['city_name'];
		$data=array('user_name'=>$username,'email'=>$email, 'token'=>$id, 'bussiness_name'=>$bussiness_name);
		$this->load->library('template');
		$email_body = $this->template->load('mail_template/one_time_profile_activation', 'mail_template/one_time_profile_activation', $data,TRUE);
		$this->load->model('cron_model');
		$this->cron_model->sendEmail($email, "Wow ! Almost Done Just One More Step To Activate Your Profile", "",$email_body, $email, "Dragdeal");
		$this->session->set_flashdata('flash_message','<span class="alert alert-success" style="float:left"><button class="close" data-dismiss="alert">×</button>Mail Send Successfully</span>');
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	############### Admin Index ###############
	public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'advertisements.name','created' =>'advertisements.created','name' =>'advertisements.name','owner_name' =>'advertisements.owner','address'=>'address_line','city_name'=>'cities.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'advertisements.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/advertisements/active';
			$data['indextitle']  = 'Advertisements - Active List';
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'advertisements.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/advertisements/inactive';
			$data['indextitle']  = 'Advertisements - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/advertisments/index';
			$data['indextitle']  = 'Advertisements List';
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
		$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(advertisements.name LIKE '%" . $data['keyword'] . "%'", 'value'=> null);
		$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "advertisements.owner LIKE '%" . $data['keyword'] . "%'", 'value' => null);
        $conditions[] = array( 'direct'=>0,  'rule' => 'or_where', 'field' => "advertisements.email like '%" . $data['keyword'] . "%')", 'value'=> null); 	
		 }
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';	
		$new_data = $this->advertisment_model->get_advertisments( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end); 
		$data['comments']=$new_data['list'];		
		$config['total_rows'] =$new_data['total']; 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/advertisments/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/advertisments/index';
		$data['title']="Advertisement";
		$this->load->view('includes/template', $data);
	}
	
	############## Update Status #############
	public function update_status($id, $status, $pageredirect=null,$pageno) { 
	
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
			redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->advertisment_model->update_status($id, $data);

		redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	############## Bulk Action #############
	public function bulkautions($pageredirect=null,$pageno) {
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->advertisment_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled'));
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->advertisment_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	########### Advertisement View ##############
	public function  view($id) {
	    $getValues = $this->advertisment_model->get_advertisment_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$gallery=array();
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			// add breadcrumbs
			$this->breadcrumbs->push('Advertisments', base_url().ADMIN.'/advertisments');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/advertisment_view/view');
			$this->data['advertisments'] = $getValues;	
			$this->data['gallery'] = $gallery;	
			$this->data['main_content'] = 'admin/advertisments/view';
			$this->data['title']="View Advertisement Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	########### Advertisement Delete #############
	function delete($id) {
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$this->db->delete('advertisements',array('id' => $id));
	
		$this->db->where('advertisment_id', $id);
		$this->db->delete('advertisment_comments'); 

		$this->db->where('advertisment_id', $id);
		$this->db->delete('advertisment_comments'); 

		$this->db->where('advertisment_id', $id);
		$this->db->delete('advertisment_images'); 

		$this->db->where('advertisment_id', $id);
		$this->db->delete('advertisment_phones'); 

		$this->db->where('advertisment_id', $id);
		$this->db->delete('advertisment_views'); 
		
		$this->db->where('advertisment_id', $id);
		$this->db->delete('advertisment_enquiry_list'); 

		$this->db->where('listing_id', $id);
		$this->db->delete('category_listing'); 

	     $this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
    ############# Advertisement Edit ##########
	public function edit($id) {
		$getValues = $this->advertisment_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Advertisments', base_url().ADMIN.'/categories');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/categories/edit');
			if (isset($_POST) && !empty($_POST)){
				if($_POST['step']==1):
					$this->form_validation->set_rules('name','Business Name','trim|required');
					$this->form_validation->set_rules('owner','Contact Person','trim|required');
					$this->form_validation->set_rules('address_line','Address Line','trim|required');
					$this->form_validation->set_rules('zip','Zip','trim|required');
					$this->form_validation->set_rules('contact_number','Contact Number','trim|required');
					$this->form_validation->set_rules('email',ucwords($this->lang->line('Email')),'trim|valid_email');
				elseif($_POST['step']==2):
					$this->form_validation->set_rules('step','Step','trim|required');
				else:
					$this->form_validation->set_rules('step','Step','trim|required');
				endif;
				if ($this->form_validation->run() === true) {	
					$this->advertisment_model->edit($id);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}				
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['advertisments'] = $getValues;
			$this->data['user_business_data'] = $getValues;
			
			$this->data['countries']= $this->countries_model->get_countries();
			$this->data['is_active']=$getValues['is_active'] ? 1 : 0 ; 
			$this->data['advertimentsId']=$id;
			
			$this->data['main_content'] = 'admin/advertisments/edit';
			$this->data['title']="Edit Advertisments";
			$this->load->view('includes/template', $this->data);
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/advertisments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
    }
}