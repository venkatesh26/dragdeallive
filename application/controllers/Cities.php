<?php
class Cities extends CI_Controller {

    public function __construct()
    { 
        parent::__construct();
        $this->load->model('cities_model');
		 $this->load->model('states_model');
		$this->load->model('countries_model');
		$this->load->model('common_model');
		$this->load->model('areas_model');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
    }
	
	public function index($type = null, $page_num =1,$sortfield='id',$order='desc')
	{
		$this->load->helper('date_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'cities.name','created' =>'cities.created','countries_name' =>'countries.name','states_name' =>'states.name');
		if($type == 'active') {	
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'cities.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/cities/active';
			$data['indextitle']  = 'Cities - Active List';
			$data['type'] = 'active';
		} else if($type == 'inactive') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'cities.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/cities/inactive';
			$data['indextitle']  = 'Cities - Inactive List';
			$data['type'] = 'inactive';
		}
		else if($type == 'featured') {
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'cities.featured_city', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/cities/featured';
			$data['indextitle']  = 'Cities - FeaturedCity List';
			$data['type'] = 'featured';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/cities/index';
			$data['indextitle']  = 'Cities List';
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
			$data['advanced_search'] = false;
		}
		if((isset($_POST['submit-search-advance'])) || $data['submit-search-advance'])
		{
			$data['keyword']='';
			$data['advanced_search'] = true;
			
		}
		
		/*********** pagination search ********************/
			$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword'], 'name'=>$data['name'] , 'state_filter'=>$data['state_filter'], 'country_filter'=>$data['country_filter']));
		if($data['country_filter'] || $data['name'] || $data['state_filter'] ){ //die; 
			$search_session  =  array('search'=>array('type'=>$type,'name'=>$data['name'], 'state_filter'=>$data['state_filter'], 'country_filter'=>$data['country_filter']));
			$array_items = array('keyword' => '');
			$this->session->unset_userdata($array_items);
			$data['advanced_search'] = true;
		}else if($data['keyword']){ //die;
	//	$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword']));
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
			$data['advanced_search'] = false;
			$array_items = array('country_filter' => '', 'state_filter' => '','name'=>'');
			$this->session->unset_userdata($array_items);
			
		}
		else if(!$data['keyword'] || !$data['name'])
		{ 
			 if(isset($this->session->userdata['search']['type']) && !$data['submit-search'] && $sortfield != 'reset' && $this->session->userdata['search']['keyword']!="" ){ 
			 //echo $this->session->userdata['search']['keyword'];die;
			//  $this->session->unset_userdata['search'];
			  $array_items = array('country_filter' => '', 'state_filter' => '','name'=>'');

					$this->session->unset_userdata($array_items);
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
					$data['advanced_search'] = false;
				}
			else if(isset($this->session->userdata['search']['type']) && !$data['submit-search-advance'] && $sortfield != 'reset' && isset($this->session->userdata['search']['name']) && ($this->session->userdata['search']['name']!="" || $this->session->userdata['search']['state_filter']!="" || $this->session->userdata['search']['country_filter']!="" ) ) {  		//echo "1";die;
					$data['name'] = $this->session->userdata['search']['name'];
					$data['country_filter'] = $this->session->userdata['search']['country_filter'];
					$data['state_filter'] = $this->session->userdata['search']['state_filter'];
					$data['advanced_search'] = true;
				}else
				{//die;
					$type = '';
					$data['advanced_search'] = false;
				}//echo $this->session->userdata['search']['type']."2";die;
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword'] , 'name'=>$data['name'], 'country_filter'=>$data['country_filter'], 'state_filter'=>$data['state_filter']));
		}
		else
		{ //die;
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['search_submit'] && $sortfield != 'reset'){
					$data['keyword'] = $this->session->userdata['search']['keyword'];
					$data['advanced_search'] = false;
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
				$data['advanced_search'] = false;
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/

		 if($data['keyword']  )
		 {
			$value = '( cities.name Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 
		  if($data['name']  )
		 {
			$value = '( cities.name Like "%'.$data['name'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		
		 if($data['country_filter']  )
		 {
			 $value = '( cities.country_id ='.$data['country_filter'].' )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		 
		  if($data['state_filter']  )
		 {
			$value = '( cities.state_id ='.$data['state_filter'].' )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
		
		//fetch sql records with arrays
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['location_list'] = $this->cities_model->get_cities_list( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);
		
		//echo "<pre>";  
		//print_r($data['location_list']);      
		$config['total_rows'] =$this->cities_model->get_cities_list( 0 , $conditions, '', '', '', '');   
		//echo "<pre>";
		//print_r($config['total_rows']);   exit;  
		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
			redirect(ADMIN.'/cities/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['countries']= $this->countries_model->get_countries();
		$data['main_content'] = 'admin/locations/location_list';
		$data['title']="Cities";
		$this->load->view('includes/template', $data);
	}
	
	public function isunique($pk1, $pk2)
	{
			$result = $this->cities_model->is_city_exists($pk1,  $this->input->post('select_state'), $this->input->post('select_country'));
		   if($result )
		   {
			  $this->form_validation->set_message('isunique','City already exists !'); // set your message
			  return false;
		   }
		   else{ return true;}

	}
	public function add() 
	{		
		$this->breadcrumbs->push('Cities', base_url().ADMIN.'/cities');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/cities/add');
	    $this->form_validation->set_rules('select_country', 'Country Name', 'required');
	    $this->form_validation->set_rules('select_state', 'State Name', 'required');	 
	    $this->form_validation->set_rules('add_city', 'City Name',  'trim|required|callback_isunique[add_city]');
		if ($this->form_validation->run() == true) 
		{
			$config['upload_path']   =  $this->config->item('cities_icon_url');
            $config['allowed_types'] =   "gif|jpg|jpeg|png";		 
	    	$this->load->library( 'upload' ,  $config);
			$this->upload->initialize($config);
			$image_up = $this->upload->do_upload('image');
	        $image_data =  array('upload_data' => $this->upload->data());
			$id=$this->cities_model->create_cities($image_data);
			if($id)
			{	
					$selected_country=$this->input->post('select_country');
					$this->common_model->count_action($selected_country,'city_count','+','countries');		
					 $this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
							redirect(ADMIN.'/cities');				
				}else{
					 $this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				}
		}
		$data['countries']= $this->countries_model->get_countries();
		$data['main_content'] = 'admin/locations/city';
		$data['title']="Add cities";
		$data['indextitle']="Add";
		$this->load->view('includes/template', $data);
    }
	public function edit($id) 
	{
		$data['result']=$this->get($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($data['result']!=null){
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Cities', base_url().ADMIN.'/cities');
			$this->breadcrumbs->push('Add', base_url().ADMIN.'/cities/edit');
			$this->form_validation->set_rules('select_country', 'Country Name', 'required');
			$this->form_validation->set_rules('select_state', 'State Name', 'required');
			if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='') 
			{
			   $this->form_validation->set_rules('image', 'Image', 'file_allowed_type[image]');
			}
			if(($this->input->post('add_city') != $data['result'][0]['city_value'] ) || ($this->input->post('select_state') != $data['result'][0]['id']) || ($this->input->post('select_country') != $data['result'][0]['c_id'])) {
				$is_unique =  '|callback_isunique[add_city]';
			} else {
				$is_unique =  '' ;
			}	
			$this->form_validation->set_rules('add_city', 'City Name',  'trim|required'.$is_unique);
	   
				if (isset($_POST) && !empty($_POST))
			{					
			if ($this->form_validation->run() == true) 
			{
                    $data_to_store="";
					if($_FILES['image']['name']!='')
	 			 	{
					   	$config['upload_path']   =   $this->config->item('cities_icon_url');
					   	$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
					   	$this->load->library( 'upload' ,  $config);
						$this->upload->initialize($config);
					   	$image_up = $this->upload->do_upload('image');
					   	$image_data =  array('upload_data' => $this->upload->data());
					   	$data_to_store = array(
					   						'city_image' => $image_data['upload_data']['file_name'],
											'image_dir' => $this->config->item('cities_icon_url')
					    				);
				 	}				
				if($this->cities_model->edit($data_to_store))
				{					      
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}
				else
				{
					$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
				}
			}
			}
			$data['countries']= $this->countries_model->get_countries();
			$data['areas']= $this->areas_model->get_areas($data['result'][0]['city_id'] );			
			$data['main_content'] = 'admin/locations/city';
			$data['title']="Edit city";
			$data['indextitle']="Edit";
			$this->load->view('includes/template', $data);
		}else{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
    }
  
    public function get($slug=false) 
	{		
		if($slug){
			$data = $this->cities_model->get_cities_by_id($slug);
			return $data;
			
		}else{
			$data = $this->cities_model->get_cities($slug);
			echo json_encode($data);
		}
    } 
	
	public function get_cities_by_state($slug=false) 
	{	
			$data = $this->cities_model->get_cities($slug);
			//return 	$data;
			echo json_encode($data);
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
			redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->cities_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function update_featured($id, $featured, $pageredirect=null,$pageno)
	{
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		
		if($featured == 'featured'){ 
			$data = array('featured_city' => '0');
			
			$this->session->set_flashdata('flash_message', $this->lang->line('cityunfeatured') );
		} else if($featured == 'unfeatured'){
			$data = array('featured_city' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('cityfeatured') );
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		} 
		$this->cities_model->update_featured($id, $data);
		redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function update_en_start_your($id, $featured, $pageredirect=null,$pageno)
	{
	    $fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($featured == 'featured'){ 
			$data = array('is_home_city' => '0');
			
		
		} else if($featured == 'unfeatured'){
			$data = array('is_home_city' => '1');
			
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		} 
		$status=$this->cities_model->update_en_start_your($id, $data);
		if($status=='inactive-success')
		{
		$this->session->set_flashdata('flash_message', $this->lang->line('disabled'));
		}
		if($status=='active-success')
		{
		$this->session->set_flashdata('flash_message', $this->lang->line('citystart') );
		}
		if($status=='need-tofill')
		{
		$this->session->set_flashdata('flash_message', $this->lang->line('cityunstart') );
		}
		redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	
	
	}
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->cities_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled') );
		}
		else if($bulk_type == 2){
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->cities_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->cities_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	public function remove_images($id=null)
	{
	$data = $this->cities_model->remove_images($id);
	$s=0;
	if($data)
	$s=1;
	echo json_encode($s);
	die;
	}
	public function view($id=null)
	{
	    $getValues = $this->cities_model->get_city_detail($id);
		$get_city_images=$this->cities_model->get_city_images($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('City', base_url().ADMIN.'/cities');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/cities/view');
			$this->data['cities'] = $getValues;	
			$this->data['place_images'] = $get_city_images;	
			$this->data['main_content'] = 'admin/locations/view';
			$this->data['title']="View City Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/cities/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
}
?>
