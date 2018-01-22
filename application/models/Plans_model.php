<?php
class Plans_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
	public function get_plans($flag='')
	{  
		$this->db->from('plans');
		
		if($flag == 1){
			$query = $this->db->get();		
			return $query->result_array(); 
		}
		else{
			$query = $this->db->get();		
			return $query->num_rows();        
		}
	 }
	function get_values($id) {
		//$this->db->select('id, name,price, is_active');
		$this->db->where('id', $id);
		$query = $this->db->get('plans');

		return $query->row_array();
	}
	public function plans_list($flag=null)
	{  
		$this->db->select('plans.id, plans.name, plans.price, plans.auction_limit , plans.plan_valid_days, plans.is_active');
		$this->db->from('plans');
		$this->db->where('is_active', 1);
		
		if($flag == 1){
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else if($flag == 2){
				$this->db->order_by('name','ASC' );
				$query = $this->db->get();	
				$returnVal=array();
				foreach($query->result_array() as $vals) {
						$returnVal[$vals['id']]=$vals['name'];
				}
				return $returnVal; 
		}
		else{
				$query = $this->db->get();		
				return $query->num_rows();        
		}
	}
	public function edit($id)
	{
		$data = array(
				'modified' 			 => date('Y-m-d h:i:s'),
				'name'				 => $this->input->post('name'),
				'price' 			 => $this->input->post('price'),
				'plan_valid_days'	 => $this->input->post('plan_valid_days'),
				'commision' 		 => $this->input->post('commision'),
				'auction_limit' 	 => $this->input->post('auction_limit'),
				'featured_home_page' => $this->input->post('featured_home_page'),
				'is_active'			 => $this->input->post('is_active')
			);
		$this->db->where('id', $id);
		$this->db->update('plans', $data);
	}
	public function update_status($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('plans', $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}
 
}
?>