<?php
class Advertisment_Coupon_List_model extends CI_Model {
 
	function get_all_rows() {	
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	function get_enquiry_detail($id) {
		$this->db->select('coupons.*');
		$this->db->where('coupons.id', $id);
		$query = $this->db->get('coupons');
		$results=$query->row_array(); 
		return $results;
	}
	
	public function advertisment_coupons_lists($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$type) {  
		$this->db->select('coupons.*');
		$this->db->from('coupons');
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
			$this->db->order_by('coupons.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type); 

		if($flag == 1){
			    $this->db->group_by('coupons.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();			
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('coupons.id');	
				$query = $this->db->get();				
				return $query->num_rows();        
		}
	}
	
	function get_values($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('coupons');
		return $query->row_array();
	}
	
    	
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('coupons', $data);
		
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
		$this->db->delete('coupons',array('id' => $id));
		return true;
	}
}
?>