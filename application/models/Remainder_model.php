<?php
class Remainder_model extends CI_Model {
	
	
	###### CAMPAIGN DELETE ###########
	public function delete($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('remainder_settings');
		$res = $query->row();
		$this->db->delete('remainder_settings',array('id' => $id));	
	}
	
	###### Update Status ###########
	public function update_status($id, $data){
		$this->db->where('id', $id);
		$this->db->update('remainder_settings', $data);
		return true;
	}
	
	########### Statistics Data#############
	public function getStatisticsData($user_id,$limit_start,$limit_end) {

		$this->db->select('SQL_CALC_FOUND_ROWS remainders.id,remainders.*,remainder_settings.name as campaign_title,users.contact_number,users.email',false);
		$this->db->where('remainders.parent_user_id',$user_id);
		$this->db->limit($limit_start, $limit_end);
		$this->db->from('remainders');
	    $this->db->join('remainder_settings','remainder_settings.id=remainders.remainder_setting_id','left');
		$this->db->join('users','users.id=remainders.user_id','left');
		$this->db->order_by('remainders.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();	
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}
	
	########### Statistics Data#############
	public function getRemainderCampaignTrackList($user_id,$limit_start,$limit_end) {
		$this->db->select('SQL_CALC_FOUND_ROWS remainders.id,remainders.*,remainder_settings.name as campaign_title,users.contact_number,users.email',false);
		$this->db->where('remainders.parent_user_id',$user_id);
		$this->db->limit($limit_start, $limit_end);
		$this->db->from('remainders');
	    $this->db->join('remainder_settings','remainder_settings.id=remainders.remainder_setting_id','left');
		$this->db->join('users','users.id=remainders.user_id','left');
		$this->db->order_by('remainders.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();	
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}	
	
	####### Admin Details #########
	public function get_remainder_detail($id){
		$this->db->select('remainder_settings.*,users.email,users.contact_number');
		$this->db->where('remainder_settings.id',$id);
		$this->db->from('remainder_settings');
		$this->db->join('users','users.id=remainder_settings.user_id');
		$this->db->order_by('remainder_settings.id','DESC');
		$query = $this->db->get();
		$result = $query->row_array();	
		return $result;
	}
	
	public function get_remainder($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) {  
		$this->db->select('remainder_settings.*,users.email,users.contact_number');
		$this->db->from('remainder_settings');
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
		$this->db->join('users', 'users.id = remainder_settings.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = remainder_settings.user_id', 'left');
		if(!$sort_field)
			$this->db->order_by('remainder_settings.id', $order_type);
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
	
   ####### Customer Service Remainder List#####
   public function customer_remainder_data($keyword,$user_id){

		$this->db->select('SQL_CALC_FOUND_ROWS remainder_settings.id,remainder_settings.*',false);
		if($keyword) 
		{
			$this->db->like('remainder_settings.name', $keyword,'after'); 
		}
		$this->db->where('remainder_settings.user_id',$user_id);
		$this->db->where('remainder_settings.is_active',1);
		$this->db->where('remainder_settings.remainder_type_id',3);
		$query = $this->db->get('remainder_settings');
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'text'=>$g->name,'label'=>$g->name,'id'=>$g->id);
		}
		return $arr;
    }
	
	public function getRemainderData($id,$user_id) {
		$this->db->select('remainder_settings.*',false);
		$this->db->where('remainder_settings.user_id',$user_id);
		$this->db->where('remainder_settings.id',$id);
		$query = $this->db->get('remainder_settings');
		$result = $query->row_array();	
		return $result;
	}
	
	public function get_user_remainder_data() {
		$this->db->select('remainder_settings.name,remainder_settings.id');
		$this->db->from('remainder_settings');
		$query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['name']);	
		}	
		return $new_results;
  }
	
	public function saveRemainders($user_id,$id=null){
		
		$isActive=($this->input->post('is_active')=='on') ? 1:0; 
		$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$this->input->post('name'),
			'remainder_type_id'=>$this->input->post('remainder_type_id'),
			'remainder_period_type'=>$this->input->post('remainder_period_type'),
			'no_of_days'=>$this->input->post('no_of_days'),
			'user_id'=>$user_id,
			'message'=>$this->input->post('message'),
			'url'=>$this->input->post('url'),
			'shorten_url'=>$this->input->post('shorten_url'),
			'coupon_code'=>$this->input->post('coupon_code'),
			'coupon_type'=>$this->input->post('coupon_type'),
			'is_active'=>$isActive,
			'custom_service_date'=>$this->input->post('custom_service_date'),
			'is_custom_servicedate'=>$this->input->post('is_custom_servicedate'),
		);
		if($id > 0) {
			$this->db->where('id', $id);
			$this->db->update('remainder_settings', $table_data);
		} else {
			$this->db->insert('remainder_settings', $table_data);	
		}		
		$result=array('id'=>$this->db->insert_id(),'status'=>1);
		return $result;		
	}
	
	public function getMyRemainderList($userId,$limit_start,$limit_end) {
		$this->db->select('SQL_CALC_FOUND_ROWS remainder_settings.id,remainder_settings.*',false);
		$this->db->where('remainder_settings.user_id',$userId);
		$this->db->from('remainder_settings');
		$this->db->order_by('remainder_settings.id','DESC');
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
	
	function getHistroyData($userId,$limit_start,$limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS remainder_histroy.id,remainder_histroy.*,remainder_settings.name,remainder_settings.remainder_type_id',false);
		$this->db->where('remainder_histroy.user_id',$userId);
		$this->db->from('remainder_histroy');
		$this->db->join('remainder_settings','remainder_histroy.remainder_settings_id=remainder_settings.id');
		$this->db->order_by('remainder_histroy.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
		
	}
}
?>