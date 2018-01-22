<?php
class Notification_type_model extends CI_Model {
    
	############## Notification Type ###################
	public function get_notifications_type($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('notification_type.*');
		$this->db->from('notification_type');
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
			$this->db->order_by('notification_type.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			    $this->db->group_by('notification_type.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('notification_type.id');	
				$query = $this->db->get();	
			
				return $query->num_rows();        
		}
	}
	
	
	###### Add New ########
    public function add_new() {
		$data = array(
				'name'	=> $this->input->post('name'),
				'modified' 	=> date('Y-m-d h:i:s'),
				'modified' 	=> date('Y-m-d h:i:s'),
				'code' 		=> $this->input->post('code'),
				'name'		=> $this->input->post('name'),
				'template_title	' => $this->input->post('template_title'),
				'template'	=> $this->input->post('template'),
		);
		$this->db->insert('notification_type', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	
	####### Update Notification Type ##########
	public function edit($id) {
		$data = array(
				'name'	=> $this->input->post('name'),
				'modified' 	=> date('Y-m-d h:i:s'),
				'code' 		=> $this->input->post('code'),
				'name'		=> $this->input->post('name'),
				'template_title	' => $this->input->post('template_title'),
				'template'	=> $this->input->post('template'),
		);
		$this->db->where('id', $id);
		$this->db->update('notification_type', $data);
	}
	
	######### Delete Notification Type #########
	public function delete($id) {
		$this->db->delete('notification_type',array('id' => $id));
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}

	function get_values($id) {
		$this->db->select('notification_type.*');
		$this->db->where('id', $id);
		$query = $this->db->get('notification_type');
		return $query->row_array();
	}
}
?>