<?php
class Areas_model extends CI_Model {

	public function __construct(){ 
		parent::__construct();
		$this->load->model('countries_model');
		$this->load->model('states_model');
		$this->load->model('cities_model');
    }
	
	
	function get_add_area($keyword,$city_id=false)
	{			
		if($keyword) 
		{
			$this->db->like('name', $keyword,'after'); 
		}
		$this->db->where('city_id', $city_id); 	
		$this->db->where('is_active',1); 	
		$this->db->order_by('areas.name','ASC' );
		$query = $this->db->get('areas');		
		
		$result = $query->result();		
		$arr = array();
		foreach($result as $g) {
			$arr[$g->id]= ucfirst($g->name);
		}
		
		return $arr;
	}

	function is_area_exists($slug,$selected_country,$selected_state,$selected_city){ 
		$this->db->select('id');
		$this->db->where('name', $slug); 
		$this->db->where('country_id', $selected_country); 
		$this->db->where('state_id', $selected_state); 
		$this->db->where('city_id', $selected_city); 
		$query = $this->db->get('areas');		
		$id = $query->result();
		if($id){			
			return $id[0]->id;
		}else{
			return false;
		}	
	}
	function create_areas(){
			$insert=false;
			$selected_country=$this->input->post('select_country');
			$selected_state=$this->input->post('select_state');
			$selected_city=$this->input->post('select_city');
			$new_area_insert_data = array(
				'name' => $this->input->post('add_area'),						
				'created'=>date("Y-m-d h:i:s", time()),
				'modified'=>date("Y-m-d h:i:s", time()),
				'is_active'=> $this->input->post('is_active'),
				'city_id'=>$selected_city,				
				'country_id'=>$selected_country,				
				'state_id'=>$selected_state,					
			);
			$this->db->insert('areas', $new_area_insert_data);
			$insert = $this->db->insert_id() ;
			return $insert;
	}
	

	function get_areas_by_id($slug=false) {	

		$this->db->where('areas.id', $slug); 
		$this->db->select('countries.id as c_id,countries.name as c_name,
				states.id as s_id ,states.name as s_name,cities.id as city_id ,
				cities.name as city_name,areas.id as area_id ,
				areas.name as area_name,areas.is_active');	

		$this->db->join('cities', 'areas.city_id = cities.id','left'); 
		$this->db->join('states', 'areas.state_id = states.id','left'); 
		$this->db->join('countries', 'areas.country_id = countries.id','left'); 
		
		$query = $this->db->get('areas');		
		//echo $this->db->last_query();
		$result = $query->result();

		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->s_name),'id'=>$g->s_id,'c_value'=> ucfirst($g->c_name),'c_id'=>$g->c_id,'city_value'=> ucfirst($g->city_name),'city_id'=>$g->city_id,'area_value'=> ucfirst($g->area_name),'area_id'=>$g->area_id,'is_active'=>$g->is_active);
		}
		
		return $arr;
	}

	function get_areas($city_id=false)
	{			
		
		$this->db->where('city_id', $city_id); 	
		$this->db->where('is_active',1); 	
		$this->db->order_by('areas.name','ASC' );
		$query = $this->db->get('areas');		
		
		$result = $query->result();		
		$arr = array();
		foreach($result as $g) {
			$arr[$g->id]= ucfirst($g->name);
		}
		
		return $arr;
	}


	function edit( ) {
		$_data = array(
		 	'name'=> $this->input->post('add_area'),
			'country_id' => $this->input->post('select_country'),
			'state_id' => $this->input->post('select_state'),
			'city_id' => $this->input->post('select_city'),			
			'is_active'=>$this->input->post('is_active')
		);
		$this->db->where('id', $this->input->post('id'));

		$update = $this->db->update('areas', $_data);//echo $this->db->last_query();exit;
	       	return $update;
	}
	public function update_status($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('areas', $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}

	public function get_areas_list($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end)
	{  
		$this->db->select('areas.name as a_name,areas.id , cities.name as cs_name, states.name as s_name,countries.name as c_name,areas.created, areas.is_active');
		$this->db->join('countries', 'areas.country_id = countries.id','left'); 
		$this->db->join('states', 'areas.state_id = states.id','left'); 
		$this->db->join('cities', 'areas.city_id = cities.id','left'); 
		$this->db->from('areas');		
		if(!empty($conditions))
		{ 
				foreach($conditions as $key=>$cond)
				{
					if(!$cond['direct'])
						$this->db->$cond['rule']($cond['field'], $cond['value']);
					else
						$this->db->$cond['rule']($cond['value']);
				}
		}	
		if(!$sort_field)
			$this->db->order_by('areas.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
				$query = $this->db->get();		
				return $query->num_rows();        
		}
	 }
	public function delete($id) {
		$this->db->delete('areas',array('id' => $id));
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	function get_auto_area() {
		$query_str = $_POST['keys'];
		//echo $query_str;die;
		if($query_str) {
			$this->db->like('name', $query_str,'after'); 
		}
		$this->db->where('country_id',$_POST['country']);
		$this->db->where('state_id',$_POST['state']);
		$this->db->where('city_id',$_POST['city']);
		$this->db->where('is_active','1');
		$this->db->select('id,name');
		$query = $this->db->get('areas');		
		//echo $this->db->last_query();die;
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}
		return $arr;
	}
}
?>