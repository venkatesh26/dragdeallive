<?php
class Remainder_histroy_model extends CI_Model {
	
	###### CAMPAIGN DELETE ###########
	public function delete($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('remainder_histroy');
		$res = $query->row();
		$this->db->delete('remainder_histroy',array('id' => $id));	
	}
	
	####### Admin Details #########
	public function get_histroy_detail($id){
		$this->db->select('remainder_histroy.*,users.email,users.contact_number,remainder_settings.name,remainder_settings.remainder_period_type,remainder_settings.remainder_type_id,remainder_settings.message,remainder_settings.no_of_days');
		$this->db->where('remainder_histroy.id',$id);
		$this->db->from('remainder_histroy');
		$this->db->join('remainder_settings', 'remainder_settings.id = remainder_histroy.remainder_settings_id', 'left');	
		$this->db->join('users','users.id=remainder_histroy.user_id');
		$this->db->order_by('remainder_histroy.id','DESC');
		$query = $this->db->get();
		$result = $query->row_array();	
		return $result;
	}
	
	
	public function get_remainder_histroy($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) {  
		$this->db->select('remainder_histroy.*,users.email,users.contact_number,remainder_settings.name');
		$this->db->from('remainder_histroy');
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
		$this->db->join('remainder_settings', 'remainder_settings.id = remainder_histroy.remainder_settings_id', 'left');		
		$this->db->join('users', 'users.id = remainder_histroy.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = remainder_histroy.user_id', 'left');
		if(!$sort_field)
			$this->db->order_by('remainder_histroy.id', $order_type);
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
}
?>