<?php
class Cron_model extends CI_Model {

    #Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
		$sms_settings=admin_settings_initialize('sms_settings');
		$this->total_sms=$sms_settings['total_sms'];
		$this->sender_id1=$sms_settings['sender_id1'];
		$this->sender_id2=$sms_settings['sender_id2'];
		$this->sms_apikey=$sms_settings['api_key'];
		include 'sendsms.php';
    }
	
	#### Payments List ######
	public function getKeyWordList(){
		$this->db->select('keyword_enquiry.*');
		$this->db->where('keyword_enquiry.is_send',0);
		$this->db->from('keyword_enquiry');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	#### Payments List ######
	public function getKeyAddvertsimentList($data) {
		
		$categories_result=array();
		#Category Based Search
		if(!empty($data['keyword'])) {
			$this->db->select('categories.id as cat_id');
			$this->db->where('LOWER(categories.name)',strtolower($data['keyword']));
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

	    $this->db->select('SQL_CALC_FOUND_ROWS advertisements.id,advertisements.contact_number,advertisements.id,advertisements.zip,advertisements.name as add_name,advertisements.owner,
		advertisements.address_line,advertisements.email,advertisements.city_name',false);
		$this->db->where('advertisements.is_active','1');	
		$this->db->where('advertisements.email!=','');			
		
		if($category_set!='') {
			foreach($category_set as $key=>$set) {	
				if($key==0) {
				  $this->db->where("FIND_IN_SET('$set',category_id) !=", 0);
				}			 
			}
		}
 		
		#City Based Search
		if(!empty($data['city'])) {
			$this->db->where('advertisements.city_name',$data['city']);	
		}
		
		#Area Based Search
		if(!empty($data['area'])) {
			$this->db->where('advertisements.area_name',$data['area']);
		}
		$this->db->from('advertisements');   
		$this->db->limit(10, 0);
		$this->db->order_by("advertisements.plan_id", "DESC"); 
		$query = $this->db->get();	
		return $query->result_array();
	}
	
	
	#### Payments List ######
	public function getPaymentsList($type_id){
		$today=date('Y-m-d');
		$this->db->select('payments.*');
		$this->db->where('payments.is_verified',0);
		$this->db->where('payments.type_id',$type_id);
		$this->db->where('DATE(payments.created) =',$today);
		$this->db->from('payments');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;
	}
	
	###### All Advertisment ##########
	public function allAdvertisements(){
		
		$today=date('Y-m-d');
		$this->db->select('advertisements.expiry_date,advertisements.id,advertisements.user_id,users.total_sms');
		$this->db->where('advertisements.expiry_date !=','0000-00-00');
		$this->db->where('advertisements.plan_id !=',1);
		$this->db->join('users','users.id=advertisements.user_id');
		$this->db->where('DATE(advertisements.expiry_date) <=',$today);
		$this->db->from('advertisements');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result;
	}

	####### Send Sms ##########
	public function send_message($contact_number,$message,$sender_info) {

		$sender_id1=$this->sender_id1;
		if(!empty($sender_info['sender_id']) && $sender_info['sender_id']!='0'){
			$sender_id1=$sender_info['sender_id'];
		}
		$sendsms=new sendsms("http://api-alerts.solutionsinfini.com/v4/", 'sms', $this->sms_apikey, $sender_id1);
		$sendsmsInfo=$sendsms->send_sms($contact_number, $message, base_url().'/sms&custom='.$sender_info['user_id'], 'json');
		$sms_status=array('AWAITED-DLR'=>1,'DNDNUMB'=>1,'OPTOUT-REJ'=>1,'INVALID-NUM'=>0);
		$dataStatus=json_decode($sendsmsInfo,true);
		$status=0;
		if(isset($dataStatus['data'][0]['status'])){
			$status=$sms_status[$dataStatus['data'][0]['status']];
		}
		return $status;
	}
	
	############# Send Email ###############
	public function sendEmail($to, $subject, $body_text, $body_html, $from, $fromName){
		$res = "";
		$data = "username=".urlencode("dhamodaran@constient.com");
		$data .= "&api_key=".urlencode("12d2d9f1-e893-4726-826b-caacae82877d");
		$data .= "&from=".urlencode($from);
		$data .= "&from_name=".urlencode($fromName);
		$data .= "&to=".urlencode($to);
		$data .= "&subject=".urlencode($subject);
		if($body_html)
		  $data .= "&body_html=".urlencode($body_html);
		if($body_text)
		  $data .= "&body_text=".urlencode($body_text);

		$header = "POST /mailer/send HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($data) . "\r\n\r\n";
		$fp = fsockopen('ssl://api.elasticemail.com', 443, $errno, $errstr, 30);
		if(!$fp)
		  return "ERROR. Could not open connection";
		else {
		  fputs ($fp, $header.$data);
		  while (!feof($fp)) {
			$res .= fread ($fp, 1024);
		  }
		  fclose($fp);
		}
		return $res;                  
	}
	
	##### Save Reaminders #########
    public function saveRemainders($data){
		$this->db->insert('remainders', $data);
	}
	
	######## Get Users List #########
    public function getUsersList() {
	 	$this->db->select('users.id,users.total_sms');
		$this->db->where('users.total_sms >=',1);
		$this->db->from('users');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result; 
    }
	
	#### Save Remiander Histroy ########
	public function saveRemaindersHistroy($data) {
	  $this->db->insert('remainder_histroy',$data);	
	  return true;
	}
	
	public function getSendId($user_id){
		$this->db->select('user_sender_ids.id,user_sender_ids.sender_id',false);
		$this->db->where('user_sender_ids.user_id',$user_id);
		$this->db->where('user_sender_ids.is_active',1);
		$this->db->from('user_sender_ids');
		$this->db->order_by('user_sender_ids.id','DESC');
		$query = $this->db->get();
		$result=$query->row_array();
		return $result;	
	}
	
	########## Remainder List ##############
	public function getRemainderList($type_id) {
		
		$this->db->select('remainder_settings.*,users.id as parent_user_id,users.total_sms');
		$this->db->where('remainder_settings.remainder_type_id',$type_id);
		$this->db->where('users.total_sms >=',1);
		$this->db->join('users','users.id=remainder_settings.user_id');
		$this->db->where('remainder_settings.is_active',1);
		$this->db->from('remainder_settings');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result; 
	}
	
	public function getServiceUsersList($user_id, $data) {
		$this->db->select('advertisment_customer_lists.*,users.contact_number,users.email');
		$this->db->where('advertisment_customer_lists.parent_user_id',$user_id);
		$this->db->where('advertisment_customer_remainders.remainder_setting_id',$data['id']);
		$this->db->where('advertisment_customer_lists.is_active',1);
		$this->db->from('advertisment_customer_lists');
		if($data['remainder_period_type']==1){
		  $this->db->where("DATEDIFF(DATE(advertisment_customer_remainders.service_date),now()) BETWEEN 1 AND ".$data['no_of_days']."");
		}
		else if($data['remainder_period_type']==2){
			$this->db->where("DAYOFYEAR(NOW()) - DAYOFYEAR(advertisment_customer_remainders.service_date) BETWEEN 1 AND ".$data['no_of_days']."");
		}
		else if($data['remainder_period_type']==3){
			$this->db->where("MONTH(advertisment_customer_remainders.service_date)=MONTH(CURDATE())");
			$this->db->where("DAY(advertisment_customer_remainders.service_date)=DAY(CURDATE())");
		}
		$this->db->join('advertisment_customer_remainders','advertisment_customer_remainders.user_id=advertisment_customer_lists.user_id');
		$this->db->join('users','users.id=advertisment_customer_lists.user_id');
		$this->db->join('user_profiles','user_profiles.user_id=advertisment_customer_lists.user_id');
		$query = $this->db->get();
		$result=$query->result_array();
		return $result; 
	}
	
	
	############# Child Users List #############
	public function getChildUsersList($user_id,$data,$type) {
		$this->db->select('advertisment_customer_lists.*,users.contact_number,users.email');
		$this->db->where('advertisment_customer_lists.parent_user_id',$user_id);
		$this->db->where('advertisment_customer_lists.is_active',1);
		$this->db->from('advertisment_customer_lists');
		if($type=='birthday'){
			$this->db->where('advertisment_customer_lists.is_birthday_remainder',1);
			if($data['remainder_period_type']==1){
				$this->db->where("DATEDIFF(DATE(advertisment_customer_lists.dob),now()) BETWEEN 1 AND ".$data['no_of_days']."");
			}
			else if($data['remainder_period_type']==2){
				$this->db->where("DAYOFYEAR(NOW()) - DAYOFYEAR(advertisment_customer_lists.dob) BETWEEN 1 AND ".$data['no_of_days']."");
			}
			else if($data['remainder_period_type']==3){
				$this->db->where("MONTH(advertisment_customer_lists.dob)=MONTH(CURDATE())");
				$this->db->where("DAY(advertisment_customer_lists.dob)=DAY(CURDATE())");
			}
		}
		else if($type=='aniversery'){
			$this->db->where('advertisment_customer_lists.is_aniversy_reminder',1);
			if($data['remainder_period_type']==1){
				$this->db->where("DATEDIFF(now(),DATE(advertisment_customer_lists.doa)) BETWEEN 1 AND ".$data['no_of_days']."");
			}
			else if($data['remainder_period_type']==2){
				$this->db->where("DAYOFYEAR(NOW()) - DAYOFYEAR(advertisment_customer_lists.doa) BETWEEN 1 AND ".$data['no_of_days']."");
			}
			else if($data['remainder_period_type']==3){
				$this->db->where("MONTH(advertisment_customer_lists.doa)=MONTH(CURDATE())");
				$this->db->where("DAY(advertisment_customer_lists.doa)=DAY(CURDATE())");
			}
		}			
		$this->db->join('users','users.id=advertisment_customer_lists.user_id');
		$this->db->join('user_profiles','user_profiles.user_id=advertisment_customer_lists.user_id');
		$query = $this->db->get();

		$result=$query->result_array();
		return $result; 
	}
}?>