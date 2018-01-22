<?php
class Jobs extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('jobs_model');
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');	
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	
	########## Front Index Page ###########
	public function index(){
		$data=array();
		$config=array();
		$this->load->library('pagination');
		
		#Query String
		$category_name=(isset($_GET['category']))?ucwords(str_replace('-',' ',$_GET['category'])):'';
		
		#Query String
		$city=(isset($_GET['city']) && $_GET['city']!='0')?$_GET['city']:'';
		$area=(isset($_GET['area']) && $_GET['area']!='0')?$_GET['area']:'';
		$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';		
		$query_string='?city='.$city.'&area='.$area.'&keyword='.$keyword.'&category='.$category_name;
		
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push('Jobs', base_url().'job');
		
		#Pagination Settings
		$config['suffix'] = $query_string;
		$config['base_url'] = base_url().'job/index';
		$config['first_url'] = base_url().'job/index'.$query_string;
		$config['per_page'] = '10';
		$config['num_links'] = '1';
		$config["uri_segment"] = 3;
		$config["full_tag_open"] = '<div class="page-nav td-pb-padding-side">';
		$config["full_tag_close"] = '</div>';
		$config["cur_tag_open"] = '<span class="current">';
		$config["cur_tag_close"] = '</span>';
		$page = ($this->uri->segment(3)) ? 1 : 0;
		
		#Get Jobs List
		$data["list"] = $this->jobs_model->get_job_list('all',$config['per_page'], $page, $city, $area, $keyword, $category_name);
		$config['total_rows'] = $data["list"]['all_total_rows'];
		$this->pagination->initialize($config);
		$data["pagination_link"]= $this->pagination->create_links();
		
		$data['main_content']=$this->load->view('jobs/list', $data,true);
		$this->load->view('layouts/default',$data);
	}

	############ Front Home Page #############
	public function view($id) {
	    $getValues = $this->jobs_model->get_active_job_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)==0) {
			redirect(base_url().'jobs/index');
		}
		$data['related_jobs']= $this->jobs_model->get_related_job_detail($id);
		$this->load->helper('thumb_helper');
		$this->breadcrumbs->push($this->site_name,base_url());
		$this->breadcrumbs->push($getValues['name'], base_url().'jobs_view/view');
		$data['result'] = $getValues;	
		$data['main_content'] = 'jobs/view';
		$data['title']=$getValues['name'];
		$data['job_id']=$id;
		$this->load->model('comment_model');
		$data['job_id']=$id;
		$data['title_of_layout']=$getValues['name'];
	    $data['title_of_description']=$getValues['short_description'];
		
		$data['main_content']=$this->load->view('jobs/view', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
	############### Admin Panel ##################### 
	public function admin_index($type = null, $page_num =1,$sortfield='id',$order='desc') 
	{
		if(!$this->session->userdata('is_logged_in')){
			
            redirect(ADMIN.'/login');
        }
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'jobs.title','created' =>'jobs.created','name' =>'jobs.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'jobs.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/jobs/active';
			$data['indextitle']  = 'jobs - Active List';
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'jobs.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/jobs/inactive';
			$data['indextitle']  = 'jobs - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/jobs/index';
			$data['indextitle']  = 'jobs List';
			$data['type'] = 'index';
		}
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
		$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(jobs.name LIKE '%" . $data['keyword'] . "%'", 'value'=> null);	
		 }
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['jobs'] = $this->jobs_model->get_jobs( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end,1);        
		$config['total_rows'] =$this->jobs_model->get_jobs( 0 , $conditions, '', '', '', '',1); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/jobs/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/jobs/index';
		$data['title']="jobs";
		$this->load->view('includes/template', $data);
	}

	public function add() 
	{
		$this->load->helper('ckeditor_helper');
		$this->breadcrumbs->push('jobs', base_url().ADMIN.'/jobs');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/jobs/add');
		$this->form_validation->set_rules('name', 'Title','trim|required');
		$this->form_validation->set_rules('description', 'Description','trim|required');
		$this->form_validation->set_rules('short_description', 'Short Description','trim|required');
		$this->form_validation->set_rules('qualification', 'Qualification','trim|required');
		$this->form_validation->set_rules('no_of_vacancy', 'No Of Vacancy','trim|required');	
		$this->form_validation->set_rules('pay_scale', 'Pay Scale','trim|required');	
		$this->form_validation->set_rules('age_limit', 'Age Limit','trim|required');
		$this->form_validation->set_rules('selection_process', 'Selection Process','trim|required');
		$this->form_validation->set_rules('skills', 'Skills','trim|required');
		$this->form_validation->set_rules('city', 'City','trim|required');
		$this->form_validation->set_rules('area', 'Area','trim|required');
		$this->form_validation->set_rules('meta_keywords', 'Meta keywords','trim|required');
		$this->form_validation->set_rules('meta_description', 'Meta Description','trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name','trim|required');
		if ($this->form_validation->run() == true) 
		{
			$config['upload_path']   =  $this->config->item('job_icon_url');
            $config['allowed_types'] =   "gif|jpg|jpeg|png";		 
	    	$this->load->library( 'upload' ,  $config);
			$this->upload->initialize($config);
			$image_up = $this->upload->do_upload('image');
	        $image_data =  array('upload_data' => $this->upload->data());
			$success = $this->jobs_model->add_new($image_data);
			if($success==true) {
				$this->session->set_flashdata('flash_message', $this->lang->line('record_add'));
			} else {
				$this->session->set_flashdata('flash_message', "error");
			}
			redirect(base_url().ADMIN.'/jobs'); 
		} 
		else 
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['main_content'] = 'admin/jobs/add';
			$this->data['title']="Add Job";
			$this->load->view('includes/template', $this->data);
		}
    } 
	
	
	function update_status($id, $status, $pageredirect=null,$pageno)
	{ 
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($status == 'enable')
		{
			$data = array('is_active' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		} 
		else if($status == 'disable')
		{
			$data = array('is_active' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		} 
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->jobs_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function bulkautions($pageredirect=null,$pageno)
	{
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->jobs_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled'));
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->jobs_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
		
	public function admin_view($id)
	{
	    $getValues = $this->jobs_model->get_job_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('jobs', base_url().ADMIN.'/jobs');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/jobs_view/view');
			$this->data['jobs'] = $getValues;	
			$this->data['main_content'] = 'admin/jobs/view';
			$this->data['title']="View job Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	function delete($id)
	{
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->jobs_model->delete($id)) 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	

	public function edit($id) 
	{
		$this->load->helper('ckeditor_helper');
		$getValues = $this->jobs_model->get_values($id);
		//pr($getValues);die;
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) 
		{
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Advertisments', base_url().ADMIN.'/Jobs');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/Jobs/edit');
			if (isset($_POST) && !empty($_POST))
			{
				$this->form_validation->set_rules('name', 'Title','trim|required');
				$this->form_validation->set_rules('company_name', 'Company Name','trim|required');
				$this->form_validation->set_rules('description', 'Description','trim|required');
				$this->form_validation->set_rules('short_description', 'Short Description','trim|required');
				$this->form_validation->set_rules('qualification', 'Qualification','trim|required');
				$this->form_validation->set_rules('no_of_vacancy', 'No Of Vacancy','trim|required');	
				$this->form_validation->set_rules('pay_scale', 'Pay Scale','trim|required');	
				$this->form_validation->set_rules('skills', 'Skills','trim|required');	
				$this->form_validation->set_rules('age_limit', 'Age Limit','trim|required');
				$this->form_validation->set_rules('city', 'City','trim|required');
				$this->form_validation->set_rules('area', 'Area','trim|required');
				if ($this->form_validation->run() === true)
				{	
			        $image_data=array();
					if(!empty($_FILES['image']['name']))
					{
						$config['upload_path']   =  $this->config->item('job_icon_url');
						$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
						$this->load->library( 'upload' ,  $config);
						$this->upload->initialize($config);
						$image_up = $this->upload->do_upload('image');
						$image_data =  array('upload_data' => $this->upload->data());
					}
					$this->jobs_model->edit($id,$image_data);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}				
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['jobs'] = $getValues;
			$this->data['is_active']=$getValues['is_active'] ? 1 : 0 ; 
			$this->data['main_content'] = 'admin/jobs/edit';
			$this->data['title']="Edit Advertisments";
			$this->load->view('includes/template', $this->data);
		}
		else
		{	
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/jobs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}

    }
	
}?>