<?php
class Common_model extends CI_Model {

	public function __construct(){ 
		parent::__construct();
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
	
	function get_settings() {
		$this->db->where('id', 1);
		$query = $this->db->get('settings');
		return $query->result_array();		
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
	
	############# Send Email ###############
	public function SendEmail($to, $subject, $emailData, $templateName = null, $layoutName = 'template', $from = null, $replyTo = null, $attachment = null, $cc = null, $bcc = null){
		
		############ Load Template ##########
		$this->load->library('template');
		
		############ Load Email ############
		$this->load->library('email');
		
		$email_body = $this->template->load('mail_template/'.$layoutName, 'mail_template/'.$templateName, $emailData, TRUE);
		$this->email->from(admin_settings_initialize('email'), admin_settings_initialize('sitename'));
		if($from!=''){
			$this->email->from($from, admin_settings_initialize('sitename'));
		}
		if($replyTo!=''){
			$this->email->replyTo($replyTo, admin_settings_initialize('sitename'));
		}
		$this->email->to($to);
		if($cc!=''){
			$this->email->cc($cc);
		}
		if($bcc!=''){
			$this->email->bcc($bcc);
		}
		$this->email->subject($subject);
		$this->email->message($email_body);
	
		if($this->email->send()) {
		    return true;
		}
		return false;
	}
}
?>