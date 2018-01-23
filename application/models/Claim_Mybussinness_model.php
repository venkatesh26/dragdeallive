<?php
class claim_mybussinness_model extends CI_Model {
 
 
    public function __construct(){
        $this->load->database();
    }

	##############  GET User Details #############
	public function get_user_details($email=null) {
		
		$response=array();
		$this->db->select('users.email,users.id');
		$this->db->where('users.email', $email);
		$usersquery = $this->db->get('users');		
		$response['request_usersdetails']=$usersquery->row_array(); 
		if(isset($response['request_usersdetails']['id'])) {
			
			$this->db->select('advertisements.email,advertisements.id,advertisements.user_id');
			$this->db->where('advertisements.user_id', $response['request_usersdetails']['id']);
			$query = $this->db->get('advertisements');		
			$response['add_usersdetails']=$query->row_array(); 
			if(!isset($response['add_usersdetails']['id']) || empty($response['add_usersdetails']['id'])){
				$this->db->select('advertisements.email,advertisements.id,advertisements.user_id');	
				$this->db->where('advertisements.email', $email);
				$query = $this->db->get('advertisements');		
				$response['current_add_usersdetails']=$query->row_array(); 
			}
		}
		return $response;
	}
	
	public function get_claim_my_bussiness($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('claim_my_bussiness.id, claim_my_bussiness.name, claim_my_bussiness.created,claim_my_bussiness.contact_number,claim_my_bussiness.email,claim_my_bussiness.is_account,claim_my_bussiness.is_resolved');
		$this->db->from('claim_my_bussiness');
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
			$this->db->order_by('claim_my_bussiness.id', $order_type);
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
		$this->db->select('claim_my_bussiness.id, claim_my_bussiness.name, claim_my_bussiness.created,claim_my_bussiness.contact_number,claim_my_bussiness.email,claim_my_bussiness.description,claim_my_bussiness.is_resolved,claim_my_bussiness.url,claim_my_bussiness.is_account');
		$this->db->where('claim_my_bussiness.id', $id);
		$query = $this->db->get('claim_my_bussiness');
		return $query->row_array();
	}
		
	public function update_status($id, $data) 
	{
		$this->db->where('id', $id);
		$this->db->update('contact_us', $data);
		return true;
	}
	
	public function delete($id) {
		$this->db->delete('claim_my_bussiness',array('id' => $id));
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
	
	public function add(){
	    $data = array(
			'email'			=> strtolower($this->input->post('email')),			
 			'password'		=> md5($this->input->post('password')),
			'display_name' => $this->input->post('username'),
			'user_type'		=>3,
			'is_approved' 	=> 1,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => 1,
			'is_active'		=> 1,
			'is_email_confirmed'=> 1,
			'uid'			=> '1234567',			
		);
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		if($id) {
			$data = array(
				'user_id'			=> $id,	
				'mobile_number'		=> $this->input->post('mobile_number'),
				'first_name'		=> $this->input->post('username'),	
				'last_name'		=> $this->input->post('username'),
				'created'			=> date('Y-m-d h:i:s'),
				'modified'			=> date('Y-m-d h:i:s'),
			);
			$this->db->insert('user_profiles', $data);
		}
		$add_datas=array();
		$add_datas['is_active']=0;
		$add_datas['user_id']=$id;
		$this->db->where('advertisements.id', $this->input->post('advertisment_id'));
		$this->db->update('advertisements', $add_datas);
		
		$claim_datas=array();
		$claim_datas['is_resolved']=1;
		$this->db->where('claim_my_bussiness.id', $this->input->post('claim_id'));
		$this->db->update('claim_my_bussiness', $claim_datas);
		return (isset($id)) ? $id : FALSE;
	}
	
	public function update_account(){
		
		$add_datas=array();
		$add_datas['is_active']=0;
		$add_datas['user_id']=$this->input->post('user_id');
		$this->db->where('advertisements.id', $this->input->post('advertisment_id'));
		$this->db->update('advertisements', $add_datas);
		
		$claim_datas=array();
		$claim_datas['is_resolved']=1;
		$this->db->where('claim_my_bussiness.id', $this->input->post('claim_id'));
		$this->db->update('claim_my_bussiness', $claim_datas);
		return (isset($id)) ? $id : FALSE;
	}
}
?>