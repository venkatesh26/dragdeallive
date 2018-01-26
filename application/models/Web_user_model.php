<?php
class Web_user_model extends CI_Model {
 
  
    public function __construct()
    {
        $this->load->database();
    }
		
	public function add($image_data,$email_act_id=null){
	    $data = array(
			'email'			=> strtolower($this->input->post('email')),			
 			'password'		=> md5($this->input->post('password')),
			'display_name' => $this->input->post('display_name'),
			'user_type'		=>'3',
			'profile_image'	=> $image_data['upload_data']['file_name'],				
			'image_dir'		=> $this->config->item('profile_url'),
			'image_info'	=> serialize($image_data),
			'is_approved' 	=> 1,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => 4,
			'is_active'		=> $this->input->post('is_active'),
			'uid'			=> $email_act_id,			
			'preferred_country_id'=>$this->input->post('select_country'),
			'preferred_state_id'=>$this->input->post('select_state'),
			'preferred_city_id'=>$this->input->post('select_city'),
			'preferred_area_id'=>$this->input->post('select_area')
		);
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();
		
		$selected_country=$this->input->post('select_country');
			$selected_state=$this->input->post('select_state');
			$selected_city=$this->input->post('select_city');

		if($id){
			$data = array(
				'user_id'			=> $id,	
				'address'			=> $this->input->post('address'),
				'mobile_number'		=> $this->input->post('mob_no'),
				'telephone_number'	=> $this->input->post('tele_no'),
				'first_name'		=> $this->input->post('first_name'),
				'last_name'			=> $this->input->post('last_name'),			
				'gender_id'			=> $this->input->post('gender'),	
				//'dob'				=> $this->input->post('dob'),				
				'created'			=> date('Y-m-d h:i:s'),
				'modified'			=> date('Y-m-d h:i:s'),
			);
			$this->db->insert('user_profiles', $data);
		}
		return (isset($id)) ? $id : FALSE;
	}
	
	public function subadmin_add(){
	    $data = array(
			'email'			=> strtolower($this->input->post('email')),			
 			'password'		=> md5($this->input->post('password')),
			'display_name' => $this->input->post('display_name'),
			'user_type'		=>'4',
			'is_approved' 	=> 1,
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'register_type' => 4,
			'is_active'		=> $this->input->post('is_active'),
		);
		$this->db->insert('users', $data);
		$id = $this->db->insert_id();

		if($id){
			$data = array(
				'user_id'			=> $id,	
				'mobile_number'		=> $this->input->post('mob_no'),
				'telephone_number'	=> $this->input->post('tele_no'),
				'first_name'		=> $this->input->post('first_name'),
				'gender_id'			=> $this->input->post('gender'),	
				'created'			=> date('Y-m-d h:i:s'),
				'modified'			=> date('Y-m-d h:i:s'),
			);
			$this->db->insert('user_profiles', $data);
		}
		return (isset($id)) ? $id : FALSE;
	}

	function get_values($id) {
		$this->db->select('users.id');
		$this->db->select('users.email');
		$this->db->select('users.created');
		$this->db->select('users.display_name');
		
		$this->db->select('users.preferred_country_id');
		$this->db->select('users.preferred_state_id');
		$this->db->select('users.preferred_city_id');
		$this->db->select('users.preferred_area_id');
		$this->db->select('users.register_type');
		
		$this->db->select('areas.name as preferred_area');
		$this->db->select('cities.name as preferred_city');
		$this->db->select('countries.name as preferred_country');
		$this->db->select('states.name as preferred_state');
		
		 
		$this->db->select('users.is_approved');
		$this->db->select('user_profiles.first_name');
		$this->db->select('user_profiles.last_name');
		$this->db->select('user_profiles.gender_id');		
		$this->db->select('user_profiles.mobile_number');
		
		$this->db->select('user_profiles.telephone_number');
		$this->db->select('user_profiles.address');
		$this->db->select('users.image_dir'); 
		$this->db->select('users.profile_image');
		
		$this->db->select('users.is_active');
		$this->db->where('users.id', $id);
		$this->db->from('users');
		$this->db->join('user_profiles', 'users.id = user_profiles.user_id', 'left');
				
		$this->db->join('areas', 'users.preferred_area_id = areas.id', 'left');	
		$this->db->join('countries', 'users.preferred_country_id = countries.id', 'left');	
		$this->db->join('cities', 'users.preferred_city_id = cities.id', 'left');	
		$this->db->join('states', 'users.preferred_state_id = states.id', 'left');	
		
		$this->db->group_by('users.id');
		$query = $this->db->get();		
		$hotel_profile = $query->row_array();
		
		$result=array(
				'profile'=>$hotel_profile
			);
		return $result;
	}
			
