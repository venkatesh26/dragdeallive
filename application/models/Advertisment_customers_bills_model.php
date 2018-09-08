<?php
class Advertisment_customers_bills_model extends CI_Model {
	
	#	Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
    }
	
	
	############### Order Details ###################
	public function my_order_detail($order_id, $customer_id){
		$this->db->select('cities.name as city, areas.name as area, advertisment_customer_bills.id,advertisment_customer_lists.first_name,advertisment_customer_lists.last_name, advertisment_customer_lists.mobile_number, advertisment_customer_lists.email, advertisment_customer_bills.parent_user_id,advertisment_customer_bills.id,advertisment_customer_bills.created,advertisment_customer_bills.amount, advertisment_customer_lists.address, advertisment_customer_bills.order_id, advertisements.name as shop_name, advertisements.email AS contact_email, advertisements.contact_number as contact_phone_number,advertisements.address_line as contact_address',false);
		$this->db->join('advertisment_customer_lists','advertisment_customer_bills.customer_id=advertisment_customer_lists.customer_id');
		$this->db->join('cities','cities.id=advertisment_customer_lists.preferred_city_id', 'LEFT');
		$this->db->join('areas','areas.id=advertisment_customer_lists.preferred_area_id', 'LEFT');
		$this->db->join('advertisements','advertisements.user_id=advertisment_customer_lists.parent_user_id', 'LEFT');
		$this->db->where('advertisment_customer_bills.id',$order_id);
		$this->db->where('advertisment_customer_bills.customer_id',$customer_id);
		$this->db->from('advertisment_customer_bills');
		$this->db->order_by('advertisment_customer_bills.created','DESC');
		$this->db->group_by('advertisment_customer_bills.customer_id');
		$query = $this->db->get();			
		$result=$query->row_array();
	
		######################## Order Product Details ###################
		if(!empty($result)){
			$this->db->select('advertisment_products.name as product_name, advertisment_customer_bill_details.*');
			$this->db->join('advertisment_products','advertisment_products.id=advertisment_customer_bill_details.product_id');
			$this->db->where('advertisment_customer_bill_details.bill_id',$result['id']);
			$this->db->from('advertisment_customer_bill_details');
			$this->db->order_by('advertisment_customer_bill_details.id');
			$query = $this->db->get();			
			$result['product_order_details']=$query->result_array();
		}
		return $result;	
	}
	
	############### Order Details ###################
	public function order_detail($order_id, $userId){
		$this->db->select('cities.name as city, areas.name as area, advertisment_customer_bills.id,advertisment_customer_lists.first_name,advertisment_customer_lists.last_name, advertisment_customer_lists.mobile_number, advertisment_customer_lists.email, advertisment_customer_bills.parent_user_id,advertisment_customer_bills.id,advertisment_customer_bills.created,advertisment_customer_bills.amount, advertisment_customer_lists.address, advertisment_customer_bills.order_id',false);
		$this->db->join('advertisment_customer_lists','advertisment_customer_bills.customer_id=advertisment_customer_lists.customer_id');
		$this->db->join('cities','cities.id=advertisment_customer_lists.preferred_city_id', 'LEFT');
		$this->db->join('areas','areas.id=advertisment_customer_lists.preferred_area_id', 'LEFT');
		$this->db->where('advertisment_customer_bills.id',$order_id);
		$this->db->where('advertisment_customer_bills.parent_user_id',$userId);
		$this->db->from('advertisment_customer_bills');
		$this->db->order_by('advertisment_customer_bills.created','DESC');
		$this->db->group_by('advertisment_customer_bills.customer_id');
		$query = $this->db->get();			
		$result=$query->row_array();
	
		######################## Order Product Details ###################
		if(!empty($result)){
			$this->db->select('advertisment_products.name as product_name, advertisment_customer_bill_details.*');
			$this->db->join('advertisment_products','advertisment_products.id=advertisment_customer_bill_details.product_id');
			$this->db->where('advertisment_customer_bill_details.bill_id',$result['id']);
			$this->db->from('advertisment_customer_bill_details');
			$this->db->order_by('advertisment_customer_bill_details.id');
			$query = $this->db->get();			
			$result['product_order_details']=$query->result_array();
		}
		return $result;
	}
	
	
	################ Get My Order List ####################
	public function getMyOrderList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS advertisment_customer_bills.id,advertisment_customer_lists.first_name,advertisment_customer_lists.last_name, advertisment_customer_lists.mobile_number, advertisment_customer_lists.email, advertisment_customer_bills.parent_user_id,advertisment_customer_bills.id,advertisment_customer_bills.created,advertisment_customer_bills.amount, advertisements.name as shop_name, advertisements.email AS contact_email, advertisements.contact_number as contact_phone_number',false);
		
		if(isset($_POST['s_name']) && $_POST['s_name']!=''){
			$this->db->like('advertisements.name',$_POST['s_name'],'after'); 		
		}
		if(isset($_POST['from_date']) && $_POST['from_date']!=''){
			$this->db->where('advertisment_customer_bills.created >=', date('Y-m-d 00:00:00', strtotime($_POST['from_date']))); 	
		}
		if(isset($_POST['to_date']) && $_POST['to_date']!=''){
	    	$this->db->where('advertisment_customer_bills.created <=', date('Y-m-d 23:59:59', strtotime($_POST['to_date']))); 	
		}
		$this->db->join('advertisment_customer_lists','advertisment_customer_bills.customer_id=advertisment_customer_lists.id');
		$this->db->join('advertisements','advertisements.user_id=advertisment_customer_lists.parent_user_id', 'LEFT');
		$this->db->where('advertisment_customer_bills.customer_id',$userId);
		$this->db->from('advertisment_customer_bills');
		$this->db->order_by('advertisment_customer_bills.created','DESC');
		$this->db->limit($limit_start, $limit_end);
		$this->db->group_by('advertisment_customer_bills.customer_id');
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }
	
	################ Get Customer List ####################
	public function getOrderList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS advertisment_customer_bills.id,advertisment_customer_lists.first_name,advertisment_customer_lists.last_name, advertisment_customer_lists.mobile_number, advertisment_customer_lists.email, advertisment_customer_bills.parent_user_id,advertisment_customer_bills.id,advertisment_customer_bills.created,advertisment_customer_bills.amount, ',false);
		if(isset($_POST['s_name']) && $_POST['s_name']!=''){
			$this->db->like('advertisment_customer_lists.first_name',$_POST['s_name'],'after'); 
			$this->db->or_like('advertisment_customer_lists.last_name',$_POST['s_name'],'after');
			$this->db->or_like('advertisment_customer_lists.email',$_POST['s_name'],'after');			
		}
		if(isset($_POST['s_mobile_number']) && $_POST['s_mobile_number']!=''){
			$this->db->like('advertisment_customer_lists.mobile_number',$_POST['s_mobile_number'],'after'); 	
		}
		$this->db->join('advertisment_customer_lists','advertisment_customer_bills.customer_id=advertisment_customer_lists.id');
		$this->db->where('advertisment_customer_bills.parent_user_id',$userId);
		$this->db->from('advertisment_customer_bills');
		$this->db->order_by('advertisment_customer_bills.created','DESC');
		$this->db->limit($limit_start, $limit_end);
		$this->db->group_by('advertisment_customer_bills.customer_id');
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
	
	########### Save Bill Amount ########
	public function saveBillingInfo($parentUserId,$customer_id,$alldata){
	 
	    $totalOrderPrice=0;
		
		$redem_points=0;
		
		$bill_id=0;
		
		$order_id="ORD-".$parentUserId."-".date('Ymd');
		
		if(!empty($alldata['advertisment_customer_bill_details'])){
		   
			################ Total Amount ################
			foreach($alldata['advertisment_customer_bill_details'] as $details){
					if( $details['product_id']!='' && $details['amount']!='' && $details['quantity']!=''){
						$amount=$details['quantity'] * $details['amount'];	
						$totalOrderPrice=$totalOrderPrice+$amount;
					}
			}
			
			################ Redeem By Points ###############
			
			############ Reed By Offer ######################
		    if($totalOrderPrice >0){
				$data = array(
					'parent_user_id'=> $parentUserId,
					'customer_id'=> $customer_id,			
					'created'=> date('Y-m-d h:i:s'),
					'modified' => date('Y-m-d h:i:s'),	
					'amount'=>$totalOrderPrice,	
					'redem_points'=>$redem_points,
					'order_id'=>$order_id					
				);
				$this->db->insert('advertisment_customer_bills', $data);
				$bill_id = $this->db->insert_id();
			}
		}
		
		######################## Save Order And Order Details ################# 
		if(!empty($alldata['advertisment_customer_bill_details'])){
			foreach($alldata['advertisment_customer_bill_details'] as $details){
				if( $details['product_id']!=''){
					$amount=$details['quantity'] * $details['amount'];
					$data = array(
						'created'=>date('y-m-d H:i:s'),
						'modified'=>date('y-m-d H:i:s'),
						'bill_id'=>$bill_id,
						'product_id'=> $details['product_id'],
						'quantity'=> $details['quantity'],			
						'price'=> $details['amount'],
						'total_price' => $amount			
					);
					$this->db->insert('advertisment_customer_bill_details', $data);
				}
			}
		}
		
		############### Update Total Amount And Last Bill Amount ###################
		if($totalOrderPrice > 0){
			$this->db->select('advertisment_customer_lists.id,advertisment_customer_lists.visit_count,advertisment_customer_lists.total_amount');
			$this->db->where('advertisment_customer_lists.customer_id',$customer_id);
			$this->db->where('advertisment_customer_lists.parent_user_id',$parentUserId);
			$this->db->from('advertisment_customer_lists');
			$query = $this->db->get();
			$results=$query->row_array();
			if($results){
				$update_data=array(
					'total_amount'=>$totalOrderPrice+$results['total_amount'],
					'last_bill_amount_paid'=>$totalOrderPrice
				);
				$this->db->where('id', $results['id']);
				$a=$this->db->update('advertisment_customer_lists', $update_data);	
			}
		}
		return true;
	}
}