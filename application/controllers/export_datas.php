<?php
class Export_datas extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
		if(!$this->session->userdata('is_logged_in'))
		{
            redirect(ADMIN.'/login');
        }
		$this->load->model('advertisment_model');
    }
     
  
   #Export Excel From File -Advertisments Import
   public function index() {
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
}