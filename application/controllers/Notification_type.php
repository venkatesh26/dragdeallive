<?php
class Notification_type extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('notification_type_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
				$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }

    public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		$this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'notificationtype.name','created' =>'notificationtype.created');
		$config['base_url'] = base_url().ADMIN.'/notificationtype/index';
		$data['indextitle']  = 'Notification Types List';
		$data['type'] = 'index';
		
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
			$value = '( notificationtype.name Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 //fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['notificationtype'] = $this->notification_type_model->get_notifications_type( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);  
		$config['total_rows'] =$this->notification_type_model->get_notifications_type( 0 , $conditions, '', '', '', '');   
		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/notificationtype/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
				
		$data['main_content'] = 'admin/notificationtype/index';
		$data['title']="Notification Types";
		$this->load->view('includes/template', $data);
    }

    public function add() {
		$this->breadcrumbs->push('Notification Type', base_url().ADMIN.'/notification_type');  
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/notification_type/add');
		$this->form_validation->set_rules('code', 'Code','trim|required|is_unique[notification_type.code]');
		$this->form_validation->set_rules('name', 'Name','trim|required');
		$this->form_validation->set_rules('template_title', 'Title','trim|required');
		$this->form_validation->set_rules('template', 'Message','trim|required');
		if ($this->form_validation->run() == true) 
		{
			$success = $this->notification_type_model->add_new();
			if($success==true) {
				$this->session->set_flashdata('flash_message', $this->lang->line('record_add'));
			} else {
				$this->session->set_flashdata('flash_message', "error");
			}
			redirect(base_url().ADMIN.'/notificationtype'); 
			
		} 
		else 
		{
		$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		$this->data['main_content'] = 'admin/notificationtype/add';
		$this->data['title']="Add Notification";
		$this->load->view('includes/template', $this->data);
		}
		
    } 

    public function edit($id) {
		$getValues = $this->notification_type_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Notification Type', base_url().ADMIN.'/notificationtype');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/notificationtype/edit');
			
			if (isset($_POST) && !empty($_POST))
			{
				if(trim($this->input->post('code')) != $getValues['code']) {
					$is_unique =  '|is_unique[notification_type.code]' ;
				} else {
					$is_unique =  '' ;
				}
				$this->form_validation->set_rules('code', 'Code','trim|required'.$is_unique);
				$this->form_validation->set_rules('name', 'Name','trim|required');
				$this->form_validation->set_rules('template_title', 'Title','trim|required');
				$this->form_validation->set_rules('template', 'Message','trim|required');
				
				if ($this->form_validation->run() === true)
				{	
					$this->notification_type_model->edit($id);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/notificationtype/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}			
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['notification_type'] = $getValues;
			$this->data['main_content'] = 'admin/notificationtype/edit';
			$this->data['title']="Edit Notification Type";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/notificationtype/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
    }
	
	function update_status($id, $status, $pageredirect=null,$pageno){ 
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($status == 'enable'){
			$data = array('is_active' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		} else if($status == 'disable'){
			$data = array('is_active' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		} 
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/categories/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->category_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/categories/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function update_popular_status($id, $status, $pageredirect=null,$pageno){ 
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($status == 'enable'){
			$data = array('is_popular' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		} else if($status == 'disable'){
			$data = array('is_popular' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		} 
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/categories/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->category_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/categories/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->category_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->category_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/notificationtype/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/notificationtype/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->category_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/notificationtype/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
?>