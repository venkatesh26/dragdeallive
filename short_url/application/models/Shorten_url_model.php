<?php
class Shorten_url_model extends CI_Model {

	#Magic Method - Construct the object
    public function __construct() {
        parent::__construct();
    }
	
	################## Update Advertisments Status##########
	public function update_status($id, $data) {	
		$this->db->where('id', $id);
		$this->db->update(' shorten_url', $data);
	
		$report = array();
		$report['error'] = $this->db->error();
		$report['message'] = $this->db->error();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

	################ Track Vist Counts #########
	public function trackVisitCount($short_url_id) {
		$reponse=array();
		$this->db->select('short_url_visit.id,short_url_visit.short_url_id, short_url_visit.visit_count', false);
		$this->db->where('short_url_visit.short_url_id',$short_url_id);
		$this->db->from('short_url_visit');
		$query = $this->db->get();
		$result=$query->row_array();
		if(!empty($result)){
		
		    $visit_count=$result['visit_count']+1;
			$short_url_visit_update_data=array(
				'modified'=> date('Y-m-d h:i:s'),
				'short_url_id'=>$short_url_id,
				'visit_count'=>$visit_count		
		    );
			$this->db->where('id',$result['id']);
			$this->db->update('short_url_visit', $short_url_visit_update_data);
			$this->trackVisitDetails($result['id']);
		}
		else{
			$short_url_visit_update_data=array(
				'created'=> date('Y-m-d h:i:s'),
				'short_url_id'=>$short_url_id,
				'visit_count'=>1		
		    );
			$this->db->insert('short_url_visit', $short_url_visit_update_data);
			$this->trackVisitDetails($this->db->insert_id());
		}
	}
	
	################ Public function Track Visit Details ############
	public function trackVisitDetails($visit_id){
		$ua=$this->common_model->getBrowser();
		$ipData=$this->common_model->getLocationInfoByIp();
		$views_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'visit_id'=>$visit_id,
			'browser'=>$ua['name'],
			'browser_version'=>$ua['version'],
			'platform'=>$ua['platform'],
			'ip_address'=>(isset($ipData['ip'])) ? $ipData['ip']:'',
			'city'=>$ipData['city'],
		);
		$this->db->insert('short_url_visit_details', $views_data);
		return true;
    }
	
	############# Get Long Url ##########
	public function get_long_url_details($code){
		$reponse=array();
		$this->db->select('shorten_url.id, shorten_url.long_url', false);
		$this->db->where('shorten_url.code',$code);
		$this->db->where('shorten_url.is_active',true);
		$this->db->where('shorten_url.deleted IS NULL');
		$this->db->from('shorten_url');
		$query = $this->db->get();
		$result=$query->row_array();
		if(!empty($result)){
			return $result;
		}
		return false;
	}
	
	############# Get Long Url ##########
	public function get_long_url($code){
		$reponse=array();
		$this->db->select('shorten_url.long_url', false);
		$this->db->where('shorten_url.code',$code);
		$this->db->from('shorten_url');
		$query = $this->db->get();
		$result=$query->row_array();
		if(!empty($result)){
			return $result['long_url'];
		}
		return false;
	}

	############## User Add ###################
	public function get_details($user_id, $id){

		$this->db->select('shorten_url.*,short_url_visit.visit_count');
		$this->db->from('shorten_url');
		$this->db->where('shorten_url.user_id',$user_id);
		$this->db->where('shorten_url.id',$id);
		$this->db->join('short_url_visit','short_url_visit.short_url_id=shorten_url.id','left');
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	################# Get Advertisment ##################
	public function get_list($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) {  
		$this->db->select('SQL_CALC_FOUND_ROWS shorten_url.id,shorten_url.id,shorten_url.user_id,shorten_url.created,shorten_url.name,shorten_url.long_url,shorten_url.code,shorten_url.is_active',false);
		if(!empty($conditions))
		{ 
				foreach($conditions as $key=>$cond)
				{
					if(!$cond['direct']):
						$where=$cond['rule'];
						$this->db->$where($cond['field'], $cond['value']);
					else:
						$this->db->$cond['rule']($cond['value']);
					endif;
				}
		}	
		if(!$sort_field)
		{
			$this->db->order_by('shorten_url.id', $order_type);
		}
		else{
			$this->db->order_by($sort_field, $order_type);
		}
		
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get('shorten_url');	

		$response['list']=$query->result_array(); 
		$response['total']=$this->get_all_rows();
		return $response;
	}

	#################### Add Short Url ###############
	public function add($user_id, $code) {
		$data = array(
			'name'=> $this->input->post('name'),			
			'user_id'=> $user_id,
			'long_url'=> $this->input->post('long_url'),
			'code'=>$code,
			'created'=> date('Y-m-d h:i:s'),
			'modified'=> date('Y-m-d h:i:s'),
			'is_active'=>true
		);
		$this->db->insert('shorten_url', $data);
		$this->db->insert_id();
		return true;
	}
	
	#################### Update Short Url ###############
	public function update($user_id, $id) {
		$data = array(		
			'user_id'=> $user_id,
			'long_url'=> $this->input->post('long_url'),
			'modified'=> date('Y-m-d h:i:s')
		);
		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		$this->db->update('shorten_url', $data);
		return true;
	}
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
}