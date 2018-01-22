<?php
class Main_category_model extends CI_Model {
 
 
    public function __construct()
    {
        $this->load->database();
    }

	function getmain_category($offer_page=null) 
	{
		$query_str = $_SERVER['QUERY_STRING'];
		if($query_str) {
			$query_str=explode("=",$query_str );
			$this->db->like('main_category.name', $query_str[1],'after'); 
		}

		$this->db->where('main_category.is_active','1');
		$this->db->select('main_category.id,main_category.name');
  	    $query = $this->db->get('main_category');	
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}	
		return $arr;
	}

	public function get_main_category($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('main_category.id, main_category.name, main_category.created,main_category.is_active');
		$this->db->from('main_category');
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
			$this->db->order_by('main_category.id', $order_type);
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
	function get_values($id) {
		$this->db->select('id, name,font_name,is_active');
		$this->db->where('id', $id);
		$query = $this->db->get('main_category');
		return $query->row_array();
	}
    public function add_new() {
		$data = array(
				'name'			=> $this->input->post('name'),
				'font_name'			=> $this->input->post('font_name'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
			);
		$this->db->insert('main_category', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	public function edit($id) {
		$data = array(
				'name'			=> $this->input->post('name'),
				'font_name'			=> $this->input->post('font_name'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
			);
		$this->db->where('id', $id);
		$this->db->update('main_category', $data);
	}
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('main_category', $data);
		
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
		$this->db->delete('main_category',array('id' => $id));
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	public function amenities_auto_list($q) {
		$this->db->from('main_category');
		$this->db->like('main_category.name', $q,'after');
		$this->db->where('main_category.is_active', 1);
		$query=$this->db->get();
		return $query->result_array(); 
	}
	public function main_category_id($q) {
		$this->db->from('main_category');
		$this->db->where('name', $q);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->id;
	} 
}
?>