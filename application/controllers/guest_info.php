<?php
class Guest_info extends CI_Controller {

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('guest_info_model');
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
        $search_phone = $this->input->post('search_phone');
        $search_code = $this->input->post('search_code');
        $start_month = $this->input->post('start_month');
        $start_day = $this->input->post('start_day');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');
        $filter_session_data = array();
        //pagination settings
        $config['per_page'] = 10;

        $config['base_url'] = base_url().'guest/info';
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

        if($search_string !== false || $search_phone !== false || $search_code !== false || $start_month !== false || $start_day !== false || $this->uri->segment(3) == true){
            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($search_phone){
                $filter_session_data['search_phone_selected'] = $search_phone;
            }else{
                $search_phone = $this->session->userdata('search_phone_selected');
            }
            $data['search_phone_selected'] = $search_phone;

            if($search_code){
                $filter_session_data['search_code_selected'] = $search_code;
            }else{
                $search_code = $this->session->userdata('search_code_selected');
            }
            $data['search_code_selected'] = $search_code;

            if($start_month){
                $filter_session_data['month_selected'] = $start_month;
            }else{
                $start_month = $this->session->userdata('month_selected');
            }
            $data['month_selected'] = $start_month;

            if($start_day){
                $filter_session_data['day_selected'] = $start_day;
            }else{
                $start_day = $this->session->userdata('day_selected');
            }
            $data['day_selected'] = $start_day;



            if($order){
                $filter_session_data['order'] = $order;
            }else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);


            $data['count_tour_infos']= $this->guest_info_model->count_guest_infos($search_string, $search_phone, $search_code,  $start_month,  $start_day, $order);
            $config['total_rows'] = $data['count_tour_infos'];

