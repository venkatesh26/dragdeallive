<?php
class Notification_model extends CI_Model {

	public function common_save_notification($type,$data) {

		$notification_type=$this->getNotificationTypes($type);
		$title=$notification_type['template_title'];
		$message=$notification_type['template'];
		if(isset($data['username']) && $data['username']!=''){
			$message=str_replace('##NAME##',$data['username'],$message);
		}
		if(isset($data['email']) && $data['email']!=''){
			$message=str_replace('##EMAIL##',$data['email'],$message);
		}
		if(isset($data['email']) && $data['email']!=''){
			$message=str_replace('##COUNT##',$data['username'],$message);
		}
		if(isset($data['browser']) && $data['browser']!=''){
			$message=str_replace('##BROWSER##',$data['browser'],$message);
		}
		if(isset($data['city']) && $data['city']!=''){
			$message=str_replace('##CITY##',$data['city'],$message);
		}
		if(isset($data['ip']) && $data['ip']!=''){
			$message=str_replace('##IP##',$data['ip'],$message);
		}
		if(isset($data['sender_id']) && $data['sender_id']!=''){
			$message=str_replace('##SENDERID##',$data['sender_id'],$message);
		}
		$notification_id=$notification_type['id'];
		$notification_data = array(
			'created'	=> date('Y-m-d h:i:s'),
			'modified' 	=> date('Y-m-d h:i:s'),
			'from_user_id' 	=> 1,
			'to_user_id'   =>$data['user_id'],
			'notification_type' =>$notification_id,
			'title' =>$title,
			'message' =>$message,
			'is_read' =>0,
		);
		$this->db->insert('notifications', $notification_data);
		return true;
	}
	
	public function getNotificationTypes($type) {
		$this->db->select('notification_type.*');
		$this->db->where('notification_type.code',$type);
		$this->db->from('notification_type');
		$query = $this->db->get();
		$result=$query->row_array();
		return $result;
	} 
	
	##### Notification List ############
	public function getMyNotificationList($user_id, $limit_start, $limit_end) {
		
		$this->db->select('SQL_CALC_FOUND_ROWS notifications.id,notifications.*',false);
		$this->db->where('notifications.to_user_id',$user_id);
		$this->db->from('notifications');
		$this->db->order_by('notifications.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
}
?>
