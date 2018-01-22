<?php
class Home_model extends CI_Model {
	
    # Construct - Load the database
    public function __construct() {
    }
    
   ############# Create User ###################
	public function saveCampignUser($verify_link, $password){
		$this->db->select('users.id');
		$this->db->where('email',$this->input->post('email'));
		$this->db->from('users');
		$query = $this->db->get();			
		$result=$query->row_array(); 
		if(empty($result)){
				
			$data = array(
				'email'			=> strtolower(trim($this->input->post('email'))),			
				'password'		=> md5($password),
				'contact_number' => $this->input->post('contact_number'),
				'user_type'		=>3,
				'is_approved' 	=> 1,
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'register_type' => 4,
				'is_active'		=> 1,
				'uid'			=> $verify_link,
			);
			$this->db->insert('users', $data);
			$user_id = $this->db->insert_id();
			
			$profile_data = array(
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'first_name' 	=> 'Customer',
				'mobile_number' => $this->input->post('contact_number'),
				'user_id'		=> $user_id
			);
			$this->db->insert('user_profiles', $profile_data);
			$response['user_id']=$user_id;
			$response['is_already_register']=false;
			return $response;
		}
		else{
			$response['user_id']=$result['id'];
			$response['is_already_register']=true;
			return $response;
		}
	}
	
	############### Update User Details ###########
	public function updateCampignUser($user_id, $data, $profile_data) {
		$this->db->where('id', $user_id);
		$this->db->update('users', $data);	

		$this->db->where('user_id', $user_id);
		$this->db->update('user_profiles', $profile_data);			
	}
	
	################# Create Campaign Advertisment ############
	public function createAddCampaign() {
		
		$this->load->model('Advertisment_model');
		if($this->input->post('city')){
			If($this->input->post('city_id')==''){
				$city_id=$this->input->post('city_id');
			}
			else {
				$city_id=$this->cityFindOrSave($this->input->post('city'));
			}
		}
		if($this->input->post('area')){
			If($this->input->post('area_id')==''){
				$area_id=$this->input->post('area_id');
			}
			else {
				$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
			}
		}
		
		$category_data_id=array();
		if($this->input->post('keywords')) {
			$keywords=explode(',',$this->input->post('keywords'));
			foreach($keywords as $key=>$name){
				$category_data_id[]=(is_numeric($name)) ? $name : $this->Advertisment_model->categoryFindOrSave($name);
			}
		}
		$category_data_ids['category_id']=implode(',',array_merge($category_data_id));
		$category_data_id_update =(!empty($category_data_ids['category_id'])) ? $category_data_ids['category_id'] : '';
		
		$campaign_data = array(
			'created'	=> date('Y-m-d h:i:s'),
		   'category_id'=>$category_data_id_update,
			'name' => $this->input->post('name'),
			'owner' => $this->input->post('owner'),
			'contact_number' => trim($this->input->post('contact_number')),
			'address_line'=> $this->input->post('address_line'),
			'description'=> $this->input->post('description'),
			'zip'=> $this->input->post('zip'),
			'email' => trim($this->input->post('email')),
			'is_active'=>false,
			'overall_score'=>5,
			'site_score'=>4,
			'working_start'=>'9 AM',
			'working_end'=>'9 PM',
			'city_name' 	=> $this->input->post('city'),
			'city_id' 	=> $city_id,
			'area_name' 	=> $this->input->post('area'),
			'area_id' => $area_id,
			'user_id'=>$this->input->post('user_id')
		);
		$this->db->insert('advertisements', $campaign_data);
		$addId = $this->db->insert_id();
		
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
		
		$data=array('add_id'=>$addId , 'user_id'=>$this->input->post('user_id'));
		return $data;
	}
	
