<?php
class site_maps extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
	
	############# Type News Data ############
	public function feedNews(){
		$type=array('the-hindu'=>'the-hindu','fortune'=>'fortune','the-times-of-india-api'=>'the-times-of-india-api','espn-cric-info'=>'espn-cric-info','google-news'=>'google-news');
		foreach($type as $t){
			$this->newsData($t);
		}
		die;
	}
	
	########## News Feed Api ##########
	public function newsData($news_type) {
	
		$this->load->model('blog_model');
		$token='3ad5feb803b544a4b0fee60f93844467';
	    $url='https://newsapi.org/v1/articles?source='.$news_type.'&sortBy=top&apiKey='.$token;
		$timeout = 45;
		$cObj = curl_init();
		curl_setopt($cObj, CURLOPT_URL, $url);
		curl_setopt($cObj, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
		$allDdata = curl_exec($cObj);
		curl_close($cObj);
		$count=0;
		$allDdata=json_decode($allDdata, true);
		foreach($allDdata['articles'] as $data){
			$count=$count+1;
			$product_image_name=basename($data['urlToImage']);
			$dir="app_data/blogs/".$product_image_name;
			file_put_contents($dir, file_get_contents($data['urlToImage']));
			$image_dir="app_data/blogs/";
			$this->blog_model->saveData($data,$image_dir,$product_image_name,$news_type,'https://newsapi.org');
			echo $count;
			echo "<br/>";
			echo "<br/>";
		}	
	}
	
	
	public function index(){
	

		ini_set('memory_limit', '-1');
		$this->load->helper('file');
        header("Content-Type: text/xml;charset=iso-8859-1");      		
		$limit_end=(isset($_GET['limit_end']) && $_GET['limit_end']!='')?$_GET['limit_end']:10;
		$limit_start=(isset($_GET['limit_start']) && $_GET['limit_start']!='')?$_GET['limit_start']:0;
		$SQL="SELECT id,name as add_name , city_name as city_name FROM (`advertisements`) WHERE is_active='1' LIMIT $limit_start, $limit_end";
		$query = $this->db->query($SQL);
        $this->data['results']['listings']=$query->result_array();
		$this->load->view('admin/sitemaps/site_maps', $this->data);
	}
	
	public function sitemaps(){
		ini_set('memory_limit', '-1');	
		$limit_end=(isset($_GET['limit_end']) && $_GET['limit_end']!='')?$_GET['limit_end']:10;
		$limit_start=(isset($_GET['limit_start']) && $_GET['limit_start']!='')?$_GET['limit_start']:0;
		$SQL="SELECT id,name as add_name , city_name as city_name FROM (`advertisements`) LIMIT $limit_start, $limit_end";
		$query = $this->db->query($SQL);
       		 $this->data['results']['listings']=$query->result_array();
		$this->load->view('admin/sitemaps/site_mapss', $this->data);
	}
	
	public function category(){
		ini_set('memory_limit', '-1');
		$this->load->helper('file');
        header("Content-Type: text/xml;charset=iso-8859-1");      
		$limit_end=(isset($_GET['limit_end']) && $_GET['limit_end']!='')?$_GET['limit_end']:10;
		$limit_start=(isset($_GET['limit_start']) && $_GET['limit_start']!='')?$_GET['limit_start']:0;
		$SQL="SELECT `categories`.`name` as category_name, `cities`.`name` as city_name, `areas`.`name` as area_name
		FROM (`category_listing`)
		LEFT JOIN `categories` ON `categories`.`id`=`category_listing`.`category_id`
		LEFT JOIN `areas` ON `areas`.`id`=`category_listing`.`area_id`
		LEFT JOIN `cities` ON `cities`.`id`=`category_listing`.`city_id`
		LIMIT $limit_start, $limit_end";
		$SQL="SELECT link from category_listing LIMIT $limit_start, $limit_end";
		$query = $this->db->query($SQL);
        $this->data['results']=$query->result_array();
		$this->load->view('admin/sitemaps/site_maps_category', $this->data);
	}
	
	
	public function link_create(){
		//$con=mysqli_connect("localhost","root","","indiabe");
		$con=mysqli_connect("localhost","sportsga_dialbe","Deva7254","sportsga_new_dialbe2");
		$query="SELECT `category_listing`.`id`,`category_listing`.`link`,`categories`.`name` as category_name, `cities`.`name` as city_name, `areas`.`name` as area_name
				FROM (`category_listing`)
				LEFT JOIN `categories` ON `categories`.`id`=`category_listing`.`category_id`
				LEFT JOIN `areas` ON `areas`.`id`=`category_listing`.`area_id`
				LEFT JOIN `cities` ON `cities`.`id`=`category_listing`.`city_id`
				WHERE `category_listing`.`link` IS NULL";
			$rs=mysqli_query($con,$query);
			$count=0;
			while($datas=mysqli_fetch_assoc($rs))
			{
				$table_id=$datas['id'];
				$count=$count+1;
				$city_name=strtolower($datas['city_name']);
				$area_name=strtolower($datas['area_name']);
				$cat_name=strtolower($datas['category_name']);
				if($city_name!='' && $area_name!='' && $cat_name!='')
				{
				$link=base_url().'category-search/'.url_title(strtolower($cat_name)).'/'.strtolower(url_title($city_name)).'/'.strtolower(url_title($area_name));	
				}
				else
				{
				if($cat_name!='' && $city_name!='')
				{
				$link=base_url().'category-search/'.url_title(strtolower($cat_name)).'/'.url_title(strtolower($city_name));	
				}
				}
				$insertQuery="UPDATE `category_listing` SET `link` = '".$link."' WHERE `category_listing`.`id` = $table_id;";
				mysqli_query($con,$insertQuery);	
				echo $count;
				echo "<br/>";
				echo "<br/>";
			}
		die;
	}
}