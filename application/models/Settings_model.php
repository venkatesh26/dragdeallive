<?php
class Settings_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
    }
	
	### Get Sms Settings Data ###
	public function sms_notification($user_id){
		$this->db->select('customers_sms_notifications.*');
		$this->db->where('customers_sms_notifications.user_id',$user_id);
		$this->db->join('customers_sms_notification_types','customers_sms_notification_types.id=customers_sms_notifications.type_id');
		$query = $this->db->get('customers_sms_notifications');
		$result = $query->result_array();	
		return $result;	
	}
	
	#### Save Notification Settings #####
	public function saveSettings($user_id) {
		
		$is_active=($this->input->post('is_active')==1 || $this->input->post('is_active')=='on') ? 1 :0; 
		$id=$this->settingsId($user_id, $this->input->post('type_id'));
		$data = array(
			'user_id'=> $user_id,
			'type_id'=>	$this->input->post('type_id'),	
			'created'=> date('Y-m-d h:i:s'),	
			'is_active'=>$is_active,	
			'message'=>	$this->input->post('message')
		);
		if($id > 0){
			$new_data=array('modified'=>date('Y-m-d h:i:s'));
			$data=array_merge($data, $new_data);
			$this->db->where('id', $id);
			$this->db->update('customers_sms_notifications', $data);
		}
		else {
           $this->db->insert('customers_sms_notifications', $data);	
		}
		return true;
	}
	
	## Find Settings Id ######
	public function settingsId($user_id, $type_id){
        $this->db->select('customers_sms_notifications.*');
		$this->db->where('customers_sms_notifications.user_id',$user_id);
		$this->db->where('customers_sms_notifications.type_id',$type_id);
		$this->db->join('customers_sms_notification_types','customers_sms_notification_types.id=customers_sms_notifications.type_id');
		$query = $this->db->get('customers_sms_notifications');
		$result = $query->row_array();	
		return (isset($result['id'])) ? $result['id']:'';			
	}
	
	### Send Sms ##### 
	public function send_sms($user_id , $code, $userInfo){
		$this->db->select('customers_sms_notifications.*');
		$this->db->where('customers_sms_notifications.user_id',$user_id);
		$this->db->where('customers_sms_notifications.is_active',true);
		$this->db->where('customers_sms_notification_types.code',$code);
		$this->db->join('customers_sms_notification_types','customers_sms_notification_types.id=customers_sms_notifications.type_id');
		$query = $this->db->get('customers_sms_notifications');
		$result = $query->row_array();	
		if($result){		
			$getAddDetails=$this->getAddDetails($user_id);
			$link=base_url().'business'.'/'.$getAddDetails['id'].'/'.url_title(strtolower($getAddDetails['name'])).'/'.url_title(strtolower($getAddDetails['city_name']));
			$short_url=$this->googleShortUrl($link, $userInfo, 0, 1, $this->session->userdata('user_id'));
			$datas=array('##SHOPURL##', '##SHOPNAME##', '##USERNAME##');
			$replace_data=array($short_url,$getAddDetails['name'], $userInfo['first_name']);
			$message = str_replace($datas, $replace_data, $result['message']);
			$this->load->model('cron_model');
			$this->load->model('campaign_model');
			$sendIdInfo=$this->cron_model->getSendId($this->session->userdata('user_id'));
			$senderid=(isset($sendIdInfo['id'])) ? $sendIdInfo['id']  : 0;  
			$sender_data['user_id']=$user_id;
			$sender_data['sender_id']=(isset($sender_id['sender_id']) && $sender_id['sender_id']) ? $sender_id['sender_id'] : 0;	
			$status=$this->cron_model->send_message($userInfo['mobile_number'], $message, $sender_data);
			$this->campaign_model->debitSms($this->session->userdata('user_id'),1);
		}
	}
	
	#### Get ADD Info #####
	public function getAddDetails($user_id){
		$this->db->select('id,name,city_name');
		$this->db->where('advertisements.user_id',$user_id);
		$query = $this->db->get('advertisements');
		$result = $query->row_array();	
		
		return $result;
	}
	
	########### Get Shorten Url ########
	public function googleShortUrl($url,$user_info,$camp_info, $type_id, $paren_user_id){
		$apiKey = 'AIzaSyDIKdXDrC-mJC0KfSlu1PwdVqTFum6I-Tw';
		$base_url=base_url()."?r_url=".$url."&UTM_mobilenumber=".$user_info['mobile_number']."&UTM_email=".$user_info['email']."&UTM_campaign_id=".$camp_info."&UTM_user_id=".$paren_user_id."&UTM_type_id=".$type_id;
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
}