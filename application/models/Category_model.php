<?php
class Category_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
      
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */

	function getcategories($offer_page=null) {
		$query_str = $_SERVER['QUERY_STRING'];
		if($query_str) {
			$query_str=explode("=",$query_str );
			$this->db->like('categories.name', $query_str[1],'after'); 
		}

		$this->db->where('categories.is_active','1');
		$this->db->select('categories.id,categories.name');
  	    $query = $this->db->get('categories');	
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}	
		return $arr;
	}

	public function get_categories($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('categories.id, categories.name, categories.created,categories.is_active,categories.is_popular');
		$this->db->from('categories');
		if(!empty($conditions))
		{ 
				foreach($conditions as $key=>$cond)
				{
					if(!$cond['direct'])
						$this->db->where($cond['field'], $cond['value']);
					else
					  $this->db->$cond['rule']($cond['value']);
				}
		}	
		if(!$sort_field)
			$this->db->order_by('categories.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			    $this->db->group_by('categories.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('categories.id');	
				$query = $this->db->get();	
			
				return $query->num_rows();        
		}
	 }
	function get_values($id) {
		$this->db->select('categories.*');
		$this->db->where('id', $id);
		$query = $this->db->get('categories');
		return $query->row_array();
	}
    public function add_new() {
		$data = array(
				'name'			=> $this->input->post('name'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'parent' 		=> $this->input->post('select_category'),
				'is_active'		=> $this->input->post('is_active'),
				'meta_title' 	=> $this->input->post('meta_title'),
				'meta_description'	=> $this->input->post('meta_description'),
				'meta_city_title' 		=> $this->input->post('meta_city_title'),
				'meta_city_description'		=> $this->input->post('meta_city_description'),
				'meta_city_area_title' 		=> $this->input->post('meta_city_area_title'),
				'meta_city_area_description'		=> $this->input->post('meta_city_area_description'),
			);
		$this->db->insert('categories', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	public function edit($id) {
		$data = array(
				'name'			=> $this->input->post('name'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'parent' 		=> $this->input->post('select_category'),
				'is_active'		=> $this->input->post('is_active'),
				'meta_title' 	=> $this->input->post('meta_title'),
				'meta_description'	=> $this->input->post('meta_description'),
				'meta_city_title' 		=> $this->input->post('meta_city_title'),
				'meta_city_description'		=> $this->input->post('meta_city_description'),
				'meta_city_area_title' 		=> $this->input->post('meta_city_area_title'),
				'meta_city_area_description'		=> $this->input->post('meta_city_area_description'),
			);
		$this->db->where('id', $id);
		$this->db->update('categories', $data);
	}
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('categories', $data);
		return true;
	}
	public function delete($id) {
		$this->db->delete('categories',array('id' => $id));
		return true;
	}
	
	public function amenities_auto_list($q) {
		$this->db->from('categories');
		$this->db->like('categories.name', $q,'after');
		$this->db->where('categories.is_active', 1);
		$query=$this->db->get();
		return $query->result_array(); 
	}
	public function categories_id($q) {
		$this->db->from('categories');
		$this->db->where('name', $q);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->id;
	} 
	
	public function get_main_category($slug=false)
	{	
		if($slug){
			$this->db->where('id', $slug); 
		}else{
			$this->db->where('is_active',1); 	
		}
		$this->db->select('id,name');		
		$this->db->order_by('main_category.name','ASC' );
		$query = $this->db->get('main_category');	
		
		$result = $query->result();	
		
		$arr = array();
		foreach($result as $g) 
		{
					$arr[$g->id]=ucfirst($g->name);
		}
		return $arr;
	}
	
	public function get_main_category_new($keyword=false)
	{	
			if($keyword) 
			{
				$this->db->like('name', $keyword,'after'); 
			}
			$this->db->where('is_active','1');
			$this->db->select('id,name');
			$query = $this->db->get('main_category');		
			$result = $query->result();	
			$arr = array();
			foreach($result as $g) 
			{
				$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
			}
			return $arr;
	}
}
?>