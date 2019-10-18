<?php
class Tour_location extends CI_Controller {

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tour_location_model');

        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index()
    {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 10;

        $config['base_url'] = base_url().'tour/location';
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
        if($search_string !== false && $order !== false || $this->uri->segment(3) == true){
            
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
            if(isset($filter_session_data)){
                $this->session->set_userdata($filter_session_data);
            }

            //fetch sql data into arrays
            $data['count_locations']= $this->tour_location_model->count_tour_location($search_string, $order);
            $config['total_rows'] = $data['count_locations'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['tour_location'] = $this->tour_location_model->get_tour_location($search_string, $order, $order_type, $config['per_page'],$limit_end);
                }else{
                    $data['tour_location'] = $this->tour_location_model->get_tour_location($search_string, '', $order_type, $config['per_page'],$limit_end);
                }
            }else{
                if($order){
                    $data['tour_location'] = $this->tour_location_model->get_tour_location('', $order, $order_type, $config['per_page'],$limit_end);
                }else{
                    $data['tour_location'] = $this->tour_location_model->get_tour_location('', '', $order_type, $config['per_page'],$limit_end);
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['tour_location_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_locations']= $this->tour_location_model->count_tour_location();
            $data['tour_location'] = $this->tour_location_model->get_tour_location('', '', $order_type, $config['per_page'],$limit_end);
            $config['total_rows'] = $data['count_locations'];

        }//!isset($search_string) && !isset($order)

        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'tour/location/list';
        $this->load->view('includes/template', $data);

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_add = array(
                    'country' => $this->input->post('country'),
                    'continent' => $this->input->post('continent'),
                );
                //if the insert has returned true then we show the flash message
                if($this->tour_location_model->add_tour_location($data_to_add)){
                    $data['flash_message'] = TRUE;
                }else{
                    $data['flash_message'] = FALSE;
                }
            }
        }
        //load the view
        $data['main_content'] = 'tour/location/add';
        $this->load->view('includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update()
    {
        //product id
        $id = $this->uri->segment(4);

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {

                $data_to_store = array(
                    'country' => $this->input->post('country'),
                    'continent' => $this->input->post('continent'),
                );
                //if the insert has returned true then we show the flash message
                if($this->tour_location_model->update_tour_location($id, $data_to_store) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('tour/location/update/'.$id.'');

            }//validation run

        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data
        $data['tour_location'] = $this->tour_location_model->get_tour_location_by_id($id);
        //load the view
        $data['main_content'] = 'tour/location/edit';
        $this->load->view('includes/template', $data);

    }//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete()
    {
        //product id
        $id = $this->uri->segment(4);
        $this->tour_location_model->delete_tour_location($id);
        redirect('tour/location');
    }//edit

}