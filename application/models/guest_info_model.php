<?php
/**
 * Created by PhpStorm.
 * User: thaind
 * Date: 8/10/2019
 * Time: 3:02 PM
 */

class Guest_info_model extends CI_Model {

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
    public function get_guest_info_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('guest_info');
        $this->db->where('guest_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch products data from the database
     * possibility to mix search, filter and order
     * @param int $manufacuture_id
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_guest_infos($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end)
    {
        $this->db->select('*');
        $this->db->from('guest_info');

        if($search_string){
            $this->db->like('guest_name', $search_string);
        }

        $this->db->group_by('guest_id');

        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('guest_id', $order_type);
        }

        if($limit_start){
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $manufacture_id
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_guest_infos($search_string=null, $order=null)
    {
        $this->db->select('*');
        $this->db->from('guest_info');

        if($search_string){
            $this->db->like('guest_name', $search_string);
        }

        $this->db->group_by('guest_id');

        if($order){
            $this->db->order_by($order, 'Asc');
        }else{
            $this->db->order_by('guest_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function add_payment_toguest($data)
    {
        $insert = $this->db->insert('guest_pay', $data);
        return $insert;
    }
    function update_payment_toguest($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('guest_pay', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if($report !== 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_payment_toguest_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('guest_pay');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_payment_toguest_by_id_tour_id($guest_info_id, $tour_info_id, $user_sale_id)
    {
        $this->db->select('id, guest_info_id, tour_info_id, user_sale_id , SUM(guest_pay_price) as total_price, SUM(guest_pay_finish) as total_finish, COUNT(id) as total_number_price');
        $this->db->from('guest_pay');
        $this->db->where('guest_info_id', $guest_info_id);
        $this->db->where('tour_info_id', $tour_info_id);
        $this->db->where('user_sale_id', $user_sale_id);
        $this->db->group_by('guest_info_id, tour_info_id, user_sale_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_payment_toguest($guest_id, $guest_tour_sale_id)
    {
        $this->db->select('*');
        $this->db->from('guest_pay');

        $this->db->where('guest_info_id', $guest_id);
        $this->db->where('guest_tour_sale_id', $guest_tour_sale_id);

        $this->db->group_by('id');
        $query = $this->db->get();

        return $query->result_array();
    }

    function add_guest_info($data)
    {
        $insert = $this->db->insert('guest_info', $data);
        return $insert;
    }

    /**
     * Update product
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_guest_info($id, $data)
    {
        $this->db->where('guest_id', $id);
        $this->db->update('guest_info', $data);
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
     * Delete product
     * @param int $id - product id
     * @return boolean
     */
    function delete_guest_info($id){
        $this->db->where('id', $id);
        $this->db->delete('tour_info');
    }

    function add_sale_and_tour_toguest($data, $id=null)
    {
        if($id){
            $this->db->where('id', $id);
            $this->db->delete('guest_tour_link');
        }
        $insert = $this->db->insert('guest_tour_link', $data);
        return $insert;
    }

    function get_sale_and_tour_toguest($guestid)
    {
        $this->db->select('guest_tour_link.id as guest_tour_link_id, guest_tour_link.guest_info_id as guest_info_id, guest_tour_link.tour_info_id as tour_info_id, guest_tour_link.user_sale_id as user_sale_id, guest_info.guest_name as guest_name, membership.id as user_id, membership.first_name as user_name, tour_info.tour_id as tour_id, tour_info.tour_name as tour_name, tour_info.start_date as start_date, tour_info.tour_price as tour_price');
        $this->db->from('guest_tour_link');
        $this->db->join('membership', 'membership.id = guest_tour_link.user_sale_id', 'inner');
        $this->db->join('tour_info', 'tour_info.tour_id = guest_tour_link.tour_info_id', 'inner');
        $this->db->join('guest_info', 'guest_info.guest_id = guest_tour_link.guest_info_id', 'inner');

        $this->db->where('guest_tour_link.guest_info_id', $guestid);
        $this->db->group_by('guest_tour_link.id');

        $query = $this->db->get();
        return $query->result_array();
    }

    function get_guest_tour_sale_data($id)
    {
        $this->db->select('guest_tour_link.id as guest_tour_link_id, guest_info.guest_name as guest_name, membership.id as user_id, membership.first_name as user_name, tour_info.tour_id as tour_id, tour_info.tour_name as tour_name, tour_info.start_date as start_date');
        $this->db->from('guest_tour_link');
        $this->db->join('membership', 'membership.id = guest_tour_link.user_sale_id', 'inner');
        $this->db->join('tour_info', 'tour_info.tour_id = guest_tour_link.tour_info_id', 'inner');
        $this->db->join('guest_info', 'guest_info.guest_id = guest_tour_link.guest_info_id', 'inner');

        $this->db->where('guest_tour_link.id', $id);
        $this->db->group_by('guest_tour_link.id');

        $query = $this->db->get();
        return $query->result_array();
    }

}
?>
