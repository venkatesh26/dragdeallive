<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisments_images extends CI_Controller {

    ######### Advertisments Imagees Model ##########
    public function __construct() {
        parent::__construct();
		$this->load->model('home_model');
		$this->load->model('advertisment_model');
		$this->load->model('advertisment_customers_model');
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
	
	################### My Gallery #################
	public function my_gallery() {	
		$this->data=array();
		$this->breadcrumbs->push($this->site_name,base_url());		
		$this->breadcrumbs->push('Business Gallery',base_url());
		#Set Meta Title And Keyword
		$this->data['title_of_layout']=$this->site_name." - ".'My Gallery';
		$this->data['main_content']=$this->load->view('advertisment_images/gallery', $this->data,true);
		$this->load->view('layouts/customer', $this->data);	
	}
	
	################### Add Gallery #################
	public function gallery_add() {
		
		$this->MyaddId=get_my_addId($this->myUserId);
		$profile_image=array();
		if($this->MyaddId=='' || $this->MyaddId==0){
			
				$json_array['status']="error";
				$json_array['sts']="custom_err";
				$json_array['msg']="Please Complete Your  Business Profile.!";	
				$json_array['error_msg']="Please Complete Your  Business Profile.!";
				echo json_encode($json_array);
				die;	
		}
		else {
			
			if(!empty($_FILES) && $_FILES['profile_image']['name']!='')
			{
			  
                $dir=$this->config->item('profile_url').$this->session->userdata('user_id').'/';    
                if (!is_dir($dir))
                {
                  mkdir($dir, 0777, true);
                }
			  $config['upload_path']   =  $dir;
			  $config['allowed_types'] =   "gif|jpg|jpeg|png";
			  $config['file_name'] =   md5(date('Ymdhis'));
			  $this->load->library( 'upload' ,  $config);
			  if(!$image_up = $this->upload->do_upload('profile_image'))
			  {
				  $json_array['status']="error";
				  $json_array['sts']="custom_err";
				  $json_array['msg']="Image Could Not Be Saved !";	
				  $json_array['error_msg']="Invalid File !";
				  echo json_encode($json_array);
				  die;	
			  }
			  else
			  {
				$ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
				$profile_image['profile_image']= $config['file_name'].'.'.$ext;
				$profile_image['image_dir']=$dir;	
				$success=$this->advertisment_model->add_advertisments_image($profile_image,$this->MyaddId);
				if($success) 
				{
					$extra_array = array('status'=>'success','msg'=>'Image Updated Successfully');
					echo json_encode($extra_array);
					die;					
				} 
			  }
			}
			else{
				  $json_array['status']="error";
				  $json_array['sts']="custom_err";
				  $json_array['msg']="No Data Posted";	
				  $json_array['error_msg']="Invalid File";
				  echo json_encode($json_array);
				  die;
			}	
		}		
	}
	
	#################### Get Gallery Images ####################
	public function galleryList(){
		
		$this->MyaddId=get_my_addId($this->myUserId);
		$datas=$this->advertisment_model->get_advertisments_image($this->MyaddId);
		$content='';
		if(!empty($datas)){
			foreach($datas as $image_list) {
							
				   if(!empty($image_list['image_dir']) && file_exists('./'.$image_list['image_dir'].$image_list['profile_image']))
				   {
					   $img_src = thumb(FCPATH.$image_list['image_dir'].$image_list['profile_image'],'300','170','new_list_thumb');
					   $image = base_url().$image_list['image_dir'].'new_list_thumb/'.$img_src;
				   }
				   else
				   {
					   $image = base_url().'assets/img/list_logo.png';
				   }				
				$content.= '<div class="image-container">
					<div class="controls">
					<a href="#" class="control-btn remove delete-gallery" data-toggle="modal" data-target="#confirm-delete-modal" rel="'.$image_list['id'].'"> <i class="fa fa-trash-o"></i> </a>
					</div>
					<div class="image" style="background-image:url('.$image.')"></div>
					</div> ';
			}
		}
		else {
			$content='<span class="sms_chart no_sms_data" style="color: red;"> - No Gallery Found <span></span></span>';
		}
		echo json_encode($content);
		die;					
	}
	
	#####################Delete Gallery#################
	public function deleteGallery(){
		$gallery_delete=array();
		if(isset($_POST['id']))
		{
			$this->MyaddId=get_my_addId($this->myUserId);
			$gallery_delete=$this->advertisment_customers_model->deleteGallery($_POST['id'], $this->MyaddId);
		}
		echo json_encode($gallery_delete);
		die;
	}	
}