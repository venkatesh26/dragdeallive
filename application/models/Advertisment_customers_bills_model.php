<?php
class Advertisment_customers_bills_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
    }
	
	########### Save Bill Amount ########
	public function saveBillingInfo($parentUserId,$userId,$alldata){
	   if($alldata['bill_amount'] < 0){
	    return false;
	   }
		$data = array(
			'parent_user_id'=> $parentUserId,
			'user_id'=> $userId,			
			'created'=> date('Y-m-d h:i:s'),
			'modified' => date('Y-m-d h:i:s'),	
			'amount'=>$alldata['bill_amount'],			
		);
		$this->db->insert('advertisment_customer_bills', $data);
		$id = $this->db->insert_id();	
	}
}