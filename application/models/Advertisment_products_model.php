<?php
class Advertisment_products_model extends CI_Model {
	
	#Magic Method - Construct the object
    public function __construct(){
        parent::__construct();
    }
			
	######### Product Find Or Save ######## 
	public function productFindOrSave($name, $price=0){
		$table_data=array();
		$this->db->select('id');        
		$this->db->where('name',strtolower($name));
		$query = $this->db->get('advertisment_products');
		$res = $query->row();
		if(!empty($res)){
			return $res->id;
		}
		$table_data=array(
			'created'=>date('Y-m-d h:i:s'),
			'name'=>$name,
			'price'=>$price,
			'is_active'=>1
		);
		$this->db->insert('advertisment_products', $table_data);			
		return $this->db->insert_id();
	}
	
	############# Product Auto Complete ################
	public function product_auto_list($keyword,$user_id=null) {
		$this->db->like('name', $keyword,'after'); 
		$this->db->where('is_active','1');
		if($user_id!=''){
			$this->db->where('advertisment_store_products.user_id',$user_id);
			$this->db->join('advertisment_store_products','advertisment_store_products.product_id=advertisment_products.id');
		} 
		$this->db->select('id,name');
		$query = $this->db->get('advertisment_products');		
		$result = $query->result();	
		$arr = array();
		foreach($result as $g) {
			$arr[]=array('value'=> ucfirst($g->name),'id'=>$g->id);
		}
		return $arr;
	} 
}