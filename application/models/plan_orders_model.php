<?php
class Plan_orders_model extends CI_Model {
 

	public function get_plan_orders($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('plan_order.*, plans.name as plan_name,plans.price,user_profiles.first_name as customer_name');
		$this->db->from('plan_order');
		$this->db->join('plans','plan_order.plan_id=plans.id','left');	
		$this->db->join('users','plan_order.user_id=users.id','left');	
		$this->db->join('user_profiles','user_profiles.user_id=users.id','left');	
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
			$this->db->order_by('plan_order.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			    $this->db->group_by('plan_order.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('plan_order.id');	
				$query = $this->db->get();	
			
				return $query->num_rows();        
		}
	 }
	 
	public function delete($id) {
		$this->db->delete('plan_order',array('id' => $id));
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