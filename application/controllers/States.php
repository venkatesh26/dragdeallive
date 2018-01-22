<?php
class States extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('states_model');
		$this->load->model('countries_model');
		$this->load->model('common_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
    }

	public function index($type = null, $page_num =1,$sortfield='id',$order='desc'){
		$this->load->helper('date_helper');
		$conditions = array();
		$search_session = array();
		//pagination settings
		$cofig =array();
		$config = admin_settings_initialize('settings');
		//sortings
		$this->sorting = array('name' =>'states.name','created' =>'states.created','countries_name' =>'countries.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'states.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/states/active';
			$data['indextitle']  = 'States - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'states.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/states/inactive';
			$data['indextitle']  = 'States - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/states/index';
			$data['indextitle']  = 'States List';
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
		  $data['search_country'] = '';
		 $data['keyword'] = $this->input->post('keyword');
		 $data['search_country'] = $this->input->post('search_country');
		 $data['search_submit'] =$this->input->post('search_submit');
		
		/*********** pagination search ********************/
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword']));
		if($data['keyword'] || $data['search_country']){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'],'search_country'=>$data['search_country']));
		}
		else { 
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['search_submit'] && $sortfield != 'reset'){
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
					if(isset($this->session->userdata['search']['search_country'])){
						$data['search_country'] = $this->session->userdata['search']['search_country']; 
					}
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'],'search_country'=>$data['search_country']));
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/

		 if($data['keyword']  )
		 {
			
			$value = '( states.name Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 if( $data['search_country'] )
		 {
			
			$value = '( states.country_id ='.$data['search_country'].' )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 
		//fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['location_list'] = $this->states_model->get_states_list( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->states_model->get_states_list( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/states/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['countries']= $this->countries_model->get_countries();
		$data['main_content'] = 'admin/locations/location_list';
		$data['title']="States";
		$this->load->view('includes/template', $data);
	}
	public function isunique($pk1, $pk2)
	{
			$result = $this->states_model->is_state_exists($pk1,  $this->input->post('select_country'));
		   if($result )
		   {
			  $this->form_validation->set_message('isunique','State already exists !'); // set your message
			  return false;
		   }
		   else{ return true;}

	}
	 public function add() {	
			
		$this->breadcrumbs->push('States', base_url().ADMIN.'/states');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/states/add');
	   $this->form_validation->set_rules('select_country', 'Country Name', 'required');		
	   $this->form_validation->set_rules('add_state', 'State Name',  'trim|required|callback_isunique[add_state]');
	   
		if ($this->form_validation->run() == true) { 
				if($this->states_model->create_states()){
					$selected_country=$this->input->post('select_country');
					$this->common_model->count_action($selected_country,'state_count','+','countries');			
					 $this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
						redirect(ADMIN.'/states');		
				}else{
					 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				}
		}else{
			
		}
		$this->data['countries']= $this->countries_model->get_countries();
		$this->data['main_content'] = 'admin/locations/state';
		$this->data['title']="Add States";
		$this->data['indextitle']="Add";
		$this->load->view('includes/template',$this->data);
		
    } 
	
	public function edit($id) {
		$this->data['result']=$this->get($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->data['result']!=null){
			$this->breadcrumbs->push('States', base_url().ADMIN.'/states');
			$this->breadcrumbs->push('Add', base_url().ADMIN.'/states/edit');
			
			if($this->input->post('add_state') != $this->data['result'][0]['value']) {
				$is_unique =  '|callback_isunique[add_state]' ;
			} else {
				$is_unique =  '' ;
			}
			$this->form_validation->set_rules('select_country', 'Country Name', 'required');		
			$this->form_validation->set_rules('add_state', 'State Name',  'trim|required'.$is_unique);
			
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">
					<a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
			if (isset($_POST) && !empty($_POST))
			{					
				if ($this->form_validation->run() == true) {
			
						if($this->states_model->edit()){
							 $this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
							redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);	
						}else{
							 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
							 redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
						}
				}
			}
			$this->data['countries']= $this->countries_model->get_countries();
			$this->data['main_content'] = 'admin/locations/state';
			$this->data['title']="Edit state";
			$this->data['indextitle']="Edit";
			$this->load->view('includes/template', $this->data);	
		}else{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->states_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->states_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->states_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
    public function get($slug=false) {
		if($slug){
			$data = $this->states_model->get_states_by_id($slug);
				
			return $data;			
		}else{
			$data = $this->states_model->get_states($slug);
			echo json_encode($data);
		}
    } 
	 public function get_states_by_country($slug=false) 
	 {
			$data = $this->states_model->get_states(false,$slug);				
			echo json_encode($data);
    } 
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->states_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/states/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
?>
