<?php
class User_logins_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */

	public function get_user_logins($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('user_logins.id, user_logins.created ,user_logins.ip, users.email, users.user_type');
		$this->db->join('users', 'user_logins.user_id = users.id'); 
		$this->db->where('is_deleted', 0);
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
			$this->db->order_by('user_logins.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get('user_logins');		
				return $query->result_array(); 
		}
		else{
				$query = $this->db->get('user_logins');		
				return $query->num_rows();        
		}
	}
	
	public function delete($id,$data) {
		$this->db->where('id', $id);
		$this->db->update('user_logins', $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
}
?>