<?php
class Countries extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('countries_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
    }

  	public function index($type = null, $page_num =1,$sortfield='id',$order='desc'){ 
		$this->load->helper('date_helper');
		$conditions = array();
		$search_session = array();
		 $data['advanced_search']=false;
		//pagination settings
		$cofig =array();
		$config = admin_settings_initialize('settings');
		//sortings
		$this->sorting = array('name' =>'countries.name','created' =>'countries.created','code' =>'countries.code');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'countries.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/countries/active';
			$data['indextitle']  = 'Countries - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'countries.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/countries/inactive';
			$data['indextitle']  = 'Countries - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			//$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'countries.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/countries/index';
			$data['indextitle']  = 'Countries List';
			$data['type'] = 'index';
		}
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
				$this->pagination->cur_page = $page_num;
		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$config['first_url'] = $config['base_url'].'/1/'.$sortfield.'/'.$order;
		$data['advanced_search'] = false;
		 //search 
		 $data['keyword'] = '';
		 $data['keyword'] = $this->input->post('keyword');
		 $data['search_submit'] =$this->input->post('search_submit');
		
		/*********** pagination search ********************/
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword']));
		if($data['keyword']){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] ));
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
			$value = '( countries.name Like "%'.$data['keyword'].'%" OR   countries.code Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }		
		
		//fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['location_list'] = $this->countries_model->get_countries_list( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->countries_model->get_countries_list( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/countries/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['advanced_search'] = false;
		
		$data['main_content'] = 'admin/locations/location_list';		
		$data['title']="Countries";
		$this->load->view('includes/template', $data);
    }
	
    public function get($slug=false) {
		$data = $this->countries_model->get_countries($slug);
		if($slug){	
			return $data;			
		}else{
			echo json_encode($data);
		}
    } 
	
	public function edit($slug=null) { 
		if($slug){
			$data['result']=$this->get($slug);
		}
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($data['result'])) {
			// add breadcrumbs
			$this->breadcrumbs->push('Countries', base_url().ADMIN.'/countries');
			$this->breadcrumbs->push('Add', base_url().ADMIN.'/countries/edit');
			if(trim($this->input->post('add_country')) != $data['result'][0]['value']) {
				$is_unique =  '|is_unique[countries.name]' ;
			} else {
				$is_unique =  '' ;
			}
			if(trim($this->input->post('add_code')) != $data['result'][0]['code']) {
				$is_unique_slug =  '|is_unique[countries.code]' ;
			} else {
				$is_unique_slug =  '' ;
			}
			
			$this->form_validation->set_rules('add_country', 'Country name','trim|required'.$is_unique);
			$this->form_validation->set_rules('add_code', ' Country code','trim|required'.$is_unique_slug);
			
			if (isset($_POST) && !empty($_POST))
			{	
				if ($this->form_validation->run() === true) {
					
					if($this->countries_model->edit()){
						 $this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					}else{
						 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
					}
					redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}
			}
			$data['main_content'] = 'admin/locations/country';
			$data['title']="Edit country";
			$data['head_title'] = "Edit";
			$this->load->view('includes/template', $data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}	
    } 
    public function add() {
		// add breadcrumbs
			$this->breadcrumbs->push('Countries', base_url().ADMIN.'/countries');
			$this->breadcrumbs->push('Add', base_url().ADMIN.'/countries/add');
			$this->form_validation->set_rules('add_country', 'Country Name', 'trim|required|is_unique[countries.name]');
			$this->form_validation->set_rules('add_code', 'Country code', 'trim|required|is_unique[countries.code]');
			if ($this->form_validation->run() == true) {
				if($this->countries_model->create_counties()){
					$this->session->set_flashdata('flash_message', $this->lang->line('record_add'));
				}else{
					$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				}
				redirect(ADMIN.'/countries');
		
				if($success){
					// redirection
				}
			}
			$data['main_content'] = 'admin/locations/country';
			$data['title']="Add countries";
			$data['head_title'] = "Add";
			$this->load->view('includes/template', $data);
    } 

    public function update() {
		if($this->countries_model->edit()){
			 $this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
		}else{
			 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
		}
		redirect(ADMIN.'/countries');	
    }
	function update_status($id, $status ,$pageredirect=null,$pageno){ 
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($status == 'enable'){
			$data = array('is_active' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		}
		else if($status == 'disable'){
			$data = array('is_active' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->countries_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->countries_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->countries_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
    function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->countries_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/countries/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}

}
?>
