<?php

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('home_model');
		$this->load->model('campaign_model');
		$this->load->model('remainder_model');
		
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->myUserId=$this->session->userdata('user_id');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	
	####### My Campaign Track List ###################
	public function my_campaign_tracklist() {
		
		if ($this->input->is_ajax_request()) {
			$order_list=array();
			$page_num=$this->uri->segment(3);
			
			$cofig =array();
			$config = admin_settings_initialize('settings');
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'reports/my_campaign_tracklist';
			$config['first_url'] = base_url().'reports/my_campaign_tracklist';
			$config['per_page'] = $config['per_page'];
			$config['num_links'] = 3;
			
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$from_date='';
			$to_date='';
			$order_list=$this->campaign_model->getCampaignTrackList($this->myUserId,$limit_start,$limit_end,$from_date,$to_date);	
			$this->data['order_list']=	$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('reports/campaign_tracklist_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
	}
	
	################### Campaign Stastics #################
	public function remainder_stastics() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Campaign Stastics',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Remainder Campaign Stastics';
		$this->data['main_content']=$this->load->view('reports/remainder_campaign', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	################### Campaign Stastics Data #################
	public function my_remainder_campaign_data() {
		
		if ($this->input->is_ajax_request()) {
			$order_list=array();
			$page_num=$this->uri->segment(3);
			
			$cofig =array();
			$config = admin_settings_initialize('settings');
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'reports/my_remainder_campaign_data';
			$config['first_url'] = base_url().'reports/my_remainder_campaign_data';
			$config['per_page'] = $config['per_page'];
			$config['num_links'] = 3;
			
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$from_date='';
			$to_date='';
			$this->MyaddId=get_my_addId($this->myUserId);
			$order_list=$this->remainder_model->getStatisticsData($this->myUserId,$limit_start,$limit_end,$from_date,$to_date);	
			$this->data['order_list']=	$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('reports/remainder_campaign_data_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
	}
	
	################### Campaign Stastics #################
	public function campaign_stastics() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Campaign Stastics',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Campaign Stastics';
		$this->data['main_content']=$this->load->view('reports/sms_campaign', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	################### Campaign Stastics Data #################
	public function my_campaign_data(){
		
		if ($this->input->is_ajax_request()) {
			$order_list=array();
			$page_num=$this->uri->segment(3);
			
			$cofig =array();
			$config = admin_settings_initialize('settings');
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'reports/my_campaign_data';
			$config['first_url'] = base_url().'reports/my_campaign_data';
			$config['per_page'] = $config['per_page'];
			$config['num_links'] = 3;
			
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$from_date='';
			$to_date='';
			$this->MyaddId=get_my_addId($this->myUserId);
			$order_list=$this->campaign_model->getStatisticsData($this->myUserId,$limit_start,$limit_end,$from_date,$to_date);	
			$this->data['order_list']=	$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('reports/my_campaign_data_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
	}
	
	
	
	
	################### My Stastics #################
	public function my_stastics() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Business Stastics',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Stastics';
		$this->data['main_content']=$this->load->view('reports/my_stastics', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	public function my_stastics_data() {
		
		if ($this->input->is_ajax_request()) {
			$order_list=array();
			$page_num=$this->uri->segment(3);
			
			$cofig =array();
			$config = admin_settings_initialize('settings');
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'reports/my_stastics_data';
			$config['first_url'] = base_url().'reports/my_stastics_data';
			$config['per_page'] = $config['per_page'];
			$config['num_links'] = 3;
			
			$config["uri_segment"] = ($this->uri->segment(1)!='search') ? 3: 2;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["use_page_numbers"] = TRUE;
			$config["first_tag_open"] = "<li class='page-item'>";
			$config["first_tag_close"] = "</li>";
			$config["next_tag_open"] = "<li class='page-item'>";
			$config["next_tag_close"] = "</li>";
			$config["prev_tag_open"] = "<li class='page-item'>";
			$config["prev_tag_close"] = "</li>";
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config["cur_tag_open"] = '<li class="page-item active"><a class="page-link">';
			$config["cur_tag_close"] = '</li></a>';
			$config["last_tag_open"] = "<li class='page-item'>";
			$config["last_tag_close"] = "</li>";
			$from_date='';
			$to_date='';
			$this->MyaddId=get_my_addId($this->myUserId);
			$order_list=$this->advertisment_model->getStatisticsData($this->MyaddId,$limit_start,$limit_end,$from_date,$to_date);	
			$this->data['order_list']=	$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('reports/my_stastics_data_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
	}
}