<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shorturls extends CI_Controller {

    #Construct Function
	public function __construct() {
        parent::__construct();
		if(!$this->session->userdata('is_user_logged_in')) {
			redirect(base_url().'/login');		
		}
		$this->load->model('shorten_url_model');
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
	}
	
	############# Settings ##############
	function settings() {
		if($this->session->userdata('is_user_logged_in')){
			$this->breadcrumbs->push('Dashboard', base_url().'/dashboard');
			$this->breadcrumbs->push('Admin Settings', base_url().'/settings');
			
			$this->form_validation->set_rules('site_name', 'Site Name','trim|required');
			$this->form_validation->set_rules('fields[email_address]', 'Email','trim|required|valid_email');
			$this->form_validation->set_rules('fields[contact]', 'Contact No','trim|required|numeric|max_length[14]|greater');
			$this->form_validation->set_rules('fields[back_pagination]', 'Backend Paging','trim|required|numeric|greater_than[0]|max_length[2]');
			$this->form_validation->set_rules('fields[front_pagination]', 'Frontend Paging','trim|required|numeric|greater_than[0]|max_length[2]');			
			if (isset($_POST) && !empty($_POST))
			{
				if ($this->form_validation->run() === true)
				{
					$data['setting_fields'] = serialize($this->input->post('fields'));	
					$data['sitename']=	$this->input->post('site_name');
					if($this->common_model->update_settings($data)){			
					$extra_array = array('status'=>'error','msg'=>'Settings Updated Successfully','data'=>$data);
						echo json_encode($extra_array);
						die;
					} 
					else 
					{
						$extra_array = array('status'=>'error','msg'=>'Error on Settings Updated Successfully','data'=>$data);
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
			
			$data['title'] = "General Settings";
			$data['data']=$this->common_model->get_settings();
			$data['main_content'] =$this->load->view('settings', $data,true);
			$this->load->view('layouts/default_after_login', $data);  
		} else {
			redirect('login');
		}
	}
	
	############ dashboard ############
	public function dashboard(){
		$this->data=array();
		$this->data['main_content']=$this->load->view('shorturl/dashboard', $this->data,true);
		$this->load->view('layouts/default_after_login', $this->data);	
	}
	
	########### Add ##########
	public function edit($id) {
		if($_POST) {
			$this->form_validation->set_rules('long_url','URL','trim|required');
			if($this->form_validation->run() == true) {
				$code=getShortUrl($_POST['long_url']);
				$success = $this->shorten_url_model->update($this->session->userdata('user_id'), $id);
				$short_url=base_url().$code;
				if($success)  {
					$data = array(
						'short_url'  => $short_url
					);
					$extra_array = array('status'=>'success','msg'=>'Short Url Created','data'=>$data);
					echo json_encode($extra_array);
					die;
				}
			}
			else{
				echo $this->form_validation->get_json();
				die;				
			}
		}
		else {		
			$this->data=array();
			$this->data['data']=$this->shorten_url_model->get_details($this->session->userdata('user_id'), $id);
			$this->data['main_content']=$this->load->view('shorturl/edit', $this->data,true);
			$this->load->view('layouts/default_after_login', $this->data);	
		}		
	}
	
	########### Add ##########
	public function add() {
		if($_POST) {
			$this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('long_url','URL','trim|required');
			if($this->form_validation->run() == true) {
				$code=getShortUrl($_POST['long_url']);
				$success = $this->shorten_url_model->add($this->session->userdata('user_id'), $code);
				$short_url=base_url().$code;
				if($success)  {
					$data = array(
						'short_url'  => $short_url,
						'long_url'=> $_POST['long_url']
					);
					$extra_array = array('status'=>'success','msg'=>'Short Url Created','data'=>$data);
					echo json_encode($extra_array);
					die;
				}
			}
			else{
				echo $this->form_validation->get_json();
				die;				
			}
		}
		else {		
			$this->data=array();
			$this->data['main_content']=$this->load->view('Shorturl/create', $this->data,true);
			$this->load->view('layouts/default_after_login', $this->data);	
		}		
	}
	
	############### Admin Index ###############
	public function index() {
		
		$type = $this->uri->segment(2) ? $this->uri->segment(2) : 'index';
		$page_num = $this->uri->segment(3) ? $this->uri->segment(3) : '1';
		$sortfield = $this->uri->segment(4) ? $this->uri->segment(4) : 'id';
		$order = $this->uri->segment(5) ? $this->uri->segment(5) : 'desc';				
						
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'shorten_url.name','created' =>'shorten_url.created','name' =>'shorten_url.name');
		
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'shorten_url.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().'/ShortUrls/active';
			$data['indextitle']  = 'URLS - Active List';
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'shorten_url.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().'ShortUrls/inactive';
			$data['indextitle']  = 'URLS - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().'ShortUrls/index';
			$data['indextitle']  = 'URLS List';
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
			$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(shorten_url.name LIKE '%" . $data['keyword'] . "%')", 'value'=> null);
			$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "shorten_url.long_url LIKE '%" . $data['keyword'] . "%'", 'value' => null);
		 }
		$conditions[] = array('direct'=>0,  'rule' => 'where', 'field' => "shorten_url.user_id", 'value' => $this->session->userdata('user_id'));
		
		$conditions[] = array('direct'=>0,  'rule' => 'where', 'field' => "shorten_url.deleted IS NULL", 'value' =>NULL);
		

		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';	
		$new_data = $this->shorten_url_model->get_list( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end); 
		$data['list']=$new_data['list'];		
		$config['total_rows'] =$new_data['total']; 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/advertisments/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content']=$this->load->view('shorturl/index', $data,true);
		$this->load->view('layouts/default_after_login', $data);	
		
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
			redirect(base_url().'shorturls/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->shorten_url_model->update_status($id, $data);

		redirect(base_url().'shorturls/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
	    $getValues = $this->shorten_url_model->get_details($this->session->userdata('user_id'),$id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$gallery=array();
		if(count($getValues)) {			
			$this->data=array();
			$this->data['title']="View Advertisement Details";
			$this->data['data'] = $getValues;	
			$this->data['main_content']=$this->load->view('shorturl/view', $this->data,true);
			$this->load->view('layouts/default_after_login', $this->data);	
			
			
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().'shorturls/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	########### Advertisement Delete #############
	function delete($id) {
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$this->db->where('id',$id);
		$shorten_url=array('deleted'=>date('Y-m-d H:i:s'));
		$this->db->update('shorten_url',$shorten_url);
		$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		redirect(base_url().'shorturls/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}    
}