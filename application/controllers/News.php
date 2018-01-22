<?php
class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('blog_model');
		$this->load->model('blog_category_model');
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
    }
	
	############## Front End index ##############
	public function index() {
	    $data=array();
		$config=array();
	
		$this->load->library('pagination');
		$this->load->helper('thumb');
		
		#Query String
		$category_name=(isset($_GET['category']))?ucwords(str_replace('-',' ',$_GET['category'])):'';
		if($this->uri->segment('1')=='news-category-search' && $this->uri->segment('2')!='')
		{
			$category_name=$this->uri->segment('2');	
		}
		$query_string='?category='.$category_name;
		
		#Pagination Settings
		$config['suffix'] = $query_string;
		$config['base_url'] = base_url().'news/index';
		$config['first_url'] = base_url().'news/index'.$query_string;
		$config['per_page'] = '5';
		$config['num_links'] = '3';
		$config["uri_segment"] = 3;
		$config["full_tag_open"] = '<div class="page-nav td-pb-padding-side">';
		$config["full_tag_close"] = '</div>';
		$config["cur_tag_open"] = '<span class="current">';
		$config["cur_tag_close"] = '</span>';
		$page = ($this->uri->segment(3) && $this->uri->segment(1)!='search') ? 1 : 0;
		
		#Get Blogs List
		$data["list"] = $this->blog_model->get_blog_list('all',$config['per_page'], $page,$category_name,'2');
		$config['total_rows'] = $data["list"]['all_total_rows'];
		$this->pagination->initialize($config);
		$data["pagination_link"]= $this->pagination->create_links();
		
		$data['category_list']=$this->blog_model->get_blog_list_category('2');
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push('Dialbe',base_url());
		$this->breadcrumbs->push("News",base_url().'/news');	
		$data['total_count']=$config['total_rows'];
		$data['search_header_title']="News";
		$data['main_content']=$this->load->view('news/list', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
	public function view($id) {
	    $getValues = $this->blog_model->get_blog_detail($id,'news');
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)==0) {
			redirect(base_url().'news/index');
		}
		$r_category_name=$getValues['cat_name'];
		$this->load->helper('thumb_helper');
		$this->breadcrumbs->push('Dialbe',base_url());
		$this->breadcrumbs->push('News', base_url().'news');
	    $this->breadcrumbs->push(ucfirst($r_category_name),base_url().'news-category-search/'.url_title(strtolower($r_category_name)));	
		$this->breadcrumbs->push($getValues['name'], base_url().'news/view');
		$data['result'] = $getValues;	
		$data['main_content'] = 'news/view';
		$data['title']=$getValues['name'];
		$data['blog_id']=$id;
		$this->load->model('comment_model');
		$data['user_comments']=$this->comment_model->get_blog_comment_list($id);
		$data['category_list']=$this->blog_model->get_blog_list_category('2');
		$data['blog_id']=$id;
		$data['title_of_layout']=$getValues['name'];
	    $data['title_of_description']=$getValues['short_description'];
		$data['main_content']=$this->load->view('news/view', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
	############### Admin Panel ##################### 
	public function admin_index($type = null, $page_num =1,$sortfield='id',$order='desc')  {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
	    $this->load->helper('date_helper');
		$this->load->helper('thumb_helper');
		$conditions = array();
		$search_session = array();
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->sorting = array('name' =>'blogs.title','created' =>'blogs.created','name' =>'blogs.name','owner_name' =>'blogs.owner','address'=>'address_line','city_name'=>'cities.name');
		if($type == 'active')
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'blogs.is_active', 'value' => 1 );	
			$config['base_url'] = base_url().ADMIN.'/blogs/active';
			$data['indextitle']  = 'Blogs - Active List';
			$data['type'] = 'active';
		} 
		else if($type == 'inactive') 
		{
			$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'blogs.is_active', 'value' => 0 );	
			$config['base_url'] = base_url().ADMIN.'/blogs/inactive';
			$data['indextitle']  = 'Blogs - Inactive List';
			$data['type'] = 'inactive';
		}
		else
		{
			$config['base_url'] = base_url().ADMIN.'/blogs/index';
			$data['indextitle']  = 'Blogs List';
			$data['type'] = 'index';
		}
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
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
			$conditions[] = array( 'direct'=>0,  'rule' => 'where', 'field' => "(blogs.name LIKE '%" . $data['keyword'] . "%'", 'value'=> null);
			$conditions[] = array('direct'=>0,  'rule' => 'or_where', 'field' => "blogs.owner LIKE '%" . $data['keyword'] . "%'", 'value' => null);
			$conditions[] = array( 'direct'=>0,  'rule' => 'or_where', 'field' => "blogs.email like '%" . $data['keyword'] . "%')", 'value'=> null); 	
		}
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['blogs'] = $this->blog_model->get_blogs( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end,2);        
		$config['total_rows'] =$this->blog_model->get_blogs( 0 , $conditions, '', '', '', '',2); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/blogs/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/blogs/index';
		$data['title']="Blogs";
		$this->load->view('includes/template', $data);
	}

	public function add() {
		$this->load->helper('ckeditor_helper');
		$this->breadcrumbs->push('Blogs', base_url().ADMIN.'/blogs');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/blogs/add');
		$this->form_validation->set_rules('name', 'Title','trim|required|is_unique[blogs.name]');
		$this->form_validation->set_rules('short_description', 'Short Description','trim|required');
		$this->form_validation->set_rules('description', 'Description','trim|required');
		$this->form_validation->set_rules('blog_category_id', 'Category','trim|required');
		$this->form_validation->set_rules('meta_keywords', 'Meta keywords','trim|required');
		$this->form_validation->set_rules('meta_description', 'Meta Description','trim|required');
		if ($this->form_validation->run() == true) 
		{
			$config['upload_path']   =  $this->config->item('blog_icon_url');
            $config['allowed_types'] =   "gif|jpg|jpeg|png";		 
	    	$this->load->library( 'upload' ,  $config);
			$this->upload->initialize($config);
			$image_up = $this->upload->do_upload('image');
	        $image_data =  array('upload_data' => $this->upload->data());
			$success = $this->blog_model->add_new($image_data);
			if($success==true) {
				$this->session->set_flashdata('flash_message', $this->lang->line('record_add'));
			} else {
				$this->session->set_flashdata('flash_message', "error");
			}
			redirect(base_url().ADMIN.'/blogs'); 
		} 
		else 
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['main_content'] = 'admin/blogs/add';
			$this->data['title']="Add Blog";
			$this->data['categories']=$this->blog_model->get_blog_category('2');
			$this->load->view('includes/template', $this->data);
		}
    } 
	
	
	function update_status($id, $status, $pageredirect=null,$pageno){ 
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
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->blog_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function bulkautions($pageredirect=null,$pageno){
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->blog_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled'));
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->blog_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
		
	public function admin_view($id){
	    $getValues = $this->blog_model->get_blog_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Blogs', base_url().ADMIN.'/blogs');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/blogs_view/view');
			$this->data['blogs'] = $getValues;	
			$this->data['main_content'] = 'admin/blogs/view';
			$this->data['title']="View Blog Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	function delete($id){
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->blog_model->delete($id)) 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	

	public function edit($id) {
		$this->load->helper('ckeditor_helper');
		$getValues = $this->blog_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) 
		{
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Advertisments', base_url().ADMIN.'/categories');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/categories/edit');
			if (isset($_POST) && !empty($_POST))
			{
				$this->form_validation->set_rules('name', 'Title','trim|required');
				$this->form_validation->set_rules('short_description', 'Short Description','trim|required');
				$this->form_validation->set_rules('description', 'Description','trim|required');
				$this->form_validation->set_rules('blog_category_id', 'Category','trim|required');
				$this->form_validation->set_rules('meta_keywords', 'Meta keywords','trim|required');
				$this->form_validation->set_rules('meta_description', 'Meta Description','trim|required');
				if ($this->form_validation->run() === true)
				{	
			        $image_data=array();
					if(!empty($_FILES['image']['name']))
					{
						$config['upload_path']   =  $this->config->item('blog_icon_url');
						$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
						$this->load->library( 'upload' ,  $config);
						$this->upload->initialize($config);
						$image_up = $this->upload->do_upload('image');
						$image_data =  array('upload_data' => $this->upload->data());
					}
					$this->blog_model->edit($id,$image_data);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}				
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['blogs'] = $getValues;
			$this->data['categories']=$this->blog_model->get_blog_category('2');
			$this->data['is_active']=$getValues['is_active'] ? 1 : 0 ; 
			$this->data['main_content'] = 'admin/blogs/edit';
			$this->data['title']="Edit Advertisments";
			$this->load->view('includes/template', $this->data);
		}
		else
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/blogs/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}

    }
	
}