            //fetch sql data into arrays
            if($search_string || $search_phone || $search_code || $start_month || $start_day ){
                $data['tour_infos'] = $this->guest_info_model->get_guest_infos($search_string, $search_phone, $search_code,  $start_month,  $start_day, '', $order_type, $config['per_page'],$limit_end);
            }else{
                $data['tour_infos'] = $this->guest_info_model->get_guest_infos('', '', '', '', '', '', $order_type, $config['per_page'],$limit_end);
            }

        }else{

            //clean filter data inside section
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['search_phone_selected'] = null;
            $filter_session_data['month_selected'] = null;
            $filter_session_data['day_selected'] = null;
            $filter_session_data['search_code_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['search_phone_selected'] = '';
            $data['search_code_selected'] = '';
            $data['month_selected'] = $data['day_selected'] =  'all';
            $data['order'] = 'id';

            $data['count_tour_infos']= $this->guest_info_model->count_guest_infos();
            $data['tour_infos'] = $this->guest_info_model->get_guest_infos('', '', '', '', '', '', $order_type, $config['per_page'],$limit_end);
            $config['total_rows'] = $data['count_tour_infos'];

        }//!isset($location_link) && !isset($search_string) && !isset($order)

        //initializate the panination helper
        $this->pagination->initialize($config);

        $this->load->database();
        $data['data'] = $this->db->get("products")->result();
        //load the view
        $data['main_content'] = 'guest/info/list';
        $this->load->view('includes/template', $data);

    }//index


    public function add()
    {
        $this->load->helper('upload_helper');
        $this->load->helper('true_function');
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('guest_phone', 'guest_phone', 'required');
            $this->form_validation->set_rules('guest_name', 'guest_name', 'required');
            $this->form_validation->set_rules('guest_cmnd', 'guest_cmnd', 'required|numeric');
            $this->form_validation->set_rules('guest_passport', 'guest_passport', 'required|numeric');
            $this->form_validation->set_rules('guest_address', 'guest_address', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $dataImage = uploadImage('tour_image');
                $error_upload = '';
                if(isset($dataImage['uploadInfo']) && $dataImage['uploadInfo'] != null){
                    $dataImageName = $dataImage['uploadInfo'];
                    $guest_images = $dataImageName['file_name'];
                    $guest_thumb = $dataImage['thumbnail_name'];
                }else{
                    $guest_images = 'tgtv.jpg';
                    $guest_thumb = 'tgtv_thumb.jpg';
                    $error_upload = $dataImage;
                }
                $birthday = date("Y-m-d", strtotime($this->input->post('guest_birthday')));
                $guest_code = initials($this->input->post('guest_name')).'_'.randomPassword();
                $data_to_store = array(
                    'guest_code' => $guest_code,
                    'guest_s_type' => $this->input->post('guest_s_type'),
                    'guest_s_visa' => $this->input->post('guest_s_visa'),
                    'guest_s_group' => $this->input->post('guest_s_group'),
                    'guest_name' => $this->input->post('guest_name'),
                    'guest_sex' => $this->input->post('guest_sex'),
                    'guest_address' => $this->input->post('guest_address'),
                    'guest_phone' => $this->input->post('guest_phone'),
                    'guest_email' => $this->input->post('guest_email'),
                    'guest_birthday' => $birthday,
                    'guest_cmnd' => $this->input->post('guest_cmnd'),
                    'guest_passport' => $this->input->post('guest_passport'),
                    'guest_country' => $this->input->post('guest_country'),
                    'guest_power' => $this->input->post('guest_power'),
                    'guest_com_location' => $this->input->post('guest_com_location'),
                    'guest_images' => $guest_images,
                    'guest_thumb' => $guest_thumb,
                    'guest_create_date' => date('Y-m-d H:i:s'),
                    'guest_modify_date' => date('Y-m-d H:i:s'),
                    'guest_modify_by' => $this->session->userdata('user_id'),
                );
                //if the insert has returned true then we show the flash message
                if($this->guest_info_model->add_guest_info($data_to_store)){
                    $data['flash_message'] = TRUE;
                }else{
                    $data['flash_message'] = FALSE;
                }
                $data['error_upload'] = $error_upload;
            }
        }
        $data['main_content'] = 'guest/info/add';
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
        $this->load->helper('upload_helper');
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('guest_phone', 'guest_phone', 'required');
            $this->form_validation->set_rules('guest_name', 'guest_name', 'required');
            $this->form_validation->set_rules('guest_cmnd', 'guest_cmnd', 'required|numeric');
            $this->form_validation->set_rules('guest_passport', 'guest_passport', 'required|numeric');
            $this->form_validation->set_rules('guest_address', 'guest_address', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $birthday = date("Y-m-d", strtotime($this->input->post('guest_birthday')));
                $data_to_tour = array(
                    'guest_s_type' => $this->input->post('guest_s_type'),
                    'guest_s_visa' => $this->input->post('guest_s_visa'),
                    'guest_s_group' => $this->input->post('guest_s_group'),
                    'guest_name' => $this->input->post('guest_name'),
                    'guest_sex' => $this->input->post('guest_sex'),
                    'guest_address' => $this->input->post('guest_address'),
                    'guest_phone' => $this->input->post('guest_phone'),
                    'guest_email' => $this->input->post('guest_email'),
                    'guest_birthday' => $birthday,
                    'guest_cmnd' => $this->input->post('guest_cmnd'),
                    'guest_passport' => $this->input->post('guest_passport'),
                    'guest_country' => $this->input->post('guest_country'),
                    'guest_power' => $this->input->post('guest_power'),
                    'guest_com_location' => $this->input->post('guest_com_location'),
                    'guest_modify_date' => date('Y-m-d H:i:s'),
                    'guest_modify_by' => $this->session->userdata('user_id'),
                );
                $dataImage = uploadImage('tour_image');
                $dataImageName = $dataImage['uploadInfo'];
                if(!empty($dataImage)){
                    $data_to_tour['guest_images'] = $dataImageName['file_name'];
                    $data_to_tour['guest_thumb'] = $dataImage['thumbnail_name'];
                }
                //if the insert has returned true then we show the flash message
                if($this->guest_info_model->update_guest_info($id, $data_to_tour) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('guest/info/update/'.$id.'');

            }//validation run

        }

        $data['guest_info_data'] = $this->guest_info_model->get_guest_info_by_id($id);
        //load the view
        $data['main_content'] = 'guest/info/edit';
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
        $this->products_model->delete_product($id);
        redirect('admin/products');
    }//edit

    public function addInfoTour(){
        $this->load->model('Users_model');
        $this->load->model('tour_info_model');
        $guest_id = substr($this->uri->segment(4),'4'); // cat text gid_ de lay id
        $month_select = $this->uri->segment(5);
        $guest_tour_sale_id = $this->uri->segment(6);
        $all_users_arr = $this->Users_model->get_all_users();
        foreach ($all_users_arr as $value){
            $all_users[$value['id']] = $value['first_name'];
        }
        $data['all_users'] = $all_users;
        if($month_select == 'mnow' || $month_select ==''){
            $month_tour = date('m');
            $year_tour = date('Y');
        }elseif($month_select == 'mnowst'){
            $month_tour = date('m', strtotime('+1 month', strtotime(date("Y-m-01"))));
            $year_tour = date('Y', strtotime('+1 month', strtotime(date("Y-m-01"))));
        }elseif($month_select == 'mnownd'){
            $month_tour = date('m', strtotime('+2 month', strtotime(date("Y-m-01"))));
            $year_tour = date('Y', strtotime('+1 month', strtotime(date("Y-m-01"))));
        }elseif($month_select == 'mnowrd'){
            $month_tour = date('m', strtotime('+3 month', strtotime(date("Y-m-01"))));
            $year_tour = date('Y', strtotime('+1 month', strtotime(date("Y-m-01"))));
        }

        $data['tour_infos'] = $this->tour_info_model->get_tour_infos($month_tour, $year_tour, '', '', '', '', 'Asc', '','');
        $data['guest_info_data'] = $this->guest_info_model->get_guest_info_by_id($guest_id);
        $data_get_sale_and_tour_toguest = $this->guest_info_model->get_sale_and_tour_toguest($guest_id);

        $new_data_get_sale_and_tour_toguest = array();
        foreach ($data_get_sale_and_tour_toguest as $key=>$value){
            $data_payment = array();
            $total_price = $total_finish = $total_number_price = 0;
            $new_guest_info_id = $value['guest_info_id'];
            $new_tour_info_id = $value['tour_info_id'];
            $new_user_sale_id = $value['user_sale_id'];
            $data_payment = $this->guest_info_model->get_payment_toguest_by_id_tour_id($new_guest_info_id, $new_tour_info_id, $new_user_sale_id);

            if($data_payment && count($data_payment)){
                $total_price = $data_payment[0]['total_price'];
                $total_finish = $data_payment[0]['total_finish'];
                $total_number_price = $data_payment[0]['total_number_price'];
            }
            $new_data_get_sale_and_tour_toguest[$key] = $value;
            $new_data_get_sale_and_tour_toguest[$key]['total_number_price'] = $total_number_price;
            $new_data_get_sale_and_tour_toguest[$key]['total_price'] = $total_price;
            $new_data_get_sale_and_tour_toguest[$key]['total_finish'] = $total_finish;
        }
        $data['guest_sale_tour_info_data'] = $new_data_get_sale_and_tour_toguest;

        $id = null;
        if($guest_tour_sale_id){
            $data['get_guest_tour_sale_data'] = $this->guest_info_model->get_guest_tour_sale_data($guest_tour_sale_id);
            $id = $guest_tour_sale_id;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST'){
            //form validation
            $this->form_validation->set_rules('tour_id', 'Select Tour', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run()){
                $sale_id = $this->input->post('sale_id');
                $tour_id = $this->input->post('tour_id');
                $data_to_tour = array(
                    'guest_info_id' => $guest_id,
                    'tour_info_id' => $tour_id,
                    'user_sale_id' => $sale_id,
                );
                //if the insert has returned true then we show the flash message
                if($this->guest_info_model->add_sale_and_tour_toguest($data_to_tour, $guest_id, $tour_id, $id) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('guest/link/tour/gid_'.$guest_id.'/'.$month_select);
            }

        }

        $data['main_content'] = 'guest/update/add_tour';
        $this->load->view('includes/template', $data);
    }

    public function addPayment(){
        $this->load->model('Users_model');
        $this->load->model('tour_info_model');
        $guest_id = substr($this->uri->segment(4),'4'); // cat text gid_ de lay id
        $guest_tour_sale_id = $this->uri->segment(5);
        $payment_id = substr($this->uri->segment(6),'4'); // cat text gid_ de lay id
        $all_users_arr = $this->Users_model->get_all_users();
        foreach ($all_users_arr as $value){
            $all_users[$value['id']] = $value['first_name'];
        }
        $data['all_users'] = $all_users;

        $data['guest_info_data'] = $this->guest_info_model->get_guest_info_by_id($guest_id);
        if($guest_tour_sale_id) {
            $data['get_guest_tour_sale_data'] = $this->guest_info_model->get_guest_tour_sale_data($guest_tour_sale_id);
            $data['get_all_payment_toguest'] = $this->guest_info_model->get_all_payment_toguest($guest_id, $guest_tour_sale_id);
        }
        if($payment_id) {
            $data['get_payment_toguest_by_id'] = $this->guest_info_model->get_payment_toguest_by_id($payment_id);
        }


        if ($this->input->server('REQUEST_METHOD') === 'POST'){
            //form validation
            $this->form_validation->set_rules('guest_pay_price', 'Số tiền thu', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            $guest_pay_time = date("Y-m-d", strtotime($this->input->post('guest_pay_time')));
            //if the form has passed through the validation
            if ($this->form_validation->run()){
                $guest_pay_status = $this->input->post('guest_pay_status');
                $guest_pay_by_user_id = $this->input->post('guest_pay_by_user_id');
                $guest_pay_price = $this->input->post('guest_pay_price');
                $guest_pay_by_type = $this->input->post('guest_pay_by_type');
                $guest_pay_finish = $this->input->post('guest_pay_finish');
                $user_sale_id = $this->input->post('user_sale_id');
                $tour_info_id = $this->input->post('tour_info_id');


                //if the insert has returned true then we show the flash message
                if($payment_id){
                    $data_to_tour = array(
                        'guest_pay_status' => $guest_pay_status,
                        'guest_pay_by_user_id' => $guest_pay_by_user_id,
                        'guest_pay_price' => $guest_pay_price,
                        'guest_pay_time' => $guest_pay_time,
                        'guest_pay_by_type' => $guest_pay_by_type,
                        'guest_pay_finish' => $guest_pay_finish,
                        'modify_date' => date('Y-m-d H:i:s'),
                        'modify_by' => $this->session->userdata('user_id'),
                    );
                    if($this->guest_info_model->update_payment_toguest($payment_id, $data_to_tour) == TRUE){
                        $this->session->set_flashdata('flash_message', 'updated');
                    }else{
                        $this->session->set_flashdata('flash_message', 'not_updated');
                    }
                }else{
                    $data_to_tour = array(
                        'guest_info_id' => $guest_id,
                        'tour_info_id' => $tour_info_id,
                        'user_sale_id' => $user_sale_id,
                        'guest_tour_sale_id' => $guest_tour_sale_id,
                        'guest_pay_status' => $guest_pay_status,
                        'guest_pay_by_user_id' => $guest_pay_by_user_id,
                        'guest_pay_price' => $guest_pay_price,
                        'guest_pay_time' => $guest_pay_time,
                        'guest_pay_by_type' => $guest_pay_by_type,
                        'guest_pay_finish' => $guest_pay_finish,
                        'create_date' => date('Y-m-d H:i:s'),
                        'modify_date' => date('Y-m-d H:i:s'),
                        'modify_by' => $this->session->userdata('user_id'),
                    );
                    if($this->guest_info_model->add_payment_toguest($data_to_tour) == TRUE){
                        $this->session->set_flashdata('flash_message', 'updated');
                    }else{
                        $this->session->set_flashdata('flash_message', 'not_updated');
                    }
                }

                redirect('guest/add/payment/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
            }

        }

        $data['main_content'] = 'guest/update/add_payment';
        $this->load->view('includes/template', $data);
    }

//ajax
    public function ajaxViewTour(){
        $this->load->helper('true_function');
        $id = $this->input->post('id');
        $showdata = '';
        $tour_data_array = $this->tour_info_model->get_tour_info_by_id($id);
        if($tour_data_array && count($tour_data_array)){
            $tour_data = $tour_data_array[0];
        }
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        echo '<div class="row bottom-block"><label>Tour code: </label>'.$tour_data['tour_code'].'</div>';
        echo '<div class="row bottom-block"><label>Tour duration: </label>'.$tour_data['tour_duration'].' days</div>';
        echo '<div class="row bottom-block"><label>Start date: </label>'.convertDateDMY($tour_data['start_date']).'</div>';
        echo '<div class="row bottom-block"><label>Group size: </label>'.$tour_data['group_size'].' persons</div>';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<div class="row bottom-block"><label>Tour price: </label>'.convertMilion($tour_data['tour_price']).'</div>';
        echo '<div class="row bottom-block"><label>Tour price min: </label>'.convertMilion($tour_data['tour_price_min']).'</div>';
        echo '<div class="row bottom-block"><label>Tour gift: </label>'.$tour_data['tour_gift'].'</div>';
        echo '<div class="row bottom-block"><label>Used Slot: </label>'.'xx'.' persons</div>';
        echo '</div>';
        echo '</div>';

        echo '<div class="row bottom-block">';
        echo '<div class="col-md-12"><div class="row"><label>Guide info: </label>'.$tour_data['tour_guide_info'].'</div></div>';
        echo '</div>';
        echo '<div class="row bottom-block">';
        echo '<div class="col-md-12"><strong>Tour description: </strong><br/><br/>'.htmlspecialchars_decode($tour_data['tour_description']).'</div>';
        echo '</div>';
        echo $showdata;
    }

    //test xls create xlsx

//Horizontal alignment styles Can you use : HORIZONTAL_LEFT = 'left', HORIZONTAL_RIGHT = 'right', HORIZONTAL_CENTER  = 'center', HORIZONTAL_CENTER_CONTINUOUS = 'centerContinuous' and HORIZONTAL_JUSTIFY  = 'justify'.
//
//Vertical alignment styles Can you use : VERTICAL_BOTTOM = 'bottom', VERTICAL_TOP = 'top', VERTICAL_CENTER = 'center', VERTICAL_JUSTIFY = 'justify' and HORIZONTAL_GENERAL = 'general'.

    public function createXLS() {
        $this->load->helper('true_function');
        // create file name
        $fileName = 'data-'.time().'.xlsx';
        // load excel library
        $this->load->library('excel');
        $empInfo = $this->tour_info_model->get_tour_infos('', '', '','', '', '', '', '20','');


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        // set Header
        $sheet->SetCellValue('A1', 'TGTV');
        $sheet->mergeCells('A1:AA1');
        $sheet->SetCellValue('A2', 'id');
        $sheet->SetCellValue('B2', 'tour_name');
        $sheet->SetCellValue('C2', 'tour_price');
        $sheet->SetCellValue('D2', 'start_date');
        $sheet->SetCellValue('E2', 'group_size');
        $sheet->SetCellValue('F2', 'tour_code');
        // set Row
        $rowCount = 3;

        foreach ($empInfo as $element) {
            $listID = $rowCount -2;

            $sheet->getRowDimension($rowCount)->setRowHeight(-1);
            $sheet->getStyle('B'. $rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('C'. $rowCount .':F'.$rowCount)->getAlignment()->applyFromArray(
                array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP) // top text
            );

            $sheet->SetCellValue('A' . $rowCount, $listID);
            $sheet->SetCellValue('B' . $rowCount, $element['tour_name']);
            $sheet->SetCellValue('C' . $rowCount, $element['tour_price']);
            $sheet->SetCellValue('D' . $rowCount, convertDateDMY($element['start_date']));
            $sheet->SetCellValue('E' . $rowCount, $element['group_size']);
            $sheet->SetCellValue('F' . $rowCount, $element['tour_code']);
            $rowCount++;
        }
//        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getColumnDimension('B')->setWidth(70);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2:F2")->getFont()->setBold(true);
        $sheet->getStyle("A2:F2")->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'F48024' //mau background
            ),
        ));

        $sheet->getStyle("A2:F2")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                    'color' => array('rgb' => 'FFFFFF') // mau border
                )
            )
        ));




        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/doc/'.$fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect('uploads/doc/'.$fileName);
    }


}