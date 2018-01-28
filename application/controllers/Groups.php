<?php
class Groups extends CI_Controller {

    ######### Advertisments Model ##########
    public function __construct() {
      parent::__construct();
		$this->load->model('groups_model');
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->myUserId=$this->session->userdata('user_id');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	
	######## Edit Groups #########
	public function edit_group($id){
		
		
		$data=array();
		$data['groups_info']=$this->groups_model->getValues($id,$this->session->userdata('user_id'));
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push('Dialbe',base_url());		
		$this->breadcrumbs->push('Edit Group',base_url());
		#Set Meta Title And Keyword
		$data['title_of_layout']=$this->site_name." - ".'Edit Group';	
		if($_POST) 
		{
		
				$this->form_validation->set_rules('name','Name','trim|required');
				if($this->form_validation->run() == true) 
				{
					
					$success=$this->groups_model->updateGroup($id,$this->session->userdata('user_id'));				
					if($success) 
					{
						
                        $extra_array = array('status'=>'success','msg'=>'Group Updated Successfully');
						echo json_encode($extra_array);
						die;					
					}				
				} 
				else 
				{
					echo $this->form_validation->get_json();
					die;
				}
		}
		else {
			$data['main_content']=$this->load->view('groups/edit_group', $data,true);
			$this->load->view('layouts/customer', $data);	
		}
	}
    
	######## Add Groups #########
	public function add_group(){
		
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push('Dialbe',base_url());		
		$this->breadcrumbs->push('Add Group',base_url());
		#Set Meta Title And Keyword
		$data['title_of_layout']=$this->site_name." - ".'Add Group';	
		if($_POST) 
		{
				$this->form_validation->set_rules('name','Name','trim|required');
				if($this->form_validation->run() == true) 
				{
					$success=$this->groups_model->saveGroup($this->session->userdata('user_id'));				
					if($success) 
					{
                        $extra_array = array('status'=>'success','msg'=>'Group add Successfully');
						echo json_encode($extra_array);
						die;					
					}				
				} 
				else 
				{
					echo $this->form_validation->get_json();
					die;
				}
		}
		$data['main_content']=$this->load->view('groups/add_group', $data,true);
		$this->load->view('layouts/customer', $data);	
	}
	
	##### Group List #############
	public function group_list(){	
	
	
	
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('My Groups',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Business Group List';
		if ($this->input->is_ajax_request()) {
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'groups/group_list';
		$config['first_url'] = base_url().'groups/group_list';
		$config['per_page'] = 5;
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
		$order_list=$this->groups_model->getMyGroupList($this->myUserId,$limit_start,$limit_end);		
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('groups/bussiness_groups_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('groups/bussiness_groups_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
}