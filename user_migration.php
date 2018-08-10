<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
	################ Create DB connection ###############
	
		$ci=& get_instance();
		$ci->load->database(); 
		
		$ci->db->select('users.email,users.id,user_profiles.first_name as name,users.profile_image,users.image_dir,user_profiles.mobile_number,user_profiles.last_name,user_profiles.address');
		$ci->db->where('users.id',$user_id);
		$ci->db->join('user_profiles', 'user_profiles.user_id = users.id', 'left');
		$ci->db->where('customer_id', NULL);
		$ci->db->order_by('id', 'ASC');
		$query = $ci->db->get('users');
		$row = $query->row_array();
		pr($row);die;
		
		foreach($row as $data){
			
			
			####################
		
			$customer_data = array(
				'created'		=> date('Y-m-d h:i:s'),
				'modified' 		=> date('Y-m-d h:i:s'),
				'first_name' 	=> $data['first_name'],
				'last_name' 	=> $data['last_name'],
				'mobile_number' => $data['contact_number'],
				'email'		=> strtolower($data['email']),
			);
			$ci->db->insert('advertisment_customers', $customer_data);
			$customer_id = $ci->db->insert_id();
			
			$ci->db->where('id', $data['id']);
			$updatedata['customer_id']=$customer_id;
			$ci->db->update('users', $updatedata);
		}



?>