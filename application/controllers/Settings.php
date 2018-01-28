<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

    #Construct Function
	public function __construct() {
		
        parent::__construct();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->model('settings_model');
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
	}
	
	public function add(){
	
		$this->data=array();
		$this->data['title_of_layout']=$this->site_name." - Sms Notification Settings";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Sms Notification Settings',base_url());
		$this->data['main_content']=$this->load->view('settings/add', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	public function notification_settings(){
		
		if($_POST) {
			
			$this->form_validation->set_rules('message','Message','trim|required');
			if($this->form_validation->run() == true) 
			{
				$sender_id=$this->settings_model->saveSettings($this->session->userdata('user_id'));
				$extra_array = array('status'=>'success','msg'=>'Settings Successfully Saved...');
				echo json_encode($extra_array);
				die;			
			}
			else{
				echo $this->form_validation->get_json();
				die;
			}
		}
		else{
			$this->data=array();
			$this->data['title_of_layout']=$this->site_name." - Sms Notification Settings";
			$this->data['notification_data']=$this->settings_model->sms_notification($this->session->userdata('user_id'));
			$this->breadcrumbs->push($this->site_name,base_url());		
			$this->breadcrumbs->push('Sms Notification Settings',base_url());
			$this->data['main_content']=$this->load->view('settings/notification_settings', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
		
	}
}