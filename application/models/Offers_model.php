<?php
class Offers_model extends CI_Model {
 
    public function __construct(){
        $this->load->database();
    }
	
	######### Save Flipkart Data ###########
	public function saveCouponData($data, $image_dir, $image_file_name, $type){
		$data = array(
				'advertisement_id'=>0,
				'user_id'=>1,
				'name'	=> $data['title'],
				'created'=> date('Y-m-d h:i:s'),
				'url'=>$data['url'],
				'description'=>$data['description'],
				'profile_image' =>$image_file_name,
				'image_dir'	=> $image_dir,
				'is_active'=>1,
				'vendor_id'=>1,
				'keywords'=>$data['category'],
				'exipry_date'=>date('Y-m-d H:i:s',$data['endTime']/1000)
			);
		$this->db->insert('coupons', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
	}	
	
	
	#Front End - Deasls List
	public function get_offers_list($type=null,$limit_start=10, $limit_end=0){
		$this->db->select('SQL_CALC_FOUND_ROWS offers.id,offers.*',false);
		$this->db->where('offers.is_active','1');
		$this->db->from('offers');   
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();	
		$results['listings']=$query->result_array();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results=array_merge($results,$results_row);
		return $results;
	}
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	######### Save Flipkart Data ###########
	public function saveFlipkartData($data, $image_dir, $image_file_name){
		$data = array(
				'title'	=> $data['title'],
				'created'=> date('Y-m-d h:i:s'),
				'url'=>$data['url'],
				'description'=>$data['description'],
				'product_image' =>$image_file_name,
				'image_dir'	=> $image_dir,
				'is_active'=>1,
				'vendor_id'=>1,
				'category'=>$data['category'],
				'start_date'=>date('Y-m-d H:i:s',$data['startTime']/1000),
				'end_date'=>date('Y-m-d H:i:s',$data['endTime']/1000)
			);
		$this->db->insert('offers', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
	}
	
	############# Deals Data Save #############
	public function saveFlipkartDealsData($data, $image_dir, $image_file_name){
		
		$data = array(
				'title'	=> $data['title'],
				'created'=> date('Y-m-d h:i:s'),
				'url'=>$data['url'],
				'description'=>$data['description'],
				'product_image' =>$image_file_name,
				'image_dir'	=> $image_dir,
				'is_active'=>1,
				'vendor_id'=>1,
			);
		$this->db->insert('deals', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;		
	}
}
?>