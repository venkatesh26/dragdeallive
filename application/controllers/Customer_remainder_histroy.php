<?php
class Customer_remainder_histroy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('remainder_histroy_model');
		$this->load->library('breadcrumbs');
    }
	
	########## Remainder Analysis ##########	
    public function reaminder_analysis(){
	   ini_set('memory_limit', '-1');
	   $data_filters=array();
	   $data_datas=array();
	   $data=array();
		if($_POST) {
				$this->load->library('Excel');	
				$headers= array('City','Url');
				$limit_end=(isset($_POST['limit_end']) && $_POST['limit_end']!='')?$_POST['limit_end']:10;
				$limit_start=(isset($_POST['limit_start']) && $_POST['limit_start']!='')?$_POST['limit_start']:0;
				$SQL="SELECT id,name as add_name, city_name, area_name,address_line,contact_number,email FROM (`advertisements`) WHERE is_active=1";
				if($_POST['city']!=''){
					$SQL.=" AND city_name="."'".$_POST['city']."'";
				}
				$SQL.=" LIMIT $limit_start, $limit_end";
				$query = $this->db->query($SQL);
				$data['excel']=$query->result_array();
				$report = array();
				if(!empty($data['excel'])){
					$count=0;
					$count1=0;
					$totalCounts=count($data['excel']);
					for($i=0;$i<=$totalCounts;$i=$i+250) {
						$count=$count+250;
						$count1=$count1+1;
						$datas=array_slice($data['excel'],$i,$count);
						if(!empty($datas)){
							$report[$count1]['City'] = $_POST['city'].$count1;
							$urls='';
							foreach ($datas as $key=>$excel) {
								$url=base_url().'business'.'/'.$excel['id'].'/'.url_title(strtolower($excel['add_name'])).'/'.url_title(strtolower($excel['city_name']));
								$urls .= "<a href=".$url.">".$excel['add_name']."</a>"."<br>";
							}
							$report[$count1]['Url'] = $urls;
						}
					}						
					$this->excel->export( $report,$headers,'add_list__'.date('Y-m-d h:i:s').'.xls', true,$data_filters,$data_datas);
				}
		}
	   	$data['main_content'] = 'admin/export_data/index';
		$data['title']="Export Files";
		$this->load->view('includes/template', $data);  
    }
	
	
	######### Admn Index #########
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
		$this->sorting = array('name' =>'user_profiles.first_name','created' =>'remainder_settings.created','email' =>'users.email','title' =>'remainder_settings.title');
		
		$config['base_url'] = base_url().ADMIN.'/customer_remainders/index';
		$data['indextitle']  = 'Remainder Histroy';
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
		
		
		
		if(isset($this->sorting[$sortfield])) $sort_f =  $this->sorting[$sortfield] ; else $sort_f =  '';
		$data['remainders'] = $this->remainder_histroy_model->get_remainder_histroy( 1 , $conditions, $sort_f, $order, $limit_start ,$limit_end);    
		$config['total_rows'] =$this->remainder_histroy_model->get_remainder_histroy( 0 , $conditions, '', '', '', ''); 
		if($config['total_rows'] <= $limit_end )
		if($page_num && $page_num != 1) 
		redirect(ADMIN.'/customer_remainders/'.$data['type'].'/'. ($page_num -1).'/'.$sortfield.'/'.$order );
		$this->pagination->initialize($config);  
		$data['per_page']  = $limit_start;
		$data['main_content'] = 'admin/customer_remainder_histroy/index';
		$data['title']="Customer Remainders Histroy";
		$this->load->view('includes/template', $data);
	}
	
	########### Update Status #########
	function update_status($id, $status, $pageredirect=null,$pageno) { 
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
			redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		$this->comment_model->update_status($id, $data);
		redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	function bulkautions($pageredirect=null,$pageno) {
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		$bulk_type= $this->input->post('more_action_id');
		$bulk_ids= $this->input->post('checkall_box');
		if($bulk_type == 1)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '1');
				$this->comment_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_enabled'));
		}
		else if($bulk_type == 2)
		{
			foreach($bulk_ids as $id) {
				$data = array('is_active' => '0');
				$this->comment_model->update_status($id, $data);
			}
			$this->session->set_flashdata('flash_message', $this->lang->line('bulk_disabled') );
		}
		else 
		{
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error') );
			redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
		redirect(base_url().ADMIN.'/customer_remainders/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
	
	####### Admin View ########
	public function  view($id) {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
	    $getValues = $this->remainder_histroy_model->get_histroy_detail($id);
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if(count($getValues)) {
			$this->load->helper('thumb_helper');
			$this->breadcrumbs->push('Remainders', base_url().ADMIN.'/customer_remainder_histroy/');
			$this->breadcrumbs->push('View', base_url().ADMIN.'/customer_remainder_histroy/view');
			$this->data['campaign'] = $getValues;	
			$this->data['main_content'] = 'admin/customer_remainder_histroy/view';
			$this->data['title']="View Remainder Details";
			$this->load->view('includes/template', $this->data);
		} else {
			$this->session->set_flashdata('flash_message', $this->lang->line('edit_error'));
			redirect(base_url().ADMIN.'/customer_remainder_histroy/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
		}
	}
	
	function delete($id) {
		if(!$this->session->userdata('is_logged_in')){
            redirect(ADMIN.'/login');
        }
		sub_admin_permission_check();
		$pageredirect=$this->input->get('pagemode');
		$pageno=$this->input->get('modestatus');
		$fieldsorts = $this->input->get('sortingfied');
		$typesorts = $this->input->get('sortype');
		if($this->remainder_histroy_model->delete($id)) {
			$this->session->set_flashdata('flash_message', $this->lang->line('deleted'));
		}
		redirect(base_url().ADMIN.'/customer_remainder_histroy/'.$pageredirect.'/'.$pageno.'/'.$fieldsorts.'/'.$typesorts);
	}
}