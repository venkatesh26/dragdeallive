<?php
class Countries_model extends CI_Model {

	function is_country_exists($slug,$skip_create=false){
		$this->db->select('id');
		$this->db->where('name', $slug); 
		$query = $this->db->get('countries');
	//	print_r($query->result());exit;
		if($query->result()){
			//return 0 ;//$query->result()[0]->id;
			$id=$query->result();
			return $id[0]->id;
		}else{
			if(!$skip_create){
				return $this->create_counties( $slug,1);
			}else{
				return false ;
			}
		}	
		
	}

	function create_counties($countries=false,$codes=false)
	{
			$insert = $this->is_country_exists($this->input->post('add_country'),true);
			if(!$insert){
				$new_country_insert_data = array(
					'name' => $this->input->post('add_country'),
					'code'=> $this->input->post('add_code'),		
					'created'=>date("Y-m-d h:i:s", time()),
					'modified'=>date("Y-m-d h:i:s", time()),
					'is_active'=>$this->input->post('is_active'),
					'state_type'=>$this->input->post('state_type')					
				);
				$this->db->insert('countries', $new_country_insert_data);

				$insert = $this->db->insert_id() ;
				
			}
		return $insert;
	}
	
	function get_countries($slug=false)
	{	
		if($slug){
			$this->db->where('id', $slug); 
		}else{
			$this->db->where('is_active',1); 	
		}
		$this->db->select('id,name,code,is_active,state_type');		
		$this->db->order_by('countries.name','ASC' );
		$query = $this->db->get('countries');	
		
		$result = $query->result();	
		
		$arr = array();
		foreach($result as $g) {
			if($slug){
					$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id,'code'=>$g->code,'is_active'=>$g->is_active,'state_type'=>$g->state_type);
			}else{
					$arr[$g->id]=ucfirst($g->name);
			}
		}
		return $arr;
	}
	public function get_countries_list($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end)
	{  
		$this->db->select('countries.id , countries.name,countries.code, countries.created, countries.is_active ');
		$this->db->from('countries');
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
			$this->db->order_by('countries.id', $order_type);
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
	function edit()
	{ 	
		$_data = array(
		 	'name'=> $this->input->post('add_country'),
			'code'=>$this->input->post('add_code'),
			'is_active'=>$this->input->post('is_active'),
			'state_type'=>$this->input->post('state_type')	
		);
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('countries', $_data);
	       	return $update;
	      
	}
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('countries', $data);
		
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
		//for countries Tables
		$this->db->delete('countries',array('id' => $id));
		//state Tables
		$this->db->delete('states',array('country_id' => $id));
		//city Tables
		$this->db->delete('cities',array('country_id' => $id));
		//area Tables
		$this->db->delete('areas',array('country_id' => $id));
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	function get_auto_countries() {
		$query_str = $_SERVER['QUERY_STRING'];
		//echo $query_str;die;
		if($query_str) {
			$query_str=explode("=",$query_str );
			$this->db->like('name', $query_str[1],'after'); 
		}

		$this->db->where('is_active','1');
		$this->db->select('id,name');
		$query = $this->db->get('countries');		
		//echo $this->db->last_query();
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}	
		return $arr;
	}
}
?>