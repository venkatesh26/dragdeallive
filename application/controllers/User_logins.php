<?php
class User_logins extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_logins_model');
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
		$this->sorting = array('email' =>'users.email','created' =>'user_logins.created','ip' =>'user_logins.ip');
		if($type == 'admin') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.user_type', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/user_logins/active';
			$data['indextitle']  = 'Admin - Login List';
			$data['type'] = 'active';
		} else if($type == 'hotels') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.user_type', 'value' => 2 );	
			$config['base_url'] = base_url().ADMIN.'/user_logins/hotels';
			$data['indextitle']  = 'Hotels - Login List';
			$data['type'] = 'hotels';
		}
		else if($type == 'webusers') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'users.user_type', 'value' => 3 );	
			$config['base_url'] = base_url().ADMIN.'/user_logins/webusers';
			$data['indextitle']  = 'Web Users - Login List';
			$data['type'] = 'webusers';
		}
		else {
			$config['base_url'] = base_url().ADMIN.'/user_logins/index';
			$data['indextitle']  = 'User Login List';
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
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword']));
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
			$value = '( users.email Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }		
		//fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['user_logins'] = $this->user_logins_model->get_user_logins( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->user_logins_model->get_user_logins( 0 , $conditions, '', '', '', '');  
		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/user_logins/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
				
		$data['main_content'] = 'admin/user_logins/index';
		$data['title']="User Login";
		$this->load->view('includes/template', $data);
    }
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 3) {
			foreach($bulk_ids as $id) {
				$data = array('is_deleted' => '1');
				$this->user_logins_model->delete($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted') );
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/user_logins/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/user_logins/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$data = array('is_deleted' => '1');
		if($this->user_logins_model->delete($id,$data)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/user_logins/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
?>