<?php
class Common_model extends CI_Model {

	public function __construct(){ 
		parent::__construct();
    }

	function count_action($id=false,$count_field=false,$action=false,$table=false,$count =false){	
		$inc=1;
		if(!$count ){
			$string = str_replace("'","%27",  $count_field.$action.$inc);	
			$this->db->set($count_field,$string, FALSE);
		}else{
				$this->db->set($count_field,$count, FALSE);
		}
		$this->db->where('id', $id);
		$this->db->update($table);
		//echo $this->db->last_query();
		$insert = $this->db->insert_id() ;
		return $insert;
	}
}
?>