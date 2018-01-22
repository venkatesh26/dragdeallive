<?php
class Main_categories extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('main_category_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
    }

    public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		$this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		//pagination settings
		$cofig =array();
		$config = admin_settings_initialize('settings');
		//sortings
		$this->sorting = array('name' =>'main_category.name','created' =>'main_category.created');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'main_category.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/main_category/active';
			$data['indextitle']  = 'Main Category - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'main_category.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/main_category/inactive';
			$data['indextitle']  = 'Main Category - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'main_category.is_active !=', 'value' => 2 );	
			$config['base_url'] = base_url().ADMIN.'/main_category/index';
			$data['indextitle']  = 'Main Category List';
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
			$value = '( main_category.name Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 //fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['categories'] = $this->main_category_model->get_main_category( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->main_category_model->get_main_category( 0 , $conditions, '', '', '', '');   
		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/main_category/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
				
		$data['main_content'] = 'admin/main_category/index';
		$data['title']="Main Category";
		$this->load->view('includes/template', $data);
    }

    public function add() 
	{
		$this->breadcrumbs->push('Main Category', base_url().ADMIN.'/main_category');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/main_category/add');
		$this->form_validation->set_rules('name', 'Name','trim|required|is_unique[main_category.name]');
		if ($this->form_validation->run() == true) 
		{
			$success = $this->main_category_model->add_new();
			if($success==true) {
				$this->session->set_flashdata('flash_message', $this->lang->line('record_add'));
			} else {
				$this->session->set_flashdata('flash_message', "error");
			}
			redirect(base_url().ADMIN.'/main_category'); 
			
		} 
		else 
		{
		$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		$this->data['main_content'] = 'admin/main_category/add';
		$this->data['title']="Add Main Category";
		$this->load->view('includes/template', $this->data);
		}
		
    } 

    public function edit($id) {
		$getValues = $this->main_category_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Main Category', base_url().ADMIN.'/main_category');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/main_category/edit');
			
			if (isset($_POST) && !empty($_POST))
			{
				if(trim($this->input->post('name')) != $getValues['name']) {
					$is_unique =  '|is_unique[main_category.name]' ;
				} else {
					$is_unique =  '' ;
				}
				$this->form_validation->set_rules('name', 'Name','trim|required'.$is_unique);
				if ($this->form_validation->run() === true)
				{	
					$this->main_category_model->edit($id);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}			
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['categories'] = $getValues;
			$this->data['is_active']=$getValues['is_active'] ? 1 : 0 ; 
			$this->data['main_content'] = 'admin/main_category/edit';
			$this->data['title']="Edit Main Category";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
		else if($status == 'new-request'){
			$data = array('is_active' => '1');
			if(!empty($_GET) && !empty($_GET['request_type']) && !empty($_GET['hotel_id']) && !empty($_GET['request_id']))
			{
			 $hotel_main_category=array('created'=>date('Y-m-d H:i:s'),'hotel_id'=>$_GET['hotel_id'],'amenity_id'=>$id,'is_active'=>1);
			  $this->db->insert('hotel_amenities', $hotel_main_category);
			  if($_GET['request_type']==1)
			  {
		       $offer_main_category=array('created'=>date('Y-m-d H:i:s'),'offer_id'=>$_GET['request_id'],'amenity_id'=>$id,'is_active'=>1);
			    $this->db->insert('offer_amenities', $offer_main_category);
			  }
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		}
		else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->main_category_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->main_category_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->main_category_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->main_category_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/main_category/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
    public function getCategory() {
		$data = $this->main_category_model->getmain_category();
		echo json_encode($data);
    }
}
?>