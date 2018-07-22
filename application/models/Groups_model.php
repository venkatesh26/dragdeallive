<?php
class Groups_model extends CI_Model {

	public function get_add_groups($keyword,$user_id)
	{
		if($keyword) 
		{
			$this->db->like('name', $keyword,'after'); 
		}
		$this->db->where('is_active','1');
		$this->db->where('user_id',$user_id);
		$this->db->select('id,name');
		$query = $this->db->get('groups');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}
		return $arr;
	}
	
	##### Enquiry List ############
	public function getMyGroupList($user_id, $limit_start, $limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS groups.id,groups.*',false);
		$this->db->where('groups.user_id',$user_id);
		$this->db->from('groups');
		$this->db->order_by('groups.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}
	
	########## Save Group #########
	public function saveGroup($user_id){
		
		$is_active=($this->input->post('is_active')=="on") ? 1:0;
		$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$this->input->post('name'),
			'user_id'=>$user_id,
			'is_active'=>$is_active,
		);
		$this->db->insert('groups', $table_data);			
		return $this->db->insert_id();	
	}
	
	########## Save Group #########
	public function updateGroup($id,$user_id){
		
		$is_active=($this->input->post('is_active')=="on") ? 1:0;
		$table_data=array(
			'modified'=>date('Y-m-d h:i:s'),
			'name'=>$this->input->post('name'),
			'user_id'=>$user_id,
			'is_active'=>$is_active,
		);
		$this->db->where('id',$id);
		$this->db->update('groups', $table_data);			
		return true;
	}
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	function getValues($id,$user_id){
		$this->db->select('groups.*');
		$this->db->where('groups.user_id',$user_id);
		$this->db->where('groups.id',$id);
		$this->db->from('groups');
		$query = $this->db->get();
		return $result=$query->row_array();
	}
	
		
	########## Find Or Save Customer #######
	public function findOrSaveGroup($parent_user_id,$name){
		if($name==''){
			return 0;
		}
		$this->db->select('groups.id');
		$this->db->where('groups.user_id',$parent_user_id);
		$this->db->where('groups.name',$name);
		$this->db->from('groups');
		$query = $this->db->get();			
		$result=$query->row_array();
		if($result){
		  return $result['id'];	
		}
		else{
			$table_data=array(
				'created'=>date('Y-m-d h:i:s'),
				'name'=>$name,
				'user_id'=>$parent_user_id,
				'is_active'=>1,
			);
			$this->db->insert('groups', $table_data);			
			return $this->db->insert_id();	
		}
	}
}
?>
