<?php
class Users_model extends CI_Model {

	function validate($user_name, $password)
	{
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
			
		if($query->num_rows() == 1)
		{
			return true;
		}else{
			return false;
		}
	}
	
	function last_login_time($email) {
		$this->load->helper('date');
		$this->load->library('user_agent');
    	$this->db->select('id,email,user_type,last_login_time,current_login_time');
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		$getUserDetails = $query->row();
		
		if($getUserDetails->last_login_time == "0000-00-00 00:00:00" ) {
			$lastlogin=date('Y-m-d h:i:s',now());
		} else {
			$lastlogin=$getUserDetails->current_login_time;
		}
		//Update users Last login Details
		$loginDetails =  array('current_login_time'=> date('Y-m-d h:i:s',now()),'last_login_time'=> $lastlogin);
		$this->db->where('id', $getUserDetails->id);
		$update = $this->db->update('users', $loginDetails);
		//Maintain users log history
		$logHistory = array('user_id' => $getUserDetails->id,'created'=>date('Y-m-d h:i:s',now()),'ip'=>$this->input->ip_address(),'browser_info'=>$this->agent->agent_string(),'is_deleted' => 0);
		$insert = $this->db->insert('user_logins', $logHistory);
	}
	
	function check_user_available($email,$uid) 
	{
		$this->load->helper('date');
		$this->db->where('email', $email);
		$this->db->where_in('user_type', array('1','4'));
		$query = $this->db->get('users');
		if($query->num_rows() == 1) { 
			$my_date = date("Y-m-d h:i:s", time());
			$new_member_insert_data = array('uid'=> $uid ,
							'uid_request_date'=> $my_date
						);
			$this->db->where('id',$query->id);
			$update = $this->db->update('users', $new_member_insert_data);
			return $update;
		}else{
			return FALSE;
		}		
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
		//echo $this->db->last_query();die;
		$result = $query->row_array();
		if(!empty($result)){
			return $result['numrows'];
		} else {
			return '0';
		}
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