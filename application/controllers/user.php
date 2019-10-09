<?php

class User extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('Users_model');
        $this->load->model('manufacturers_model');
    }

    /**
    * Check if the user is logged in, if he's not, 
    * send him to the login page
    * @return void
    */	
	function index()
	{
		if($this->session->userdata('is_logged_in')){
            //all the posts sent by the view
            $search_string = $this->input->post('search_string');
            $role_id = $this->input->post('role_id');
            $order = $this->input->post('order');
            $order_type = $this->input->post('order_type');

            //pagination settings
            $config['per_page'] = 10;
            $config['base_url'] = base_url().'admin/list';
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 10;
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';

            $config['first_tag_open']   = '<li>';
            $config['first_tag_close']  = '</li>';
            $config['last_tag_open']    = '<li>';
            $config['last_tag_close']   = '</li>';
            $config['next_tag_open']    = '<li>';
            $config['next_tag_close']   = '</li>';
            $config['prev_tag_open']    = '<li>';
            $config['prev_tag_close']   = '</li>';

            //limit end
            $page = $this->uri->segment(3);

            //math to get the initial record to be select in the database
            $limit_end = ($page * $config['per_page']) - $config['per_page'];
            if ($limit_end < 0){
                $limit_end = 0;
            }

            //if order type was changed
            if($order_type){
                $filter_session_data['order_type'] = $order_type;
            }
            else{
                //we have something stored in the session?
                if($this->session->userdata('order_type')){
                    $order_type = $this->session->userdata('order_type');
                }else{
                    //if we have nothing inside session, so it's the default "Asc"
                    $order_type = 'Asc';
                }
            }
            //make the data type var avaible to our view
            $data['order_type_selected'] = $order_type;

            //filtered && || paginated
            if($role_id !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){

                /*
                The comments here are the same for line 79 until 99

                if post is not null, we store it in session data array
                if is null, we use the session data already stored
                we save order into the the var to load the view with the param already selected
                */

                if($role_id !== 0){
                    $filter_session_data['role_id_selected'] = $role_id;
                }else{
                    $role_id = $this->session->userdata('role_id_selected');
                }
                $data['role_id_selected'] = $role_id;

                if($search_string){
                    $filter_session_data['search_string_selected'] = $search_string;
                }else{
                    $search_string = $this->session->userdata('search_string_selected');
                }
                $data['search_string_selected'] = $search_string;

                if($order){
                    $filter_session_data['order'] = $order;
                }
                else{
                    $order = $this->session->userdata('order');
                }
                $data['order'] = $order;

                //save session data into the session
                $this->session->set_userdata($filter_session_data);

                //fetch manufacturers data into arrays
                $data['roles'] = $this->manufacturers_model->get_manufacturers();

                $data['count_users']= $this->Users_model->count_users($role_id, $search_string, $order);
                $config['total_rows'] = $data['count_users'];

                //fetch sql data into arrays
                if($search_string){
                    if($order){
                        $data['users'] = $this->Users_model->get_users($role_id, $search_string, $order, $order_type, $config['per_page'],$limit_end);
                    }else{
                        $data['users'] = $this->Users_model->get_users($role_id, $search_string, '', $order_type, $config['per_page'],$limit_end);
                    }
                }else{
                    if($order){
                        $data['users'] = $this->Users_model->get_users($role_id, '', $order, $order_type, $config['per_page'],$limit_end);
                    }else{
                        $data['users'] = $this->Users_model->get_users($role_id, '', '', $order_type, $config['per_page'],$limit_end);
                    }
                }

            }else{

                //clean filter data inside section
                $filter_session_data['search_string_selected'] = null;
                $filter_session_data['role_id_selected'] = null;
                $filter_session_data['order'] = null;
                $filter_session_data['order_type'] = null;
                $this->session->set_userdata($filter_session_data);

                //pre selected options
                $data['search_string_selected'] = '';
                $data['role_id_selected'] = '';
                $data['order'] = 'id';

                //fetch sql data into arrays
                $data['count_users']= $this->Users_model->count_users();
                $data['users'] = $this->Users_model->get_users('', '', '', $order_type, $config['per_page'],$limit_end);
                $config['total_rows'] = $data['count_users'];
                $data['roles'] = $this->manufacturers_model->get_manufacturers();
            }

            //initializate the panination helper
            $this->pagination->initialize($config);

            //load the view

            $data['main_content'] = 'admin/member_list';
            $this->load->view('includes/template', $data);

        }else{
            $this->load->view('admin/login');
        }

	}

    /**
    * encript the password 
    * @return mixed
    */	
    function __encrip_password($password) {
        return md5($password);
    }	

    /**
    * check the username and the password with the database
    * @return void
    */
	function validate_credentials()
	{
		$user_name = $this->input->post('user_name');
		$password = $this->__encrip_password($this->input->post('password'));
		$is_valid = $this->Users_model->validate($user_name, $password);
		if($is_valid)
		{
			$data = array(
				'user_name' => $user_name,
				'user_id' => $is_valid,
				'is_logged_in' => true,
			);
			$this->session->set_userdata($data);
			redirect('admin/list');
		}
		else // incorrect username or password
		{
			$data['message_error'] = TRUE;
			$this->load->view('admin/login', $data);	
		}
	}	

    /**
    * The method just loads the signup view
    * @return void
    */
	function signup()
	{
        $data['roles'] = $this->manufacturers_model->get_manufacturers();
        $data['main_content'] = 'admin/signup_form';
        $this->load->view('includes/template', $data);
    }

    function uploadImage()
    {
        $config['upload_path']   =   "uploads/";
        $config['allowed_types'] =   "gif|jpg|jpeg|png";
        $config['max_size']      =   "5000";
        $config['max_width']     =   "1907";
        $config['max_height']    =   "1280";
        $this->load->library('upload',$config);
        if(!$this->upload->do_upload('image'))
        {
            echo $this->upload->display_errors();
        }
        else
        {
            $finfo=$this->upload->data();
            $this->_createThumbnail($finfo['file_name']);
            $data['uploadInfo'] = $finfo;
            $data['thumbnail_name'] = $finfo['raw_name']. '_thumb' .$finfo['file_ext'];
            return $data;
        }
    }

    function _createThumbnail($filename)
    {
        $config['image_library']    = "gd2";
        $config['source_image']     = "uploads/" .$filename;
        $config['create_thumb']     = TRUE;
        $config['maintain_ratio']   = TRUE;
        $config['width'] = "80";
        $config['height'] = "80";
        $this->load->library('image_lib',$config);
        if(!$this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
        }
    }

    /**
    * Create new user and store it in the database
    * @return void
    */	
	function create_member()
	{
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
		
		if($this->form_validation->run() == FALSE)
		{
            $data['roles'] = $this->manufacturers_model->get_manufacturers();
            $data['main_content'] = 'admin/signup_form';
		}
		
		else
		{
			$dataImage = $this->uploadImage();
			$dataImageName = $dataImage['uploadInfo'];

			if($query = $this->Users_model->create_member($dataImageName['file_name'], $dataImage['thumbnail_name']))
			{
                $data['main_content'] = 'admin/signup_successful';
			}
			else
			{
                $data['roles'] = $this->manufacturers_model->get_manufacturers();
                $data['main_content'] = 'admin/signup_form';
			}
		}
        $this->load->view('includes/template', $data);
		
	}

	function edit_member()
	{
        //user id
        $id = $this->uri->segment(3);

		$this->load->library('form_validation');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            // field name, error message, validation rules
            $this->form_validation->set_rules('first_name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('address', 'address', 'trim|required');
            $this->form_validation->set_rules('phone', 'phone', 'trim|required');
            $this->form_validation->set_rules('birthday', 'birthday', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            $newbirthday = date("Y-m-d", strtotime($this->input->post('birthday')));
            if ($this->form_validation->run()) {
                $data_to_user = array(
                    'first_name'        => $this->input->post('first_name'),
                    'email_address'     => $this->input->post('email_address'),
                    'user_name'         => $this->input->post('username'),
                    'sex'               => $this->input->post('sex'),
                    'address'           => $this->input->post('address'),
                    'phone'             => $this->input->post('phone'),
                    'birthday'          => $newbirthday,
                    'identificatio_id'  => $this->input->post('identificatio_id'),
                    'passport'          => $this->input->post('passport'),
                    'role'              => $this->input->post('role'),
                    'color'             => $this->input->post('color'),
                    'modify_date'       => date('Y-m-d H:i:s'),
                    'modify_by'         => $this->session->userdata('user_id'),
                );
                //if the insert has returned true then we show the flash message

                $dataImage = $this->uploadImage();
                $dataImageName = $dataImage['uploadInfo'];
                if(!empty($dataImage)){
                    $data_to_user['image'] = $dataImageName['file_name'];
                    $data_to_user['thumb'] = $dataImage['thumbnail_name'];
                }

                if ($this->Users_model->update_user($id, $data_to_user) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('admin/edit_member/' . $id . '');
            }
        }

        //product data
        $data['roles'] = $this->manufacturers_model->get_manufacturers();
        $data['member'] = $this->Users_model->get_user_by_id($id);
        //load the view
        $data['main_content'] = 'admin/member_edit';

        $this->load->view('includes/template', $data);

	}

	/**
    * Destroy the session, and logout the user.
    * @return void
    */		
	function logout()
	{
		$this->session->sess_destroy();
		redirect('admin');
	}

}