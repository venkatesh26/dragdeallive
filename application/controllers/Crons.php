<?php
class Crons extends CI_Controller {

    #Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
		$this->load->model('cron_model');
		$this->load->model('campaign_model');
		$this->site_name=admin_settings_initialize('sitename');
		$sms_settings=admin_settings_initialize('sms_settings');
		$this->total_sms=$sms_settings['total_sms'];
		$this->sender_id1=$sms_settings['sender_id1'];
		$this->sender_id2=$sms_settings['sender_id2'];
    }

	########## Crons for Keyword Enquiry ##########
    public function send_enquiry_notification(){
		
		$getKeywordList=$this->cron_model->getKeyWordList(1);
		foreach($getKeywordList as $list){
			$getAddList=$this->cron_model->getKeyAddvertsimentList($list);
			if(!empty($getAddList)) {
				$customer_emails=array();
				$bussiness_data=array();
				
				######## All Add List ###########
				foreach($getAddList as $key=>$addList) {
					$customer_emails[$key]=$addList['email'];
					$link=base_url().'business'.'/'.$addList['id'].'/'.url_title(strtolower($addList['add_name'])).'/'.url_title(strtolower($addList['city_name']));
					$b_data="<a href=".$link.">".$addList['add_name']."</a><br/>".$addList['add_name']."<br/>".$addList['contact_number']."<br/>".$addList['address_line']."<br>".$addList['city_name'];
					$bussiness_data[$key]=$b_data;
				}
				$data=array('user_name'=>$list['name'],'bData'=>$bussiness_data);
				$this->load->library('template');
				$siteEmail=admin_settings_initialize('email');
			
				############ Customer Enquiry Notification ######
				$notificatiosTemplate="mail_template/customer_keyword_enquiry_notification";
				$email_body = $this->template->load('mail_template/template', $notificatiosTemplate, $data, TRUE);
				$this->cron_model->sendEmail($list['email'], "Thanks For Enquiry -".$this->site_name, "",$email_body, $siteEmail, "Dragdeal");
				
				########## Agent Notification ##############
				$notificatiosTemplate="mail_template/agent_keyword_enquiry_notification";
				$data=array('username'=>"Sir/Madam",'userInfo'=>$list);
				$email_body = $this->template->load('mail_template/template', $notificatiosTemplate, $data, TRUE);
				$customer_emails=implode(',', $customer_emails);
				$this->cron_model->sendEmail($customer_emails, "Dreagdeal Enquiry -".$this->site_name, "",$email_body, $siteEmail, "Dragdeal");
			}
			
			$campaign_data=array(
				'is_send'=>1
			);
			$this->db->where('id',$list['id']);
			$this->db->update('keyword_enquiry',$campaign_data);	
		}
	}
	
	###### Crons for Payments #####
	public function payu_payment_status(){
				
		$getPaymentsList=$this->cron_model->getPaymentsList(1);
		$this->load->model('advertisment_model');
		foreach($getPaymentsList as $list){
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.payumoney.com/payment/op/getPaymentResponse?merchantKey=tUZAApJl&merchantTransactionIds=".$list['transaction_id']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_POST, 1);
			$headers = array();
			$headers[] = "Authorization: WXnPnY7nD2qsQW86s5aBDsW5hCwoA0bxV2BG8byWd3U=";
			$headers[] = "Cache-Control: no-cache";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			$result = json_decode($result);
			curl_close ($ch);
			if(isset($result->result[0]->postBackParam) && !empty($result->result[0]->postBackParam)){
				
				$response=(array)$result->result[0]->postBackParam;
				$status = $response['status'];
				$this->advertisment_model->savePaymentResponse($response , $status);
				$campaign_data=array(
					'is_verified'=>1
				);
				$this->db->where('id',$list['id']);
				$this->db->update('payments',$campaign_data);	
			}		
		}		
	}
	
	##### Sms Credit Response ####
	public function sms_credit_response(){
		$getPaymentsList=$this->cron_model->getPaymentsList(2);
		$this->load->model('campaign_model');
		foreach($getPaymentsList as $list){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.payumoney.com/payment/op/getPaymentResponse?merchantKey=tUZAApJl&merchantTransactionIds=".$list['transaction_id']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			$headers = array();
			$headers[] = "Authorization: WXnPnY7nD2qsQW86s5aBDsW5hCwoA0bxV2BG8byWd3U=";
			$headers[] = "Cache-Control: no-cache";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			$result = json_decode($result);
			curl_close ($ch);
			if(isset($result->result[0]->postBackParam) && !empty($result->result[0]->postBackParam)){
				
				$response=(array)$result->result[0]->postBackParam;
				$status = $response['status'];
				$this->campaign_model->savePaymentResponsePayu($response , $status);
				$campaign_data=array(
					'is_verified'=>1
				);
				$this->db->where('id',$list['id']);
				$this->db->update('payments',$campaign_data);	
			}		
		}		
    }
	
	######### Remainders ############
	public function index() {
	  
		$remainderType=$_GET['type'];
		if($remainderType=='birthday'){
			$getRemainders=$this->cron_model->getRemainderList(1);
		}
		else if($remainderType=='aniversery'){
			$getRemainders=$this->cron_model->getRemainderList(2);
		}
		if(count($getRemainders) > 0) {
			
			foreach($getRemainders as $data) {

				###### Customers List #####
				$customer_list=$this->cron_model->getChildUsersList($data['parent_user_id'],$data,$remainderType);				
				if(count($customer_list) > 0) {	
				
					$sendIdInfo=$this->cron_model->getSendId($data['parent_user_id']);
					$addName=getAddName($data['parent_user_id']);
				    if($data['total_sms'] > 0):
						$noOfMessage=ceil(strlen($data['message'])/160);
						$message_length=ceil(strlen($data['message'])/160);
						$totalSmsSend=$noOfMessage * count($customer_list);
						$total_sms=($data['total_sms'] - $totalSmsSend);
						if($total_sms <=0) {
							$total_sms=0;
							$customer_list_count=floor(count($customer_list)/$noOfMessage);
							$customer_list=array_slice($customer_list,$customer_list_count);
						}
						$sms_send_count=0;
						foreach($customer_list as $newData) {
								if($addName!=''){
									$coupon_code=offerCode(3);	
									$coupon_code=ucwords(substr(trim($addName),0,3)).'-'.$coupon_code;
								}
								else{
									$coupon_code=incrementalHash(5);
								}
								$datas=array('##URL##','##CODE##', '##USERNAME##');
								$short_url=$this->campaign_model->googleShortUrl($data['url'],$newData,$data['id'],2,$data['parent_user_id']);
								$replace_data=array($short_url,$coupon_code, $newData['first_name']);
								$message = str_replace($datas, $replace_data, $data['message']);
								$sender_info=array('user_id'=>$newData['user_id'], 'sender_id'=>$sendIdInfo['sender_id']);
								$status=$this->cron_model->send_message($newData['contact_number'],$message,$sender_info);
								if($status==1){
									$sms_send_count=$sms_send_count+1;			   
								}
							   $remainder_data=array(
									'created'=>date('Y-m-d'),
									'name'=>$data['name'],
									'message'=>$message,
									'coupon_code'=>$coupon_code,
									'mobileno'=>$newData['contact_number'],
									'remainder_date'=>date('Y-m-d'),
									'remainder_type'=>$data['remainder_type_id'],	
									'remainder_setting_id'=>$data['id'],
									'campaign_url'=>$data['url'],
									'campaign_url_short'=>$short_url,
									'token'=>'',
									'status'=>$status,
									'is_verified'=>1,
									'user_id'=>$newData['user_id'],
									'parent_user_id'=>$data['parent_user_id'],
							   );
							$getChildUserList=$this->cron_model->saveRemainders($remainder_data);
						}
						$sms_send_count=$sms_send_count *  $noOfMessage;
						$this->campaign_model->debitSms($data['parent_user_id'],$sms_send_count);
						$this->saveCustomerHistroy($data['parent_user_id'],$data['id'],count($customer_list),$sms_send_count,$sms_send_count,0,$message_length);
					endif;
				}
				else {
					echo "No Customers Found :".$data['parent_user_id'];
					echo "<br/>";
					echo "<br/>";
				}					
			}
		}
		else {		   
		}
	}
	
	######### Cron For Service Remainders ######
	public function service(){
		$getRemainders=$this->cron_model->getRemainderList(3);	
	
		foreach($getRemainders as $data){
			###### Customers List #####
				$customer_list=$this->cron_model->getServiceUsersList($data['parent_user_id'], $data);					
				if(count($customer_list) > 0) {	
					$sendIdInfo=$this->cron_model->getSendId($data['parent_user_id']);
				    if($data['total_sms'] > 0):
						$noOfMessage=ceil(strlen($data['message'])/160);
						$message_length=ceil(strlen($data['message'])/160);
						$totalSmsSend=$noOfMessage * count($customer_list);
						$total_sms=($data['total_sms'] - $totalSmsSend);
						if($total_sms <=0) {
							$total_sms=0;
							$customer_list_count=floor(count($customer_list)/$noOfMessage);
							$customer_list=array_slice($customer_list,$customer_list_count);
						}
						$sms_send_count=0;
						foreach($customer_list as $newData) {
								$coupon_code=incrementalHash(6);
								$datas=array('##URL##','##CODE##', '##USERNAME##');
								$short_url=$this->campaign_model->googleShortUrl($data['url'],$newData,$data['id'],2,$data['parent_user_id']);
								$replace_data=array($short_url, $coupon_code, $newData['first_name']);
								$message = str_replace($datas, $replace_data, $data['message']);
								$sender_info=array('user_id'=>$newData['user_id'], 'sender_id'=>$sendIdInfo['sender_id']);
								$status=$this->cron_model->send_message($newData['contact_number'],$message,$sender_info);
								if($status==1){
									$sms_send_count=$sms_send_count+1;			   
								}
							$remainder_data=array(
								'created'=>date('Y-m-d'),
								'name'=>$data['name'],
								'message'=>$message,
								'coupon_code'=>$coupon_code,
								'mobileno'=>$newData['contact_number'],
								'remainder_date'=>date('Y-m-d'),
								'remainder_type'=>$data['remainder_type_id'],	
								'remainder_setting_id'=>$data['id'],
								'campaign_url'=>$data['url'],
								'campaign_url_short'=>$short_url,
								'token'=>'',
								'status'=>$status,
								'is_verified'=>1,
								'user_id'=>$newData['user_id'],
								'parent_user_id'=>$data['parent_user_id'],
							);
							$getChildUserList=$this->cron_model->saveRemainders($remainder_data);
						}
						$sms_send_count=$sms_send_count *  $noOfMessage;
						$this->campaign_model->debitSms($data['parent_user_id'],$sms_send_count);
						$this->saveCustomerHistroy($data['parent_user_id'],$data['id'],count($customer_list),$sms_send_count,$sms_send_count,0,$message_length);
					endif;
				}
				else {
					echo "No Customers Found :".$data['parent_user_id'];
					echo "<br/>";
					echo "<br/>";
				}
		}
	}
	
	######## Save Customer Histroy ###########
	public function saveCustomerHistroy($user_id,$setting_id,$number_of_user_send,$number_of_user_received,$number_of_sms_debit,$number_of_user_recredit,$messsage_length){
		
		$remainder_data=array(
			'created'=>date('Y-m-d'),
			'user_id'=>$user_id,
			'remainder_settings_id'=>$setting_id,
			'number_of_user_send'=>$number_of_user_send,
			'number_of_user_received'=>$number_of_user_received,
			'number_of_sms_debit'=>$number_of_sms_debit,
			'number_of_user_recredit'=>$number_of_user_recredit,
			'message_length'=>$messsage_length
		);
		$getChildUserList=$this->cron_model->saveRemaindersHistroy($remainder_data);
	}
	
	################ Cron For Plans ##############
	public function add_plan_downgrade() {
		###### Customers List #####
		$allAdvertisements=$this->cron_model->allAdvertisements();	
		foreach($allAdvertisements as $data){
		    $updatedata=array('plan_id'=> 1 );
			$this->db->where('advertisements.id', $data['id']);
			$this->db->update('advertisements', $updatedata);
			if($total_sms > 1) {
				$smsUpdatedata=array('total_sms'=> $total_sms / 2);
				$this->db->where('users.id', $data['user_id']);
				$this->db->update('users', $smsUpdatedata);
			}
		}
      echo "cron Successfully Completed - plan Downgrade";
	  die;	  
	}
} 