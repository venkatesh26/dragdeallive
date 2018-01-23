<?php
class Feed_back_model extends CI_Model {
 
    public function __construct()
    {
        $this->load->database();
    }
	
	public function get_feed_backs($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) 
	{  
		$this->db->select('feed_backs.id,feed_backs.created, feed_backs.message,user_profiles.first_name as name');
		$this->db->from('feed_backs');
		$this->db->join('user_profiles', 'user_profiles.user_id = feed_backs.user_id', 'left');
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
			$this->db->order_by('feed_backs.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			     if($limit_end!='-10')
				 {
				$this->db->limit($limit_start, $limit_end);
				 }
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
				$query = $this->db->get();		
				return $query->num_rows();        
		}
	 }
	function get_values($id) {
		$this->db->select('feed_backs.id,feed_backs.created, feed_backs.message,user_profiles.first_name as name');
		$this->db->join('user_profiles', 'user_profiles.user_id = feed_backs.user_id', 'left');
		$this->db->where('feed_backs.id', $id);
		$query = $this->db->get('feed_backs');
		return $query->row_array();
	}
	
	public function delete($id) 
	{
		$this->db->delete('feed_backs',array('id' => $id));
		return true;
	}
}
?>