    public function get_user_users($flag , $conditions = array(), $sort_field=null, $order_type='Asc', $limit_start, $limit_end,$export=null) {
	   if($export=='')
		{
		$this->db->select('users.id,users.created,users.register_type,users.email,user_profiles.first_name,user_profiles.last_name,users.image_dir,users.profile_image,users.created,users.is_active,users.is_email_confirmed,user_profiles.gender_id, users.contact_number');
		$this->db->from('users');
		$this->db->join('user_profiles', 'users.id = user_profiles.user_id', 'left');
		$this->db->where('users.user_type', '3');
		}
		else
		{
			$this->db->select('users.id,users.created,users.email,user_profiles.first_name,user_profiles.last_name,users.image_dir,users.profile_image,users.created,users.is_active,users.is_email_confirmed,user_profiles.gender_id,user_profiles.mobile_number,user_profiles.telephone_number,user_profiles.address,cities.name as city_name, users.contact_number');
		    $this->db->from('users');
		    $this->db->join('user_profiles', 'users.id = user_profiles.user_id', 'left');
			$this->db->join('cities', 'cities.id = users.preferred_city_id', 'left');
		    $this->db->where('users.user_type', '3');
		}
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
			$this->db->order_by('users.id', $order_type);
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
	
	public function get_sub_admin_users($flag , $conditions = array(), $sort_field=null, $order_type='Asc', $limit_start, $limit_end,$export=null) {
	   if($export=='')
		{
		$this->db->select('users.id,users.created,users.email,user_profiles.first_name,user_profiles.last_name,users.image_dir,users.profile_image,users.created,users.is_active,users.is_email_confirmed,user_profiles.gender_id');
		$this->db->from('users');
		$this->db->join('user_profiles', 'users.id = user_profiles.user_id', 'left');
		$this->db->where('users.user_type', '4');
		}
		else
		{
			$this->db->select('users.id,users.created,users.email,user_profiles.first_name,user_profiles.last_name,users.image_dir,users.profile_image,users.created,users.is_active,users.is_email_confirmed,user_profiles.gender_id,user_profiles.mobile_number,user_profiles.telephone_number,user_profiles.address,cities.name as city_name');
		    $this->db->from('users');
		    $this->db->join('user_profiles', 'users.id = user_profiles.user_id', 'left');
			$this->db->join('cities', 'cities.id = users.preferred_city_id', 'left');
		    $this->db->where('users.user_type', '4');
		}
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
			$this->db->order_by('users.id', $order_type);
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
	
    function count_webusers($user_id=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('users');
		if($user_id != null && $user_id != 0){
			$this->db->where('id', $user_id);
		}
		if($search_string){
			$this->db->like('address', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

	public function update($id,$image_data) {

		$data=array(
			'preferred_country_id'=>$this->input->post('select_country'),
			'preferred_state_id'=>$this->input->post('select_state'),
			'preferred_city_id'=>$this->input->post('select_city'),
			'preferred_area_id'=>$this->input->post('select_area'),
                        'is_active'=>$this->input->post('is_active')		
		);
		
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		
		$data = array(			
			'address'						=> $this->input->post('address'),	
			'mobile_number'			=> $this->input->post('mob_no'),
			'telephone_number'		=> $this->input->post('tele_no'),
			'first_name'					=> $this->input->post('first_name'),
		//	'last_name'					=> $this->input->post('last_name'),	
			'gender_id'						=> $this->input->post('gender'),	
			//'dob'								=> $this->input->post('dob'),	
			'modified' 						=> date('Y-m-d h:i:s'),
			
		);

		$this->db->where('user_id', $id);
		$this->db->update('user_profiles', $data);
		
		$data = array(			
			'profile_image'		=> $image_data['upload_data']['file_name'],				
				'image_dir'			=> $this->config->item('profile_url'),
				'image_info'		=> serialize($image_data)
			);
		$this->db->where('id', $id);
		$this->db->update('users', $data);		
		return true;
	}
	
	public function update_subadmin($id,$image_data) {

		$data = array(			
			'address'			=> $this->input->post('address'),	
			'mobile_number'		=> $this->input->post('mob_no'),
			'telephone_number'	=> $this->input->post('tele_no'),
			'first_name'		=> $this->input->post('first_name'),
			'gender_id'			=> $this->input->post('gender'),	
			'modified' 			=> date('Y-m-d h:i:s')
			
		);

		$this->db->where('user_id', $id);
		$this->db->update('user_profiles', $data);
		return true;
	}
	public function update_subadmin_status($id,$status)
	 {
                $data['is_active']=$status;
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return 1;
	}
	public function edit_user_info($location=null,$data=null,$image_data=null) {
		$this->db->where('id',  $this->session->userdata('user_id'));
		$this->db->update('users', $location);
		
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update('user_profiles', $data);
		
		
		if(!empty( $image_data['upload_data']['file_name'] ) ) {
			$data = array(			
				'profile_image'		=> $image_data['upload_data']['file_name'],				
				'image_dir'			=> $this->config->item('profile_url'),
				'image_info'		=> serialize($image_data)
			);
			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
		}
		
		return true;
	}

   	public function update_status($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		
	    return true; 
	}
	
	function get_user_name($id) {
		$this->db->select('user_profiles.first_name,user_profiles.last_name,
		users.display_name,user_profiles.gender_id');
		$this->db->where('users.id', $id);
		$this->db->join('user_profiles', 'users.id = user_profiles.user_id', 'right');
		$this->db->from('users');
		$query = $this->db->get();
		$user_profile = $query->row_array();
		return $user_profile;
	}
        function get_user_wish_list($user_id,$field='null',$order="null")
        {
          $this->db->select('wishlists.id as wish_list_id,offers.created,
                             offers.offer_type,offers.offer_name,
                             offers.booking_start_date,offers.booking_end_date,
                             offers.offer_start_date,offers.offer_end_date,
                             offers.bidding_start_amount,offers.id as offer_id,
                             offers.current_rate,offers.offer_price,
                             offers.msrp_price,offers.current_rate,
                             hotels.name as hotel_name,hotels.hotel_id,users.display_name');
          $this->db->from('wishlists');
          $this->db->where('wishlists.user_id',$user_id);
          if($field=='id' && $order=='asc')
          {
             $this->db->order_by('wishlists.id','desc');
          }
          else if($field !='' && $order !='')
          {
            $this->db->order_by('offers.'.$field.'',$order);
          }
          else
          {
            $this->db->order_by('wishlists.id','desc');
           }
           $this->db->join('offers', 'offers.id = wishlists.offer_id', 'left');
           $this->db->join('hotels', 'hotels.hotel_id = offers.hotel_id', 'left');
           $this->db->join('users', 'users.id = hotels.hotel_id', 'left');
           $query = $this->db->get();
           $wishlist_offers=$query->result_array();
           return $wishlist_offers;
        } 
        function get_user_wish_list_after_delete($id)
        {
			 $notificate_type = $this->config->item('notification_type');
             $this->db->select('wishlists.id,wishlists.user_id,wishlists.offer_id,offers.hotel_id');
             $this->db->from('wishlists');
             $this->db->where('wishlists.id',$id);
			 $this->db->join('offers', 'offers.id = wishlists.offer_id', 'left');
			 $query = $this->db->get();
             $wishlist_offers=$query->row_array();
			 if(!empty($wishlist_offers))
			 {
		     notification_status($wishlist_offers['offer_id'],$wishlist_offers['user_id'],$wishlist_offers['hotel_id'],$notificate_type[1],$this->config->item('user_remove_wishlist'),'1','');
		     $this->db->delete('wishlists',array('id' => $id));
			 }
             return 1;
        }
        function get_user_follow_list($user_id,$page_num=null)
        {
            if($page_num==null || $page_num=='')
			{
			$page_num = 1;
			}
           $limit_start= ($page_num-1) * 15;
		   $limit_end =15;
            $this->db->select('hotel_follows.id,hotels.name,hotels.hotel_id as hotel_id,users.profile_image,users.image_dir');
            $this->db->from('hotel_follows');
            $this->db->where('hotel_follows.user_id',$user_id);
            $this->db->join('users', 'users.id = hotel_follows.hotel_id', 'left');
            $this->db->join('hotels', 'hotels.hotel_id = hotel_follows.hotel_id', 'left');
			$this->db->order_by('hotel_follows.id','desc');
			if($page_num !='no-limit')
			{
			$this->db->limit($limit_end, $limit_start);
			}
            $query = $this->db->get();
            $follows=$query->result_array();
            return $follows;
        }
        function get_user_follow_list_after_delete($id)
        {
           $this->db->delete('hotel_follows',array('id' => $id));
           return 1;
        }
        public function add_follow($user_id,$hotel_id,$login_page=null)
        {
		     $flag=0;
             $this->db->select('hotel_follows.id');
             $this->db->from('hotel_follows');
             $this->db->where('hotel_follows.user_id',$user_id);
             $this->db->where('hotel_follows.hotel_id',$hotel_id);
             $query = $this->db->get();
             $count = $query->num_rows(); 
			 $notificate_type = $this->config->item('notification_type');
             if($count >=1):
			 if($login_page==''):
             $this->db->delete('hotel_follows',array('user_id' => $user_id,'hotel_id'=>$hotel_id));
			 notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[2],$this->config->item('user_unfollow_hotel'),'2','');
             endif;
			 $flag=0;
             else:
             $data = array(
			'created' =>  date('Y-m-d h:i:s'),	
 			'user_id' => $user_id,
                        'hotel_id' => $hotel_id,
                        'is_active' =>1,

		     );
	        $this->db->insert('hotel_follows', $data);
			notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[2],$this->config->item('user_follow_hotel'),'2','');
            $flag=1;
              endif;
              return $flag;
        }
       public function check_follows($user_id,$hotel_id)
       {
             $flag=0;
             if($user_id!='' && $hotel_id !='')
             {
             $this->db->select('hotel_follows.id');
             $this->db->from('hotel_follows');
             $this->db->where('hotel_follows.user_id',$user_id);
             $this->db->where('hotel_follows.hotel_id',$hotel_id);
             $query = $this->db->get();
             $count = $query->num_rows(); 
             if($count >=1){
             $flag=1;
             }
             else
             {
             $flag=0;
             }
             }
            return $flag;
       }
     public function hotel_follow_counts($hotel_id)
     {
             $count=0;
             if($hotel_id !='')
             {
             $this->db->select('hotel_follows.id');
             $this->db->from('hotel_follows');
             $this->db->where('hotel_follows.hotel_id',$hotel_id);
             $query = $this->db->get();
             $count = $query->num_rows(); 
             }
            return  $count;
     }
        public function add_wish_list($user_id,$offer_id,$login_page=null)
        {
             $this->db->select('wishlists.id');
             $this->db->from('wishlists');
             $this->db->where('wishlists.user_id',$user_id);
             $this->db->where('wishlists.offer_id',$offer_id);
             $query = $this->db->get();
             $count = $query->num_rows(); 
			 
			 $this->db->select('offers.hotel_id');
			 $this->db->where('offers.id',$offer_id);
			 $get_hotel = $this->db->get('offers');
			 $hotel_id = $get_hotel->row_array();
			 //pr($hotel_id);die;
			  $notificate_type = $this->config->item('notification_type');
             if($count >=1):
			 if($login_page==''):
             $this->db->delete('wishlists',array('user_id' => $user_id,'offer_id'=>$offer_id));
			 notification_status($offer_id,$user_id,$hotel_id['hotel_id'],$notificate_type[1],$this->config->item('user_remove_wishlist'),'1','');
             endif;
			 $flag=0;
             else:
             $data = array(
			'created' =>  date('Y-m-d h:i:s'),	
 			'user_id' => $user_id,
                        'offer_id' => $offer_id,
                        'is_active' =>1,

		    );
	      $this->db->insert('wishlists', $data);
		  notification_status($offer_id,$user_id,$hotel_id['hotel_id'],$notificate_type[1],$this->config->item('user_added_wishlist'),'1','');
              $flag=1;
              endif;
              return $flag;
        }
       public function check_wishlists($user_id,$offer_id)
       {
             $flag=0;
             if($user_id!='' && $offer_id !='')
             {
             $this->db->select('wishlists.id');
             $this->db->from('wishlists');
             $this->db->where('wishlists.user_id',$user_id);
             $this->db->where('wishlists.offer_id',$offer_id);
             $query = $this->db->get();
             $count = $query->num_rows(); 
             if($count >=1){
             $flag=1;
             }
             else
             {
             $flag=0;
             }
             }
            return $flag;
       }
       public function add_like_dislike($user_id,$hotel_id,$login_page=null)
        {
		     $notificate_type = $this->config->item('notification_type');
             $flag=0;
             if($user_id!='' && $hotel_id !='')
             {   
             $this->db->select('hotel_likes_dislikes.id,hotel_likes_dislikes.type');
             $this->db->from('hotel_likes_dislikes');
             $this->db->where('hotel_likes_dislikes.user_id',$user_id);
             $this->db->where('hotel_likes_dislikes.hotel_id',$hotel_id);
             $query = $this->db->get();
             $likes = $query->result_array(); 
             $likes_count = $query->num_rows(); 
             if($likes_count==0)
             {
                 $data = array(
			'created' =>  date('Y-m-d h:i:s'),	
 			'user_id' => $user_id,
                        'hotel_id' => $hotel_id,
                        'type' => 1,
                        'is_active' =>1,
		      );
	         $this->db->insert('hotel_likes_dislikes', $data);
			 notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[4],$this->config->item('user_like_hotel'),'4','');
              $flag=1;
             }
             else
             { 
                $type=1;
                $flag=1;
                if($likes[0]['type']==1)
                {
                 $type=2;
                 $flag=2;
                 }
				 if($login_page==1)
				 {
				    $type=1;
				 }
				 if($type==1)
				 {
				  notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[4],$this->config->item('user_like_hotel'),'4','');
				 }
				 else
				 {
				  notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[5],$this->config->item('user_unlike_hotel'),'5','');
				  }
            $data = array(
			'modified' =>  date('Y-m-d h:i:s'),	
 			'user_id' => $user_id,
                        'hotel_id' => $hotel_id,
                        'type' => $type,
                        'is_active' =>1,
		      );
	        $this->db->where('id', $likes[0]['id']);
		    $this->db->update('hotel_likes_dislikes', $data);
	
             }
                return $flag;
         }  
        }
       public function check_likes($user_id,$hotel_id)
       {
             $flag=0;
             if($user_id!='' && $hotel_id !='')
             {
             $this->db->select('hotel_likes_dislikes.id,hotel_likes_dislikes.type');
             $this->db->from('hotel_likes_dislikes');
             $this->db->where('hotel_likes_dislikes.user_id',$user_id);
             $this->db->where('hotel_likes_dislikes.hotel_id',$hotel_id);
             $query = $this->db->get();
             $count = $query->num_rows(); 
             $likes_type = $query->result_array(); 
             if($count >=1 && $likes_type[0]['type']==1)
             {
             $flag=1;
             }
             else if($count >=1 && $likes_type[0]['type']==2)
             {
             $flag=2;
             }
             else
             {
             $flag=0;
             }
            }
            return $flag;
       }
      public function hotel_likes_counts($hotel_id)
      {
             $this->db->select('hotel_likes_dislikes.id,hotel_likes_dislikes.type');
             $this->db->from('hotel_likes_dislikes');
             $this->db->where('hotel_likes_dislikes.hotel_id',$hotel_id);
             $this->db->where('hotel_likes_dislikes.type','1');
             $query = $this->db->get();
             $count = $query->num_rows(); 
             return $count;
       }
      public function hotel_unlikes_counts($hotel_id)
      {
             $this->db->select('hotel_likes_dislikes.id,hotel_likes_dislikes.type');
             $this->db->from('hotel_likes_dislikes');
             $this->db->where('hotel_likes_dislikes.hotel_id',$hotel_id);
             $this->db->where('hotel_likes_dislikes.type','2');
             $query = $this->db->get();
             $count = $query->num_rows(); 
             return $count;
      }
	 
	   

      public function my_current_bids($user_id,$field='null',$order="null")
      {
         $today = date('Y-m-d H:i:s');
         $time=$this->session->userdata('local_time_zone_name');
         $today = ConvertGMTToLocalTimezone($today,$time);
         $this->db->select('bids.id,bids.created,offers.offer_name,offers.msrp_price,bids.bid_value,
                            offers.current_rate,offers.bidding_start_amount,
                            offers.booking_start_date,offers.booking_end_date,offers.id as offer_id,
                            hotels.name as hotel_name,
                            cities.name as city_name');
         $this->db->from('bids');
         $this->db->where('bids.user_id',$user_id);
         $this->db->where('bids.is_active','1');
         $this->db->where('offers.offer_type','3');
         $this->db->where('offers.is_active','1');
         $this->db->where("DATE_FORMAT(offers.booking_start_date,'%Y-%m-%d  %H:%i:%s') <= '".$today."'");
         $this->db->where("DATE_FORMAT(offers.booking_end_date,'%Y-%m-%d  %H:%i:%s') >= '".$today."'");
		 $this->db->join('offers', 'offers.id = bids.offer_id', 'left');
         $this->db->join('hotels', 'hotels.hotel_id = offers.hotel_id', 'left');
         $this->db->join('users', 'users.id = hotels.hotel_id', 'left');
         $this->db->join('cities', 'cities.id = users.preferred_city_id', 'left');
         if($field =='' && $order =='')
          {
            $this->db->order_by('bids.id','desc');
          }
         else if($field=='created' || $field=='bid_value' || $field=='bid_status')
         {
           $this->db->order_by('bids.'.$field,$order);
         }
		  else if($field =='id' && $order =='desc')
          {
            $this->db->order_by('bids.id','desc');
          }
         else
         {
            $this->db->order_by('offers.'.$field,$order);
         }
         $query = $this->db->get();
         $bids=$query->result_array();
         return $bids;
      }
	   public function my_completed_bids($user_id,$field='null',$order="null")
      {
	     
         $today = date('Y-m-d H:i:s');
         $time=$this->session->userdata('local_time_zone_name');
         $today = ConvertGMTToLocalTimezone($today,$time);
         $this->db->select('bids.id,bids.created,offers.offer_name,offers.msrp_price,
		                   bids.bid_value,bids.bid_status,
                            offers.current_rate,offers.bidding_start_amount,
                            offers.booking_start_date,offers.booking_end_date,offers.id as offer_id,
                            hotels.name as hotel_name,
                            cities.name as city_name');
         $this->db->from('bids');
         $this->db->where('bids.user_id',$user_id);
         $this->db->where('bids.is_active','1');
         $this->db->where('offers.offer_type','3');
         $this->db->where('offers.is_active','1');
		 $this->db->where("DATE_FORMAT(offers.booking_end_date,'%Y-%m-%d  %H:%i:%s') < '".$today."'");
		 $this->db->join('offers', 'offers.id = bids.offer_id', 'left');
         $this->db->join('hotels', 'hotels.hotel_id = offers.hotel_id', 'left');
         $this->db->join('users', 'users.id = hotels.hotel_id', 'left');
         $this->db->join('cities', 'cities.id = users.preferred_city_id', 'left');
         if($field =='' && $order =='')
          {
            $this->db->order_by('bids.id','desc');
          }
         else if($field=='created' || $field=='bid_value' || $field=='bid_status')
         {
           $this->db->order_by('bids.'.$field,$order);
         }
         else
         {
            $this->db->order_by('offers.'.$field,$order);
         }
         $query = $this->db->get();
         $bids=$query->result_array();
         return $bids;
    }
	public function add_bids_user($user_id,$offer_id,$price) {
	    $price_flag=0;
	    if(!empty($offer_id)) {
			$this->db->select('offers.current_rate,offers.msrp_price,offers.bidding_start_amount');
			$this->db->from('offers');
			$this->db->where('offers.id', $offer_id);
			$query = $this->db->get();
			$offers=$query->row_array();
			if($offers['current_rate'] ==0 &&   $price <= $offers['bidding_start_amount']) {
				$price_flag=0;
				$current_price=$offers['bidding_start_amount'];
				$o_price=$offers['msrp_price'];
			} else if($offers['current_rate'] >= $price) {
				$price_flag=0;
				$current_price=$offers['current_rate'];
				$o_price=$offers['msrp_price'];
			} else {
				$price_flag=1;
				$current_price=$offers['current_rate'];
				$o_price=$offers['msrp_price'];
			}
		}
		if($price_flag && !empty($offer_id) && !empty($user_id)) {
			$this->db->select('bids.id');
			$this->db->from('bids');
			$this->db->where('bids.offer_id', $offer_id);
			$this->db->where('bids.user_id', $user_id);
			$query = $this->db->get();
			$bids=$query->row_array();
			if(!empty($bids)) {
				$data=array(
					'modified'=>date('Y-m-d H:i:s'),
					'bid_value'=>$price,
					 );
				$this->db->where('bids.id', $bids['id']);
				$this->db->update('bids', $data);
				 $offer_data=array(
					'current_rate'=>$price,
				 );
				$this->db->where('offers.id', $offer_id);
				$this->db->update('offers', $offer_data);
				$data=array();
				$data['current_price']=currency_convert($price);
				$data['update']='1';
				$data['message']=ucfirst($this->lang->line('you successfully bidded'));
				$flag=$data;
			} else {
			  $data = array(			
					'created'		=> date('Y-m-d h:i:s'),	
					'modified'		=> date('Y-m-d h:i:s'),
					'user_id'		=> $user_id,
					'offer_id'		=> $offer_id,
					'bid_amount'    => $o_price,
					'bid_value'		=> $price,
					'is_active'    => 1,
				);  
			   $this->db->insert('bids', $data);
			   $offer_data=array(
				'current_rate'=>$price,
			   );
				$this->db->where('offers.id', $offer_id);
				$this->db->update('offers', $offer_data);
				$data=array();
				$data['current_price']=currency_convert($price);
				$data['update']='1';
				$data['message']=ucfirst($this->lang->line('you successfully bidded'));
				$flag=$data;
			}
		} else {
			if($price_flag==0) {
				$data=array();
				$data['current_price']=currency_convert($current_price);
				$data['update']='0';
				$data['message']=ucfirst($this->lang->line('invalid amount'));
				$flag=$data;
			} else {
				$data['current_price']=0;
				$data['update']='0';
				$data['message']=ucfirst($this->lang->line('invalid amount'));
				$flag=$data;
			}
		}
		return $flag;
	}
    
	public function get_likes_count(){
		$this->db->where('user_id',$this->session->userdata('user_id'));
		return $this->db->count_all_results('hotel_likes_dislikes');
	}
	
	public function get_user_review_list($user_id) {
		$data=array();
		$this->db->select('hotel_comments.created,hotel_comments.user_id,hotel_comments.hotel_id,hotel_comments.comments,hotel_comments.title,hotel_comments.rating,hotels.name,hotel_comments.negative_comments');
		$this->db->from('hotel_comments');
		$this->db->where('hotel_comments.user_id',$user_id);
		$this->db->where('hotel_comments.is_active','1');
		$this->db->join('hotels', 'hotels.hotel_id = hotel_comments.hotel_id', 'left');
		$query = $this->db->get();
		$reviews=$query->result_array();
		if(!empty($reviews)) {
			foreach($reviews as $r) {
				$this->db->select('hotel_banners.image_name,hotel_banners.image_dir');
				$this->db->from('hotel_banners');
				$this->db->where('hotel_banners.hotel_id',$r['hotel_id']);
				$this->db->where('hotel_banners.is_display','1');
				$this->db->limit('1');
				$query = $this->db->get();
				$banners=$query->row_array();
				$data[]=array_merge($r,$banners);
			}
		}
		return  $data;
	}
	function upload_profile_image($image_data)
	{
	  	if(!empty( $image_data['upload_data']['file_name'] ) ) {
			$data = array(			
				'profile_image'		=> $image_data['upload_data']['file_name'],				
				'image_dir'			=> $this->config->item('profile_url'),
				'image_info'		=> serialize($image_data)
			);
			$this->db->where('id', $this->session->userdata('user_id'));
			$this->db->update('users', $data);
		}
		return true;
	}
	public function add_review($user_id,$hotel_id) {
		$notificate_type = $this->config->item('notification_type');
		$this->db->select('hotel_comments.id');
		$this->db->from('hotel_comments');
		$this->db->where('hotel_comments.user_id',$user_id);
		$this->db->where('hotel_comments.hotel_id',$hotel_id);
		$query = $this->db->get();
		$comments = $query->result_array(); 
		$count = $query->num_rows(); 
		if($count >=1) {
			$data = array(			
				'modified'			=> date('Y-m-d h:i:s'),			
				'user_id'			=> $user_id,
				'hotel_id'			=> $hotel_id,
				'title'				=> $_POST['title'],
				'comments'			=> $_POST['comments'],
				'negative_comments'	=> $_POST['negative_comments'],
				'rating '			=> $_POST['rating'],
				'is_active'    		=> 0,
			);  
			$this->db->where('id', $comments[0]['id']);
			$this->db->update('hotel_comments', $data);
			notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[6],$this->config->item('user_review_hotel'),'6','');
		} else {
			$data = array(			
				'created'		=> date('Y-m-d h:i:s'),			
				'user_id'		=> $user_id,
				'hotel_id'		=> $hotel_id,
				'title'		    =>$_POST['title'],
				'comments'		=> $_POST['comments'],
				'negative_comments'	=> $_POST['negative_comments'],
				'rating '       =>$_POST['rating'],
				'is_active'    => 0,
			);  
		   $this->db->insert('hotel_comments', $data);
		   notification_status($hotel_id,$user_id,$hotel_id,$notificate_type[6],$this->config->item('user_review_hotel'),'6','');
		}
		return true;
	}
	public function check_user_exists($hotel_name) {
		$data=array();
		if(!empty($hotel_name)) {
			$this->db->select("users.id,hotels.name");
			$this->db->select("hotels.name as name");
			$this->db->from('users');
			$this->db->where('hotels.name =', $hotel_name);
			$this->db->where('users.is_active','1'); 
			$this->db->where('users.user_type','2'); 
			$this->db->join('hotels', 'hotels.hotel_id = users.id', 'left');
			$query = $this->db->get();
			$users =$query->row_array();  			  
			$count=$query->num_rows();  
			if($count >=1) {
				$data['user_id']=$users['id'];
				$data['success']=1;
			} else {
				$this->db->select("users.id");
				$this->db->from('users');
				$this->db->where('users.display_name =', $hotel_name);
				$this->db->where('users.is_active','1'); 
				$this->db->where_in('users.user_type',array('1','2'));
				$query = $this->db->get();
				$users =$query->row_array();  			  
				$count=$query->num_rows();
				if($count>=1){
					$data['user_id']=$users['id'];
					$data['success']=1;
				} else {
					$data['user_id']=0;
					$data['success']=0;
				}
			}  
		} else {
			$data['user_id']=0;
			$data['success']=0;
		}
		return $data; 
	}
	public function add_message($hotel_user_id,$user_id)
	{
	  $data = array(			
				'created'		=> date('Y-m-d h:i:s'),			
				'from_user_id'	=> $user_id,
				'to_user_id'	=> $hotel_user_id,
				'message'	    => $_POST['message'],
				'is_read'		=> '0',
				'is_active'		=> '1',
				'is_main'		=> '0',
				'is_high_important'=>$_POST['high_important'],
				'message_type'     => 1,
			);  
	   $this->db->insert('messages', $data);
	   return 1;
	}
	public function user_sent_message($user_id,$keyword)
	{
	        $this->db->select('messages.id,messages.created,messages.is_high_important,
			messages.message,
			users.display_name,
			users.profile_image,users.image_dir,hotels.name as hotel_name');
            $this->db->from('messages');
            $this->db->where('messages.from_user_id',$user_id);
			$this->db->where('messages.message_type','1');
			$this->db->where('messages.is_active','1');
			$this->db->where('messages.from_delete','0');
			$this->db->where('messages.is_main','0');
			$this->db->order_by('messages.id','desc');
			 if(!empty($keyword))
		    {
		      $exp_keyword=explode(' ',str_replace('%20',' ',$keyword));
		      if(count($exp_keyword) >= 1)
		     {
		      foreach($exp_keyword as $k)
		      {
		        $this->db->where('(`message` LIKE \'%'.$k.'%\' OR `name` LIKE \'%'.$k.'%\')', NULL, FALSE);
		       }
		    }
		   else
		   {
		     $this->db->where('(`message` LIKE \'%'.$keyword.'%\' OR `name` LIKE \'%'.$keyword.'%\')', NULL, FALSE);
		   }
		   } 
			$this->db->join('users', 'users.id = messages.to_user_id', 'left');
			$this->db->join('hotels', 'hotels.hotel_id = messages.to_user_id', 'left');
            $query = $this->db->get();
            $messages=$query->result_array();
            return $messages;
	}
	public function user_inbox_message($user_id,$keyword='')
	{
	       $this->db->select('messages.id,messages.created,messages.is_high_important,
			messages.message,messages.is_read,messages.is_high_important,
			users.display_name,
			users.profile_image,users.image_dir,hotels.name as hotel_name');
            $this->db->from('messages');
            $this->db->where('messages.to_user_id',$user_id);
			$this->db->where('messages.message_type','1');
			$this->db->where('messages.is_active','1');
			$this->db->where('messages.to_delete','0');
			$this->db->where('messages.is_main','0');
			if(!empty($keyword))
		    {
		      $exp_keyword=explode(' ',str_replace('%20',' ',$keyword));
		      if(count($exp_keyword) >= 1)
		     {
		      foreach($exp_keyword as $k)
		      {
		        $this->db->where('(`message` LIKE \'%'.$k.'%\' OR `name` LIKE \'%'.$k.'%\')', NULL, FALSE);
		       }
		    }
		   else
		   {
		     $this->db->where('(`message` LIKE \'%'.$keyword.'%\' OR `name` LIKE \'%'.$keyword.'%\')', NULL, FALSE);
		   }
		   } 
			$this->db->order_by('messages.id','desc');
			$this->db->join('users', 'users.id = messages.from_user_id', 'left');
			$this->db->join('hotels', 'hotels.hotel_id = messages.from_user_id', 'left');
            $query = $this->db->get();
            $messages=$query->result_array();
            return $messages;
	}
	public function user_inbox_count($user_id,$is_high=null) {
		$this->db->select('messages.id');
		$this->db->from('messages');
		$this->db->where('messages.to_user_id',$user_id);
		$this->db->where('messages.message_type','1');
		$this->db->where('messages.is_main','0');
		$this->db->where('messages.is_read','0');   
		$this->db->where('messages.to_delete','0');
		if($is_high=="Yes"){
			$this->db->where('messages.is_high_important','1');
		}		
		$query = $this->db->get();
		$messages=$query->num_rows();
		return $messages;
	}
	public function user_chat_message($id,$page) {
		$this->db->select('messages.id,messages.created,messages.is_high_important,
		messages.message,messages.is_read,messages.from_user_id,messages.to_user_id,
		users.display_name,
		users.profile_image,users.image_dir,hotels.name as hotel_name,user_profiles.first_name');
		$this->db->from('messages');
		$where = "(messages.id=".$id." or messages.is_main = ".$id.")";
		$this->db->where($where);
		$this->db->where('messages.message_type','1');
		$this->db->where('messages.is_active','1');
		$check_where = "(messages.to_user_id=".$this->session->userdata('user_id')." or messages.from_user_id = ".$this->session->userdata('user_id').")";
		$this->db->where($check_where);

		if($page=='inbox-message') {
			$this->db->where('messages.to_delete','0');
			$this->db->join('users', 'users.id = messages.from_user_id', 'left');
			$this->db->join('user_profiles', 'user_profiles.user_id = messages.from_user_id', 'left');
		} else {
			$this->db->join('users', 'users.id = messages.from_user_id', 'left');
			$this->db->join('user_profiles', 'user_profiles.user_id = messages.from_user_id', 'left');
		}
		$this->db->order_by('messages.id','asc');
		$this->db->join('hotels', 'hotels.hotel_id = messages.from_user_id', 'left');
		$query = $this->db->get();
		$messages=$query->result_array();
		return $messages;
	}
	
	public function user_readmessage_update($id)
	{
	   $data=array(
			'is_read'=>1,
		);
		$this->db->where('id', $id);
		$this->db->update('messages', $data);
		return 1;
	}
	public function user_notemessage_update($id)
	{
	   $data=array(
			'is_read'=>1,
		);
		$this->db->where('id', $id);
		$this->db->update('notifications', $data);
		return 1;
	}
	public function delete_message($id)
	{
		$data=array(
			'messages.from_delete'=>1,
		);
		$this->db->where('id', $id);
		$this->db->update('messages', $data);
		return 1;
	}
	public function inbox_delete_message($id)
	{
		$data=array(
			'messages.to_delete'=>1,
		);
		$this->db->where('id', $id);
		$this->db->update('messages', $data);
		return 1;
	}
	public function note_delete_message($id)
	{
		$data=array(
			'notifications.to_delete'=>1,
		);
		$this->db->where('id', $id);
		$this->db->update('notifications', $data);
		return 1;
	}
	public function user_info($user_id)
	{
	        $this->db->select('users.id,users.display_name,user_profiles.first_name,users.profile_image,users.image_dir,');
            $this->db->from('users');
			$this->db->where('users.id',$user_id);
			$this->db->join('user_profiles', 'user_profiles.user_id = users.id', 'left');
            $query = $this->db->get();
            $users=$query->row_array();
            return $users;
	}
	public function user_reply_message_save($user_id)
	{
	    $data = array(			
				'created'		=> date('Y-m-d h:i:s'),			
				'from_user_id'	=> $user_id,
				'to_user_id'	=> $_POST['reply_user_id'],
				'message'	    => $_POST['message'],
				'is_read'		=> '0',
				'is_active'		=> '1',
				'is_main'		=> $_POST['message_id'],
				'message_type'     => 1,
			);  
	   $this->db->insert('messages', $data);
	   return 1;
	}
	public function get_user_order_list($user_id,$field='null',$order="null",$page=null) {
		$this->db->select('orders.id,orders.created,orders.order_status,orders.amount,
	                   orders.transaction_id,offers.offer_name,offers.offer_type,
	                   offers.msrp_price,offers.offer_price,offers.current_rate,
					   offers.bidding_start_amount,offers.offer_start_date,
					   offers.booking_status,offers.cancel_last_date,
					   offers.offer_end_date,hotels.name as hotel_name,hotels.hotel_id as hotel_id');
		$this->db->from('orders');
		$this->db->where('orders.user_id',$user_id);
		$this->db->where('offers.is_active','1');
		if($page=="dashboard") {
			$this->db->where('orders.order_status','1');
		}
		if($field=='id' && $order=='asc') {
			$this->db->order_by('orders.id','desc');
		} else if($field=='created' ||  $field=='amount') {
			$this->db->order_by('orders.'.$field.'',$order);
		} else if($field !='' && $order !='') {
			$this->db->order_by('offers.'.$field.'',$order);
		} else {
			$this->db->order_by('offers.id','desc');
		}
		$this->db->join('offers', 'offers.id = orders.offer_id', 'left');
		$this->db->join('hotels', 'hotels.hotel_id = offers.hotel_id', 'left');
		$query = $this->db->get();
		$orders=$query->result_array();
		return $orders;
	}
	public function saved_search_list($user_id,$field='null',$order="null",$page=null) {
		$this->db->select('save_filter.id,save_filter.created,save_filter.keyword');
		$this->db->from('save_filter');
		$this->db->where('save_filter.user_id',$user_id);
		$this->db->where('save_filter.is_deleted','0');
		
		if($field=='id' && $order=='asc') {
			$this->db->order_by('save_filter.id','desc');
		} else if($field=='created') {
			$this->db->order_by('save_filter.'.$field.'',$order);
		} else {
			$this->db->order_by('save_filter.id','desc');
		}
		$query = $this->db->get();
		$filters=$query->result_array();
		return $filters;
	}
	public function get_filter_data($user_id,$filter_id) {
		$this->db->select('save_filter.keyword');
		$this->db->where('save_filter.user_id',$user_id);
		$this->db->where('save_filter.id',$filter_id);
		$this->db->where('save_filter.is_deleted','0');
		$this->db->from('save_filter');
		
		$query = $this->db->get();
		$filters=$query->row();
		$num_row = $query->num_rows();
		if($num_row){
			return $filters->keyword;
		} else {
			return false;
		}
		//return $filters;
	}
	public function get_user_notification($user_id,$keyword)
	{
	        $this->db->select('notifications.id,notifications.created,
			notifications.message,notifications.is_read,
			users.display_name,
			users.profile_image,users.image_dir,hotels.name as hotel_name');
            $this->db->from('notifications');
            $this->db->where('notifications.to_user_id',$user_id);
			$this->db->where('notifications.is_active','1');
			$this->db->where('notifications.to_delete','0');
			if(!empty($keyword))
		    {
		      $exp_keyword=explode(' ',str_replace('%20',' ',$keyword));
		      if(count($exp_keyword) >= 1)
		     {
		      foreach($exp_keyword as $k)
		      {
		        $this->db->where('(`message` LIKE \'%'.$k.'%\' OR `name` LIKE \'%'.$k.'%\')', NULL, FALSE);
		       }
		    }
		   else
		   {
		     $this->db->where('(`message` LIKE \'%'.$keyword.'%\' OR `name` LIKE \'%'.$keyword.'%\')', NULL, FALSE);
		   }
		   } 
			$this->db->order_by('notifications.id','desc');
			$this->db->join('users', 'users.id = notifications.from_user_id', 'left');
			$this->db->join('hotels', 'hotels.hotel_id = notifications.from_user_id', 'left');
            $query = $this->db->get();
            $messages=$query->result_array();
            return $messages;
	}
	public function user_notification_count($user_id)
	{
	 $this->db->select('notifications.id');
	 $this->db->from('notifications');
     $this->db->where('notifications.to_user_id',$user_id);
	 $this->db->where('notifications.is_read','0');   
	 $this->db->where('notifications.to_delete','0');   
	 $query = $this->db->get();
	 $messages=$query->num_rows();
	 return $messages;
	}
	public function get_user_note_detail($user_id,$id)
	{
	       $this->db->select('notifications.id,notifications.created,
			notifications.message,notifications.is_read,
			users.display_name,
			users.profile_image,users.image_dir,hotels.name as hotel_name');
            $this->db->from('notifications');
            $this->db->where('notifications.to_user_id',$user_id);
			$this->db->where('notifications.id',$id);
			$this->db->where('notifications.is_active','1');
			$this->db->where('notifications.to_delete','0');
			$this->db->order_by('notifications.id','desc');
			$this->db->join('users', 'users.id = notifications.from_user_id', 'left');
			$this->db->join('hotels', 'hotels.hotel_id = notifications.from_user_id', 'left');
            $query = $this->db->get();
            $messages=$query->row_array();
            return $messages;
	}
	public function get_auctions_count($user_id)
	{
	 $this->db->select('bids.id');
	 $this->db->from('bids');
     $this->db->where('bids.user_id',$user_id);
	 $query = $this->db->get();
	 $counts=$query->num_rows();
	 return $counts;
	}
	public function order_cancel($order_id,$user_id,$offer_type_id)
	{
	 $status=0;
	 $this->db->select('orders.created,orders.id,orders.offer_id,
	 orders.user_id,orders.amount,offers.hotel_id');
	 $this->db->from('orders');
	 $this->db->where('orders.id',$order_id);
	  $this->db->where('orders.user_id',$this->session->userdata('user_id'));
	 $this->db->join('offers', 'offers.id = orders.offer_id', 'left');
	 $query = $this->db->get();
	 $orders=$query->row_array();
	 if(!empty($orders))
	 {
	      $order_datas = array(
				'order_status' => '2'
		  );
	      $this->db->where('id', $order_id);
		  $this->db->update('orders', $order_datas);
		  $offer_datas = array(
				'booking_status' => '0'
		  );
	      $this->db->where('id', $orders['offer_id']);
		  $this->db->update('offers', $offer_datas);
		  $cron_data = array(
				'offer_id'	=>  $orders['offer_id'],
				'hotel_id'	=> '1',
				'notification_type'=> 3,
			);
		 $this->db->insert('cron_datas', $cron_data);
	      $status=1;
		  if($offer_type_id==3)
		  {
			  $bid_datas = array(
					'bid_status' => '5'
			  );
			  $this->db->where('offer_id', $orders['offer_id']);
			  $this->db->where('user_id', $user_id);
			  $this->db->update('bids', $bid_datas);
		  }
	   cancel_order_report($orders['created'],$orders['hotel_id'],$orders['amount']);
	   $status=1;
	 }
	 return $status;
	}
	 public function get_user_orders($flag , $conditions = array(), $sort_field=null, $order_type='Asc', $limit_start, $limit_end) {
		 $this->db->select('orders.id,orders.created,
		orders.amount,orders.unique_id,orders.transaction_id,
		orders.order_type,orders.order_status,orders.is_active,
		user_profiles.first_name,offers.offer_name,users.email,
		user_profiles.mobile_number,user_profiles.telephone_number,
		user_profiles.address,users.image_dir,users.profile_image,hotels.name as hotel_name');
		$this->db->from('orders');
		$this->db->join('users', 'users.id = orders.user_id', 'left');
		$this->db->join('offers', 'offers.id = orders.offer_id', 'left');
		$this->db->join('hotels', 'hotels.hotel_id = offers.hotel_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = orders.user_id', 'left');
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
			$this->db->order_by('orders.id', $order_type);
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
	public function get_admin_orders($id)
	{
	    $this->db->select('orders.id,orders.created,
		orders.amount,orders.unique_id,orders.transaction_id,
		orders.order_type,orders.order_status,orders.is_active,
		user_profiles.first_name,offers.offer_name,users.email,
		user_profiles.mobile_number,user_profiles.telephone_number,
		user_profiles.address,users.image_dir,users.profile_image');
		$this->db->from('orders');
		$this->db->where('orders.id',$id);
		$this->db->join('users', 'users.id = orders.user_id', 'left');
		$this->db->join('offers', 'offers.id = orders.offer_id', 'left');
		$this->db->join('user_profiles', 'user_profiles.user_id = orders.user_id', 'left');
		$query = $this->db->get();		
		return $query->row_array(); 
	}
	public function get_hotel_users($flag , $conditions = array(), $sort_field=null, $order_type='Asc', $limit_start, $limit_end) {
		$this->db->select('users.id,users.email,users.is_approved,hotels.name,users.image_dir,users.profile_image,users.created,users.is_active,users.is_email_confirmed');
		$this->db->from('users');
		$this->db->join('hotels', 'users.id = hotels.hotel_id', 'left');
		$this->db->where('users.user_type', '2');
		
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
			$this->db->order_by('users.id', $order_type);
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
	public function user_type_check($fb_id=null,$fb_email=null,$user_type=null,$fun=null) {
		$this->db->select('users.id,users.email,users.facebook_user_id,users.is_active,users.user_type');
		$this->db->from('users');
		if(!empty($fb_email)) {
			$this->db->where('users.email',$fb_email);
		} else if(!empty($fb_id) && $user_type=="2") {
			$this->db->where('users.facebook_user_id',$fb_id);
		} else if(!empty($fb_id) && $user_type=="3") {
			$this->db->where('users.google_auth_id',$fb_id);
		}
		
		if($fun=='authorize') {
			$this->db->where('users.register_type',$user_type);
		} else {
			$this->db->where('users.register_type !=',$user_type);
		}
		$query = $this->db->get();
		if($fun=='authorize') {	  
			return $query->row_array();
		} else {
			return $query->num_rows(); 
		}
	}
	public function save_filter($user_id,$filter_data){
		$this->load->library('user_agent');
		$data = array(
			'created'		=> date('Y-m-d h:i:s'),
			'modified' 		=> date('Y-m-d h:i:s'),
			'user_id'		=> $user_id,
			'keyword'		=> @serialize($filter_data),
			'ip'			=> $this->input->ip_address(),
			'browser_info'	=> $this->agent->agent_string(),
			'is_deleted'	=> '0'
		);
		$this->db->insert('save_filter', $data);
		return true;
	}
	
	public function delete_filter($user_id,$id){
		$this->db->where('user_id', $user_id);
		$this->db->where('id', $id);
		$this->db->delete('save_filter');
		return true;
	}
}
?>