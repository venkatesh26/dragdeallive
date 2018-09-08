<?php
class Advertisment_store_products_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
		$this->load->model('advertisment_products_model');
    }
	
	public function get_all_products_list($user_id, $type=null){
		$this->db->where('advertisment_products.is_active','1');
		if($type!=null){
			$this->db->where('advertisment_store_products.user_id',$user_id);
			$this->db->join('advertisment_store_products','advertisment_store_products.product_id=advertisment_products.id');
			$this->db->select('advertisment_products.id,advertisment_products.name,advertisment_store_products.price as amount');
		}
		else{
			$this->db->select('advertisment_products.id,advertisment_products.name, advertisment_products.price as amount');
		}
		$query = $this->db->get('advertisment_products');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id, 'amount'=>$g->amount);
		}
		return $arr;
	}
	
	public function get_products_list($keyword,$user_id, $type=null){
		if($keyword) 
		{
			$this->db->like('advertisment_products.name', $keyword,'after'); 
		}
		$this->db->where('advertisment_products.is_active','1');
		if($type!=null){
			$this->db->where('advertisment_store_products.user_id',$user_id);
			$this->db->join('advertisment_store_products','advertisment_store_products.product_id=advertisment_products.id');
			$this->db->select('advertisment_products.id,advertisment_products.name,advertisment_store_products.price as amount');
		}
		else{
			$this->db->select('advertisment_products.id,advertisment_products.name, advertisment_products.price as amount');
		}
		$query = $this->db->get('advertisment_products');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) 
		{
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id, 'amount'=>$g->amount);
		}
		return $arr;
	}
	
	############### Delete Product ###############
	public function deleteProducts($id, $user_id){
	   $this->db->delete('advertisment_store_products',array('product_id' => $id,'user_id'=>$user_id));
	   return true;	
	}
	
	########### Import Products #########################
	public function import_product_data($data, $user_id){		
		foreach($data as $key=>$productData){	
			$price=$productData['price'];
			$product=$productData['name'];
            $product_id=$this->advertisment_products_model->productFindOrSave($product, $price);
			if(!$this->check_product_exists($user_id, $product_id)){
				$advertisment_store_products=array(
					'created'=>date('Y-m-d h:i:s'),
					'user_id'=>$user_id,
					'product_id'=>$product_id,
					'price'=>$price,
					'is_active'=>1,
				);
				$this->db->insert('advertisment_store_products', $advertisment_store_products);	
			}
			else{
				$advertisment_store_products=array(
					'modified'=>date('Y-m-d h:i:s'),
					'price'=>$price
				);
				$this->db->where('user_id', $user_id);
				$this->db->where('product_id', $product_id);
				$a=$this->db->update('advertisment_store_products', $advertisment_store_products);	
			}
		}
		return true;
	}
	
	################## Get Product Details ##############
	public function get_product($userId, $id) {
	    $this->db->select('advertisment_store_products.id, advertisment_store_products.user_id,advertisment_store_products.created,advertisment_products.name,advertisment_store_products.price,advertisment_store_products.is_active');
		$this->db->where('advertisment_store_products.user_id',$userId);
		$this->db->where('advertisment_store_products.id',$id);
		$this->db->join('advertisment_products','advertisment_products.id=advertisment_store_products.product_id');
		$this->db->from('advertisment_store_products');
		$this->db->order_by('advertisment_store_products.created','DESC');
		$query = $this->db->get();			
		$result=$query->row_array();
		return $result;
	}
	
	############ Check Product Already Exist #############
	public function check_product_exists($user_id, $product_id){
		
		$this->db->select('advertisment_store_products.id, advertisment_store_products.user_id,advertisment_store_products.created,advertisment_store_products.is_active');
		$this->db->where('advertisment_store_products.user_id',$user_id);
		$this->db->where('advertisment_store_products.product_id',$product_id);
		$this->db->from('advertisment_store_products');
		$this->db->order_by('advertisment_store_products.created','DESC');
		$query = $this->db->get();			
		$result=$query->row_array();
		if(!empty($result)){
			return true;
		}
		return false;
	}
	
	################# Add Products ###################
	public function add_products($user_id){
		foreach($_POST['product_name'] as $key=>$product){	
			$price=$_POST['product_price'][$key];
            $product_id=$this->advertisment_products_model->productFindOrSave($product, $price);
			if(!$this->check_product_exists($user_id, $product_id)){
				$advertisment_store_products=array(
					'created'=>date('Y-m-d h:i:s'),
					'user_id'=>$user_id,
					'product_id'=>$product_id,
					'price'=>$price,
					'is_active'=>1,
				);
				$this->db->insert('advertisment_store_products', $advertisment_store_products);	
			}			
		}			
		return true;
	}
	
	################## Update Products ##############
	public function update_products($userId, $id){

	    	$price=$_POST['price'];
		$product=$_POST['name'];
		$is_active=0;
		if(isset($_POST['is_active']) && $_POST['is_active']!=''){
			$is_active=1;		
		}

		$product_id=$this->advertisment_products_model->productFindOrSave($product, $price);
		$advertisment_store_products=array(
				'modified'=>date('Y-m-d h:i:s'),
				'user_id'=>$userId,
				'product_id'=>$product_id,
				'price'=>$price,
				'is_active'=>$is_active
		);
		$this->db->where('id', $id);
		$a=$this->db->update('advertisment_store_products', $advertisment_store_products);	
		return true;
	}
	
    ################ Get Customer List ####################
	public function getProductList($userId,$limit_start=10,$limit_end=0) {
	    $this->db->select('SQL_CALC_FOUND_ROWS advertisment_store_products.id,advertisment_store_products.id,advertisment_store_products.product_id,advertisment_store_products.created,advertisment_products.name,advertisment_store_products.price,advertisment_store_products.is_active',false);
		if(isset($_POST['s_name']) && !empty($_POST['s_name']))
		{
			$this->db->like('advertisment_products.name',$_POST['s_name'],'after'); 
		}
		$this->db->where('advertisment_store_products.user_id',$userId);
		$this->db->join('advertisment_products','advertisment_products.id=advertisment_store_products.product_id');
		$this->db->from('advertisment_store_products');
		$this->db->order_by('advertisment_store_products.created','DESC');
		//$this->db->group_by('advertisment_store_products.product_id');
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
}
