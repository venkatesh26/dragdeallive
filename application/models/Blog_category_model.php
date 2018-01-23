<?php
class Blog_category_model extends CI_Model {
 
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
			$this->db->like('blog_category.name', $query_str[1],'after'); 
		}

		$this->db->where('blog_category.is_active','1');
		$this->db->select('blog_category.id,blog_category.name');
  	    $query = $this->db->get('blog_category');	
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}	
		return $arr;
	}

	public function get_categories($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('blog_category.id, blog_category.name, blog_category.created,blog_category.is_active');
		$this->db->from('blog_category');
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
			$this->db->order_by('blog_category.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			    $this->db->group_by('blog_category.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('blog_category.id');	
				$query = $this->db->get();	
			
				return $query->num_rows();        
		}
	 }
	function get_values($id) {
		$this->db->select('id, name,is_active');
		$this->db->where('id', $id);
		$query = $this->db->get('blog_category');
		return $query->row_array();
	}
    public function add_new() {
		$data = array(
				'name'			=> $this->input->post('name'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
			);
		$this->db->insert('blog_category', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	public function edit($id) {
		$data = array(
				'name'			=> $this->input->post('name'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
			);
		$this->db->where('id', $id);
		$this->db->update('blog_category', $data);
	}
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('blog_category', $data);
		return true;
	}
	public function delete($id) {
		$this->db->delete('blog_category',array('id' => $id));
		return true;
	}
	public function amenities_auto_list($q) {
		$this->db->from('blog_category');
		$this->db->like('blog_category.name', $q,'after');
		$this->db->where('blog_category.is_active', 1);
		$query=$this->db->get();
		return $query->result_array(); 
	}
	public function categories_id($q) {
		$this->db->from('blog_category');
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
}
?>