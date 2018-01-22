<?php
class Plan_orders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('plan_orders_model');
		$this->load->helper('ckeditor_helper');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
	}

	########### Plan Clicks ###############
    public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		
		$this->load->helper('date_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'plans.name','created' =>'plan_order.created','price' =>'plan_order.amount','contact_number' =>'plan_order.buyer_phone','customer_name' =>'user_profiles.first_name','email' =>'plan_order.buyer_email','status' =>'plan_order.status');
		$config['base_url'] = base_url().ADMIN.'/plan_orders/index';
		$data['indextitle']  = 'Plan Order List';
		$data['type'] = 'index';
		
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$config['first_url'] = $config['base_url'].'/1/'.$sortfield.'/'.$order;

		 //search 
		 $data['keyword'] = '';
		 $data['keyword'] = $this->input->post('keyword');
		 $data['search_submit'] =$this->input->post('search_submit');
		
		/*********** pagination search ********************/
		$search_session  = array('search'=>array('type'=>$type, 'keyword'=>$data['keyword']));
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
			$value = '( user_profiles.first_name Like "%'.$data['keyword'].'%" )'; 
			$conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
					
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['pages'] = $this->plan_orders_model->get_plan_orders( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);   
		$config['total_rows'] =$this->plan_orders_model->get_plan_orders( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/plan_orders/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		
		$data['main_content'] = 'admin/plan_orders/index';
		$data['title']="Plan Clicks";
		$this->load->view('includes/template', $data);
    }
}
?>