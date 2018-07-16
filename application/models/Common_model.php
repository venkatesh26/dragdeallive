<?php
class Common_model extends CI_Model {

	public function __construct(){ 
		parent::__construct();
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

	
	############## Count Action ##################
	function count_action($id=false,$count_field=false,$action=false,$table=false,$count =false){	
		$inc=1;
		if(!$count ){
			$string = str_replace("'","%27",  $count_field.$action.$inc);	
			$this->db->set($count_field,$string, FALSE);
		}else{
				$this->db->set($count_field,$count, FALSE);
		}
		$this->db->where('id', $id);
		$this->db->update($table);
		$insert = $this->db->insert_id() ;
		return $insert;
	}
}
?>