	############### Send  Keyword Enquiry ###########
	function add_keyword_enquiry() {
		
		$keyword=$this->input->post('keyword');
	   	$claim_data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'name' => $this->input->post('name'),
			'contact_no' => $this->input->post('contact_no'),
			'email' => $this->input->post('email'),
			'keyword' 	=> $this->input->post('keyword'),
			'city' 	=> $this->input->post('city'),
			'area' 	=> $this->input->post('area'),
			'is_send'=>0,
		);
		$this->db->insert('keyword_enquiry', $claim_data);
		$id = $this->db->insert_id();
		return true;	
	}
	
	#################### Save Keyword Enquiry ###############
	function save_enquiry(){

		$this->load->library('template');
		$this->db->select('keyword_enquiry.*');
		$this->db->where('is_send',0);
		$this->db->from('keyword_enquiry');
		$query = $this->db->get();			
		$keyword_result=$query->result_array(); 
		foreach($keyword_result as $keywords) {
			
				$this->db->select('advertisements.*');
				$this->db->where('advertisements.email !=','');
				$this->db->where('advertisements.is_active',1);
				if($keywords['city']!=''){
					$this->db->where('advertisements.city_name',$keywords['city']);	
				}
				if($keywords['area']!=''){
					$this->db->where('advertisements.area_name',$keywords['area']);	
				}
				$set=$keywords['keyword_id'];
				$this->db->where("FIND_IN_SET('$set',category_id) !=", 0);
				$this->db->from('advertisements');  
				$query = $this->db->get();	
				$listings=$query->result_array();
				foreach($listings as $data) {
					
					$notificatiosTemplate='mail_template/claim_notifications_new_user';
					$email_body = $this->template->load('mail_template/template', $notificatiosTemplate, $data, TRUE);
					$claim_data = array(
						'created'	=> date('Y-m-d h:i:s'),
						'email' => $data['email'],
						'template' => $email_body,
						'is_send'=>0,
					);
					$this->db->insert('keyword_enquiry_mail', $claim_data);
				}
				$update_data=array();
				$update_data['is_send']=1;
				$this->db->where('id', $keywords['id']);
				$this->db->update('keyword_enquiry', $update_data);
		}
	}
	  
	######### Keyword Notifications ##########  
	public function keyword_notification() {
		$this->load->library('template');
		$this->db->select('keyword_enquiry_mail.*');
		$this->db->where('is_send',0);
		$this->db->from('keyword_enquiry_mail');
		$query = $this->db->get();			
		$keyword_result=$query->result_array(); 
		$admin_email=admin_settings_initialize('email');
		$site_name=admin_settings_initialize('sitename');
		foreach($keyword_result as $keywords) {
			$this->email->from($admin_email, $site_name);
			$this->email->to($keywords['email']);
			$this->email->subject('Dialbe Enquiry Notification');
			$this->email->message($keywords['template']);	
			if ($this->email->send()) {
				$update_data=array();
				$update_data['is_send']=1;
				$this->db->where('id', $keywords['id']);
				$this->db->update('keyword_enquiry_mail', $update_data);
			}			
		}	
        die;		
	}
	
	########## Elastic EMail #############
	public function sendElasticEmail($to, $subject, $body_text, $body_html, $from, $fromName) {
		$res = "";
		$data = "username=".urlencode("damovenkatesh@gmail.com");
		$data .= "&api_key=".urlencode("0771851d-24a6-43f0-9904-f15d1293f017");
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
	
	#Home Get Home Listings
	public function get_home_listings(){
        $this->db->select('advertisements.id,advertisements.name,advertisements.owner,advertisements.contact_number,advertisements.address_line,advertisements.short_description,advertisements.image_dir,advertisements.profile_image,advertisements.total_user_rated,advertisements.zip,advertisements.email,advertisements.working_start,advertisements.working_end,advertisements.website,advertisements.city_name,advertisements.area_name,advertisements.site_score,advertisements.overall_score,advertisements.rating');
		$this->db->from('advertisements');
		$this->db->where('advertisements.is_active','1');
		$this->db->order_by("advertisements.id", "DESC");
		$this->db->limit('10');
		$query = $this->db->get();			
		$result=$query->result_array(); 
		return $result;	
	}
	
	#Home Get Home Listings
	public function get_home_premium_listings() {
        $this->db->select('advertisements.id,advertisements.name,advertisements.image_dir,advertisements.profile_image,advertisements.total_user_rated,advertisements.website,advertisements.city_name,advertisements.area_name,advertisements.site_score,advertisements.overall_score,advertisements.rating,advertisements.plan_id');
		$this->db->from('advertisements');
		$this->db->where('advertisements.is_active','1');
		$this->db->order_by("advertisements.plan_id", "DESC");
		$this->db->where("advertisements.plan_id >", 0);
		$this->db->limit('28');
		$query = $this->db->get();			
		$result=$query->result_array(); 
		return $result;	
	}
	
	
	#Home Get Home Cities
	public function get_home_cities($limit){
		$response=array();
	    $this->db->select('cities.id,cities.name,cities.city_image,cities.image_dir,cities.description,cities.add_count');
		$this->db->where('cities.featured_city','1');
		$this->db->where('cities.is_active','1');
		$this->db->order_by('id','rand()');
		$this->db->limit($limit);
		$query = $this->db->get('cities');
	    $results=$query->result_array();
        return $results; 	
	}
	
	#Home Update Profile
	public function update_profile($user_id=null,$profile_image=null){
		if($this->input->post('city'))
		{	
			$city_id=$this->cityFindOrSave($this->input->post('city'));
		}
		if($this->input->post('area'))
		{
			$area_id=$this->areaFindOrSave($this->input->post('area'),$city_id);
		}
		
		$data = array(
			'email'			=> strtolower($this->input->post('email')),	
			'sender_id1'			=> strtolower($this->input->post('sender_id1')),	
			'sender_id2'			=> strtolower($this->input->post('sender_id2')),				
			'modified' 		=> date('Y-m-d h:i:s'),
			'preferred_city_id' 		=> $city_id,
			'preferred_area_id' 		=> $area_id,
		);
		if(!empty($profile_image))
		{
			$image_data = array(
			'image_dir'			=> $profile_image['image_dir'],			
			'profile_image' 	=> $profile_image['profile_image'],
		     );
		  $data=array_merge($image_data,$data);
		}
		$this->db->where('id', $user_id);
		$update = $this->db->update('users', $data);
		
		$profile_data = array(
			'first_name'	=> strtolower($this->input->post('first_name')),			
			'last_name'	=> strtolower($this->input->post('last_name')),			
			'modified' 		=> date('Y-m-d h:i:s'),
			'mobile_number' => $this->input->post('contact_number'),
			'address' => $this->input->post('address'),
			'gender_id' => $this->input->post('gender'),
			'dob' => $this->input->post('dob'),
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('user_profiles', $profile_data);
		
		
	}
	# User Create an account
	public function create_account($verify_link)
	{
		$data = array(
			'email'			=> strtolower($this->input->post('email')),			
 			'password'		=> md5($this->input->post('password')),
			'contact_number' => $this->input->post('contact_number'),
			'user_type'		=>'3',
			'is_approved' 	=> 1,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => 1,
			'is_active'		=> 1,
			'uid'			=> $verify_link,
		);
		$this->db->insert('users', $data);
		$user_id = $this->db->insert_id();
		
		$profile_data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'first_name' 	=> $this->input->post('name'),
			'mobile_number' => $this->input->post('contact_number'),
			'user_id'		=> $user_id
		);
		$this->db->insert('user_profiles', $profile_data);
		$id = $this->db->insert_id();
		return $user_id;
	}

	#Check User Code verify
	public function check_verify_code($vid) 
	{
		$today_date = date("Y-m-d h:i:s", time());
		$this->db->where('uid', $vid);    	 	
		$query = $this->db->get('users');
		$numRows = $query->num_rows();
		$result = $query->row_array();
		if($numRows == 1) {
			$update_vid = array('uid'=>'','email_verified_date'=>date('Y-m-d h:i:s'),'is_email_confirmed'=>'1');
			$this->db->where('id',$result['id']);
			$this->db->update('users', $update_vid);
			return true;
		}else{
			return false;
		}
	}

	#validate user
    function validate_users($user_name, $password ,$user_type) 
	{
		$this->db->select('id,email,user_type,is_email_confirmed,is_active,is_approved,register_type,contact_number');
		$this->db->where('email', $user_name);
		$this->db->where('password', $password);
		$this->db->where('user_type', $user_type);
		$query = $this->db->get('users');
		if($query->num_rows() == 1){
			return $query->row();
		}		
	}	
	
	#User Last Login Save
	function last_login_time($email,$user_id=null) 
	{
		$this->load->helper('date');
		$this->load->library('user_agent');
    	$this->db->select('id,email,user_type,last_login_time,current_login_time');
		if(!empty($email))
		{
		$this->db->where('email', $email);
		}
		else
		{
		$this->db->where('id', $user_id);
		}
		$query = $this->db->get('users');
		$getUserDetails = $query->row();
		
		if($getUserDetails->last_login_time == "0000-00-00 00:00:00" ) {
			$lastlogin=date('Y-m-d h:i:s',now());
		} else {
			$lastlogin=$getUserDetails->current_login_time;
		}
		$loginDetails =  array('current_login_time'=> date('Y-m-d h:i:s',now()),'last_login_time'=> $lastlogin);
		$this->db->where('id', $getUserDetails->id);
		$update = $this->db->update('users', $loginDetails);
		$logHistory = array('user_id' => $getUserDetails->id,'created'=>date('Y-m-d h:i:s',now()),'ip'=>$this->input->ip_address(),'browser_info'=>$this->agent->agent_string(),'is_deleted' => 0);
		$insert = $this->db->insert('user_logins', $logHistory);
	}
	  
	  
	#socail Account Create
	public function social_create_account($user_data,$user_type,$profile_image_data=null)
	{
	   $gender_id=0;
	   if(isset($user_data['id']))
	   {
	   $field='facebook_user_id';
	   $value=$user_data['id'];
	   }
	   else
	   {
	   $field='google_auth_id';
	   $value=$user_data['uid'];
	   $user_data['first_name']=$user_data['name'];
	   }
	   if($user_type=='4')
	   {
	   $field='twitter_auth_id';
	   $value=$user_data['id'];
	   }
	   if(isset($user_data['gender']) && $user_data['gender']=='male')
	   {
	   $gender_id="1";
	   }
	   if(isset($user_data['gender']) && $user_data['gender']=='female')
	   {
	   $gender_id="2";
	   }
	       $img_dir='';
		   $profile_image='';
	   	   if(!empty($profile_image_data))
			{
			$img_dir=$profile_image_data['img_dir'];
			$profile_image=$profile_image_data['filename'];
		    }
		    $data = array(
			'email'			=> (isset($user_data['email']))?strtolower($user_data['email']):'',
			$field          => $value, 
			'display_name'	=> strtolower($user_data['first_name']),
			'user_type'		=>'3',
			'is_approved' 	=> 1,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => $user_type,
			'is_active'		=> 1,
			'image_dir'=>$img_dir,
			'profile_image'=>$profile_image,
			'is_email_confirmed'=>1,
		);
		$this->db->insert('users', $data);
		$user_id = $this->db->insert_id();
		
		$profile_data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'first_name' 	=> strtolower($user_data['name']),
			'gender_id'     =>$gender_id,
			'user_id'		=> $user_id
		);
		$this->db->insert('user_profiles', $profile_data);
		$id = $this->db->insert_id();
		
		$this->db->select();
		$this->db->from('users');
		$this->db->where('users.id',$user_id);
		$query = $this->db->get();
		$users = $query->row_array(); 
		return $users;
	}
	
	
	function check_user_available($email,$uid) 
	{
		$this->load->helper('date');
		$this->db->where('email', $email);
		$this->db->where('user_type','3');
		$query = $this->db->get('users');
		if($query->num_rows() == 1) { 
			$my_date = date("Y-m-d h:i:s", time());
			$new_member_insert_data = array('uid'=> $uid ,
							'uid_request_date'=> $my_date
						);
			$this->db->where('email',$email);
			$update = $this->db->update('users', $new_member_insert_data);
			return $update;
		}else{
			return FALSE;
		}		
	}
	
	public function valid_user_type($email)
	{
		$this->load->helper('date');
		$this->db->where('email', $email);
		$this->db->where('user_type','3');
		$query = $this->db->get('users');
		if($query->num_rows() == 1) { 
		return true;
		}else{
			return FALSE;
		}	
	}
	
	public function getUsername($email=null)
	{
	    $this->db->select('users.id,users.email,user_profiles.first_name');
		$this->db->from('users');
		$this->db->where('users.email',$email);
		$this->db->join('user_profiles','user_profiles.user_id=users.id','lefts');
		$query = $this->db->get();
		$users = $query->row_array(); 
		return $users;	
	}
	
	public function check_user_uid($uid)
	{
		$today_date = date("Y-m-d h:i:s", time());
		$this->db->where('uid', $uid); 	 	
		$query = $this->db->get('users');
		if($query->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function update_password($email) 
	{
		$this->db->where('email',$email);
		$this->db->get('users');
	    $query = $this->db->get('users');
        if($query->num_rows() < 0){
			return false;
		}else {
			$new_member_insert_data = array(
		 	'password'=> md5($this->input->post('password') ),
			'uid'=>''
			);
			$this->db->where('email', $email);
			$update = $this->db->update('users', $new_member_insert_data);
		    return $update;
		}
	}
	function get_user_info($slug=null)
	{
		$this->db->select('users.email');
		$this->db->where('uid',$slug);
		$query = $this->db->get('users');
		$users = $query->row_array(); 
		return $users;
	}
	function get_userinfo($id=null)
	{
	    $this->db->select('users.*,user_profiles.*,cities.name city_name,areas.name area_name');
		$this->db->where('users.id',$id);
		$this->db->join('user_profiles','user_profiles.user_id=users.id','left');
		$this->db->join('cities','cities.id=users.preferred_city_id','left');
		$this->db->join('areas','areas.id=users.preferred_area_id','left');
		$query = $this->db->get('users');
		$users = $query->row_array(); 
		return $users;		
	}
	
	function get_pages($slug)
	{
	    $this->db->select('pages.*');
		$this->db->where('pages.alias',$slug);
		$this->db->where('pages.is_active','1');
		$query = $this->db->get('pages');
		$pages = $query->row_array(); 
		return $pages;	
	}
	
	function add_contactus()
	{
	   	$profile_data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'name' 	        => $this->input->post('name'),
			'contact_number'=> $this->input->post('contact_number'),
			'email' 	    => $this->input->post('email'),
			'title' 	    => $this->input->post('title'),
			'message' 	    => $this->input->post('message'),
		);
		$this->db->insert('contact_us', $profile_data);
		$id = $this->db->insert_id();
		return true;	
	}
	
	
	function add_enquiry()
	{
	   	$claim_data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'advertisment_id' => $this->input->post('advertisment_id'),
			'name' 	        => $this->input->post('name'),
			'contact_no' => $this->input->post('contact_no'),
			'email' => $this->input->post('email'),
			'title' 	   		=> $this->input->post('title'),
			'message' 	=> $this->input->post('message'),
			'is_active'    => 1,
		);
		$this->db->insert('advertisment_enquiry_list', $claim_data);
		$id = $this->db->insert_id();
		return true;	
	}
	
	
	function add_claim($type=null, $session_data=null) {
		$isAccount=0;
		if($this->input->post('is_account')){
			$isAccount=1;
		}
		if($type==null){
			$claim_data = array(
				'created'		=> date('Y-m-d h:i:s'),
				'email' 	    => $this->input->post('email'),
				'name' 	        => $this->input->post('name'),
				'contact_number' => $this->input->post('contact_number'),
				'url' 	   		=> $this->input->post('url'),
				'description' 	=> $this->input->post('message'),
				'is_account'    => $isAccount
			);
		}
		else {
			$claim_data = array(
				'created'		=> date('Y-m-d h:i:s'),
				'email' 	    => $session_data['user_email'],
				'name' 	        => $session_data['user_name'],
				'contact_number' => $session_data['contact_number'],
				'url' 	   		=> $this->input->post('url'),
				'description' 	=> $this->input->post('message'),
				'is_account'    => 1
			);
		}
		$this->db->insert('claim_my_bussiness', $claim_data);
		$id = $this->db->insert_id();
		return true;	
	}
	
	
	function get_areas($city_name=null)
	{
		$areas_info=array();
		$this->db->select('areas.id,areas.name');
		$this->db->where('areas.is_active','1');
	    $this->db->where('cities.is_active','1');
		$this->db->where('cities.name',$city_name);
		$this->db->join('cities','cities.id=areas.city_id','left');
		$this->db->order_by('areas.name','asc');
		$query = $this->db->get('areas');
		$areas=$query->result_array();
		return $areas;	
	}
	
	function get_my_list($keyword=null,$city_name=null,$area_name=null)
	{
		$this->db->select('advertisements.id,advertisements.name as add_name,advertisements.owner');
		$this->db->where('advertisements.is_active','1');
		$this->db->from('advertisements');
		#City Based Search
		if(!empty($city_name))
		{
			$this->db->where('advertisements.city_name',$city_name);	
		}
		#Area Based Search
		if(!empty($area_name))
		{
			$this->db->where('advertisements.area_name',$area_name);
		}
		#Keyword Based Search
		if(!empty($keyword))
		{
			$this->db->like('advertisements.name',$keyword);
		}		
		$this->db->group_by('advertisements.id');
		$this->db->limit(10);
		$query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	function get_cities($keyword=null)
	{
		$results=array();
		if(!empty($keyword))
		{
			$this->db->select('cities.name,cities.id');
			#Keyword Based Search		
			$this->db->like('cities.name',$keyword,'after');
			$query = $this->db->get('cities');	
			$results=$query->result_array();
		}
		return $results;
	}
	
	function get_category($keyword=null,$city_name=null,$area_name=null) {
		$response=array();
	    $this->db->select('categories.name,categories.id');
		#Keyword Based Search
		if(!empty($keyword))
		{
			$this->db->like('categories.name',$keyword,'after');
		}
		$this->db->order_by('categories.name');
	    $query = $this->db->get('categories');	
		$results=$query->result_array();
      
		if(!empty($results)){
			
			   $this->db->select('advertisements.id');
				foreach($results as $result){
					$catid=$result['id'];
					$this->db->where("FIND_IN_SET('$catid',category_id) !=", 0);	
				}				   
				#City Based Search
				if(!empty($city_name))
				{
					$this->db->where('advertisements.city_name',$city_name);	
				}
				#Area Based Search
				if(!empty($area_name))
				{
					$this->db->where('advertisements.area_name',$area_name);
				}
                $query = $this->db->get('advertisements');
				$new_results=$query->result_array();	
				if(!empty($new_results)){
						$response[]=$result;
				}	
		}
        return $response;
	}
	
	function get_city_area_category($keyword=null,$city_name=null,$area_name=null)
	{
		$response=array();
	    $this->db->select('categories.name,categories.id');
		#Keyword Based Search
		if(!empty($keyword))
		{
			$this->db->like('categories.name',$keyword,'after');
		}
		if(!empty($city_name))
		{
		   $this->db->where('cities.name',$city_name);
		}
		if(!empty($area_name))
		{
		   $this->db->where('areas.name',$area_name);
		}
		$this->db->order_by('categories.name');
	    $query = $this->db->get('categories');	
		$this->db->join('category_listing','category_listing.category_id=categories.id','left');
	    $this->db->join('areas','areas.id=category_listing.area_id','left');
		$this->db->join('cities','cities.id=category_listing.city_id','left');
		$results=$query->result_array();
        return $results; 		
	}
	
	function get_home_category()
	{
		$response=array();
	    $this->db->select('main_category.name,main_category.id,main_category.font_name');
		$this->db->where('main_category.is_active','1');
		$this->db->order_by('main_category.list_count');
		$this->db->limit('20');
		$query = $this->db->get('main_category');
	    $results=$query->result_array();
        return $results; 		
	}
	
	
	public function user_type_check($fb_id=null,$fb_email=null,$user_type=null,$fun=null) 
	{
		$this->db->select('users.id,users.email,users.facebook_user_id,users.is_active,users.user_type');
		$this->db->from('users');
		if(!empty($fb_email)) {
			$this->db->where('users.email',$fb_email);
		} else if(!empty($fb_id) && $user_type=="2") {
			$this->db->where('users.facebook_user_id',$fb_id);
		} else if(!empty($fb_id) && $user_type=="3") {
			$this->db->where('users.google_auth_id',$fb_id);
		}
		else if(!empty($fb_id) && $user_type=="4") {
			$this->db->where('users.twitter_auth_id',$fb_id);
		}
		
		if($fun=='authorize') {
			$this->db->where('users.register_type',$user_type);
		} else {
			$this->db->where('users.register_type !=',$user_type);
		}
		$query = $this->db->get();
		if($fun=='authorize') {	  
			return $query->row_array();
		} else {
			return $query->num_rows(); 
		}
	}
	
	public function get_email($email=null,$user_id=null)
	{
	    $this->db->select('users.id,users.email');
		$this->db->from('users');	
		$this->db->where('users.id !=',$user_id);
		$this->db->where('users.email',$email);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function check_password($user_id=false) 
	{
		$this->db->select('id');
		$this->db->where('id',$user_id);		
		$this->db->where('password',md5($this->input->post('old_password')));
		$query=$this->db->get('users'); 
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function change_password($user_id=null,$old_pwd=null,$pwd) 
	{
   		$data = array(
          'password' => $pwd
         );
		$this->db->where('id',$user_id);
      	$this->db->update('users', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
   	}
	
	######### City Find Or Save ######## 
	public function cityFindOrSave($name)
	{
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
	public function areaFindOrSave($name,$city_id)
	{
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
	
}