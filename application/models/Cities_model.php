<?php
class Cities_model extends CI_Model {

	function is_city_exists($slug,$selected_state,$selected_country){ 
		$this->db->select('id');
		$this->db->where('name', $slug);
		$this->db->where('country_id', $selected_country); 
		$this->db->where('state_id', $selected_state); 		
		$query = $this->db->get('cities');
		$res= $query->result();
		
		if($res){			
			return $res[0]->id;
		}else{
				return false;		
		}	
		
	}

	function create_cities($image_data=null)
	{ 
		$selected_country = $this->input->post('select_country');
		$selected_state = $this->input->post('select_state');
		$image_file_name='';
		$image_name='';
		if(isset($image_data))
		{
		$image_file_name=$image_data['upload_data']['file_name'];
		$image_dir=$this->config->item('cities_icon_url');
		}
		$new_city_insert_data = array(
			'name' =>$this->input->post('add_city'),						
			'created'=>date("Y-m-d h:i:s", time()),
			'modified'=>date("Y-m-d h:i:s", time()),
			'state_id'=>$selected_state ,
			'country_id'=>$selected_country ,
			'is_active'=>$this->input->post('is_active'),
			'city_image'=>$image_file_name,
			'image_dir'=>$image_dir,
			'meta_title' 	=> $this->input->post('meta_title'),
			'meta_description'	=> $this->input->post('meta_description'),
			'meta_city_area_title' 		=> $this->input->post('meta_city_area_title'),
			'meta_city_area_description'		=> $this->input->post('meta_city_area_description'),
		);
		$this->db->insert('cities', $new_city_insert_data);
		$insert = $this->db->insert_id() ;
		return $insert;
	}
	function remove_images($id=null)
	{
		$this->db->delete('city_images',array('id' => $id));
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	public function get_cities_list($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start=null, $limit_end=null)
	{  
		$this->db->select('countries.name as c_name,states.name as s_name,cities.id,cities.name as cs_name, cities.created, cities.is_active, cities.featured_city,cities.is_home_city');
		$this->db->join('countries', 'cities.country_id = countries.id','left'); 
		$this->db->join('states', 'cities.state_id = states.id','left'); 
		$this->db->from('cities');	
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
			$this->db->order_by('cities.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
		//echo $limit_start.$limit_end; die;
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array();
				
		}
		else{
				$query = $this->db->get();		
				return $query->num_rows();        
		}
	 }
		
	public function update_status($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('cities', $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	public function update_featured($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('cities', $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	public function update_en_start_your($id, $data)
	{
		if($data['is_home_city']==0)
		{
	    $this->db->where('id', $id);
		$this->db->update('cities', $data);
		if($report !== 0)
		{
				return "inactive-success";
		}
		}
		else
		{
		$this->db->select('*');
	    $this->db->where('cities.id', $id);
		$this->db->join('city_images', 'city_images.city_id = cities.id','left'); 
		$this->db->join('states', 'cities.state_id = states.id','left'); 
		$this->db->from('cities');
		$query = $this->db->get();		
		$count=$query->num_rows();  
		if($count >=1)
		{
		$this->db->where('id', $id);
		$this->db->update('cities', $data);
		$data=array('is_home_city'=>0);
		$this->db->where('id !=', $id);
		$this->db->update('cities', $data);
		return "active-success";
		}
		else
		{
		return 	 "need-tofill";
		}
    	}
	}
	function get_cities_by_id($slug=false)
	{	

		$this->db->where('cities.id', $slug); 
		$this->db->select('countries.id as c_id,countries.name as c_name,
				states.id as s_id ,states.name as s_name,cities.id as city_id ,
				cities.name as city_name,cities.is_home_city,cities.is_active,cities.city_image,cities.image_dir,cities.meta_title,cities.meta_description,cities.meta_city_area_title,cities.meta_city_area_description');
		$this->db->join('states', 'cities.state_id = states.id','left'); 
		$this->db->join('countries', 'cities.country_id = countries.id','left'); 
		$query = $this->db->get('cities');		
		$result = $query->result();
		foreach($result as $g) 
		{
			$arr[]=array('city_image'=>$g->city_image,'image_dir'=>$g->image_dir,'value'=> ucfirst($g->s_name),'id'=>$g->s_id,'c_value'=> ucfirst($g->c_name),'c_id'=>$g->c_id,'city_value'=> ucfirst($g->city_name),'city_id'=>$g->city_id ,'is_active'=>$g->is_active,'home_city'=>$g->is_home_city,'meta_title'=>$g->meta_title,'meta_description'=>$g->meta_description,'meta_city_area_title'=>$g->meta_city_area_title,'meta_city_area_description'=>$g->meta_city_area_description);
		}
		return $arr;
	}

	function get_cities($state_id=false)
	{			
		
		$this->db->where('state_id', $state_id); 	
		$this->db->where('is_active',1); 	
		$this->db->order_by('cities.name','ASC' );
		$query = $this->db->get('cities');		
		$result = $query->result();		
		$arr = array();
		foreach($result as $g) {
			$arr[$g->id]= ucfirst($g->name);
		}
		
		return $arr;
	}
	
	function edit($image_data)
	{ 	
	   if(!empty($image_data))
		{
		$image_file_name=$image_data['upload_data']['file_name'];
		$image_dir=$this->config->item('cities_icon_url');
		}
		$_data = array(
		 	'name'=> $this->input->post('add_city'),
			'country_id' => $this->input->post('select_country'),
			'state_id' => $this->input->post('select_state'),
			'is_active'=>$this->input->post('is_active'),
			'meta_title' 	=> $this->input->post('meta_title'),
			'meta_description'	=> $this->input->post('meta_description'),
			'meta_city_area_title' 		=> $this->input->post('meta_city_area_title'),
			'meta_city_area_description'		=> $this->input->post('meta_city_area_description'),
		);
		if($image_data!="") {
			$_data +=$image_data;
		}
		
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('cities', $_data);
		
	   	return $update;
	}
	public function delete($id) 
	{
		$this->db->delete('cities',array('id' => $id));
		$this->db->delete('areas',array('city_id' => $id));
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}
		else
		{
				return false;
		}
	}
	function get_auto_cities() 
	{
		$query_str = $_POST['keys'];
		if($query_str) 
		{
			$this->db->like('name', $query_str,'after'); 
		}
		$this->db->where('country_id',$_POST['country']);
		$this->db->where('state_id',$_POST['state']);
		$this->db->where('is_active','1');
		$this->db->select('id,name');
		$query = $this->db->get('cities');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}
		return $arr;
	}
	
	public function get_add_cities($keyword)
	{
		$arr = array();
		if($keyword) 
		{
			$this->db->like('name', $keyword,'after'); 
		}
		else{
			return $arr;
		}
		$this->db->select('id,name');
		$query = $this->db->get('cities');		
		$result = $query->result();	
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}
		return $arr;
	}
	
	function get_city_detail($id=null)
	{
	     $this->db->where('cities.id', $id); 
	     $this->db->select('countries.id as c_id,countries.name as c_name,
				states.id as s_id ,states.name as s_name,cities.id as city_id ,
				cities.name as city_name, cities.is_active');	
		$this->db->join('states', 'cities.state_id = states.id','left'); 
		$this->db->join('countries', 'cities.country_id = countries.id','left'); 
		$query = $this->db->get('cities');		
		$result = $query->row_array();
		return $result;
	}
	
}
?>
