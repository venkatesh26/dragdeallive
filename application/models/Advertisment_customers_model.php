<?php
class Advertisment_customers_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
		$this->load->model('cities_model');
		$this->load->model('areas_model');
		$this->load->model('groups_model');
		$this->load->model('advertisment_customer_remainders_model');	
		$this->load->model('advertisment_customers_bills_model');		
    }
	
	####################Delete Customer#################
	public function deleteCustomer($id,$parent_user_id) {
	   $this->db->delete('advertisment_customer_lists',array('customer_id' => $id,'parent_user_id'=>$parent_user_id));
	   return true;
	}
	
	####################Delete Gallery#################
	public function deleteGallery($id, $advertisment_id) {
	   $this->db->delete('advertisment_images',array('id' => $id,'advertisment_id'=>$advertisment_id));
	   return true;
	}
	
	################  Add Customer Data#############
    public function add_customers($parentUserId)	{
		
		$is_active=($this->input->post('is_active')=="on") ? 1 : 0;
		$city_id=0;
		$area_id=0;   
		if($this->input->post('city')){	
			$city_id=$this->cities_model->cityFindOrSave($this->input->post('city'));
			if($this->input->post('area')) {
				$area_id=$this->areas_model->areaFindOrSave($this->input->post('area'),$city_id);
			}
		}	
		
		$group_id=0;
		if($this->input->post('group_name') !=''){
			$group_id=$this->groups_model->findOrSaveGroup($parentUserId,$this->input->post('group_name'));
		}
		$is_birthday_remainder=($this->input->post('is_birthday_remainder')=='on') ? 1 : 0;
		$is_aniversy_reminder=($this->input->post('is_aniversy_reminder')=='on') ? 1 : 0;
		
		if(!isset($_POST['customer_id'])){
			$save_user_data = array(		
				'created' => date('Y-m-d h:i:s'),
				'modified' => date('Y-m-d h:i:s'),
				'first_name'=> $this->input->post('first_name'),
				'last_name'=> $this->input->post('last_name'),
				'gender_id'=>$this->input->post('gender'),
				'email'=>$this->input->post('email'),
				'mobile_number'=>$this->input->post('mobile_number')		
			);
			$this->db->insert('advertisment_customers', $save_user_data);
			$customer_id = $this->db->insert_id();
		}
		else {
			$customer_id=$_POST['customer_id'];
		}
		
		$data = array(
			'parent_user_id'=> $parentUserId,
			'customer_id'=> $customer_id,			
			'created'=> date('Y-m-d h:i:s'),
			'modified' => date('Y-m-d h:i:s'),	
			'last_bill_amount_paid'=>0,
			'total_amount'=>$this->input->post('last_bill_amount_paid'),
			'is_active'=>$is_active,
			'group_id'=>$group_id,
			'is_birthday_remainder'=>$is_birthday_remainder,
			'is_aniversy_reminder'=>$is_aniversy_reminder,
			'visit_count'=>1,
			'first_name'    => $this->input->post('first_name'),
			'last_name'    => $this->input->post('last_name'),	
			'display_name' => $this->input->post('first_name'),
			'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
			'doa' => date('Y-m-d',strtotime($this->input->post('doa'))),	
			'next_service_date' => date('Y-m-d',strtotime($this->input->post('next_service_date'))),					
			'mobile_number' => $this->input->post('mobile_number'),			
			'address' => $this->input->post('address'),		
			'preferred_city_id'=>$city_id,
			'preferred_area_id'=>$area_id,	
			'gender_id'=> $this->input->post('gender'),			
			'email'=>$this->input->post('email'),
		);
		$this->db->insert('advertisment_customer_lists', $data);
		$id = $this->db->insert_id();
			
		$this->advertisment_customers_bills_model->saveBillingInfo($parentUserId, $customer_id, $_POST);
		
		$this->advertisment_customer_remainders_model->saveRemainderSettings($parentUserId,$customer_id);
		return true;	
	}
	
	##### Update Customer Info #########
	public function update_customer_info($customer_id,$parentUserId,$user_info){
		
		$city_id=0;
		$area_id=0;
		if($this->input->post('city'))
		{	
			$city_id=$this->cities_model->cityFindOrSave($this->input->post('city'));
		}	
		if($this->input->post('area'))
		{
			$area_id=$this->areas_model->areaFindOrSave($this->input->post('area'),$city_id);
		}
		
		$group_id=$this->groups_model->findOrSaveGroup($parentUserId,$this->input->post('group_name'));
		$is_active=($this->input->post('is_active')=='on') ? 1 : 0;
		$is_birthday_remainder=($this->input->post('is_birthday_remainder')=='on') ? 1 : 0;
		$is_aniversy_reminder=($this->input->post('is_aniversy_reminder')=='on') ? 1 : 0;
			
		$data = array(
			'parent_user_id'=> $parentUserId,
			'customer_id'=> $customer_id,			
			'modified' => date('Y-m-d h:i:s'),	
			'is_active'=>$is_active,
			'group_id'=>$group_id,
			'is_birthday_remainder'=>$is_birthday_remainder,
			'is_aniversy_reminder'=>$is_aniversy_reminder,
			'visit_count'=>$user_info['visit_count']+1,
			'next_service_date'=>$this->input->post('next_service_date'),
			'mobile_number' => $this->input->post('mobile_number'),
			'address' => $this->input->post('address'),
			'gender_id' => $this->input->post('gender'),
			'email' => $this->input->post('email'),
			'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
			'doa' =>  date('Y-m-d',strtotime($this->input->post('doa'))),
			'first_name'	=> strtolower($this->input->post('first_name')),			
			'last_name'	=> strtolower($this->input->post('last_name')),	
			'preferred_city_id' => $city_id,
			'preferred_area_id' => $area_id
		);
		$this->db->where('customer_id', $customer_id);
		$this->db->where('parent_user_id', $parentUserId);
		$this->db->update('advertisment_customer_lists', $data);
		
        $this->advertisment_customers_bills_model->saveBillingInfo($parentUserId, $customer_id, $_POST);
		$this->advertisment_customer_remainders_model->saveRemainderSettings($parentUserId,$customer_id,'edit');
		return true;	
	}

   	######## Customer Info ########
	function get_customeruserinfo($parent_id,$user_id) {
	 	$this->db->select('advertisment_customer_lists.*, groups.name as group_name,cities.name as city_name,cities.id as city_id,areas.name as area_name');
		$this->db->where('advertisment_customer_lists.parent_user_id',$parent_id);
		$this->db->where('advertisment_customer_lists.customer_id',$user_id);
		$this->db->join('groups','groups.id=advertisment_customer_lists.group_id','left');
		$this->db->join('cities','cities.id=advertisment_customer_lists.preferred_city_id','left');
		$this->db->join('areas','areas.id=advertisment_customer_lists.preferred_area_id','left');
		$query = $this->db->get('advertisment_customer_lists');
		$result = $query->row_array();	
		return $result;
	}	
	
	################  Add Customer Data#############
    public function import_customer_data($data,$parentUserId) {
		$city_id=0;
		$area_id=0;
		if(isset($data['city']) && $data['city']!=''){
			$city_id=$this->cities_model->cityFindOrSave($data['city']);
		}
		if($data['area']){
			$area_id=$this->areas_model->areaFindOrSave($data['area'],$city_id);
		}
		
		############### Checking Cutomer Inforamtion #################
		$this->db->select('id');
		$this->db->where('email', strtolower($data['email']));
		$this->db->or_where('mobile_number', strtolower($data['contact_number']));
		$query = $this->db->get('advertisment_customers');
		if($query->num_rows() == 1){
			$customers=$query->row_array();
			$customer_id=$customers['id'];
		}
		else {		
			$customer_data = array(
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'first_name' 	=> $data['last_name'],
				'last_name' 	=> $data['last_name'],
				'mobile_number' => $data['contact_number'],
				'email'		=> strtolower($data['email']),
			);
			$this->db->insert('advertisment_customers', $customer_data);
			$customer_id = $this->db->insert_id();
		}
		$customerInfo=$this->findOrSaveCustomer($customer_id,$parentUserId,$data);	
		return true;
	}
	
	### Check Already Customer Imaported ####
	public function findOrSaveCustomer($customer_id,$parentUserId,$alldata){

   		$this->db->select('advertisment_customer_lists.id,advertisment_customer_lists.visit_count,advertisment_customer_lists.total_amount');
		$this->db->where('advertisment_customer_lists.customer_id',$customer_id);
		$this->db->where('advertisment_customer_lists.parent_user_id',$parentUserId);
		$this->db->from('advertisment_customer_lists');
		$query = $this->db->get();
		$results=$query->row_array();
		if($results){
			$city_id=0;
			$area_id=0;
			if($alldata['city'])
			{	
				$city_id=$this->cities_model->cityFindOrSave($alldata['city']);
				if($alldata['area'])
				{
					$area_id=$this->areas_model->areaFindOrSave($alldata['area'],$city_id);
				}
			}	
			$data=array(
				'modified'=>date('Y-m-d h:i:s'),
				'visit_count'=>$results['visit_count']+1,
				'total_amount'=>$alldata['bill_amount']+$results['total_amount'],
				'last_bill_amount_paid'=>$alldata['bill_amount'],
				'email'=> $alldata['email'],
				'first_name'=> $alldata['first_name'],
				'last_name'=> $alldata['last_name'],
				'display_name'=> $alldata['last_name'],	
				'preferred_city_id'=> $city_id,
				'preferred_area_id'=> $area_id,
				'email'=>$alldata['email'],
				'gender_id'=>1,
				'address'=>$alldata['address'],
				'mobile_number'=>$alldata['contact_number'],
				'dob'=>$alldata['dob'],
				'doa'=>$alldata['doa']
			);
			$this->db->where('advertisment_customer_lists.id', $results['id']);
			$this->db->update('advertisment_customer_lists', $data);
			$this->advertisment_customers_bills_model->saveBillingInfo($parentUserId,$customer_id,$alldata);
		}
		else {
			$city_id=0;
			$area_id=0;
			if($alldata['city'])
			{	
				$city_id=$this->cities_model->cityFindOrSave($alldata['city']);
				if($alldata['area'])
				{
					$area_id=$this->areas_model->areaFindOrSave($alldata['area'],$city_id);
				}
			}	
			$data = array(
				'parent_user_id'=> $parentUserId,
				'customer_id'=> $customer_id,			
				'created'=> date('Y-m-d h:i:s'),
				'modified' => date('Y-m-d h:i:s'),	
				'last_bill_amount_paid'=>$alldata['bill_amount'],
				'total_amount'=>$alldata['bill_amount'],
				'is_active'=>1,
				'visit_count'=>1,
				'modified'=>date('Y-m-d h:i:s'),
				'email'=> $alldata['email'],
				'first_name'=> $alldata['first_name'],
				'last_name'=> $alldata['last_name'],
				'display_name'=> $alldata['last_name'],	
				'preferred_city_id'=> $city_id,
				'preferred_area_id'=> $area_id,
				'mobile_number'=>$alldata['contact_number'],
				'email'=>$alldata['email'],
				'gender_id'=>1,
				'address'=>$alldata['address'],
				'dob'=>$alldata['dob'],
				'doa'=>$alldata['doa']
			);
			$this->db->insert('advertisment_customer_lists', $data);
			$id = $this->db->insert_id();
			$this->advertisment_customers_bills_model->saveBillingInfo($parentUserId,$userId,$alldata);
			return true;	
		}
	}

}