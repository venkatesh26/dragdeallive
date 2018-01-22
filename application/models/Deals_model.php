<?php
class Deals_model extends CI_Model {
	
	#Front End - Deasls List
	public function get_deal_list($type=null,$limit_start=10, $limit_end=0){
		$this->db->select('SQL_CALC_FOUND_ROWS deals.id,deals.*',false);
		$this->db->where('deals.is_active','1');
		$this->db->from('deals');   
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
}