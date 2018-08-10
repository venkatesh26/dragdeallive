<?php
class Advertisments_customer_bills extends CI_Controller {

    ######### Advertisments  Customer Bills ##########
    public function __construct() {
        parent::__construct();
		$this->load->model('Advertisment_customers_bills_model');
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
	
	
	#################### Customer Order Detail #############
	public function view($id){
		
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Order Detail',base_url());
		$this->data['order_detail']=$this->Advertisment_customers_bills_model->order_detail($id, $this->session->userdata('user_id'));		
		$this->data['main_content']=$this->load->view('advertisments_customer_bills/order_detail', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	
	################### Products List ######
	public function index(){
		
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Customer Orders',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Customer Orders';
		if ($this->input->is_ajax_request()) {
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = 10;$config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'advertisments_customer_bills/index';
		$config['first_url'] = base_url().'advertisments_customer_bills/index';
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
		$order_list=$this->Advertisment_customers_bills_model->getOrderList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('advertisments_customer_bills/order_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('advertisments_customer_bills/order_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
		
	}
}