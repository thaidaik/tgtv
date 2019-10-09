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
        $location_link = $this->input->post('location_link');
        $search_string = $this->input->post('search_string');
        $sizes_selected = $this->input->post('group_size');
        $month_selected = $this->input->post('start_month');
        $year_selected = $this->input->post('start_year');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 10;

        $config['base_url'] = base_url().'tour/info';
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

        $data_field_tour_location = $this->tour_location_model->get_data_field_tour_location();
        foreach ($data_field_tour_location as $value){
            $field_tour_location[$value['id']] = $value['country'];
        }

        //filtered && || paginated

        if($search_string !== false && $order !== false || $this->uri->segment(3) == true){

            if($location_link !== 0){
                $filter_session_data['location_link_selected'] = $location_link;
            }else{
                $location_link = $this->session->userdata('location_link_selected');
            }
            $data['location_link_selected'] = $location_link;

            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($month_selected){
                $filter_session_data['month_selected'] = $month_selected;
            }else{
                $month_selected = $this->session->userdata('month_selected');
            }
            $data['month_selected'] = $month_selected;

            if($year_selected){
                $filter_session_data['year_selected'] = $year_selected;
            }else{
                $year_selected = $this->session->userdata('year_selected');
            }
            $data['year_selected'] = $year_selected;

            if($sizes_selected){
                $filter_session_data['sizes_selected'] = $sizes_selected;
            }else{
                $sizes_selected = $this->session->userdata('sizes_selected');
            }
            $data['sizes_selected'] = $sizes_selected;

            if($order){
                $filter_session_data['order'] = $order;
            }else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);

            //fetch manufacturers data into arrays
            $data['field_tour_location'] = $field_tour_location;

            $data['count_tour_infos']= $this->tour_info_model->count_tour_infos($month_selected, $year_selected, $sizes_selected, $location_link, $search_string, $order);
            $config['total_rows'] = $data['count_tour_infos'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['tour_infos'] = $this->tour_info_model->get_tour_infos($month_selected,  $year_selected, $sizes_selected, $location_link, $search_string, $order, $order_type, $config['per_page'],$limit_end);
                }else{
                    $data['tour_infos'] = $this->tour_info_model->get_tour_infos($month_selected,  $year_selected, $sizes_selected, $location_link, $search_string, '', $order_type, $config['per_page'],$limit_end);
                }
            }else{
                if($order){
                    $data['tour_infos'] = $this->tour_info_model->get_tour_infos($month_selected,  $year_selected, $sizes_selected, $location_link, '', $order, $order_type, $config['per_page'],$limit_end);
                }else{
                    $data['tour_infos'] = $this->tour_info_model->get_tour_infos($month_selected,  $year_selected, $sizes_selected, $location_link, '', '', $order_type, $config['per_page'],$limit_end);
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['location_link_selected'] = null;
            $filter_session_data['month_selected'] = null;
            $filter_session_data['year_selected'] = null;
            $filter_session_data['sizes_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['location_link_selected'] = array();
            $data['order'] = 'id';
            $data['sizes_selected'] = $data['month_selected'] = $data['year_selected'] = 'all';

            //fetch sql data into arrays
            $data['field_tour_location'] = $field_tour_location;
            $data['count_tour_infos']= $this->tour_info_model->count_tour_infos();
            $data['tour_infos'] = $this->tour_info_model->get_tour_infos('', '', '', '', '', '', $order_type, $config['per_page'],$limit_end);
            $config['total_rows'] = $data['count_tour_infos'];

        }//!isset($location_link) && !isset($search_string) && !isset($order)

        //initializate the panination helper
        $this->pagination->initialize($config);

        $this->load->database();
        $data['data'] = $this->db->get("products")->result();
        //load the view
        $data['main_content'] = 'tour/info/list';
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
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');

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
                    'guest_s_pay' => $this->input->post('guest_s_pay'),
                    'guest_s_pay_data' => $this->input->post('guest_s_pay_data'),
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
            $this->form_validation->set_rules('tour_code', 'tour_code', 'required');
            $this->form_validation->set_rules('tour_name', 'tour_name', 'required');
            $this->form_validation->set_rules('tour_price', 'tour_price', 'required|numeric');
            $this->form_validation->set_rules('tour_duration', 'tour_duration', 'required|numeric');
            $this->form_validation->set_rules('location_link', 'location_link', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $startdate = date("Y-m-d", strtotime($this->input->post('start_date')));
                $location_link = $this->input->post('location_link');
                $data_to_tour = array(
                    'tour_code' => $this->input->post('tour_code'),
                    'tour_name' => $this->input->post('tour_name'),
                    'tour_price' => $this->input->post('tour_price'),
                    'tour_price_min' => $this->input->post('tour_price_min'),
                    'tour_duration' => $this->input->post('tour_duration'),
                    'start_date' => $startdate,
                    'tour_gift' => $this->input->post('tour_gift'),
                    'group_size' => $this->input->post('group_size'),
                    'tour_description' => $this->input->post('tour_description'),
                    'tour_guide_info' => $this->input->post('tour_guide_info'),
                    'tour_color' => $this->input->post('tour_color'),
                    'modify_date' => date('Y-m-d H:i:s'),
                    'modify_by' => $this->session->userdata('user_id'),
                );
                $dataImage = uploadImage('tour_image');
                $dataImageName = $dataImage['uploadInfo'];
                if(!empty($dataImage)){
                    $data_to_tour['tour_image'] = $dataImageName['file_name'];
                    $data_to_tour['tour_image_thumb'] = $dataImage['thumbnail_name'];
                }
                //if the insert has returned true then we show the flash message
                if($this->tour_info_model->update_tour_info($id, $data_to_tour, $location_link) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                redirect('tour/info/update/'.$id.'');

            }//validation run

        }

        $data_field_tour_location = $this->tour_location_model->get_data_field_tour_location();
        foreach ($data_field_tour_location as $value){
            $field_tour_location[$value['id']] = $value['country'];
        }
        $data['field_tour_location'] = $field_tour_location;
        $data['tour_info_data'] = $this->tour_info_model->get_tour_info_by_id($id);
        $data['tour_location_link'] = $this->tour_info_model->get_tour_location_link_by_tour_info_id($id);
        //load the view
        $data['main_content'] = 'tour/info/edit';
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