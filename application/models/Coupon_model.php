<?php
class Coupon_model extends CI_Model {
 
  
    public function __construct()
    {
		
		$this->load->model('cron_model');
      
    }
	
	public function priceRangeLIst($coupon_id)	{
	
		$this->db->select('coupons_price_list.*');
		$this->db->where('coupons_price_list.coupon_id',$coupon_id);
		$this->db->from('coupons_price_list'); 
		$query = $this->db->get();	
		$results=$query->result_array();
		return $results;			
	}
	
	public function  keyword_data($id) {
		
		$this->db->select('coupons_category.name as category_name');
		$this->db->join('coupons_category','coupons_category.id=coupons_category_list.category_id');	
	    $this->db->where('coupons_category_list.coupon_id',$id);
		$this->db->from('coupons_category_list');
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	################  Add Customer Data #############
    public function update_coupons($userId, $advertisement_id, $coupon_id, $image_data=array())	{
		$isActive=($this->input->post('is_active') && $this->input->post('is_active')=='on') ? 1 : 0;
		$percentage=($this->input->post('percentage')!='') ? $this->input->post('percentage') : 0;
		$addInfo=$this->addDetails($advertisement_id);
		$city_name=(isset($addInfo['city_name'])) ? $addInfo['city_name'] : '';
		$area_name=(isset($addInfo['area_name'])) ? $addInfo['area_name'] : '';
		
		$categoryName=array();
		foreach($this->input->post('keywords') as $key=>$name) {
			$categoryName[$key]=(is_numeric($name)) ? $this->categoryName($name) :  $name ;
		}
		
		$data = array(
			'name'=> $this->input->post('name'),
            'short_description'=> $this->input->post('short_description'),	
			'description'=> html_entity_decode($this->input->post('description')),			
			'total_count'=>$this->input->post('total_coupon'),
			'offer_type'=>$this->input->post('offer_type'),
			'percentage'=>$percentage,
			'user_id'=>$userId,
			'advertisement_id'=>$advertisement_id,
			'exipry_date'=>date('Y-m-d',strtotime($this->input->post('expiry_date'))),
			'area_name'=>$area_name,
			'city_name'=>$city_name,
			'is_active'=>$isActive,
			'modified' => date('Y-m-d h:i:s'),
			'keywords'=>implode(',',$categoryName),
			'price_type'=>$this->input->post('price_type'),
			'original_price'=>$this->input->post('original_price'),
			'offer_price'=>$this->input->post('offer_price'),
		);
		if(isset($image_data)&& !empty($image_data))
		{
			$image_file_name=$image_data['upload_data']['file_name'];
			$image_dir=$this->config->item('coupon_icon_url');
			$image_data=array('profile_image'=>$image_file_name,'image_dir'=>$image_dir);
			$data=array_merge($data,$image_data);
		}
		$this->db->where('id', $coupon_id);
		$this->db->update('coupons', $data);
		$this->db->delete('coupons_price_list',array('coupon_id' => $coupon_id));
		
		$min_offer_percntage=0;
		if($this->input->post('offer_type')==2){
			foreach($this->input->post('from_price') as $key=>$value) {
				$toPrice=$this->input->post('to_price');
				$price_range=$this->input->post('range_per');
				$data = array(		
					'from_price'=>$value,
					'to_price'=>$toPrice[$key],	
					'percentage'=> $price_range[$key],
					'coupon_id'=>$coupon_id					
				);			
				$this->db->insert('coupons_price_list', $data);	
				if($key==0){
					$min_offer_percntage=$price_range[$key];
				}				
				else{
					if($min_offer_percntage < $price_range[$key]){
						$min_offer_percntage=$price_range[$key];
					}
				}
			}
		}
		
		if($min_offer_percntage >0){
			
			$update_coupon_data=array();
			$update_coupon_data['percentage']=$min_offer_percntage;
			$this->db->where('id',$coupon_id);
			$this->db->update('coupons', $update_coupon_data);	
		}
		
		
		$category_data_id=array();
		foreach($this->input->post('keywords') as $key=>$name) {
			$category_data_id[]=(is_numeric($name)) ? $name : $this->categoryFindOrSave($name);
		}
		
		$this->db->delete('coupons_category_list',array('coupon_id' => $coupon_id));
		foreach($category_data_id as $id) {
			$listing_data=array(
				'created'=> date('Y-m-d h:i:s'),
				'coupon_id'=>$coupon_id,
				'category_id'=>$id,
			);
		    $this->db->insert('coupons_category_list', $listing_data);
		}
		return true;
	}
	
	public function categoryName($catid){
		
		$this->db->select('coupons_category.name,coupons_category.id');
		$this->db->where('id',$catid);
		$this->db->from('coupons_category');
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results['name'];
	}  
	
	public function get_user_categories_data() {
		$this->db->select('coupons_category.name,coupons_category.id');
		$this->db->from('coupons_category');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['name']);	
		}	
		return $new_results;
	}
	
	############ Get Category Listing Front End ###############
	public function get_add_or_edit_business_data($coupon_id=null) {
		$this->db->select('coupons_category.name as category_name,coupons_category.id');
		$this->db->join('coupons_category','coupons_category.id=coupons_category_list.category_id');	
	    $this->db->where('coupons_category_list.coupon_id',$coupon_id);
		$this->db->from('coupons_category_list');
	    $query = $this->db->get();	
		$results=$query->result_array();
		$new_results=array();
		foreach($results as $cat) {
			$new_results[$cat['id']]=ucwords($cat['id']);	
		}	
		return $new_results;
	}
	
	
	################  Add Customer Data #############
    public function add_coupons($userId, $advertisement_id, $image_data=array())	{

		$addInfo=$this->addDetails($advertisement_id);
		$city_name=(isset($addInfo['city_name'])) ? $addInfo['city_name'] : '';
		$area_name=(isset($addInfo['area_name'])) ? $addInfo['area_name'] : '';
		$isActive=($this->input->post('is_active') && $this->input->post('is_active')=='on') ? 1 : 0;
		$percentage=($this->input->post('percentage')!='') ? $this->input->post('percentage') : 0;
		$data = array(
			'name'=> $this->input->post('name'),
            'description'=> html_entity_decode($this->input->post('description')),			
			'total_count'=>$this->input->post('total_coupon'),
			'offer_type'=>$this->input->post('offer_type'),
			'percentage'=>$percentage,
			'user_id'=>$userId,
			'advertisement_id'=>$advertisement_id,
			'exipry_date'=>date('Y-m-d',strtotime($this->input->post('expiry_date'))),
			'city_name'=>$city_name,
			'area_name'=>$area_name,
			'is_active'=>$isActive,
			'created' => date('Y-m-d h:i:s'),
			'keywords'=>implode(',',$this->input->post('keywords')),
			'original_price'=>$this->input->post('original_price'),
			'offer_price'=>$this->input->post('offer_price'),
		);
		if(isset($image_data)&& !empty($image_data))
		{
			$image_file_name=$image_data['upload_data']['file_name'];
			$image_dir=$this->config->item('coupon_icon_url');
			$image_data=array('profile_image'=>$image_file_name,'image_dir'=>$image_dir);
			$data=array_merge($data,$image_data);
		}
		$this->db->insert('coupons', $data);
		$last_insert_id = $this->db->insert_id();
		
		$min_offer_percntage=0;
		if($this->input->post('offer_type')==2){
			
			foreach($this->input->post('from_price') as $key=>$value)
			{
				
				$toPrice=$this->input->post('to_price');
				$price_range=$this->input->post('range_per');
				$data = array(		
					'from_price'=>$value,
					'to_price'=>$toPrice[$key],	
					'percentage'=> $price_range[$key],
					'coupon_id'=>$last_insert_id					
				);	
				if($key==0){
					$min_offer_percntage=$price_range[$key];
				}				
				else{
					if($min_offer_percntage < $price_range[$key]){
						$min_offer_percntage=$price_range[$key];
					}
				}
				$this->db->insert('coupons_price_list', $data);	
			}
		}
		if($min_offer_percntage >0){
			
			$update_coupon_data=array();
			$update_coupon_data['percentage']=$min_offer_percntage;
			$this->db->where('id',$last_insert_id);
			$this->db->update('coupons', $update_coupon_data);	
		}
		
		$category_data_id=array();
		foreach($this->input->post('keywords') as $key=>$name)
		{
			$category_data_id[]=(is_numeric($name)) ? $name : $this->categoryFindOrSave($name);
		}
		
		foreach($category_data_id as $id) {
			$listing_data=array(
				'created'=> date('Y-m-d h:i:s'),
				'coupon_id'=>$last_insert_id,
				'category_id'=>$id,
			);
		    $this->db->insert('coupons_category_list', $listing_data);
		}
		
		$result=array('status'=>1,'last_insert_id'=>$last_insert_id);
		return $result;
	}
	
	public function addDetails($addId){	
		$this->db->select('advertisements.city_name,advertisements.area_name');
		$this->db->from('advertisements');
		$this->db->where('advertisements.id',$addId);
	    $query = $this->db->get();	
		$results=$query->row_array();
		return $results;
	}
	
	function randomNumber($length) {
		$result = '';
		for($i = 0; $i < $length; $i++) {
			$result .= mt_rand(0, 9);
		}
		return $result;
	}
    
	################ Get Coupons List ####################
	public function getDownloadedCouponsList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS coupons_codes.id,coupons_codes.*,coupons.name as coupon_name,coupons.exipry_date,user_profiles.first_name as user_name,user_profiles.mobile_number',false);
		$this->db->where('coupons_codes.is_download',1);
		$this->db->from('coupons_codes');
		$this->db->join('coupons','coupons.id=coupons_codes.coupon_id');
		$this->db->join('users','users.id=coupons_codes.user_id','left');
		$this->db->join('user_profiles','user_profiles.user_id=users.id','left');
		$this->db->limit($limit_start, $limit_end);
		$this->db->order_by('coupons_codes.id','DESC');
		$this->db->where('coupons.user_id',$userId);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }
	
	################ Get Coupons List ####################
	public function getCouponsList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS coupons.id,coupons.*',false);
		$this->db->where('coupons.user_id',$userId);
		$this->db->from('coupons');
		$this->db->order_by('coupons.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }

	################ Get Coupons List ####################
	public function getMyCouponsList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS coupons_codes.id,coupons_codes.*, coupons.name, coupons.exipry_date, advertisements.name as add_name, advertisements.contact_number',false);
		$this->db->where('coupons_codes.user_id',$userId);
		$this->db->from('coupons_codes');
		$this->db->join('coupons','coupons.id=coupons_codes.coupon_id','left');
		$this->db->join('advertisements','coupons.advertisement_id=advertisements.id','left');
		$this->db->order_by('coupons_codes.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();			
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;
    }
	
	public function download_coupon_code($coupon_id,$add_id,$user_id) {
		
		$response=array();	
		$response['is_available']=0;
		$response['coupon_code']='';
		$this->db->select('coupons.id,coupons.total_coupons_download,coupons.total_count');
		$this->db->from('coupons');   
		$this->db->where('coupons.id', $coupon_id);
		$this->db->where('coupons.advertisement_id', $add_id);
		$query = $this->db->get();	
		$results=$query->row_array();	
		
		#### Check Already Download ####
		$this->db->select('coupons_codes.id');
		$this->db->where('coupons_codes.is_download',0);
		$this->db->where('coupons_codes.user_id !=',$user_id);
		$this->db->where('coupons_codes.coupon_id', $coupon_id);
		$this->db->from('coupons_codes');   
		$query = $this->db->get();	
		$new_results=$query->row_array();	
		
		if(empty($new_results) && !empty($results) && $results['total_coupons_download'] < $results['total_count']) {
			
			$data = array(		
				'created'=>date('Y-m-d H:i:s'),
				'code'=>$this->randomNumber(10),	
				'coupon_id'=> $coupon_id,
				'is_download'=>1,
				'user_id'=>$user_id					
			);			
			$this->db->insert('coupons_codes', $data);
			
			$total_coupons_download=1+$results['total_coupons_download'];
			$update_coupon_data=array();
			$update_coupon_data['total_coupons_download']=$total_coupons_download;
			$this->db->where('id',$coupon_id);
			$this->db->update('coupons', $update_coupon_data);
			$response['is_available']=1;
			$response['coupon_code']=$data['code'];
		}
	    return $response;
	}
	
	public function checkAlreadyDownload($coupon_id,$add_id,$user_id){
		
		$response=array();	
		$response['is_download']=0;
		$this->db->select('coupons.user_id, coupons.id,coupons.total_coupons_download,coupons.total_count,coupons_codes.code,coupons_codes.id as coupon_code_id');
		$this->db->from('coupons');   
		$this->db->join('coupons_codes','coupons_codes.coupon_id=coupons.id');  
		$this->db->where('coupons.id', $coupon_id);
		$this->db->where('coupons.advertisement_id', $add_id);
		$this->db->where('coupons_codes.user_id', $user_id);
		$query = $this->db->get();	
		$results=$query->row_array();		
		if(!empty($results)) {
			
			$response['is_download']=1;	
			$response['coupon_data']=$results;
		}
		return $response;		
	}
	
	public function couponDetails($coupon_id){
		
		$this->db->select('coupons.user_id, coupons.id,coupons.total_coupons_download,coupons.name,coupons.total_count,advertisements.name as add_name,advertisements.city_name,advertisements.id as add_id,advertisements.area_name,advertisements.address_line');
		$this->db->from('coupons');   
		$this->db->join('advertisements','advertisements.id=coupons.advertisement_id','LEFT');  
		$this->db->where('coupons.id', $coupon_id);
		$query = $this->db->get();	
		return $query->row_array();	
	}
	
	
	
	public function get_blog_list_category()
	{
		$this->db->select('blog_category.*');
		$this->db->from('blog_category'); 
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;			
	}
	
	######### Front End - Advertisment List ####################
	public function get_coupon_list($type=null,$limit_start=10, $limit_end=0,$city=null,$area=null,$keyword=null,$category=null, $add_id=null) {
		$today=date('Y-m-d');
		$this->db->select('SQL_CALC_FOUND_ROWS coupons.id,coupons.*,advertisements.name as add_name,advertisements.city_name,advertisements.area_name,advertisements.address_line',false);	
		$this->db->join('advertisements','advertisements.id=coupons.advertisement_id');  
		$this->db->from('coupons');   
		$this->db->where('coupons.is_active',1);
		$this->db->where('coupons.exipry_date >=',$today);	
		#City Based Search
		if(!empty($city)) {
			$this->db->where('coupons.city_name',$city);	
		}		
		#City Based Search
		if(!empty($add_id)) {
			$this->db->where('coupons.advertisement_id',$add_id);	
		}
		#Area Based Search
		if(!empty($area)) {
			$this->db->where('coupons.area_name',$area);
		}
		#Keyword Based Search
		if(!empty($keyword) && empty($category)) {
			$this->db->like('coupons.name',$keyword);
			$this->db->or_where("FIND_IN_SET('$keyword',keywords) !=", 0);
		}
		#Keyword Based Search
		elseif(empty($keyword) && !empty($category)) {
			$this->db->where("FIND_IN_SET('$category',keywords) !=", 0);
		}
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();	
		$results['listings']=$query->result_array();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results=array_merge($results,$results_row);
		return $results;	
	}
	
	####################### Get Related Coupons #################
	public function get_related_coupons($id){
		
		$today=date('Y-m-d');
		$this->db->select('SQL_CALC_FOUND_ROWS coupons.id,coupons.*,advertisements.image_dir,advertisements.profile_image',false);	
		$this->db->from('coupons');   
		$this->db->where('coupons.is_active',1);
		$this->db->where('coupons.exipry_date >=',$today);
		$this->db->where('coupons.id !=',$id);
		$this->db->limit(10,0);	
		$this->db->join('advertisements', 'advertisements.id = coupons.advertisement_id');
		$this->db->order_by('coupons.id','rand()');
		$query = $this->db->get();	
		$results['related_listings']=$query->result_array();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results=array_merge($results,$results_row);
		return $results;
	}
	
	function get_all_rows()
	{	
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	function get_coupon_detail($id)
	{
		$this->db->select('coupons.*,advertisements.name as add_name,advertisements.city_name,advertisements.id as add_id,advertisements.area_name,advertisements.address_line,advertisements.image_dir as add_image_dir,advertisements.profile_image as add_profile_image,advertisements.contact_number');
		$this->db->where('coupons.id', $id);
		$this->db->join('advertisements','advertisements.id=coupons.advertisement_id');  
		$query = $this->db->get('coupons');
		return $query->row_array();	
	}

	function getcategories($offer_page=null) {
		$query_str = $_SERVER['QUERY_STRING'];
		if($query_str) {
			$query_str=explode("=",$query_str );
			$this->db->like('blogs.name', $query_str[1],'after'); 
		}

		$this->db->where('blogs.is_active','1');
		$this->db->select('blogs.id,blogs.name');
  	    $query = $this->db->get('blogs');	
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}	
		return $arr;
	}

	public function get_blogs($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end) {  
		$this->db->select('blogs.*');
		$this->db->from('blogs');
		if(!empty($conditions))
		{ 
				foreach($conditions as $key=>$cond)
				{
					if(!$cond['direct'])
						$this->db->$cond['rule']($cond['field'], $cond['value']);
					else
						$this->db->$cond['rule']($cond['value']);
				}
		}	
		if(!$sort_field)
			$this->db->order_by('blogs.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			    $this->db->group_by('blogs.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('blogs.id');	
				$query = $this->db->get();	
			
				return $query->num_rows();        
		}
	 }
	function get_values($id, $user_id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('coupons');
		return $query->row_array();
	}
	
	function get_price_values($coupon_id) {
		$this->db->select('*');
		$this->db->where('coupon_id', $coupon_id);
		$query = $this->db->get('coupons_price_list');
		return $query->result_array();
	}
	
    public function add_new($image_data) 
	{
		$image_file_name='';
		$image_name='';
		if(isset($image_data))
		{
		$image_file_name=$image_data['upload_data']['file_name'];
		$image_dir=$this->config->item('blog_icon_url');
		}
		$data = array(
				'name'			=> $this->input->post('name'),
				'user_id'			=> $this->session->userdata('admin_id'),
				'short_description'	 => $this->input->post('short_description'),
				'description'			=> $this->input->post('description'),
				'blog_category_id'			=> $this->input->post('blog_category_id'),
				'meta_keywords'			=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
				'image_name'    =>$image_file_name,
				'image_dir'		=> $image_dir,
			);
		$this->db->insert('blogs', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	public function edit($id,$image_data=array()) {
		
	
		$data = array(
				'name'			=> $this->input->post('name'),
				'user_id'			=> $this->session->userdata('admin_id'),
				'short_description'	 => $this->input->post('short_description'),
				'description'			=> $this->input->post('description'),
				'blog_category_id'			=> $this->input->post('blog_category_id'),
				'meta_keywords'			=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
		);
		if(isset($image_data)&& !empty($image_data))
		{
			$image_file_name=$image_data['upload_data']['file_name'];
			$image_dir=$this->config->item('blog_icon_url');
			$image_data=array('image_name'=>$image_file_name,'image_dir'=>$image_dir);
			$data=array_merge($data,$image_data);
		}
		$this->db->where('id', $id);
		$this->db->update('blogs', $data);
	}
	
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('blogs', $data);
		return true;
	}
	
	public function delete($id) {
		$this->db->delete('blogs',array('id' => $id));
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
				return true;
		}else{
				return false;
		}
	}	
	public function get_main_category($slug=false)
	{	
		if($slug){
			$this->db->where('id', $slug); 
		}else{
			$this->db->where('is_active',1); 	
		}
		$this->db->select('id,name');		
		$this->db->order_by('main_category.name','ASC' );
		$query = $this->db->get('main_category');	
		
		$result = $query->result();	
		
		$arr = array();
		foreach($result as $g) 
		{
					$arr[$g->id]=ucfirst($g->name);
		}
		return $arr;
	}
	
    public function get_blog_category()
	{	
		$this->db->where('is_active',1); 	
		$this->db->select('id,name');		
		$this->db->order_by('blog_category.name','ASC' );
		$query = $this->db->get('blog_category');	
		
		$result = $query->result();	
		
		$arr = array();
		foreach($result as $g) 
		{
					$arr[$g->id]=ucfirst($g->name);
		}
		return $arr;
	}
		
	#################### Update Coupons ###################
	public function updateCoupon($c_id,$u_id){
		
		$this->db->where('id', $c_id);
		$this->db->where('user_id', $u_id);
		$data=array('is_active'=>$_POST['status']);
		$this->db->update('coupons', $data);
		return true;
	}
	
	################### Export Downloaded Coupons #################
	public function export_download_coupons_code($user_id){
		
		$this->db->select('coupons_codes.*,coupons.name as coupon_name,coupons.exipry_date,user_profiles.first_name as user_name',false);
		$this->db->where('coupons_codes.is_download',1);
		$this->db->from('coupons_codes');
		$this->db->join('coupons','coupons.id=coupons_codes.coupon_id');
		$this->db->join('users','users.id=coupons_codes.user_id','left');
		$this->db->join('user_profiles','user_profiles.user_id=users.id','left');
		$this->db->order_by('coupons_codes.modified','DESC');
		$this->db->where('coupons.user_id',$user_id);
		$query = $this->db->get();			
		$result=$query->result_array();
		return $result;
	}
	
	#################### Export Coupons ###################
	public function export_all_coupons($coupon_id,$user_id){
		
		$this->db->select('coupons_codes.created,coupons_codes.code,coupons.exipry_date,coupons.name,coupons.description,coupons.exipry_date,coupons.is_active');
		$this->db->from('coupons_codes');
		$this->db->where('coupons_codes.coupon_id',$coupon_id);
		$this->db->where('coupons.user_id',$user_id);
		$this->db->join('coupons','coupons.id=coupons_codes.coupon_id','left');
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
	#################### Download User Coupons ###################
	public function export_my_coupons($user_id){
		
		$this->db->select('coupons_codes.created,coupons_codes.code,coupons.name,coupons.description,coupons.exipry_date,coupons.is_active');
		$this->db->from('coupons_codes');
		$this->db->where('coupons_codes.user_id',$user_id);
		$this->db->where('coupons_codes.user_id',$user_id);
		$this->db->join('coupons','coupons.id=coupons_codes.coupon_id','left');
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;
	}
	
    ############ Category Find Or Save ########
	public function categoryFindOrSave($name){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$name);
		$query = $this->db->get('coupons_category');
		$res = $query->row();
		if(!empty($res)){
			return $res->id;
		}
		else{
			$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$name,
			'is_active'=>1,
			);
         $this->db->insert('coupons_category', $table_data);			
		 return $this->db->insert_id();
		}
	}

    ############ Save Coupon Campaings #######
	public function saveCouponCampaigns($user_id, $campaign_type, $senderid){
		$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'title'=>$this->input->post('name'),
			'campaign_type_id'=>$campaign_type,
			'user_id'=>$user_id,
			'message'=>$this->input->post('message'),
			'message_length'=>strlen($this->input->post('message')),
			'sender_id'=>$senderid,
			'number_of_user_send'=>$this->input->post('filter_count'),
		);
		$this->db->insert('advertisments_customers_campaign', $table_data);		
		$result=array('id'=>$this->db->insert_id(),'status'=>1);
		return $result;	
	}
		
	########### Save Campaings list ###########	
	public function saveCouponCampaignList($campaign_id,$customer_list,$filter_count,$camping_type,$user_id,$sender_id,$url){
		
		$sms_send_count=0;
		foreach($customer_list as $key=>$list) {
			
			$sender_info=array();
			$sender_info['user_id']=$list['user_id'];
			$sender_info['sender_id']=$sender_id;
			$datas=array('##USERNAME##');
			
			$datas=array('##URL##','##CODE##', '##USERNAME##');
			$base_url=base_url()."?r_url=".$url."&UTM_mobilenumber=".$list['mobile_number']."&UTM_email=".$list['email']."&UTM_campaign_id=".$campaign_id."&UTM_user_id=".$this->session->userdata('user_id')."&UTM_type_id=3&UTM_u_id=".$list['customer_id'];
			
			$replace_data=array($list['first_name']);
			$message = str_replace($datas, $replace_data, $this->input->post('message'));
			$message=$message." ".$short_url;
			$status=$this->cron_model->send_message($list['mobile_number'], $message, $sender_info);
			if($status==1){
				$sms_send_count=$sms_send_count+1;			   
			}
			$table_data=array(
				'created'=>date('Y-m-d h:i:s'),
				'parent_user_id'=>$user_id,
				'mobileno'=>$list['mobile_number'],
				'campaign_url'=>'',
				'campaign_url_short'=>'',
				'status'=>$status,
				'message'=>$this->input->post('message'),
				'customer_id'=>$list['id'],
				'camping_type_id'=>$camping_type,
				'advertisments_customers_campaign_id'=>$campaign_id,
				'message'=>$this->input->post('message'),
			);
			$this->db->insert('advertisments_customers_campaign_list', $table_data);				
		}
		$campaign_data=array(
			'number_of_user_received'=>$sms_send_count
		);
		$this->db->where('id',$campaign_id);
		$this->db->update('advertisments_customers_campaign',$campaign_data);
		return $campaign_data;
	}	
}
?>