<?php
/**
 * Created by PhpStorm.
 * User: thaind
 * Date: 2/1/2020
 * Time: 3:26 PM
 */

class Pay_info extends CI_Controller
{

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('guest_info_model');
        $this->load->model('tour_info_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index()
    {
        $tour_id = $this->uri->segment(2);
        $data_tour = $this->tour_info_model->get_tour_info_by_id($tour_id);
        $data['data_tour_name'] = $data_tour[0]['tour_name'];
        $data['data_tour_start_date'] = $data_tour[0]['start_date'];
        $data_get_sale_and_tour_toguest = $this->guest_info_model->get_sale_and_guest_totour($tour_id);

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

        $data['main_content'] = 'payment/list';
        $this->load->view('includes/template', $data);
    }
}