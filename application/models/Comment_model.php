<?php
class Comment_model extends CI_Model {
 
    public function __construct()
    {
    }
	
	##### Review List ############
	public function getMyReviewList($addId, $limit_start, $limit_end) {
		$this->db->select('SQL_CALC_FOUND_ROWS advertisment_comments.id,advertisements.name as profile_name,advertisment_comments.*,users.email,user_profiles.first_name as first_name',false);
		$this->db->where('advertisment_comments.advertisment_id',$addId);
		$this->db->from('advertisment_comments');
		$this->db->join('users', 'users.id = advertisment_comments.user_id', 'left');
		$this->db->join('advertisements', 'advertisements.id = advertisment_comments.advertisment_id');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisment_comments.user_id', 'left');
		$this->db->order_by('advertisment_comments.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response['TotalRecords']=$this->get_all_rows();
		$response['data']=$result;
		return $response;	
	}
	
	function get_all_rows(){
		$query=$this->db->query('SELECT FOUND_ROWS() AS `Count`');
		$data["totalres"] = $data["totalres"] = $query->row()->Count;
		return 	$data["totalres"] ;
	}
	
	##### Review List ############
	public function getMyReviewLists($user_id, $limit_start, $limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS advertisment_comments.id,advertisment_comments.*,advertisements.name',false);
		$this->db->where('advertisment_comments.user_id',$user_id);
		$this->db->from('advertisment_comments');
		$this->db->join('advertisements', 'advertisment_comments.advertisment_id = advertisements.id', 'left');
		$this->db->order_by('advertisment_comments.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response=array();
		$newresult=array();
		foreach($result  as $key=>$res)
		{
			$newresult[$key]=array(date('d ,M Y',strtotime($res['created'])),ucwords($res['name']),$res['title'],$res['comments'],$res['rating'],$res['is_active'],$res['id']);
		}
		$response['iTotalDisplayRecords']=$this->get_all_rows();
		$response['iTotalRecords']=$this->get_all_rows();
		$response['data']=$newresult;
		return $response;	
	}
	

	public function get_comments($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end,$r_type=null) 
	{  
		$this->db->select('advertisment_comments.*,users.email,users.display_name,advertisements.name as hotel_name,user_profiles.first_name as first_name');
		$this->db->from('advertisment_comments');
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
		$this->db->join('users', 'users.id = advertisment_comments.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisment_comments.user_id', 'left');
		$this->db->join('advertisements', 'advertisements.id = advertisment_comments.advertisment_id', 'left');
		if(!$sort_field)
			$this->db->order_by('advertisment_comments.id', $order_type);
		else
			$this->db->order_by($sort_field, $order_type);

		if($flag == 1){
				$this->db->limit($limit_start, $limit_end);
				$query = $this->db->get();	
				return $query->result_array(); 

		}
		else{
				$query = $this->db->get();		
				return $query->num_rows();        
		}
	}
	public function delete($id) 
	{
		$this->db->select('advertisment_id');
		$this->db->where('id',$id);
		$query = $this->db->get('advertisment_comments');
		$res = $query->row();
		$this->db->delete('advertisment_comments',array('id' => $id));
		if(!empty($res->advertisment_id)) {
			$this->db->select('advertisment_comments.id,advertisment_comments.rating');
			$this->db->where('is_active','1');
			$this->db->from('advertisment_comments');
			$this->db->where('advertisment_comments.advertisment_id',$res->advertisment_id);
			$query = $this->db->get();
			$get_total = $query->result_array(); 
			$count = $query->num_rows(); 
			
			$all_total=0;
			if(!empty($get_total)) {
				foreach($get_total as $t) {
					$all_total=$all_total+$t['rating'];
				}
			}
			$avg = $all_total/$count;
			$data=array('rating'=>$avg);
			$this->db->where('id', $res->advertisment_id);
			$this->db->update('advertisements', $data);
			
		}
		return true;
	}
	public function update_status($id, $data) 
	{
		$this->db->select('advertisment_id');
		$this->db->where('id',$id);
		$query = $this->db->get('advertisment_comments');
		$res = $query->row();
		
		$this->db->where('id', $id);
		$this->db->update('advertisment_comments', $data);
		
		if(!empty($res->advertisment_id)) {
			$this->db->select('advertisment_comments.id,advertisment_comments.rating');
			$this->db->where('is_active','1');
			$this->db->from('advertisment_comments');
			$this->db->where('advertisment_comments.advertisment_id',$res->advertisment_id);
			$query = $this->db->get();
			$get_total = $query->result_array(); 
			$count = $query->num_rows(); 
			
			$all_total=0;
			if(!empty($get_total)) {
				foreach($get_total as $t) {
					$all_total=$all_total+$t['rating'];
				}
			}
			$avg = $all_total/$count;
			$data=array('rating'=>$avg);
			$this->db->where('id', $res->advertisment_id);
			$this->db->update('advertisements', $data);
			
		}
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();

		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	public function get_comment_detail($id=null)
	{
		$this->db->select('advertisment_comments.*,users.email,users.display_name,advertisements.name as hotel_name,user_profiles.first_name as first_name,user_profiles.mobile_number,user_profiles.telephone_number,user_profiles.address');
		$this->db->where('advertisment_comments.id',$id);
		$this->db->from('advertisment_comments');
		$this->db->join('users', 'users.id = advertisment_comments.user_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisment_comments.user_id', 'left');
	    $this->db->join('advertisements', 'advertisements.id = advertisment_comments.advertisment_id', 'left');
		$query = $this->db->get();			
		return $query->row_array(); 
	}
	public function get_comment_list($add_id=null)
	{
		$this->db->select('advertisment_comments.created,advertisment_comments.title,advertisment_comments.comments,advertisment_comments.rating,user_profiles.first_name as first_name,users.profile_image,users.image_dir');
		$this->db->where('advertisment_comments.advertisment_id',$add_id);
		$this->db->where('advertisment_comments.is_active','1');
		$this->db->from('advertisment_comments');
		$this->db->join('users', 'users.id = advertisment_comments.user_id');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisment_comments.user_id');
		$this->db->group_by('advertisment_comments.id');
		$this->db->order_by('advertisment_comments.created','desc');
		$query = $this->db->get();	
		return $query->result_array(); 
	}
	
	public function get_blog_comment_list($add_id=null)
	{
		$this->db->select('blog_comments.created,blog_comments.title,blog_comments.comments,blog_comments.rating,user_profiles.first_name as first_name,,users.profile_image,users.image_dir');
		$this->db->where('blog_comments.blog_id',$add_id);
		$this->db->where('blog_comments.is_active','1');
		$this->db->from('blog_comments');
		$this->db->join('users', 'users.id = blog_comments.user_id');
		$this->db->join('user_profiles', 'user_profiles.user_id = blog_comments.user_id');
		$this->db->group_by('blog_comments.id');
		$this->db->order_by('blog_comments.created','desc');
		$query = $this->db->get();	
		return $query->result_array(); 
	}
	
	public function add_bussiness_commets(){
		$is_active=($this->input->post('is_active') == "on") ? 1  : 0;
		$comment_data = array(
			'created'	=> date('Y-m-d h:i:s'),
			'modified' 	=> date('Y-m-d h:i:s'),
			'user_id' 	=> $this->input->post('customer_id'),
			'title'     =>$this->input->post('title'),
			'comments'  =>$this->input->post('comments'),
			'advertisment_id' =>$this->input->post('advertisment_id'),
			'rating' =>$this->input->post('new_score'),
			'is_active' =>$is_active,
		);
		$this->db->insert('advertisment_comments', $comment_data);
		$total_user_rated=$this->getAddCount($this->input->post('advertisment_id'));
		$this->update_rating($this->input->post('advertisment_id'),$total_user_rated);
		return true;
	}
	
	public function update_bussiness_commets($id){
		$is_active=($this->input->post('is_active') == "on") ? 1  : 0;
		$comment_data = array(
			'created'	=> date('Y-m-d h:i:s'),
			'modified' 	=> date('Y-m-d h:i:s'),
			'user_id' 	=> $this->input->post('customer_id'),
			'title'     =>$this->input->post('title'),
			'comments'  =>$this->input->post('comments'),
			'advertisment_id' =>$this->input->post('advertisment_id'),
			'rating' =>$this->input->post('new_score'),
			'is_active' =>$is_active,
		);
		$this->db->where('id',$id);
		$this->db->update('advertisment_comments', $comment_data);
		$total_user_rated=$this->getAddCount($this->input->post('advertisment_id'));
		$this->update_rating($this->input->post('advertisment_id'),$total_user_rated);
		return true;
	}
	
	public function add_commets()
	{
		$comment_data = array(
			'created'	=> date('Y-m-d h:i:s'),
			'modified' 	=> date('Y-m-d h:i:s'),
			'user_id' 	=> $this->session->userdata('user_id'),
			'title'     =>$this->input->post('title'),
			'comments'  =>$this->input->post('comments'),
			'advertisment_id' =>$this->input->post('advertisment_id'),
			'rating' =>$this->input->post('new_score'),
			'is_active' =>'1',
		);
		$this->db->insert('advertisment_comments', $comment_data);
		
		$total_user_rated=$this->getAddCount($this->input->post('advertisment_id'));
		$this->update_rating($this->input->post('advertisment_id'),$total_user_rated);
		return true;
	}
	
	public function add_blog_commets()
	{
		$comment_data = array(
			'created'	=> date('Y-m-d h:i:s'),
			'modified' 	=> date('Y-m-d h:i:s'),
			'user_id' 	=> $this->session->userdata('user_id'),
			'title'     =>$this->input->post('title'),
			'comments'  =>$this->input->post('comments'),
			'blog_id' =>$this->input->post('blog_id'),
			'rating' =>$this->input->post('new_score'),
			'is_active' =>'1',
		);
		$this->db->insert('blog_comments', $comment_data);
		
		$total_user_rated=$this->getAddBlogCount($this->input->post('blog_id'));
		$this->updateblog_rating($this->input->post('blog_id'),$total_user_rated);
		return true;
	}
	
	public function getAddCount($add_id)
	{
		$this->db->select('advertisment_comments.id');
		$this->db->where('advertisment_comments.advertisment_id',$add_id);
		$this->db->from('advertisment_comments');
		$query = $this->db->get();	
		return $query->num_rows(); 
	}
	public function getAddBlogCount($add_id)
	{
		$this->db->select('blog_comments.id');
		$this->db->where('blog_comments.blog_id',$add_id);
		$this->db->from('blog_comments');
		$query = $this->db->get();	
		return $query->num_rows(); 
	}
	
	public function update_rating($add_id=null,$total_user_rated=null)
	{
		$this->db->select('avg(advertisment_comments.rating) as avg_rating');
		$this->db->where('advertisment_comments.advertisment_id',$add_id);
		$this->db->where('advertisment_comments.is_active','1');
		$query = $this->db->get('advertisment_comments');	
		$result=$query->row_array(); 
		$data=array('rating'=>$result['avg_rating'],'total_user_rated'=>$total_user_rated);
		$this->db->where('id', $add_id);
		$this->db->update('advertisements', $data);
	}

	public function updateblog_rating($add_id=null,$total_user_rated=null)
	{
		$this->db->select('avg(blog_comments.rating) as avg_rating');
		$this->db->where('blog_comments.blog_id',$add_id);
		$this->db->where('blog_comments.is_active','1');
		$query = $this->db->get('blog_comments');	
		$result=$query->row_array(); 
		$data=array('rating'=>$result['avg_rating'],'total_user_rated'=>$total_user_rated);
		$this->db->where('id', $add_id);
		$this->db->update('blogs', $data);
	}	
	
	function getValues($id){
		$this->db->select('advertisment_comments.*,user_profiles.first_name as customer_name');
		$this->db->where('advertisment_comments.id',$id);
		$this->db->from('advertisment_comments');
				$this->db->join('users', 'users.id = advertisment_comments.user_id');
		$this->db->join('user_profiles', 'user_profiles.user_id = advertisment_comments.user_id');
		$query = $this->db->get();
		return $result=$query->row_array();
	}
	
	function changeStatus($id,$is_active){
		$data=array('is_active'=>$is_active);
		$this->db->where('id', $id);
		$this->db->update('advertisment_comments', $data);
		return true;
	}
}
?>