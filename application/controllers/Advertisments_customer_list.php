<?php
class Advertisments_customer_list extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('advertisment_customer_list_model');
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');	
		$this->site_name=admin_settings_initialize('sitename');
    }
	
	############### Admin Panel ##################### 
	public function admin_index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'advertisment_customer_lists.name','created' =>'advertisment_customer_lists.created');
		$config['base_url'] = base_url().ADMIN.'/advertisment_customer_list/admin_index';
		$data['indextitle']  = 'Advertisments Customer List';
		$data['type'] = 'index';
		
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$limit_start = $config['per_page'];
		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$config['first_url'] = $config['base_url'].'/1/'.$sortfield.'/'.$order;

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
			$type = '';
			 if(isset($this->session->userdata['search']['type']) && $this->session->userdata['search']['type'] == $type && !$data['search_submit'] && $sortfield != 'reset'){
					$data['keyword'] = $this->session->userdata['search']['keyword']; 
			}
			$search_session  =  array('search'=>array('type'=>$type,'keyword'=>$data['keyword']));
		}
		$this->session->set_userdata($search_session);
		/**************** End pagination search ***********/

		 if($data['keyword']  )
		 {
			$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(advertisment_customer_lists.name LIKE '%" . $data['keyword'] . "%'", 'value'=> null);
			$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "advertisment_customer_lists.title LIKE '%" . $data['keyword'] . "%'", 'value' => null);
			$conditions[] = array( 'direct'=>0,  'rule' => 'or_where', 'field' => "advertisment_customer_lists.email like '%" . $data['keyword'] . "%')", 'value'=> null); 	
		 }
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['enquiry_list'] = $this->advertisment_customer_list_model->advertisment_customer_lists( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end,1);  		
		$config['total_rows'] =$this->advertisment_customer_list_model->advertisment_customer_lists( 0 , $conditions, '', '', '', '',1); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/advertisment_enquiry/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/advertisment_customer_list/index';
		$data['title']="Advertisment Customer List";
		$this->load->view('includes/template', $data);
	}
	
	############# Admin View #########
	public function view($id) {
	    $getValues = $this->advertisment_customer_list_model->get_enquiry_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)==0) {
			redirect(base_url().'advertisment_customer_list/index');
		}
		$this->load->helper('thumb_helper');
		$this->breadcrumbs->push($this->site_name,base_url().ADMIN);
		$this->breadcrumbs->push('Advertisment Enquiry', base_url().ADMIN.'/advertisment_customer_list');
		$this->breadcrumbs->push($getValues['name'], base_url().'advertisment_customer_list/view');
		$data['result'] = $getValues;
		$data['title']=$getValues['name'];	
		$data['main_content'] = 'admin/advertisment_customer_list/view';
		$data['title']="Advertisment Customer";
		$this->load->view('includes/template', $data);
	}
	
	######### Admin Delete ###########
	function delete($id) {
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$data = array('is_deleted' => '1');
		if($this->advertisment_customer_list_model->delete($id,$data)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/advertisment_customer_list/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}