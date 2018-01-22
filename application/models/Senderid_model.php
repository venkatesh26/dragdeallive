<?php
class Senderid_model extends CI_Model {
 
    public function __construct()
    {
    }
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}

	public function get_senderid($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) 
	{  
		$this->db->select('user_sender_ids.*,users.email,user_profiles.first_name,users.display_name');
		$this->db->from('user_sender_ids');
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
		$this->db->join('users', 'users.id = user_sender_ids.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = user_sender_ids.user_id', 'left');
		if(!$sort_field)
			$this->db->order_by('user_sender_ids.id', $order_type);
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
	public function delete($id) 
	{
		$this->db->select('id');
		$this->db->where('id',$id);
		$query = $this->db->get('user_sender_ids');
		$res = $query->row();
		$this->db->delete('user_sender_ids',array('id' => $id));
		$report = array();
		if($report !== 0) {
			return true;
		} else {
			return false;
		}
	}
	public function update_status($id, $data) 
	{
		$this->db->where('id',$id);
		$query = $this->db->get('user_sender_ids');
		$res = $query->row_array();
		
		$this->db->where('id', $id);
		$this->db->update('user_sender_ids', $data);	
		$report = array();
		
		########## Notifications Model ##############
		$this->load->model('notification_model');
		$userinfo=user_profile_info($res['user_id']);
		$username=$userinfo['name'];
		$sender_id=$res['sender_id'];
		$new_data=array('username'=>$username, 'user_id'=>$res['user_id'], 'sender_id'=>$sender_id);
		$sender_code='sender-id-decline';
		if($data['is_active']==1){
			$sender_code='sender-id-accept';
		}
		$this->notification_model->common_save_notification($sender_code, $new_data);

		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	function changeStatus($id,$is_active){
		$data=array('is_active'=>$is_active);
		$this->db->where('id', $id);
		$this->db->update('user_sender_ids', $data);
		return true;
	}
}
?>