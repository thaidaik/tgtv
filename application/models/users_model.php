<?php

class Users_model extends CI_Model {

    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
	function validate($user_name, $password)
	{
        $this->db->select('*');
        $this->db->from('membership');
		$this->db->where('user_name', $user_name);
		$this->db->where('pass_word', $password);
		$query = $this->db->get();
		$row = $query->row_array();
		$dataid = false;
        if (isset($row) && count($row)){
            $id = $row['id'];
            if($id){
                $dataid = $id;
            }
        }

        return $dataid;
	}

    public function get_user_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('membership');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_username($username)
    {
        $this->db->select('*');
        $this->db->from('membership');
        $this->db->where('user_name', $username);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
    * Serialize the session data stored in the database, 
    * store it in a new array and return it to the controller 
    * @return array
    */
	function get_db_session_data()
	{
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array(); /* array to store the user data we fetch */
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		    /* put data in array using username as key */
		    $user['user_name'] = $udata['user_name'];
		    $user['is_logged_in'] = $udata['is_logged_in'];
		}
		return $user;
	}
	
    /**
    * Store the new user's data into the database
    * @return boolean - check the insert
    */	
	function create_member($dataImageName, $dataImageThumb)
	{
        $newbirthday = date("Y-m-d", strtotime($this->input->post('birthday')));
		$this->db->where('user_name', $this->input->post('username'));
		$query = $this->db->get('membership');

        if($query->num_rows > 0){
        	echo '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>';
			  echo "Username already taken";	
			echo '</strong></div>';
		}else{

			$new_member_insert_data = array(
			    'first_name' => $this->input->post('first_name'),
				'email_address' => $this->input->post('email_address'),
                'user_name' => $this->input->post('username'),
                'pass_word' => md5($this->input->post('password')),
				'sex' => $this->input->post('sex'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'birthday' => $newbirthday,
				'identificatio_id' => $this->input->post('identificatio_id'),
				'passport' => $this->input->post('passport'),
				'image' => $dataImageName,
				'thumb' => $dataImageThumb,
				'role' => $this->input->post('role'),
				'color' => $this->input->post('color'),
				'create_date' => date('Y-m-d H:i:s'),
				'modify_date' => date('Y-m-d H:i:s'),
				'modify_by' => $this->session->userdata('user_id'),

			);
			$insert = $this->db->insert('membership', $new_member_insert_data);
		    return $insert;
		}
	      
	}//create_member


    /**
     * Update member
     * @param array $data - associative array with data to member
     * @return boolean
     */
    function update_user($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('membership', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if($report !== 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Delete member
     * @param int $id - member id
     * @return boolean
     */
    function delete_user($id){
        $this->db->where('id', $id);
        $this->db->delete('membership');
    }

    function count_users($role_id=null, $search_string=null, $order=null)
    {
        $this->db->select('*');
        $this->db->from('membership');
        if($role_id != null && $role_id != ''){
            $this->db->where('role', $role_id);
        }
        if($search_string){
            $this->db->like('first_name', $search_string);
        }
        if($order){
            $this->db->order_by($order, 'Asc');
        }else{
            $this->db->order_by('id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_users($role_id=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {

        $this->db->select('*');
        $this->db->from('membership');
        if($role_id != null && $role_id != ''){
            $this->db->where('role', $role_id);
        }
        if($search_string){
            $this->db->like('first_name', $search_string);
        }
        //$this->db->join('manufacturers', 'products.manufacture_id = manufacturers.id', 'left');
        $this->db->group_by('id');
        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('id', $order_type);
        }
        $this->db->limit($limit_start, $limit_end);
        //$this->db->limit('4', '4');

        $query = $this->db->get();
        return $query->result_array();
    }



    public function get_all_users()
    {
        $this->db->select('*');
        $this->db->from('membership');
        $this->db->group_by('id');
        $this->db->order_by('id', 'Asc');
        $query = $this->db->get();
        return $query->result_array();
    }
}

