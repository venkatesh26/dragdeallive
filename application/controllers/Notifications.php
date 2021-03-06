<?php
class Notifications extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('notification_model');
		$this->load->library('breadcrumbs');
				$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	
	public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'user_profiles.first_name','created' =>'advertisment_comments.created','email' =>'users.email','title' =>'advertisment_comments.title','rating'=>'advertisment_comments.rating','hotel_name' =>'advertisements.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'advertisment_comments.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/comments/active';
			$data['indextitle']  = 'Comments - Active List';
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'advertisment_comments.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/comments/inactive';
			$data['indextitle']  = 'Comments - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/comments/index';
			$data['indextitle']  = 'Comments List';
			$data['type'] = 'index';
		}
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->suffix = '/'.$sortfield.'/'.$order;
		$this->pagination->first_url = $config['base_url'].'/1/'.$sortfield.'/'.$order;

		 //search 
		 $data['keyword'] = '';
		 $data['keyword'] = $this->input->post('keyword');
		 $data['search_submit'] =$this->input->post('search_submit');
		
		/*********** pagination search ********************/
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword'] ));
		if($data['keyword']){ 
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
		}
		else
		{ 
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['search_submit'] && $sortfield != 'reset'){
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
				}else
				{
					$type = '';
				}
				$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/

		 if($data['keyword']  )
		 {
		$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(advertisment_comments.title LIKE '%" . $data['keyword'] . "%'", 'value'=> null);
		$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "advertisements.name LIKE '%" . $data['keyword'] . "%'", 'value' => null);
		$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "user_profiles.first_name LIKE '%" . $data['keyword'] . "%'", 'value' => null);
        $conditions[] = array( 'direct'=>0,  'rule' => 'or_where', 'field' => "users.email like '%" . $data['keyword'] . "%')", 'value'=> null); 	
		 }
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['comments'] = $this->comment_model->get_comments( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);        
		$config['total_rows'] =$this->comment_model->get_comments( 0 , $conditions, '', '', '', ''); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/comments/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/comments/index';
		$data['title']="Comments";
		$this->load->view('includes/template', $data);
	}
	
	public function  view($id)
	{
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
	    $getValues = $this->comment_model->get_comment_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			// add breadcrumbs
			$this->breadcrumbs->push('Comments', base_url().ADMIN.'/report_abuse');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/comment_view/view');
			$this->data['comments'] = $getValues;	
			$this->data['main_content'] = 'admin/comments/view';
			$this->data['title']="View Comment Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/comments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	function delete($id)
	{
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->comment_model->delete($id)) 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/comments/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	##### Group List #############
	public function my_notifications() {
		
		$this->site_name=admin_settings_initialize('sitename');
		$this->myUserId=$this->session->userdata('user_id');
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('My Notifications',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Notifications';
		if ($this->input->is_ajax_request()) {
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'notifications/my_notifications';
		$config['first_url'] = base_url().'notifications/my_notifications';
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
		$order_list=$this->notification_model->getMyNotificationList($this->myUserId,$limit_start,$limit_end);		
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('notifications/notification_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('notifications/notification_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	} 
}