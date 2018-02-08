<?php
class Advertisment_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
		$this->load->model('notification_model');
    }
	
	public function update_notification_count($id){
		$this->db->where('id', $id);
		$data=array('is_read'=>1);
		$this->db->update('notifications', $data);
		return true;
    }
	
	############# Notifications List #####
	function get_notification_list($user_id, $limit_start, $limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS notifications.id,notifications.*',false);
		$this->db->where('notifications.to_user_id',$user_id);
		$this->db->from('notifications');
		$this->db->order_by('notifications.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$newresult=array();
		$response=array();
		foreach($result  as $key=>$res)
		{
			$newresult[$key]=array(date('d ,M Y',strtotime($res['created'])),ucwords($res['title']),$res['message'],$res['is_read'],$res['id']);
		}
		$response['iTotalDisplayRecords']=$this->get_all_rows();
		$response['iTotalRecords']=$this->get_all_rows();
		$response['data']=$newresult;
		return $response;
	}
	
	######## Customer Info ########
	function get_customeruserinfo($parent_id,$user_id) {
	 	$this->db->select('advertisment_customer_lists.*, groups.name as group_name,cities.name as city_name,cities.id as city_id,areas.name as area_name');
		$this->db->where('advertisment_customer_lists.parent_user_id',$parent_id);
		$this->db->where('advertisment_customer_lists.user_id',$user_id);
		$this->db->join('groups','groups.id=advertisment_customer_lists.group_id','left');
		$this->db->join('cities','cities.id=advertisment_customer_lists.preferred_city_id','left');
		$this->db->join('areas','areas.id=advertisment_customer_lists.preferred_area_id','left');
		$query = $this->db->get('advertisment_customer_lists');
		$result = $query->row_array();	
		return $result;
	}
	
	##### Update Customer Info #########
	public function update_customer_info($user_id,$parentUserId,$user_info){
		
		$city_id=0;
		$area_id=0;
		if($this->input->post('city'))
		{	
			$city_id=$this->cityFindOrSave($this->input->post('city'));
		}	
		if($this->input->post('area'))
		{
			$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
		}
		
		$group_id=$this->findOrSaveGroup($parentUserId,$this->input->post('group_name'));
		$is_active=($this->input->post('is_active')=='on') ? 1 : 0;
		$is_birthday_remainder=($this->input->post('is_birthday_remainder')=='on') ? 1 : 0;
		$is_aniversy_reminder=($this->input->post('is_aniversy_reminder')=='on') ? 1 : 0;
			
		$data = array(
			'parent_user_id'=> $parentUserId,
			'user_id'=> $user_id,			
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
			'preferred_area_id' => $area_id,
			'business_hours'=>$this->input->post('business_hours')
		);
		$this->db->where('user_id', $user_id);
		$this->db->where('parent_user_id', $parentUserId);
		$this->db->update('advertisment_customer_lists', $data);
		
		if($this->input->post('last_bill_amount_paid') > 0) {
			$data = array(	
				'last_bill_amount_paid'=>$this->input->post('last_bill_amount_paid'),
				'total_amount'=>$user_info['total_amount']+$this->input->post('last_bill_amount_paid'),		
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('parent_user_id', $parentUserId);
			$this->db->update('advertisment_customer_lists', $data);
			$data = array(
				'parent_user_id'=> $parentUserId,
				'user_id'=> $user_id,			
				'created'=> date('Y-m-d h:i:s'),
				'modified' => date('Y-m-d h:i:s'),	
				'amount'=>$this->input->post('last_bill_amount_paid'),			
			);
			$this->db->insert('advertisment_customer_bills', $data);	
		}
		
		$this->saveRemainderSettings($parentUserId,$user_id,'edit');
		return true;	
	}
	
	########## Save Remainder ##########
	public function saveRemainderSettings($parent_user_id,$user_id,$type='add'){

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
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('advertisment_customer_remainders');
		$res = $query->result_array();
		$list_data=array();
		foreach($res as $key=>$datas){
			$list_data[$key]=$datas['remainder_setting_id'];
		}
		if($type!='add') {
			foreach($list_data as $data) {	
				$this->db->delete('advertisment_customer_remainders',array('remainder_setting_id' => $data,'user_id' => $user_id,'parent_user_id'=>$parent_user_id));
			}	
		}
		
		foreach($service_data as $data) {
			if($data > 0 && $data['service_date']!=''){
				$table_data=array(
					'created'=>date('Y-m-d h:i:s'),
					'parent_user_id'=>$parent_user_id,
					'user_id'=>$user_id,
					'remainder_setting_id'=>$data['remainder_setting_id'],
					'service_date'=>date('Y-m-d',strtotime($data['service_date'])),
				);
				$this->db->insert('advertisment_customer_remainders', $table_data);	
			}
		}
		
	}
	
	############# Save/ update Customers Remainder Data ######
	public function saveRemainderData($parent_user_id,$user_id,$remainder_data){

		$table_data=array();
		$this->db->select('remainder_setting_id');        
		$this->db->where('parent_user_id',$parent_user_id);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('advertisment_customer_remainders');
		$res = $query->result_array();
		$list_data=array();
		foreach($res as $key=>$datas){
			$list_data[$key]=$datas['remainder_setting_id'];
		}
		if(!is_array($remainder_data)){
		   $remainder_data=array();	
		}
		$delete_data=array_diff($list_data,$remainder_data);
		foreach($remainder_data as $data) {
			if(!in_array($data,$list_data)){
				$table_data=array(
					'created'=>date('Y-m-d h:i:s'),
					'parent_user_id'=>$parent_user_id,
					'user_id'=>$user_id,
					'remainder_setting_id'=>$data,
				);
				$this->db->insert('advertisment_customer_remainders', $table_data);	
			}
		}
		foreach($delete_data as $data) {	
			$this->db->delete('advertisment_customer_remainders',array('remainder_setting_id' => $data,'user_id' => $user_id,'parent_user_id'=>$parent_user_id));
        }		
	}
	
	######## Update Customers Data ###########
	public function update_customers_data($user_id,$parentUserId) {
		
		
		if($this->input->post('city'))
		{	
			$city_id=$this->cityFindOrSave($this->input->post('city'));
		}	
		if($this->input->post('area'))
		{
			$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
		}
		$data = array(			
			'contact_number' => $this->input->post('mobile_number'),
			'modified' 	=> date('Y-m-d h:i:s'),
			'preferred_city_id' => $city_id,
			'preferred_area_id' => $area_id,
		);
		$this->db->where('id', $user_id);
		$update = $this->db->update('users', $data);
		
		$profile_data = array(
			'first_name'	=> strtolower($this->input->post('first_name')),			
			'last_name'	=> strtolower($this->input->post('last_name')),			
			'modified' 		=> date('Y-m-d h:i:s'),
			'mobile_number' => $this->input->post('mobile_number'),
			'telephone_number' => $this->input->post('contact_number'),
			'address' => $this->input->post('address'),
			'gender_id' => $this->input->post('gender'),
			'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
			'doa' =>  date('Y-m-d',strtotime($this->input->post('doa'))),
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('user_profiles', $profile_data);
		
		$group_id=$this->findOrSaveGroup($parentUserId,$this->input->post('group_name'));
		$is_active=($this->input->post('is_active')=='on') ? 1 : 0;
		$is_birthday_remainder=($this->input->post('is_birthday_remainder')=='on') ? 1 : 0;
		$is_aniversy_reminder=($this->input->post('is_aniversy_reminder')=='on') ? 1 : 0;
			
		$data = array(
			'parent_user_id'=> $parentUserId,
			'user_id'=> $user_id,			
			'modified' => date('Y-m-d h:i:s'),	
			'is_active'=>$is_active,
			'group_id'=>$group_id,
			'is_birthday_remainder'=>$is_birthday_remainder,
			'is_aniversy_reminder'=>$is_aniversy_reminder,
			'visit_count'=>1,
		);
		$this->db->insert('advertisment_customer_lists', $data);
		
		if($this->input->post('last_bill_amount_paid') > 0) {
			$data = array(	
				'last_bill_amount_paid'=>$this->input->post('last_bill_amount_paid'),
				'total_amount'=>$this->input->post('last_bill_amount_paid'),		
			);
			$this->db->where('user_id', $user_id);
			$this->db->where('parent_user_id', $parentUserId);
			$this->db->update('advertisment_customer_lists', $data);
			$data = array(
				'parent_user_id'=> $parentUserId,
				'user_id'=> $user_id,			
				'created'=> date('Y-m-d h:i:s'),
				'modified' => date('Y-m-d h:i:s'),	
				'amount'=>$this->input->post('last_bill_amount_paid'),			
			);
			$this->db->insert('advertisment_customer_bills', $data);	
		}
		return true;	
	}
	
	########## Get Remainder Details ########
	public function get_remainder_settings($user_id){
		
		$this->db->select('customer_remainder_settings.*');
		$this->db->where('customer_remainder_settings.user_id',$user_id);
		$this->db->from('customer_remainder_settings');
		$query = $this->db->get();
		$result=$query->result_array();
		$new_result['birthday_remainder']=array();
		$new_result['aninversery_remainder']=array();
		foreach($result as $key=>$data){
			
			if($data['type']==1){
				$new_result['birthday_remainder']=$data;	
			}
			else{
				$new_result['aninversery_remainder']=$data;
			}
		}
		return $new_result;
	}
	
	########### Save Remainder Settings ##########
	public function save_remainder_settings($user_id){
		$b_is_active=($this->input->post('birthday_is_active')) ? 1 : 0;
		$field="created";
		if($_POST['birthday_remainder_id'] > 0){
					$field="modified";
		}
		$save_user_data = array(		
			$field 	=> date('Y-m-d h:i:s'),
			'user_id'=>$user_id,
			'message'=>$this->input->post('birthday_message'),
			'remainder_start_before_days'=>$this->input->post('birthday_remainder_start_before_days'),
			'remainder_end_after_days'=>$this->input->post('birthday_remainder_end_after_days'),
			'is_active'=>$b_is_active,		
			'type'=>1			
		);
		if($_POST['birthday_remainder_id'] > 0){
			$this->db->where('id',$_POST['birthday_remainder_id']);
			$this->db->update('customer_remainder_settings', $save_user_data);
		}else{
			$this->db->insert('customer_remainder_settings', $save_user_data);
		}
		
		$field="created";
		if($_POST['anversey_remainder_id'] > 0){
			$field="modified";
		}
		$anversey_is_active=($this->input->post('anversey_is_active')) ? 1 : 0;
		$save_user_data = array(		
			$field 	=> date('Y-m-d h:i:s'),
			'user_id'=>$user_id,
			'message'=>$this->input->post('anversey_message'),
			'remainder_start_before_days'=>$this->input->post('anversey_remainder_start_before_days'),
			'remainder_end_after_days'=>$this->input->post('anversey_remainder_end_after_days'),
			'is_active'=>$anversey_is_active,		
			'type'=>2				
		);
		if($_POST['anversey_remainder_id'] > 0){
			$this->db->where('id',$_POST['anversey_remainder_id']);
			$this->db->update('customer_remainder_settings', $save_user_data);
		}else{
			$this->db->insert('customer_remainder_settings', $save_user_data);
		}
		return true;
	}
	
	
	######## get_customers_list ######
	public function get_customers_list($keyword,$user_id){
		if($keyword) 
		{
			$this->db->like('user_profiles.first_name', $keyword,'after'); 
		}
		$this->db->where('advertisment_customer_lists.is_active','1');
		$this->db->select('users.email,user_profiles.first_name,users.id');
		$this->db->join('users','users.id=advertisment_customer_lists.user_id','left');
		$this->db->join('user_profiles','users.id=user_profiles.user_id','left');
		$query = $this->db->get('advertisment_customer_lists');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->first_name)."-".$g->email,'id'=>$g->id);
		}
		return $arr;
	}
	
	############# Check User Info #######
	public function checkUserInfo(){
		$this->db->select('users.*,user_profiles.first_name,user_profiles.last_name,user_profiles.address,user_profiles.gender_id,user_profiles.dob,user_profiles.doa,cities.name as city_name,areas.name as area_name');
		$this->db->where('users.contact_number',$_POST['contact_number']);
		$this->db->join('user_profiles','users.id=user_profiles.user_id','left');
		$this->db->join('cities','cities.id=users.preferred_city_id','left');
		$this->db->join('areas','areas.id=users.preferred_area_id','left');
		$this->db->from('users');
		$query = $this->db->get();
		$result=$query->row_array();
        return $result;		
	}
	
	######### Check Customer Data #######
	public function checkCustomerUsers($parent_user_id,$user_id){
		$this->db->select('advertisment_customer_lists.id');
		$this->db->where('advertisment_customer_lists.parent_user_id',$parent_user_id);
		$this->db->where('advertisment_customer_lists.user_id',$user_id);
		$this->db->from('advertisment_customer_lists');
		$query = $this->db->get();
		$result=$query->row_array();
		return $result;
	}
	
	########### Save User Info ########
	public function SaveUserInfo(){
		
		$save_user_data = array(		
			'created'		 => date('Y-m-d h:i:s'),
			'modified' 		 => date('Y-m-d h:i:s'),
			'contact_number'=>$data['contact_number'],
			'email'=>$data['email'],
			'password'=>md5('dialbe2016'),
			'user_type'=>3,
			'is_active'=>1,				
		);
		$this->db->insert('users', $save_user_data);
		$user_id = $this->db->insert_id();
	}
	
	############## Update Customers #########
	public function update_customer(){
		
		$save_user_data = array(		
			'created'		 => date('Y-m-d h:i:s'),
			'modified' 		 => date('Y-m-d h:i:s'),
			'contact_number'=>$_POST['contact_number'],
			'email'=>$_POST['email'],
			'password'=>md5('dialbe2016'),
			'referer_id'=>$parentUserId,
			'user_type'=>3,
			'is_active'=>1,				
		);
		
		$user_profiles_data = array(
			'user_id'		=> $user_id,			
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),	
			'first_name'    => $this->input->post('first_name'),
			'last_name'    => $this->input->post('last_name'),	
			'display_name' => $this->input->post('first_name'),
			'dob' => date('Y-m-d',strtotime($data['dob'])),		
			'mobile_number' => $this->input->post('contact_number'),		
			'telephone_number' => $this->input->post('contact_number'),		
			'address' => $this->input->post('address'),						
		);
		$this->db->insert('user_profiles', $user_profiles_data);
		$id = $this->db->insert_id();
	} 
	
	################  Add Customer Data#############
    public function add_customers($parentUserId)	{
		
		$is_active=($this->input->post('is_active')=="on") ? 1 : 0;
		$city_id=0;
		$area_id=0;   
		if($this->input->post('city'))
		{	
			$city_id=$this->cityFindOrSave($this->input->post('city'));
			if($this->input->post('area'))
			{
				$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
			}
		}	
	
			if(!$_POST['user_id']){
				$save_user_data = array(		
					'created'		 => date('Y-m-d h:i:s'),
					'modified' 		 => date('Y-m-d h:i:s'),
					'contact_number'=>$this->input->post('mobile_number'),
					'email'=>$this->input->post('email'),
					'password'=>md5('dialbe2016'),
					'referer_id'=>$parentUserId,
					'preferred_city_id'=>$city_id,
					'preferred_area_id'=>$area_id,
					'user_type'=>3,
					'is_active'=>1,				
				);
				$this->db->insert('users', $save_user_data);
				$user_id = $this->db->insert_id();
			}
			else {
				$user_id=$_POST['user_id'];
			}
			$user_profiles_data = array(
				'user_id'		=> $user_id,			
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),	
				'first_name'    => $this->input->post('first_name'),
				'last_name'    => $this->input->post('last_name'),	
				'display_name' => $this->input->post('first_name'),
				'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
				'doa' => date('Y-m-d',strtotime($this->input->post('doa'))),				
				'mobile_number' => $this->input->post('mobile_number'),		
				'telephone_number' => $this->input->post('contact_number'),		
				'address' => $this->input->post('address'),						
			);
			$this->db->insert('user_profiles', $user_profiles_data);
			$id = $this->db->insert_id();
			
			$group_id=0;
			if($this->input->post('group_name') !=''){
				$group_id=$this->findOrSaveGroup($parentUserId,$this->input->post('group_name'));
			}
			$is_birthday_remainder=($this->input->post('is_birthday_remainder')=='on') ? 1 : 0;
			$is_aniversy_reminder=($this->input->post('is_aniversy_reminder')=='on') ? 1 : 0;
			
			$data = array(
				'parent_user_id'=> $parentUserId,
				'user_id'=> $user_id,			
				'created'=> date('Y-m-d h:i:s'),
				'modified' => date('Y-m-d h:i:s'),	
				'last_bill_amount_paid'=>$this->input->post('last_bill_amount_paid'),
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
			
			if($this->input->post('last_bill_amount_paid') > 0){
				$data = array(
					'parent_user_id'=> $parentUserId,
					'user_id'=> $user_id,			
					'created'=> date('Y-m-d h:i:s'),
					'modified' => date('Y-m-d h:i:s'),	
					'amount'=>$this->input->post('last_bill_amount_paid'),			
				);
				$this->db->insert('advertisment_customer_bills', $data);
				$id = $this->db->insert_id();	
			}
	   $this->saveRemainderSettings($parentUserId,$user_id);
		return true;	
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
	
	################ Get Import List ####################
	public function getMyImportList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS customer_import_history.id,customer_import_history.*',false);
		$this->db->where('customer_import_history.user_id',$userId);
		$this->db->from('customer_import_history');
		$this->db->order_by('customer_import_history.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }
	
	######### Save Histroy Data ###########
	public function import_customer_history_data($data)	 {
	
		$this->db->insert('customer_import_history', $data);
		$user_id = $this->db->insert_id();		
	}
	
	################  Add Customer Data#############
    public function import_customer_data($data,$parentUserId) {
		$city_id=0;
		$area_id=0;
		if(isset($data['city']) && $data['city']!=''){
			$city_id=$this->cityFindOrSave($data['city']);
		}
		if($data['area']){
			$area_id=$this->areaFindOrSave($data['area'],$city_id);
		}
		$isActive=1;
		$field='created';
		$new_data = array(
			'created'=>date('Y-m-d H:i:s'),
			'email'=> $data['email'],
			'first_name'=> $data['first_name'],
			'last_name'=> $data['last_name'],
            'display_name'=> $data['last_name'],	
			'user_type'=>1,
			'preferred_city_id'=> $city_id,
			'preferred_area_id'=> $area_id,
			'email'=>$data['email'],
			'gender_id'=>1,
			'address'=>$data['address'],
			'dob' => date('Y-m-d',strtotime($data['dob'])),
			'doa' =>  date('Y-m-d',strtotime($data['doa'])),
			'user_id'=>$parentUserId,
			'is_active'=>$isActive,
			$field => date('Y-m-d h:i:s'),
			'bill_amount'=>$data['bill_amount'],
			'contact_number'=>$data['contact_number'],
		);
		$userId=$this->findOrSaveuserInfo($new_data,$parentUserId);
		$customerInfo=$this->findOrSaveCustomer($userId,$parentUserId,$data);	
		return true;
	}
	
	###### Save User Info #############
	public function findOrSaveuserInfo($data,$parentUserId){	
		$this->db->select('users.id');
		$this->db->where('users.contact_number',$data['contact_number']);
		$this->db->from('users');
		$query = $this->db->get();
		$result=$query->row_array();
		if(count($result) >=1 ){
			return $result['id'];
		} else {
			
			$city_id=0;
			$area_id=0;
			if(isset($data['city']))
			{	
				$city_id=$this->cityFindOrSave($data['city']);
				if(isset($data['area']))
				{
					$area_id=$this->areaFindOrSave($data['area'],$city_id);
				}
			}	
			$save_user_data = array(		
				'created'		 => date('Y-m-d h:i:s'),
				'modified' 		 => date('Y-m-d h:i:s'),
				'contact_number'=>$data['contact_number'],
				'email'=>$data['email'],
				'password'=>md5('dialbe2016'),
				'referer_id'=>$parentUserId,
				'preferred_city_id'=>$data['preferred_city_id'],
				'preferred_area_id'=>$data['preferred_area_id'],
				'user_type'=>3,
				'is_active'=>1,				
			);
			$this->db->insert('users', $save_user_data);
			$user_id = $this->db->insert_id();
		
			$user_profiles_data = array(
				'user_id'			=> $user_id,			
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),	
				'first_name'    => $data['first_name'],
				'last_name'    => $data['last_name'],	
				'display_name' => $data['first_name'],
				'dob' => date('Y-m-d',strtotime($data['dob'])),	
				'doa' => date('Y-m-d',strtotime($data['doa'])),					
				'mobile_number' => $data['contact_number'],		
				'telephone_number' => $data['contact_number'],		
				'address' => $data['address'],						
			);
			$this->db->insert('user_profiles', $user_profiles_data);
			$id = $this->db->insert_id();
			return $user_id;
		}
	}
	
	### Check Already Customer Imaported ####
	public function findOrSaveCustomer($userId,$parentUserId,$alldata){

   		$this->db->select('advertisment_customer_lists.id,advertisment_customer_lists.visit_count,advertisment_customer_lists.total_amount');
		$this->db->where('advertisment_customer_lists.user_id',$userId);
		$this->db->where('advertisment_customer_lists.parent_user_id',$parentUserId);
		$this->db->from('advertisment_customer_lists');
		$query = $this->db->get();
		$results=$query->row_array();
		if($results){
			$city_id=0;
			$area_id=0;
			if($alldata['city'])
			{	
				$city_id=$this->cityFindOrSave($alldata['city']);
				if($alldata['area'])
				{
					$area_id=$this->areaFindOrSave($alldata['area'],$city_id);
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
			$this->saveBillingInfo($parentUserId,$userId,$alldata);
		}
		else {
			$city_id=0;
			$area_id=0;
			if($alldata['city'])
			{	
				$city_id=$this->cityFindOrSave($alldata['city']);
				if($alldata['area'])
				{
					$area_id=$this->areaFindOrSave($alldata['area'],$city_id);
				}
			}	
			$data = array(
				'parent_user_id'=> $parentUserId,
				'user_id'=> $userId,			
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
			$this->saveBillingInfo($parentUserId,$userId,$alldata);
			return true;	
		}
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
	
	################ Send Feed Back ############
	public function save_feed_backs($user_id){
		
		    $data = array(
			'user_id'			=> $user_id,
			'message'			=> $this->input->post('message'),			
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),		
		);
		$this->db->insert('feed_backs', $data);
		$id = $this->db->insert_id();
		return true;
	}
	
	################ Send SendID ############
	public function saveSenderId($user_id){
		$data = array(
			'user_id'		=> $user_id,
			'sender_id'		=> $this->input->post('sender_id'),			
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),		
		);
		$this->db->insert('user_sender_ids', $data);
		$id = $this->db->insert_id();
		return true;
	}
	
	##### SENDER ID List ############
	public function getMySenderIdList($user_id, $limit_start, $limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS user_sender_ids.id,user_sender_ids.*',false);
		$this->db->where('user_sender_ids.user_id',$user_id);
		$this->db->from('user_sender_ids');
		$this->db->order_by('user_sender_ids.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	} 
	
	##### Enquiry List ############
	public function getMyEnquiryList($addId, $limit_start, $limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS advertisment_enquiry_list.id,advertisment_enquiry_list.*',false);
		$this->db->where('advertisment_enquiry_list.advertisment_id',$addId);
		$this->db->where('advertisment_enquiry_list.advertisment_id >',0);
		$this->db->from('advertisment_enquiry_list');
		$this->db->order_by('advertisment_enquiry_list.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	} 
	
	############ Create User ##############
	public function create_user($list,$password){
		
		    $data = array(
			'email'			=> strtolower($list['email']),			
 			'password'		=> md5($password),
			'display_name' => strtolower($list['owner']),
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
		$listContact=explode(',',$list['contact_number']);
		$mob_num=(isset($listContact[0])) ? $listContact[0]:'';
		if($id) {
			$data = array(
				'user_id'			=> $id,	
				'mobile_number'		=> $mob_num,
				'first_name'		=> $list['email'],	
				'created'			=> date('Y-m-d h:i:s'),
				'modified'			=> date('Y-m-d h:i:s'),
			);
			$this->db->insert('user_profiles', $data);
		}
		$add_datas=array();
		$add_datas['is_active']=0;
		$add_datas['user_id']=$id;
		$this->db->where('advertisements.id', $list['id']);
		$this->db->update('advertisements', $add_datas);
	}	
	
	############ Get Notifications ##########
	public function get_notifications_details(){
		
		$this->db->select('advertisements.id,advertisements.user_id,advertisements.email,advertisements.owner,advertisements.name,advertisements.contact_number');
		$this->db->from('advertisements');
		$this->db->where('advertisements.email !=','');
		$this->db->where('advertisements.plan','');
		$this->db->where('is_notification_send',0);
		$this->db->where('owner !=',"Not Available");
		$this->db->limit(0,500);
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	################ Update Noitifications #############
	public function update_notification_details($add_id){
		$add_datas=array();
		$add_datas['is_active']=0;
		$this->db->where('advertisements.id', $add_id);
		$this->db->update('advertisements', $add_datas);
	}
	
	############## User Add ###################
	public function get_user_details($user_id){

		$this->db->select('users.*');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	################ Create New User ###########
	public function create_new_user($userDetails) {
		
	    $data = array(
			'email'			=> strtolower($userDetails['email']),			
 			'password'		=> md5($userDetails['password']),
			'display_name' => $userDetails['name'],
			'user_type'		=>3,
			'is_approved' 	=> 1,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => 1,
			'is_active'		=> 1,
			'is_email_confirmed'=> 1,
			'uid'=> '1234567',			
		);
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		if($id) {
			$data = array(
				'user_id'			=> $id,	
				'mobile_number'		=> $userDetails['mobile_number'],
				'first_name'		=> $userDetails['name'],	
				'created'			=> date('Y-m-d h:i:s'),
				'modified'			=> date('Y-m-d h:i:s'),
			);
			$this->db->insert('user_profiles', $data);
		}
		
		return true;
	}
	
	#################### Search Categories ############
	public function get_search_categories_data($keyword=null, $type=null) {
	
		if($keyword) 
		{
			$this->db->like('name', $keyword,'after'); 
		}
		if($type!=null) 
		{
			$this->db->where('type',$type);
		}
		$this->db->where('is_active','1');
		$this->db->select('id,name');
		$query = $this->db->get('categories');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'text'=>$g->name);
		}
		return $arr;
	}
	
	#################### Services Categories ############
	public function get_search_services_data($keyword=null) {
	
		if($keyword) 
		{
			$this->db->like('name', $keyword,'after'); 
		}
		$this->db->where('is_active','1');
		$this->db->where('type','2');
		$this->db->select('id,name');
		$query = $this->db->get('categories');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'text'=>$g->name);
		}
		return $arr;
	}
	
	################## Save Payu Response ##################
	public function savePaymentResponse($paymentResponse,$status) {
		
		$paymentdetails_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'user_id'=>$paymentResponse['udf1'],
			'plan_id'=>$paymentResponse['udf2'],
			'payment_id'=>$paymentResponse['txnid'],
			'amount'=>$paymentResponse['amount'],
			'fees'=>$paymentResponse['additionalCharges'],
			'qunatity'=>1,
			'status'=>$paymentResponse['status'],
			'buyer_name'=>$paymentResponse['firstname'],
			'buyer_phone'=>$paymentResponse['phone'],
			'buyer_email'=>$paymentResponse['email'],
			'currency'=>'INR',
			'payment_status'=>$paymentResponse['status'],
		);
		$this->db->insert('plan_order', $paymentdetails_data);
		if($status=='success'){
			$planDetails=$this->getPlanDetails($paymentResponse['udf2']);
			$no_of_months=1;
			if(isset($planDetails['no_of_months']) && $planDetails['no_of_months']!=''){
				$no_of_months=$planDetails['no_of_months'];
			}
			$this->updateAdvertisments($paymentResponse['udf3'],$planDetails,$no_of_months);
			$this->credit_sms($paymentResponse['udf1'], $no_of_months * $planDetails['sms_counts'] );
		}
		else {
			
		}
		$data=array('is_verified'=>1);
		$this->db->where('transaction_id', $paymentResponse['txnid']);
		$this->db->update('payments', $data);
		return true;
	}
	
	################  Save Plan ################
	public function savePlanDetails($paymentResponse, $status, $payment_id=null, $addId, $user_id) {
		
		$userId=$this->session->userdata('user_id') ? $this->session->userdata('user_id') : '0';
		$planDetails=$this->getNewPlanDetails($paymentResponse['link_title']);
		$paymentdetails_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'user_id'=>$userId,
			'plan_id'=>$planDetails['id'],
			'payment_id'=>$payment_id,
			'amount'=>$paymentResponse['amount'],
			'fees'=>$paymentResponse['fees'],
			'qunatity'=>$paymentResponse['quantity'],
			'status'=>$paymentResponse['status'],
			'buyer_name'=>$paymentResponse['buyer_name'],
			'buyer_phone'=>$paymentResponse['buyer_phone'],
			'buyer_email'=>$paymentResponse['buyer_email'],
			'currency'=>$paymentResponse['currency'],
			'payment_status'=>$status
		);
		$this->db->insert('plan_order', $paymentdetails_data);
		if($status=='success') {
			$paymentClicksinfo=$this->planClicksInfo($planDetails['id'],$user_id);
			$no_of_months=1;
			if(isset($paymentClicksinfo['no_of_months']) && $paymentClicksinfo['no_of_months']!=''){
				
				$no_of_months=$paymentClicksinfo['no_of_months'];
			}
			$this->updateAdvertisments($addId,$planDetails,$no_of_months);
			$this->credit_sms($user_id,$no_of_months * $planDetails['sms_counts'] );
		}
		return true;
	}
	
	# Activate Advertisments 
	public function planClicksInfo($plan_id, $user_id){

		$this->db->select('plan_clicks.*');
		$this->db->from('plan_clicks');
		$this->db->where('plan_clicks.user_id',$user_id);
		$this->db->where('plan_clicks.plan_id',$plan_id);
		$this->db->order_by('plan_clicks.id','DESC');
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	# Activate Advertisments 
	public function updateAdvertisments($addId,$planDetails,$no_of_months){
	    
	    $date=date('Y-m-d', strtotime("+".$no_of_months." months"));
		$is_onetime_subscription=0;
		if($planDetails['id']==1){
		 $is_onetime_subscription=1;
		}
		$data=array('is_active'=>1,'expiry_date'=>$date,'plan_id'=>$planDetails['id'], 'is_onetime_subscription'=>$is_onetime_subscription);
		$this->db->where('id', $addId);
		$this->db->update('advertisements', $data);
		return true;
	}
	
	############ Save User sms Counts #####
	public function credit_sms($user_id,$total_sms){
		$this->load->model('campaign_model');
		$data=$this->campaign_model->sms_availabilty($user_id);
		$total_sms=$data['total_sms'] + $total_sms;
		$campaign_data=array (
			'total_sms'=>$total_sms,
		);
		$this->db->where('id',$user_id);
		$this->db->update('users',$campaign_data);
		return true;
	}
	
	############### Get Plan ID ##############
	public function getNewPlanDetails($planName) {
		
		$this->db->select('plans.*');
		$this->db->from('plans');
		$this->db->where('plans.name',$planName);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	################# Plan Details #########
	public function getPlanDetails($planId) {
		
		$this->db->select('plans.*');
		$this->db->from('plans');
		$this->db->where('plans.id',$planId);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	################# Sms Plan Details #########
	public function getSmsPlanDetails($planId) {
		
		$this->db->select('sms_packages.*');
		$this->db->from('sms_packages');
		$this->db->where('sms_packages.id',$planId);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	###################### Save Payment Clicks ###############
	public function saveSmsPaymentClicks($userId, $plan_id){
	    $data = array(
			'plan_id'=> $plan_id,
            'user_id'=> $userId,			
			'created' => date('Y-m-d h:i:s'),
		);
		$this->db->insert('sms_plan_clicks', $data);
		return true;	
	}
	
	################# Add Advertisments Data #########
	public function add_advertisments_image($image_data,$addId) {
		
		$advertisment_images_data=array(
		'created_at'=> date('Y-m-d h:i:s'),
		'updated_at'=> date('Y-m-d h:i:s'),
		'url'=>'',
		'image_dir'=>$image_data['image_dir'],
		'profile_image'=>$image_data['profile_image'],
		'advertisment_id'=>$addId
		);
		$this->db->insert('advertisment_images', $advertisment_images_data);
		return true;
	}
	
	################### Get Gallery List ############
	public function get_advertisments_image($addId){
		$this->db->select('advertisment_images.*');
		$this->db->from('advertisment_images');
		$this->db->where('advertisment_images.advertisment_id',$addId);
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	public function get_user_categories_data() {
		$this->db->select('categories.name,categories.id');
		$this->db->from('categories');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['name']);	
		}	
		return $new_results;
	}
	
	public function get_service_categories_data() {
		$this->db->select('categories.name,categories.id');
		$this->db->from('categories');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['name']);	
		}	
		return $new_results;
	}
	
	public function get_user_remainder_data($user_id) {
		$this->db->select('remainder_settings.name,remainder_settings.id');
		$this->db->from('remainder_settings');
		$this->db->where('remainder_settings.user_id',$user_id);
		$this->db->where('remainder_settings.remainder_type_id',3);
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['name']);	
		}	
		return $new_results;
	}
	
	
	############ Get Category Listing Front End ###############
	public function get_add_or_edit_business_data($add_id=null) {
		$this->db->select('categories.name as category_name,categories.id');
		$this->db->join('categories','categories.id=category_listing.category_id');	
	    $this->db->where('category_listing.listing_id',$add_id);
		$this->db->from('category_listing');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['id']);	
		}	
		return $new_results;
	}
	
	############ Get Category Listing Front End ###############
	public function get_add_or_edit_business_service_data($add_id=null) {
		$this->db->select('categories.name as category_name,categories.id');
		$this->db->join('categories','categories.id=advertisment_customer_service.category_id');	
	    $this->db->where('advertisment_customer_service.listing_id',$add_id);
		$this->db->from('advertisment_customer_service');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['id']);	
		}	
		return $new_results;
	}
	
	############ Get Category Listing Front End ###############
	public function get_add_or_edit_service_data($add_id=null) {
		$this->db->select('categories.name as category_name,categories.id');
		$this->db->join('categories','categories.id=advertisment_customer_service.category_id');	
	    $this->db->where('advertisment_customer_service.listing_id',$add_id);
		$this->db->from('advertisment_customer_service');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['id']);	
		}	
		return $new_results;
	}
	
	###################### Save Payment Clicks ###############
	public function savePaymentClicks($userId, $plan_id, $add_id){
	    $data = array(
			'plan_id'=> $plan_id,
            'user_id'=> $userId,			
			'created' => date('Y-m-d h:i:s'),
		);
		$this->db->insert('plan_clicks', $data);	
		return true;	
	}
	
	
	############# get Statistics Data ##############
	public function getStatisticsData($addId, $limit_start=10, $limit_end=0,$from_date=null,$to_date=null) {
		
		$date=date('Y-m-d');
		$this->db->select('SQL_CALC_FOUND_ROWS advertisment_views.id,advertisment_views.*',false);
		$this->db->where('advertisment_views.advertisment_id',$addId);
		if($from_date!='') { $from_date=date('Y-m-d H:i:s',strtotime($from_date)); $this->db->where('advertisment_views.created >=',$from_date); }
		if($to_date!=''){ $to_date=date('Y-m-d H:i:s',strtotime($to_date)); $this->db->where('advertisment_views.created <=',$to_date); }
		$this->db->from('advertisment_views');
		$this->db->order_by('advertisment_views.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;		
	}
	
	################# Plan Packges ##########################
	public function getPlanPackes($limit=null) {
		
		$limit=(isset($limit) && $limit!='') ? $limit : 4;
		$this->db->select('plans.*');
		$this->db->from('plans');
		$this->db->limit($limit);
		$query = $this->db->get();			
		$result=$query->result_array();
		return $result;	
	}
	
	################# CusTomer Today Views ###################
	public function getCustomerTodayViews($addId) {
		
		$date=date('Y-m-d');
		$this->db->select("browser as label, COUNT(*) as Total, (COUNT(*) / (SELECT COUNT(*) FROM advertisment_views WHERE advertisment_id=$addId)) * 100 AS data",false);
		$this->db->where('advertisment_views.advertisment_id',$addId);
		$this->db->where('advertisment_views.created >=',$date);
		$this->db->from('advertisment_views');
		$this->db->group_by('browser');
		$this->db->order_by('browser');
		$query = $this->db->get();
		$result=$query->result_array();
		if(!empty($result))
		{
			$new_response=array();
			foreach($result as $key=>$data)
			{
				$new_response[$key]['label']=ucwords($this->getLabel($data['label']));
				$new_response[$key]['Total']=$data['Total'];
				$new_response[$key]['value']=$data['Total'];
				$new_response[$key]['data']=$data['data'];
			}
			
			return $new_response;
		}
	}
	
	################# CusTomer Total Views ###################
	
	public function getCustomerTotalViews($addId) {
		$this->db->select("browser as label, COUNT(*) as Total, (COUNT(*) / (SELECT COUNT(*) FROM advertisment_views WHERE advertisment_id=$addId)) * 100 AS data",false);
		$this->db->where('advertisment_views.advertisment_id',$addId);
		$this->db->from('advertisment_views');
		$this->db->group_by('browser');
		$query = $this->db->get();
		$result=$query->result_array();
		if(!empty($result))
		{
			$new_response=array();
			foreach($result as $key=>$data)
			{
				$new_response[$key]['label']=ucwords($this->getLabel($data['label']));
				$new_response[$key]['Total']=$data['Total'];
				$new_response[$key]['value']=$data['Total'];
				$new_response[$key]['data']=$data['data'];
			}
			return $new_response;
		}
	}
	
	
	############## Get Browser Label################
	function getLabel($label=null) {
		
		$label=strtolower($label);
		$browserName=array( 
		' '               => 'UN',
		'unknown'         => 'Google Crawl',
		'mozilla firefox' => 'Firefox',
		'firefox'         => 'Firefox',
		'apple safari'    => 'Apple Safari',
		'google chrome'   => 'Google Chrome',
		'safari'          => 'Safari',
		'internet explorer'=>'Internet Explorer',
		'opera'=>'Opera',
		);
		$labelName=isset($browserName[strtolower($label)]) ? $browserName[strtolower($label)]:'Others';
		return $labelName; 
	}
	
	################# CusTomer Top Platforms ###################
	
	public function getCustomertopPlatForms($addId) {
		
		$this->db->select("COUNT(*) as value,platform as label, (COUNT(*) / (SELECT COUNT(*) FROM advertisment_views WHERE advertisment_id=$addId)) * 100 AS data",false);
		$this->db->where('advertisment_views.advertisment_id',$addId);
		$this->db->from('advertisment_views');
		$this->db->group_by('platform');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;
	}
		
	################ Get Blog List ####################
	
	public function getCustomerBlogList($userId,$limit_start=10,$limit_end=0) {
		 
	    $this->db->select('SQL_CALC_FOUND_ROWS blogs.id,blogs.*',false);
		$this->db->where('blogs.user_id',$userId);
		$this->db->from('blogs');
		$this->db->order_by('blogs.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$newresult=array();
		$response=array();
		foreach($result  as $key=>$res)
		{
			$newresult[$key]=array(date('d ,M Y',strtotime($res['created'])),ucwords($res['name']),$res['short_description'],$res['is_active'],$res['is_active'],$res['id']);
		}
		$response['iTotalDisplayRecords']=$this->get_all_rows();
		$response['iTotalRecords']=$this->get_all_rows();
		$response['data']=$newresult;
		return $response;
    }
	
	############### Notifications Details ############
	public function notificationDetails($notificaion_id,$user_id) {
		$this->db->select('notifications.*');
		$this->db->where('notifications.id',$notificaion_id);
		$query = $this->db->get('notifications');
		$result = $query->row_array();	
		return $result;
	}
	
	####################Customer Details#################
	
	public function customersDetails($user_id,$parent_id) {
		$this->db->select('users.email,users.id,users.contact_number,advertisment_customer_lists.visit_count,advertisment_customer_lists.is_birthday_remainder,advertisment_customer_lists.is_aniversy_reminder,advertisment_customer_lists.user_id,advertisment_customer_lists.total_amount,advertisment_customer_lists.last_bill_amount_paid,advertisment_customer_lists.is_active,user_profiles.*,groups.name as group_name,cities.name as city_name,cities.id as city_id,areas.name as area_name');
		$this->db->where('advertisment_customer_lists.parent_user_id',$parent_id);
		$this->db->where('advertisment_customer_lists.user_id',$user_id);
		$this->db->join('advertisment_customer_lists','users.id=advertisment_customer_lists.user_id');
		$this->db->join('user_profiles','user_profiles.user_id=users.id','left');
		$this->db->join('groups','groups.id=advertisment_customer_lists.group_id','left');
		$this->db->join('cities','cities.id=users.preferred_city_id','left');
		$this->db->join('areas','areas.id=users.preferred_area_id','left');
		$query = $this->db->get('users');
		$result = $query->row_array();	
		return $result;
	}
	
	####################Delete Customer#################
	public function deleteCustomer($id,$parent_user_id) {
	   $this->db->delete('advertisment_customer_lists',array('user_id' => $id,'parent_user_id'=>$parent_user_id));
	   return true;
	}
	
	####################Delete Gallery#################
	public function deleteGallery($id, $advertisment_id) {
	   $this->db->delete('advertisment_images',array('id' => $id,'advertisment_id'=>$advertisment_id));
	   return true;
	}

    ################ Get Customer List ####################
	public function getCustomerList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS advertisment_customer_lists.user_id,advertisment_customer_lists.first_name,advertisment_customer_lists.email,advertisment_customer_lists.visit_count,advertisment_customer_lists.is_active,advertisment_customer_lists.created,groups.name as group_name,advertisment_customer_lists.total_amount,advertisment_customer_lists.mobile_number',false);
		if(isset($_POST['s_name']) && !empty($_POST['s_name']))
		{
			$this->db->like('advertisment_customer_lists.first_name',$_POST['s_name'],'after'); 
		}
		if(isset($_POST['s_email']) && !empty($_POST['s_email']))
		{
			$this->db->like('advertisment_customer_lists.email',$_POST['s_email'],'after'); 
		}
		if(isset($_POST['s_mno']) && !empty($_POST['s_mno']))
		{
			$this->db->where('advertisment_customer_lists.mobile_number',$_POST['s_mno']); 
		}
		$this->db->where('advertisment_customer_lists.parent_user_id',$userId);
		$this->db->join('groups','groups.id=advertisment_customer_lists.group_id','left');
		$this->db->from('advertisment_customer_lists');
		$this->db->order_by('advertisment_customer_lists.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }
	
	################ Get Orders List ####################
	public function getMyOrdersList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS plan_order.id,plan_order.*, plans.name as plan_name',false);
		$this->db->where('plan_order.user_id',$userId);
		$this->db->from('plan_order');
		$this->db->join('plans','plans.id=plan_order.plan_id','left');
		$this->db->order_by('plan_order.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }
	
	#################Get Sms Packages################
	public function getSmsPackageList() {
		$this->db->select('sms_packages.*');
		$this->db->from('sms_packages');
		$this->db->limit(4);
		$query = $this->db->get();			
		$result=$query->result_array();
		return $result;
	}
	
    ################ Edit Customer Data#############
    public function upate_customers_status($addId)	
	{
		$this->db->where('id', $addId);
		$this->db->update('advertisment_customer_list', $data);
		return true;
	}

    ################ Edit Customer Data#############
    public function edit_customers($userId,$addId)	
	{
		$city_id=0;
		$area_id=0;
		if($this->input->post('city'))
		{
			$city_id=$this->cityFindOrSave($this->input->post('city'));
		}
		if($this->input->post('area'))
		{
			$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
		}
		$isActive=($this->input->post('is_active') && $this->input->post('is_active')=='on') ? 1 : 0;
		$data = array(
			'name'=> $this->input->post('name'),				
			'address'=>$this->input->post('address'),
			'city_id'=> $city_id,
			'area_id'=> $area_id,
			'website'=>$this->input->post('website'),
			'email'=>$this->input->post('email'),
			'user_id'=>$userId,
			'is_active'=>$isActive,
			'created'=> date('Y-m-d h:i:s'),
			'contact_number'=>$this->input->post('contact_number'),
		);
		$this->db->where('id', $addId);
		$this->db->update('advertisment_customer_list', $data);
		return true;
	}
	
	
    ############### Get User Bussiness Data ############
    public function get_user_businessdata($user_id,$field=null)
    {
		$this->db->select('advertisements.*,cities.name as city_name,areas.name as area_name');
		if($field=='id'){
			$this->db->where('advertisements.id',$user_id);
		}
		else{
			$this->db->where('advertisements.user_id',$user_id);	
		}
		$this->db->from('advertisements');
		$this->db->join('cities','cities.id=advertisements.city_id','left');
		$this->db->join('areas','areas.id=advertisements.area_id','left');
		$query = $this->db->get();			
		$result=$query->row_array(); 
		if(!empty($result))
		{
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	############### Get User Bussiness Data ############
    public function get_user_remainderdata($parent_user_id,$user_id){
		$this->db->select('remainder_settings.id,advertisment_customer_remainders.remainder_setting_id,advertisment_customer_remainders.service_date,remainder_settings.name');
		$this->db->where('advertisment_customer_remainders.user_id',$user_id);
		$this->db->where('advertisment_customer_remainders.parent_user_id',$parent_user_id);
		$this->db->from('advertisment_customer_remainders');
		$this->db->join('remainder_settings','remainder_settings.id=advertisment_customer_remainders.remainder_setting_id','left');
		$query = $this->db->get();			
		$result=$query->result_array(); 
		return $result;
	}
	
	################ Edit My Business######################
 	public function edit_business($addId, $user_id,$profile_image_data)
	{
		####### STEP 1 DATA #########
			$all_contact_number='';
			if($this->input->post('contact_number')){
				$all_contact_number=$this->input->post('contact_number');
			}
			if($this->input->post('contact_number1')){
				$all_contact_number=$all_contact_number.','.$this->input->post('contact_number1');
			}
			if($this->input->post('contact_number2')){
				$all_contact_number=$all_contact_number.','.$this->input->post('contact_number2');
			}
			$contact_numbers=explode(',',$all_contact_number);
			

			$contact_numbers=explode(',',$all_contact_number);
			$this->db->delete('advertisment_phones',array('advertisment_id' => $addId));	
			foreach($contact_numbers as $key=>$number)
			{  
				   if($key==0){$type='1';}else{$type='2';} 
				   $advertisment_phones_data=array(
					'created'=> date('Y-m-d h:i:s'),
					'advertisment_id'=>$addId,
					'number'=>$number,
					'type'=>$type,
					);
				$this->db->insert('advertisment_phones', $advertisment_phones_data);
			}		
			if(!empty($profile_image_data))
			{
				$data=array_merge($data,$profile_image_data);
			}			


			if($this->input->post('city')){
				$city_id=$this->cityFindOrSave($this->input->post('city'));
			}
			if($this->input->post('area')){
				$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
			}

			if($this->input->post('city')){
				$city_id=$this->cityFindOrSave($this->input->post('city'));
			}
			if($this->input->post('area')){
				$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
			}
			$main_category_id=0;
			if($this->input->post('main_category'))
			{
				$main_category_id=$this->mainCategoryFindOrSave($this->input->post('main_category'));
			}
			$category_data_id=array();
			if($this->input->post('keywords')) {
				foreach($this->input->post('keywords') as $key=>$name){
					$category_data_id[]=(is_numeric($name)) ? $name : $this->categoryFindOrSave($name);
				}
			}
			
			$service_data_id=array();
			if($this->input->post('service')) {
				foreach($this->input->post('service') as $key=>$name){
					$service_data_id[]=(is_numeric($name)) ? $name : $this->serviceFindOrSave($name);
				}
			}
			
			$category_data_ids['category_id']=implode(',',array_merge($category_data_id,$service_data_id));
			$this->db->delete('category_listing',array('listing_id' => $addId));	
			foreach($category_data_id as $id) {
				$listing_data=array(
				'created_at'=> date('Y-m-d h:i:s'),
				'listing_id'=>$addId,
				'city_id'=>$city_id,
				'area_id'=>$area_id,
				'category_id'=>$id,
				);
				$this->db->insert('category_listing', $listing_data);
			}
			$category_data_id_update =(!empty($category_data_ids['category_id'])) ? $category_data_ids['category_id'] : '';
			$notification_settings=array();
			$custom_meta=($this->input->post('custom_meta')=='on' || $this->input->post('custom_meta')==1) ? 1 : 0;
			$social_media=($this->input->post('social_media')=='on' || $this->input->post('social_media')==1) ? 1 : 0;
			$enquiry_via_mail=($this->input->post('enquiry_via_mail')=='on' || $this->input->post('enquiry')==1) ? 1 : 0;
			$monthly_analytics=($this->input->post('monthly_analytics')=='on' || $this->input->post('monthly_analytics')==1) ? 1 : 0;
			$notification_settings=array('custom_meta'=>$custom_meta,'social_media'=>$social_media,'enquiry_via_mail'=>$enquiry_via_mail,'monthly_analytics'=>$monthly_analytics);
			$notification_settings=serialize($notification_settings);
			

			$other_info=array('facebook_url'=>$this->input->post('facebook_url'),'googleplus_url'=>$this->input->post('googleplus_url'),'twitter_url'=>$this->input->post('twitter_url'),'linkedin_url'=>$this->input->post('linkedin_url'),'youtube_url'=>$this->input->post('youtube_url'),'whatsup_contact_number'=>$this->input->post('whatsup_contact_number'));
			$other_info=serialize($other_info);
		
			if($this->input->post('city')){
				$city_id=$this->cityFindOrSave($this->input->post('city'));
			}
			if($this->input->post('area')){
				$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
			}
			
			$category_data_id=array();
			if($this->input->post('keywords')) {
				foreach($this->input->post('keywords') as $key=>$name){
					$category_data_id[]=(is_numeric($name)) ? $name : $this->categoryFindOrSave($name);
				}
			}
			
			
			$service_data_id=array();
			if($this->input->post('service')) {
				foreach($this->input->post('service') as $key=>$name){
					$service_data_id[]=(is_numeric($name)) ? $name : $this->serviceFindOrSave($name);
				}
			}
			
			$category_ids=implode(',',array_merge($category_data_id,$service_data_id));
			if($category_ids!=''){
				$data=array('category_id'=>$category_ids);
			}
			$this->db->delete('advertisment_customer_service',array('listing_id' => $addId));	
			foreach($service_data_id as $id) {
				$listing_data=array(
				'created'=> date('Y-m-d h:i:s'),
				'listing_id'=>$addId,
				'city_id'=>$city_id,
				'area_id'=>$area_id,
				'category_id'=>$id,
				);
				$this->db->insert('advertisment_customer_service', $listing_data);
			}
			
			$data = array(	
				'name'=> $this->input->post('name'),			
				'owner'=> $this->input->post('owner'),	
				'email'=>$this->input->post('email'),
				'no_of_employees'=> $this->input->post('no_of_employees'),			
				'since'=> $this->input->post('since'),	
				'website'=>$this->input->post('website'),
				'contact_number'=>$all_contact_number,
				'address_line'=>$this->input->post('address_line'),
				'city_id'=> $city_id,
				'city_name'=>$this->input->post('city'),
				'area_name'=>$this->input->post('area'),
				'area_id'=> $area_id,
				'zip' =>$this->input->post('zip'),
				'fax'=>$this->input->post('fax'),
				'working_start'=>$this->input->post('working_start'),
				'working_end'=>$this->input->post('working_end'),
				'latitude'=>$this->input->post('latitude'),
				'longitude'=>$this->input->post('longitude'),
				'notification_settings'=>$notification_settings,
				'category_id'=>$category_data_id_update,
				'main_category_id'=>$main_category_id,
				'meta_keywords'=>'',
				'meta_description'=>'',
				'description'=>$this->input->post('description'),
				'short_description'=>$this->input->post('short_description'),
				'other_info'=>$other_info
			);
			$common_data=array('updated_at'=> date('Y-m-d h:i:s'),'user_id'=>$user_id);
			$data=array_merge($common_data,$data);
			$this->db->where('id', $addId);
			$this->db->update('advertisements', $data);		
	
	    return true;
	}
	
	################## Update Advertisment Views Count############
	public function update_views_counts($add_id=null,$view_count=0,$user_id)
	{
		$view_count=1+$view_count;
		$data=array('view_count'=>$view_count);
		$this->db->where('id', $add_id);
		$this->db->update('advertisements', $data);
		$this->advertisment_view_count($add_id,$user_id);
	}
	
	################## Advertisment Views Count Update ############
	public function advertisment_view_count($add_id,$user_id)
	{
        $ua=$this->getBrowser();
	    $advertisment_views_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'advertisment_id'=>$add_id,
			'browser'=>$ua['name'],
			'browser_version'=>$ua['version'],
			'platform'=>$ua['platform']
			);
		$ipData=$this->getLocationInfoByIp();
		$advertisment_views_data=array_merge($ipData,$advertisment_views_data);
		$this->db->insert('advertisment_views', $advertisment_views_data);
		$new_data=array('browser'=>$ua['name'],'city'=>$ipData['city'],'ip'=>(isset($ipData['ip'])) ? $ipData['ip']:'','user_id'=>$user_id);
		if($user_id > 1){
		    $this->notification_model->common_save_notification('VIEW',$new_data);
		}
	}	
	
	#############Get ip Based Info##############
	function getLocationInfoByIp() {
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = @$_SERVER['REMOTE_ADDR'];
		$result  = array('country'=>'', 'city'=>'');
		if(filter_var($client, FILTER_VALIDATE_IP)){
			$ip = $client;
		}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
			$ip = $forward;
		}else{
			$ip = $remote;
		}
		$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
		if($ip_data && $ip_data->geoplugin_countryName != null){
			$result['country'] = $ip_data->geoplugin_countryName;
			$result['city'] = $ip_data->geoplugin_city;
			$result['ip'] = $remote;
		}
		return $result;
     }

    ########## Front End Profile Add ######################
	public function add_data($add_data,$category_data,$contact_data) {

		$city_id=$add_data['city_id'];
		$area_id=$add_data['area_id'];
        $category_data_new=explode(',',$category_data);	
		$category_data_id=array();
		foreach($category_data_new as $key=>$name)
		{
			$name=str_replace('&', 'And', $name);
			$name=str_replace('"', '', $name);
			$name=str_replace("'", '', $name);
			$category_data_id[]=$this->categoryFindOrSave($name);
		}
		$category_data_ids['category_id']=implode(',',$category_data_id);
		$add_data=array_merge($add_data,$category_data_ids);
		$this->db->insert('advertisements', $add_data);
		$last_insert_id = $this->db->insert_id();
		foreach($category_data_id as $key=>$value)
		{
			$cat_data=array(
			'created_at'=> date('Y-m-d h:i:s'),
			'listing_id'=>$last_insert_id,
			'city_id'=>$city_id,
			'area_id'=>$area_id,
			'category_id'=>$value,
			);
		   $this->db->insert('category_listing', $cat_data);
	    }
		
		  $contact_numbers=explode(',',$contact_data);
		  foreach($contact_numbers as $key=>$number)
		  {  
			   if($key==0){$type='1';}else{$type='2';}
			   $advertisment_phones_data=array(
				'created'=> date('Y-m-d h:i:s'),
				'advertisment_id'=>$last_insert_id,
				'number'=>$number,
				'type'=>$type,
				);
			   $this->db->insert('advertisment_phones', $advertisment_phones_data);
		  }		
	}
	
	#############Import Data##############
	public function add_business($userId, $profile_image_data=array()){
		$city_id='0';
		$area_id='0';
		$last_insert_id='0';
		$category_id='0';
		$all_contact_number='';
		if($this->input->post('contact_number'))
		{
			$all_contact_number=$this->input->post('contact_number');
		}
		if($this->input->post('contact_number1'))
		{
			$all_contact_number=$all_contact_number.','.$this->input->post('contact_number1');
		}
		
		if($this->input->post('contact_number2'))
		{
			$all_contact_number=$all_contact_number.','.$this->input->post('contact_number2');
		}
		$contact_numbers=explode(',',$all_contact_number);
		if($this->input->post('city'))
		{
			$city_id=$this->cityFindOrSave($this->input->post('city'));
		}
		if($this->input->post('area'))
		{
			$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
		}
		$main_category_id=0;
		if($this->input->post('main_category'))
		{
			$main_category_id=$this->mainCategoryFindOrSave($this->input->post('main_category'));
		}
		$category_data_id=array();
		$category_data_ids['category_id']=array();
		if($this->input->post('keywords')!=''){
			foreach($this->input->post('keywords') as $key=>$name)
			{
				$category_data_id[]=(is_numeric($name)) ? $name : $this->categoryFindOrSave($name);
			}
			$category_data_ids['category_id']=implode(',',$category_data_id);
		}
		
		$other_info=array('facebook_url'=>$this->input->post('facebook_url'),'googleplus_url'=>$this->input->post('googleplus_url'),'twitter_url'=>$this->input->post('twitter_url'),'linkedin_url'=>$this->input->post('linkedin_url'),'youtube_url'=>$this->input->post('youtube_url'),'whatsup_contact_number'=>$this->input->post('whatsup_contact_number'));
		$other_info=serialize($other_info);
		$notification_settings=array('custom_meta'=>$this->input->post('custom_meta'),'social_media'=>$this->input->post('social_media'),'enquiry_via_mail'=>$this->input->post('enquiry_via_mail'),'monthly_analytics'=>$this->input->post('monthly_analytics'));
		$notification_settings=serialize($notification_settings);
		
		$service_data_id=array();
		if($this->input->post('service')!=''){
			foreach($this->input->post('service') as $key=>$name)
			{
				$service_data_id[]=(is_numeric($name)) ? $name : $this->serviceFindOrSave($name);
			}
			$category_data_ids['category_id']=implode(',',array_merge($category_data_id,$service_data_id));
		}
		$category_data_id_with_comma=(!empty($category_data_ids['category_id']))? $category_data_ids['category_id'] :'';
		
		$data = array(
			'name'=> $this->input->post('name'),			
 			'owner'=> $this->input->post('owner'),	
			'no_of_employees'=> $this->input->post('no_of_employees'),			
 			'since'=> $this->input->post('since'),				
			'address_line'=>$this->input->post('address_line'),
			'city_id'=> $city_id,
			'area_id'=> $area_id,
			'zip' =>$this->input->post('zip'),
			'fax'=>$this->input->post('fax'),
			'website'=>$this->input->post('website'),
			'description'=>$this->input->post('description'),
			'short_description'=>$this->input->post('short_description'),
			'latitude'=>$this->input->post('latitude'),
			'longitude'=>$this->input->post('longitude'),
			'working_start'=>$this->input->post('working_start'),
			'working_end'=>$this->input->post('working_end'),
			'email'=>$this->input->post('email'),
			'user_id'=>$userId,
			'category_id'=>$category_data_id_with_comma,
			'main_category_id'=>$main_category_id,
			'created_at'=> date('Y-m-d h:i:s'),
			'overall_score'=>5,
			'site_score'=>4,
			'city_name'=>$this->input->post('city'),
			'area_name'=>$this->input->post('area'),
			'contact_number'=>$all_contact_number,
			'meta_keywords'=>$this->input->post('meta_keywords'),
			'meta_description'=>$this->input->post('meta_description'),
			'other_info'=>$other_info,
			'notification_settings'=>$notification_settings
		);
		if(!empty($profile_image_data))
		{
			$data=array_merge($data,$profile_image_data);
		}
		$this->db->insert('advertisements', $data);
		$last_insert_id = $this->db->insert_id();
		
		foreach($category_data_id as $id) {
			
			$listing_data=array(
			'created_at'=> date('Y-m-d h:i:s'),
			'listing_id'=>$last_insert_id,
			'city_id'=>$city_id,
			'area_id'=>$area_id,
			'category_id'=>$id,
			);
		    $this->db->insert('category_listing', $listing_data);
		}
		
		foreach($service_data_id as $id) {
			
			$service_data=array(
				'created'=> date('Y-m-d h:i:s'),
				'listing_id'=>$last_insert_id,
				'city_id'=>$city_id,
				'area_id'=>$area_id,
				'category_id'=>$id,
			);
		    $this->db->insert('advertisment_customer_service', $service_data);
		}
		
	  $contact_numbers=explode(',',$all_contact_number);
	  foreach($contact_numbers as $key=>$number)
	  {  
	       if($key==0){$type='1';}else{$type='2';}
		   $advertisment_phones_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'advertisment_id'=>$last_insert_id,
			'number'=>$number,
			'type'=>$type,
			);
		   $this->db->insert('advertisment_phones', $advertisment_phones_data);
	  }
	  return true;
	}
	
	######### City Find Or Save ######## 
	public function cityFindOrSave($name){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$name);
		$query = $this->db->get('cities');
		$res = $query->row();
		if(!empty($res))
		{
			return $res->id;
		}
		else
		{
			$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$name,
			'country_id'=>0,
			'state_id'=>0,
			'is_active'=>1,
			);
         $this->db->insert('cities', $table_data);			
		 return $this->db->insert_id();
		}
	}
	
	#######Area Find Or Save ###########
	public function areaFindOrSave($name,$city_id){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$name);
		$query = $this->db->get('areas');
		$res = $query->row();
		if(!empty($res))
		{
			return $res->id;
		}
		else
		{
			$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$name,
			'country_id'=>0,
			'state_id'=>0,
			'city_id'=>$city_id,
			'is_active'=>1,
			);
         $this->db->insert('areas', $table_data);			
		 return $this->db->insert_id();
		}
	}
	
	#######Area Find Or Save ###########
	public function mainCategoryFindOrSave($name){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$name);
		$query = $this->db->get('main_category');
		$res = $query->row();
		if(!empty($res))
		{
			return $res->id;
		}
		else
		{
			$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$name,
			'is_active'=>1,
			);
         $this->db->insert('main_category', $table_data);			
		 return $this->db->insert_id();
		}
	}
	
	############ Category Find Or Save ########
	public function categoryFindOrSave($name){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$name);
		$query = $this->db->get('categories');
		$res = $query->row();
		if(!empty($res))
		{
			return $res->id;
		}
		else
		{
			$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$name,
			'is_active'=>0,
			);
         $this->db->insert('categories', $table_data);			
		 return $this->db->insert_id();
		}
	} 
	
	############ Service Find Or Save ########
	public function serviceFindOrSave($name){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$name);
		$this->db->where('type',2);
		$query = $this->db->get('categories');
		$res = $query->row();
		if(!empty($res))
		{
			return $res->id;
		}
		else
		{
			$table_data=array(
				'created'=>date('Y-m-d h:i:s'),
				'name'=>$name,
				'type'=>2,
				'is_active'=>0,
			);
			$this->db->insert('categories', $table_data);			
			return $this->db->insert_id();
		}
	} 
	
	################# Get Advertisment ##################
	public function get_advertisments($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) {  
		$this->db->select('SQL_CALC_FOUND_ROWS advertisements.id,advertisements.id,advertisements.user_id,advertisements.created,advertisements.name,advertisements.owner,advertisements.address_line,advertisements.city_name,advertisements.is_active,advertisements.email,advertisements.owner,users.email AS user_email ,users.id AS user_id',false);

				$this->db->join('users','users.id=advertisements.user_id','left');
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
		{
			$this->db->order_by('advertisements.id', $order_type);
		}
		else{
			$this->db->order_by($sort_field, $order_type);
		}
		
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get('advertisements');	

		$response['list']=$query->result_array(); 
		$response['total']=$this->get_all_rows();
		return $response;
	}
	
	##############Delete Advertisments###########
	public function delete($id) {
		$this->db->select('id');
		$this->db->where('id',$id);
		$query = $this->db->get('advertisements');
		$res = $query->row();
		
		$this->db->delete('advertisements',array('id' => $id));
		$report = array();
		$report['error'] = $this->db->error();
		$report['message'] = $this->db->error();
		if($report !== 0) {
			return true;
		} else {
			return false;
		}
	}
	
	################## Update Advertisments Status##########
	public function update_status($id, $data) {	
		$this->db->where('id', $id);
		$this->db->update('advertisements', $data);
	
		$report = array();
		$report['error'] = $this->db->error();
		$report['message'] = $this->db->error();

		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	#Admin - Get Advertisments Detail
	public function get_advertisment_detail($id=null){
		$this->db->select('advertisements.*,states.name as state_name,countries.name as country_name,GROUP_CONCAT(advertisment_phones.number) as contact_number');
		$this->db->where('advertisements.id',$id);
		$this->db->from('advertisements');
		$this->db->join('states','states.id=advertisements.state_id','left');
		$this->db->join('countries','countries.id=advertisements.country_id','left');
		$this->db->join('advertisment_phones','advertisment_phones.advertisment_id=advertisements.id','left');
		$query = $this->db->get();			
		return $query->row_array(); 
	}
	
	
	############ City Details ##############
	public function city_details($city_name) {
		$this->db->select('cities.*');
		$this->db->where('cities.name',$city_name);
		$query = $this->db->get('cities');
		$result=$query->row_array();
		return $result;
	}
	
	############ Category Details ##############
	public function category_details($cat_name) {
		$this->db->select('categories.*');
		$this->db->where('categories.name',$cat_name);
		$query = $this->db->get('categories');
		$result=$query->row_array();
		return $result;
	}
	
	#Front End - Advertisment List
	public function get_add_list($type=null,$limit_start=10, $limit_end=0,$city=null,$area=null,$keyword=null,$category=null,$home_category=null,$r_category=null){
		
		$list_id=array();
		$home_list_id=array();
		$category_set='';
	
		$categories_result=array();
		#Category Based Search
		if(!empty($r_category)) {
			$this->db->select('categories.id as cat_id');
			$this->db->where('categories.name',$r_category);
			$query = $this->db->get('categories');
		    $categories_result=$query->row_array();
			if(!empty($categories_result)) {
				$res[]=$categories_result['cat_id'];
				$category_set=array_unique($res);
			}
		}
		#Category Based Search
		if(!empty($category)) {
			$category_set[]=$category;	
		}
		
		$this->db->select('SQL_CALC_FOUND_ROWS advertisements.id,advertisements.total_user_rated,advertisements.contact_number,advertisements.id,advertisements.zip,advertisements.name as add_name,advertisements.owner,
		advertisements.address_line,advertisements.rating,advertisements.working_start,advertisements.working_end,advertisements.category_id,	advertisements.city_name,advertisements.area_name,advertisements.areas,advertisements.short_description,advertisements.image_dir,advertisements.profile_image,advertisements.email,advertisements.website,advertisements.site_score,advertisements.overall_score,advertisements.rating',false);
		$this->db->where('advertisements.is_active','1');		
		
		if($category_set!='') {
			foreach($category_set as $key=>$set) {	
				if($key==0) {
				  $this->db->where("FIND_IN_SET('$set',category_id) !=", 0);
				}			 
			}
		}
		
		#City Based Search
		if(!empty($city)) {
			$this->db->where('advertisements.city_name',$city);	
		}
		
		#Area Based Search
		if(!empty($area)) {
			$this->db->where('advertisements.area_name',$area);
		}
		
		#Keyword Based Search
		if(!empty($keyword) && empty($category)) {
			$this->db->like('LOWER(advertisements.name)',$keyword);
		}
		
		$this->db->from('advertisements');   
		$this->db->limit($limit_start, $limit_end);
		$this->db->order_by("advertisements.plan_id", "DESC"); 
		$query = $this->db->get();	
		$results['listings']=$query->result_array();
//	echo $this->db->last_query();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results_row["category_details"]=$categories_result;
		$results=array_merge($results,$results_row);
	
		return $results;
	}
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	#Front End - Get Advertisment Detail
	public function get_add_detail($id=null){
		$this->db->select('advertisements.*, category_id as list_cat_id');
		$this->db->where('advertisements.id',$id);
		$this->db->where('advertisements.is_active','1');
		$this->db->from('advertisements');
		$query = $this->db->get();			
		$results=$query->row_array(); 
	
		return $results;
	}
	
	#Front End - Get Advertisment Detail
	public function get_add_preview_detail($id=null){
		$this->db->select('advertisements.*, category_id as list_cat_id');
		$this->db->where('advertisements.id',$id);
		$this->db->from('advertisements');
		$query = $this->db->get();			
		$results=$query->row_array(); 
		return $results;
	}
	

    #Front End - Get Advertisment Contacts	
	public function get_contact_detail($id=null){
		$this->db->select('advertisment_phones.type,advertisment_phones.number');
		$this->db->where('advertisment_phones.advertisment_id',$id);
		$this->db->from('advertisment_phones');
		$query = $this->db->get();			
		return $query->result_array(); 
	}
	
	#Front End - Get Advertisment Images	
	public function get_add_image($id=null){
		$this->db->select('advertisment_images.*');
		$this->db->where('advertisment_images.advertisment_id',$id);
		$this->db->from('advertisment_images');
		$query = $this->db->get();			
		return $query->result_array(); 
	}
	
	#Front End - Category list
    public function get_category_list($add_id=null,$keyword=null,$city=null,$area=null,$add_name=null){
		$add_id=explode(',',$add_id);
		$this->db->select('GROUP_CONCAT(categories.parent) as parent_ids');
		$this->db->where('categories.parent !=','0');
		$this->db->where_in('categories.id',$add_id);
		$this->db->from('categories');
		$query = $this->db->get();			
		$results=$query->row_array();
		
		$main_category=$results['parent_ids'];
		$this->db->select('categories.id,categories.name');
		$this->db->where('categories.is_active','1');
	    $this->db->join('category_listing','category_listing.category_id=categories.id','left');	
		if(!empty($main_category))
		{
		  $main_category=explode(',',$main_category);
		  $this->db->where_in('categories.parent',$main_category);
		}
		$this->db->group_start();
		if(!empty($keyword))
		{
		    $split_array=explode(' ',$keyword);
			foreach($split_array as $result)
			{
				$this->db->or_like('categories.name',$result);
			}			
		}
		if(!empty($add_name))
		{
		    $split_array=explode(' ',$add_name);
			foreach($split_array as $result)
			{
				$this->db->or_like('categories.name',$result);
			}
		}
		$this->db->group_end();
		#City Based Search
		if(!empty($city))
		{
			$this->db->where('cities.name',$city);	
			$this->db->join('cities','cities.id=category_listing.city_id');
		}
		
		#Area Based Search
		if(!empty($area))
		{
			$this->db->where('areas.name',$area);
			$this->db->join('areas','areas.id=category_listing.area_id');
		}
		$this->db->group_by('categories.id');
		$this->db->limit('10');
		$this->db->from('categories');
		$query = $this->db->get();			
		$results=$query->result_array();	
		return $results;
	}	
	
	############Get New List Category #############
	public function get_new_list_category($category){	
	    $results=array();
	    if($category!='')
		{
			$category=explode(',',$category);
			$category=array_filter($category);
		    $category=array_unique($category);
			$category=implode(',',$category);
			$this->db->select('categories.id,categories.name');
			$this->db->where('categories.is_active','1');
			$this->db->where('categories.id IN('.$category.')');
			$this->db->limit('10');
			$this->db->order_by('categories.name','ASC');
			$this->db->from('categories');
			$query = $this->db->get();			
			$results=$query->result_array();		
		}
		return $results;
	}
	
	#Get List Category
	public function get_list_category($category=null,$keyword=null,$city=null,$area=null,$category_name=null,$home_category=null){		
		$this->db->select('categories.id,categories.name,advertisements.id as add_id');
		$this->db->where('categories.is_active','1');
		#City Based Search
		if(!empty($city))
		{
			$this->db->where('cities.name',$city);	
		}
		
		#Area Based Search
		if(!empty($area))
		{
			$this->db->where('areas.name',$area);
		}
		if(!empty($keyword))
		{
		    $split_array=explode(' ',$keyword);
			foreach($split_array as $result)
			{
				$this->db->or_like('categories.name',$result);
			}			
		}
		if(!empty($category_name))
		{
		    $split_array=explode(' ',$category_name);
			foreach($split_array as $result)
			{
				$this->db->or_like('categories.name',$result);
			}
		}
		$this->db->join('category_listing','category_listing.category_id=categories.id');
		$this->db->join('advertisements','advertisements.id=category_listing.listing_id');
		$this->db->join('areas','areas.id=category_listing.area_id');
		$this->db->join('cities','cities.id=category_listing.city_id');
		$this->db->group_by('categories.id');		
		$this->db->limit('10');
		$this->db->order_by('categories.name','ASC');
		$this->db->from('categories');
		$query = $this->db->get();			
		$results=$query->result_array();		
		return $results;
	}
	
	#Get Category Results
	public function get_related_list($type=null,$limit_start=10, $limit_end=0,$city=null,$area=null,$keyword=null,$category=null,$home_category=null){
		$this->db->select('advertisements.total_user_rated,advertisements.contact_number,advertisements.id,advertisements.name as add_name,advertisements.owner,advertisements.address_line,advertisements.zip,advertisements.rating,advertisements.working_start,advertisements.working_end,cities.name as city_name,states.name as state_name,areas.name as area_name,advertisements.areas,advertisements.overall_score,advertisements.site_score,advertisements.email');
		$this->db->where('advertisements.is_active','1');	 
		#City Based Search
		if(!empty($city_name))
		{
			$this->db->where('cities.name',$city_name);	
		}
		#Area Based Search
		if(!empty($area_name))
		{
			$this->db->where('areas.name',$area_name);
		}
		if(!empty($keyword))
		{
		    $split_array=explode(' ',$keyword);
			foreach($split_array as $result)
			{
				$this->db->or_like('advertisements.name',$result);
			}			
		}
		if(!empty($home_category))
		{
		    $split_array=explode(' ',$home_category);
			foreach($split_array as $result)
			{
				$this->db->or_where('advertisements.name LIKE',$result);
			}
		}
		if(!empty($category_name))
		{
		    $split_array=explode(' ',$category_name);
			foreach($split_array as $result)
			{
				$this->db->or_like('advertisements.name',$result);
			}
		}
		$this->db->from('advertisements');
	    $this->db->join('areas','areas.id=advertisements.area_id','left');
		$this->db->join('cities','cities.id=advertisements.city_id','left');
		$this->db->join('states','states.id=advertisements.state_id','left');
		$this->db->order_by('advertisements.id','RANDOM');
		$this->db->group_by('advertisements.id');
		$this->db->limit(10);
		$query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	#############Get Advertisments Images #################
	public function get_add_images($id=null){
		    $this->db->select('advertisment_images.url as image_url');
		    $this->db->from('advertisment_images');
			$this->db->where('advertisment_images.advertisment_id',$id);
			$this->db->where('advertisment_images.type','1');
			$this->db->limit('1');
			$query = $this->db->get();
            return $query->row_array();	
	}
	
	############Get Advertisments Values############
	function get_values($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('advertisements');
		return $query->row_array();
	}
	
	##################### Admin Panel Edit Function ##################
	public function edit($id){	
		if($this->input->post('step')=='1'){
			
			$data = array(
				'name'=> $this->input->post('name'),			
				'owner'=> $this->input->post('owner'),		
				'address_line'=>$this->input->post('address_line'),
				'zip' =>$this->input->post('zip'),
				'fax'=>$this->input->post('fax'),
				'website'=>$this->input->post('website'),
				'working_start'=>$this->input->post('working_start'),
				'working_end'=>$this->input->post('working_end'),
				'since'=>$this->input->post('since'),
				'no_of_employees'=>$this->input->post('no_of_employees'),
				'email'=>$this->input->post('email')
		    );
		}
		if($this->input->post('step')=='2'){
			
			$data = array(
				'description'=> $this->input->post('description'),			
		    );
		}
		if($this->input->post('step')=='3'){
			$other_info=array('facebook_url'=>$this->input->post('facebook_url'),'googleplus_url'=>$this->input->post('googleplus_url'),'twitter_url'=>$this->input->post('twitter_url'),'linkedin_url'=>$this->input->post('linkedin_url'),'youtube_url'=>$this->input->post('youtube_url'),'whatsup_contact_number'=>$this->input->post('whatsup_contact_number'));
			$other_info=serialize($other_info);
			$data = array(	
				'other_info'=>$other_info
			);
		}
		if($this->input->post('step')=='4'){
			$city_id='0';
			$area_id='0';
			if($this->input->post('city')){	
				$city_id=$this->cityFindOrSave($this->input->post('city'));
			}	
			if($this->input->post('area')){
				$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
			}
			$data = array(
				'city_name'=> $this->input->post('city_name'),
				'area_name'=> $this->input->post('area_name'),
				'city_id'=> $city_id,				
				'area_id'=> $area_id,
                'latitude'=> $this->input->post('latitude'),
				'longitude'=> $this->input->post('longitude')	
		    );
		}
		if($this->input->post('step')=='5'){
			$data = array(
				'description'=> $this->input->post('description'),			
		    );
		}
		$this->db->where('id', $id);
		$this->db->update('advertisements', $data);
	}
	
	############ Get Category Listing Front End ###############
	public function get_business_data($add_id=null){
		$this->db->select('categories.name as category_name,cities.name as city_name,areas.name as area_name');
		$this->db->join('categories','categories.id=category_listing.category_id');	
		$this->db->join('advertisements','advertisements.id=category_listing.listing_id');
		$this->db->join('areas','areas.id=category_listing.area_id');
		$this->db->join('cities','cities.id=category_listing.city_id');
	    $this->db->where('category_listing.listing_id',$add_id);
		$this->db->where('categories.is_active', true);
		$this->db->from('category_listing');
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	############ Get Service Listing Front End ###############
	public function get_service_data($add_id=null){
		$this->db->select('categories.name as category_name,cities.name as city_name,areas.name as area_name');
		$this->db->join('categories','categories.id=advertisment_customer_service.category_id');	
		$this->db->join('advertisements','advertisements.id=advertisment_customer_service.listing_id');
		$this->db->join('areas','areas.id=advertisment_customer_service.area_id');
		$this->db->join('cities','cities.id=advertisment_customer_service.city_id');
	    $this->db->where('advertisment_customer_service.listing_id',$add_id);
		$this->db->where('categories.is_active',true);
		$this->db->from('advertisment_customer_service');
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	################ Get Bussines  Listings ###################
	public function get_business_listings($limit_start=10, $limit_end=0){
		$this->db->select('categories.name as category_name,cities.name as city_name,areas.name as area_name');
		$this->db->join('categories','categories.id=category_listing.category_id','left');	
		$this->db->join('areas','areas.id=category_listing.area_id','left');
		$this->db->join('cities','cities.id=category_listing.city_id','left');
		$this->db->from('category_listing');
		$this->db->limit($limit_start, $limit_end);
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	
	############## Get Browser View#####################
    public function getBrowser(){
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Others';
		$platform = 'Others';
		$version= "";

		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
	   
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}
	   
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
	   
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
	   
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
	   
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
   }
   
   	function changeEnquiryStatus($id,$is_active){
		$data=array('is_active'=>$is_active);
		$this->db->where('id', $id);
		$this->db->update('advertisment_enquiry_list', $data);
		return true;
	}
}