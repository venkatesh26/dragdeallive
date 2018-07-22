<?php
class Users_model extends CI_Model {

	#Magic Method - Construct the object
    public function __construct() {
        parent::__construct();
		$this->load->model('cities_model');
		$this->load->model('areas_model');
		$this->load->model('groups_model');
		$this->load->model('advertisment_customer_remainders_model');	
    }
	
	#Check User Code verify
	public function check_verify_code($vid) {
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
	
	# User Info
	function get_userinfo($id=null) {
	    $this->db->select('users.*,user_profiles.*,cities.name city_name,areas.name area_name');
		$this->db->where('users.id',$id);
		$this->db->join('user_profiles','user_profiles.user_id=users.id','left');
		$this->db->join('cities','cities.id=users.preferred_city_id','left');
		$this->db->join('areas','areas.id=users.preferred_area_id','left');
		$query = $this->db->get('users');
		$users = $query->row_array(); 
		return $users;		
	}
	
	# Email Info
	public function get_email_info($email=null,$user_id=null) {
	    $this->db->select('users.id,users.email');
		$this->db->from('users');	
		$this->db->where('users.id !=',$user_id);
		$this->db->where('users.email',$email);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	#Update Profile
	public function update_user_profile($user_id=null,$profile_image=null){
		if($this->input->post('city'))
		{	
			$city_id=$this->cities_model->cityFindOrSave($this->input->post('city'));
		}
		if($this->input->post('area'))
		{
			$area_id=$this->areas_model->areaFindOrSave($this->input->post('area'),$city_id);
		}
		
		$data = array(
			'email'			=> strtolower($this->input->post('email')),			
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
			'dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
		);
		$this->db->where('user_id', $user_id);
		$update = $this->db->update('user_profiles', $profile_data);
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
		
		if(empty($result)){	
			$this->db->select('advertisment_customers.*,user_profiles.address,user_profiles.gender_id,user_profiles.dob,user_profiles.doa,cities.name as city_name,areas.name as area_name');
			$this->db->where('advertisment_customers.mobile_number',$_POST['contact_number']);
			$this->db->join('users','users.customer_id=advertisment_customers.id','left');
			$this->db->join('user_profiles','users.id=user_profiles.user_id','left');
			$this->db->join('cities','cities.id=users.preferred_city_id','left');
			$this->db->join('areas','areas.id=users.preferred_area_id','left');
			$this->db->from('advertisment_customers');
			$query = $this->db->get();
			$result=$query->row_array();
		}
        return $result;		
	}
	
	######### Check Customer Data #######
	public function checkCustomerUsers($parent_user_id,$user_id){
		$this->db->select('advertisment_customer_lists.id');
		$this->db->where('advertisment_customer_lists.parent_user_id',$parent_user_id);
		$this->db->where('advertisment_customer_lists.customer_id',$user_id);
		$this->db->from('advertisment_customer_lists');
		$query = $this->db->get();
		$result=$query->row_array();
		return $result;
	}

	#################### User Register ###############
	public function create_account($verify_link, $user_type) {
		
		############### Checking Cutomer Inforamtion #################
		$this->db->select('id');
		$this->db->where('email', strtolower($this->input->post('email')));
		$this->db->or_where('mobile_number', strtolower($this->input->post('contact_number')));
		$query = $this->db->get('advertisment_customers');
		if($query->num_rows() == 1){
			$customers=$query->row_array();
			$customer_id=$customers['id'];
		}
		else {		
			$customer_data = array(
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'first_name' 	=> $this->input->post('first_name'),
				'last_name' 	=> $this->input->post('last_name'),
				'mobile_number' => $this->input->post('contact_number'),
				'email'		=> strtolower($this->input->post('email')),
			);
			$this->db->insert('advertisment_customers', $customer_data);
			$customer_id = $this->db->insert_id();
		}
		
		$data = array(
			'email'			=> strtolower($this->input->post('email')),			
			'password'		=> md5($this->input->post('password')),
			'contact_number' => $this->input->post('contact_number'),
			'user_type'		=>$user_type,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => 1,
			'is_active'		=> 1,
			'uid'			=> $verify_link,
			'customer_id'  => $customer_id
		);
		$this->db->insert('users', $data);
		$user_id = $this->db->insert_id();
			
		$profile_data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'first_name' 	=> $this->input->post('first_name'),
			'last_name' 	=> $this->input->post('last_name'),
			'mobile_number' => $this->input->post('contact_number'),
			'user_id'		=> $user_id
		);
		$this->db->insert('user_profiles', $profile_data);
		$id = $this->db->insert_id();
		
		
		return $user_id;
	}

	####### Validate User ##################
    function validate_users($user_name, $password ,$user_type=null) {
		$this->db->select('id,email,user_type,is_email_confirmed,is_active,register_type,contact_number');
		$this->db->where('email', $user_name);
		$this->db->where('password', $password);
		if($user_type!=''){
			$this->db->where('user_type', $user_type);
		}
		$query = $this->db->get('users');
		if($query->num_rows() == 1){
			return $query->row();
		}		
	}	
	
	#User Last Login Save
	function last_login_time($email,$user_id=null) {
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
	
	public function valid_user_type($email) {
		$this->load->helper('date');
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		if($query->num_rows() == 1) { 
		return true;
		}
		return FALSE;	
	}
	
	function validate($user_name, $password) {
		$this->db->select('email,user_type,users.id,first_name');
		$this->db->where('email', $user_name);
		$this->db->where('password', $password);
		$this->db->where_in('user_type', array('1','4'));
		$this->db->join('user_profiles','user_profiles.user_id = users.id');
		$query = $this->db->get('users');
		if($query->num_rows() == 1){
			return $query->row_array();
		}
	}
	
	function check_user_uid($uid){
		$today_date = date("Y-m-d h:i:s", time());
		$this->db->where('uid', $uid);	 	
		$query = $this->db->get('users');
			
		if($query->num_rows() == 1) {
			return true;
		}
		return false;
	}
	
	function update_password($email) {
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
	
	function check_user_available($email,$uid) {
		$this->load->helper('date');
		$this->db->where('email', $email);
		$this->db->where_in('user_type', array('1','4', '3'));
		$query = $this->db->get('users');
	
		if($query->num_rows() == 1) { 
			$my_date = date("Y-m-d h:i:s", time());
			$new_member_insert_data = array('uid'=> $uid ,
							'uid_request_date'=> $my_date
						);
			$query=$query->row_array(); 
			$this->db->where('id',$query['id']);
			$update = $this->db->update('users', $new_member_insert_data);
			return $update;
		}	
		return FALSE;		
	}

	public function getUsername($email=null) {
	    $this->db->select('users.id,users.email,user_profiles.first_name');
		$this->db->from('users');
		$this->db->where('users.email',$email);
		$this->db->join('user_profiles','user_profiles.user_id=users.id','lefts');
		$query = $this->db->get();
		$users = $query->row_array(); 
		return $users;	
	}
	
	function get_user_info($slug=null) {
		$this->db->select('users.email');
		$this->db->where('uid',$slug);
		$query = $this->db->get('users');
		$users = $query->row_array(); 
		return $users;
	}
	
	function get_settings() {
		$this->db->where('id', 1);
		$query = $this->db->get('settings');
		return $query->result_array();		
	}

	function get_db_session_data() {
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array(); /* array to store the user data we fetch */
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		    /* put data in array using username as key */
		    $user['user_name'] = $udata['user_name']; 
		    $user['is_logged_in'] = $udata['is_logged_in']; 
		}
		return $user;
	}
	
	function update_settings($data ) {
		$this->db->where('id', 1);
		$this->db->update('settings', $data);
		$report = array();
		$errors=$this->db->error();
		$report['error'] = $errors['code'];
		$report['message'] = $errors['message'];
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

	function update_pwrd() {
		$this->db->where('email', $this->input->post('uid'));
		$query = $this->db->get('users');
        if($query->num_rows < 0){
			 echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>';
			 echo "Enter registered mail-id !";	
			 echo '</strong></div>';
		}else {
			$new_member_insert_data = array(
		 	'password'=> md5($this->input->post('password') ),
			'uid'=>''
			);
			$this->db->where('uid', $this->input->post('uid'));
			$update = $this->db->update('users', $new_member_insert_data);
		    return $update;
		}
	      
	}

	function check_password($user_id=false) {
		$this->db->select('id');
		if(!$user_id){
			$this->db->where('id',$this->session->userdata('admin_id'));
		}else{
			$this->db->where('id',$user_id);		
		}
		$this->db->where('password',md5($this->input->post('old_password')));
		$query=$this->db->get('users'); 
		//echo $this->db->last_query();die;
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function change_password($user_id=null,$old_pwd=null,$pwd) {
   		$data = array(
          'password' => $pwd
         );
      	if(!$user_id){
			$this->db->where('id',$this->session->userdata('admin_id'));
			$this->db->where('password',$old_pwd);
		}else{
			$this->db->where('id',$user_id);
		}
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
	
	function get_profile() {
    	$this->db->select('id,first_name,last_name,display_name,mobile_number,telephone_number');
		$this->db->where('user_profiles.user_id', $this->session->userdata('admin_id'));
		$query = $this->db->get('user_profiles');
		return $query->row_array();	
	}

	function get_users_profile($user_type,$user_id) {
		if($user_type=="hotels") {
			$this->db->select('users.id,users.email,hotels.name as name');
			$this->db->where('users.id', $user_id);
			
			$this->db->join('hotels', 'users.id = hotels.hotel_id');
		} else {
			$this->db->select('users.id,users.email,user_profiles.first_name as name');
			$this->db->where('users.id', $user_id);
			
			$this->db->join('user_profiles', 'users.id = user_profiles.user_id');
		}
		$query = $this->db->get('users');
		return $query->row();
	}
	
	function get_email() {
    	$this->db->select('email');
		$this->db->where('id', $this->session->userdata('admin_id'));
		$query = $this->db->get('users');
		return $query->row_array();	
	}
	function update_profile($data)
    	{
		$this->db->where('user_id', $this->session->userdata('admin_id'));
		$this->db->update('user_profiles', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	function update_email($data) {
		$this->db->where('id', $this->session->userdata('admin_id'));
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
	
	function create_member() {
		$this->db->where('email', $this->input->post('email_address'));
		$query = $this->db->get('users');

        	if($query->num_rows > 0){
		 echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>';
		 echo "Already registered !";	
		 echo '</strong></div>';
		}else{
		$new_member_insert_data = array(
			'email' => $this->input->post('email_address'),
		 	'password'=> md5($this->input->post('password') )						
		);
			$insert = $this->db->insert('users', $new_member_insert_data);
		       	return $insert;
		}
	}//create_member
	
	function verify_email($uid) {
		$this->db->where('uid', $uid);
		$new_member_insert_data = array(
		 	'is_email_confirmed'=>1,
			'uid'=>'',
			'email_verified_date'=>date('Y-m-d h:i:s')
		);
		$update = $this->db->update('users', $new_member_insert_data);
		return $update;
	}
	
	function today_statistics($table){
		if($table=='user_logins'){
			$this->db->select('COUNT(distinct `user_id`) AS `numrows`');
			$this->db->where_not_in('users.user_type', array('1','4'));
			$this->db->join('users','users.id = user_logins.user_id', 'left');
		} else {
			$this->db->select('COUNT(*) AS `numrows`');
		}
		if($table=='offers'){
			$this->db->where("DATE_FORMAT(modified,'%Y-%m-%d')",date('Y-m-d'));
		} else {
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		$query = $this->db->get($table);
		$result = $query->row_array();
		if(!empty($result)){
			return $result['numrows'];
		} else {
			return '0';
		}
	}
	
	function add_statistics($table, $type=0){
		$this->db->select('COUNT(*) AS `numrows`');
		$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		if($type=='active'){
			$this->db->where("is_active",1);
		}
		$query = $this->db->get($table);
		$result = $query->row_array();
		if(!empty($result)){
			return $result['numrows'];
		}
		return '0';
	}
	
	function user_statistics($type='all', $table=null){
		$this->db->select('COUNT(*) AS `numrows`');
		if($table==null){
			$table='users';
		}
		if($type=='active'){
			$this->db->where("is_active",1);
		}
		else if($type=='facebook'){
			$this->db->where("register_type",2);
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		else if($type=='twitter'){
			$this->db->where("register_type",3);
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		else if($type=='google'){
			$this->db->where("register_type",4);
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		else if($type=='signup'){
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		else if($type=='signin'){
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		$query = $this->db->get($table);
		$result = $query->row_array();
		if(!empty($result)){
			return $result['numrows'];
		}
		return '0';
	}

	function yellowpages_statistics($type=null, $table=null){
		if($table==null){
			$table='advertisements';
		}
		$this->db->select('COUNT(*) AS `numrows`');
		
		if($type=='active'){ 
			$this->db->where("is_active",1);
		}
		else if($type=='today_active'){
			$this->db->where("is_active",1);
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		else if($type=='today'){
			$this->db->where("DATE_FORMAT(".$table.".created,'%Y-%m-%d')",date('Y-m-d'));
		}
		$query = $this->db->get($table);
		$result = $query->row_array();
		if(!empty($result)){
			return $result['numrows'];
		}
		return '0';
	}	
	
	public function recent_messages(){
		$this->db->select('messages.id,messages.created,messages.is_high_important,
		messages.message,messages.is_read,messages.is_high_important,
		users.display_name,users.user_type,users.id as user_id,
		users.profile_image,users.image_dir,hotels.name as hotel_name');
		$this->db->join('users', 'users.id = messages.from_user_id', 'left');
		$this->db->where('messages.to_delete','0');
		$this->db->from('messages');
		//$this->db->where('messages.to_user_id','1');
		$this->db->where('messages.message_type','1');
		$this->db->where('messages.is_active','1');
		$this->db->where('messages.to_user_id','1');
		
		$this->db->where('messages.is_main','0');
		$this->db->order_by('messages.id','desc');
		
		$this->db->join('hotels', 'hotels.hotel_id = messages.from_user_id', 'left');
		//$this->db->where('is_active', 1);
		
		$this->db->limit('5');
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $query->result_array();
	}
	function get_calander_events($startDate,$endDate){
		$this->db->select('id,start_date as start,end_date as end,title');
		$this->db->where('start_date >=',$startDate);
		$this->db->where('end_date <=',$endDate);
		$this->db->where('user_id',$this->session->userdata('admin_id'));
		$query = $this->db->get('calendar_events');
		$datas = $query->result_array();
		//echo $this->db->last_query();
		return $datas;die;
	}
	function add_events(){
		$datas = array('user_id' => $this->session->userdata('admin_id'),
						'created'=>date('Y-m-d h:i:s'),
						'title'=>$_POST['title'],
						'start_date'=>date('Y-m-d',strtotime($_POST['start_date']."+1 days")),
						'end_date' => date('Y-m-d',strtotime($_POST['end_date']."+1 days")),
						'status'=> '1'
					);
		$insert = $this->db->insert('calendar_events', $datas);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	function edit_events($id){
		$edit_details =  array('title'=> $_POST['title']);
		$this->db->where('id', $id);
		$update = $this->db->update('calendar_events', $edit_details);
		
		$this->db->select('id,start_date as start,end_date as end,title');
		$this->db->where('id',$id);
		$query = $this->db->get('calendar_events');
		$datas = $query->row_array();
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return $datas;
		}else{
			return false;
		}
	}
	 function generate_display_name($display_name=null){
		if($display_name==""){
			if(isset($_POST['first_name'])){
				$name = substr(url_title(strtolower($_POST['first_name'].$_POST['last_name']), '', TRUE),0,8);
			} elseif(isset($_POST['hotel_name'])) {
				$name = substr(url_title(strtolower($_POST['hotel_name']), '', TRUE),0,8);
			}
		} else {
			$name = $display_name;
		}
		$this->db->select('display_name');
		$this->db->where('display_name',$name);
		$query = $this->db->get('users');
		$chk = $query->num_rows();
		if($chk==0){
			return $name;
		} else {
			$randId = random_string('numeric', 3);
			return $this->generate_display_name($name.$randId);
		}
		
	 }
	
}