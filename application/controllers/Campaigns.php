<?php
class Campaigns extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->load->model('campaign_model');
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
	
	###### Campaign Details ########
	public function campaignDetails(){
		$data=array();
		if($this->input->post('campaign_id'))
		{
		 $data=$this->campaign_model->campaignDetails($this->input->post('campaign_id'),$this->session->userdata('user_id'));	
		}
		echo json_encode($data,true);
		die;
	}
	
	
	##### Customer Mobile Number Search #####
	public function search_customers_mobile_numbers(){
		$search_text=(isset($_GET['search'])) ? $_GET['search']:'';
		$data=$this->campaign_model->customer_mobile_data($search_text,$this->session->userdata('user_id'));
		echo json_encode($data);
		die;
	}
	
	######### Sms Count ##########
	public function get_customer_counts(){
	    $this->data['filter_count']=$this->campaign_model->filterDatas($this->session->userdata('user_id'),1);	
		$data=array('total_count'=>$this->data['filter_count']);
		echo json_encode($data);
		die;
	}
	
	############ Campaign Interset ##########
	public function campaign_interset() {
		
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->MyaddId=get_my_addId($this->myUserId);
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Campaign Interset',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Campaign Interset';
		if ($this->input->is_ajax_request()) {
		$page_num=$this->uri->segment(3);
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->pagination->cur_page = $this->uri->segment(3);
		$order_list=array();
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'campaigns/campaign_interset';
		$config['first_url'] = base_url().'campaigns/campaign_interset';
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
		$order_list=$this->campaign_model->getCampaignIntersetList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('campaigns/campaign_interset_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('campaigns/campaign_interset', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
	
	
	######### General Campaings ##########
	public function general_campaigns(){
		
		$this->data=array();
		$this->data['title_of_layout']=$this->site_name." - General Campaign";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('General Campaigns',base_url());
		$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
		$this->data['total_sms']=$this->data['user_info']['total_sms'];
		$this->data['filter_count']=$this->campaign_model->filterDatas($this->session->userdata('user_id'),1);
		$this->data['my_groups']=$this->campaign_model->my_groups($this->session->userdata('user_id'));	
		$this->data['my_sendeids']=$this->campaign_model->my_sendIds($this->session->userdata('user_id'));	
		if($_POST) {
			$this->form_validation->set_rules('title','Title','trim|required');
			$this->form_validation->set_rules('message','Message','trim|required');
			$this->form_validation->set_rules('sender_id','senderId','trim|required');
			$filter_type=$this->input->post('filter_type');
			$this->form_validation->set_rules('url','Url','trim|required|valid_url_format');
			$noOfMessage=ceil(strlen($this->input->post('message'))/160);
			if($this->data['total_sms'] <= 0 ) {
				$extra_array = array('status'=>'error','sts'=>'custom_mess_err','msg'=>'<i class="fa fa-info-circle"></i> Please Choose Your Sms Plan');
				echo json_encode($extra_array);
				die;	
			}
			else if($this->input->post('filter_count') <= 0 ) {
				$extra_array = array('status'=>'error','sts'=>'custom_mess_err','msg'=>'<i class="fa fa-info-circle"></i> Please Choose Atleast One Customers');
				echo json_encode($extra_array);
				die;	
			}
			else {
					if($this->form_validation->run() == true) 
					{
						$datas=$this->campaign_model->saveGeneralCampaigns($this->session->userdata('user_id'),1);				
						if($datas['status']==1)  {
							$filter_datas=array();
							$customer_list=$this->campaign_model->filterDatas($this->session->userdata('user_id'),0);
							$totalSmsSend=$noOfMessage * count($customer_list);
							$total_sms=($this->data['total_sms'] - $totalSmsSend);	
							if($total_sms <=0) {
								$total_sms=0;
								$customer_list_count=floor(count($customer_list)/$noOfMessage);
								$customer_list=array_slice($customer_list,$customer_list_count);
							}	
							$sender_id=$this->campaign_model->senderid_details($this->input->post('sender_id'));
							$sender_id=(isset($sender_id['sender_id']) && $sender_id['sender_id']) ? $sender_id['sender_id'] : 0;						
							$number_of_user_received=$this->campaign_model->saveCampaignList($datas['id'],$customer_list,count($customer_list),1,$this->session->userdata('user_id'),$sender_id);	
							$total_sms_send=$number_of_user_received['number_of_user_received'] * $noOfMessage;
							$this->campaign_model->debitSms($this->session->userdata('user_id'),$total_sms_send);
							$extra_array = array('status'=>'success','msg'=>'Campaign Successfully Send...');
							$this->session->set_flashdata('success','Campaign Successfully Send..');
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
			}
		$this->data['main_content']=$this->load->view('campaigns/general_campaigns', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
	}
	
	public function offer_campaigns() {
		$this->data=array();
		$this->data['title_of_layout']=$this->site_name." - Offer Campaign";
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Offer Campaigns',base_url());
		$this->data['user_info']=$this->campaign_model->sms_availabilty($this->session->userdata('user_id'));
		$this->data['total_sms']=$this->data['user_info']['total_sms'];
		$this->data['filter_count']=$this->campaign_model->filterDatas($this->session->userdata('user_id'),1);
		$this->data['my_groups']=$this->campaign_model->my_groups($this->session->userdata('user_id'));	
		$this->data['my_sendeids']=$this->campaign_model->my_sendIds($this->session->userdata('user_id'));
		if($_POST) {
			$this->form_validation->set_rules('title','Title','trim|required');
			$this->form_validation->set_rules('message','Message','trim|required');
			$this->form_validation->set_rules('campaign_start_date','Start Date','trim|required');
			$this->form_validation->set_rules('campaign_end_date','End Date','trim|required');
			$this->form_validation->set_rules('url','Url','trim|required');
			$this->form_validation->set_rules('sender_id','senderId','trim|required');
			if($this->input->post('filter_type_code')==2){
				
				$this->form_validation->set_rules('coupon_code','Coupon Code','trim|required');
			}

			if($this->input->post('display_as_offer')=='on' || $this->input->post('display_as_offer')==true){
				$this->form_validation->set_rules('description','Description','trim|required');
			    if($this->input->post('offer_type')==1){
					$this->form_validation->set_rules('mrp_price','MRP','trim|required|number');
					$this->form_validation->set_rules('offer_price','Offer Price','trim|required|number|callback_offer_price_validate');
				}
				else{
					$this->form_validation->set_rules('percentage','Percentage','trim|required|number');
				}
			}
			$filter_type=$this->input->post('filter_type');
			$noOfMessage=ceil(strlen($this->input->post('message'))/160);
			if($this->data['total_sms'] <= 0 ) {
				$extra_array = array('status'=>'error','sts'=>'custom_mess_err','msg'=>'<i class="fa fa-info-circle"></i> Please Choose Your Sms Plan');
				echo json_encode($extra_array);
				die;	
			}
			else if($this->input->post('filter_count') <= 0 ) {
				$extra_array = array('status'=>'error','sts'=>'custom_mess_err','msg'=>'<i class="fa fa-info-circle"></i> Please Choose Atleast One Customers');
				echo json_encode($extra_array);
				die;	
			}
			else {
					if($this->form_validation->run() == true)  {
							$profile_image=array();
							if(!empty($_FILES) && $_FILES['profile_image']['name']!='') {
								$config['upload_path']   =   $this->config->item('campaign_url');
								$config['allowed_types'] =   "gif|jpg|jpeg|png";		 
								$this->load->library( 'upload' ,  $config);
								if(!$image_up = $this->upload->do_upload('profile_image')){
									$json_array['status']="error";
									$json_array['sts']="custom_err";
									$json_array['msg']="Campaign Could Not Be Saved";	
									$json_array['error_msg']="Invalid File";
									echo json_encode($json_array);
									die;	
								}
								else
								{
									$profile_image['profile_image']=$_FILES['profile_image']['name'];
									$profile_image['image_dir']=$upload_path=$this->config->item('campaign_url');							 
								}
							}
						$datas=$this->campaign_model->saveOfferCampaigns($this->session->userdata('user_id'),2,$profile_image);				
						if($datas['status']==1)  {
							$filter_datas=array();
							$customer_list=$this->campaign_model->filterDatas($this->session->userdata('user_id'),0);
							$totalSmsSend=$noOfMessage * count($customer_list);
							$total_sms=($this->data['total_sms'] - $totalSmsSend);	
							if($total_sms <=0) {
								$total_sms=0;
								$customer_list_count=floor(count($customer_list)/$noOfMessage);
								$customer_list=array_slice($customer_list,$customer_list_count);
							}				
							$sender_id=$this->campaign_model->senderid_details($this->input->post('sender_id'));
							$sender_id=(isset($sender_id['sender_id']) && $sender_id['sender_id']) ? $sender_id['sender_id'] : 0;	
							$addName=getAddName($this->session->userdata('user_id'));							
							$number_of_user_received=$this->campaign_model->saveOfferCampingList($datas['id'],$customer_list,count($customer_list),1,$this->session->userdata('user_id'),$sender_id, $addName);	
							$total_sms_send=$number_of_user_received['number_of_user_received'] * $noOfMessage;
							$this->campaign_model->debitSms($this->session->userdata('user_id'),$total_sms_send);
							$extra_array = array('status'=>'success','msg'=>'Campaign Successfully Send...');
							$this->session->set_flashdata('success','Campaign Successfully Send..');
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
		}
		$this->data['main_content']=$this->load->view('campaigns/offer_campaigns', $this->data,true);
		$this->load->view('layouts/customer', $this->data);
		
	}

	public function offer_price_validate()
    {
        if ($this->input->post('mrp_price') > $this->input->post('offer_price')) //Use your logic to check here
        {
			return TRUE;
        }	
       $this->form_validation->set_message('offer_price_validate', 'The %s price not greathan MRP.');
       return FALSE;
    }
	
	############ Campaign History ##########
	public function campaign_histroy() {
		
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->MyaddId=get_my_addId($this->myUserId);
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Campaign History',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Campaign History';
		if ($this->input->is_ajax_request()) {
		$page_num=$this->uri->segment(3);
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->pagination->cur_page = $this->uri->segment(3);
		$order_list=array();
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'campaigns/campaign_histroy';
		$config['first_url'] = base_url().'campaigns/campaign_histroy';
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
		$order_list=$this->campaign_model->getCampaignList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('campaigns/campaign_history_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('campaigns/campaign_history', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
	
	####################### Buy Packages ##################
	public function buySmsPlan() {
		
		$this->myUserId=$this->session->userdata('user_id');
		$this->MyaddId=get_my_addId($this->myUserId);
		if($this->MyaddId=='' || $this->MyaddId==0){
			
			$this->session->set_flashdata('error','Please Complete Your Profile !'); 
			redirect('business-profile');
		}
		else {
			
			if(isset($_GET['plan_id']) && $_GET['plan_id']!='') {
				
				$planDetails=$this->campaign_model->getPlanDetails($_GET['plan_id']);
				if(!empty($planDetails)) {
					
					$insta_settings=admin_settings_initialize('instamojo_settings');							
					################### Load Instamojo Class Files ###########
					$this->load->library('instamojo',array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));
					$api =new Instamojo(array('api_key'=>$insta_settings['insta_api_key'],'auth_token'=>$insta_settings['insta_auth_key']));

					$response = $api->linkCreate(array(
						'title'=>$planDetails['name'],
						'description'=>"My Plan", 
						'base_price'=>$planDetails['price'],
						'buyer_name'=>$this->session->userdata('user_name'),
						'send_email'=>$this->session->userdata('user_email'),
						'amount'=>$planDetails['price'],
						'custom_fields'=>array('customer_id'=>$this->session->userdata('user_id')),
						'email'=>$this->session->userdata('user_email'),
						'redirect_url'=>base_url().'home/sms_plan_package_response',
						'cover_image'=>base_url().'assets/img/list_logo.png'
					));
					if(isset($response) && !empty($response))
					{
						$this->campaign_model->savePaymentClicks($this->session->userdata('user_id'),$_GET['plan_id'],$this->MyaddId);
						$data['status']=isset($response['url'])? 1 : 0;
						$data['url']=isset($response['url'])?$response['url']:'';
						
						redirect($data['url']);
					}
					else{
						redirect('home');
					}				
				}
				else {
					$this->session->set_flashdata('error','Invalid Plan'); 
					redirect('dashboard');
				}
				
			} else {
				
				$this->session->set_flashdata('error','Invalid Request'); 
				redirect('dashboard');
			}
		}
	}
		
	public function sms_order_histroy(){
		
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Sms Order History',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'Sms Order History';
		if ($this->input->is_ajax_request()) {
		$page_num=$this->uri->segment(3);
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->pagination->cur_page = $this->uri->segment(3);
		$order_list=array();
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'campaigns/sms_order_histroy';
		$config['first_url'] = base_url().'campaigns/sms_order_histroy';
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
		$order_list=$this->campaign_model->getMyOrdersList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('campaigns/sms_history_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('campaigns/sms_history', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
	
	############ Campaign Offers ##########
	public function my_campaign_offers() {
		
		
		$this->load->model('advertisment_model');
		if(!$this->session->userdata('is_user_logged_in'))
		{
			$url = 'login';
			redirect($url);
		}		
		$this->load->library('breadcrumbs');
		$this->MyaddId=get_my_addId($this->myUserId);
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Campaign Interset',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Campaign Offers';
		if ($this->input->is_ajax_request()) {
		$page_num=$this->uri->segment(3);
		$cofig =array();
		$config = admin_settings_initialize('settings');
		$this->pagination->cur_page = $this->uri->segment(3);
		$order_list=array();
		if(empty($page_num)) $page_num = 1;
		$limit_end = ($page_num-1) * $config['per_page'];
		$limit_start = $config['per_page'];
		$this->pagination->cur_page = $page_num;
		$config['base_url'] = base_url().'campaigns/my_campaign_offers';
		$config['first_url'] = base_url().'campaigns/my_campaign_offers';
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
		$order_list=$this->campaign_model->getCampaignOffersList($this->session->userdata('user_id'),$limit_start,$limit_end);	
		$this->data['order_list']=$order_list['data'];	
		$config['total_rows']=$order_list['TotalRecords'];
		$this->pagination->initialize($config);
		$this->data["pagination_link"]= $this->pagination->create_links();
		$this->data['main_content']=$this->load->view('campaigns/campaign_my_offers_json', $this->data,true);
		echo json_encode($this->data);
		die;
		} else {
			$this->data['main_content']=$this->load->view('campaigns/campaign_my_offers', $this->data,true);
			$this->load->view('layouts/customer', $this->data);	
		}
	}
}	
?>