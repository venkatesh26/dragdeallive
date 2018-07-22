<?php
class Import_datas extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('is_logged_in'))
		{
            redirect(ADMIN.'/login');
        }
		$this->load->model('advertisment_model');
		$this->load->model('cities_model');
		$this->load->model('areas_model');
    }
  
   #Import Excel From File
   public function index()
   {
	 #ini_set('MAX_EXECUTION_TIME', -1);
	 #ini_set('memory_limit', '-1');
	 if($_POST)
	 {
		 $this->form_validation->set_rules('file_data', 'File', 'required'); 
		 if($this->form_validation->run() == true && $_FILES['file_data']['name'] && $_FILES['file_data']['tmp_name'] && ($_FILES['file_data']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['file_data']['type']=='application/zip'))
		 {
				 $file_name= $_FILES['file_data']['tmp_name'];		 
				 require_once APPPATH . 'third_party/PHPExcel.php';
				 $objReader = PHPExcel_IOFactory::createReader('Excel2007');
				 $objReader->setReadDataOnly(true);
				 $objPHPExcel = $objReader->load($file_name);
				 $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				 $total_rows=$objPHPExcel->setActiveSheetIndex(0)->getHighestDataRow();
				 $count=0;
				 if($total_rows > 2)
				 {
					 for($i=2; $i<=$total_rows; $i++)
					 {
						if($objWorksheet->getCellByColumnAndRow(0,$i)->getValue()!='')
						{
							$count=$count+1;
							$name = ltrim($objWorksheet->getCellByColumnAndRow(0,$i)->getValue());
							$email = ltrim($objWorksheet->getCellByColumnAndRow(1,$i)->getValue());
							$contact_number = ltrim($objWorksheet->getCellByColumnAndRow(2,$i)->getValue());
							$website = ltrim($objWorksheet->getCellByColumnAndRow(3,$i)->getValue());
							$owner = ltrim($objWorksheet->getCellByColumnAndRow(4,$i)->getValue());
							$address = ltrim($objWorksheet->getCellByColumnAndRow(5,$i)->getValue());
							$area = ltrim($objWorksheet->getCellByColumnAndRow(6,$i)->getValue());
							$city = ltrim($objWorksheet->getCellByColumnAndRow(7,$i)->getValue());
							$zip = ltrim($objWorksheet->getCellByColumnAndRow(8,$i)->getValue());
							$category =ltrim($objWorksheet->getCellByColumnAndRow(9,$i)->getValue());
							if($category=='')
							{
								$category='Yellow Pages';
							}
							$fax ='';
							$description = '';
							$start_time ='10 am';
							$end_time = '7 pm';
							$plan = '';
							$category=explode(',',$category);
							$category=array_unique($category);
							$category=implode(',',$category);
							$city_id=($city!='')?$this->cities_model->cityFindOrSave($city):0;
							$area_id=($area!='')?$this->areas_model->areaFindOrSave($area,$city_id):0;
							if($owner==null || $owner==NULL)
							{
								$owner='Not Available';
							}
							$data_user = array(
										 "name" =>$name,
										 "owner" => $owner,
										 "address_line"=>$address,
										 "city_id"=>$city_id,	
										 "area_id"=>$area_id,	
										 "zip"=>$zip,
										 "fax"=>$fax,
										 "email"=>$email,
										 "description"=>$description,
										 "contact_number"=>$contact_number,
										 "working_start"=>$start_time,
										 "working_end"=>$end_time,
										 "created"=>date('y-m-d H:i:s'),
										 "plan_id"=>$plan,
										 "is_active"=>1,
										 "user_id"=>1,
										 "overall_score"=>5,
										 "site_score"=>4,
										 "short_description"=>'Dragdeal.com provides a excellent information services between local business and users in various cities across India.We Provide the most accurate data to users and businesses.'
										 );											 
							  if(!$this->advertisment_model->add_data($data_user,$category,$contact_number))
							  {
								$data['status']="<p style='color:red;'>Error</p>";  
								$data['total_rows']=$total_rows;
								$data['inserted_datas']=$count;
								$data['message']="<p style='color:red;'>Sowmething Went Wrong Wile Save Data on row $count</p>";   
							  }
						}					
					 }
					 $data['status']="<p style='color:green;'>Success</p>";  
					 $data['total_rows']=$total_rows;
					 $data['inserted_datas']=$count;
					$data['message']="<p style='color:green;'>Data Imported Successfully</p>"; 
					 
					 
				  }
				  else
				  {
					$data['status']="<p style='color:red;'>Error</p>";  
					$data['total_rows']=0;
					$data['inserted_datas']=0;
					$data['message']="<p style='color:red;'>No Datas Available</p>"; 
				  }
		}
		else
		{
			$data['status']="<p style='color:red;'>Error</p>";  
			$data['total_rows']=0;
			$data['inserted_datas']=0;
			$data['message']="<p style='color:red;'>Please Upload Valid File</p>"; 
			
		}
    }
	else
	{
		    $data['status']='Error';  
			$data['total_rows']=0;
			$data['inserted_datas']=0;
			$data['message']='No Datas Available'; 
	}
	   	$data['main_content'] = 'admin/import_data/index';
		$data['title']="Import Files";
		$this->load->view('includes/template', $data);
    }	
}