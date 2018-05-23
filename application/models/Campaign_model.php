<?php
class Campaign_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
		$this->load->model('cron_model');
    }
	
	##### update Reedmed Offer ##########
    public function reedemPoints($parent_user_id, $user_id, $points){
		
		$reponse=array();
		$this->db->select('advertisment_customer_lists.id,advertisment_customer_lists.total_reward_points,advertisment_customer_lists.total_redeemed_points', false);
		$this->db->where('advertisment_customer_lists.user_id',$user_id);
		$this->db->where('advertisment_customer_lists.parent_user_id',$parent_user_id);
		
		$this->db->from('advertisment_customer_lists');
		$query = $this->db->get();
		$result=$query->row_array();
		
		if(!empty($result) && $result['total_reward_points'] >= $points){
			$total_redeemed_points= $result['total_redeemed_points'];
			$total_reward_points=$result['total_reward_points'] - $points;
			$total_redeemed_points=$total_redeemed_points+$points;
			$campaign_data=array(
				'total_reward_points'=>$total_reward_points,
				'total_redeemed_points'=>$total_redeemed_points
			);
			$this->db->where('id',$result['id']);
			$this->db->update('advertisment_customer_lists',$campaign_data);		 
			$response=array('status'=>true, 'msg'=>'Points Reedmed Successfully');
		}
		else{
			$response=array('status'=>false, 'msg'=>'Invalid Data.Please Try Again');			 	
		}
		return $response;
	}
	
	##### update Reedmed Offer ##########
    public function reedemOffer($id){
		
		$campaign_data=array(
			'is_redeemed'=>1
		);
		$this->db->where('id',$id);
		$this->db->update('advertisments_customers_campaign_list',$campaign_data);
		return true;
	}
	
	##### My Campaign List ##########
    public function getUserCampaignOffersList($parent_id, $user_id, $limit_start, $limit_end){

		$this->db->select('SQL_CALC_FOUND_ROWS advertisments_customers_campaign_list.id,advertisments_customers_campaign_list.*,advertisments_customers_campaign.title, advertisements.contact_number, advertisements.name as add_name,advertisements.id as add_id, advertisements.city_name,advertisments_customers_campaign.title',false);
		$this->db->where('advertisments_customers_campaign_list.user_id',$user_id);
		$this->db->where('advertisments_customers_campaign_list.parent_user_id',$parent_id);
		$this->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = advertisments_customers_campaign_list.advertisments_customers_campaign_id');
		$this->db->join('users', 'users.id = advertisments_customers_campaign_list.parent_user_id');
		$this->db->join('advertisements', 'advertisements.user_id = users.id');
		$this->db->from('advertisments_customers_campaign_list');
		$this->db->order_by('advertisments_customers_campaign_list.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
   }
	
	##### My Campaign List ##########
    public function getCampaignOffersList($user_id, $limit_start, $limit_end){

		$this->db->select('SQL_CALC_FOUND_ROWS advertisments_customers_campaign_list.id,advertisments_customers_campaign_list.*,advertisments_customers_campaign.title, advertisements.contact_number, advertisements.name as add_name,advertisements.id as add_id, advertisements.city_name,advertisments_customers_campaign.title',false);
		$this->db->where('advertisments_customers_campaign_list.user_id',$user_id);
		$this->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = advertisments_customers_campaign_list.advertisments_customers_campaign_id');
		$this->db->join('users', 'users.id = advertisments_customers_campaign_list.parent_user_id');
		$this->db->join('advertisements', 'advertisements.user_id = users.id');
		$this->db->from('advertisments_customers_campaign_list');
		$this->db->order_by('advertisments_customers_campaign_list.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
   }
	
	##### My Campaign List ##########
    public function getCampaignIntersetList($user_id, $limit_start, $limit_end){

		$this->db->select('SQL_CALC_FOUND_ROWS campaign_interset.id,campaign_interset.*,advertisments_customers_campaign.title,user_profiles.first_name,users.contact_number',false);
		$this->db->where('campaign_interset.parent_user_id',$user_id);
		$this->db->join('advertisments_customers_campaign', 'advertisments_customers_campaign.id = campaign_interset.campaign_id');
		$this->db->join('users', 'users.id = campaign_interset.user_id');
		$this->db->join('user_profiles', 'user_profiles.user_id = users.id','LEFT');
		$this->db->from('campaign_interset');
		$this->db->order_by('campaign_interset.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
   }
	
	public function add_interset($campaign_id,$parent_user_id,$user_id) {
		
		$data = array(		
			'created'=>date('Y-m-d H:i:s'),
			'parent_user_id'=> $parent_user_id,
			'campaign_id'=>$campaign_id,
			'user_id'=>$user_id					
		);			
		$this->db->insert('campaign_interset', $data);
		
		$this->db->select('advertisments_customers_campaign.total_interset');
		$this->db->from('advertisments_customers_campaign');  
		$this->db->where('advertisments_customers_campaign.id', $campaign_id);
		$query = $this->db->get();	
		$results=$query->row_array();	
		$total_interset=0;
		if(isset($results['total_interset'])){
			
			$total_interset=$results['total_interset'];
		}
		$campaign_data=array(
			'total_interset'=>$total_interset+1
		);
		$this->db->where('id',$campaign_id);
		$this->db->update('advertisments_customers_campaign',$campaign_data);
		
	    return true;
	}
	
	public function checkAlreadyAdded($campaign_id,$user_id){
		$response=array();	
		$response['is_added']=0;
		$this->db->select('campaign_interset.*');
		$this->db->from('campaign_interset');   
		$this->db->where('campaign_interset.campaign_id', $campaign_id);
		$this->db->where('campaign_interset.user_id', $user_id);
		$query = $this->db->get();	
		$results=$query->row_array();		
		if(!empty($results)) {
			$response['is_added']=1;	
		}
		return $response;		
	}
	
	######### Front End - Advertisment List ####################
	public function get_offer_list($type=null,$limit_start=10, $limit_end=0,$city=null,$area=null,$keyword=null,$category=null) {
		$today=date('Y-m-d');
		$this->db->select('SQL_CALC_FOUND_ROWS advertisments_customers_campaign.id,advertisments_customers_campaign.*',false);	
		$this->db->from('advertisments_customers_campaign');   
		$this->db->where('advertisments_customers_campaign.is_active',1);
		$this->db->where('advertisments_customers_campaign.campaign_type_id',2);
		$this->db->where('advertisments_customers_campaign.display_as_offer',1);
		$this->db->where('advertisments_customers_campaign.campaign_start_date <=',$today);	
		$this->db->where('advertisments_customers_campaign.campaign_end_date >=',$today);			
		$this->db->limit($limit_start, $limit_end);
		if($city!=null || $area!=null){
			$this->db->join('advertisements', 'advertisements.user_id = advertisments_customers_campaign.user_id');	
			if($city!=null){
				$this->db->where('LOWER(advertisements.city_name)',strtolower($city));	
			}
			if($area!=null){
			  $this->db->where('LOWER(advertisements.area_name)',strtolower($area));	
			}
		}
		$query = $this->db->get();	
		$results['listings']=$query->result_array();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results=array_merge($results,$results_row);
		return $results;	
	}
	
	####################### Get Related Coupons #################
	public function get_related_coupons($id){
		
		$today=date('Y-m-d');
		$this->db->select('SQL_CALC_FOUND_ROWS coupons.id,coupons.*,advertisements.image_dir,advertisements.profile_image',false);	
		$this->db->from('coupons');   
		$this->db->where('coupons.is_active',1);
		$this->db->where('coupons.exipry_date >=',$today);
		$this->db->where('coupons.id !=',$id);
		$this->db->limit(10,0);	
		$this->db->join('advertisements', 'advertisements.id = coupons.advertisement_id');
		$this->db->order_by('coupons.id','rand()');
		$query = $this->db->get();	
		$results['related_listings']=$query->result_array();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results=array_merge($results,$results_row);
		return $results;
	}
	
	function get_campaign_details($id)
	{
		$this->db->select('advertisments_customers_campaign.*, advertisements.id as add_id,advertisements.name as add_name,advertisements.city_name,advertisements.area_name,advertisements.address_line,advertisements.contact_number');
		$this->db->where('advertisments_customers_campaign.id', $id);
		$this->db->join('advertisements', 'advertisements.user_id = advertisments_customers_campaign.user_id');
		$query = $this->db->get('advertisments_customers_campaign');
		
		return $query->row_array();	
	}
	
	########### Tarck Data#############
	public function getCampaignTrackList($user_id,$limit_start,$limit_end) {

		$this->db->select('SQL_CALC_FOUND_ROWS DISTINCT  advertisments_customers_campaign_tracking.id,advertisments_customers_campaign_tracking.*,advertisments_customers_campaign.title as campaign_title,advertisment_customer_lists.first_name,advertisment_customer_lists.mobile_number',false);
		$this->db->where('advertisments_customers_campaign_tracking.parent_user_id',$user_id);
		$this->db->limit($limit_start, $limit_end);
		$this->db->from('advertisments_customers_campaign_tracking');
		$this->db->join('advertisment_customer_lists','advertisment_customer_lists.user_id=advertisments_customers_campaign_tracking.user_id');
	    $this->db->join('advertisments_customers_campaign','advertisments_customers_campaign.id=advertisments_customers_campaign_tracking.advertisments_customers_camping_id');
		$this->db->order_by('advertisments_customers_campaign_tracking.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}
	
	########### Statistics Data#############
	public function getStatisticsData($user_id,$limit_start,$limit_end) {

		$this->db->select('SQL_CALC_FOUND_ROWS advertisments_customers_campaign_list.id,advertisments_customers_campaign_list.*,advertisments_customers_campaign.title as campaign_title,users.contact_number,users.email',false);
		$this->db->where('advertisments_customers_campaign_list.parent_user_id',$user_id);
		$this->db->limit($limit_start, $limit_end);
		$this->db->from('advertisments_customers_campaign_list');
	    $this->db->join('advertisments_customers_campaign','advertisments_customers_campaign.id=advertisments_customers_campaign_list.advertisments_customers_campaign_id','left');
		$this->db->join('users','users.id=advertisments_customers_campaign_list.user_id','left');
		$this->db->order_by('advertisments_customers_campaign_list.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();	
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}
	
	###### CAMPAIGN DELETE ###########
	public function delete($id) {
		$this->db->where('id',$id);
		$query = $this->db->get('advertisments_customers_campaign');
		$res = $query->row();
		$this->db->delete('advertisments_customers_campaign',array('id' => $id));	
	}
	
	####### Admin Details #########
	public function get_campaign_detail($id){
		$this->db->select('advertisments_customers_campaign.*,users.email,users.contact_number');
		$this->db->where('advertisments_customers_campaign.id',$id);
		$this->db->from('advertisments_customers_campaign');
		$this->db->join('users','users.id=advertisments_customers_campaign.user_id');
		$this->db->order_by('advertisments_customers_campaign.id','DESC');
		$query = $this->db->get();
		$result = $query->row_array();	
		return $result;
	}

	####### Track Campaign ID ########
	public function track_campagin(){
		$userInfo=$this->get_uer_id($_GET['UTM_email']);
		
		$this->db->select('advertisments_customers_campaign_tracking.*');
		$this->db->where('advertisments_customers_campaign_tracking.advertisments_customers_camping_id',$_GET['UTM_campaign_id']);
		$this->db->where('advertisments_customers_campaign_tracking.type_id',$_GET['UTM_type_id']);
		$this->db->where('advertisments_customers_campaign_tracking.user_id',$_GET['UTM_u_id']);
		$this->db->from('advertisments_customers_campaign_tracking');
		$query = $this->db->get();
		$result = $query->row_array();
		if(!empty($result)) {
			$campaign_data=array(
				'visit_count'=>$result['visit_count']+1
			);
			$this->db->where('id',$result['id']);
			$this->db->update('advertisments_customers_campaign_tracking',$campaign_data);
		}
		else {
			$table_data=array(
				'created'=>date('Y-m-d h:i:s'),
				'user_id'=>$_GET['UTM_u_id'],
				'parent_user_id'=>$_GET['UTM_user_id'],
				'type_id'=>$_GET['UTM_type_id'],
				'visit_count'=>1,
				'advertisments_customers_camping_id'=>$_GET['UTM_campaign_id'],
			);
			$this->db->insert('advertisments_customers_campaign_tracking', $table_data);
		}
		return true;
	} 
	
	########### My Offers #############
	public function getOfferData($user_id,$limit_start,$limit_end) {
		
		$this->db->select('advertisments_customers_campaign_list.*');
		$this->db->where('advertisments_customers_campaign_list.id');
		$this->db->where('advertisments_customers_campaign_list.user_id',$user_id);
		$this->db->limit($limit_start, $limit_end);
		$this->db->from('advertisments_customers_campaign_list');
		$this->db->order_by('advertisments_customers_campaign_list.id','DESC');
		$query = $this->db->get();
		$result = $query->result_array();	
		$response=array();
		$newresult=array();
		foreach($result  as $key=>$res){
			$newresult[$key]=array(date('d ,M Y',strtotime($res['created'])),ucwords($res['title']),$res['number_of_user_send'],$res['number_of_user_received'],$res['number_of_user_opened'],ucwords($res['campaign_type_id']),$res['id']);
		}
		$response['iTotalDisplayRecords']=$this->get_all_rows();
		$response['iTotalRecords']=$this->get_all_rows();
		$response['data']=$newresult;
		return $response;	
	}
	
	public function get_uer_id($email){
		$this->db->select('users.id,users.email,users.referer_id');
		$this->db->where('users.email',$email);
		$this->db->from('users');
		$query = $this->db->get();
		$result = $query->row_array();	
		return $result;
	}
	
	########## My CAMPAIGN Details #######
	public function campaignDetails($id,$user_id) {
		$this->db->select('advertisments_customers_campaign.*');
		$this->db->where('advertisments_customers_campaign.id',$id);
		$this->db->where('advertisments_customers_campaign.user_id',$user_id);
		$this->db->from('advertisments_customers_campaign');
		$this->db->order_by('advertisments_customers_campaign.id','DESC');
		$query = $this->db->get();
		$result = $query->row_array();	
		return $result;
	}
	
	########## My Groups #######
	public function my_groups($user_id) {
		$this->db->select('groups.id,groups.name',false);
		$this->db->where('groups.user_id',$user_id);
		$this->db->from('groups');
		$this->db->order_by('groups.id','DESC');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;	
	}
	
	########## My Senderids #######
	public function my_sendIds($user_id) {
		$this->db->select('user_sender_ids.id,user_sender_ids.sender_id',false);
		$this->db->where('user_sender_ids.user_id',$user_id);
		$this->db->where('user_sender_ids.is_active',1);
		$this->db->from('user_sender_ids');
		$this->db->order_by('user_sender_ids.id','DESC');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;	
	}
	
	########## My Groups #######
	public function senderid_details($sender_id) {
		$this->db->select('user_sender_ids.id,user_sender_ids.sender_id',false);
		$this->db->where('user_sender_ids.id',$sender_id);
		$this->db->where('user_sender_ids.is_active',1);
		$this->db->from('user_sender_ids');
		$this->db->order_by('user_sender_ids.id','DESC');
		$query = $this->db->get();
		$result=$query->row_array();
		return $result;	
	}
	
  	################  Save Plan ################
	public function savePlanDetails($paymentResponse, $status, $payment_id=null) {
		$userId=$this->session->userdata('user_id') ? $this->session->userdata('user_id') : '0';
		$plan_packages=array(
			'Bronze'=>'Bronze Pack',
			'Sliver'=>'Sliver Pack',
			'Gold'=>'Gold Pack',
			'Platinum'=>'Platinum Pack',
			'Custom'=>'Custom Pack'
		);
		$planDetails=$this->getNewPlanDetails($plan_packages[$paymentResponse['link_title']]);
		if($paymentResponse['link_title']=='custom' || $paymentResponse['link_title']=='Custom') {
			$sms_info=admin_settings_initialize('sms_cost');
			$total_sms_count=round($paymentResponse['amount'] / $sms_info['sms_cost']);
			$total_sms = $total_sms_count;
		}
		else {
			$total_sms = $planDetails['no_of_sms'];
		}
		$paymentdetails_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'user_id'=>$paymentResponse['udf1'],
			'sms_plan_id'=>$paymentResponse['udf2'],
			'payment_id'=>$paymentResponse['txnid'],
			'amount'=>$paymentResponse['amount'],
			'total_sms_ordered'=>$total_sms,
			'fees'=>$paymentResponse['additionalCharges'],
			'qunatity'=>1,
			'status'=>$paymentResponse['status'],
			'buyer_name'=>$paymentResponse['firstname'],
			'buyer_phone'=>$paymentResponse['phone'],
			'buyer_email'=>$paymentResponse['email'],
			'currency'=>'INR',
			'payment_status'=>$paymentResponse['status'],
		);
		$this->db->insert('customer_sms_order', $paymentdetails_data);
		$this->credit_sms($userId,$planDetails,$paymentResponse);
		return true;
	}
	
	
	### Save Plan #######
	public function  savePaymentResponsePayu($paymentResponse, $status){
		
        $userId=$paymentResponse['udf1']; 
		$plan_packages=array(
			'Bronze'=>'Bronze Pack',
			'Sliver'=>'Sliver Pack',
			'Gold'=>'Gold Pack',
			'Platinum'=>'Platinum Pack',
			'Custom'=>'Custom Pack'
		); 
		$pack=ucwords($paymentResponse['udf2']);
		$planDetails=$this->getNewPlanDetails($plan_packages[$pack]);
		if($paymentResponse['udf2']=='custom') {
			$sms_info=admin_settings_initialize('sms_cost');
			$total_sms_count=round($paymentResponse['amount'] / $sms_info['sms_cost']);
		}
		else {
			$total_sms_count = $planDetails['no_of_sms'];
		}
		$paymentdetails_data=array(
			'created'=> date('Y-m-d h:i:s'),
			'valid_from'=>date('Y-m-d'),
			'valid_to'=>date('Y-m-d'),
			'user_id'=>$userId,
			'sms_plan_id'=>$planDetails['id'],
			'payment_id'=>$paymentResponse['paymentId'],
			'amount'=>$paymentResponse['amount'],
			'total_sms_ordered'=>$total_sms_count,
			'payment_status'=>$paymentResponse['status'],
			'buyer_name'=>$paymentResponse['firstname'],
			'buyer_phone'=>$paymentResponse['phone'],
			'buyer_email'=>$paymentResponse['email'],
			'currency'=>'INR',
			'is_competed'=>1,
			'status'=>1,
			'sms_left'=>$total_sms_count,
			'payment_status'=>$status
		);
		$this->db->insert('customer_sms_order', $paymentdetails_data);
		if($status=='success'){
			$this->credit_sms_payu($userId, $paymentdetails_data);
		}
		return true;
	}
	
	
	############ Save User sms Counts #####
	public function credit_sms_payu($user_id,$paymentdetails_data){
		
		$this->sms_availabilty($user_id);
		$data=$this->campaign_model->sms_availabilty($user_id);
		$total_sms = $data['total_sms'] + $paymentdetails_data['total_sms_ordered'];
		$campaign_data=array(
			'total_sms'=>$total_sms,
		);
		$this->db->where('id',$user_id);
		$this->db->update('users',$campaign_data);
		return true;
	}	
	
	
	############ Save User sms Counts #####
	public function credit_sms($user_id,$planDetails,$paymentResponse){
		
		$this->sms_availabilty($user_id);
		$data=$this->campaign_model->sms_availabilty($user_id);
	
		if($paymentResponse['link_title']=='custom' || $paymentResponse['link_title']=='Custom') {
			$sms_info=admin_settings_initialize('sms_cost');
			$total_sms_count=round($paymentResponse['amount'] / $sms_info['sms_cost']);
			$total_sms=$data['total_sms'] + $total_sms_count;
		}
		else {
			$total_sms=$data['total_sms'] + $planDetails['no_of_sms'];
		}
		$campaign_data=array(
			'total_sms'=>$total_sms,
		);
		$this->db->where('id',$user_id);
		$this->db->update('users',$campaign_data);
		return true;
	}	
	
	########## Debit Total Sms #########
	public function debit_total_sms() {
		$sms_settings=admin_settings_initialize('sms_settings');		
	}
	
	############### Get Plan ID ##############
	public function getNewPlanDetails($planName) {
		$this->db->select('sms_packages.*');
		$this->db->from('sms_packages');
		$this->db->where('sms_packages.name',$planName);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}

   
    ##### My Campaign List ##########
    public function getCampaignList($user_id, $limit_start, $limit_end){

		$this->db->select('SQL_CALC_FOUND_ROWS advertisments_customers_campaign.id,advertisments_customers_campaign.*',false);
		$this->db->where('advertisments_customers_campaign.user_id',$user_id);
		$this->db->from('advertisments_customers_campaign');
		$this->db->order_by('advertisments_customers_campaign.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
   }
   
    ####### Customer Mobile Number Search #####
    public function customer_mobile_data($keyword,$user_id){

		$this->db->select('SQL_CALC_FOUND_ROWS users.id,users.*',false);
		if($keyword) 
		{
			$this->db->like('users.contact_number', $keyword,'after'); 
		}
		$this->db->where('advertisment_customer_lists.parent_user_id',$user_id);
		$this->db->where('advertisment_customer_lists.is_active',1);
		$this->db->join('advertisment_customer_lists','users.id=advertisment_customer_lists.user_id');
		$query = $this->db->get('users');
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->contact_number),'text'=>$g->contact_number."-".$g->email);
		}
		return $arr;
   }
    
    ######## Sms Availbility #########
	public function sms_availabilty($user_id){	
		$this->db->select('users.total_sms,users.sender_id1,users.sender_id2');
		$this->db->where('users.id',$user_id);
		$this->db->from('users');
		$query = $this->db->get();
		$result=$query->row_array();
		return $result;
	}	

    ############ Filter Datas #########
	public function filterDatas($userId,$result_type=1){
		$this->db->select('SQL_CALC_FOUND_ROWS advertisment_customer_lists.id,advertisment_customer_lists.*',false);
		$this->db->where('advertisment_customer_lists.parent_user_id',$userId);
		$this->db->where('advertisment_customer_lists.is_active',1);
		if($this->input->post('filter_type')=='1') {
			
			if($this->input->post('bill_filter')=='between_10000_50000') {
				$this->db->where('advertisment_customer_lists.total_amount >=',10000);
				$this->db->where('advertisment_customer_lists.total_amount <=',50000);
			}
			else if($this->input->post('bill_filter')=='bill_amount_lessthan_10000') {
				$this->db->where('advertisment_customer_lists.total_amount <=',10000);
			}
			else if($this->input->post('bill_filter')=='bill_amount_lessthan_10000') {
				$this->db->where('advertisment_customer_lists.total_amount <=',1000);
			}
			else if($this->input->post('bill_filter')=='greaterthan_50000') {
				$this->db->where('advertisment_customer_lists.total_amount >=',50000);
			}
			else {	
				$this->db->where('advertisment_customer_lists.total_amount >=',$this->input->post('bill_from'));
				$this->db->where('advertisment_customer_lists.total_amount <=',$this->input->post('bill_to'));
			}
			
		}
		else if($this->input->post('filter_type')=='2') {
			
			if($this->input->post('date_filter')=='last_30_days') {
				$from_date=date('Y-m-d',strtotime('-30 days'));
				$this->db->where('advertisment_customer_lists.created >=',$from_date);
			}
			else if($this->input->post('date_filter')=='last_60_days') {
				$from_date=date('Y-m-d',strtotime('-60 days'));
				$this->db->where('advertisment_customer_lists.created >=',$from_date);
			}
			else {	
				$this->db->where('advertisment_customer_lists.created >=',date('Y-m-d',strtotime($this->input->post('from_date'))));
				$this->db->where('advertisment_customer_lists.created <=',date('Y-m-d',strtotime($this->input->post('to_date'))));	
			}
		}
		else if($this->input->post('filter_type')=='3') {
			if($this->input->post('visit_filter')=='visit_lessthan_500') {
				$this->db->where('advertisment_customer_lists.visit_count <=',500);
			}
			else if($this->input->post('visit_filter')=='between_100_500') {
				$this->db->where('advertisment_customer_lists.visit_count >=',100);
				$this->db->where('advertisment_customer_lists.visit_count <=',500);
			}
			else if($this->input->post('visit_filter')=='between_500_1000') {
				$this->db->where('advertisment_customer_lists.visit_count >=',500);
				$this->db->where('advertisment_customer_lists.visit_count <=',1000);
			}
			else if($this->input->post('visit_filter')=='greaterthan_1000') {
				$this->db->where('advertisment_customer_lists.visit_count >=',1000);
			}
			else {	
				$this->db->where('advertisment_customer_lists.visit_count >=',$this->input->post('from_visit_count'));
				$this->db->where('advertisment_customer_lists.visit_count <=',$this->input->post('from_visit_count'));
			}
		}
		else if($this->input->post('filter_type')=='4') {
			$this->db->where('advertisment_customer_lists.group_id',$this->input->post('group_id'));
		}
		else if($this->input->post('filter_type')=='5') {
			$this->db->where_in('advertisment_customer_lists.mobile_number',$this->input->post('contact_numbers'));
		}
		$this->db->from('advertisment_customer_lists');
		$query = $this->db->get();
		if($result_type==1){
			$result=$query->num_rows();
			return $result;
		}		
	    else { 	
			$result=$query->result_array();
			return $result;
		}
	}
	
	########### Get Shorten Url ########
	public function googleShortUrl($url,$user_info,$camp_info, $type_id, $paren_user_id){
		$apiKey = 'AIzaSyDIKdXDrC-mJC0KfSlu1PwdVqTFum6I-Tw';
		$base_url=base_url()."?r_url=".$url."&UTM_mobilenumber=".$user_info['mobile_number']."&UTM_email=".$user_info['email']."&UTM_campaign_id=".$camp_info."&UTM_user_id=".$paren_user_id."&UTM_type_id=".$type_id."&UTM_u_id=".$user_info['user_id'];
		$post_data = json_encode( array( 'longUrl'=>$base_url ) );
		$ch= curl_init();
		$arr = array();
		array_push($arr, 'Content-Type: application/json; charset=utf-8');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $arr);
		curl_setopt($ch, CURLOPT_URL,"https://www.googleapis.com/urlshortener/v1/url?key=".$apiKey);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER,base_url());
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		$short_url = json_decode($output);
		$msg = $short_url->id;
		curl_close($ch);
		return $msg;
	}

	############ Save General Campaings #######
	public function saveGeneralCampaigns($user_id,$campaign_type){
		$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'title'=>$this->input->post('title'),
			'campaign_type_id'=>$campaign_type,
			'user_id'=>$user_id,
			'message'=>$this->input->post('message'),
			'message_length'=>strlen($this->input->post('message')),
			'sender_id'=>$this->input->post('sender_id'),
			'number_of_user_send'=>$this->input->post('filter_count'),
			'url'=>$this->input->post('url'),
		);
		$this->db->insert('advertisments_customers_campaign', $table_data);		
		$result=array('id'=>$this->db->insert_id(),'status'=>1);
		return $result;	
	}
		
	########### Save Campaings list ###########	
	public function saveCampaignList($campaign_id,$customer_list,$filter_count,$camping_type,$user_id,$sender_id){
		
		$sms_send_count=0;
		foreach($customer_list as $key=>$list) {
			
			$sender_info=array();
			$sender_info['user_id']=$list['user_id'];
			$sender_info['sender_id']=$sender_id;
			$datas=array('##URL##','##USERNAME##');
			$short_url=$this->googleShortUrl($this->input->post('url'), $list, $campaign_id, 1, $this->session->userdata('user_id'));
			$replace_data=array($short_url,$list['first_name']);
			$message = str_replace($datas, $replace_data, $this->input->post('message'));
			$status=$this->cron_model->send_message($list['mobile_number'], $message, $sender_info);
			if($status==1){
				$sms_send_count=$sms_send_count+1;			   
			}
			$table_data=array(
				'created'=>date('Y-m-d h:i:s'),
				'parent_user_id'=>$user_id,
				'mobileno'=>$list['mobile_number'],
				'campaign_url'=>$this->input->post('url'),
				'campaign_url_short'=>$short_url,
				'status'=>$status,
				'message'=>$this->input->post('message'),
				'user_id'=>$list['user_id'],
				'camping_type_id'=>$camping_type,
				'advertisments_customers_campaign_id'=>$campaign_id,
				'message'=>$this->input->post('message'),
			);
			$this->db->insert('advertisments_customers_campaign_list', $table_data);				
		}
		$campaign_data=array(
			'number_of_user_received'=>$sms_send_count
		);
		$this->db->where('id',$campaign_id);
		$this->db->update('advertisments_customers_campaign',$campaign_data);
		return $campaign_data;
	}
	
	############ Save Offer Campaings #######
	public function saveOfferCampaigns($user_id,$campaign_type,$offer_image=null){
		$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'title'=>$this->input->post('title'),
			'campaign_type_id'=>$campaign_type,
			'user_id'=>$user_id,
			'campaign_start_date'=>date('Y-m-d',strtotime($this->input->post('campaign_start_date'))),
			'campaign_end_date'=>date('Y-m-d',strtotime($this->input->post('campaign_end_date'))),
			'message'=>$this->input->post('message'),
			'coupon_type'=>$this->input->post('coupon_type'),
			'message_length'=>strlen($this->input->post('message')),
			'number_of_user_send'=>$this->input->post('filter_count'),
			'description'=>$this->input->post('description'),
			'sender_id'=>$this->input->post('sender_id'),
			'display_as_offer'=>($this->input->post('display_as_offer') == 'on') ? 1 : 0,
			'is_active'=>1,
			'url'=>$this->input->post('url'),
			'percentage'=>$this->input->post('percentage'),
			'mrp_price'=>$this->input->post('mrp_price'),
			'offer_price'=>$this->input->post('offer_price'),
			'offer_type'=>$this->input->post('offer_type'),
		);
		if($offer_image!=''){
			$table_data=array_merge($table_data,$offer_image);
		}
		$this->db->insert('advertisments_customers_campaign', $table_data);		
		$result=array('id'=>$this->db->insert_id(),'status'=>1);
		return $result;	
	}
	
	########### Save Campaings list ###########	
	public function saveOfferCampingList($campaign_id,$customer_list,$filter_count,$camping_type,$user_id,$sender_id, $addName){
		
		$sms_send_count=0;
		foreach($customer_list as $key=>$list) {
			if($this->input->post('coupon_type')==1){
				if($addName!=''){
					$coupon_code=offerCode(3);	
					$coupon_code=ucwords(substr(trim($addName),0,3)).'-'.$coupon_code;
				}
				else{
					$coupon_code=offerCode(6);
				}
			}  else {
				$coupon_code=$this->input->post('coupon_code');
			}
			$datas=array('##URL##','##CODE##', '##USERNAME##');
			$short_url=$this->googleShortUrl($this->input->post('url'),$list,$campaign_id,2,$this->session->userdata('user_id'));
			$replace_data=array($short_url,$coupon_code, $list['first_name']);
			$message = str_replace($datas, $replace_data, $this->input->post('message'));
			$sender_info=array();
			$sender_info['user_id']=$list['id'];
			$sender_info['sender_id']=$sender_id;
			$status=$this->cron_model->send_message($list['mobile_number'],$message,$sender_info);
			if($status==1){
				$sms_send_count=$sms_send_count+1;			   
			}
			$table_data=array(
				'created'=>date('Y-m-d h:i:s'),
				'parent_user_id'=>$user_id,
				'mobileno'=>$list['mobile_number'],
				'campaign_url'=>$this->input->post('url'),
				'campaign_url_short'=>$short_url,
				'status'=>$status,
				'message'=>$message,
				'user_id'=>$list['user_id'],
				'camping_type_id'=>$camping_type,
				'advertisments_customers_campaign_id'=>$campaign_id,
				'coupon_code'=>$coupon_code,
			);
			$this->db->insert('advertisments_customers_campaign_list', $table_data);				
		}
		$campaign_data=array(
			'number_of_user_received'=>$sms_send_count
		);
		$this->db->where('id',$campaign_id);
		$this->db->update('advertisments_customers_campaign',$campaign_data);
		return $campaign_data;
	}
	
	########### Deduce Total Sms ###############
	public function debitSms($user_id,$total_sms){
		
		$getTotalSmsCounts=$this->getTotalSmsCounts($user_id);
		$all_total_sms=$getTotalSmsCounts['total_sms'] -  $total_sms;
	    $total_number_of_sms_send = $getTotalSmsCounts['total_number_of_sms_send'] +  $total_sms;
		$campaign_data=array(
			'total_sms'=>$all_total_sms,
			'total_number_of_sms_send'=>$total_number_of_sms_send
		);
		$this->db->where('id',$user_id);
		$this->db->update('users',$campaign_data);
		return true;
	}
	
	public function getTotalSmsCounts($user_id){
		
		$this->db->select('users.total_number_of_sms_send,users.total_sms');
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
		
	}
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	################# Plan Details #########
	public function getPlanDetails($planId) {
		
		$this->db->select('sms_packages.*');
		$this->db->from('sms_packages');
		$this->db->where('sms_packages.id',$planId);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
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
	
	################ Get Orders List ####################
	public function getMyOrdersList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS customer_sms_order.id,customer_sms_order.*, sms_packages.name as plan_name',false);
		$this->db->where('customer_sms_order.user_id',$userId);
		$this->db->from('customer_sms_order');
		$this->db->join('sms_packages','sms_packages.id=customer_sms_order.sms_plan_id','left');
		$this->db->order_by('customer_sms_order.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['data']=$result;
		$response['TotalRecords']=$this->get_all_rows();
		return $response;
    }
	
	public function get_campaign($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) {  
		$this->db->select('advertisments_customers_campaign.*,users.email,users.contact_number');
		$this->db->from('advertisments_customers_campaign');
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
		$this->db->join('users', 'users.id = advertisments_customers_campaign.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisments_customers_campaign.user_id', 'left');
		if(!$sort_field)
			$this->db->order_by('advertisments_customers_campaign.id', $order_type);
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