<?php
class Advertisment_customer_remainders_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
    }
	
	############### Get User Bussiness Data ############
    public function get_user_remainderdata($parent_user_id,$customer_id){
		$this->db->select('remainder_settings.id,advertisment_customer_remainders.remainder_setting_id,advertisment_customer_remainders.service_date,remainder_settings.name');
		$this->db->where('advertisment_customer_remainders.customer_id',$customer_id);
		$this->db->where('advertisment_customer_remainders.parent_user_id',$parent_user_id);
		$this->db->from('advertisment_customer_remainders');
		$this->db->join('remainder_settings','remainder_settings.id=advertisment_customer_remainders.remainder_setting_id','left');
		$query = $this->db->get();			
		$result=$query->result_array(); 
		return $result;
	}
		
	########## Save Remainder ##########
	public function saveRemainderSettings($parent_user_id,$customer_id,$type='add'){

		$serviceDates=$this->input->post('service_date');
		$serviceIDs=$this->input->post('service_id');
		$service_data=array();
		$rem_service_data =array();
		if(!is_array($serviceIDs)){
		   $serviceIDs=array();	
		}
		foreach($serviceIDs as $key=>$data){
			
			$service_data[$key]['remainder_setting_id']=$data;
			$service_data[$key]['service_date']=$serviceDates[$key];
			$rem_service_data[$key]=$data;
		}
		
		$table_data=array();
		$this->db->select('remainder_setting_id');        
		$this->db->where('parent_user_id',$parent_user_id);
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get('advertisment_customer_remainders');
		$res = $query->result_array();
		$list_data=array();
		foreach($res as $key=>$datas){
			$list_data[$key]=$datas['remainder_setting_id'];
		}
		if($type!='add') {
			foreach($list_data as $data) {	
				$this->db->delete('advertisment_customer_remainders',array('remainder_setting_id' => $data,'customer_id' => $customer_id,'parent_user_id'=>$parent_user_id));
			}	
		}
		foreach($service_data as $data) {
			if($data > 0 && $data['service_date']!=''){
				$table_data=array(
					'created'=>date('Y-m-d h:i:s'),
					'parent_user_id'=>$parent_user_id,
					'customer_id'=>$customer_id,
					'remainder_setting_id'=>$data['remainder_setting_id'],
					'service_date'=>date('Y-m-d',strtotime($data['service_date'])),
				);
				$this->db->insert('advertisment_customer_remainders', $table_data);	
			}
		}
		
	}
}