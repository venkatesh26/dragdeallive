<?php
class Offers extends CI_Controller {

    public function __construct() {
		
        parent::__construct();
		$this->load->model('campaign_model');
		$this->load->library('breadcrumbs');
		$this->site_name=admin_settings_initialize('sitename');
		$this->load->library('Mobile_Detect'); ######## Agent Notifications ############
		$this->detect=new Mobile_Detect();
    }
	
	############## Front End index ##############
	public function index() { 
	    $data=array();
		$config=array();
	
		$this->load->library('pagination');
		$this->load->helper('thumb');
		
		#Query String
		$category_name=(isset($_GET['category']))?ucwords(str_replace('-',' ',$_GET['category'])):'';
		
		#Query String
		$city=(isset($_GET['coupon_city']) && $_GET['coupon_city']!='0')?$_GET['coupon_city']:'';
		$area=(isset($_GET['coupon_area']) && $_GET['coupon_area']!='0')?$_GET['coupon_area']:'';
		$keyword=(isset($_GET['keyword']))?$_GET['keyword']:'';		
		$query_string='?city='.$city.'&area='.$area.'&keyword='.$keyword.'&category='.$category_name;
		
		#Pagination Settings
		$config['suffix'] = $query_string;
		$config['base_url'] = base_url().'offers/index';
		$config['first_url'] = base_url().'offers/index'.$query_string;
		$config['per_page'] = 16;
		$config['num_links'] = '3';
		$config["uri_segment"] = 3;
		$config["full_tag_open"] = '<div class="page-nav td-pb-padding-side">';
		$config["full_tag_close"] = '</div>';
		$config["cur_tag_open"] = '<span class="current">';
		$config["cur_tag_close"] = '</span>';
		$page = ($this->uri->segment(3) && $this->uri->segment(1)!='search') ? 1 : 0;

		#Get Blogs List
		
		$data["list"] = $this->campaign_model->get_offer_list('all',16, $page,$city,$area,$keyword,$category_name);
		$config['total_rows'] = $data["list"]['all_total_rows'];
		$this->pagination->initialize($config);
		$data["pagination_link"]= $this->pagination->create_links();
		$data['category_list']=array();
		#BreadCrumb Push 
		$this->load->library('breadcrumbs');
		$this->breadcrumbs->push($this->site_name,base_url());
		$data['total_count']=$config['total_rows'];
		$data['search_header_title']="Offers";
		
		if(!empty($city) && $city!='0'){
		   $this->breadcrumbs->push(ucfirst($city),base_url().'offers?coupon_city='.$city);
		}
		if(!empty($area) && $area!='0' && !empty($city) && $city!='0'){
		   $this->breadcrumbs->push(ucfirst($area),base_url().'offers?coupon_city='.$city."&coupon_area=".$area);	
		}
		
		$data['main_content']=$this->load->view('offers/list', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
	
	################### Coupon View ###################
	public function view($id) { 
	    $getValues = $this->campaign_model->get_campaign_details($id);
		$related_coupons = $this->campaign_model->get_related_coupons($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)==0) {
			redirect(base_url());
		}
		$this->load->helper('thumb_helper');
		$this->breadcrumbs->push('Offers', base_url().'offers');
		$this->breadcrumbs->push(ucwords($getValues['city_name']), base_url().'offers/index?coupon_city='.$getValues['city_name']);
		$this->breadcrumbs->push(ucwords($getValues['area_name']), base_url().'offers/index?coupon_city='.$getValues['city_name'].'&coupon_area='.$getValues['area_name']);
		$this->breadcrumbs->push(ucwords($getValues['title']), base_url().'offers/view');
		
		$data['result'] = $getValues;
		$data['title']="View Offer Details";
		$data['title_of_layout']=$getValues['title'].' in '.$getValues['city_name'].','.$getValues['area_name'] .' at '.$getValues['add_name'].' | '.$this->site_name;
		$data['title_of_description']=$getValues['description'];
		$data['main_content']=$this->load->view('offers/view', $data,true);
		$this->load->view('layouts/default',$data);
	}
	
		
	############## Add InterSet ###############
	public function show_interset(){
		
		if($_POST && $_POST['campaign_id']!=''){

			$response=array();
			$campaign_id=(isset($_POST['campaign_id'])) ? $_POST['campaign_id'] :'';
			$user_id=($this->session->userdata('user_id')) ? $this->session->userdata('user_id') :'';;
			$parent_user_id=(isset($_POST['parent_user_id'])) ? $_POST['parent_user_id'] :'';
			if($user_id!='') {
				$campain_response=$this->campaign_model->checkAlreadyAdded($campaign_id,$user_id);
				if($campain_response['is_added']==0){
					
						$campain_code_response=$this->campaign_model->add_interset($campaign_id,$parent_user_id,$user_id);
						$json_array['status']="success";
						$json_array['msg']="Offers Added Successfully!";	
						$json_array['error_msg']="Offers  Added Successfully";
						echo json_encode($json_array);
						die;
				}
				else {
					$json_array['status']="error";
					$json_array['sts']="custom_err";
					$json_array['msg']="Offer Already Added";	
					$json_array['error_msg']="Offers Already Added!";
					echo json_encode($json_array);
					die;	
				}
			}
		}
		die;
	}
}