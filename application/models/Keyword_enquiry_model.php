<?php
class Keyword_Enquiry_model extends CI_Model {

	function get_all_rows() {	
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	function get_enquiry_detail($id) {
		$this->db->select('keyword_enquiry.*');
		$this->db->where('keyword_enquiry.id', $id);
		$query = $this->db->get('keyword_enquiry');
		$results=$query->row_array(); 
		return $results;
	}
	
	public function get_keyword_enquiry_list($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$type) {  
		$this->db->select('keyword_enquiry.*');
		$this->db->from('keyword_enquiry');
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
			$this->db->order_by('keyword_enquiry.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type); 

		if($flag == 1){
			    $this->db->group_by('keyword_enquiry.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();			
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('keyword_enquiry.id');	
				$query = $this->db->get();				
				return $query->num_rows();        
		}
	}
	
	function get_values($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('keyword_enquiry');
		return $query->row_array();
	}
	
    	
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('keyword_enquiry', $data);
		return true;
	}
	public function delete($id) {
		$this->db->delete('keyword_enquiry',array('id' => $id));
		return true;
	}
}
?>