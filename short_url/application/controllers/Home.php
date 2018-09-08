<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	#Construct Function
	public function __construct() {
        parent::__construct();
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
	}
	 
	 
	public function index()
	{
		$this->load->view('home');
	}
	
	public function longurlConvert($slug=null){
		
		if(empty($slug)){
			redirect(base_url());
		}
		
		################ Check Short Code and Details ############
		$this->load->model('shorten_url_model');
		$this->data['details']=$this->shorten_url_model->get_long_url_details($slug);
		
		if(empty($this->data['details'])){
			redirect(base_url());
		}
		################## Track Visit Url #######################
		$this->shorten_url_model->trackVisitCount($this->data['details']['id']);
		$this->load->view('goto_longurl', $this->data);
	}
}
