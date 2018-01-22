<?php

class Remainders extends CI_Controller {

    public function __construct(){ 
        parent::__construct();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->myUserId=$this->session->userdata('user_id');
		$this->load->model('remainder_model');
    }
	
	##### Customer Mobile Number Search #####
	public function search_customers_remainders() {
		$search_text=(isset($_GET['search'])) ? $_GET['search']:'';
		$data=$this->remainder_model->customer_remainder_data($search_text,$this->session->userdata('user_id'));
		echo json_encode($data);
		die;
	}
	
   ######## Remainder List ########
	public function remainder_list() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push("Remainder List",base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - Remainder List";
		$this->data['label']="Remainder List";
		if ($this->input->is_ajax_request()) {
			$page_num=$this->uri->segment(3);
			$cofig =array();
			$config = admin_settings_initialize('settings');
			$this->pagination->cur_page = $this->uri->segment(3);
			$order_list=array();
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'remainders/remainder_list';
			$config['first_url'] = base_url().'remainders/remainder_list';
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
			$order_list=$this->remainder_model->getMyRemainderList($this->session->userdata('user_id'),$limit_start,$limit_end);	
			$this->data['order_list']=$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('remainders/remainder_list_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
		else {
			$this->data['main_content']=$this->load->view('remainders/remainder_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}		
	}
	
	############ Add Remainder ##########
	public function add(){
		$this->data=array();
		$this->data['type']=$this->uri->segment('2');
		$this->load->model('campaign_model');
		$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
		$this->data['total_sms']=$this->data['user_info']['total_sms'];
		$this->data['my_sendeids']=$this->campaign_model->my_sendIds($this->session->userdata('user_id'));	
		if($_POST) {
			$this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('message','Message','trim|required');
			$this->form_validation->set_rules('url','Url','trim|url');
			$this->form_validation->set_rules('remainder_period_type','Type','trim|required');
			$this->form_validation->set_rules('remainder_type_id','Type','trim|required');
			if($this->input->post('remainder_period_type')!=3){
				$this->form_validation->set_rules('no_of_days','No Of Days','trim|required');
			}
			if($this->input->post('filter_type_code')==2){
				
				$this->form_validation->set_rules('coupon_code','Coupon Code','trim|required');
			}
			$filter_type=$this->input->post('filter_type');
			$noOfMessage=ceil(strlen($this->input->post('message'))/160);
			if($this->form_validation->run() == true)  {
				$datas=$this->remainder_model->saveRemainders($this->session->userdata('user_id'));				
				if($datas['status']==1)  {
					$extra_array = array('status'=>'success','msg'=>'Remainder Added Successfully');
					$this->session->set_flashdata('success','Remainder Added Successfully');
					echo json_encode($extra_array);
					die;					
				}				
			} 
			else {
				echo $this->form_validation->get_json();
				die;
			}
		}
		$this->data['main_content']=$this->load->view('remainders/add_remainder', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
    }
	
	############ Add Remainder ##########
	public function edit($id){
		$this->data=array();
		$this->data['type']=$this->uri->segment('3');
		$this->data['edit_id']=$id;
		$this->load->model('campaign_model');
		$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
		$this->data['total_sms']=$this->data['user_info']['total_sms'];
		if($_POST) {
			$this->form_validation->set_rules('name','Name','trim|required');
			$this->form_validation->set_rules('message','Message','trim|required');
			$this->form_validation->set_rules('url','Url','trim|required');
			$this->form_validation->set_rules('remainder_period_type','Type','trim|required');
			$this->form_validation->set_rules('remainder_type_id','Type','trim|required');
			if($this->input->post('remainder_period_type')!=3){
				$this->form_validation->set_rules('no_of_days','No Of Days','trim|required');
			}
			if($this->input->post('filter_type_code')==2){
				
				$this->form_validation->set_rules('coupon_code','Coupon Code','trim|required');
			}
			$filter_type=$this->input->post('filter_type');
			$noOfMessage=ceil(strlen($this->input->post('message'))/160);
			if($this->form_validation->run() == true)  {
				$datas=$this->remainder_model->saveRemainders($this->session->userdata('user_id'),$id);				
				if($datas['status']==1)  {
					$extra_array = array('status'=>'success','msg'=>'Remainder Updated Successfully');
					$this->session->set_flashdata('success','Remainder Updated Successfully');
					echo json_encode($extra_array);
					die;					
				}				
			} 
			else {
				echo $this->form_validation->get_json();
				die;
			}
		}
		$this->data['edit_info']=$this->remainder_model->getRemainderData($id,$this->session->userdata('user_id'));
		if(!isset($this->data['edit_info']['id'])){
			redirect('dashboard');
		}
		$this->data['main_content']=$this->load->view('remainders/edit_remainder', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
    }
	
	############ Campaign History ##########
	public function history() {
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Campaign History',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Remainder History';
		if ($this->input->is_ajax_request()) {
			$page_num=$this->uri->segment(3);
			$cofig =array();
			$config = admin_settings_initialize('settings');
			$this->pagination->cur_page = $this->uri->segment(3);
			$order_list=array();
			if(empty($page_num)) $page_num = 1;
			$limit_end = ($page_num-1) * $config['per_page'];
			$limit_start = $config['per_page'];
			$this->pagination->cur_page = $page_num;
			$config['base_url'] = base_url().'remainders/history';
			$config['first_url'] = base_url().'remainders/history';
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
			$order_list=$this->remainder_model->getHistroyData($this->session->userdata('user_id'),$limit_start,$limit_end);	
			$this->data['order_list']=$order_list['data'];	
			$config['total_rows']=$order_list['TotalRecords'];
			$this->pagination->initialize($config);
			$this->data["pagination_link"]= $this->pagination->create_links();
			$this->data['main_content']=$this->load->view('remainders/remainder_histroy_json', $this->data,true);
			echo json_encode($this->data);
			die;
		}
		else {
			$this->data['main_content']=$this->load->view('remainders/histroy', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}		
	}
}
?>