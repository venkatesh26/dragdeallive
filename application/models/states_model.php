<?php
class States_model extends CI_Model {
	public function is_state_exists($slug , $selected_country){ 
		$this->db->select('id');
		$this->db->where('name', $slug); 
		$this->db->where('country_id', $selected_country); 
		$query = $this->db->get('states');
		$id=$query->result();
		if($id){			
			return $id[0]->id;
		}else{
			return false;
		}
	}

	public function create_states()
	{
			$selected_country = $this->input->post('select_country');
			$is_exist =$this->is_state_exists($this->input->post('add_state'),$selected_country);
			$insert=false;
			if(!$is_exist ){
				$new_state_insert_data = array(
					'name' => $this->input->post('add_state'),						
					'created'=>date("Y-m-d h:i:s", time()),
					'modified'=>date("Y-m-d h:i:s", time()),				
					'country_id'=>$selected_country,
					'latitude'=>$this->input->post('add_lat'),
					'longtitude'=>$this->input->post('add_long'),
					'is_active'=>$this->input->post('is_active')
						
				);
				$this->db->insert('states', $new_state_insert_data);
				$insert = $this->db->insert_id() ;
			}					
			return $insert;
	}
	
	public function get_states($slug=false,$country_id=false)
	{	
	
		if($slug)
		{ 
				$this->db->where('states.id', $slug); 
				$this->db->select('countries.id as c_id,countries.name as c_name,
					states.id as s_id ,states.name as s_name,countries.state_type');	
			$this->db->join('countries', 'states.country_id = countries.id'); 
		}
		if($country_id){
			$this->db->where('states.country_id', $country_id); 
			$this->db->where('is_active',1); 	
		}		
		$this->db->order_by('states.name','ASC' );
		$query = $this->db->get('states');		
		$result = $query->result();
		$arr = array();
		foreach($result as $g) 
		{
			 $arr[$g->id]=ucfirst($g->name);
		}
		return $arr;
	}

	public function get_states_list($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end)
	{  
		//$this->db->select('states.id, states.name, states.created, states.is_active ');
		$this->db->select('countries.name as c_name,states.id ,states.name as s_name, states.created, states.is_active,countries.state_type');	
		$this->db->where('countries.is_active',1);
		$this->db->join('countries', 'states.country_id = countries.id'); 
		$this->db->from('states');
		//$this->db->where('is_active', 1);
		
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
			$this->db->order_by('states.id', $order_type);
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
	 
	public function get_states_by_id($slug=false)
	{	

		$this->db->where('states.id', $slug); 
		$this->db->select('countries.id as c_id,countries.name as c_name,
				states.id as s_id ,states.name as s_name,states.longtitude,states.latitude,states.is_active,countries.state_type');	

		$this->db->join('countries', 'states.country_id = countries.id'); 
		
		$query = $this->db->get('states');		
		
		$result = $query->result();

		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->s_name),'id'=>$g->s_id,'c_value'=> ucfirst($g->c_name),'c_id'=>$g->c_id,'longitude'=>$g->longtitude,'latitude'=>$g->latitude,'is_active'=>$g->is_active);
		}
		
		return $arr;
	}

	public function edit()
	{ 	
		$selected_country = $this->input->post('select_country');
		$_data = array(
		 	'name'=> $this->input->post('add_state'),
			'latitude'=> $this->input->post('add_lat'),
			'longtitude'=> $this->input->post('add_long'),
			'country_id' => 	$selected_country,
			'is_active'=>$this->input->post('is_active')			
		);
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('states', $_data);
	       	return $update;
	      
	}
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('states', $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	public function delete($id) {
		$this->db->delete('states',array('id' => $id));
		//city Tables
		$this->db->delete('cities',array('state_id' => $id));
		//area Tables
		$this->db->delete('areas',array('state_id' => $id));
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	function get_auto_states() {
		$query_str = $_POST['keys'];
		//echo $query_str;die;
		if($query_str) {
			$this->db->like('name', $query_str,'after'); 
		}
		$this->db->where('country_id',$_POST['country']);
		$this->db->where('is_active','1');
		$this->db->select('id,name');
		$query = $this->db->get('states');		
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
