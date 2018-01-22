<?php
class Jobs_model extends CI_Model {
 
    public function __construct() {
      
    }
	
	################## Update Advertisment Views Count############
	public function update_views_counts($add_id=null,$view_count=0)
	{
		$view_count=1+$view_count;
		$data=array('view_count'=>$view_count);
		$this->db->where('id', $add_id);
		$this->db->update('jobs', $data);
	}
	
	
	############ Save News Data ###########
	public function saveData($data, $image_dir, $product_image_name, $category,$source){
		$cat_id=$this->saveOrFindCategory($category,2);
		$author="Admin";
		if($data['author']!=''){
			$author=$data['author'];
		}
		$supported_image = array('gif','jpg','jpeg','png','GIF','JPG','JPEG','PNG');
		$ext = strtolower(pathinfo($product_image_name, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
		if (!in_array($ext, $supported_image)) {
				$product_image_name=$product_image_name.'jpg';
		}
		if($data['description']!=''){
			$data = array(
					'name'=> $data['title'],
					'author'=>$author,
					'user_id'=> 1,
					'short_description'	=> $data['description'],
					'description'=> $data['description'],
					'blog_category_id'=> $cat_id,
					'meta_keywords'	=> $data['title'],
					'meta_description'=>  $data['description'],
					'created'		=> date('Y-m-d h:i:s'),
					'modified' 		=> date('Y-m-d h:i:s'),
					'is_active'		=>1,
					'source_url'=>$data['url'],
					'api_provider'=>$source,
					'image_name'    =>$product_image_name,
					'image_dir'		=> $image_dir,
					'type'=>2,
				);
			$this->db->insert('jobs', $data);
			$id = $this->db->insert_id();
		}
		return (isset($id)) ? TRUE : FALSE;
    }
	
	######## Save Category ###########
	public function saveOrFindCategory($cat_name,$type){
		
		$cat_name=ucwords(str_replace('-',' ',$cat_name));
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',$cat_name);
		$this->db->where('type',$type);
		$query = $this->db->get('blog_category');
		$res = $query->row();
		if(!empty($res))
		{
			return $res->id;
		}
		else
		{
			$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$cat_name,
			'type'=>$type,
			'is_active'=>1,
			);
         $this->db->insert('blog_category', $table_data);			
		 return $this->db->insert_id();
		}
	}
	
	
	######### Front End - Advertisment List ####################
	public function get_job_list($type=null,$limit_start=10, $limit_end=0,$category=null,$blog_type=null) {
		#Category Based Search
		$cat_id='';
		if(!empty($category))
		{
			$category_name=ucwords(str_replace('-',' ',$category));
			$this->db->select('blog_category.id as cat_id');
			$this->db->where('blog_category.name',$category_name);
			$query = $this->db->get('blog_category');
		    $categories_result=$query->row_array();
			if(!empty($categories_result)){
				$cat_id=$categories_result['cat_id'];
			}
		}	
		if($type=="total_records")
		{
			$this->db->select('jobs.id');
		}
		else
		{
		$this->db->select('SQL_CALC_FOUND_ROWS jobs.id,jobs.*',false);
		}
		$this->db->where('jobs.is_active','1');
		if($cat_id!=''){
		$this->db->where('jobs.blog_category_id',$cat_id);	
		}	
		$this->db->from('jobs');   
		$this->db->limit($limit_start, $limit_end);
		$this->db->order_by('id','DESC');
		$query = $this->db->get();	
		$results['listings']=$query->result_array();
		$results_row["all_total_rows"] = $this->get_all_rows();
		$results=array_merge($results,$results_row);
		return $results;	
	}
	
	function get_all_rows() {	
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	function get_job_detail($id) {
		$this->db->select('jobs.*');
		$this->db->where('jobs.id', $id);
		$query = $this->db->get('jobs');
		$results=$query->row_array(); 
		return $results;
	}
	
	function get_active_job_detail($id) {
		$this->db->select('jobs.*');
		$this->db->where('jobs.id', $id);
		$this->db->where('jobs.is_active', 1);
		$query = $this->db->get('jobs');
		$results=$query->row_array(); 
		$this->update_views_counts($id, $results['view_count']);
		return $results;
	}
	
	function get_related_job_detail($id) {
		$this->db->select('jobs.*',true);
		$this->db->where('jobs.id !=', $id);
		$this->db->where('jobs.is_active', 1);
		$query = $this->db->get('jobs');
		$results=$query->result_array(); 
		return $results;
	}

	function getcategories($offer_page=null) {
		$query_str = $_SERVER['QUERY_STRING'];
		if($query_str) {
			$query_str=explode("=",$query_str );
			$this->db->like('jobs.name', $query_str[1],'after'); 
		}
		$this->db->where('jobs.is_active','1');
		$this->db->select('jobs.id,jobs.name');
  	    $query = $this->db->get('jobs');	
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}	
		return $arr;
	}

	public function get_jobs($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$type) {  
		$this->db->select('jobs.*');
		$this->db->from('jobs');
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
			$this->db->order_by('jobs.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
			    $this->db->group_by('jobs.id');
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();		
				return $query->result_array(); 
		}
		else{
			$this->db->group_by('jobs.id');	
				$query = $this->db->get();	
			
				return $query->num_rows();        
		}
	 }
	function get_values($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('jobs');
		return $query->row_array();
	}
    public function add_new($image_data) {
		$image_file_name='';
		$image_name='';
		if(isset($image_data))
		{
			$image_file_name=$image_data['upload_data']['file_name'];
			$image_dir=$this->config->item('blog_icon_url');
		}
		$data = array(
				'name'			=> $this->input->post('name'),
				'description'	=> $this->input->post('description'),
				'meta_keywords'	 => $this->input->post('meta_keywords'),
				'meta_description'=> $this->input->post('meta_description'),
				'short_description'	=> $this->input->post('short_description'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
				'no_of_vacancy'=>$this->input->post('no_of_vacancy'),
				'pay_scale'=>$this->input->post('pay_scale'),
				'city'=>$this->input->post('city'),
				'area'=>$this->input->post('area'),
				'qualification'=>$this->input->post('qualification'),
				'age_limit'=>$this->input->post('age_limit'),
				'selection_process'=>$this->input->post('selection_process'),
				'how_to_apply'=>$this->input->post('how_to_apply'),
				'last_date_apply'=>$this->input->post('last_date_apply'),
				'image_name'    =>$image_file_name,
				'image_dir'		=> $image_dir,
				'website'=>$this->input->post('website'),
				'company_name'=>$this->input->post('company_name'),
				'skills'=>$this->input->post('skills'),
			);
		$this->db->insert('jobs', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	public function edit($id,$image_data=array()) {
		$data = array(
				'name'			=> $this->input->post('name'),
				'description'	=> $this->input->post('description'),
				'short_description'	=> $this->input->post('short_description'),
				'meta_keywords'	 => $this->input->post('meta_keywords'),
				'meta_description'=> $this->input->post('meta_description'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'is_active'		=> $this->input->post('is_active'),
				'no_of_vacancy'=>$this->input->post('no_of_vacancy'),
				'pay_scale'=>$this->input->post('pay_scale'),
				'city'=>$this->input->post('city'),
				'area'=>$this->input->post('area'),
				'qualification'=>$this->input->post('qualification'),
				'age_limit'=>$this->input->post('age_limit'),
				'selection_process'=>$this->input->post('selection_process'),
				'how_to_apply'=>$this->input->post('how_to_apply'),
				'last_date_apply'=>$this->input->post('last_date_apply'),
				'website'=>$this->input->post('website'),
				'company_name'=>$this->input->post('company_name'),
				'skills'=>$this->input->post('skills'),
		);
		if(isset($image_data)&& !empty($image_data))
		{
			$image_file_name=$image_data['upload_data']['file_name'];
			$image_dir=$this->config->item('blog_icon_url');
			$image_data=array('image_name'=>$image_file_name,'image_dir'=>$image_dir);
			$data=array_merge($data,$image_data);
		}
		$this->db->where('id', $id);
		$this->db->update('jobs', $data);
	}
	
	public function update_status($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('jobs', $data);
		
		return true;
	}
	public function delete($id) {
		$this->db->delete('jobs',array('id' => $id));
		$report = array();
		return true;
	}	
}
?>