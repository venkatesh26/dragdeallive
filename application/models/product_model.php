<?php
class Product_model extends CI_Model {

	##### Get Product List ############
	public function getMyProductList($addId, $limit_start, $limit_end){
		
		$this->db->select('SQL_CALC_FOUND_ROWS advertisment_customer_products.id,advertisment_customer_products.*,products.name,products.price as mrp',false);
		$this->db->where('advertisment_customer_products.advertisment_id',$addId);
		$this->db->from('advertisment_customer_products');
		$this->db->join('products','products.id=advertisment_customer_products.product_id');
		$this->db->order_by('advertisment_customer_products.id','DESC');
		$this->db->limit($limit_start, $limit_end);
		$query = $this->db->get();
		$result=$query->result_array();
		$response=array();
		$newresult=array();
		foreach($result  as $key=>$res)
		{
			$newresult[$key]=array(date('d ,M Y',strtotime($res['created'])),ucwords($res['name']),$res['price']);
		}
		$response['iTotalDisplayRecords']=$this->get_all_rows();
		$response['iTotalRecords']=$this->get_all_rows();
		$response['data']=$newresult;
		return $response;	
	} 
}