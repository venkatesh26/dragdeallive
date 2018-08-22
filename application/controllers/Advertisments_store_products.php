<?php
class Advertisments_store_products extends CI_Controller {

    ######### Advertisments Model ##########
    public function __construct() {
        parent::__construct();
		$this->load->model('advertisment_store_products_model');
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
	
	############ Products Auto Complete ##########
	public function get_products_autocomplete(){
		
		$keyword=(isset($_GET['term']))?$_GET['term']:'';
		$type=(isset($_GET['type']))?$_GET['type']:'';
		$all_list=$this->advertisment_store_products_model->get_products_list($keyword,$this->session->userdata('user_id'), $type);
		echo json_encode($all_list);
		die;
	}
	
	########### Delete Products ###################
	public function deleteProducts(){
	
		$products_delete=array();
		if(isset($_POST['product_id']))
		{
			$products_delete=$this->advertisment_store_products_model->deleteProducts($_POST['product_id'], $this->session->userdata('user_id'));
		}
		echo json_encode($products_delete);
		die;
	}
	
	########### Import Products ###########
	public function import_products() {
		$data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Import Products',base_url());
		$data['title_of_layout']=$this->site_name." - ".'Import Products';
		#Set Meta Title And Keyword
		if(isset($_FILES['file_data'])) {			
		 if($_FILES['file_data']['name'] && $_FILES['file_data']['tmp_name'] && ($_FILES['file_data']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['file_data']['type']=='application/zip' || $_FILES['file_data']['type']=='application/octet-stream' )) 
		 {
				$file_name= $_FILES['file_data']['tmp_name'];		 
				require_once APPPATH . 'third_party/PHPExcel.php';
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($file_name);
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				$total_rows=$objPHPExcel->setActiveSheetIndex(0)->getHighestDataRow();
				$count=0;
				if($total_rows > 2) {
					$data_product=array();
					for($i=2; $i<=$total_rows; $i++)
					{
						if($objWorksheet->getCellByColumnAndRow(0,$i)->getValue()!='')
						{
							$count=$count+1;
							$data_product[$i]=array(
								'name' => ltrim($objWorksheet->getCellByColumnAndRow(0,$i)->getValue()),
								'price' => ltrim($objWorksheet->getCellByColumnAndRow(1,$i)->getValue())
							);
						}	
					}
					$this->advertisment_store_products_model->import_product_data($data_product,$this->session->userdata('user_id'));
					$data['status']="success";  
					$data['total_rows']=$total_rows;
					$data['inserted_datas']=$count;
					$data['msg']="<p>Product Data Imported Successfully</p>"; 
					echo json_encode($data);
					die;	
				}
				else {
					$extra_array = array('status'=>'error','msg'=>'Please add valid data');
					echo json_encode($extra_array);
					die;	
				}
		    }
			else{
				$extra_array = array('status'=>'error','msg'=>'Please upload a valid File');
				echo json_encode($extra_array);
				die;					
			}
		}
		else {
			$data['main_content']=$this->load->view('advertisments_store_products/import_product_data', $data,true);
			$this->load->view('layouts/customer', $data);	
		}
	}
	
	
	################### Products List ######
	public function index(){
		
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Products List',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Products List';
		if ($this->input->is_ajax_request()) {
		$order_list=array();
		$page_num=$this->uri->segment(3);
		
		$cofig =array();
		$config = admin_settings_initialize('settings');
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = 10;
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'advertisments_store_products/index';
		$config['first_url'] = base_url().'advertisments_store_products/index';
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
		$order_list=$this->advertisment_store_products_model->getProductList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=	$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('advertisments_store_products/products_list_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('advertisments_store_products/products_list', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}	
	}

    ########################### add Product ########
	public function add() {
		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->data['title_of_layout']=$this->site_name." - Add Product";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Add Product',base_url());
		if($_POST) 
		{
			$success=$this->advertisment_store_products_model->add_products($this->session->userdata('user_id'));
			if($success) {						
				$extra_array = array('status'=>'success','msg'=>'Product Add Successfully.');
				echo json_encode($extra_array);
				die;					
			}				
		}
		$this->data['main_content']=$this->load->view('advertisments_store_products/add', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
	
	
	########################### edit Product ########
	public function edit($id) {

		$this->data=array();
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}
		$this->data['title_of_layout']=$this->site_name." - Edit Product";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Edit Product',base_url());
		if($_POST) 
		{
			$success=$this->advertisment_store_products_model->update_products($this->session->userdata('user_id'), $id);
			if($success) {						
				$extra_array = array('status'=>'success','msg'=>'Product updated Successfully.');
				echo json_encode($extra_array);
				die;					
			}				
		}
		$this->data['data']=$this->advertisment_store_products_model->get_product($this->session->userdata('user_id'), $id);
		$this->data['main_content']=$this->load->view('advertisments_store_products/edit', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
}