<?php
class Tour_info_model extends CI_Model {

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
    public function get_tour_info_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tour_info');
        $this->db->where('tour_id', $id);
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
    public function get_tour_infos($location_link=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {

        $this->db->select('tour_info.*');
        $this->db->from('tour_info');
        if($location_link != null && $location_link != 0){
            $this->db->where('location_link', $location_link);
        }
        if($search_string){
            $this->db->like('tour_name', $search_string);
        }

        $this->db->join('tour_location_link', 'tour_info.tour_id = tour_location_link.tour_info_id', 'inner');

        $this->db->group_by('tour_info.tour_id');

        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('tour_id', $order_type);
        }


        $this->db->limit($limit_start, $limit_end);
        //$this->db->limit('4', '4');


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
    function count_tour_infos($location_link=null, $search_string=null, $order=null)
    {
        $this->db->select('*');
        $this->db->from('tour_info');
        if($location_link != null && $location_link != 0){
            $this->db->where('location_link', $location_link);
        }
        if($search_string){
            $this->db->like('description', $search_string);
        }
        if($order){
            $this->db->order_by($order, 'Asc');
        }else{
            $this->db->order_by('tour_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function add_tour_info($data, $location_link)
    {
        $insert = $this->db->insert('tour_info', $data);
        $insert_id = $this->db->insert_id();
        foreach ($location_link as $value){
            $data_link= array(
                'tour_info_id' => $insert_id,
                'tour_location_id' => $value
            );
            $this->db->insert('tour_location_link', $data_link);
        }
        return $insert;
    }

    /**
     * Update product
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_tour_info($id, $data, $location_link)
    {
        $this->db->where('tour_id', $id);
        $this->db->update('tour_info', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        $this->reset_tour_location_link($id);
        foreach ($location_link as $value){
            $data_link= array(
                'tour_info_id' => $id,
                'tour_location_id' => $value
            );
            $this->db->insert('tour_location_link', $data_link);
        }
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
    function delete_tour_info($id){
        $this->db->where('id', $id);
        $this->db->delete('tour_info');
    }

    function reset_tour_location_link($id){
        $this->db->where('tour_info_id', $id);
        $this->db->delete('tour_location_link');
    }

    function get_tour_location_link_by_tour_info_id($id){
        $this->db->select('*');
        $this->db->from('tour_location_link');
        $this->db->where('tour_info_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

}
?>
