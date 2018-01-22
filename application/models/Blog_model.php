<?php
class Blog_model extends CI_Model {
 
    public function __construct() {
      
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
			$this->db->insert('blogs', $data);
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
	
	
	##### Blog List Category ###########
	public function get_blog_list_category($type) {
		$this->db->select('blog_category.*');
		$this->db->from('blog_category');
		$this->db->where('blog_category.type',$type);		
	    $query = $this->db->get();	
		$results=$query->result_array();
		return $results;			
	}
	
	################## Update Advertisment Views Count############
	public function update_views_counts($add_id=null,$view_count=0) {
		$view_count=1+$view_count;
		$data=array('view_count'=>$view_count);
		$this->db->where('id', $add_id);
		$this->db->update('blogs', $data);
	}
	
	######### Front End - Advertisment List ####################
	public function get_blog_list($type=null,$limit_start=10, $limit_end=0,$category=null,$blog_type=null) {
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
			$this->db->select('blogs.id');
		}
		else
		{
		$this->db->select('SQL_CALC_FOUND_ROWS blogs.id,blogs.*',false);
		}
		$this->db->where('blogs.is_active','1');
		if($cat_id!=''){
		$this->db->where('blogs.blog_category_id',$cat_id);	
		}
		$this->db->where('blogs.type',$blog_type);	
		$this->db->from('blogs');   
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
	
	function get_blog_detail($id) {
		$this->db->select('blogs.*,blog_category.name as cat_name');
		$this->db->where('blogs.id', $id);
		$this->db->join('blog_category','blogs.blog_category_id=blog_category.id','left');
		$query = $this->db->get('blogs');
		$results=$query->row_array(); 
		if($results['id']!=''){
		$this->update_views_counts($results['id'],$results['view_count']);
		}
		return $results;
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

	public function get_blogs($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$type) {  
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

		$this->db->where('blogs.type', $type);		
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
	function get_values($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('blogs');
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
				'type'=>1
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
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
				return true;
		}else{
				return false;
		}
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
	public function get_main_category($slug=false) {	
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
	
    public function get_blog_category($type) {	
		$this->db->where('is_active',1); 
		$this->db->where('type',$type); 		
		$this->db->select('id,name');		
		$this->db->order_by('blog_category.name','ASC' );
		$query = $this->db->get('blog_category');	
		
		$result = $query->result();	
		
		$arr = array();
		foreach($result as $g)  {
					$arr[$g->id]=ucfirst($g->name);
		}
		return $arr;
	}
}
?>