<?php
class Pages_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
	public function get_pages($flag , $conditions = array(), $sort_field=null, $order_type='Desc', $limit_start, $limit_end)
	{  
		$this->db->select('pages.id, pages.title,pages.content, pages.created');
		$this->db->from('pages');
		//$this->db->where('is_active', 1);
		
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
			$this->db->order_by('pages.id', $order_type);
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
	function get_values($id) {
		$this->db->select('id, title, content,meta_keywords,meta_description,is_active');
		$this->db->where('id', $id);
		$query = $this->db->get('pages');
		return $query->row_array();
	}
    public function add_new()
    {
		$alias =  url_title($this->input->post('name'), 'dash', TRUE);
		$data = array(
				'name'			=> $this->input->post('name'),
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'alias'  		=> $alias,
				'is_active'		=> $this->input->post('is_active')
			);
		$this->db->insert('pages', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? TRUE : FALSE;
    }
	public function edit($id)
	{
		$alias =  url_title($this->input->post('title'), 'dash', TRUE);
		$data = array(
				'modified' 			=> date('Y-m-d h:i:s'),
				'alias'  			=> $alias,
				'title'				=> $this->input->post('title'),
				'content'			=> $this->input->post('content'),
				'alias'  			=> $alias,
				'meta_keywords'		=> $this->input->post('meta_keywords'),
				'meta_description'	=> $this->input->post('meta_description')
			);
		$this->db->where('id', $id);
		$this->db->update('pages', $data);
	}
	
}
?>