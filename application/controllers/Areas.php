<?php
class Areas extends CI_Controller {

    public function __construct()
    {  
        parent::__construct();
        $this->load->model('areas_model');
		$this->load->model('states_model');
		$this->load->model('areas_model');
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
		$this->sorting = array('name' =>'areas.name','created' =>'areas.created','countries_name' =>'countries.name','states_name' =>'states.name','areas_name' =>'areas.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'areas.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/areas/active';
			$data['indextitle']  = 'Areas - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'areas.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/areas/inactive';
			$data['indextitle']  = 'Areas - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/areas/index';
			$data['indextitle']  = 'Areas List';
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
		 $data['name'] = '';
		 $data['search_country'] = '';
		 $data['keyword'] = $this->input->post('keyword');
		 $data['search_submit'] =$this->input->post('search_submit');
		  
		  // Advanced search
	     $data['name'] = $this->input->post('name');//for Normal search
		 $data['country_filter'] = $this->input->post('country_filter');
		 $data['state_filter'] = $this->input->post('state_filter');
		 $data['city_filter'] = $this->input->post('city_filter');
		 
		$data['submit-search'] =$this->input->post('submit-search');//Normal Search submit button
		 $data['submit-search-advance'] =$this->input->post('submit-advanced-search');//Advanced Search submit button
		 //echo $data['submit-search'].'.No.'.$data['submit-search-advance'];die;
		 $data['advanced_search']=false;
		 //Search Start
		if((isset($_POST['submit-search']) || isset($_GET['keyword'])) &&
			($this->input->post('keyword') != '' || $this->input->get('keyword')))
		{
			$data['name']='';
			$data['country_filter']='';
			$data['state_filter']='';
			$data['city_filter']='';
			$data['advanced_search'] = false;
		}
		if((isset($_POST['submit-search-advance'])) || $data['submit-search-advance'])
		{
			$data['keyword']='';
			$data['advanced_search'] = true;
		}
		
		/*********** pagination search ********************/
			$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword'], 'name'=>$data['name'] , 'state_filter'=>$data['state_filter'], 'country_filter'=>$data['country_filter'], 'city_filter'=>$data['city_filter']));
		if($data['keyword'] || $data['country_filter'] || $data['name'] || $data['state_filter'] ||$data['city_filter']  ){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'name'=>$data['name'], 'state_filter'=>$data['state_filter'], 'country_filter'=>$data['country_filter'] , 'city_filter'=>$data['city_filter']));
		}
		else
		{ 
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['submit-search'] && $sortfield != 'reset'){ 
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
				}
			else if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['submit-search-advance'] && $sortfield != 'reset') {
					$data['name'] = $this->session->userdata['search']['name'];
					$data['country_filter'] = $this->session->userdata['search']['country_filter'];
					$data['state_filter'] = $this->session->userdata['search']['state_filter'];
					$data['city_filter'] = $this->session->userdata['search']['city_filter'];
					
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'name'=>$data['name'], 'country_filter'=>$data['country_filter'], 'state_filter'=>$data['state_filter'], 'city_filter'=>$data['city_filter']));
		}
		
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
			$value = '( areas.name Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 
		  if($data['name']  )
		 {
			$value = '( areas.name Like "%'.$data['name'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		
		 if($data['country_filter']  )
		 {
			
			$value = '( areas.country_id ='.$data['country_filter'].' )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 
		  if($data['state_filter']  )
		 {
			
			$value = '( areas.state_id ='.$data['state_filter'].' )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 
		 if($data['city_filter']  )
		 {
			
			$value = '( areas.city_id ='.$data['city_filter'].' )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
					
		//fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['location_list'] = $this->areas_model->get_areas_list( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->areas_model->get_areas_list( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/areas/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['countries']= $this->countries_model->get_countries();
		$data['main_content'] = 'admin/locations/location_list';
		$data['title']="Areas";
		$this->load->view('includes/template', $data);
	}
	public function isunique($pk1, $pk2)
	{
			$result = $this->areas_model->is_area_exists($pk1,  $this->input->post('select_country'), $this->input->post('select_state'),$this->input->post('select_city'));
		   if($result )
		   {
			  $this->form_validation->set_message('isunique','Area already exists !'); // set your message
			  return false;
		   }
		   else{ return true;}

	}
	
	public function add() {	
		$this->breadcrumbs->push('Areas', base_url().ADMIN.'/areas');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/areas/add');
		
		   $this->form_validation->set_rules('select_country', 'Country Name', 'required');		   
		   $this->form_validation->set_rules('select_state', 'State Name',  'required');
		   $this->form_validation->set_rules('select_city', 'City name', 'required');				 
		   $this->form_validation->set_rules('add_area', 'Area name', 'required|callback_isunique[add_area]');
		
	
		if ($this->form_validation->run() == true) {
				
				$selected_country=$this->input->post('select_country');
				if($this->areas_model->create_areas( )){
					$this->common_model->count_action($selected_country,'area_count','+','countries');					
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
							redirect(ADMIN.'/areas');				
				}else{
					 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				}
		}
		$data['countries']= $this->countries_model->get_countries();
		$data['main_content'] = 'admin/locations/area';
		$data['title']="Add areas";
		$data['indextitle']="Add";
		$this->load->view('includes/template', $data);
    }
		
	public function edit($id) {
		$data['result']=$this->get($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($data['result']!=null){
			$this->breadcrumbs->push('Areas', base_url().ADMIN.'/areas');
			$this->breadcrumbs->push('Add', base_url().ADMIN.'/areas/edit');
			
			$this->form_validation->set_rules('select_country', 'Country Name', 'required');		   
			$this->form_validation->set_rules('select_state', 'State Name',  'required');
			$this->form_validation->set_rules('select_city', 'City name', 'required');	
			
			if(($this->input->post('add_area') != $data['result'][0]['area_value']) || ($this->input->post('select_state') != $data['result'][0]['id']) || ($this->input->post('select_country') != $data['result'][0]['c_id']) || ($this->input->post('select_city') != $data['result'][0]['city_id'])) {
				$is_unique =  '|callback_isunique[add_area]';
			} else {
				$is_unique =  '' ;
			}					
			$this->form_validation->set_rules('add_area', 'Area name', 'required'.$is_unique);
		  
				if (isset($_POST) && !empty($_POST))
			{					
					if ($this->form_validation->run() == true) {
							if($this->areas_model->edit( )){	
									$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
									redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);	
							}else{
								 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
								 redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
							}
					}
			}
			$data['countries']= $this->countries_model->get_countries();
			$data['main_content'] = 'admin/locations/area';
			$data['title']="Edit areas";
			$data['indextitle']="Edit";
			$this->load->view('includes/template', $data);
		}else{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
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
			redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->areas_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->areas_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->areas_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
 	 public function get($slug=false) {		
		if($slug){
			$data = $this->areas_model->get_areas_by_id($slug);
			return $data;
			
		}
	}
	
	public function get_areas_by_city($slug=false) {	
			$data = $this->areas_model->get_areas($slug);
			//return 	$data;
			echo json_encode($data);
    } 
	
	
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->areas_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/areas/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}
?>