<?php
class Advertisment_Customer_List_model extends CI_Model {
 
	function get_all_rows() {	
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	function get_enquiry_detail($id) {
		$this->db->select('advertisment_customer_lists.*');
		$this->db->where('advertisment_customer_lists.id', $id);
		$query = $this->db->get('advertisment_customer_lists');
		$results=$query->row_array(); 
		return $results;
	}
	
	public function advertisment_customer_lists($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$type) {  
		$this->db->select('advertisment_customer_lists.*');
		$this->db->from('advertisment_customer_lists');
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
			$this->db->order_by('advertisment_customer_lists.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type); 

		if($flag == 1){
			    $this->db->group_by('advertisment_customer_lists.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();			
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('advertisment_customer_lists.id');	
				$query = $this->db->get();				
				return $query->num_rows();        
		}
	}
	
	function get_values($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('advertisment_customer_lists');
		return $query->row_array();
	}
	
    	
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('advertisment_customer_lists', $data);
		
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
		$this->db->delete('advertisment_customer_lists',array('id' => $id));
		return true;
	}
}
?>