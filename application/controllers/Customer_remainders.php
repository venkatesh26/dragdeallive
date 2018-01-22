<?php
class Customer_remainders extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('remainder_model');
		$this->load->library('breadcrumbs');
    }
	
	######### Admn Index #########
	public function index($remainder_type=null,$type = null, $page_num =1,$sortfield='id',$order='desc') {
		
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'user_profiles.first_name','created' =>'remainder_settings.created','email' =>'users.email','title' =>'remainder_settings.title');
		$data['remainder_type'] = ($remainder_type=='') ? 'birthday':$remainder_type;	
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'remainder_settings.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/customer_remainders/'.$data['remainder_type'].'/active';
			$data['indextitle']  = 'Remainders List - '.ucfirst($this->uri->segment(3));
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'remainder_settings.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/customer_remainders/'.$data['remainder_type'].'/inactive';
			$data['indextitle']  = 'Remainders List - '.ucfirst($this->uri->segment(3));
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/customer_remainders/'.$data['remainder_type'].'/index';
			$data['indextitle']  = 'Remainders List - '.ucfirst($this->uri->segment(3));
			$data['type'] = 'index';
		}
		
		if($this->uri->segment(3)=='birthday'){
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'remainder_settings.remainder_type_id', 'value' => 1);	
		}
		else if($this->uri->segment(3)=='aniversery'){
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'remainder_settings.remainder_type_id', 'value' => 2);	
		}
		else {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'remainder_settings.remainder_type_id', 'value' => 3);	
		}
		
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$this->pagination->cur_page = $page_num;
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
			$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(advertisment_comments.title LIKE '%" . $data['keyword'] . "%'", 'value'=> null);
			$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "advertisements.name LIKE '%" . $data['keyword'] . "%'", 'value' => null);
			$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "user_profiles.first_name LIKE '%" . $data['keyword'] . "%'", 'value' => null);
			$conditions[] = array( 'direct'=>0,  'rule' => 'or_where', 'field' => "users.email like '%" . $data['keyword'] . "%')", 'value'=> null); 	
		 }
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['remainders'] = $this->remainder_model->get_remainder( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);    
		$config['total_rows'] =$this->remainder_model->get_remainder( 0 , $conditions, '', '', '', ''); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/customer_remainders/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/customer_remainders/index';
		$data['title']="Customer Remainders";
		$this->load->view('includes/template', $data);
	}
	
	########### Update Status #########
	function update_status($remainder_type,$id, $status, $pageredirect=null,$pageno) { 
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
			redirect(base_url().ADMIN.'/customer_remainders/'.$remainder_type.'/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->remainder_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function bulkautions($pageredirect=null,$pageno) {
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->comment_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled'));
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->comment_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	####### Admin View ########
	public function  view($type,$id) {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
	    $getValues = $this->remainder_model->get_remainder_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Remainders', base_url().ADMIN.'/customer_remainders/'.$type);
			$this->breadcrumbs->push('View', base_url().ADMIN.'/customer_remainders/view');
			$this->data['campaign'] = $getValues;	
			$this->data['type']=$type;
			$this->data['main_content'] = 'admin/customer_remainders/view';
			$this->data['title']="View Remainder Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	function delete($id) {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->remainder_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}