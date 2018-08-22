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
	
		
		
	################ Get My Vendor List ####################
	public function getMyVendorList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS advertisment_customer_lists.id,advertisment_customer_lists.total_amount, advertisment_customer_lists.parent_user_id,advertisment_customer_lists.id,advertisment_customer_lists.created, advertisements.name as shop_name, advertisements.email AS contact_email, advertisements.contact_number as contact_phone_number',false);
		if(isset($_POST['s_name']) && $_POST['s_name']!=''){
			$this->db->like('advertisements.name',$_POST['s_name'],'after'); 		
		}
		$this->db->join('advertisements','advertisements.user_id=advertisment_customer_lists.parent_user_id', 'LEFT');
		$this->db->where('advertisment_customer_lists.customer_id',$userId);
		$this->db->from('advertisment_customer_lists');
		$this->db->order_by('advertisment_customer_lists.created','DESC');
		$this->db->limit($limit_start, $limit_end);
		$this->db->group_by('advertisment_customer_lists.customer_id');
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
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
		return true;
	}
	public function delete($id) {
		$this->db->delete('advertisment_customer_lists',array('id' => $id));
		return true;
	}
}
?>