<?php
class Pages extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('pages_model');
		$this->load->helper('ckeditor_helper');
        if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$this->load->library('breadcrumbs');
        $path = '';//'/js/ckfinder';
 //   $width = '850px';
  //  $this->editor($path, $width);
	
	}

    public function index($type = null, $page_num =1,$sortfield='id',$order='desc') {
		$this->load->helper('date_helper');
		$conditions = array();
		$search_session = array();
		//pagination settings
		$cofig =array();
		$config = admin_settings_initialize('settings');
		//block_user_list
		//sortings
		$this->sorting = array('name' =>'pages.title','created' =>'pages.created');
		//$conditions[] = array( 'direct'=>0, 'rule' => 'where', 'field'=>'pages.is_active', 'value' => 1 );	
		$config['base_url'] = base_url().'/admin/pages/index';
		$data['indextitle']  = 'Pages List';
		$data['type'] = 'index';
		
		/*****pagination ********/ 
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$config['suffix'] = '/'.$sortfield.'/'.$order;
		$this->pagination->cur_page = $page_num;
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
			$value = '( pages.title Like "%'.$data['keyword'].'%" )'; 
			 $conditions[] = array( 'direct'=>1,  'rule' => 'where', 'value'=> $value  );	
		 }
					
		$data['user_login_types'] = $this->config->item('user_login_type_names');
		//fetch sql data into arrays 

		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['pages'] = $this->pages_model->get_pages( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);   
		$config['total_rows'] =$this->pages_model->get_pages( 0 , $conditions, '', '', '', '');   

		if($config['total_rows'] <= $limit_end )
			if($page_num && $page_num != 1) 
				redirect(ADMIN.'/pages/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		
		//$this->pagination->cur_page = $limit_end;
		//initializate the panination helper 
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		
		$data['main_content'] = 'admin/pages/index';
		$data['title']="Pages";
		$this->load->view('includes/template', $data);
    }

    public function add() {
		// add breadcrumbs
		$this->breadcrumbs->push('Pages', base_url().ADMIN.'/pages');
		$this->breadcrumbs->push('Add', base_url().ADMIN.'/pages/add');
		
		$this->form_validation->set_rules('name', 'Name','trim|required|is_unique[pages.name]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
		if ($this->form_validation->run() == true) {
		
			$success = $this->pages_model->add_new();
			if($success==true) {
				$this->session->set_flashdata('flash_message', $this->lang->line('record_add'));
			} else {
				$this->session->set_flashdata('flash_message', "error");
			}
			redirect(base_url().ADMIN.'/pages'); 
			
		} else {
		$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		$this->data['main_content'] = 'admin/pages/add';
		$this->data['title']="Add Pages";
		$this->load->view('includes/template', $this->data);
		}
		
    } 

    public function edit($id) {
		$getValues = $this->pages_model->get_values($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
		$this->load->helper('ckeditor');
		//Ckeditor's configuration
		$this->data['ckeditor'] = array(
			//ID of the textarea that will be replaced
			'id' 	=> 	'content',
			'path'	=>	'/assets/js/admin/ckeditor',
 
			//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"600px",	//Setting a custom width
				'height' 	=> 	'300px',	//Setting a custom height
 
			),
			//Replacing styles from the "Styles tool"
			'styles' => array(
				//Creating a new style named "style 1"
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 	=> 	'Blue',
						'font-weight' 	=> 	'bold'
					)
				),
				//Creating a new style named "style 2"
				'style 2' => array (
					'name' 	=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)				
			)
		); //print_r($this->data['ckeditor']);die;
		
			// add breadcrumbs
			$this->breadcrumbs->push('Pages', base_url().ADMIN.'/pages');
			$this->breadcrumbs->push('Edit', base_url().ADMIN.'/pages/edit');
			if($this->input->post('title') != $getValues['title']) {
				$is_unique =  '|is_unique[pages.title]' ;
			} else {
				$is_unique =  '' ;
			}
			$this->form_validation->set_rules('title', 'Name','trim|required'.$is_unique);
			$this->form_validation->set_rules('content', 'Content','trim|required');
			if (isset($_POST) && !empty($_POST))
			{		
				if ($this->form_validation->run() === true)
				{
					$this->pages_model->edit($id);
					$this->session->set_flashdata('flash_message', $this->lang->line('record_update'));
					redirect(base_url().ADMIN.'/pages/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
				}			
			}
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			$this->data['pages'] = $getValues;
			//print_r($this->data);die;
			//display the edit pages form
			$this->data['is_active']=$getValues['is_active'] ? 1 : 0 ; 
			//echo $this->data['is_active'];die;
			$this->data['main_content'] = 'admin/pages/edit';
			$this->data['title']="Edit Pages";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/pages/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}

    }
	
	function update_status($id, $status ){ 
					
		if($status == 'enable'){
			$data = array('is_active' => '1');
			$this->session->set_flashdata('flash_message', $this->lang->line('enabled') );
		}
		else{
			$data = array('is_active' => '0');
			$this->session->set_flashdata('flash_message', $this->lang->line('disabled') );
		}
		$this->pages_model->update_status($id, $data);
		if($status == 'enable'){
			redirect(base_url().ADMIN.'/pages/inactive');
		} else {
			redirect(base_url().ADMIN.'/pages/active');
		}
		
		
	}
	 function editor($path,$width) {
    //Loading Library For Ckeditor
    //$this->load->library('ckeditor');
    $this->load->library('ckFinder');
    //configure base path of ckeditor folder 
  //  $this->ckeditor->basePath = base_url().'assets/js/ckeditor/';
    $this->ckeditor-> config['toolbar'] = 'Full';
    $this->ckeditor->config['language'] = 'en';
    $this->ckeditor-> config['width'] = $width;
    //configure ckfinder with ckeditor config 
    $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
  }
}
?>