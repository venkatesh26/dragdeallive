<?php
class customer_campaign_model extends CI_Model {
	
	###### CAMPAIGN DELETE ###########
	public function delete($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('advertisments_customers_campaign');
		$res = $query->row();
		$this->db->delete('advertisments_customers_campaign',array('id' => $id));	
	}
	
	####### Admin Details #########
	public function get_campaign_detail($id){
		$this->db->select('advertisments_customers_campaign_list.*,users.email,users.contact_number,advertisments_customers_campaign.title,advertisments_customers_campaign.campaign_type_id');
		$this->db->where('advertisments_customers_campaign_list.id',$id);
		$this->db->from('advertisments_customers_campaign_list');
		$this->db->join('users','users.id=advertisments_customers_campaign_list.user_id');
		$this->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = advertisments_customers_campaign_list.advertisments_customers_campaign_id', 'left');	
		$this->db->order_by('advertisments_customers_campaign_list.id','DESC');
		$query = $this->db->get();
		$result = $query->row_array();	
		return $result;
	}
	
	#### Customer Campaign #####
	public function get_customer_campaign($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) {  
		$this->db->select('advertisments_customers_campaign_list.*,users.email,users.contact_number,advertisments_customers_campaign.title');
		$this->db->from('advertisments_customers_campaign_list');
		if(!empty($conditions)){ 
				foreach($conditions as $key=>$cond)
				{
					if(!$cond['direct'])
						$this->db->$cond['rule']($cond['field'], $cond['value']);
					else
						$this->db->$cond['rule']($cond['value']);
				}
		}
		$this->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = advertisments_customers_campaign_list.advertisments_customers_campaign_id', 'left');		
		$this->db->join('users', 'users.id = advertisments_customers_campaign_list.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisments_customers_campaign_list.user_id', 'left');
		if(!$sort_field)
			$this->db->order_by('advertisments_customers_campaign_list.id', $order_type);
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